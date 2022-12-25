{{-- popular categories --}}
@if(Cache::has('categories') && is_array(Cache::get('categories')) && count(Cache::get('categories')))
<div class="main-content my-2 my-md-3">
    <section class="popular-categories">
        <div class="container-fluid">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                <div class="row">
                    <div class="col-12">
                        <div class="popular_title d-flex mb-3 align-items-baseline border-bottom">
                            <h2>
                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{__('msg.Popular Categories')}}</span>
                            </h2>
                            <div class="pop_desc_title">
                                <a href="{{ route('categories_all') }}" class="btn-1 view title-section view-all ml-auto mr-0 btn btn-primary btn-sm shadow-md w-100 w-md-auto">{{__('msg.view_all')}}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                        <div class="popular_content">
                            <div class="popular-cat owl-carousel">
                                @foreach(Cache::get('categories') as $i => $c)
                                @if($c->web_image !== '')
                                <div class="pop_item-listcategories">
                                    <div class="pop_list-categories">
                                        <div class="pop_thumb-category">
                                            <a href="{{ route('category', $i) }}"><img class="lazy" data-original="{{ $c->web_image }}" alt="{{ $c->name ?? 'Category' }}"></a>
                                        </div>
                                        <div class="pop_desc_listcat">
                                            <div class="name_categories">
                                                <h4>@if(strlen(strip_tags($c->name)) > 20) {!! substr(strip_tags($c->name), 0,20) ."..." !!} @else {!! substr(strip_tags($c->name), 0,20) !!} @endif </h4>
                                            </div>
                                            <div class="number_product">@if(strlen(strip_tags($c->subtitle)) > 20) {!! substr(strip_tags($c->subtitle), 0,20) ."..." !!} @else {!! substr(strip_tags($c->subtitle), 0,20) !!} @endif </div>
                                            <div class="view-more"><a href="{{ route('category', $i) }}">{{__('msg.shop_now')}} &nbsp;<em class="fas fa-chevron-circle-right"></em></a></div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="pop_item-listcategories-rounded">
                                    <div class="pop_thumb-category-rounded">
                                        <a href="{{ route('category', $i) }}">
                                            <img src="{{ $c->image }}?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=10&q=60" alt="{{ $c->name ?? 'Category' }}">
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
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="popular_content">
                            @if(Cache::has('category_offer_images') && is_array(Cache::get('category_offer_images')) && count(Cache::get('category_offer_images')))
                            @foreach(Cache::get('category_offer_images') as $i => $s)
                            @if($s->image !== '')
                            <div class="py-4 py-md-3 bg-white shadow-sm rounded">
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
        </div>
    </section>
</div>
@endif