<!-- seller sec -->
@if(Cache::has('seller') && is_array(Cache::get('seller')) && count(Cache::get('seller')))
<div class="main-content my-2 my-md-3">
    <section class="new-arrival seller__sec">
        <div class="container-fluid">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product_right_bar">
                            <div class="product_container">
                                <div class="section_title d-flex mb-3 align-items-baseline border-bottom">
                                    <h2>
                                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{__('msg.Shop by Seller')}}</span>
                                    </h2>
                                    <div class="pop_desc_title ml-auto">
                                        <a href="{{ route('seller_all') }}" class="btn-1 view title-section view-all ml-auto mr-0 btn btn-primary btn-sm shadow-md w-100 w-md-auto">{{__('msg.view_all')}}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i></a>
                                    </div>
                                </div>
                                <div class="product_carousel_content seller-carousel owl-carousel">
                                    @foreach(Cache::get('seller') as $i => $s)
                                    @if(!empty($s->name))
                                    <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="{{ route('seller', $s->slug ?? '-') }}">
                                                        <img class="lazy" data-original="{{$s->logo}}" alt="seller"></a>
                                                </div>
                                                <figcaption class="product_content">
                                                    <h4 class="product_name"><a href="{{ route('seller', $s->slug ?? '-') }}">{{$s->store_name}}</a>
                                                    </h4>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="popular_content">
                                    @if(Cache::has('seller_offer_images') && is_array(Cache::get('seller_offer_images')) && count(Cache::get('seller_offer_images')))
                                    @foreach(Cache::get('seller_offer_images') as $i => $s)
                                    @if($s->image !== '')
                                    <div class="row my-md-5 my-sm-2 my-3">
                                        <div class="col-md-12">
                                            <div class="banner_box_content">
                                                <img class="lazy" data-original="{{ $s->image }}" alt="ad-1">
                                            </div>
                                        </div>

                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------Category Offer Image-------------->

                </div>
            </div>
        </div>
    </section>
</div>
@endif
<!-- seller sec end-->