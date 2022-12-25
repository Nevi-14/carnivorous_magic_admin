<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1>{{$data['data'][0]->name}}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('home') }}">{{__('msg.home')}}</a>
               </li>
               <li class="breadcrumb-item active">
                  {{$data['data'][0]->name}}
               </li>
            </ol>
            <div class="divider-15 d-none d-xl-block"></div>
         </div>
      </div>
   </div>
</section>
<!-- eof breadcumb -->
<div class="main-content mt-4 my-md-2">
   <section class="featured_product py-5 seller-sec">
      <div class="container-fluid">
         <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="section_title d-flex mb-3 align-items-baseline border-bottom">
               <h2>
               <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{$data['data'][0]->store_name}} {{__('msg.store')}}</span>
               </h2>
            </div>
            <div class="row ">
               <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                  <div class="dash-bg-right dash-bg-right1">
                     <div class="reward-body-dtt">
                        <div class="reward-img-icon">
                           <img class="lazy" data-original="{{$data['data'][0]->logo}}" alt="{{$data['data'][0]->store_name}}">
                        </div>
                        <span class="rewrd-title">{{$data['data'][0]->store_name}}</span>
                     </div>
                  </div>
               </div>
               @if(isset($data['products']) && is_array($data['products']) && count($data['products']))
                  <div class="col-xl-9 col-lg-8 col-md-8 col-12">
                     <div class="featured_product_area product_carousel seller-details owl-carousel">
                        @php
                        $i=0;
                        @endphp
                        @foreach($data['products'] as $p)
                           @php
                           $i++;
                           @endphp
                           @if($i%2 !== 0)
                              <div class="product_items">
                                 <article class="single_product">
                                    <figure>
                                       @if(!count(getInStockVarients($p)))
                                       <div class="content_label">
                                          <span class="sold-out">{{ __('msg.sold_out') }}</span>
                                      </div>
                                       @endif
                                       <div class="product_thumb">
                                          <a class="primary_img" href="{{ route('product-single', $p->slug) }}">
                                             <img class="lazy" data-original="{{ $p->image }}" alt="{{ $p->name ?? 'Product Name'}}">
                                          </a>
                                       </div>

                                       <figcaption class="product_content">
                                          <h4 class="product_name">
                                             <a href="{{ route('product-single', $p->slug) }}">@if(strlen(strip_tags($p->name)) > 20) {!! substr(strip_tags($p->name), 0,20)."..." !!} @else {!! substr(strip_tags($p->name), 0,20) !!} @endif</a></h4>
                                          </h4>
                                          <div class="action_links">
                                             <span class="inner product_data">
                                                <ul>
                                                   @if(count(getInStockVarients($p)))
                                                   <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                   <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                   @foreach(getInStockVarients($p) as $v)
                                                   <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                   @endforeach
                                                   <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                   @if(count(getInStockVarients($p))>1)
                                                   <li class="add_to_cart productmodal">
                                                      <a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                   </li>
                                                   @else
                                                   <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1">
                                                      <a title="Add to cart"><span class="fas fa-shopping-cart"></span></a>
                                                   </li>
                                                   @endif
                                                   <li class="quick_button productmodal">
                                                      <a title="quick view"><span class="fas fa-search"></span></a>
                                                   </li>
                                                   @endif
                                                   <li class="wishlist">
                                                      <a  title="Add to Wishlist" class="{{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $p->id }}'></a>
                                                   </li>
                                                </ul>
                                             </span>
                                          </div>
                                          <div class="price_box">
                                             <span class="current_price">{!! print_price($p) !!}</span>
                                             <span class="old_price">{!! print_mrp($p) !!}</span>
                                             @if(get_savings_varients($p->variants[0]))
                                             <span class="discount-percentage discount-product">{{ get_savings_varients($p->variants[0]) }}</span>
                                             @endif
                                          </div>
                                       </figcaption>
                                    </figure>
                                 </article>
                                 @endif
                                 @if($i%2 == 0)
                                 <article class="single_product">
                                    <figure>
                                       @if(!count(getInStockVarients($p)))
                                       <div class="content_label">
                                          <span class="sold-out">{{ __('msg.sold_out') }}</span>
                                      </div>
                                       @endif
                                       <div class="product_thumb">
                                          <a class="primary_img" href="{{ route('product-single', $p->slug) }}">
                                             <img class="lazy" data-original="{{ $p->image }}" alt="{{ $p->name ?? 'Product Name'}}">
                                          </a>
                                       </div>

                                       <figcaption class="product_content">
                                          <h4 class="product_name">
                                             <a href="{{ route('product-single', $p->slug) }}">@if(strlen(strip_tags($p->name)) > 30) {!! substr(strip_tags($p->name), 0,30)."..." !!} @else {!! substr(strip_tags($p->name), 0,30) !!} @endif</a></h4>
                                          </h4>
                                          <div class="action_links">
                                             <span class="inner product_data">
                                                <ul>
                                                   @if(count(getInStockVarients($p)))
                                                   <input type="hidden" class="id" name="id" value="{{ $p->id }}" data-id="{{ $p->id }}">
                                                   <input type="hidden" name="qty" value="1" class="qty" data-qty="1">
                                                   @foreach(getInStockVarients($p) as $v)
                                                   <input type="hidden" class="varient" data-varient="{{ $v->id }}" name="varient" value="{{ $v->id }}"  data-price='{{ get_price(get_price_varients($v)) }}' data-mrp='{{ get_price(get_mrp_varients($v)) }}' data-savings='{{ get_savings_varients($v) }}' checked>
                                                   @endforeach
                                                   <input type="hidden" class="slug" value="{{ $p->slug }}" data-slug="{{ $p->slug }}">
                                                   @if(count(getInStockVarients($p))>1)
                                                   <li class="add_to_cart productmodal"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                   @else
                                                   <li class="add_to_cart addtocart_single" data-id="{{ $p->id }}" data-varient="{{ $v->id }}" data-qty="1"><a title="Add to cart"><span class="fas fa-shopping-cart"></span></a></li>
                                                   @endif
                                                   <li class="quick_button productmodal"><a title="quick view"><span class="fas fa-search"></span></a></li>
                                                   @endif
                                                   <li class="wishlist"><a title="Add to Wishlist" class="{{ (isset($p->is_favorite) && intval($p->is_favorite)) ? 'saved' : 'save' }}" data-id='{{ $p->id }}'></a></li>
                                                </ul>
                                             </span>
                                          </div>
                                          <div class="price_box">
                                             <span class="current_price">{!! print_price($p) !!}</span>
                                             <span class="old_price">{!! print_mrp($p) !!}</span>
                                             @if(get_savings_varients($p->variants[0]))
                                             <span class="discount-percentage discount-product">{{ get_savings_varients($p->variants[0]) }}</span>
                                             @endif
                                          </div>
                                       </figcaption>
                                    </figure>
                                 </article>
                              </div>
                           @endif
                        @endforeach
                     </div>
                  </div>
                  @else
                  {{-- <div class="row"> --}}
                     <div class="col d-flex justify-content-center align-items-center my-3">
                        <h1 class="text-center my-2">{{__('msg.no_product_found')}}</h1>
                     </div>
                  {{-- </div> --}}
               @endif
               
            </div>
         </div>
      </div>
   </section>
    
    
    
</div>
