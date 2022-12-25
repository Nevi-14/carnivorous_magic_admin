<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PayumoneyboltController extends CartController {

    private $amount = 0;
    private $isFromWallet = true;

    public function index() {

        $tmp = session()->get('tmp_payu');

        $this->amount = session()->get('wallet_topup_amount', 0);
        if (floatval($this->amount) == 0) {
            $this->isFromWallet = false;
            $this->amount = floatval($tmp['final_total']);
        }

        $amount = $this->amount * 100;
        $amount = $amount / 100;

        $loggedInUser = session()->get('user');

        $paymentMethods = Cache::get('payment_methods');
       

        if (request()->has('status') && request()->status == 'failed') {

            if ($this->isFromWallet == false) {
                return redirect()->route('checkout-payment')->with('err', 'Failed To Make Payment With PayUMoney. Kindly Select Another Option');
            } else {
                return redirect()->route('wallet-history')->with('err', 'Failed To Make Payment With PayUMoney. Kindly Select Another Option');
            }
        }

        if (isset($paymentMethods->payumoney_payment_method) && $paymentMethods->payumoney_payment_method == 1) {

            $mode = $paymentMethods->payumoney_mode;

            $merchant_key = $paymentMethods->payumoney_merchant_key;

            $salt = $paymentMethods->payumoney_salt;

            $payment_url = ($mode == 'sandbox') ? 'https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js' : 'https://checkout-static.citruspay.com/bolt/run/bolt.min.js';

            $data = ['key' => $merchant_key, 'salt' => $salt, 'txnid' => substr(hash('sha256', getTxnId() . microtime()), 0, 20)];

            $data['amount'] = $amount;

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
            return redirect()->back()->with('err', 'Kindly Select Another Payment Method');
        }
    }

    public function complete(Request $request, $type = "cancel") {

        $this->amount = session()->get('wallet_topup_amount', 0);
        if (floatval($this->amount) == 0) {
            $this->isFromWallet = false;
        }

        $error = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";
        $amount = 0;
        if ($request->has('status') && $request->status == 'success') {
            $amount = $request->amount ?? 0;

            

            if ($this->isFromWallet == false) {
                $response = $this->order_placed($request->session()
                                ->get('tmp_payu'));

                if ($response['success'] && intval($response['data']['order_id'])) {

                    $trans = $this->add_transaction($response['data']['order_id'],  __('msg.PayUMoney'), $request->txnid ?? '', true,  __('msg.order_success'), $request->amount ?? 0);

                    if (isset($trans['error']) && !$trans['error']) {

                        return redirect()->route('my-orders')
                                        ->with('suc',  __('msg.order_success'));
                    } else {

                        return redirect()->route('my-orders')
                                        ->with('suc',  __('msg.order_success'));
                    }
                } else {

                    $this->add_transaction($response['data']['order_id'], __('msg.PayUMoney'), $request->txnid ?? '', true, __('msg.order_success'), $request->amount ?? 0);

                    return redirect()
                                    ->back()
                                    ->with('err', $response['message'] ?? msg('order_error'));
                }
            } else {

                $response = $this->topup_wallet($amount, __('msg.PayUMoney'));

                if ($response['error'] == false) {

                    return redirect()->route('wallet-history')->with('suc',  __('msg.wallet_recharge_successfully'));
                } else {

                    $error = $response['message'];
                }
            }
        }


        if ($this->isFromWallet) {
            return redirect()->route('wallet-history')->with('err', $error);
        } else {
            return redirect()->route('checkout-payment')->with('err', $error);
        }
    }

}
