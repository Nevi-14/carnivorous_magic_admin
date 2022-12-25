<?php

namespace App\Http\Controllers\Payments;
use App\Http\Controllers\CartController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaypalController extends CartController{

    private $amount = 0;
    private $isFromWallet = true;

    public function index(){


        $paymentMethods = Cache::get('payment_methods');

        $loggedInUser = session()->get('user');

        $this->amount = session()->get('wallet_topup_amount', 0);
        if(floatval($this->amount) == 0){
            $this->isFromWallet = false;
            $tmp = session()->get('tmp_paypal');
            $this->amount = floatval($tmp['final_total']);
        }

        $amount = $this->amount;

        $paymentMethods = Cache::get('payment_methods');

        if (isset($paymentMethods->paypal_payment_method) && $paymentMethods->paypal_payment_method == 1){

            $payment_url = "https://www.paypal.com/cgi-bin/webscr";

            if ($paymentMethods->paypal_mode == "sandbox"){

                $payment_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
            }

            return view('payment-gateways.paypal', compact('payment_url', 'paymentMethods', 'amount'));

        }else{

            return redirect()->back()->with('err', 'Kindly Select Another Payment Method');

        }

    }

    public function complete(Request $request, $type = "cancel"){

        $this->amount = session()->get('wallet_topup_amount', 0);
        if(floatval($this->amount) == 0){
            $this->isFromWallet = false;
        }

        $error = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";

        if ($type == "return"){

            $error = true;

            $msg = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";

            if (isset($_GET['amt']) && isset($_GET['st']) && $_GET['st'] == 'Completed'){
                $msg = "Payment completed successfully";
                $error = false;
            }elseif (isset($_GET['amt']) && isset($_GET['st']) && $_GET['st'] == 'Authrize'){
                $msg = "Payment is authorized successfully. Your order will be fulfilled once we capture the transaction.";
                $error = false;
            }elseif (isset($_GET['tx']) && $_GET['tx'] == 'disabled'){
                $msg = "Paypal payment method is not available currently";
            }

            $orderId = "";

            if (!$error){

                if($this->isFromWallet == false){
                    $response = $this->order_placed($request->session()
                        ->get('tmp_paypal'));

                    $orderId = $response['data']['order_id']??"";

                    if (intval($orderId))
                    {

                        $this->add_transaction($response['data']['order_id'], __('msg.paypal'), $request->item_number??'', true, $msg, $request->amt??0);

                        return redirect()
                            ->route('my-orders')
                            ->with('suc', $response['message']??$msg);
                    }else{
                        $this->add_transaction($orderId,  __('msg.paypal'), $request->item_number??'', false, $msg, $request->amt??0);
                    }
                }else{
                    $response = $this->topup_wallet($_GET['amt'], __('msg.paypal'));

                    if($response['error'] == false){

                        return redirect()->route('wallet-history')->with('suc', __('msg.wallet_recharge_successfully') ?? $response['message']);

                    }else{

                        $error = $response['message'];
                    }

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
