<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;

class CheckoutController extends CartController {

    public function index() {

        if (!isLoggedIn()) {

            return redirect()->route('login');
        } else {

            $address = session()->get('checkout-address');

            $data = $this->post('cart', ['data' => ['get_user_cart' => 1, 'user_id' => session()->get('user')['user_id'], 'address_id' => $address->id]]);

            $data['cart'] = $this->getCart();

            $data['code_list'] = $this->post('validate-promo-code', ['data' => [api_param('get_promo_codes') => 1, 'user_id' => session()->get('user') ['user_id'], 'amount' => $data['cart']['total'], 'limit' => '200']]);

            $data['title'] = __('msg.checkout_summary_title');

            $this->html('checkout_summary', ['data' => $data, 'address' => $address, 'carticon' => 0, 'title' => __('msg.checkout_summary_pass')]);
        }
    }

    public function summary(Request $request) {

        if (!isLoggedIn()) {

            return redirect()->route('login');
        } else {

            //$data = $this->post('cart', ['data' => ['get_user_cart' => 1, 'user_id' => session()->get('user')['user_id'], 'address_id' => $request->id]]);

            $data['cart'] = $this->getCart();

            $data['code_list'] = $this->post('validate-promo-code', ['data' => [api_param('get_promo_codes') => 1, 'user_id' => session()->get('user') ['user_id'], 'amount' => $data['cart']['total'], 'limit' => '200']]);

            $address = $this->post('addresses', ['data' => ['get_addresses' => 1, 'user_id' => session()->get('user') ['user_id']]]);

            if (!($address['error'] ?? false)) {
                $address = $address['data'];

                $data['address'] = $address;
            }

            $addressExist = false;

            if (intval($request->id ?? 0)) {

                foreach ($data['address'] as $a) {

                    if ($a->id == $request->id) {

                        $addressExist = $a;
                    }
                }

                if (isset($addressExist->id)) {

                    $request->session()->put('checkout-address', $addressExist);

                    $address = session()->get('checkout-address');

                    $this->html('checkout_summary', ['data' => $data, 'address' => $address, 'carticon' => 0, 'title' => __('msg.checkout_summary')]);
                }
            } else {

                return redirect()->route('checkout-address')->with('err', 'Selected Address Does not Exists');
            }
        }
    }

    public function init_checkout() {

        if (!isLoggedIn()) {

            return redirect()
                            ->route('login');
        } else {

            return $this->getCart();
        }
    }

    public function getProductId($cart) {

        $tmp = array();

        if (isset($cart['cart']) && count($cart['cart'])) {

            foreach ($cart['cart']['data'] as $item) {

                $tmp[] = $item->product_variant_id;
            }
        }

        return json_encode($tmp);
    }

    public function getQty($cart) {

        $tmp = array();

        if (isset($cart['cart']) && count($cart['cart'])) {

            foreach ($cart['cart']['data'] as $item) {

                $tmp[] = $item->qty;
            }
        }

        return json_encode($tmp);
    }

    public function getAddress() {

        $address = session()->get('checkout-address');

        $a = [];

        $a[] = $address->name;

        $a[] = $address->address;

        $a[] = $address->landmark;

        $a[] = $address->area;

        $a[] = $address->city;

        $a[] = $address->state;

        $a[] = $address->country;

        $a[] = $address->pincode;

        $a[] = 'Deliver to ' . $address->type;

        return \implode(", ", $a);
    }

    public function address(Request $request) {

        $data = $this->init_checkout();

        $address = $this->post('addresses', ['data' => ['get_addresses' => 1, 'user_id' => session()->get('user') ['user_id']]]);

        $data['address'] = [];

        if (!($address['error'] ?? false) && count($address)) {

            $address = $address['data'];
            $data['address'] = $address;
        }

        $addressExist = false;

        if (intval($request->id ?? 0)) {
            foreach ($data['address'] as $a) {

                if ($a->id == $request->id) {

                    $addressExist = $a;
                }
            }

            if (isset($addressExist->id)) {
                $request->session()->put('checkout-address', $addressExist);

                return redirect()->route('checkout-summary');
            } else {

                return redirect()->route('checkout-address')->with('err', 'Selected Address Doen\'t Exists');
            }
        }


        if (is_array($data['cart'] ?? []) && count($data['cart'])) {
            $data['title'] = __('msg.address');

            $this->html('checkout_address', $data);
        } else {

            return redirect()->route('shop')
                            ->with('err', msg('no_product_checkount'));
        }
    }

