<!DOCTYPE html>
<!--v3.0.2 -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <link rel="icon" type="image/x-icon" href="{{ _asset(Cache::get('favicon', 'images/favicon.ico')) }}" />
        <title>
            {{ ((isset($data['title']) && trim($data['title']) != "") ? $data['title']." | " : ''). Cache::get('app_name', get('name')) }}
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="cache-control" content="max-age=604800" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="WRTeam">
        <meta name="keywords" content="{{ Cache::get('common_meta_keywords', '') }}">
        <meta name="description" content="{{ Cache::get('common_meta_description', '') }}">
        <meta property="og:image:width" content="450"/>
        <meta property="og:image:height" content="298"/>

        <!-- fontaweosme icon common-->
        <link href="{{ theme('fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />


        <!-- this for gulp if you dont know about that then dont change it or not uncomment it-->
        <!-- ****************************** gulp start **************************************** -->

        <!-- ltr gulp -->
        <!-- <link href="{{ theme('css/bundle.css') }}" rel="stylesheet" type="text/css" /> -->

        <!-- rtl gulp -->
        <!-- <link href="{{ theme('css/rtlbundle.css') }}" rel="stylesheet" type="text/css" />-->

        <!-- headerbundle gulp -->
        <!--<script src="{{ theme('js/headerbundle.js') }}"></script>-->

        <!-- ****************************** gulp end **************************************** -->


        <link href="{{ theme('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/semantic.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/plugin.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/owl-carousel.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/calender.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/spectrum.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- rtl -->
        <!-- <link href="{{ theme('css/bootstrap.rtl.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/rtlcustom.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/rtlintlTelInput.css') }}" rel="stylesheet" type="text/css" /> -->

        <link href="{{ theme('css/sweetalert.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/intlTelInput.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/animate.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/custom.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ theme('css/sweetalert.min.css') }}" rel="stylesheet" >
        <link href="{{ theme('css/alertify.min.css') }}" rel="stylesheet" type="text/css" />

        <script src="{{ theme('js/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ theme('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ theme('js/jquery-ui.min.js') }}"></script>
        <script src="{{ theme('js/intlTelInput.js') }}"></script>
        <script src="{{ theme('js/alertify.min.js') }}"></script>
        <script src="{{ theme('js/sweetalert.min.js') }}"></script>

    <style>
        :root {
            --buttons: {{Cache::get('color', '')}};
            --a-hover:{{Cache::get('color', '')}};
        }
    </style>

    <script>
        var home = "{{ get('home_url') }}";
        var suc_msg = "{{ Session::get('suc') }}";
        var err_msg = "{{ Session::get('err') }}";
        var error_code = "{{ Session::get('error_code') }}";
        var msg = {!! json_encode(__('msg'), JSON_HEX_TAG) !!};
        var deactivate_user = "{{ $user->status ??''}}";
        var user_id = "{{ $user->user_id ??''}}";
    </script>

</head>

