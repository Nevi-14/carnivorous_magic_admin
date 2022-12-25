<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Razorpay\Api\Api;
use function GuzzleHttp\json_encode;
use Redirect;

function encrypt_e($input, $ky) {
    return openssl_encrypt($input, "AES-128-CBC", html_entity_decode($ky), 0, "@@@@&&&&####$$$$");
}

function decrypt_e($crypt, $ky) {
    return openssl_decrypt($crypt, "AES-128-CBC", html_entity_decode($ky), 0, "@@@@&&&&####$$$$");
}

function generateSalt_e($length) {
    $random = "";
    srand((double) microtime() * 1000000);

    $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
    $data .= "0FGH45OP89";

    for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, (random_int(0, 99) % (strlen($data))), 1);
    }

    return $random;
}

function checkString_e($value) {
    if ($value == 'null') {
        $value = '';
    }
    return $value;
}

function getChecksumFromArray($arrayList, $key, $sort = 1) {
    if ($sort != 0) {
        ksort($arrayList);
    }
    $str = getArray2Str($arrayList);
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    return encrypt_e($hashString, $key);
}

function getChecksumFromString($str, $key) {

    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    return encrypt_e($hashString, $key);
}

function verifychecksum_e($arrayList, $key, $checksumvalue) {
    $arrayList = removeCheckSumParam($arrayList);
    ksort($arrayList);
    $str = getArray2StrForVerify($arrayList);
    $paytm_hash = decrypt_e($checksumvalue, $key);
    $salt = substr($paytm_hash, -4);

    $finalString = $str . "|" . $salt;

    $website_hash = hash("sha256", $finalString);
    $website_hash .= $salt;
    if ($website_hash == $paytm_hash) {
        $validFlag = "TRUE";
    } else {
        $validFlag = "FALSE";
    }
    return $validFlag;
}

function verifychecksum_eFromStr($str, $key, $checksumvalue) {
    $paytm_hash = decrypt_e($checksumvalue, $key);
    $salt = substr($paytm_hash, -4);

    $finalString = $str . "|" . $salt;

    $website_hash = hash("sha256", $finalString);
    $website_hash .= $salt;
    if ($website_hash == $paytm_hash) {
        $validFlag = "TRUE";
    } else {
        $validFlag = "FALSE";
    }
    return $validFlag;
}

function getArray2Str($arrayList) {
    $findme = 'REFUND';
    $findmepipe = '|';
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $value) {
        $pos = strpos($value, $findme);
        $pospipe = strpos($value, $findmepipe);
        if ($pos !== false || $pospipe !== false) {
            continue;
        }

        if ($flag) {
            $paramStr .= checkString_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkString_e($value);
        }
    }
    return $paramStr;
}

function getArray2StrForVerify($arrayList) {
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $value) {
        if ($flag) {
            $paramStr .= checkString_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkString_e($value);
        }
    }
    return $paramStr;
}

function removeCheckSumParam($arrayList) {
    if (isset($arrayList["CHECKSUMHASH"])) {
        unset($arrayList["CHECKSUMHASH"]);
    }
    return $arrayList;
}

function getTxnStatus($requestParamList) {
    return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
}

function getTxnStatusNew() {
    return callNewAPI;
}

function initiateTxnRefund($requestParamList) {
    $CHECKSUM = getRefundChecksumFromArray($requestParamList, PAYTM_MERCHANT_KEY, 0);
    $requestParamList["CHECKSUM"] = $CHECKSUM;
    return callAPI(PAYTM_REFUND_URL, $requestParamList);
}

function callAPI($apiURL, $requestParamList) {
    $jsonResponse = "";
    $JsonData = json_encode($requestParamList);
    $postData = urlencode($JsonData);
    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type:  application/json',
        'Content-Length: ' . strlen($postData)
    ));
    $jsonResponse = curl_exec($ch);
    return json_decode($jsonResponse, true);
}

function callNewAPI() {
    return $this->callAPI();
}

function getRefundChecksumFromArray($arrayList, $key, $sort = 1) {
    if ($sort != 0) {
        ksort($arrayList);
    }
    $str = getRefundArray2Str($arrayList);
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    return encrypt_e($hashString, $key);
}