    public function payment(Request $request) {

        $data = [];

        $data = $this->getCart();

        $delivery_charge = $this->post('cart', ['data' => ['get_user_cart' => 1, 'user_id' => session()->get('user')['user_id'], 'address_id' => $data['address']->id, 'is_code' => '1']]);
        $data['delivery_charge'] = $delivery_charge['delivery_charge_with_cod'] ?? 0;
        
        $data['selected_address'] = $this->getAddress();
        if (isset($data['cart']) && is_array($data['cart']) && count($data['cart'])) {

            if (isset($data['address']->id) && intval($data['address']->id)) {

                $user = $this->post('get-user', ['data' => ['get_user_data' => 1, 'user_id' => session()->get('user') ['user_id']]]);

                if (isset($user['error']) && $user['error']) {
                    redirect()->route('logout');
                } else {

                    $data['user'] = $user;
                    $data['title'] = __('msg.payment');

                    $this->html('checkout_payment', $data);
                }
            } else {

                redirect()->route('checkout-address')->with('err', 'Select Address For Delivery');
            }
        } else {

            redirect()->route('shop')->with('err', msg('no_product_checkount'));
        }
    }

    public function get_shipdel_charge(Request $request) {
        $payment_type = $request->payment_type;
        
        $data = $this->getCart();
       
        $delivery_charge = $this->post('cart', ['data' => ['get_user_cart' => 1, 'user_id' => session()->get('user')['user_id'], 'address_id' => $data['address']->id, 'is_code' => '1']]);
        
        $delivery_charge['currency'] = Cache::get('currency') ?? '';

        echo json_encode($delivery_charge);
        
        
    }

