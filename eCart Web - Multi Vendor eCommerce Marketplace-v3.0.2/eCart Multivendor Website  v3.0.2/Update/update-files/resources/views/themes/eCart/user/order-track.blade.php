<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{__('msg.my_order_track')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('my-account') }}">{{__('msg.my_account')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{__('msg.my_order_track')}}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->
<div class="order_track_page main-content">
    <section class="checkout-section ptb-70">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div id="data-step1" class="account-content" data-temp="tabdata">
                        <div id="form-print" class="admission-form-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading-part heading-bg mb-30 px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                                        <h2 class="heading m-0">{{__('msg.my_orders')}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-right">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="order-dashboard">
                                            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                                                @if(isset($data['list']->items) && is_array($data['list']->items) && count($data['list']->items))
                                                <div class="dash-bg-right-title">
                                                    @if(intval($data['list']->otp))
                                                    <h6>{{ __('msg.order_otp') }} : {{ $data['list']->otp }}</h6>
                                                    @endif
                                                    <h6>{{ __('msg.ordered_id') }} : {{ $data['list']->id }}</h6>
                                                    <h6>{{ __('msg.order_date') }} : {{ $data['list']->date_added ? date('d-m-Y', strtotime($data['list']->date_added)) : '' }}</h6>
                                                    @if ($data['list']->payment_method == 'bank_transfer')

                                                    <h6>{{ __('msg.Account Details!') }} :<br/><br/>
                                                        <ul>
                                                            <li>{{ __('msg.Account Name') }} : {{ Cache::get('payment_methods')->account_name }}</li>
                                                            <li>{{ __('msg.Account Number') }} : {{ Cache::get('payment_methods')->account_number }}</li>
                                                            <li>{{ __('msg.Bank Name') }} : {{ Cache::get('payment_methods')->bank_name }}</li>
                                                            <li>{{ __('msg.Bank Code') }} : {{ Cache::get('payment_methods')->bank_code }}</li>
                                                        </ul>

                                                    </h6>
                                                    <h6>{{ __('msg.Note') }} : {{ Cache::get('payment_methods')->notes }}</h6>
                                                    <h6>{{ __('msg.Bank Payment Receipt') }} : </h6>

                                                    <form method='POST' enctype="multipart/form-data" id="bank_receipt_form">
                                                        @csrf
                                                        <input class="fileinput" type="file" name="image[]" accept="image/jpeg,image/jpg,image/png,application/pdf,image/x-eps" id="bank_receipt" multiple required/>
                                                        <input type="hidden" name="order_id" value="{{ $data['list']->id }}">
                                                        <input type="hidden" name="accesskey" value="90336">
                                                        <input type="hidden" name="upload_bank_transfers_attachment" value="1">
                                                        <button type="submit" name="submit" value="submit" id="submit_btn" class=" btn btn-primary">{{__('msg.Send')}}</button>
                                                    </form>

                                                    <h6 class="r_attach">
                                                        @foreach ($data['list']->attachment as $attach)
                                                        <span class="image_data" id="image_data{{$attach->id}}">
                                                            <input type="hidden" name="order_id" value="{{ $data['list']->id }}" class="order_id">
                                                            <input type="hidden" name="accesskey" value="90336" class="accesskey">
                                                            <input type="hidden" name="delete_bank_transfers_attachment" value="1" class="delete_bank_transfers_attachment">
                                                            <input type="hidden" name="id" value="{{$attach->id}}" class="id">
                                                            <a href="{{$attach->image}}" target="_blank" class="outer_receipt">
                                                                <img src="{{$attach->image}}" class="receipt_img img-fluid">
                                                            </a>
                                                            <i class="fa fa-times attach_image_delete"></i>
                                                        </span>
                                                        @endforeach
                                                    </h6>
                                                    @endif
                                                </div>
                                                @foreach($data['list']->items as $itm)
                                                @php
                                                $allStatus = ['received' => 0, 'processed' => 1, 'shipped' => 2, 'delivered' => 3];
                                                $orderPlaced = "";
                                                $orderAwaiting_payment = "";
                                                $orderProcessed = "";
                                                $orderShipped = "";
                                                $orderDelivered = "";
                                                $orderCancelled = "";
                                                $orderReturned = "";
                                                foreach($itm->status as $s){
                                                if($s[0] == "received"){
                                                $orderPlaced = $s[1];
                                                }elseif($s[0] == "awaiting_payment"){
                                                $orderAwaiting_payment = $s[1];
                                                }elseif($s[0] == "processed"){
                                                $orderProcessed = $s[1];
                                                }elseif($s[0] == "shipped"){
                                                $orderShipped = $s[1];
                                                }elseif($s[0] == "delivered"){
                                                $orderDelivered = $s[1];
                                                }elseif($s[0] == "cancelled"){
                                                $orderCancelled = $s[1];
                                                }elseif($s[0] == "returned"){
                                                $orderReturned = $s[1];
                                                }
                                                }
                                                @endphp

                                                <div class="">
                                                    <ul class="order-dash-desc">
                                                        <li>
                                                            <div class="order-img">
                                                                <img class="lazy" data-original="{{ $itm->image }}"
                                                                     alt="{{ $itm->name ?? 'Product Image'}}">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="order-desc">
                                                                <h4>{{ $itm->name }}</h4>
                                                                <p>{{__('msg.qty :')}}{{ $itm->quantity }}</p>
                                                                <p>{{ get_price(($itm->sub_total) ?? 0) }}</p>
                                                                <p>{{__('msg.via')}} {{ strtoupper($data['list']->payment_method) }}</p>
                                                                @php
                                                                $orderColor='';
                                                                if($itm->active_status == "received"){
                                                                $orderColor = 'received_status_bg';
                                                                }elseif($itm->active_status == "processed"){
                                                                $orderColor = 'awaiting_status_bg';
                                                                }elseif($itm->active_status == "shipped"){
                                                                $orderColor = 'shipped_status_bg';
                                                                }elseif($itm->active_status == "delivered"){
                                                                $orderColor = 'delivered_status_bg';
                                                                }elseif($itm->active_status == "cancelled"){
                                                                $orderColor = 'returned_and_cancel_status_bg';
                                                                }elseif($itm->active_status == "returned"){
                                                                $orderColor = 'returned_and_cancel_status_bg';
                                                                }
                                                                @endphp
                                                                <p class="order__status {{$orderColor}}">{{ strtoupper($itm->active_status) }}</p>
                                                                @if ($orderCancelled == '')
                                                                @if (intval($itm->cancelable_status) && intval($allStatus[$itm->active_status] ?? 0) <= intval($allStatus[$itm->till_status ?? 0]))
                                                                <span class="form-group orderalign">
                                                                    <a role="button" href="{{ route('order-item-status', ['orderId' => $data['list']->id, 'orderItemId' => $itm->id, 'status' => 'cancelled']) }}" data-confirm="Are you sure, you want to cancel this item?">
                                                                        <button class="btn btn-sm btn-primary">
                                                                            {{ __('msg.cancel_item') }}
                                                                        </button>
                                                                    </a>
                                                                </span>
                                                                @endif
                                                                @if ($orderDelivered != '' && intval($itm->return_status))
                                                                <span class="form-group orderalign">
                                                                    <a role="button" href="{{ route('order-item-status', ['orderId' => $data['list']->id, 'orderItemId' => $itm->id, 'status' => 'returned']) }}"
                                                                       data-confirm="Are you sure, you want to return this item?">
                                                                        <button class="btn btn-sm btn-primary">
                                                                            {{ __('msg.return_item') }}
                                                                        </button>
                                                                    </a>
                                                                </span>
                                                                @endif
                                                                @endif
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    

                                                    <div class="call-bill ">
                                                        <div class="delivery-man">
                                                        </div>
                                                        <div class="order-bill-slip  ">
                                                            <a class="bill-btn hover-btn track_order_btn ">Track Order</a>
                                                            <input type="hidden" name="shipment_id" value="{{$itm->shipment_id}}">
                                                            <input type="hidden" name="order_item_id" value="{{$itm->id}}">
                                                            <input type="hidden" name="order_status" value="{{$itm->active_status}}">
                                                        </div>
                                                    </div>


                                                    <div>
                                                        <div class="delivery-man"></div>
                                                    </div>

                                                </div>
                                                @endforeach
                                                <div class="modal fade track_order_view" id="productvariant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="quick_view modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"><em class="fas fa-times"></em></span>
                                                                </button>
                                                                <div class="modal_body product_details">
                                                                    <div class="container productmodaldetails">
                                                                        <span class="timeline_content">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <span class="form-group orderalign mb-3 mr-10">
                                                    <a role="button" href="{{ route('re-order', ['orderId' => $data['list']->id]) }}" data-confirm="Are you sure, you want to re-order this order?">
                                                        <button class="btn btn-sm btn-primary">
                                                            {{ __('msg.re_order') }}
                                                        </button>
                                                    </a>
                                                </span>

                                                <span class="form-group orderalign mb-3">
                                                    <a role="button" href="{{ route('invoice_pdf', ['orderId' => $data['list']->id]) }}" class="btn btn-sm btn-dark" target="_blank">
                                                        <i class="fas fa-file-invoice pe-2"></i>{{ __('msg.invoice') }}
                                                    </a>
                                                    
                                                </span>

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                                            <h3 class="m-2 font-weight-bold text-dark text-start">{{__('msg.price_detail')}}</h3>
                                            <table class="table table-hover" aria-describedby="order-trak">
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>

                                                <tr>
                                                    <td>{{__('msg.items_amount')}} :</td>
                                                    <td>{{ get_price($data['list']->total, false)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('msg.delivery_charge')}} :</td>
                                                    <td>+ {{ get_price($data['list']->delivery_charge, false)}}</td>
                                                </tr>

                                                <tr>
                                                    <td>{{__('msg.discount')}}(0%) :</td>
                                                    <td>- {{ get_price($data['list']->discount, false)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('msg.total')}} : </td>
                                                    <td><strong>{{ get_price(floatval($data['list']->total) + floatval($data['list']->delivery_charge) - floatval($data['list']->discount), false)}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('msg.promo_code_discount')}} :</td>
                                                    <td>- {{ get_price($data['list']->promo_discount, false) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('msg.wallet_balance')}}  : </td>
                                                    <td>-{{ get_price($data['list']->wallet_balance, false) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>{{__('msg.final_total')}} :</strong> </td>
                                                    <td><strong>{{ get_price(($data['list']->final_total-$data['list']->promo_discount), false) }}</strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                                            <h3 class="m-2 font-weight-bold text-dark text-start">{{__('msg.other_details')}}</h3>
                                            <table class="table table-hover" aria-describedby="otherdetails">
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                                <tr>
                                                    <td>{{__('msg.name')}} : {{ $data['list']->user_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('msg.mobile_no')}}: {{ $data['list']->mobile }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('msg.address')}} : {{ $data['list']->address ?? '' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--- cancel confirm box -->
        <div class="modal" id="modal">
            <div class="modal-dialog mt-2">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="Cancel__item">
                            <span class="text-dark text-center">{{ __('msg.are_you_sure') }}</span>
                            <a href="" id="modal-btn-yes" class="btn text-primary font-weight-bold">{{ __('msg.yes') }}</a>
                            <button type="button" class="btn font-weight-bold text-primary" data-bs-dismiss="modal">{{ __('msg.no') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--- cancel confirm box -->
    </section>
</div>