<body>
    <div id="wrapper">
        <a href="#" id="return-to-top" class="shadow"><em class="fas fa-chevron-up"></em></a>

        <div class="loader">
            <img src="{{ _asset(Cache::get('loading')) }}" alt="preloader">
        </div>

        <!--header area start-->

        <!--offcanvas mobile menu area start-->
        <div class="mobile_overlay"></div>
        <div class="mobile_menu">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="mobile_canvas_open">
                            <a href="javascript:void(0)"><em class="fas fa-bars"></em></a>
                        </div>
                        <div class="mobile_wrapper">
                            <div class="mobile_canvas_close">
                                <a href="javascript:void(0)"><em class="fas fa-times"></em></a>
                            </div>
                            @if(Cache::has('social_media') && is_array(Cache::get('social_media')) && count(Cache::get('social_media')))
                            <div class="header_social_icon text-end">
                                <ul>
                                    @foreach(Cache::get('social_media') as $i => $c)
                                    <li><a href="{{ $c->link }}" target="_blank"><em class="fab {{ $c->icon }}"></em></a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if(trim(Cache::get('support_number', '')) != '')
                            <div class="connect-with-us">
                                <p><a href="#">{{Cache::get('support_number')}}</a>
                                    {{__('msg.customer_support')}}
                                </p>
                            </div>
                            @endif
                            <div id="menu" class="text-left ">
                                <ul class="offcanvas_main_menu">
                                    <li class="menu-item-has-children active">
                                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="{{ route('shop') }}">{{__('msg.shop')}}</a>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">{{__('msg.more')}} </a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('about') }}">{{__('msg.about us')}}</a></li>
                                            <li><a href="{{ route('page', 'faq') }}">{{__('msg.faq')}}</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="{{ route('contact') }}"> {{__('msg.contact us')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-12">
                                <p class="text-center"><a href="#"><em class="fas fa-envelope"></em>
                                        {{Cache::get('support_email')}}</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--offcanvas menu area end-->

        <header>
            <div class="main_header sticky-header">
                <div class="middle_content ">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-lg-2 col-md-3 col-sm-3 col-12">
                                <div class="logo">
                                    <a href="{{ route('home') }}"><img src="{{ _asset(Cache::get('web_logo')) }}" alt="logo"></a>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-7 col-12">
                                <div class="content_right_info">
                                    <div class="col d-flex justify-content-center pin__code">
                                        @if(isset($data['carticon']) && $data['carticon'] == 0 )
                                            <button type="button" class="btn hide" data-bs-toggle="modal" data-bs-target="#pincodeModal">
                                                <em class="fas fa-map-marker-alt">&nbsp;{{__('msg.deliver to')}} {{ session()->get('pincode_no')??'All' }}</em>
                                            </button>
                                            @else
                                            @if(Cache::get('local_shipping')=='1')
                                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#pincodeModal">
                                                <em class="fas fa-map-marker-alt">&nbsp;{{__('msg.deliver to')}} {{ session()->get('pincode_no')??'All' }}</em>
                                            </button>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="col-8 justify-content-center mobile_screen_none">
                                        <div class="searchbar_content">
                                            <form action="{{ route('shop') }}">
                                                <div class="category_hover_content">
                                                    @php
                                                    $categories = Cache::get('categories', []);
                                                    @endphp
                                                    <select class="" name="category">
                                                        @php
                                                            if(isset($_GET['category'])){
                                                                echo '<option selected>'.$_GET['category'].'</option>';
                                                            }
                                                        @endphp
                                                        <option>{{__('msg.all_categories')}}</option>
                                                        @foreach($categories as $i => $c)
                                                        <option value="{{ $c->slug }}">{{ $c->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="search-box">
                                                    <input placeholder="Search product..." value="{{ isset($_GET['s']) ? trim($_GET['s']) : ''}}" name="s" type="text" class="typeahead" autocomplete="off" id="search">
                                                    <button type="submit"><em class="fas fa-search"></em></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="header_account_area">
                                            <div class="header_account_list register login-sec">
                                                @if(isLoggedIn())
                                                <ul>
                                                    <li>
                                                        <a class="profile__name">{{__('msg.hello')}} {{ strlen($user->name) > 10 ? substr($user->name,0,10)."..." : $user->name }} <em class="fas fa-chevron-down fa-xs"></em></a>
                                                        <ul class="sub_menu myaccount">
                                                            <li>
                                                                <a href="{{ route('my-account') }}" >
                                                                    <span class="my-profile-img"><img class="lazy" data-original="{{ $user->profile }}" alt="profile"></span>
                                                                    <span class="side-menu account-profile ">{{__('msg.my_profile')}}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('change-password') }}"><em class="fas fa-key"></em>
                                                                    <span class="side-menu">{{__('msg.change_password')}}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('my-orders') }}"><em class="far fa-list-alt"></em>
                                                                    <span class="side-menu">{{__('msg.my_orders')}}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('wallet-history') }}"><em class="far fa-list-alt"></em>
                                                                    <span class="side-menu">{{__('msg.wallet_history')}}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('notification') }}"><em class="fa fa-bell"></em>
                                                                    <span class="side-menu">{{__('msg.notifications')}}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('favourite') }}"><em class="fa fa-heart"></em>
                                                                    <span class="side-menu">{{__('msg.favourite')}}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('transaction-history') }}"><em class="fa fa-outdent"></em>
                                                                    <span class="side-menu">{{__('msg.transaction_history')}}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('refer-earn') }}"><em class="fas fa-rupee-sign"></em>
                                                                    <span class="side-menu">{{ __('msg.refer_and_earn') }}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('addresses') }}"><em class="fa fa-wrench"></em>
                                                                    <span class="side-menu">{{__('msg.manage_addresses')}}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('logout') }}"><em class="fa fa-sign-out-alt"></em>
                                                                    <span class="side-menu">{{__('msg.logout')}}</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                                @else

                                                    <a data-bs-toggle="modal" data-bs-target="#myModal" data-tab="login"><em class="far fa-user "></em></a>

                                                @endif
                                            </div>
                                            <div class="header_account_list header_wishlist">
                                                <a href="{{ route('favourite') }}"><em class="far fa-heart"></em></a>
                                            </div>
                                            @if(isLoggedIn() && isset($data['cart']['cart']) && is_array($data['cart']['cart']) && count($data['cart']['cart']))
                                            @if(isset($data['carticon']) && $data['carticon'] == 0 )
                                            <div class="header_account_list ">
                                                @else
                                                <div class="header_account_list  mini_cart_wrapper">
                                                    @endif
                                                    @else
                                                    <div class="header_account_list mini_cart_wrapper" id="mini_cart_wrapper_ajax">
                                                        @endif
                                                        <a href="#"><em class="fab fa-opencart "></em>
                                                            <span class="cart_count">
                                                                @if(isset($data['cart']['cart']['data']) && is_array($data['cart']['cart']['data']) && count($data['cart']['cart']['data']))
                                                                @if(isset($data['carticon']) && $data['carticon'] == 0 )
                                                                <span class="hide"></span>
                                                                @else
                                                                <span class="item_count" id="item_count">{{ $data['cart']['cart']['total']}}</span>
                                                                @endif
                                                                @endif
                                                            </span>
                                                        </a>
                                                        <div class="mini_cart">
                                                            <span class="mini_cart_close">
                                                                <a href="#"><em class="fas fa-times"></em></a>
                                                            </span>
                                                            @if(isset($data['cart']['cart']) && is_array($data['cart']['cart']) && count($data['cart']['cart']))
                                                            <!--mini cart-->
                                                            <div class="cart_gallery">
                                                                <div class="cart_close"></div>
                                                                <table id="myTable" class="table " aria-describedby="minicart">
                                                                    <th scope="col"></th>
                                                                    <tbody>
                                                                        @if(isset($data['cart']['cart']['data'][0]->item[0]))
                                                                        <tr>
                                                                            <td class="mini_cart-subtotal">
                                                                                
                                                                                <span class="text-end innersubtotal">
                                                                                    <p class="product-name">{{__('msg.total')}} :
                                                                                        <span>{{ get_price(sprintf("%0.2f",$data['cart']['subtotal'])) ?? '-' }}</span>
                                                                                    </p>
                                                                                </span>
                                                                            </td>
                                                                           
                                                                        </tr>
                                                                         @endif
                                                                        @php $ready_to_checkout = '1'; @endphp
                                                                        @if(isset($data['cart']['cart']['data']) &&
                                                                        is_array($data['cart']['cart']['data']) &&
                                                                        count($data['cart']['cart']['data']))
                                                                        @foreach($data['cart']['cart']['data'] as $p)
                                                                        @if(isset($p->item[0]))
                                                                        @php
                                                                        if(isset($p->qty) &&  ($p->qty) > 0){
                                                                         $qty = $p->qty;
                                                                        }else{
                                                                         $qty = $data['cart']['cart_session'][$p->product_variant_id]['quantity'];
                                                                        }
                                                                        @endphp

                                                                        <tr class="cart1price">
                                                                            <td class="text-end checktrash cart">
                                                                                @if((isset($p->item[0]->is_item_deliverable)) && ($p->item[0]->is_item_deliverable == false) && (session()->get('pincode_no') == true))
                                                                                <p class="deliver_notice">{{__('msg.Not Deliverable for')}} {{ session()->get('pincode_no') }}</p>
                                                                                @php $ready_to_checkout = '0'; @endphp
                                                                                @endif
                                                                                <a href="">
                                                                                    <figure class="itemside">
                                                                                        <div class="aside">
                                                                                            <img src="{{ $p->item[0]->image }}" class="img-sm" alt="{{ $p->item[0]->name ?? 'Product Image' }}">
                                                                                        </div>
                                                                                        <figcaption class="info minicartinfo">
                                                                                            <a href="" class="title text-dark">{{ $p->item[0]->name ?? '-' }}</a>
                                                                                            <span class="small">{{ get_varient_name($p->item[0]) ?? '-' }}</span>
                                                                                            <br />
                                                                                            <span class="price-wrap cartShow">{{ $qty??'1' }}</span>
                                                                                            <form action="{{ route('cart-update', $p->product_id) }}" method="POST" class="cartEdit cartEditmini">
                                                                                                @csrf
                                                                                                <input type="hidden" name="child_id" value="{{ $p->product_variant_id }}">
                                                                                                <input type="hidden" name="product_id" value="{{ $p->product_id }}">
                                                                                                <div class="button-container col pr-0 my-1 mini_cart_button">
                                                                                                    <button class="cart-qty-minus button-minus" type="button" id="button-minus-{{ $p->product_variant_id }}" value="-">-</button>
                                                                                                    <input class="form-control qtyPicker midd_button" type="number" name="qty" data-min="1" min="1" max="{{ intval(getMaxQty($p->item[0])) }}" data-max="{{ intval(getMaxQty($p->item[0])) }}" data-max-allowed="{{ (Cache::get('max_cart_items_count')) }}" value="{{ $qty ?? '1' }}" readonly>
                                                                                                    <button class="cart-qty-plus button-plus-cart" type="button" id="button-plus-{{ $p->product_variant_id }}" value="+">+</button>
                                                                                                </div>
                                                                                            </form>
                                                                                            @if(intval($qty??'1') > 1)
                                                                                            @if(intval($p->item[0]->discounted_price))
                                                                                            x<small class="text-muted">
                                                                                                @if(isset($p->item[0]->tax_percentage) && $p->item[0]->tax_percentage > 0)
                                                                                                @php
                                                                                                $tax_price  =  $p->item[0]->discounted_price + ($p->item[0]->discounted_price * $p->item[0]->tax_percentage/100);
                                                                                                @endphp
                                                                                                {{ get_price($tax_price) }}</small>
                                                                                            @else
                                                                                            {{ get_price($p->item[0]->discounted_price) }}</small>
                                                                                            @endif
                                                                                            @else
                                                                                            x<small class="text-muted">
                                                                                                @if(isset($p->item[0]->tax_percentage) && $p->item[0]->tax_percentage > 0)
                                                                                                @php
                                                                                                $tax_price  =  $p->item[0]->price + ($p->item[0]->price * $p->item[0]->tax_percentage/100);
                                                                                                @endphp
                                                                                                {{ get_price($tax_price) }}</small>
                                                                                            @else
                                                                                            {{ get_price($p->item[0]->price) }}</small>
                                                                                            @endif
                                                                                            @endif
                                                                                            @endif
                                                                                        </figcaption>
                                                                                    </figure>
                                                                                </a>
                                                                                <div class="price-wrap">
                                                                                    <var class="price">
                                                                                        @if(isset($p->item[0]->tax_percentage) && $p->item[0]->tax_percentage > 0)
                                                                                        @if(intval($p->item[0]->discounted_price))
                                                                                        @php
                                                                                        $tax_price  =  $p->item[0]->discounted_price + ($p->item[0]->discounted_price * $p->item[0]->tax_percentage/100);
                                                                                        @endphp
                                                                                        {{ get_price(sprintf("%0.2f", $tax_price * ($qty ?? 1) )) }}
                                                                                        @else
                                                                                        @php
                                                                                        $tax_price  =  $p->item[0]->price + ($p->item[0]->price * $p->item[0]->tax_percentage/100);
                                                                                        @endphp
                                                                                        {{ get_price(sprintf("%0.2f",$tax_price * ($qty ?? 1) )) }}
                                                                                        @endif
                                                                                        @else
                                                                                        @if(intval($p->item[0]->discounted_price))
                                                                                        {{ get_price(sprintf("%0.2f", $p->item[0]->discounted_price * ($qty ?? 1) )) }}
                                                                                        @else
                                                                                        {{ get_price(sprintf("%0.2f", $p->item[0]->price * ($qty ?? 1) )) }}
                                                                                        @endif
                                                                                        @endif
                                                                                    </var>
                                                                                </div>
                                                                                <button class="btn btn-light btn-round btnEdit cartShow">
                                                                                    <em class="fa fa-pencil-alt"></em>
                                                                                </button>
                                                                                <button class="btn btn-light btn-round cartSave cartEdit cartEditmini">
                                                                                    <em class="fas fa-check"></em>
                                                                                </button>
                                                                                <button class="btn btn-light btn-round btnEdit cartEdit cartEditmini">
                                                                                    <em class="fa fa-times"></em>
                                                                                </button>
                                                                                <button class="btn btn-light btn-round cartDelete" data-varient="{{ $p->product_variant_id }}">
                                                                                    <em class="fas fa-trash-alt"></em>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                        @endforeach
                                                                        @else
                                                                        <tr>
                                                                            <td colspan="4" class="text-center">
                                                                                <img src="{{ asset('images/empty-cart.png') }}" alt="No Items In Cart">
                                                                                <br><br>
                                                                                <a href="{{ route('shop') }}" class="btn btn-primary"><em class="fa fa-chevron-left  mr-1"></em>{{__('msg.continue_shopping')}}</a>
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            @if(isset($data['cart']['cart']['data']) && is_array($data['cart']['cart']['data']) && count($data['cart']['cart']['data']))
                                                                            <td colspan="" class="text-end checkoutbtn">
                                                                                @if(Cache::has('min_order_amount') && intval($data['cart']['subtotal']) >= intval(Cache::get('min_order_amount')))
                                                                                @if(session()->has('pincode') && Cache::get('local_shipping')=='1')
                                                                                @if($ready_to_checkout == '1')
                                                                                @if(isLoggedIn())
                                                                                <a href="{{ route('checkout-address') }}" class="btn btn-primary">{{__('msg.checkout')}}
                                                                                    <em class="fa fa-arrow-right"></em>
                                                                                </a>
                                                                                @else
                                                                                <a class="btn btn-primary login-popup">{{__('msg.checkout')}}
                                                                                    <em class="fa fa-arrow-right"></em>
                                                                                </a>
                                                                                @endif
                                                                                @else
                                                                                <a class="btn btn-primary checkout-dbutton">{{__('msg.checkout')}}
                                                                                    <em class="fa fa-arrow-right"></em>
                                                                                </a>
                                                                                @endif
                                                                                @elseif(Cache::get('local_shipping')=='1')
                                                                                <a class="btn btn-primary checkout-spincode-button">{{__('msg.checkout')}}
                                                                                    <em class="fa fa-arrow-right"></em></a>
                                                                                @else
                                                                                @if(isLoggedIn())
                                                                                <a href="{{ route('checkout-address') }}" class="btn btn-primary">{{__('msg.checkout')}}
                                                                                    <em class="fa fa-arrow-right"></em>
                                                                                </a>
                                                                                @else
                                                                                <a class="btn btn-primary login-popup">{{__('msg.checkout')}}
                                                                                    <em class="fa fa-arrow-right"></em>
                                                                                </a>
                                                                                @endif
                                                                                @endif
                                                                                @else

                                                                                @endif

                                                                                <a href="{{ route('cart') }}" class="btn btn-primary">{{__('msg.viewcart')}}
                                                                                    <em class="fa fa-arrow-right"></em>
                                                                                </a>
                                                                            </td>
                                                                           
                                                                            @endif
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                            <!--mini cart end-->
                                                            @else
                                                            <div class="text-center mini_no_cart">
                                                                <img src="{{ asset('images/empty-cart.png') }}" alt="No Items In Cart">
                                                                <br><br>
                                                                <a href="{{ route('shop') }}" class="btn btn-primary text-white"><em class="fa fa-chevron-left  mr-1"></em>{{__('msg.continue_shopping')}}</a>
                                                            </div>
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

                    <div class="header_bottom">
                        <div class="container-fluid">
                            <div class="row align-items-center">

                                <div class="col-lg-3 col-md-6 mb-sm-2 mb-2 mb-md-0">
                                    <div class="categories_menu">
                                        @php
                                        $categories = Cache::get('categories', []);
                                        $maxProductToShow = 10;
                                        $totalCategories = count($categories);
                                        @endphp
                                        <div class="title_content">

                                            <h2 class="categories_toggle"><em class="fas fa-bars"></em>{{__('msg.all_categories')}}</h2>
                                            <em class="fas fa-chevron-down fa-xs"></em>
                                        </div>
                                        <div class="categories_content_toggle">
                                            <ul>
                                                @foreach($categories as $k=>$c)
                                                @if(isset($c->childs) && count((array)$c->childs))
                                                <li class="menu_item_content {{ $k >= $maxProductToShow ? 'hidden' : ''}}">
                                                    <a href="{{ route('category', $k) }}">{{ $c->name }}<em class="fas fa-plus fa-xs"></em></a>
                                                    <ul class="cate_mega_menu">
                                                        @foreach($c->childs as $child)
                                                        <li><a href="{{ route('shop', ['category' => $c->slug, 'sub-category' => $child->slug]) }}">{{ $child->name }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @else
                                                <li class="menu_item_content {{ $k >= $maxProductToShow ? 'hidden' : ''}}">
                                                    <a href="{{ route('category', $k) }}">{{ $c->name }}</a>
                                                </li>
                                                @endif
                                                @if(intval(--$maxProductToShow))
                                                @else
                                                @if($maxProductToShow == 0)
                                                <li>
                                                    <a href="#" id="more-btn"><em class="fa fa-plus" aria-hidden="true"></em>
                                                        {{__('msg.more_categories')}}
                                                    </a>
                                                </li>
                                                @endif
                                                @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mobail_s_block">
                                        <div class="searchbar_content">
                                            <form action="{{ route('shop') }}">
                                                <div class="category_hover_content">
                                                    @php
                                                    $categories = Cache::get('categories', []);
                                                    @endphp
                                                    <select class="" name="category">
                                                        @foreach($categories as $i => $c)
                                                        <option value="{{ $c->slug }}">{{ $c->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="search-box">
                                                    <input placeholder="Search product..." value="{{ isset($_GET['s']) ? trim($_GET['s']) : ''}}" name="s" type="text" class="typeahead search" autocomplete="off" id="searchm">
                                                    <button type="submit"><span class="fas fa-search"></span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                     <!--main menu start-->
                                     <div class="main_menu_content main_menu_position">
                                        <nav>
                                            <ul>
                                                <li>
                                                    <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">{{__('msg.home')}}
                                                    </a>
                                                </li>
                                                <li class="mega_items_content"><a href="{{ route('shop') }}" class="{{ request()->is('shop') ? 'active' : '' }}">{{__('msg.shop')}}</a>
                                                </li>
                                                <li>
                                                    <a>{{__('msg.more')}}<em class="fa fa-angle-down"></em></a>
                                                    <ul class="sub_menu pages">
                                                        <li><a href="{{ route('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">{{__('msg.about us')}}</a></li>
                                                        <li><a href="{{ route('page', 'faq') }}" class="{{ request()->is('page/contact') ? 'active' : '' }}">{{__('msg.faq')}}</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="{{ route('contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}"> {{__('msg.contact us')}}</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <!--main menu end-->

                                </div>
                                <div class="col-lg-3">
                                    @if(trim(Cache::get('support_number', '')) != '')
                                    <div class="connect-with-us">
                                    <em class="fas fa-mobile"></em>
                                        <p>
                                            <a href="#">{{Cache::get('support_number')}}</a>
                                            {{__('msg.customer_support')}}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </header>
        <!--header area end-->
        <!-- modal area start-->
        <div class="modal fade" id="productvariant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="quick_view modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><em class="fas fa-times"></em></span>
                    </button>
                    <div class="modal_body product_details">
                        <div class="container productmodaldetails">
                            <span class="productmodaldetails">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id='loader2'>
            <img src="{{ asset('images/loading.gif') }}"  id="preloader" alt="preloader">
        </div>

        <div class="modal fade" id="pincodeModal" tabindex="-1" aria-labelledby="pincodeModalLabel" aria-hidden="true">
            <div class="pincode modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="defaulthead modal-header">
                        <h5 class="modal-title" id="pincodeModalLabel"> {{__('msg.Default Delivery Location')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-header">
                        <h6 class="warning-title"> {{__('msg.selected location line')}}</h6>
                    </div>
                    <div class="modal-body">
                        <div class="wrapper-dropdown-5 dd" tabindex="1">
                            @if(Cache::has('locations') && is_array(Cache::get('locations')) && !empty(Cache::get('locations')['data']))
                            <input class="inP live-search-box form-control" type="text" name="selected_pincode" placeholder="{{session()->get('pincode_no')}}" autocomplete="off" onkeyup="searchclick()" id="searchclick">
                            <ul class="dropdown live-search-list">
                            <li class="item">
                                <a class="close-pincode-modal" href="{{ route('home-pincode-clear') }}"> {{__('msg.all')}}</a>
                            </li>
                            @foreach(Cache::get('locations')['data'] as $loc)
                            @if(!empty($loc->pincode))
                            <li class="item">
                                <a class="close-pincode-modal" href="{{ route('home-pincode', $loc->id) }}">{{$loc->pincode}}</a>
                            </li>
                            @endif
                            @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
