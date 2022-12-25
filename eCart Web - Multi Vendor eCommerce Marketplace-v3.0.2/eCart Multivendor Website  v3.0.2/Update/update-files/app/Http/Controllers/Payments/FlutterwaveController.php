<?php

namespace App\Http\Controllers\Payments;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FlutterwaveController extends CartController{

    private $amount = 0;
    private $isFromWallet = true;

    public function index(){

        $this->amount = session()->get('wallet_topup_amount', 0);
        if(floatval($this->amount) == 0){
            $this->isFromWallet = false;
            $tmp = session()->get('tmp_payment');
            $this->amount = floatval($tmp['final_total']);
        }

        $amount = $this->amount;

        $paymentMethods = Cache::get('payment_methods');

        $session = session()->get('tmp_payment');

        $loggedInUser = session()->get('user');

        if(isset($paymentMethods->flutterwave_payment_method) && $paymentMethods->flutterwave_payment_method == 1){

            return view('payment-gateways.flutterwave', compact('paymentMethods', 'session', 'loggedInUser', 'amount'));

        }else{

            return redirect()->back()->with('err', msg('select_payment_method'));

        }

    }

    public function complete(Request $request, $type = "cancel"){

        $this->amount = session()->get('wallet_topup_amount', 0);
        if(floatval($this->amount) == 0){
            $this->isFromWallet = false;
        }

        $error = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";

        $amount = 0;

        if($type == "success"){

            $orderId = $request->get('transaction_id', '');

            if(trim($orderId) != ""){

                $paymentMethods = Cache::get('payment_methods');

                $secret_key = $paymentMethods->flutterwave_secret_key;

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$orderId/verify",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "Authorization: Bearer $secret_key"
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $response = \json_decode($response);

                if(($response->status ?? '') == "success"){

                    $tx_ref = $response->data->tx_ref ?? '';

                    $status = $response->data->processor_response ?? 'unknown';

                    $amount = $response->data->charged_amount ?? 0;

                    $msg = $response->message ?? '';

                    if($this->isFromWallet == false){

                        $order = $this->order_placed($request->session()->get('tmp_payment'));

                        if($order['success']){

                            $orderId = $order['data']['order_id'] ?? "";

                            if(intval($orderId)){

                                $this->add_transaction($order['data']['order_id'], __('msg.flutterwave'), $tx_ref ?? '', true, $status, $amount);

                                return redirect()->route('my-orders')->with('suc', __('msg.order_success'));

                            }

                        }else{

                            $error = $order['message'];
                        }

                    }else{

                        $response = $this->topup_wallet($amount, __('msg.flutterwave'));

                        if($response['error'] == false){

                            return redirect()->route('wallet-history')->with('suc', __('msg.wallet_recharge_successfully'));

                        }else{

                            $error = $response['message'];
                        }

                    }

                }else{

                    $this->add_transaction($orderId, __('msg.Stripe'), $orderId, false, $response->error ?? 'Something Went Wrong', $amount);

                }

            }

        }

        if($this->isFromWallet){
            return redirect()->route('wallet-history')->with('err', $error);
        }else{
            return redirect()->route('checkout-payment')->with('err', $error);
        }

    }

}
