@include("themes.$theme.common.msg")
<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{__('msg.checkout_summary')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{__('msg.checkout_summary')}}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->
<div class="main-content">
    <section class="checkout-section ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 mb-4">
                    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded account-sidebar account-tab mb-sm-30">
                        <div class="dark-bg tab-title-bg">
                            <div class="heading-part">
                                <div class="sub-title text-center"><span></span><em class="far fa-user"></em> {{__('msg.my_account')}}
                                </div>
                            </div>
                        </div>
                        <div class="account-tab-inner">
                            <ul class="account-tab-stap">
                                <li>
                                    <a href="{{ route('cart') }}"><em class="fas fa-wallet"></em>{{__('msg.cart')}}<em class="fa fa-angle-right"></em> </a>
                                </li>
                                <li>
                                    <a href="{{ route('checkout-address') }}"><em class="fas fa-wallet"></em>{{__('msg.Address')}}<em class="fa fa-angle-right"></em> </a>
                                </li>
                                <li class="active">
                                    <a><em class="far fa-heart"></em>{{__('msg.checkout_summary')}}<em class="fa fa-angle-right"></em> </a>
                                </li>
                                <li>
                                    <a href="#"><em class="fas fa-digital-tachograph"></em>{{__('msg.payment')}}<em class="fa fa-angle-right"></em> </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 col-12">
                    <div id="data-step1" class="account-content" data-temp="tabdata">
                        <div class="cart-main-content pb-2 pb-lg-5">
                            <div class="container">
                                <div class=" outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded mb-3">
                                    <div class="section_title d-flex mb-3 align-items-baseline border-bottom">
                                        <h2>
                                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{__('msg.Order Summary')}}</span>
                                        </h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="table_description">
                                                <div class="cart_page-content">
                                                    <table aria-describedby="cart-table">
                                                        <thead>
                                                            <tr class="cart-header">
                                                                <th scope="col" class="header_product_thumb">{{__('msg.Image')}}</th>
                                                                <th scope="col" class="header_product_name">{{__('msg.product')}}</th>
                                                                <th scope="col" class="header_product-price">{{__('msg.price')}}</th>
                                                                <th scope="col" class="header_product_quantity">{{__('msg.qty')}}</th>
                                                                <th scope="col" class="header_product_total">{{__('msg.subtotal')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $ready_to_checkout = '1'; @endphp
                                                            @if(isset($data['cart']['cart']['data']) && is_array($data['cart']['cart']['data']) && count($data['cart']['cart']['data']))
                                                            @foreach($data['cart']['cart']['data'] as $p)
                                                            @if(isset($p->item[0]))

                                                            <tr>
                                                                <td class="header_product_thumb"><a href="#"><img class="lazy" data-original="{{ $p->item[0]->image }}" alt=""></a></td>
                                                                <td class="header_product_name">
                                                                    @if(isset($p->item[0]->is_item_deliverable) && ($p->item[0]->is_item_deliverable == false) && (session()->get('pincode_no') == true))
                                                                    <p class="deliver_notice">{{__('msg.This_item_is_not_deliverable_in_selected_address')}}</p>
                                                                    @php $ready_to_checkout = '0'; @endphp
                                                                    @endif
                                                                    <a href="#">{{ strtoupper($p->item[0]->name) ?? '-' }}</a>
                                                                    <p class="small text-muted text-center">{{ get_varient_name($p->item[0]) }}
                                                                        @if(intval($p->item[0]->discounted_price))
                                                                        ({{intval($p->item[0]->discounted_price)}} X {{($p->qty ?? 1)}})
                                                                        @else
                                                                        ({{intval($p->item[0]->price)}} X {{($p->qty ?? 1)}})
                                                                        @endif
                                                                        <br>{{ __('msg.tax')." (".$p->item[0]->tax_percentage  }}% {{ $p->item[0]->tax_title  }})
                                                                    </p>
                                                                </td>
                                                                <td class="header_product-price">
                                                                    @if(intval($p->item[0]->discounted_price))
                                                                    @if (isset($p->item[0]->tax_percentage) && $p->item[0]->tax_percentage > 0)
                                                                    {{ $p->item[0]->discounted_price+($p->item[0]->discounted_price*$p->item[0]->tax_percentage/100) ?? '' }}
                                                                    @else
                                                                    {{ $p->item[0]->discounted_price ?? '' }}
                                                                    @endif
                                                                    @else
                                                                    @if (isset($p->item[0]->tax_percentage) && $p->item[0]->tax_percentage > 0)
                                                                    {{ $p->item[0]->price+($p->item[0]->price*$p->item[0]->tax_percentage/100) ?? '' }}
                                                                    @else
                                                                    {{ $p->item[0]->price ?? '' }}
                                                                    @endif
                                                                    @endif
                                                                </td>
                                                                <td class="header_product_quantity">{{ $p->qty }}</td>
                                                                <td class="header_product_total">
                                                                    @if(intval($p->item[0]->discounted_price))
                                                                    @if (isset($p->item[0]->tax_percentage) && $p->item[0]->tax_percentage > 0)
                                                                    {{ ($p->item[0]->discounted_price+($p->item[0]->discounted_price*$p->item[0]->tax_percentage/100)) * ($p->qty ?? 1) }}
                                                                    @else
                                                                    {{ $p->item[0]->discounted_price * ($p->qty ?? 1) }}
                                                                    @endif
                                                                    @else
                                                                    @if (isset($p->item[0]->tax_percentage) && $p->item[0]->tax_percentage > 0)
                                                                    {{ ($p->item[0]->price+($p->item[0]->price*$p->item[0]->tax_percentage/100)) * ($p->qty ?? 1) }}
                                                                    @else
                                                                    {{ $p->item[0]->price * ($p->qty ?? 1) }}
                                                                    @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="cart_submit">
                                                    <a href="{{ route('shop') }}" class="btn cart_shopping"><em class="fas fa-angle-double-left"></em>&nbsp;&nbsp;{{__('msg.Continue Shopping')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 ">
                                            <div class="discount-code-wrapper">
                                                <div class="title-wrap">
                                                    <h4 class="cart-bottom-title section-bg-gray">{{__('msg.Use Coupon Code')}}</h4>
                                                </div>
                                                @if(intval($data['cart']['coupon'] ?? 0))
                                                <div class="form-group" id='couponAppliedDiv'>
                                                    <label class="title-sec">{{__('msg.coupon_code')}}</label>
                                                    <div class="alert alert-success">{{ $data['cart']['coupon']['promo_code_message'] }}</div>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" value="{{ $data['cart']['coupon']['promo_code'] }}" disabled="disabled" placeholder="Coupon code">
                                                        <span class="input-group-append">
                                                            <a href="{{ route('coupon-remove') }}" class="btn btn-danger" id='removeCoupon'>x</a>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="discount-code">
                                                    <p>{{__('msg.Enter your coupon code if you have one.')}}</p>
                                                    <form action="{{ route('coupon-apply') }}" method="POST" class='ajax-form {{ intval($data['cart']['coupon'] ?? 0) ? 'address-hide' : '' }}' id='couponForm'>
                                                        <input type="hidden" name="total" value="{{ $data['cart']['subtotal'] ?? '' }}">
                                                        <div class='formResponse'></div>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="coupon" value="{{ $data['cart']['coupon']['promo_code'] ?? '' }}" placeholder="Coupon code">
                                                            <input type="hidden" class="form-control" name="address_id" value="{{ $data['address']->id ?? '' }}">
                                                            <span class="input-group-append">
                                                                <button class="btn btn-primary">{{__('msg.APPLY COUPON')}}</button>
                                                            </span>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($data['data']['code_list']['data']) && is_array($data['data']['code_list']['data']) && count($data['data']['code_list']['data']))
                                        @if(isset($data['data']['code_list']['data'][0]->id))
                                        <div class="col-lg-4 col-md-4 col-12 ">
                                            <div class="discount-code-wrapper coupan__wrapper">
                                                <div class="title-wrap">
                                                    <h4 class="cart-bottom-title section-bg-gray">{{__('msg.offers')}}</h4>
                                                </div>

                                                <div class="discount-code">
                                                    <p>{{__('msg.copy_and_paste_code_in_coupan_code_to_get_exciting_discount')}}</p>

                                                    {{-- coupans --}}
                                                    @if(isset($data['data']['code_list']['data']) && is_array($data['data']['code_list']['data']) && count($data['data']['code_list']['data']))
                                                    @foreach($data['data']['code_list']['data'] as $c)
                                                    @if(isset($c->id) && !($c->is_validate[0]->error))
                                                    <div class="inner__sec_discount mb-2">
                                                        <h5 class="">{{$c->is_validate[0]->promo_code_message}}</h5>
                                                        <p class="themeclr">You will save {{$c->is_validate[0]->discount}} with this code</p>
                                                        <p class="pt-1 coupan_text">{{$c->promo_code}}</p>
                                                    </div>
                                                    @else
                                                    <div class="inner__sec_discount mb-2">
                                                        <h5 class="">{{$c->message}}</h5>
                                                        <p class="redclr">{{$c->is_validate[0]->message}}</p>
                                                        <p class="pt-1 coupan_text">{{$c->promo_code}}</p>
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        @endif
                                        @endif

                                        <div class="col-lg-4 col-md-6 col-12 ">
                                            <div class="grand-total-content">
                                                <div class="title-wrap">
                                                    <h4 class="cart-bottom-title section-bg-gary-cart">{{__('msg.Cart Total')}}</h4>
                                                </div>
                                                <h5>{{__('msg.subtotal')}} : <span>{{ get_price(sprintf("%0.2f",$data['cart']['subtotal'] ?? '-')) }}</span></h5>
                                                @if(isset($data['cart']['coupon']['discount'])  && floatval($data['cart']['coupon']['discount']))
                                                <h5>{{__('msg.discount')}} : <span>-
                                                        {{ get_price(sprintf("%0.2f",$data['cart']['coupon']['discount'])) ?? '-' }}</span>
                                                </h5>
                                                @endif
                                                @if(isset($data['cart']['cart']['saved_amount']) && floatval($data['cart']['cart']['saved_amount']))
                                                <h5>{{__('msg.saved_price')}} : <span>
                                                        {{ get_price($data['cart']['cart']['saved_amount']) }}</span>
                                                </h5>
                                                @endif

                                                @if($ready_to_checkout == '1')
                                                <a href="{{ route('checkout-payment') }}">{{__('msg.Proceed to Checkout')}}&nbsp;&nbsp;<em class="fas fa-angle-double-right"></em></a>
                                                @else
                                                <a class="checkout-dbutton">{{__('msg.checkout')}}
                                                    <em class="fas fa-angle-double-right"></em>
                                                </a>
                                                @endif
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