<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{__('msg.favourites')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('my-account') }}">{{__('msg.my_account')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{__('msg.favourites')}}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->
<div class="main-content">
    <section class="favourite_sec checkout-section ptb-70">
        <div class="container-fluid">
            <div class="row">
                @if(isLoggedIn())
                <div class="col-lg-3 col-md-12 col-12 mb-4">
                    @include("themes.".get('theme').".user.sidebar")
                </div>
                <div class="col-lg-9 col-md-12">
                    @else
                    <div class="col-lg-12 col-md-12">
                        @endif
                        <!--shop wrapper start-->
                        @if(isset($data['list']) && isset($data['list']['data']) && is_array($data['list']['data']) && count($data['list']['data']))
                        <!--shop toolbar start-->
                        <div class="shop_toolbar_content px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded mb-3">
                            <div class="shop_toolbar_btn">
                                <button data-role="grid-view" type="button" class="active btn-grid-view" data-toggle="tooltip" title="grid"></button>
                                <button data-role="list-view" type="button"  class="btn-list-view" data-toggle="tooltip" title="List"></button>
                            </div>
                        </div>
                        <!--shop toolbar end-->
                        <div class="row right_shop_content grid-view">
                            @foreach($data['list']['data'] as $p)
                            @if(count($p->variants))
                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-6 col-12" id="fav{{ $p->product_id ?? $p->id}}">
                                <div class="single_product_content px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                                    @if(!count(getInStockVarients($p)))
                                    <div class="content_label">
                                        <span class="sold-out">{{ __('msg.sold_out') }}</span>
                                    </div>
                                    @endif
                                    <div class="inner_product_content">

                                        <a class="img_content" href="{{ route('product-single', $p->slug ?? '-') }}"><img class="lazy" data-original="{{ $p->image }}" alt="{{ $p->image }}"></a>

                                        <div class="share_links inner product_data">
                                            @if(count(getInStockVarients($p)))
                                            <form action="{{ route('cart-add-single-varient') }}" method="POST">
                                                <input type="hidden" class="id" name="id" value="{{ $p->product_id ?? $p->id }}" data-id="{{ $p->product_id ?? $p->id }}">
                                                @foreach(getInStockVarients($p) as $v)
                                                <input type="hidden" class="qtyPicker qtyPicker-single-page qty" name="qty" type="number" id="qty-{{ $v->id }}" data-min="1" min="1" max="{{(int)$v->stock+1}}" data-max="{{(int)$v->stock+1}}" data-max-allowed="{{ Cache::get('max_cart_items_count')+1 }}" value="{{ $v->cart_count+1 }}" readonly data-qty="{{ $v->cart_count+1 }}">
                                                <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                @endforeach
                                                <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                <ul>
                                                    @if(count(getInStockVarients($p))>1)
                                                    <li class="add_to_cart productmodal"><a  title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                    @else
                                                    <li class="add_to_cart addtocart_single" data-id="{{ $p->product_id ?? $p->id }}" data-varient="{{ $v->id }}" data-qty="1"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                    @endif
                                                    <li class="quick_button productmodal"><a title="quick view"><span class="fas fa-eye"></span></a></li>
                                                    @endif
                                                    @if (session()->has('favourite'))
                                                    @if(in_array($p->id, session()->get('favourite')))
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="saved" data-id='{{ $p->id }}'></a></li>
                                                    @else
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="save" data-id='{{ $p->id }}'></a></li>
                                                    @endif
                                                    @else
                                                    <li class="wishlist"><a  title="Add to Wishlist" class="{{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{  $p->product_id }}'></a></li>
                                                    @endif
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="product_content inner_grid_content">
                                        <h4 class="product_name"><a href="{{ route('product-single', $p->slug ?? '-') }}">@if(strlen(strip_tags($p->name)) > 30) {!! substr(strip_tags($p->name), 0,30)."..." !!} @else {!! substr(strip_tags($p->name), 0,30) !!} @endif</a></h4>
                                        <div class="price_box">
                                            <span class="current_price" id="price_{{ $p->id }}">{!! print_price($p) !!}</span>
                                            <span class="old_price" id="mrp_{{ $p->id }}">{!! print_mrp($p) !!}</span>
                                            @if(get_savings_varients($p->variants[0]))
                                            <span class="discount-percentage discount-product" id="savings_{{ $p->id }}">{{ get_savings_varients($p->variants[0]) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product_content inner_list_content">
                                        <h4 class="product_name"><a href="{{ route('product-single', $p->slug ?? '-') }}">{{ $p->name }}</a></h4>
                                        <div class="price_box">
                                            <span class="current_price">{!! print_price($p) !!}</span>
                                            <span class="old_price">{!! print_mrp($p) !!}</span>
                                            @if(get_savings_varients($p->variants[0]))
                                            <span class="discount-percentage discount-product" id="savings_{{ $p->id }}">{{ get_savings_varients($p->variants[0]) }}</span>
                                            @endif
                                        </div>
                                        <div class="product_desc">
                                            <p>@if(strlen(strip_tags($p->description)) > 180) {!! substr(strip_tags($p->description), 0,180) ."..." !!} @else {!! substr(strip_tags($p->description), 0,180) !!} @endif</p>
                                        </div>
                                        <div class="share_links list_action_right inner product_data">
                                            <ul>
                                                @if(count(getInStockVarients($p)))
                                                <input type="hidden" class="id" name="id" value="{{ $p->product_id ?? $p->id}}" data-id="{{ $p->product_id ?? $p->id }}">

                                                @foreach(getInStockVarients($p) as $v)
                                                <input type="hidden" class="qtyPicker qtyPicker-single-page qty" name="qty" type="number" id="qty-{{ $v->id }}" name="qty" data-min="1" min="1" max="{{(int)$v->stock+1}}" data-max="{{(int)$v->stock+1}}" data-max-allowed="{{ Cache::get('max_cart_items_count')+1 }}" value="{{ $v->cart_count+1 }}" readonly data-qty="{{ $v->cart_count+1 }}">
                                                <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                @endforeach
                                                <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                @if(count(getInStockVarients($p))>1)
                                                <li class="add_to_cart productmodal" data-bs-toggle="modal" data-bs-target="#modal_box" data-tab="login"><a title="Add to cart">{{__('msg.add_to_cart')}}</span></a></li>
                                                @else
                                                <li class="add_to_cart addtocart_single" data-id="{{ $p->product_id ?? $p->id }}" data-varient="{{ $v->id }}" data-qty="1"><a title="Add to cart">{{__('msg.add_to_cart')}}</span></a></li>
                                                @endif
                                                @endif
                                                @if (session()->has('favourite'))
                                                @if(in_array($p->id, session()->get('favourite')))
                                                <li class="wishlist"><a  title="Add to Wishlist" class="saved" data-id='{{ $p->id }}'></a></li>
                                                @else
                                                <li class="wishlist"><a  title="Add to Wishlist" class="save" data-id='{{ $p->id }}'></a></li>
                                                @endif
                                                @else
                                                <li class="wishlist"><a  title="Add to Wishlist" class="{{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $p->product_id }}'></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <div class="row bg-white shadow rounded ">
                            <div class="col justify-content-center align-items-center my-3">
                                <p class="text-center">{{__('msg.no_favorites_product_found')}}</p>
                            </div>
                        </div>
                        @endif
                        <div class="shop_toolbar t_bottom">
                            <div class="pagination">
                            </div>
                        </div>
                        <!--shop toolbar end-->
                        <!--shop wrapper end-->
                    </div>
                </div>
            </div>
    </section>
</div>
