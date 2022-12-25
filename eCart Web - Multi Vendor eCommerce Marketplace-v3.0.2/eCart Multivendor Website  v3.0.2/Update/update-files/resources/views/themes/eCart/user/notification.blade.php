<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1>{{__('msg.notifications')}}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('my-account') }}">{{__('msg.my_account')}}</a>
               </li>
               <li class="breadcrumb-item active">
                  {{__('msg.notifications')}}
               </li>
            </ol>
            <div class="divider-15 d-none d-xl-block"></div>
         </div>
      </div>
   </div>
</section>
<!-- eof breadcumb -->
<div class="main-content">
   <section class="checkout-section ptb-70 notification__sec">
      <div class="container">
         <div class="row">
            
            <div class="col-lg-12 col-md-12 col-12">
               <section class="about-us ">
                  <div class="about-us-area">
                     <div class="container">
                        @if(isset($data['list']) && isset($data['list']['data']) && count($data['list']['data']))
                        @foreach($data['list']['data'] as $w)
                        <div class="row border_about outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                           <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                              @if(trim($w->image) != "")
                              <div class="about-us-img text-center">
                                 <img class="lazy" data-original="{{ $w->image }}" alt="{{ $w->name }}">
                              </div>
                              @else
                              <div class="about-us-img text-center">
                                 <img class="lazy" data-original="{{ asset('images/no-image.png') }}" alt="notification">
                              </div>
                              @endif
                           </div>
                           <div class="col-xl-6 col-lg-12 col-md-12 col-12 align-self-center">
                              <div class="about-us-content">
                                 <h2>{{ $w->name }}</h2>
                                 <span class="animate-border mb-40"></span>
                                 <p>{{ $w->subtitle }}</p>
                              </div>
                           </div>
                        </div>
                        @endforeach
                        @else
                        <div class="row text-center px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                           <div class="col-12 d-flex justify-content-center align-items-center my-3">
                              <br><br>
                              <h3>{{__('msg.no_notification_found')}}.</h3>
                           </div>
                           <div class="col-12 d-flex justify-content-center align-items-center my-3">
                              <br><br>
                              <a href="{{ route('shop') }}" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em> {{__('msg.continue_shopping')}}</a>
                           </div>
                        </div>
                        @endif
                        <div class="row">
                           <div class="col">
                              @if(isset($data['last']) && $data['last'] != "")
                              <a href="{{ $data['last'] }}" class="btn btn-primary pull-left text-white"><em class="fa fa-arrow-left"></em> {{__('msg.previous')}}</a>
                              @endif
                           </div>
                           <div class="col">
                              @if(isset($data['next']) && $data['next'] != "")
                              <a href="{{ $data['next'] }}" class="btn btn-primary pull-right text-white"> {{__('msg.next')}}<em class="fa fa-arrow-right"></em></a>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
         </div>
      </div>
   </section>
</div>