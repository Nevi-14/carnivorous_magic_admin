<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{$data['title']}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $data['title'] }}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- seller sec -->
@if(isset($data['data']))
<div class="main-content mt-4 my-md-2">
    <section class="new-arrival mb-lg-5 pt-5 seller__sec seller__view__all">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                <div class="row">
                    <div class="product_right_bar">
                        <div class="product_container">
                            <div class="section_title d-flex mb-3 align-items-baseline border-bottom">
                                <h2>
                                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ __('msg.all sellers') }}</span>
                                </h2>

                            </div>
                            <div class="row">
                                @foreach($data['data'] as $i => $s)
                                @if(!empty($s->name))
                                <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-12 mb-4">
                                    <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="{{ route('seller', $s->slug ?? '-') }}"><img class="lazy" data-original="{{$s->logo}}" alt="seller"></a>
                                                </div>
                                                <figcaption class="product_content">
                                                    <h4 class="product_name"><a href="{{ route('seller', $s->slug ?? '-') }}">{{$s->store_name}}</a>
                                                    </h4>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@else
<div class="main-content mt-4 my-md-2">
    <section class="new-arrival mb-lg-5 pt-5 seller__sec seller__view__all">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                <div class="row">
                    <div class="product_right_bar">
                        <div class="product_container">
                            <div class="section_title d-flex mb-3 align-items-baseline border-bottom">
                                <h2>
                                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ __('msg.all sellers') }}</span>
                                </h2>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <br><br>
                                    <h1 class="text-center">{{__('msg.no_seller_found')}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endif

<!-- seller sec end-->