    public function proceed(Request $request) {
        $loggedInUser = $this->post('get-user', ['data' => ['get_user_data' => 1, 'user_id' => session()->get('user')['user_id']]]);

        $loggedInUser = $loggedInUser['data'][0];

        $data = [];

        $cart = $this->getCart();

        $msg = msg('no_product_checkount');

        $return = false;

        if (isset($cart['cart']) && is_array($cart['cart']) && count($cart['cart'])) {

            $data[api_param('place-order')] = api_param('get-val');

            $data[api_param('user-id')] = $loggedInUser->user_id;

            $data[api_param('tax-percentage')] = $cart['tax'] ?? '';

            $data[api_param('tax-amount')] = $cart['tax_amount'] ?? 0;

            $data[api_param('total')] = $cart['subtotal'];

            $data[api_param('payment-method')] = $request->paymentMethod;
            
            if(session()->has('pincode_no')){
                $data[api_param('final-total')] = $cart['subtotal'] + $cart['shipping'];
            } else {
            if ($request->paymentMethod == 'cod') {
                $delivery_charge = $this->post('cart', ['data' => ['get_user_cart' => 1, 'user_id' => session()->get('user')['user_id'], 'address_id' => $cart['address']->id, 'is_code' => '1']]);
                $data[api_param('final-total')] = $cart['subtotal'] + $delivery_charge['delivery_charge_with_cod'];
            } else {
                $delivery_charge = $this->post('cart', ['data' => ['get_user_cart' => 1, 'user_id' => session()->get('user')['user_id'], 'address_id' => $cart['address']->id, 'is_code' => '0']]);
                $data[api_param('final-total')] = $cart['subtotal'] + $delivery_charge['delivery_charge_without_cod'];
            }
            }

            $data[api_param('product-variant-id')] = $this->getProductId($cart);

            $data[api_param('quantity')] = $this->getQty($cart);

            $data[api_param('mobile')] = $loggedInUser->mobile;

            if(session()->has('pincode_no')){
                $data[api_param('delivery-charge')] = $cart['shipping'] ?? 0;
            } else {
                if ($request->paymentMethod == 'cod') {
                    $data[api_param('delivery-charge')] = $delivery_charge['delivery_charge_with_cod'] ?? 0;
                } else {
                    $data[api_param('delivery-charge')] = $delivery_charge['delivery_charge_without_cod'] ?? 0;
                }
                
            }

            $deliverDay = $request->deliverDay ?? '';

            $data[api_param('delivery-time')] = $deliverDay . " " . ($request->deliveryTime ?? '');

            $data[api_param('address')] = $this->getAddress();

            $data['address_id'] = $cart['address']->id;

            $data[api_param('latitude')] = 0;

            $data[api_param('longitude')] = 0;

            $coupon = session()->get('discount', []);

            if (is_array($coupon) && count($coupon) && floatval($coupon['discount']) > 0) {

                $data[api_param('promo-code')] = $coupon['promo_code'];

                $data[api_param('promo-discount')] = $coupon['discount'];
            }

            $data[api_param('email')] = $loggedInUser->email;

            $data[api_param('wallet-used')] = $request->wallet_used ?? "false";

            if ($data[api_param('wallet-used')] == "true") {

                $data[api_param('wallet-balance')] = $request->wallet_balance ?? 0;

                if (floatval($loggedInUser->balance)) {

                    if (floatval($loggedInUser->balance) > floatval($data['total'])) {

                        $request->paymentMethod = 'cod';
                        if(session()->has('pincode_no')){
                            $data[api_param('final-total')] = 0;
                        } else {
                            $data[api_param('final-total')] = $delivery_charge['delivery_charge_with_cod'] ?? 0;
                        }
                    } else {
                        if(session()->has('pincode_no')){
                            $data[api_param('final-total')] = floatval($data['total']) - floatval($loggedInUser->balance);
                        } else {
                            if ($request->paymentMethod == 'cod') {
                                $data[api_param('final-total')] = floatval($data['total']) - floatval($loggedInUser->balance) + $delivery_charge['delivery_charge_with_cod'] ?? 0;
                        }
                           else {
                                $data[api_param('final-total')] = floatval($data['total']) - floatval($loggedInUser->balance) + $delivery_charge['delivery_charge_without_cod'] ?? 0;
                            }
                        
                            }
                            
                    }
                }
            } else {

                $data[api_param('wallet-balance')] = 0;
            }

            switch ($request->paymentMethod) {

                case 'cod':

                    $return = $this->checkout_cod($data);

                    break;

                case 'razorpay':

                    $request->session()
                            ->put('tmp_razorpay', $data);

                    $return = redirect()->route('checkout-razorpay-init');

                    break;

                case 'payumoney':

                    $request->session()
                            ->put('tmp_payu', $data);

                    $return = redirect()->route('checkout-payu-init');

                    break;

                case 'payumoney-bolt':

                    $request->session()
                            ->put('tmp_payu', $data);

                    $return = redirect()->route('checkout-payu-init-bolt');

                    break;

                case 'paypal':

                    $request->session()
                            ->put('tmp_paypal', $data);

                    $return = redirect()->route('checkout-paypal-init');

                    break;

                case 'stripe':

                    $request->session()
                            ->put('tmp_payment', $data);

                    $return = redirect()->route('payment-stripe-start');

                    break;

                case 'flutterwave':

                    $request->session()
                            ->put('tmp_payment', $data);

                    $return = redirect()->route('payment-flutterwave-start');

                    break;

                case 'paystack':

                    $request->session()
                            ->put('tmp_payment', $data);

                    $return = redirect()->route('payment-paystack-start');

                    break;

                case 'paytm':

                    $request->session()
                            ->put('tmp_paytm', $data);

                    $return = redirect()->route('txnTest');

                    break;

                case 'bank_transfer':

                    $data[get('api-params.status')] = get('api-params.order-status.awaiting-payment');

                    $return = $this->checkout_bank_transfer($data);

                    break;

                default:

                    $return = redirect()->route('checkout-payment')
                            ->with('err', msg('select_payment_method'));
            }
        }

        return (!$return) ? redirect()->route('checkout-payment')
                        ->with('err', $msg) : $return;
    }

}