function getRefundArray2Str($arrayList) {
    $findmepipe = '|';
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $value) {
        $pospipe = strpos($value, $findmepipe);
        if ($pospipe !== false) {
            continue;
        }

        if ($flag) {
            $paramStr .= checkString_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkString_e($value);
        }
    }
    return $paramStr;
}

function callRefundAPI($refundApiURL, $requestParamList) {
    $jsonResponse = "";
    $JsonData = json_encode($requestParamList);
    $postData = urlencode($JsonData);
    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_URL, $refundApiURL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = array();
    $headers[] = ' Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $jsonResponse = curl_exec($ch);
    return json_decode($jsonResponse, true);
}

class PaymentController extends Controller {

    public function order_placedp($data, $clearCart = true) {

        $data['order_from'] = '1';

        $response = $this->post('order-process', ['data' => $data, 'place_order' => 1]);

        if (!($response['error'])) {

            if ($clearCart == true) {

                $this->post('cart', ['data' => ['remove_from_cart' => 1, 'user_id' => session()
                                ->get('user') ['user_id']]]);

                session()
                        ->put('discount', '');

                session()
                        ->put('checkout-address', '');
            }

            return ['success' => true, 'message' => $response['message'] ?? msg('order_success'), 'data' => $response];
        } else {

            return ['success' => false, 'message' => $response['message'] ?? msg('order_error')];
        }
    }

    public function add_transactionp($orderId = "", $paymentType = "", $txnId = "", $status = true, $message = "", $amount = 0) {

        $data = ['add_transaction' => 1, 'user_id' => session()->get('user') ['user_id'], 'order_id' => $orderId, 'type' => $paymentType, 'txn_id' => $txnId, 'amount' => $amount, 'status' => ($status ? 'Success' : 'canceled'), 'message' => $message ?? msg('order_success'), 'transaction_date' => date('Y-m-d H:i:s')];

        return $this->post('order-process', ['data' => $data, 'data_param' => '']);
    }

