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
    <section class="popular-categories  mt-md-3 mt-sm-2 mt-3 categories__viewall">
        <div class="container-fluid">
            <div class="row">
                <div class="popular_content">
                    <div class="row">
                        @foreach($data['data'] as $i => $c)
                        @if($c->web_image !== '')
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="pop_item-listcategories">
                                <div class="pop_list-categories">
                                    <div class="pop_thumb-category">
                                        <a href="{{ route('category', $i) }}"><img class="lazy" data-original="{{ $c->web_image }}" alt="{{ $c->name ?? 'Category' }}"></a>
                                    </div>
                                    <div class="pop_desc_listcat">
                                        <div class="name_categories">
                                            <h4>{{ $c->name }}</h4>
                                        </div>
                                        <div class="number_product">{{ $c->subtitle }}</div>
                                        <div class="view-more"><a href="{{ route('category', $i) }}">{{__('msg.shop_now')}} &nbsp;<em class="fas fa-chevron-circle-right"></em></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="pop_item-listcategories-rounded">
                                <div class="pop_thumb-category-rounded">
                                    <a href="{{ route('category', $i) }}">
                                        <img class="lazy" data-original="{{ $c->image }}" alt="{{ $c->name ?? 'Category' }}">
                                    </a>
                                </div>
                                <div class="pop_desc_listcat">
                                    <div class="name_categories">
                                        <h4>{{ $c->name }}</h4>
                                    </div>
                                    <div class="number_product">{{ $c->subtitle }}</div>
                                    <div class="view-more"><a href="{{ route('category', $i) }}">{{__('msg.shop_now')}} &nbsp;<em class="fas fa-chevron-circle-right"></em></a></div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endif


