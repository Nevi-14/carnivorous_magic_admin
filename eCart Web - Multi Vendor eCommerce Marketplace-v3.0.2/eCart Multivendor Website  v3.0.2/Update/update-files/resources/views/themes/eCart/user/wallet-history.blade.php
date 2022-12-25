<section class="padding-bottom footerfix section-content pb-3 wallet_history">
    <a href="#" id="scroll"><span></span></a>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="bg-white shadow mb-4 p-3">
                    <p>Your Balance : {{ get_price($data['balance'], false) }}</p>
                    <a role="button" data-bs-confirm="Confirm Order Amount" data-bs-toggle="modal" data-bs-target=".wallet_recharge_modal">
                        <button id='proceed1' class="btn btn-primary add-to-cart" >
                            {{__('msg.recharge_your_wallet')}} <em class="fa fa-arrow-right"></em>
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div id="orderConfirm" class="modal wallet_recharge_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        {{__('msg.recharge_your_wallet')}}
                        <div class=" mb-0 mr-4 row">
                            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <tr class="mr-5">
                                <td>
                                    <form method="POST" action='{{ route('wallet-topup') }}'>
                                        <div class="form-row">
                                            <div class="col form-group">
                                                <label>Amount</label>
                                                <input type="number" name="wallet_amount" class="form-control" required>
                                            </div>
                                        </div>
                                        <h5 class="card-title title-sec ml-3 mt-3" id="myDec2">{{__('msg.payment_method')}}</h5>

                                        <div class="form-group">
                                            <div class="alert alert-danger" id="paymentError">{{__('msg.select_payment_method')}}</div>
                                        </div>
                                        <div class="d-block my-3">
                                            <div class="row">
                                            @if(isset(Cache::get('payment_methods')->paypal_payment_method) && Cache::get('payment_methods')->paypal_payment_method == 1)
                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="paypal" name='payment_method'>
                                                <span class="custom-control-label"> {{__('msg.paypal')}}</span>
                                            </label>
                                            @endif
                                            @if(isset(Cache::get('payment_methods')->payumoney_payment_method) && Cache::get('payment_methods')->payumoney_payment_method == 1)

                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="payumoney-bolt" name='payment_method'>
                                                <span class="custom-control-label"> {{__('msg.PayUMoney')}}</span>
                                            </label>
                                            @endif
                                            @if(isset(Cache::get('payment_methods')->razorpay_payment_method) && Cache::get('payment_methods')->razorpay_payment_method == 1)
                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="razorpay" name='payment_method'>
                                                <span class="custom-control-label"> {{__('msg.Razorpay')}}</span>
                                            </label>
                                            @endif
                                            @if(isset(Cache::get('payment_methods')->stripe_payment_method) && Cache::get('payment_methods')->stripe_payment_method == 1)
                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="stripe" name='payment_method'>
                                                <span class="custom-control-label"> {{__('msg.Stripe')}}</span>
                                            </label>
                                            @endif

                                            @if(isset(Cache::get('payment_methods')->flutterwave_payment_method) && Cache::get('payment_methods')->flutterwave_payment_method == 1)
                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="flutterwave" name='payment_method'>
                                                <span class="custom-control-label"> {{__('msg.flutterwave')}}</span>
                                            </label>
                                            @endif
                                            @if(isset(Cache::get('payment_methods')->paystack_payment_method) && Cache::get('payment_methods')->paystack_payment_method == 1)
                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="paystack" name='payment_method'>
                                                <span class="custom-control-label"> {{__('msg.paystack')}}</span>
                                            </label>
                                            @endif
                                            @if(isset(Cache::get('payment_methods')->paytm_payment_method) && Cache::get('payment_methods')->paytm_payment_method == 1)
                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="paytm" name='payment_method'>
                                                <span class="custom-control-label"> {{__('msg.paytm')}}</span>
                                            </label>
                                            @endif
                                            @if (isset(Cache::get('payment_methods')->ssl_commerce_payment_method) && Cache::get('payment_methods')->ssl_commerce_payment_method == 1)
                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="sslecommerz" name='payment_method'>
                                                <span class="custom-control-label"> {{__('msg.SSLECOMMERZ')}}</span>
                                            </label>
                                            @endif
                                        </div>
                                        </div>
                                        <div class="form-group paybtn">
                                            <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block">{{__('msg.recharge')}} </button>
                                        </div>
                                        <div class="form-group sslbuttons">
                                            <form action="{{ route('checkout-sslecommerz-init') }}" method="POST" class="sslbuttons">
                                                <div class="Place-order mt-25">
                                                    <button class="" id="sslczPayBtn"
                                                            token="if you have any token validation"
                                                            postdata="your javascript arrays or objects which requires in backend"
                                                            order="test time"> Pay Now</button>
                                                </div>
                                            </form>

                                        </div>
                                    </form>
                                </td>
                            </tr>

                        </div>
                        <div class="row add-to-fav1 mr-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>

            @if(isset($data['list']) && isset($data['list']['data']) && count($data['list']['data']))
            <div class="row">
            @foreach($data['list']['data'] as $w)
                <div class="col-md-4 col-12">
                    <div class="bg-white shadow mb-4 p-3">
                        <div class="d-flex my-2">
                            <div class="ml-2 form-group walletid col"><span class="font-weight-bold">{{__('msg.id')}} #{{ $w->id }}</span></div>
                            <div class="mr-5 form-group">
                                <div class="wallet-header">
                                    <button class="btn btn-sm btn-{{ ($w->type == 'debit') ? 'danger' : 'success' }}">{{ strtoupper($w->type) }}</button>
                                </div>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="wallet__history_data mt-2">
                            <a class="add-to-fav1 name d-block">{{__('msg.amount')}} : {{ get_price($w->amount, false) }}</a>
                            <span class="text-muted mt-0">
                                {{__('msg.date_and_time')}}
                            </span>

                            <p href="#" class="card-title product-name">{{ date('d-M-Y H:i A', strtotime($w->date_created)) }}</p>
                            <span class="text-muted mb-0">{{__('msg.message')}}</span>
                            <p class="text-dark mb-0">
                                <span class="product-name">{{ $w->message }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else

        <div class="row text-center px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
            <div class="col-12 d-flex justify-content-center align-items-center my-3">
                <br><br>
                <h3>{{__('msg.no_wallet_history_found')}}</h3>
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center my-3">
                <br><br>
                <a href="{{ route('shop') }}" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em> {{__('msg.continue_shopping')}}</a>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col">
                @if(isset($data['last']) && $data['last'] != "")
                <a href="{{ $data['last'] }}" class="btn btn-primary pull-left text-white"><em class="fa fa-arrow-left"></em> {{__('msg.previous')}}</a>
                @endif
            </div>
            <div class="col favnext text-end">
                @if(isset($data['next']) && $data['next'] != "")
                <a href="{{ $data['next'] }}" class="btn btn-primary pull-right text-white">{{__('msg.next')}} <em class="fa fa-arrow-right"></em></a>
                @endif
            </div>
        </div>
    </div>
</section>
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"),
                    tag = document.getElementsByTagName("script")[0];
            script.src = "{{ asset('js/payment-gateway-sslcommerz.js') }}?" + Math.random().toString(36).substring(
                    7);
            tag.parentNode.insertBefore(script, tag);
        };
        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
                loader);

    })(window, document);
</script>
<script src="{{ asset('js/checkout-payment.js') }}"></script>
