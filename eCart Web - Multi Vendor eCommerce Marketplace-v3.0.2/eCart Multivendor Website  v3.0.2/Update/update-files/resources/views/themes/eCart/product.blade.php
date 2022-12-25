<meta property="og:image" content="{{ $data['product']->image }}"/>
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>@if(strlen(strip_tags($data['product']->name)) > 70) {!! substr(strip_tags($data['product']->name), 0,70) ."..." !!} @else {!! substr(strip_tags($data['product']->name), 0,70) !!} @endif </h1>
                   
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if(strlen(strip_tags($data['product']->name)) > 70) {!! substr(strip_tags($data['product']->name), 0,70) ."..." !!} @else {!! substr(strip_tags($data['product']->name), 0,70) !!} @endif
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->

{{-- all-content --}}
<div class="main-content my-lg-5  my-md-2">

    {{-- product detail --}}
    <section class="product-detail-sec my-2 my-md-3">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 col-md-6 col-12">
                        <div class="product-details-tab">
                            @if (count(getInStockVarients($data['product'])))
                            @else
                            <div class="content_label">
                                <span class="sold-out">{{ __('msg.sold_out') }}</span>
                            </div>
                            @endif
                            <div id="img-1" class="zoomWrapper single-zoom">
                                <a href="#">
                                    <img id="zoom1" src="{{ $data['product']->image }}"  alt="{{ $data['product']->name ?? 'Product Image' }}" data-zoom-image="{{ $data['product']->image }}" alt="big-1">
                                </a>
                            </div>
                            <div class="single-zoom-thumb">
                                <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                    @php $count=1; @endphp
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{ $data['product']->image }}" data-zoom-image="{{ $data['product']->image }}" >
                                            <img src="{{ $data['product']->image }}" alt="{{ $data['product']->name ?? 'Product Image' }}" />
                                        </a>
                                    </li>
                                    @foreach($data['product']->other_images as $index => $img)
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{ $img }}" data-zoom-image="{{ $img }}" >
                                            <img src="{{ $img }}" alt="{{ $data['product']->name ?? 'Product Image' }}" />
                                        </a>
                                    </li>
                                    @php $count++; @endphp
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class=" col-xl-7 col-lg-6 col-md-6 col-12">
                        <div class="product_details_right productdetails2">
                            <h1>{{ $data['product']->name ?? '-' }}</h1>
                            @if(count(getInStockVarients($data['product'])))
                            <div class="price_box">
                                <span class="current_price" id="price_offer_{{ $data['product']->id }}">{{ Cache::get('currency') }}<span class='value '></span></span>
                                <span class="old_price" id="price_mrp_{{ $data['product']->id }}">{{ Cache::get('currency') }}
                                    <span class='value single_p'></span></span>
                                <span class="current_price" id="price_regular_{{ $data['product']->id }}">{{ Cache::get('currency') }}  <span class='value'></span></span>
                                <small class="pro_savings" id="price_savings_{{ $data['product']->id }}">{{__('msg.you_save')}}: {{ Cache::get('currency') }} <span class='value'></span></small>
                            </div>
                            <div class="product_desc">
                                <p>@if(strlen(strip_tags($data['product']->description)) > 180) {!! substr(strip_tags($data['product']->description), 0,180) ."..." !!} @else {!! substr(strip_tags($data['product']->description), 0,180) !!} @endif
                                @if(strlen($data['product']->description) > 180)
                                <a class="more-content" href="#info" id="description">{{__('msg.read_more')}}</a></p>
                                @endif
                                @if (intval($data['product']->indicator) == 2)
                            <img class="lazy" data-original="{{ asset('images/nonvag.svg') }}" alt="Not Vegetarian Product">
                            <span class="text-left ml-1"> {{ __('msg.not') }}
                                <strong>{{ __('msg.vegetarian') }}</strong>
                                {{ __('msg.v_product') }}.
                            </span>
                            @elseif(intval($data['product']->indicator) == 1)
                            <img class="lazy" data-original="{{ asset('images/vag.svg') }}" alt="Vegetarian Product">
                            <span class="text-left ml-1"> {{ __('msg.this_is') }}
                                <strong>{{ __('msg.vegetarian') }}</strong>
                                {{ __('msg.v_product') }}.
                            </span>
                            @endif
                            </div>
                            <div class="form">
                                <form action="{{ route('cart-add') }}" class="addToCart" method="POST">
                                    @csrf
                                    <input type="hidden" class="name" name="name" value="{{ $data['product']->name }}" data-name="{{ $data['product']->name }}">
                                    <input type="hidden" class="image" name="image" value="{{ $data['product']->image }}" data-image="{{ $data['product']->image }}">
                                    <input type="hidden" class="price" name="price" value="" data-price="">
                                    <input type="hidden" name='id' value='{{ $data['product']->id }}'>
                                    <input type="hidden" name="type" value='add'>
                                    <input type="hidden" name="child_id" value='0' id="child_{{ $data['product']->id }}">

                                    <div class="product-variant1">
                                        <div class="product-variant__label">{{__('msg.available')}}</div>
                                        <div class="product-variant__list variant btn-group-toggle" data-toggle="buttons">
                                            @php $firstSelected = true; @endphp
                                            @foreach(getInStockVarients($data['product']) as $v)
                                            <button class="product-variant__btn pdp-btn product-variant__btn--active trim btn {{$firstSelected}}"  data-id="{{ $data['product']->id }}" >
                                                {{ get_varient_name($v) }}
                                                <input hidden type="radio" name="options" id="option{{ $v->id }}" value="{{ $v->id }}" data-id='{{ $v->id }}' data-price='@php $tax_discounted_price = get_price_varients($v)+(get_price_varients($v)*get_pricetax_varients($data['product']->tax_percentage)/100); print number_format($tax_discounted_price,2); @endphp '
                                                data-tax='{{ get_pricetax_varients($data['product']->tax_percentage) }}'
                                                data-mrp='@php
                                                $get_mrp_varients = get_mrp_varients($v);
                                                if($get_mrp_varients !== ''){
                                                $tax_mrp_price = (int)get_mrp_varients($v)+((int)get_mrp_varients($v)*(int)get_pricetax_varients($data['product']->tax_percentage)/100); print number_format($tax_mrp_price,2);
                                                }
                                                @endphp'
                                                data-mrp_number='@php $tax_mrp_price_number = intval(preg_replace('/[^\d.]/', '', $tax_mrp_price));  print  $tax_mrp_price_number; @endphp'
                                                data-savings='{{ get_savings_varients($v, false) }}' data-stock='{{ intval(getMaxQty($v)) }}' data-max-allowed-stock='{{ intval(getMaxQtyAllowed($v)) }}'
                                                data-cart_count='{{ intval(get_cart_count($v)) }}'
                                                data-main-image='{{ get_main_image($data['product']) }}'
                                                data-gallery-images='{{ get_gallery_images(($v)) }}'
                                                data-qty='1' autocomplete="off" >
                                            </button>
                                            @if($firstSelected == true)
                                            {{ $firstSelected = false }}
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="product_variant quantity">
                                        <label>{{__('msg.quantity')}} :</label>
                                        <button class="cart-qty-minus button-minus button-minus-single-page" type="button" id="button-minus" value="-">-</button>
                                        <input class="qtyPicker qtyPicker-single-page" type="number" id="qtyPicker_{{ $data['product']->id }}" name="qty" data-min="1" min="1" max="1" data-max="1" data-max-allowed="1" value="1" readonly>
                                        <button class="cart-qty-plus button-plus button-plus-single-page" type="button" id="button-plus" value="+">+</button>
                                        <button class="btn btn-primary  outline-inward" type="submit"><em class="fas fa-shopping-cart pr-2"></em>&nbsp;&nbsp;{{__('msg.add_to_cart')}}</button>
                                        <li class="btn btn-primary pro_fav  {{ isset($data['product']->is_favorite) && intval($data['product']->is_favorite) ? 'saved' : 'save' }}" data-id='{{ $data['product']->id }}'></li>
                                    </div>
                                    
                                </form>
                                
                            </div>
                            
                            <div class="col-lg-12 col-md-12 product__details">
                                <ul class="top_bar_left mb-3">
                                    <li class="price-marquee">
                                        @if(Cache::has('pincode_no'))
                                        <p>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#_pincodeModalsingle">
                                                <em class="fas fa-map-marker-alt">&nbsp;<span class='pincode_msg'>{{__('msg.Deliverable_to:')}} {{ Cache::get('pincode_no') }}</span></em>
                                            </button>
                                        </p>
                                        @else
                                        @if(isset($data['pincodedata']['error']) && $data['pincodedata']['error'] == true)
                                        <p>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#_pincodeModalsingle">
                                                <em class="fas fa-map-marker-alt">&nbsp;<span class='pincode_msg'>{{__('msg.Can_not_deliverable_to')}} {{$data['pincode_no'] ?? '-'}}</span></em>
                                            </button>
                                        </p>
                                        @elseif(isset($data['pincodedata']['error']) && $data['pincodedata']['error'] == false)
                                        @if(isset($data['pincodedata']['estimated_date']))
                                        <p>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#_pincodeModalsingle">
                                                <em class="fas fa-map-marker-alt">&nbsp;<span class='pincode_msg'>{{__('msg.delivery_charge_cod:')}} {{$data['pincodedata']['delivery_charge_with_cod'] ?? '-'}}</span></em>
                                            </button>
                                        </p>
                                        @else
                                        <p>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#_pincodeModalsingle">
                                                <em class="fas fa-map-marker-alt">&nbsp;<span class='pincode_msg'>{{__('msg.Deliverable_to:')}} {{$data['pincode_no'] ?? '-'}}</span></em>
                                            </button>
                                        </p>
                                        @endif
                                        @else
                                        <p>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#_pincodeModalsingle">
                                                <em class="fas fa-map-marker-alt">&nbsp;<span class='pincode_msg'>{{__('msg.Select_a_location_to_see_product_availability')}}</span></em>
                                            </button>
                                        </p>
                                        @endif
                                        <span class="delivery_charges"></span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class='row' id="info">
                                <div class='col-lg-6 col-12'>
                                    <h6>Check Pincode</h6>
                                    <form  method='POST' class='pincode_form'>
                                        @csrf
                                        <input type="text" name="product_variant_id" class="form-control" value="{{ $data['product']->variants['0']->id }}" hidden>
                                        <input type="text" name="slug" class="form-control" value="{{ $data['product']->slug }}" hidden>
                                        <div class="quick_deliver"><input type="text" name="pincode" class="form-control mr-70" id="pincode_no" placeholder="Enter a Pincode">
                                            <button class="btn btn-primary" type="submit" name="submit">Apply</button>
                                        </div>
                                    </form>
                                    <br/>
                                </div>
                            </div>
                            @else
                            @endif
                            <div class="priduct_social">
                                <ul>
                                    <li>
                                        <a class="facebook" href="https://facebook.com/sharer.php?u={{url()->current()}}" target="_blank" title="facebook"><em class="fab fa-facebook-f"></em>{{__('msg.Facebook')}}</a>
                                    </li>
                                    <li>
                                        <a class="twitter" href="http://twitter.com/share?url={{url()->current()}}" target="_blank" title="twitter"><em class="fab fa-twitter"></em>{{__('msg.Twitter')}}</a>
                                    </li>
                                    <li>
                                        <a class="pinterest" href="http://pinterest.com/pin/create/button/?url=http://www.google.com&media={{ $data['product']->image }}" target="_blank" title="pinterest"><em class="fab fa-pinterest"></em>{{__('msg.pinterest')}}</a>
                                    </li>
                                    <li>
                                        <a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url={{url()->current()}}" target="_blank" title="linkedin"><em class="fab fa-linkedin"></em>{{__('msg.linkedin')}}</a>
                                    </li>

                                </ul>
                            </div>

                            <!-- policy content -->
                            <div class="card-content text-center policycontent">
                                @if (isset($data['product']->return_status))
                                <div class="col-md-3">
                                    <div class="card productcard returnpolicy">
                                        @if (intval($data['product']->return_status))
                                        <div class="card-img pb-2">
                                            <span class="creativity">
                                                <img class="lazy" data-original="{{ asset('images/returnable.svg') }}" alt="Returnable">
                                            </span>
                                        </div>
                                        <div class="card-box">
                                            <h6 class="card-title text-center">
                                                {{ Cache::get('max-product-return-days') }}
                                                {{ __('msg.days') }} {{ __('msg.returnable') }}
                                            </h6>
                                        </div>
                                        @else
                                        <div class="card-img pb-2">
                                            <span class="creativity">
                                                <img class="lazy" data-original="{{ asset('images/not-returnable.svg') }}" alt="notReturnable">
                                            </span>
                                        </div>
                                        <div class="card-box">
                                            <h6 class="card-title text-center">{{ __('msg.not_returnable') }}</h6>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if (isset($data['product']->cancelable_status))
                                <div class="col-md-3">
                                    <div class="card productcard returnpolicy">
                                        @if (intval($data['product']->cancelable_status))
                                        <div class="card-img pb-2">
                                            <span class="creativity">
                                                <img class="lazy" data-original="{{ asset('images/cancellable.svg') }}" alt="Cancellable">
                                            </span>
                                        </div>
                                        <div class="card-box">
                                            <h6 class="card-title text-center">
                                                {{ __('msg.order_can_cancel_till_order') }}
                                                {{ strtoupper($data['product']->till_status ?? '') }}
                                            </h6>
                                        </div>
                                        @else
                                        <div class="card-img pb-2">
                                            <span class="creativity">
                                                <img class="lazy" data-original="{{ asset('images/not-cancellable.svg') }}" alt="notCancellable">
                                            </span>
                                        </div>
                                        <div class="card-box">
                                            <h6 class="card-title text-center">{{ __('msg.not_cancellable') }}</h6>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="seller_name">
                                <p>
                                    <strong>{{__('msg.seller')}}</strong>
                                    <a href="{{ route('seller', $data['product']->seller_slug ?? '-') }}">{!! ($data['product']->seller_name) !!} </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--product info start-->
    <section class="product_d_info my-2 my-md-3" >
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                <div class="row">
                    <div class="col-12">
                        <div class="product_d_inner">
                            <div class="product_info_button">
                                <ul class="nav" role="tablist">
                                    <li>
                                        <a class="active" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">{{__('msg.description')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="" role="tabpanel">
                                    <div class="product_info_content">
                                        @if(isset($data['product']->manufacturer) && !(empty($data['product']->manufacturer)))
                                        <p> {{__('msg.manufacturer')}} {!! ($data['product']->manufacturer) !!} </p>
                                        @endif
                                        @if(isset($data['product']->made_in) && !(empty($data['product']->made_in)))
                                        <p>{{__('msg.made_in')}} {!! ($data['product']->made_in) !!}</p>
                                        @endif
                                        <p> {!! ($data['product']->description) !!} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- featured product --}}
    @if(isset($data['similarProducts']) && !empty($data['similarProducts']))
    <section class="similar-product-sec my-2 my-md-3">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product_right_bar">
                            <div class="product_container">
                                <div class="section_title d-flex mb-3 align-items-baseline border-bottom">
                                    <h2>
                                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ __('msg.similar_products') }}</span>
                                    </h2>
                                    <div class="desc_title">
                                        {{-- {{ __('msg.Add_new_product_to_weekly_show_up') }} --}}
                                    </div>
                                </div>
                                <div class="product_carousel_content similar-pro-carousel owl-carousel">
                                    @foreach ($data['similarProducts'] as $p)
                                    <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                @if(!count(getInStockVarients($p)))
                                                <div class="content_label">
                                                    <span class="label_sale">{{ __('msg.sold_out') }}</span>
                                                </div>
                                                @endif
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="{{ route('product-single', $p->slug) }}"><img class="lazy" data-original="{{ $p->image }}" alt="{{ $p->name ?? 'Product Image' }}"></a>

                                                    <div class="action_links">
                                                        <span class="inner product_data">
                                                            <ul>
                                                                @if (count(getInStockVarients($p)))
                                                                <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                                @foreach (getInStockVarients($p) as $v)
                                                                <input type="hidden" class="qtyPicker qtyPicker-single-page qty" name="qty" type="number" id="qty-{{ $v->id }}" name="qty" data-min="1" min="1" max="{{(int)$v->stock+1}}" data-max="{{(int)$v->stock+1}}" data-max-allowed="{{ Cache::get('max_cart_items_count')+1 }}" value="{{ $v->cart_count+1 }}" readonly data-qty="{{ $v->cart_count+1 }}">
                                                                <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}" data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                                @endforeach
                                                                <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                                @if (count(getInStockVarients($p)) > 1)
                                                                <li class="add_to_cart productmodal"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                                </li>
                                                                @else
                                                                <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                                </li>
                                                                @endif

                                                                @endif
                                                                <li class="quick_button productmodal">
                                                                    <a title="quick view"><span class="fas fa-search"></span></a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a title="Add to Wishlist" class="{{ isset($p->is_favorite) && intval($p->is_favorite) ? 'saved' : 'save' }}" data-id='{{ $p->id }}'>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </span>
                                                    </div>
                                                </div>
                                                <figcaption class="product_content">
                                                    <h4 class="product_name">
                                                        <a href="{{ route('product-single', $p->slug) }}">@if(strlen(strip_tags($p->name)) > 30) {!! substr(strip_tags($p->name), 0,30)."..." !!} @else {!! substr(strip_tags($p->name), 0,30) !!} @endif</a>
                                                    </h4>
                                                    <div class="price_box">
                                                        <span class="current_price">{!! print_price($p) !!}</span>
                                                        <span class="old_price">{!! print_mrp($p) !!}</span>
                                                        @if (get_savings_varients($p->variants[0]))
                                                        <span class="discount-percentage discount-product">{{ get_savings_varients($p->variants[0]) }}</span>
                                                        @endif
                                                    </div>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
</div>

<div class="modal fade" id="pincodeModalsingle" tabindex="-1" aria-labelledby="pincodeModalLabelsingle" aria-hidden="true">
    <div class="pincode modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="defaulthead modal-header">
                <h5 class="modal-title" id="pincodeModalLabelsingle">{{__('msg.Check Pincode')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-header">
                <h6 class="warning-title">{{__('msg.Enter Pincode')}}</h6>
            </div>
            <div class="modal-body">
                <div class="productwrapper">
                    <form action="{{ route('check-product-availability', $data['product']->slug ?? '-') }}" method="POST">
                        <input type="text" name="product_id" class="form-control" value="{{ $data['product']->id ?? '-' }}" hidden>
                        <input type="text" name="slug" class="form-control" value="{{ $data['product']->slug ?? '-' }}" hidden>
                        <input type="text" name="pincode" class="form-control">
                        <button class="btn btn-primary">{{__('msg.Apply')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