    public function update(Request $request, $id) {

        if (!isLoggedIn()) {
            $id = $request->child_id;
            $cart = session()->get('cart');
            if (isset($cart[$id])) {

                $cart[$id]['quantity'] = $request->qty ?? 1;

                session()->put('cart', $cart); // this code put product of choose in cart
            }
            $cart_session = session()->get('cart');
            $get_session_varient_ids = session()->get('variant_ids', []);
            $varient_ids = implode(',', $get_session_varient_ids);
            $result = $this->post('get-products', ['data' => ['get_variants_offline' => 1, 'variant_ids' => $varient_ids]]);
            $totalcart = count($get_session_varient_ids);
            $settings = $this->post('settings', ['data' => ['all' => true]]);
            $data = $this->getCart_offline();
            if (isset($settings['error']) && !$settings['error']) {
                $settings = $settings['data'];
                $data['title'] = __('msg.cart');
                $total = $data['subtotal'] ?? '0';
                $saved_price = $data['saved_price'] ?? '0';
                $tax_amount = $data['tax_amount'] ?? ' ';
                $shipping = $data['cart']['shipping'] ?? ' ';
                $currency = $settings->currency;
                $min_order_amount = $settings->min_order_amount;
                $items = $data['cart'];

                echo json_encode(array(
                    'totalcart' => $totalcart,
                    'tax_amount' => $tax_amount,
                    'shipping' => $shipping,
                    'total' => $total,
                    'saved_price' => $saved_price,
                    'items' => $items,
                    'currency' => $currency,
                    'min_order_amount' => $min_order_amount,
                    'max_cart_items_count' => $settings->max_cart_items_count,
                    'is_pincode' => session()->has('pincode_no'),
                    'is_local_shipping' => Cache::get('local_shipping'),
                    'pincode_no' => session()->get('pincode_no'),
                    'subtotal_msg' => __('msg.subtotal'),
                    'tax_msg' => __('msg.tax'),
                    'delivery_charge_msg' => __('msg.delivery_charge'),
                    'discount_msg' => __('msg.discount'),
                    'total_msg' => __('msg.total'),
                    'delete_all_msg' => __('msg.delete_all'),
                    'checkout_msg' => __('msg.checkout'),
                    'saved_price_msg' => __('msg.saved_price'),
                    'viewcart' => __('msg.viewcart'),
                    'cart_session' => $cart_session
                ));
            }
        } else {

            $data = ['add_to_cart' => 1, 'user_id' => session()->get('user') ['user_id'], 'product_id' => $request->id, 'product_variant_id' => $request->child_id, 'qty' => $request->qty ?? 1];
            $result = $this->post('cart', ['data' => $data]);
            $settings = $this->post('settings', ['data' => ['all' => true]]);
            if (isset($settings['error']) && !$settings['error']) {
                $settings = $settings['data'];

                $data1 = $this->getCart();

                if ($data1 != NULL) {
                    $totalcart = $data1['cart']['total'];
                    $total = $data1['subtotal'] ?? '0';
                    $saved_price = $data1['saved_price'] ?? '0';
                    $tax_amount = $data1['tax_amount'] ?? ' ';
                    $shipping = $data1['cart']['shipping'] ?? ' ';
                    $currency = $settings->currency;
                    $min_order_amount = $settings->min_order_amount;
                    $items = $data1['cart'];

                    echo json_encode(array(
                        'totalcart' => $totalcart,
                        'result' => $result,
                        'tax_amount' => $tax_amount,
                        'shipping' => $shipping,
                        'total' => $total,
                        'items' => $items,
                        'saved_price' => $saved_price,
                        'currency' => $currency,
                        'min_order_amount' => $min_order_amount,
                        'max_cart_items_count' => $settings->max_cart_items_count,
                        'is_pincode' => session()->has('pincode_no'),
                        'is_local_shipping' => Cache::get('local_shipping'),
                        'pincode_no' => session()->get('pincode_no'),
                        'subtotal_msg' => __('msg.subtotal_update'),
                        'tax_msg' => __('msg.tax_update'),
                        'delivery_charge_msg' => __('msg.delivery_charge_update'),
                        'discount_msg' => __('msg.discount_update'),
                        'total_msg' => __('msg.total_update'),
                        'delete_all_msg' => __('msg.delete_all_update'),
                        'checkout_msg' => __('msg.checkout_update'),
                        'saved_price_msg' => __('msg.saved_price_update'),
                        'continue_shopping' => __('msg.continue_shopping'),
                        'empty_card_img' => asset('images/empty-cart.png '),
                        'you_must_have_to_purchase' => __('msg.you_must_have_to_purchase'),
                        'to_place_order' => __('msg.to_place_order'),
                        'you_can_get_free_delivery_by_shopping_more_than' => __('msg.you_can_get_free_delivery_by_shopping_more_than'),
                        'product' => __('msg.product'),
                        'qty' => __('msg.qty'),
                        'viewcart' => __('msg.viewcart'),
                        'price' => __('msg.price'),
                        'min_amount' => Cache::get('min_amount'),
                        'status' => __('msg.updated_items_to_cart'),
                    ));
                    die;
                }
            } else {
                abort(404);
            }
        }
    }

    public function cart_update(Request $request, $id) {
        if (!isLoggedIn()) {

             $id = $request->child_id;
            $cart = session()->get('cart');
            if (isset($cart[$id])) {

                $cart[$id]['quantity'] = $request->qty ?? 1;

                session()->put('cart', $cart); // this code put product of choose in cart
            }
            $cart_session = session()->get('cart');
            $get_session_varient_ids = session()->get('variant_ids', []);
            $varient_ids = implode(',', $get_session_varient_ids);
            $result = $this->post('get-products', ['data' => ['get_variants_offline' => 1, 'variant_ids' => $varient_ids]]);
            $totalcart = count($get_session_varient_ids);
            $settings = $this->post('settings', ['data' => ['all' => true]]);
            if (isset($settings['error']) && !$settings['error']) {
                $settings = $settings['data'];
            }
            $data = $this->getCart_offline();
             if ($result['error']) {

                return redirect()->back()->with('err', __('msg.updated_items_to_cart'));
            } else {

                return redirect()->back()->with('suc',  __('msg.updated_items_to_cart'));
            }
        } else {

            $data = ['add_to_cart' => 1, 'user_id' => session()->get('user') ['user_id'], 'product_id' => $request->id, 'product_variant_id' => $request->child_id, 'qty' => $request->qty ?? 1];
            $result = $this->post('cart', ['data' => $data]);
            $settings = $this->post('settings', ['data' => ['all' => true]]);
            if (isset($settings['error']) && !$settings['error']) {
                $settings = $settings['data'];
            }

            if ($result['error']) {

                return redirect()->back()->with('err', $result['message']);
            } else {

                return redirect()->back()->with('suc', $result['message']);
            }
        }
    }

