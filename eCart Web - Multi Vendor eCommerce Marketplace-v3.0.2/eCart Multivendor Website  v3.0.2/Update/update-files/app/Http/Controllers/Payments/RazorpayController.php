<?php

namespace App\Http\Controllers\Payments;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RazorpayController extends CartController{

    private $amount = 0;
    private $isFromWallet = true;

    public function index(){

        $data = session()->get('tmp_razorpay');

        $this->amount = session()->get('wallet_topup_amount', 0);
        if(floatval($this->amount) == 0){
            $this->isFromWallet = false;
            $this->amount = floatval($data['final_total']);
        }

        $amount = $this->amount * 100;

        $loggedInUser = session()->get('user');

        $response = $this->post('razorpay-order', ['data' => ['amount' => $amount, 'user_id' => session()->get('user') ['user_id']], 'data_param' => '']);

        if (isset($response['error']) && !$response['error']){
            return view('payment-gateways.razorpay', compact('response', 'loggedInUser', 'data', 'amount'));
        }else{
            return redirect()->back()->with('err', $response['message']??msg('order_error'));
        }

    }

    public function complete(Request $request, $type = "cancel"){

        $this->amount = session()->get('wallet_topup_amount', 0);
        if(floatval($this->amount) == 0){
            $this->isFromWallet = false;
        }

        $error = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";

        $data = json_decode($request->data);

        $generated_signature = hmac_sha256($data->id . "|" . $request->razorpay_payment_id, Cache::get('payment_methods')->razorpay_secret_key);

        $amount  = $request->amount ?? 0;

        try{
            $amount = $amount / 100;
        }catch(\Exception $e){}

        if ($generated_signature == $request->razorpay_signature){

            if($this->isFromWallet == false){
                $response = $this->order_placed($request->session()->get('tmp_razorpay'));

                if ($response['success'] && intval($response['data']['order_id'])){

                    $trans = $this->add_transaction($response['data']['order_id'],  __('msg.Razorpay'), $request->razorpay_payment_id??'', true, __('msg.order_success') , $amount);

                    if (isset($trans['error']) && !$trans['error']){
                        return redirect()->route('my-orders')->with('suc', __('msg.order_success'));
                    }else{
                        return redirect()->route('my-orders')->with('suc', __('msg.order_success'));
                    }
                }else{
                    $this->add_transaction($response['data']['order_id'],  __('msg.Razorpay'), $request->razorpay_payment_id??'', true, __('msg.order_success') , $amount);

                    $error = $response['message']??msg('order_error');
                }
            }else{
                $response = $this->topup_wallet($amount, __('msg.Razorpay'));

                if($response['error'] == false){

                    return redirect()->route('wallet-history')->with('suc', __('msg.wallet_recharge_successfully'));

                }else{

                    $error = $response['message'];
                }
            }

        }else{

            $error = $response['message']??msg('order_error');
        }


        if($this->isFromWallet){
            return redirect()->route('wallet-history')->with('err', $error);
        }else{
            return redirect()->route('checkout-payment')->with('err', $error);
        }

    }

}
