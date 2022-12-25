<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{__('msg.checkout_payment')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{__('msg.checkout_payment')}}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->
<div class="main-content payment__Sec">
    <section class="checkout-section ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 mb-4">
                    <div class="px-2 py-4 px-md-4 py-md-3 rounded bg-white px-2 py-4 px-md-4 py-md-3 rounded shadow rounded account-sidebar account-tab mb-sm-30">
                        <div class="dark-bg tab-title-bg">
                            <div class="heading-part">
                                <div class="sub-title text-center"><span></span><em class="far fa-user"></em>{{__('msg.my_account')}}</div>
                            </div>
                        </div>
                        <div class="account-tab-inner">
                            <ul class="account-tab-stap">
                                <li>
                                    <a href="{{ route('checkout') }}"><em class="fas fa-wallet"></em>{{__('msg.checkout_summary')}}<i class="fa fa-angle-right"></i> </a>
                                </li>
                                <li>
                                    <a href="{{ route('checkout-address') }}"><em class="far fa-heart"></em>{{__('msg.address')}}<i class="fa fa-angle-right"></i> </a>
                                </li>
                                <li class="active">
                                    <a href="#"><em class="fas fa-digital-tachograph"></em>{{__('msg.payment')}}<i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 col-12">
                    <div id="data-step1" class="" data-temp="tabdata">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 back-bg">
                                <div class="row bg-white py-md-3 rounded shadow my-2 mt-md-0 px-md-4" id="balance">
                                    <div class="custom-control title-sec custom-checkbox mb-1">
                                        <div class="section_title d-flex mb-3 align-items-baseline border-bottom pl-0">
                                            <div class="section_title d-flex  align-items-baseline border-bottom pl-0">
                                                <h3>
                                                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{__('msg.address')}}</span>
                                                </h3>
                                            </div>
                                        </div>

                                        <label class="custom-control-label" for="wallet">{{$data['selected_address']}}</label>
                                    </div>
                                </div>
                                @if(isset(Cache::get('timeslot')->slots) && count(Cache::get('timeslot')->slots))
                                <form class=" full">
                                    <div class="mb-10">

                                        <div class="row bg-white px-2 py-4 px-md-4 py-md-3 rounded shadow">
                                            <div class="section_title d-flex mb-3 align-items-baseline border-bottom pl-0">
                                                <h3>
                                                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{__('msg.select_delivery_day')}}</span>
                                                </h3>
                                            </div>

                                            <table class="table table-borderless table-shopping-cart" aria-describedby="myDec" aria-hidden="true">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="alert alert-danger" id="dateError">{{__('msg.select_suitable_delivery_date')}}</div>
                                                            </div>
                                                            <div class="col-md-12 col-xl-12 col-12">
                                                                <div class="form-group calender w-100">
                                                                    <div id="calendar">
                                                                        <div id="datepicker" data-start='{{ Cache::get('delivery_starts_from', 0) }}' data-end='{{ Cache::get('allowed_days', 0) }}'></div>
                                                                        <em class="calender-icon fa fa-calendar-o"></em>
                                                                        <span id='deliveryDatePrint'></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row bg-white px-2 py-4 px-md-4 py-md-3 rounded shadow">
                                        <div class="section_title d-flex mb-3 align-items-baseline border-bottom pl-0">
                                            <h3>
                                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{__('msg.select_delivery_time')}}</span>
                                            </h3>
                                        </div>

                                        <table class="table table-borderless table-shopping-cart"
                                               aria-describedby="myDec3" aria-hidden="true">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="alert alert-danger" id="timeError">{{__('select_payment_suitable_delivery_time')}}</div>
                                                        </div>
                                                        <div class="form-group" id="time">
                                                            @foreach(Cache::get('timeslot')->slots as $slot)
                                                            @if($slot->status == 1)
                                                            <div class="col-md-12">
                                                                <div class="custom-control custom-radio mb-3">
                                                                    <input name="deliverTime" type="radio"
                                                                           class="custom-control-input"
                                                                           value="{{ $slot->title }}"
                                                                           data-from="{{ $slot->from_time }}"
                                                                           data-to="{{ $slot->to_time }}"
                                                                           data-last="{{ $slot->last_order_time }}">
                                                                    <label class="custom-control-label">{{ $slot->title }}</label>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </form>
                                @endif
                            </div>


                            <div class=" col-xl-5 col-lg-12 back-bg1 col-xl-offset-1 col-12">

                                <div class="bg-white px-2 py-4 px-md-4 py-md-3 rounded shadow my-2 mt-md-0" id="balance">

                                    <div class="custom-control title-sec custom-checkbox mb-1">
                                        <input type="checkbox" class="custom-control-input" id="wallet" data-amount='{{ $data['user']['data'][0]->balance ?? '0' }}' />
                                        <label class="custom-control-label" for="wallet">{{__('msg.wallet_balance')}}</label>
                                    </div>
                                    <small class="text-muted custom-control">{{__('msg.total_balance')}}: {{ get_price($data['user']['data'][0]->balance ?? '0', false) }}</small>

                                </div>

                                <div class="order-area-content1 bg-white px-2 py-4 px-md-4 py-md-3 rounded shadow">

                                    <h3>{{__('msg.your_order')}}</h3>
                                    <div class="order-wrap-content">
                                        <div class="order-product-info">
                                            <div class="order-middle-content">
                                                <ul>
                                                    <li>
                                                        <span class="order-middle-left">{{__('msg.subtotal')}}</span>
                                                        <span class="order-price">{{ get_price(sprintf("%0.2f",$data['subtotal']))?? '-' }}</span>
                                                    </li>
                                                    @if(session()->has('pincode_no'))
                                                    @if(isset($data['shipping']) && floatval($data['shipping']))
                                                    <li>
                                                        <span class="order-middle-left">{{__('msg.delivery_charge')}}</span>
                                                        <span class="order-price local_shipping">+ {{ get_price(sprintf("%0.2f",$data['shipping'])) }}</span>
                                                    </li>
                                                    @endif
                                                    @else
                                                    @if(isset($data['delivery_charge']) && floatval($data['delivery_charge']))
                                                    <li>
                                                        <span class="order-middle-left">{{__('msg.delivery_charge')}}</span>
                                                        <span class="order-price standard_shipping">+ {{ get_price(sprintf("%0.2f",$data['delivery_charge'])) }}</span>
                                                    </li>
                                                    @endif
                                                    @endif

                                                    @if(isset($data['coupon']['discount']) && floatval($data['coupon']['discount']))
                                                    <li><span class="order-middle-left">{{__('msg.discount')}} </span>
                                                        <span class="order-price">- {{ get_price(sprintf("%0.2f",$data['coupon']['discount'])) }} </span>
                                                        <span class="order-price promo_code_discount hide">{{ $data['coupon']['discount'] }} </span>
                                                    </li>
                                                    @endif

                                                    
                                                </ul>
                                            </div>
                                            <div class="order-bottom-content">
                                                <ul>
                                                    <li class="order-shipping">{{__('msg.total')}}</li>
                                                    @if(session()->has('pincode_no'))
                                                    <li class="order-shipping">{{ get_price(sprintf("%0.2f",$data['total']))?? '-' }}</li>
                                                    @else
                                                    <li class="order-shipping total_amount">{{ get_price(sprintf("%0.2f",$data['total']))?? '-' }}</li>
                                                    @endif
                                                </ul>
                                                @if(isset($data['cart']['cart']['saved_amount']) && floatval($data['cart']['cart']['saved_amount']))
                                                <ul>
                                                    <li class="order">{{__('msg.saved_price')}}</li>
                                                    <li class="order">{{ get_price(sprintf("%0.2f",$data['cart']['cart']['saved_amount']))?? '-' }}</li>
                                                </ul>
                                                @endif
                                                
                                            </div>
                                            <h4 class="my-3">{{__('msg.payment_method')}}</h4>
                                            <div class="d-block my-3">
                                                <div class="row">
                                                    @if(isset(Cache::get('payment_methods')->cod_payment_method) &&
                                                    Cache::get('payment_methods')->cod_payment_method == 1)
                                                    @php 
                                                    $ready_to_checkout = '1'; 
                                                    $is_cod_allowed = '1'; 
                                                    session()->put('is_cod_allowed', $is_cod_allowed);
                                                    @endphp
                                                    @if(isset($data['cart']['cart']['data']) && is_array($data['cart']['cart']['data']) && count($data['cart']['cart']['data']))
                                                    @foreach($data['cart']['cart']['data'] as $p)
                                                    @if(isset($p->item[0]) && isset($p->item[0]->cod_allowed) && ($p->item[0]->cod_allowed == '0'))
                                                    @php 
                                                    $is_cod_allowed = '0';
                                                    session()->put('is_cod_allowed', $is_cod_allowed);
                                                    @endphp
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    @if(session()->get('is_cod_allowed') == '1' )
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio" class="custom-control-input" value="cod" checked>
                                                            <img src="{{URL::asset('images/cod.svg')}}" alt="cod" class="payment__icon">
                                                            <label class="custom-control-label">{{__('msg.cash_on_delivery')}}</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endif
                                                    @if(isset(Cache::get('payment_methods')->paypal_payment_method) &&
                                                    Cache::get('payment_methods')->paypal_payment_method == 1)
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio" class="custom-control-input" value="paypal">
                                                            <img src="{{URL::asset('images/paypal.svg')}}" alt="paypal" class="payment__icon">
                                                            <label class="custom-control-label">{{__('msg.paypal')}}</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if(isset(Cache::get('payment_methods')->payumoney_payment_method)
                                                    && Cache::get('payment_methods')->payumoney_payment_method == 1)
                                                    <div class="col-md-12">

                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio" class="custom-control-input" value="payumoney-bolt">
                                                            <img src="{{URL::asset('images/payu.svg')}}" alt="payumoney-bolt" class="payment__icon">
                                                            <label class="custom-control-label">{{__('msg.PayUMoney')}}</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if(isset(Cache::get('payment_methods')->razorpay_payment_method) &&
                                                    Cache::get('payment_methods')->razorpay_payment_method == 1)
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio" class="custom-control-input" value="razorpay">
                                                            <img src="{{URL::asset('images/rozerpay.svg')}}" alt="rozerpay" class="payment__icon">
                                                            <label class="custom-control-label">{{__('msg.Razorpay')}}</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if(isset(Cache::get('payment_methods')->stripe_payment_method) &&
                                                    Cache::get('payment_methods')->stripe_payment_method == 1)
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio" class="custom-control-input" value="stripe">
                                                            <img src="{{URL::asset('images/stripe.svg')}}" alt="cod" class="payment__icon">
                                                            <label class="custom-control-label">{{__('msg.Stripe')}}</label>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if(isset(Cache::get('payment_methods')->flutterwave_payment_method)
                                                    && Cache::get('payment_methods')->flutterwave_payment_method == 1)
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio" class="custom-control-input" value="flutterwave">
                                                            <img src="{{URL::asset('images/flutterwave.svg')}}" alt="flutterwave" class="payment__icon">
                                                            <label class="custom-control-label">{{__('msg.flutterwave')}}</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if(isset(Cache::get('payment_methods')->paystack_payment_method) &&
                                                    Cache::get('payment_methods')->paystack_payment_method == 1)
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio" class="custom-control-input" value="paystack">
                                                            <img src="{{URL::asset('images/paystack.svg')}}" alt="paystack" class="payment__icon">
                                                            <label class="custom-control-label">{{__('msg.paystack')}}</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if(isset(Cache::get('payment_methods')->paytm_payment_method) &&
                                                    Cache::get('payment_methods')->paytm_payment_method == 1)
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio" class="custom-control-input" value="paytm">
                                                            <img src="{{URL::asset('images/paytm.svg')}}" alt="paytm" class="payment__icon">
                                                            <label class="custom-control-label">{{__('msg.paytm')}}</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if (isset(Cache::get('payment_methods')->ssl_commerce_payment_method) && Cache::get('payment_methods')->ssl_commerce_payment_method == 1)
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio"
                                                                   class="custom-control-input"
                                                                   value="sslecommerz">
                                                            <img src="{{URL::asset('images/sslecommerz.svg')}}" alt="sslecommerz" class="payment__icon">
                                                            <label
                                                                class="custom-control-label">{{ __('msg.SSLECOMMERZ') }}</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if (isset(Cache::get('payment_methods')->direct_bank_transfer_method) && Cache::get('payment_methods')->direct_bank_transfer_method == 1)
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="payment_method" type="radio" class="custom-control-input" value="bank_transfer">
                                                            <img src="{{URL::asset('images/banktransfer.svg')}}" alt="banktransfer" class="payment__icon">
                                                            <label
                                                                class="custom-control-label">{{ __('msg.bank_transfer') }}</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a role="button" data-bs-confirm="Confirm Order Amount">
                                        <button id='proceed' class="btn btn-primary text-uppercase add-to-cart d-block m-auto">
                                            {{__('msg.procced')}} <em class="fas fa-truck pl-2"></em>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="alert alert-warning col-lg-11 mt-10 bank_transfer_warning">
                                <p><strong>{{__('msg.Instruction')}} <br></strong> {{__('msg.bank_detail_instruction1')}}<br/>{{__('msg.bank_detail_instruction2')}}</p>
                            </div>
                            <!-- The Modal -->
                            <div id="orderConfirm" class="modal">
                                <div class="modal-dialog">
                                    <div class="modal-content px-3">
                                        <div class="modal-header">
                                            <p class="font-weight-bold mb-0">{{__('msg.confirm_order_amount')}}</p>
                                            <button type="button" class="close rtl_close_inner" data-bs-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <tr>
                                                <td>
                                                    <p class="product-name pb-1">{{__('msg.subtotal')}} :
                                                        <span>{{ get_price($data['subtotal']) ?? '-' }}</span></p>
                                                        @if(session()->has('pincode_no'))
                                                    @if(isset($data['shipping']) && floatval($data['shipping']))
                                                    <p class="product-name pb-1">{{__('msg.delivery_charge')}} : <span>+
                                                            {{ get_price($data['shipping']) }}</span></p>
                                                    @endif
                                                    @else
                                                    @if(isset($data['delivery_charge']) && floatval($data['delivery_charge']))
                                                    <p class="product-name pb-1">{{__('msg.delivery_charge')}} : <span class="standard_shipping">+
                                                            {{ get_price($data['delivery_charge']) }}</span></p>
                                                    @endif
                                                    @endif
                                                    @if(isset($data['coupon']['discount']) && floatval($data['coupon']['discount']))
                                                    <p class="product-name pb-1">{{__('msg.discount')}} : <span>-
                                                            {{ get_price($data['coupon']['discount']) }}</span></p>
                                                    @endif
                                                    @if(session()->has('pincode_no'))
                                                    <p class="product-name pb-1">{{__('msg.total')}} : <span> {{ $data['total'] }}</span>
                                                        @else
                                                    <p class="product-name pb-1">{{__('msg.total')}} : <span class="total_amount"> {{ get_price($data['total'])}}</span>
                                                        @endif
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr class="text-left">
                                                <td>
                                                    <strong>
                                                        <p class="checkout-total walletNotUsed pb-1">{{ __('msg.final_total')}} :
                                                            @if(session()->has('pincode_no'))
                                                            <span class="">{{ get_price($data['total']) }}</span>
                                                        @else
                                                        <span class="finaltotalamount_walletnotused">{{ get_price($data['total']) }}</span></p>
                                                        @endif

                                                        @if(intval($data['user']['data'][0]->balance ?? 0))
                                                        @if(floatval($data['user']['data'][0]->balance) > floatval($data['total']))
                                                        @if(session()->has('pincode_no'))
                                                        <p class="product-name walletUsed pb-1">{{__('msg.wallet_from')}} :
                                                            <span>{{ floatval($data['total']) }}</span></p>
                                                        <p class="checkout-total walletUsed">{{__('msg.total_payable')}} :
                                                            <span>0</span><input type="hidden" value="0" name="total_payable"></p>
                                                        @else
                                                        <p class="product-name walletUsed pb-1">{{__('msg.wallet_from')}} :
                                                            <span>{{ get_price($data['total']) }}</span></p>
                                                        <p class="checkout-total walletUsed">{{__('msg.total_payable')}} :
                                                            <span class="standard_shipping">{{ $data['delivery_charge'] }}</span><input type="hidden" value="{{ $data['delivery_charge'] }}" name="total_payable" class="standard_shipping"></p>
                                                        @endif

                                                        @else
                                                        <p class="product-name walletUsed pb-1">{{__('msg.wallet_from')}} :
                                                            <span>-{{ $data['user']['data'][0]->balance ?? '0' }}</span></p>
                                                        <p class="checkout-total walletUsed pb-1">{{__('msg.total_payable')}} :
                                                            @if(session()->has('pincode_no'))
                                                            <span class="">{{ floatval($data['total']) - floatval($data['user']['data'][0]->balance) }}</span>
                                                            <input type="hidden" value="{{ floatval($data['total']) - floatval($data['user']['data'][0]->balance) }}" name="total_payable">
                                                            @else
                                                            <span class="finaltotalamount_walletused">{{ (floatval($data['total']) - floatval($data['user']['data'][0]->balance)) + $data['delivery_charge'] }}</span>
                                                            <input  type="hidden" value="{{ (floatval($data['total']) - floatval($data['user']['data'][0]->balance)) + $data['delivery_charge'] }}" name="total_payable">
                                                            @endif
                                                        </p>
                                                        @endif
                                                        @endif
                                                    </strong>
                                                </td>
                                            </tr>

                                            <div class="cancel_confirm d-flex align-items-center">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('msg.cancel')}}</button>
                                                <form action="{{ route('checkout-proceed') }}" method="POST" class="paybtn">
                                                    <input type="hidden" name="deliverDay" id="date" class="deliveryDate">
                                                    <input type="hidden" name="deliveryTime" class="deliveryTime">
                                                    <input type="hidden" name="paymentMethod">
                                                    <input type="hidden" name="wallet_used" value="false">
                                                    @if(intval($data['user']['data'][0]->balance ?? 0))
                                                    @if(floatval($data['user']['data'][0]->balance) > floatval($data['total']))
                                                    <input type="hidden" name="wallet_balance" value="{{ floatval($data['total']) }}">
                                                    @else
                                                    <input type="hidden" name="wallet_balance" value="{{ floatval($data['user']['data'][0]->balance) }}">
                                                    @endif
                                                    @else
                                                    <input type="hidden" name="wallet_balance" value="0">
                                                    @endif
                                                    <button type="submit" name="submit" value="submit" class="btn btn-primary ml-2">{{__('msg.confirm')}}</button>
                                                </form>
                                                <form action="{{ route('checkout-sslecommerz-init') }}" method="POST" class="sslbuttons">
                                                    <div class="Place-order">
                                                        <button class="btn" id="sslczPayBtn"
                                                                token="if you have any token validation"
                                                                postdata="your javascript arrays or objects which requires in backend"
                                                                order="test time"> Pay Now</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"),
                    tag = document.getElementsByTagName("script")[0];
            script.src = "{{ asset('js/payment-gateway-sslcommerz.js') }}?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };
        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>
<script src="{{ asset('js/checkout-payment.js') }}"></script>