    public function remove($id) {

        if (!isLoggedIn()) {
            $cart = session()->get('cart');

            $cart_session = session()->get('cart');
            $get_session_varient_ids = session()->get('variant_ids', []);
            if (($key = array_search($id, $get_session_varient_ids)) !== false) {
                session()->pull('variant_ids.' . $key);
            }

            session()->pull('cart.' . $id);

            $cart_session = session()->get('cart');
            $get_session_varient_ids = session()->get('variant_ids', []);
            $varient_ids = implode(',', $get_session_varient_ids);
            $result = $this->post('get-products', ['data' => ['get_variants_offline' => 1, 'variant_ids' => $varient_ids]]);
            $totalcart = count($get_session_varient_ids);
            $settings = $this->post('settings', ['data' => ['all' => true]]);
            $data = $this->getCart_offline();
            if (isset($settings['error']) && !$settings['error']) {
                $settings = $settings['data'];
                $data['title'] = __('msg.cart');
                $total = $data['subtotal'] ?? '0';
                $saved_price = $data['saved_price'] ?? '0';
                $tax_amount = $data['tax_amount'] ?? ' ';
                $shipping = $data['cart']['shipping'] ?? ' ';
                $currency = $settings->currency;
                $min_order_amount = $settings->min_order_amount;
                $items = $data['cart'];

                echo json_encode(array(
                    'totalcart' => $totalcart,
                    'tax_amount' => $tax_amount,
                    'shipping' => $shipping,
                    'total' => $total,
                    'saved_price' => $saved_price,
                    'items' => $items,
                    'currency' => $currency,
                    'min_order_amount' => $min_order_amount,
                    'max_cart_items_count' => $settings->max_cart_items_count,
                    'is_pincode' => session()->has('pincode_no'),
                    'is_local_shipping' => Cache::get('local_shipping'),
                    'pincode_no' => session()->get('pincode_no'),
                    'subtotal_msg' => __('msg.subtotal'),
                    'tax_msg' => __('msg.tax'),
                    'delivery_charge_msg' => __('msg.delivery_charge'),
                    'discount_msg' => __('msg.discount'),
                    'total_msg' => __('msg.total'),
                    'delete_all_msg' => __('msg.delete_all'),
                    'checkout_msg' => __('msg.checkout'),
                    'saved_price_msg' => __('msg.saved_price'),
                    'viewcart' => __('msg.viewcart'),
                    'cart_session' => $cart_session,
                    'status' => 'Deleted Item to Cart',
                    'get_session_varient_ids' => $get_session_varient_ids,
                ));
            }
        } else {

            $data = ['remove_from_cart' => 1, 'user_id' => session()->get('user')['user_id']];
            $settings = $this->post('settings', ['data' => ['all' => true]]);
            if (isset($settings['error']) && !$settings['error']) {
                $settings = $settings['data'];
            }
            if (intval($id)) {

                $data['product_variant_id'] = $id;
            }
            $result = $this->post('cart', ['data' => $data]);

            $data1 = $this->getCart();

            if ($data1['cart'] != NULL) {
                $totalcart = $data1['cart']['total'];
                $total = $data1['subtotal'] ?? '0';
                $saved_price = $data1['saved_price'] ?? '0';
                $currency = $settings->currency;
                $min_order_amount = $settings->min_order_amount;
                $items = $data1['cart'];

                echo json_encode(array(
                    'totalcart' => $totalcart,
                    'result' => $result,
                    'total' => $total,
                    'items' => $items,
                    'saved_price' => $saved_price,
                    'currency' => $currency,
                    'min_order_amount' => $min_order_amount,
                    'max_cart_items_count' => $settings->max_cart_items_count,
                    'subtotal_msg' => __('msg.subtotal_remove'),
                    'tax_msg' => __('msg.tax_remove'),
                    'delivery_charge_msg' => __('msg.delivery_charge_remove'),
                    'discount_msg' => __('msg.discount_remove'),
                    'total_msg' => __('msg.total_remove'),
                    'delete_all_msg' => __('msg.delete_all_remove'),
                    'checkout_msg' => __('msg.checkout_remove'),
                    'is_pincode' => session()->has('pincode_no'),
                    'is_local_shipping' => Cache::get('local_shipping'),
                    'pincode_no' => session()->get('pincode_no'),
                    'saved_price_msg' => __('msg.saved_price_remove'),
                    'continue_shopping' => __('msg.continue_shopping '),
                    'empty_card_img' => asset('images/empty-cart.png'),
                    'you_must_have_to_purchase' => __('msg.you_must_have_to_purchase'),
                    'to_place_order' => __('msg.to_place_order'),
                    'you_can_get_free_delivery_by_shopping_more_than' => __('msg.you_can_get_free_delivery_by_shopping_more_than'),
                    'product' => __('msg.product'),
                    'qty' => __('msg.qty'),
                    'price' => __('msg.price'),
                    'viewcart' => __('msg.viewcart'),
                    'min_amount' => Cache::get('min_amount'),
                    'status' => __('msg.deleted_items_to_cart')
                ));
                die;
            } else {
                $totalcart = 0;
                echo json_encode(array(
                    'totalcart' => $totalcart,
                    'continue_shopping' => __('msg.continue_shopping'),
                    'empty_card_img' => asset('images/empty-cart.png'),
                    'status' =>  __('msg.deleted_items_to_cart')
                ));
                die;
            }
        }
    }

