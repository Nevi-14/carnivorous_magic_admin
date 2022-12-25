<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class WalletController extends CartController {

    public function index() {
        request()->session()->put('wallet_topup_amount', 0);
        $limit = 12;
        $page = request()->page??0;

        $user = $this->post('get-user', ['data' => ['get_user_data' => 1, 'user_id' => session()
            ->get('user') ['user_id']]]);

        $list = $this->post('wallet-history', ['data' => ['get_user_transactions' => 1, api_param('user-id') => session()
            ->get('user') ['user_id'], 'type' => 'wallet_transactions', 'limit' => $limit, 'offset' => ($page * $limit) ], 'data_param' => '']);

        $data = $this->pagination($list, "wallet-history", $page, $limit);

        \extract($data);

        $balance = $user['data'][0]->balance;

        $this->html('user.wallet-history', ['title' => __('msg.wallet_history') , 'list' => $list, 'limit' => $limit, 'total' => $total, 'next' => $nextPage, 'last' => $lastPage, 'balance' => $balance]);
    }

    public function topup(Request $request){
        $request->session()->put('wallet_topup_amount', $request->wallet_amount);
        $request->session()->put('wallet_topup_message', $request->wallet_message);

        switch ($request->payment_method){
            case 'razorpay': // Done
                return redirect()->route('checkout-razorpay-init');
                break;

            case 'payumoney-bolt':
                return redirect()->route('checkout-payu-init-bolt');
                break;
            case 'paypal': // Done
                return redirect()->route('checkout-paypal-init');
                break;
            case 'stripe': // Done
                return redirect()->route('payment-stripe-start');
                break;
            case 'midtrans': // https://prnt.sc/1rwwb0l
                return redirect()->route('payment-midtrans-start');
                break;
            case 'flutterwave': // Done
                return redirect()->route('payment-flutterwave-start');
                break;
            case 'paystack': // Done
                return redirect()->route('payment-paystack-start');
                break;
            case 'paytm':
                return redirect()->route('checkout-paytm-init');
                break;
            case 'sslecommerz':
                return redirect()->route('checkout-sslecommerz-init');
                break;
            default:
                return redirect()->route('wallet-history')->with('err', msg('select_payment_method'));

        }

    }

}
