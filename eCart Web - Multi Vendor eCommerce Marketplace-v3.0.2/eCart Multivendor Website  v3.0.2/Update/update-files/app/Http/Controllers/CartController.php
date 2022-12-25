<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use function GuzzleHttp\json_encode;
use Redirect;

class CartController extends Controller {

    public function index() {

        if (!isLoggedIn()) {

            $data['cart'] = $this->getCart_offline();

            $settings = $this->post('settings', ['data' => ['all' => true]]);

            if (isset($settings['error']) && !$settings['error']) {

                $settings = $settings['data'];

                $data['title'] = __('msg.cart');

                $this->html('cart', $data, $settings);
            } else {
                abort(404);
            }
        } else {

            $data['cart'] = $this->getCart();

            $settings = $this->post('settings', ['data' => ['all' => true]]);

            if (isset($settings['error']) && !$settings['error']) {

                $settings = $settings['data'];

                $data['title'] = __('msg.cart');
             
                $this->html('cart', ['data' => $data, 'title' => __('msg.cart'), 'settings' => $settings]);
            } else {
                abort(404);
            }
        }
    }

    public function cartajax() {

        if (!isLoggedIn()) {
            $data = $this->getCart_offline();
            $cart_session = session()->get('cart');
            $get_session_varient_ids = session()->get('variant_ids', []);
            $varient_ids = implode(',', $get_session_varient_ids);
            $result = $this->post('get-products', ['data' => ['get_variants_offline' => 1, 'variant_ids' => $varient_ids]]);
            $totalcart = count($get_session_varient_ids);
            $settings = $this->post('settings', ['data' => ['all' => true]]);
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
                    'pincode_no' => session()->get('pincode_no'),
                    'is_local_shipping' => Cache::get('local_shipping'),
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
                ));
            }
        } else {

            $data = $this->getCart();
            $settings = $this->post('settings', ['data' => ['all' => true]]);
            if (isset($settings['error']) && !$settings['error']) {
                $settings = $settings['data'];
                $data['title'] = __('msg.cart');
                $totalcart = $data['cart']['total'];
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
                    'login' => 1,
                ));
                die;
            } else {
                abort(404);
            }
        }
    }

    public function getLastUrl() {

        $lastUrlName = "";

        try {

            $lastUrl = app('request')->create(url()
                            ->previous(), 'GET');

            $lastUrlName = app('router')->goroutes()
                            ->match($lastUrl)->getName() ?? '';
        } catch (\Exception $e) {

            $lastUrlName = "";
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {

            $lastUrlName = "";
        }

        return $lastUrlName;
    }

    public function add(Request $request) {

        if (!isLoggedIn()) {
            if (!in_array($request->child_id, session()->get('variant_ids', []))) {
                session()->push('variant_ids', $request->child_id);
            }

            $id = $request->child_id;

            $cart = session()->get('cart');

            // if cart is empty then this the first product
            if (!$cart) {

                $cart = [
                    $id => [
                        "name" => $request->name,
                        "quantity" => $request->qty,
                        "price" => $request->price,
                        "image" => $request->image
                    ]
                ];

                session()->put('cart', $cart);
            }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {

                $cart[$id]['quantity']++;

                session()->put('cart', $cart); // this code put product of choose in cart
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $request->name,
                "quantity" => $request->qty,
                "price" => $request->price,
                "image" => $request->image
            ];

            session()->put('cart', $cart); // this code put product of choose in cart
            $cart = session()->get('cart');

            return redirect()->back()->with('suc', __('msg.added_items_to_cart'));
        }
        //return redirect()->route('home')->with('error_code', 5);
        else {

            $lastUrlName = $this->getLastUrl();

            if ($lastUrlName == "login" && $request->session()->has('tmp_cart')) {

                $tmp = $request->session()->get('tmp_cart');

                if (isset($tmp['id']) && intval($tmp['id']) && isset($tmp['varient']) && intval($tmp['varient'])) {

                    $request->id = $tmp['id'];

                    $request->child_id = $tmp['varient'];
                }
            }

            return $this->addToCart($request);
        }
    }

    public function addToCart(Request $request, $lastUrlName = "") {

        $result = $this->post('cart', ['data' => ['add_to_cart' => 1, 'user_id' => session()
                        ->get('user') ['user_id'], 'product_id' => $request->id, 'product_variant_id' => $request->child_id, 'qty' => $request->qty ?? 1]]);

        $return = false;

        if ($result['error']) {

            if ($lastUrlName == 'login') {

                $return = redirect()->route('cart')
                        ->with('err', $result['message']);
            } else {

                $return = redirect()->back()
                        ->with('err', $result['message']);
            }
        } else {

            $request->session()
                    ->forget('tmp_cart');

            if ($request->has('submit') && $request->submit == "buynow") {

                $return = redirect()->route('cart')
                        ->with('suc', $result['message']);
            } else {

                $return = redirect()->back()
                        ->with('suc', $result['message']);
            }
        }

        return $return;
    }

    public function add_single_varient(Request $request) {

        return $this->add_single($request, $request->id, $request->varient);
    }

    public function add_single(Request $request, $id, $varient_id) {

        if (!isLoggedIn()) {

            $request->session()->put('last-url', url()->full());
        }

        $request->id = $id;

        $request->child_id = $varient_id;

        return $this->add($request);
    }

    public function addajax(Request $request) {

        if (!isLoggedIn()) {
            if (!in_array($request->varient, session()->get('variant_ids', []))) {
                session()->push('variant_ids', $request->varient);
            }

            $id = $request->varient;

            $cart = session()->get('cart');

            // if cart is empty then this the first product
            if (!$cart) {

                $cart = [
                    $id => [
                        "name" => $request->name,
                        "quantity" => $request->qty,
                        "price" => $request->price,
                        "image" => $request->image
                    ]
                ];

                session()->put('cart', $cart);
            }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {

                $cart[$id]['quantity']++;

                session()->put('cart', $cart); // this code put product of choose in cart
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $request->name,
                "quantity" => $request->qty,
                "price" => $request->price,
                "image" => $request->image
            ];

            session()->put('cart', $cart); // this code put product of choose in cart
            $cart = session()->get('cart');
            $get_session_varient_ids = session()->get('variant_ids', []);
            $totalcart = count($get_session_varient_ids);
            return response()->json(['status' => __('msg.added_items_to_cart'), 'cart' => $cart, 'totalcart' => $totalcart]);
        } else {

            $lastUrlName = $this->getLastUrl();

            if ($lastUrlName == "login" && $request->session()
                            ->has('tmp_cart')) {

                $tmp = $request->session()
                        ->get('tmp_cart');

                if (isset($tmp['id']) && intval($tmp['id']) && isset($tmp['varient']) && intval($tmp['varient'])) {

                    $request->id = $tmp['id'];

                    $request->varient = $tmp['varient'];

                    $request->qty = $tmp['qty'];
                }
            }

            return $this->addToCartajax($request);
        }
    }

    public function addToCartajax(Request $request, $lastUrlName = "") {

        $result = $this->post('cart', ['data' => ['add_to_cart' => 1, 'user_id' => session()
                        ->get('user') ['user_id'], 'product_id' => $request->id, 'product_variant_id' => $request->varient, 'qty' => $request->qty ?? 1]]);

        $return = false;

        if ($result['error']) {

            if ($lastUrlName == 'login') {

                $return = redirect()->route('cart')
                        ->with('err', $result['message']);
            } else {

                return response()->json(['status' => $result['message']]);
            }
        } else {

            $request->session()
                    ->forget('tmp_cart');

            if ($request->has('submit') && $request->submit == "buynow") {

                $return = redirect()->route('cart')
                        ->with('suc', $result['message']);
            } else {
                $data1 = $this->getCart();

                $totalcart = $data1['cart']['total'];

                return response()->json(['status' => __('msg.added_items_to_cart'), 'login' => '1', 'totalcart' => $totalcart]);
            }
        }

        return $return;
    }

    public function add_single_varientajax(Request $request) {

        return $this->add_singleajax($request, $request->id, $request->varient, $request->qty);
    }

    public function add_singleajax(Request $request, $id, $varient_id, $qty) {

        if (!isLoggedIn()) {

            $request->session()->put('last-url', url()->full());
        }

        $request->id = $id;

        $request->varient = $varient_id;

        $request->qty = $qty;

        return $this->addajax($request);
    }

    public function calc() {

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

    public function order_placed($data, $clearCart = true) {

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

    public function checkout_cod($data) {

        $response = $this->order_placed($data);
//dd($response);
        if ($response['success']) {

            return redirect()->route('my-orders')
                            ->with('suc', $response['message'] ?? msg('order_success'));
        } else {

            return redirect()->back()
                            ->with('err', $response['message'] ?? msg('order_error'));
        }
    }

    public function checkout_bank_transfer($data) {

        $response = $this->order_placed($data);

        if ($response['success']) {

            return redirect()->route('my-orders')->with('suc', $response['message'] ?? msg('order_success'));
        } else {

            return redirect()->back()->with('err', $response['message'] ?? msg('order_error'));
        }
    }

    public function checkout_paypal_init(Request $request) {

        $paymentMethods = Cache::get('payment_methods');

        if (isset($paymentMethods->paypal_payment_method) && $paymentMethods->paypal_payment_method == 1) {

            $payment_url = "https://www.paypal.com/cgi-bin/webscr";

            if ($paymentMethods->paypal_mode == "sandbox") {

                $payment_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
            }

            $tmp = $request->session()
                    ->get('tmp_paypal');

            return view('payment-gateways.paypal', compact('payment_url', 'paymentMethods', 'tmp'));
        }
    }

    public function checkout_paypal(Request $request, $type = "return") {

        if ($type == "return") {

            $error = true;

            $msg = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";

            if (isset($_GET['amt']) && isset($_GET['st']) && $_GET['st'] == 'Completed') {
                $msg = "Payment completed successfully";
                $error = false;
            } elseif (isset($_GET['amt']) && isset($_GET['st']) && $_GET['st'] == 'Authrize') {
                $msg = "Payment is authorized successfully. Your order will be fulfilled once we capture the transaction.";
                $error = false;
            } elseif (isset($_GET['tx']) && $_GET['tx'] == 'disabled') {
                $msg = "Paypal payment method is not available currently";
            }

            $orderId = "";

            if (!$error) {

                $response = $this->order_placed($request->session()
                                ->get('tmp_paypal'));

                $orderId = $response['data']['order_id'] ?? "";

                if (intval($orderId)) {

                    $this->add_transaction($response['data']['order_id'], "paypal", $request->item_number ?? '', true, $msg, $request->amt ?? 0);

                    return redirect()
                                    ->route('my-orders')
                                    ->with('suc', $response['message'] ?? $msg);
                }
            }

            $this->add_transaction($orderId, "paypal", $request->item_number ?? '', false, $msg, $request->amt ?? 0);

            return redirect()
                            ->route('checkout-payment')
                            ->with('err', $response['message'] ?? $msg);
        }

        return redirect()->route('checkout-payment')
                        ->with('err', $msg);
    }

    public function checkout_payu_bolt_init(Request $request) {

        $paymentMethods = Cache::get('payment_methods');

        if ($request->has('status') && $request->status == 'failed') {

            return redirect()
                            ->route('checkout-payment')
                            ->with('err', 'Failed To Make Payment With PayUMoney. Kindly Select Another Option');
        }

        if (isset($paymentMethods->payumoney_payment_method) && $paymentMethods->payumoney_payment_method == 1) {

            $loggedInUser = $request->session()
                    ->get('user');

            $tmp = $request->session()
                    ->get('tmp_payu');

            $mode = $paymentMethods->payumoney_mode;

            $merchant_key = $paymentMethods->payumoney_merchant_key;

            $salt = $paymentMethods->payumoney_salt;

            $payment_url = ($mode == 'sandbox') ? 'https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js' : 'https://checkout-static.citruspay.com/bolt/run/bolt.min.js';

            $data = ['key' => $merchant_key, 'salt' => $salt, 'txnid' => substr(hash('sha256', getTxnId() . microtime()), 0, 20)];

            $data['amount'] = $tmp['final_total'];

            $data['firstname'] = $loggedInUser['name'];

            $data['email'] = $loggedInUser['email'];

            $data['phone'] = $loggedInUser['mobile'];

            $data['productinfo'] = get('name');

            $data['surl'] = route('checkout-payu-bolt');

            $data['furl'] = route('checkout-payu-bolt', ['status' => 'failed']);

            $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|||||";

            $hashVarsSeq = explode('|', $hashSequence);

            $hash_string = '';

            foreach ($hashVarsSeq as $hash_var) {

                $hash_string .= isset($data[$hash_var]) ? $data[$hash_var] : '';

                $hash_string .= '|';
            }

            $data['hash'] = strtolower(hash('sha512', $hash_string . $salt));

            $data['payment_url'] = $payment_url;

            return view("payment-gateways.payu-bolt", compact('data'));
        } else {

            return redirect()->route('cart')
                            ->with('err', 'Kindly Select Another Payment Method');
        }
    }

    public function checkout_payu_bolt(Request $request) {

        if ($request->has('status') && $request->status == 'success') {

            $response = $this->order_placed($request->session()
                            ->get('tmp_payu'));

            if ($response['success'] && intval($response['data']['order_id'])) {

                $trans = $this->add_transaction($response['data']['order_id'], "payumoney", $request->txnid ?? '', true, msg('order_success'), $request->amount ?? 0);

                if (isset($trans['error']) && !$trans['error']) {

                    return redirect()->route('my-orders')
                                    ->with('suc', $response['message'] ?? msg('order_success'));
                } else {

                    return redirect()->route('my-orders')
                                    ->with('suc', $response['message'] . "<br>" . $trans['message'] ?? msg('order_success'));
                }
            } else {

                $this->add_transaction($response['data']['order_id'], "payumoney", $request->txnid ?? '', true, msg('order_success'), $request->amount ?? 0);

                return redirect()
                                ->back()
                                ->with('err', $response['message'] ?? msg('order_error'));
            }
        }
    }

    public function add_transaction($orderId = "", $paymentType = "", $txnId = "", $status = true, $message = "", $amount = 0) {

        $data = ['add_transaction' => 1, 'user_id' => session()->get('user') ['user_id'], 'order_id' => $orderId, 'type' => $paymentType, 'txn_id' => $txnId, 'amount' => $amount, 'status' => ($status ? 'Success' : 'canceled'), 'message' => $message ?? msg('order_success'), 'transaction_date' => date('Y-m-d H:i:s')];

        return $this->post('order-process', ['data' => $data, 'data_param' => '']);
    }

    public function topup_wallet($amount = "", $msg = "", $type = "credit") {

        $data = ['add_wallet_balance' => 1, 'user_id' => session()->get('user') ['user_id'], 'type' => $type, 'amount' => $amount, 'message' => $msg ?? msg('order_success')];

        return $this->post('wallet-history', ['data' => $data, 'data_param' => '']);
    }

    public function checkout_razorpay_init(Request $request) {

        $loggedInUser = $request->session()
                ->get('user');

        $data = $request->session()
                ->get('tmp_razorpay');

        $response = $this->post('razorpay-order', ['data' => ['amount' => $data[api_param('final-total')] * 100, 'user_id' => session()->get('user') ['user_id']], 'data_param' => '']);

        if (isset($response['error']) && !$response['error']) {

            return view('payment-gateways.razorpay', compact('response', 'loggedInUser', 'data'));
        } else {

            return redirect()->back()
                            ->with('err', $response['message'] ?? msg('order_error'));
        }
    }

    public function checkout_razorpay(Request $request) {

        $data = json_decode($request->data);

        $generated_signature = hmac_sha256($data->id . "|" . $request->razorpay_payment_id, Cache::get('payment_methods')
                ->razorpay_secret_key);

        $return = false;

        if ($generated_signature == $request->razorpay_signature) {

            $response = $this->order_placed($request->session()
                            ->get('tmp_razorpay'));

            if ($response['success'] && intval($response['data']['order_id'])) {

                $trans = $this->add_transaction($response['data']['order_id'], "razorpay", $request->razorpay_payment_id ?? '', true, msg('order_success'), $request->amount ?? 0);

                if (isset($trans['error']) && !$trans['error']) {

                    $return = redirect()->route('my-orders')
                            ->with('suc', $response['message'] ?? msg('order_success'));
                } else {

                    $return = redirect()->route('my-orders')
                            ->with('suc', $response['message'] . "<br>" . $trans['message'] ?? msg('order_success'));
                }
            } else {

                $this->add_transaction($response['data']['order_id'], "razorpay", $request->razorpay_payment_id ?? '', true, msg('order_success'), $request->amount ?? 0);

                $return = redirect()->back()
                        ->with('err', $response['message'] ?? msg('order_error'));
            }
        } else {

            $return = redirect()->back()
                    ->with('err', $response['message'] ?? msg('order_error'));
        }

        return $return;
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

}