    public function cart_remove($id) {

        if (!isLoggedIn()) {
            $cart = session()->get('cart');
            $cart_session = session()->get('cart');
            $get_session_varient_ids = session()->get('variant_ids', []);
            if (($key = array_search($id, $get_session_varient_ids)) !== false) {
                session()->pull('variant_ids.' . $key);
            }

            session()->pull('cart.' . $id);

            $cart_session = session()->get('cart');
            $get_session_varient_ids = session()->get('variant_ids', []);
            $varient_ids = implode(',', $get_session_varient_ids);
            if(!empty($varient_ids)){
            $result = $this->post('get-products', ['data' => ['get_variants_offline' => 1, 'variant_ids' => $varient_ids]]);
            }
            $totalcart = count($get_session_varient_ids);
            $settings = $this->post('settings', ['data' => ['all' => true]]);
            $data = $this->getCart_offline();
            if (isset($result['error']) && $result['error']) {

                return redirect()->back()->with('err', $result['message']);
            } else {

                return redirect()->back()->with('suc',  __('msg.deleted_items_to_cart'));
            }
        } else {

            $data = ['remove_from_cart' => 1, 'user_id' => session()->get('user')['user_id']];
            $settings = $this->post('settings', ['data' => ['all' => true]]);
            if (isset($settings['error']) && !$settings['error']) {
                $settings = $settings['data'];
            }
            if (intval($id)) {

                $data['product_variant_id'] = $id;
            }

            $result = $this->post('cart', ['data' => $data]);

            if ($result['error']) {

                return redirect()->back()->with('err', $result['message']);
            } else {

                return redirect()->back()->with('suc', $result['message']);
            }
        }
    }

    public function calcp() {

        $arr = session('cart');

        $total = 0;

        $shipping = 0;

        $discount = 0;

        $tax_amount = 0;

        if (is_array($arr) && count($arr)) {

            var_dump($arr);
            die();

            foreach ($arr as $a) {

                if (isset($a['varient']->discounted_price) && isset($a['quantity']) && intval($a['quantity'])) {

                    $total += $a['variant']->discounted_price * $a['quantity'];
                }
            }
        }

        if (Cache::has('delivery_charge')) {

            $shipping = floatval(Cache::get('delivery_charge'));
        }

        if (Cache::get('tax') && floatval(Cache::get('tax')) > 0) {

            $tax = number_format(Cache::get('tax'), 2);

            $tax_amount = floatval(floatval(Cache::get('tax')) * session()->get('sub_total') / 100);
        }

        if (session()
                        ->has('discount')) {

            $coupon = session()->get('discount');

            if (is_array($coupon) && count($coupon) && floatval($coupon['discount']) > 0) {

                $discount = $coupon['discount'];
            }
        }

        session(['sub_total' => $total, 'shipping' => $shipping, 'tax_percentage' => $tax ?? '', 'tax_amount' => $tax_amount, 'discount' => $discount, 'total' => floatval(floatval($total) - floatval($discount) + floatval($tax_amount) + floatval($shipping))]);
    }

