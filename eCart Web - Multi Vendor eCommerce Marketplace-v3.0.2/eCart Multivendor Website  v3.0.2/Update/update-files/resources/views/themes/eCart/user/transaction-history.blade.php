<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1>{{__('msg.transaction_history')}}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('my-account') }}">{{__('msg.my_account')}}</a>
               </li>
               <li class="breadcrumb-item active">
                  {{__('msg.transaction_history')}}
               </li>
            </ol>
            <div class="divider-15 d-none d-xl-block"></div>
         </div>
      </div>
   </div>
</section>
<!-- eof breadcumb -->
<div class="main-content">
   <section class="checkout-section ptb-70 transaction_history">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-3 col-md-12 col-12 mb-4">
               @include("themes.".get('theme').".user.sidebar")
            </div>
            <div class="col-lg-9 col-md-12 col-12">
               <div class="shadow dash-bg-right dash-bg-right1">
                  @if(isset($data['list']) && isset($data['list']['data']) && count($data['list']['data']))
                  <div class="active-offers-body">
                     <div class="table-responsive">
                        <table aria-describedby="wallet-table"
                           class="table offer-table earning-table">
                           <thead class="thead-s-offer">
                              <tr>
                                 <th scope="col">{{__('msg.id')}}</th>
                                 <th scope="col">{{__('msg.payment_gateway')}}</th>
                                 <th scope="col">{{__('msg.date_and_time')}}</th>
                                 <th scope="col">{{__('msg.message')}}</th>
                                 <th scope="col">{{__('msg.amount')}}</th>
                                 <th scope="col">{{__('msg.status')}}</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($data['list']['data'] as $w)
                              <tr>
                                 <td><span class="trans_id">#{{__('msg.id')}}</span>#{{ $w->id }}</td>
                                 <td><span class="trans_payment">{{__('msg.payment_gateway')}}</span>{{ strtoupper($w->type) }}</td>
                                 <td><span class="trans_date">{{__('msg.date_and_time')}}</span>{{ date('d-M-Y H:i A', strtotime($w->date_created)) }}</td>
                                 <td><span class="trans_message">{{__('msg.message')}}</span>{{ $w->message }}</td>
                                 <td><span class="trans_amount">{{__('msg.amount')}}</span>{{ get_price($w->amount, false) }}</td>
                                 <td><span class="trans_status">{{__('msg.status')}}</span><button class="btn btn-sm btn-{{ ($w->status == 'canceled') ? 'danger' : 'success'}}">{{ strtoupper($w->status) }}</button></strong>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
                  @else
                  <div class="row text-center no_history">
                     <div class="col-12">
                        <br><br>
                        <h3>{{__('msg.no_transaction_history_found')}}</h3>
                     </div>
                     <div class="col-12">
                        <br><br>
                        <a href="{{ route('shop') }}" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>{{__('msg.continue_shopping')}}</a>
                     </div>
                  </div>
                  @endif
                  <div class="row pt-3">
                     <div class="col">
                        @if(isset($data['last']) && $data['last'] != "")
                        <a href="{{ $data['last'] }}" class="btn btn-primary pull-left text-white"><em class="fa fa-arrow-left"></em>{{__('msg.previous')}}</a>
                        @endif
                     </div>
                     <div class="col favnext text-end">
                        @if(isset($data['next']) && $data['next'] != "")
                        <a href="{{ $data['next'] }}" class="btn btn-primary pull-right text-white">{{__('msg.next')}} <em class="fa fa-arrow-right"></em></a>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>