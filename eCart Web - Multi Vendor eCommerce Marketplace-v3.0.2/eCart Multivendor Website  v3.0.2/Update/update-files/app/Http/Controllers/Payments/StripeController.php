<?php

namespace App\Http\Controllers\Payments;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use \Stripe\Stripe;

class StripeController extends CartController{

    private $apiKey = "";
    private $amount = 0;
    private $isFromWallet = true;

    public function __construct(){

        parent::__construct();

        $paymentMethods = Cache::get('payment_methods');

        $this->apiKey = $paymentMethods->stripe_secret_key;
    }

    public function index(){

        $this->amount = session()->get('wallet_topup_amount', 0);
        if(floatval($this->amount) == 0){
            $this->isFromWallet = false;
            $tmp = session()->get('tmp_payment');
            $this->amount = floatval($tmp['final_total']);
        }
        $this->amount = $this->amount * 100;

        $paymentMethods = Cache::get('payment_methods');

        if(isset($paymentMethods->stripe_payment_method) && $paymentMethods->stripe_payment_method == 1){

            \Stripe\Stripe::setApiKey($this->apiKey);

            try {
                $checkout_session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => $paymentMethods->stripe_currency_code,
                            'unit_amount' => $this->amount,
                            'product_data' => [
                                'name' => Cache::get('app_name', get('name')),
                                'images' => [_asset(Cache::get('logo'))],
                            ],
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => route('payment-stripe-complete', ['type' => 'success'])."/{CHECKOUT_SESSION_ID}?amount=".$this->amount,
                    'cancel_url' => route('payment-stripe-complete', ['type' => 'cancel']),
                ]);

                return view('payment-gateways.stripe', compact('checkout_session', 'paymentMethods'));

            }catch(\Stripe\Exception\InvalidRequestException $e) {

                return redirect()->back()->with('err', $e->getMessage());

            }catch(\Exception $e) {

                return redirect()->back()->with('err', $e->getMessage());
            }

        }else{

            return redirect()->back()->with('err', msg('select_payment_method'));

        }

    }

    public function complete(Request $request, $type = "cancel", $orderId = ""){

        $this->amount = session()->get('wallet_topup_amount', 0);
        if(floatval($this->amount) == 0){
            $this->isFromWallet = false;
        }

        $error = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";

        $amount = 0;

        if($type == "success"){

            if(trim($orderId) != ""){

                \Stripe\Stripe::setApiKey($this->apiKey);

                // Fetch the Checkout Session to display the JSON result on the success page

                try {

                    $checkout_session = \Stripe\Checkout\Session::retrieve($orderId);

                    $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);

                    if($intent->status == 'succeeded'){

                        // Transaction details
                        $amount = $intent->amount;

                        $amount = ($amount/100);

                        if($this->isFromWallet == false){

                            $response = $this->order_placed($request->session()->get('tmp_payment'));

                            if($response['success']){

                                $orderId = $response['data']['order_id'] ?? "";

                                if(intval($orderId)){

                                    $this->add_transaction($response['data']['order_id'], __('msg.Stripe'), $intent->id ?? '', true, $intent->status, $amount);

                                    return redirect()->route('my-orders')->with('suc', __('msg.order_success'));

                                }

                            }else{

                                $error = $response['message'];
                            }
                        }else{

                            $response = $this->topup_wallet($amount, __('msg.Stripe'));

                            if($response['error'] == false){

                                return redirect()->route('wallet-history')->with('suc', __('msg.wallet_recharge_successfully'));

                            }else{

                                $error = $response['message'];
                            }

                        }

                    }else{

                        $error = "Transaction has been failed!";

                    }

                }catch(\Stripe\Exception\ApiErrorException $e){

                    $error = $e->getMessage();

                }catch(\Exception $e) {

                    $error = $e->getMessage();

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