    public function coupon_apply(Request $request) {

        $loggedInUser = session()->get('user');

        $response = array(
            'error' => true,
            'message' => 'Enter Coupon Code'
        );

        if ($request->has('coupon') && trim($request->coupon) != "") {

            $data = [];

            $data['validate_promo_code'] = api_param('get-val');

            $data[api_param('user-id')] = $loggedInUser['user_id'];

            $data[api_param('promo-code')] = $request->coupon;

            $data[api_param('total')] = $request->total ?? 0;

            $response = $this->post('validate-promo-code', ['data' => $data]);

            if (!$response['error'] && floatval($response['discount']) > 0) {

                session()->put('discount', $response);

                $response['url'] = route('checkoutcoupon');
            }
        }

        echo json_encode($response);
    }

    public function coupon_remove() {

        session()->put('discount', '');

        $this->calcp();

        return redirect()->route('checkoutcoupon');
    }

    public function txnTest(Request $request) {
        $tmp = $request->session()
                ->get('tmp_paytm');
        $tmp[get('api-params.status')] = get('api-params.order-status.awaiting-payment');

        $loggedInUser = $request->session()
                ->get('user');
        $data = $request->session()
                ->get('tmp_paytm');
        return view("payment-gateways.txnTest", compact('loggedInUser', 'data', 'tmp'));
    }

    public function pgRedirect(Request $request) {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        $checkSum = "";
        $paramList = array();
        $ORDER_ID = $request["ORDER_ID"];
        $CUST_ID = $request["CUST_ID"];
        $TXN_AMOUNT = $request["TXN_AMOUNT"];
        $paymentMethods = Cache::get('payment_methods');
        if (isset($paymentMethods->paytm_payment_method) && $paymentMethods->paytm_payment_method == 1) {
            $paytm_merchant_id = $paymentMethods->paytm_merchant_id;
            $paytm_merchant_key = $paymentMethods->paytm_merchant_key;
            $callback_url = env('APP_URL', 'default_value') . "paytm/success";
            $paramList["MID"] = $paytm_merchant_id;
            $paramList["ORDER_ID"] = $ORDER_ID;
            $paramList["CUST_ID"] = $CUST_ID;
            $paramList["INDUSTRY_TYPE_ID"] = "Retail";
            $paramList["CHANNEL_ID"] = "WEB";
            $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
            $paramList["WEBSITE"] = "WEBSTAGING";
            $paramList["CALLBACK_URL"] = $callback_url;
        }

        $checkSum = getChecksumFromArray($paramList, $paytm_merchant_key);
        return view("payment-gateways.pgRedirect")->with('paramList', $paramList)->with('checkSum', $checkSum);
    }

    public function pgResponse(Request $request) {
        $paytmChecksum = "";
        $paramList = array();
        $paymentMethods = Cache::get('payment_methods');
        $paytm_merchant_key = $paymentMethods->paytm_merchant_key;
        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        $isValidChecksum = verifychecksum_e($paramList, $paytm_merchant_key, $paytmChecksum); //will return TRUE or FALSE string.
        if ($isValidChecksum == "TRUE") {
            echo "<b>Checksum matched and following are the transaction details:</b>";
            if ($_POST["STATUS"] == "TXN_SUCCESS") {
                echo "<b>Transaction status is success</b>";
                $transaction_id = $_POST['TXNID'];
                $data = $request->session()
                        ->get('tmp_paytm');
                $amount = $data['final_total'];
                $msg = "Payment completed successfully";
                $orderId = "";
                $response = $this->order_placedp($request->session()
                                ->get('tmp_paytm'));
                $orderId = $response['data']['order_id'] ?? "";
                if (intval($orderId)) {
                    $this->add_transactionp($response['data']['order_id'], "paytm", $transaction_id, true, $msg, $amount);
                    return redirect()->route('my-orders')
                                    ->with('suc', $response['message'] ?? $msg);
                }

                $this->add_transactionp($orderId, "paytm", $transaction_id, false, $msg, $amount);
                return redirect()->route('checkout-payment')
                                ->with('err', $response['message'] ?? $msg);
            }
        } else {
            echo "<b>Transaction status is failure</b>";
        }
        if (isset($_POST) && (!empty($_POST))) {
            foreach ($_POST as $paramName => $paramValue) {
                echo "<br/>" . $paramName . " = " . $paramValue;
            }
        } else {
            echo "<b>Checksum mismatched.</b>";
        }
    }

}
