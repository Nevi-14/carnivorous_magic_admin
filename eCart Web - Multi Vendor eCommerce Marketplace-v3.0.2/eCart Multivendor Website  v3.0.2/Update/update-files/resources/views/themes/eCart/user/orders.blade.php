<!-- breadcumb -->
<section class="page_title corner-title overflow-visible ">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{__('msg.my_orders')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('my-account') }}">{{__('msg.my_account')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{__('msg.my_orders')}}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->
<div class="order_page main-content">
    <section class="checkout-section ptb-70">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div id="data-step1" class="account-content" data-temp="tabdata">
                        <div id="form-print" class="admission-form-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading-part heading-bg mb-30 px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                                        <h2 class="heading m-0">{{__('msg.my_orders')}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-right">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        @if(isset($data['list']['data']) && isset($data['list']['data']) && count($data['list']['data']))
                                        @foreach($data['list']['data'] as $w)
                                        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded mb-4">
                                            <div class="dash-bg-right-title">
                                                <h6>{{__('msg.ordered_id')}} : {{ $w->id ?? '-'}}</h6>
                                                <h6>{{__('msg.order_date')}} :  {{ isset($w->date_added) ? date('d-m-Y', strtotime($w->date_added)) : '' }}</h6>
                                            </div>
                                            <div class="order-dashboard">
                                                <ul class="order-dash-desc">

                                                    <li>
                                                        <div class="order-desc">
                                                            @if(isset($w->items) && is_array($w->items) && count($w->items))
                                                            <p>{{count($w->items)}}  @if(count($w->items)=='1'){{__('msg.Item')}}@else{{__('msg.Items')}}@endif</p>
                                                            <h4 class="card-title text-dark">
                                                                @foreach ($w->items as $itm)
                                                                @if (isset($itm->id) && intval($itm->id))
                                                                @php
                                                                $names[] = $itm->name;
                                                                @endphp
                                                                @endif
                                                                @endforeach
                                                                {{implode(', ',$names)}}
                                                                @php
                                                                $names = []; 
                                                                @endphp
                                                            </h4>
                                                            @endif
                                                            <h4>{{ get_price(($w->final_total-$w->promo_discount) ?? 0) }}</h4>
                                                            <p>{{__('msg.via')}} {{ strtoupper($w->payment_method) }}</p>
                                                        </div>
                                                    </li>
                                                </ul>

                                                <div class="call-bill">
                                                    <div class="delivery-man">
                                                    </div>
                                                    <div class="order-bill-slip">
                                                        <a href="{{ route('order-track-item', $w->id ?? 0) }}" class="bill-btn hover-btn">{{__('msg.track_order')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                        @else
                                        <div class="row text-center">
                                            <div class="col-12">
                                                <br><br>
                                                <h3>{{__('msg.no_orders_found')}}.</h3>
                                            </div>
                                            <div class="col-12">
                                                <br><br>
                                                <a href="{{ route('shop') }}" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em> {{__('msg.continue_shopping')}}</a>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row mt-3">
                                            <div class="col">
                                                @if(isset($data['last']) && $data['last'] != "")
                                                <a href="{{ $data['last'] }}" class="btn btn-primary pull-left"><em class="fa fa-arrow-left"></em> {{__('msg.previous')}}</a>
                                            </div>
                                            </a>
                                            @endif
                                            <div class="col text-end">
                                                @if(isset($data['next']) && $data['next'] != "")
                                                <a href="{{ $data['next'] }}" class="btn btn-primary pull-right">{{__('msg.next')}} <em class="ml-2 fa fa-arrow-right"></em></a>
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
    </section>
</div>