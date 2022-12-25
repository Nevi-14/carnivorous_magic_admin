

{{-- subscribe sec --}}
<section class="subscribe-news">
   <div class="newsletter">
      <div class="container-fluid">
         <div class="newsletter-inner center-sm">
            <div class="row justify-content-center align-items-center">
               <div class="col-md-12">
                  <div class="newsletter-bg">
                     <div class="row  align-items-center">
                        <div class="col-xl-6 col-lg-6">
                           <div class="d-lg-flex align-items-center">
                              <div class="newsletter-icon">
                                 <em class="far fa-envelope-open fa-3x"></em>
                              </div>
                              <div class="newsletter-title">
                                 <h2 class="main_title">{{ __('msg.subscribe_to_our_newsletter') }}</h2>
                                 <div class="sub-title">{{ __('msg.newsletter_line') }}
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                           <form action="{{ route('newsletter') }}" method="POST" class="ajax-form">
                              @csrf
                              <div class="formResponse"></div>
                              <div class="newsletter-box">
                                 <input type="email"  id="email" name="email" placeholder="Email Here..." required>
                                 <button title="Subscribe" name="submit" type="submit" class="btn-color">{{ __('msg.subscribe') }}</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

{{-- footer --}}
<footer class="footer" id="iconfooter3">
   <div class="container-fluid">
      <hr>
      <div class="footer-inner">
         <div class="footer-middle">
            <div class="row">
               <div class="col f-col">
                  <div class="footer-static-block">
                     <span class="opener plus"></span>
                     <div class="f-logo">
                        <a href="{{ route('home') }}" class="">
                        <img src="{{ _asset(Cache::get('web_logo')) }}" alt="Logo">
                        </a>
                     </div>
                     <div class="footer-respond">
                        <p class="company__desc">{{ Cache::get('common_meta_description', '') }}</p>
                        @if(trim(Cache::get('android_app_url', '')) != '')
                        <a target="_blank" href="{{ Cache::get('android_app_url', 'https://play.google.com') }}" class="app_button">
                        <img src="{{ _asset(Cache::get('google_play', theme('images/google1.png'))) }}" alt="Google Play Store">
                        </a>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="col f-col">
                  <div class="footer-static-block">
                     <span class="opener plus"></span>
                     <h3 class="title">{{ __('msg.customer_services') }} <span
                        class="animate-border animate-border border-black"></span><em
                        class="fas fa-angle-down arrowdown"></em></h3>
                     <ul class="collapse dont-collapse-sm link">
                        <li><a href="{{ route('page', 'privacy-policy') }}">{{ __('msg.privay_policy')}}</a></li>
                        <li><a href="{{ route('page', 'tnc') }}">{{ __('msg.terms_and_conditions')}}</a></li>
                        <li><a href="{{ route('page', 'refund-policy') }}">{{ __('msg.refund_policy')}}</a></li>
                        <li><a href="{{ route('page', 'shipping-policy') }}">{{ __('msg.shipping_policy')}}</a></li>
                        <li><a href="{{ route('page', 'delivery-returns-policy') }}">{{ __('msg.delivery_returns')}}</a></li>
                     </ul>
                  </div>
               </div>
               <div class="col f-col">
                  <div class="footer-static-block">
                     <span class="opener plus"></span>
                     <h3 class="title">pages <span
                        class="animate-border animate-border border-black"></span><em
                        class="fas fa-angle-down arrowdown"></em></h3>
                     <ul class="collapse dont-collapse-sm link">
                        <li><a href="{{ route('about') }}">{{ __('msg.about_us')}}</a></li>
                        <li><a href="{{ route('shop') }}">{{ __('msg.shop')}} </a></li>
                        <li><a href="{{ route('page', 'faq') }}">{{ __('msg.faq')}}</a></li>
                        <li><a href="{{ route('contact') }}">{{ __('msg.contact_us')}} </a></li>
                     </ul>
                  </div>
               </div>
               <div class="col f-col">
                  <div class="footer-static-block">
                     <span class="opener plus"></span>
                     <h3 class="title">{{ __('msg.address')}} <span
                        class="animate-border animate-border border-black"></span><em
                        class="fas fa-angle-down arrowdown"></em></h3>
                     <ul class="collapse dont-collapse-sm address-footer">
                        @php
                        $store_address = str_ireplace("<br>", ' ',  Cache::get('store_address') );
                        @endphp
                        @if(trim(Cache::get('store_address', '')) != '')
                        <li class="item company__address">
                           <em class="fas fa-map-marker"> </em>
                           <p>{{ $store_address }}</p>
                        </li>
                        @endif
                        <li class="item">
                           <em class="fas fa-envelope"> </em>
                           <p> <a href="#">{{ Cache::get('support_email')}}</a> </p>
                        </li>
                        <li class="item">
                           <em class="fas fa-phone"> </em>
                           <p>{{ Cache::get('support_number')}}</p>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col f-col">
                  <div class="footer-static-block">
                     <span class="opener plus"></span>
                     <h3 class="title">{{ __('msg.reach_us')}} <span
                        class="animate-border animate-border border-black"></span><em
                        class="fas fa-angle-down arrowdown"></em></h3>
                     <div class="footer-respond">
                        <iframe
                           width="100%"
                           height="200"
                            allowfullscreen="" aria-hidden="false" tabindex="0" title="map"
                           src="https://maps.google.com/maps?q=+{{ Cache::get('map_latitude') }}+,+{{ Cache::get('map_longitude') }}+&hl=en&z=18&amp;output=embed">
                        </iframe>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
         <hr>
         <div class="footer-bottom ">
            <div class="row mtb-30">
               <div class="col-md-4 col-12 ">
                  @if(Cache::has('social_media') && is_array(Cache::get('social_media')) && count(Cache::get('social_media')))
                  <div class="footer_social pt-xs-15 center-sm">
                     <ul class="social-icon">
                        <li>
                           <div class="title">{{ __('msg.follow_us_on')}}</div>
                        </li>
                        @foreach(Cache::get('social_media') as $i => $c)
                        <li><a href="{{ $c->link }}" target="_blank"><em class="fab {{ $c->icon }}"></em></a></li>
                        @endforeach
                     </ul>
                  </div>
                  @endif
               </div>
               <div class="col-md-4 col-12 ">
                  <div class="copy-right ">{{__('msg.copyright')}} &copy; {{date('Y')}} {{__('msg.made')}} <a href="https://wrteam.in/" target="_blank" rel="noopener noreferrer">{{__('msg.wrteam')}}.</a>
                  </div>
               </div>
               <div class="col-md-4 col-12">
                  <div class="payment">
                     <div class="payment_icon">
                        <ul>
                           <li>
                              @if(isset(Cache::get('payment_methods')->cod_payment_method) && Cache::get('payment_methods')->cod_payment_method == 1)
                              <img src="{{URL::asset('images/cod.svg')}}" alt="">
                              @endif
                           </li>
                           <li>
                              @if(isset(Cache::get('payment_methods')->paypal_payment_method) && Cache::get('payment_methods')->paypal_payment_method == 1)
                              <img src="{{URL::asset('images/paypal.svg')}}" alt="" >
                              @endif
                           </li>
                           <li>
                              @if(isset(Cache::get('payment_methods')->payumoney_payment_method) && Cache::get('payment_methods')->payumoney_payment_method == 1)
                              <img src="{{URL::asset('images/payu.svg')}}" alt="">
                              @endif
                           </li>
                           <li>
                              @if(isset(Cache::get('payment_methods')->razorpay_payment_method) && Cache::get('payment_methods')->razorpay_payment_method == 1)
                              <img src="{{URL::asset('images/rozerpay.svg')}}" alt="">
                              @endif
                           </li>
                           <li>
                              @if(isset(Cache::get('payment_methods')->stripe_payment_method) && Cache::get('payment_methods')->stripe_payment_method == 1)
                              <img src="{{URL::asset('images/stripe.svg')}}">
                              @endif
                           </li>
                           <li>
                              @if(isset(Cache::get('payment_methods')->midtrans_payment_method) && Cache::get('payment_methods')->midtrans_payment_method == 1)
                              <img src="{{URL::asset('images/midtrans.svg')}}" alt="" >
                              @endif
                           </li>
                           <li>
                              @if(isset(Cache::get('payment_methods')->flutterwave_payment_method) && Cache::get('payment_methods')->flutterwave_payment_method == 1)
                              <img src="{{URL::asset('images/flutterwave.svg')}}" alt="" >
                              @endif
                           </li>
                           <li>
                              @if(isset(Cache::get('payment_methods')->paystack_payment_method) && Cache::get('payment_methods')->paystack_payment_method == 1)
                              <img src="{{URL::asset('images/paystack.svg')}}" alt="" >
                              @endif
                           </li>
                           <li>
                              @if(isset(Cache::get('payment_methods')->paytm_payment_method) && Cache::get('payment_methods')->paytm_payment_method == 1)
                              <img src="{{URL::asset('images/paytm.svg')}}" alt="" >
                              @endif
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>

            </div>
         </div>

   </div>
</footer>
<!-- dark mode -->
<div id="switch-mode">
   <span class="dark-mode mode-control">
      <em class="fas fa-moon"></em>
   </span>
   <span class="light-mode mode-control d-none">
      <em class="fas fa-sun"></em>
   </span>
</div>

<!-- color switcher -->
@if(Cache::get('show_color_picker_in_website')=='1')
<div class="demo-style-switch" id="switch-style">
   <a id="toggle-switcher" class="switch-button"><em class="far fa-sun fa-spin"></em></a>
   <div class="switched-options">
      <ul class="styles color-inputs">
         <li>
            <label>{{__('msg.custom_color')}}</label>
            <span class="sp-original-input-container">
               <div class="sp-colorize-container sp-add-on">
                  <div class="sp-colorize"></div>
               </div>
               <input id="theme-color-master" value="#ff9900" name="theme-color-master" class="spectrum with-add-on">
            </span>
         </li>
      </ul>
   </div>
</div>
@endif
</body>
</html>

<!-- this for gulp if you dont know about that then dont change it or not uncomment it-->
<!-- ****************************** gulp start **************************************** -->

<!-- ltr gulp -->
<!--<script src="{{ theme('js/footerbundle.js') }}"></script>-->

<!-- rtl gulp-->
<!-- <script src="{{ theme('js/rtlfooterbundle.js') }}"></script> -->

<!-- ****************************** gulp end **************************************** -->

<script src="{{ theme('js/plugins.js') }}"></script>
<script src="{{ theme('js/semantic.min.js') }}"></script>
<script src="{{ theme('js/elevatezoom.js') }}"></script>
<script src="{{ theme('js/owl-carousel.js') }}"></script>
<script src="{{ theme('js/wow.js') }}"></script>
<script src="{{ theme('js/script.js') }}"></script>
<script src="{{ theme('js/cartajax.js') }}"></script>
<script src="{{ theme('js/cartpageajax.js') }}"></script>
<script src="{{ theme('js/lazy.js') }}"></script>
<script src="{{ theme('js/spectrum.min.js') }}"></script>

<!--rtl-->
{{-- <script src="{{ theme('js/rtlscript.js') }}"></script> --}}



<!-- common outer js -->
<script src="{{ asset('js/script.js') }}"></script>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="{{ asset('js/firebase-app.js') }}"></script>
<script src="{{ asset('js/firebase-analytics.js') }}"></script>
<script src="{{ asset('js/firebase-auth.js') }}"></script>
<script src="{{ asset('js/firebase-firestore.js') }}"></script>
<script src="{{ asset('js/firebase.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"></script>


<script>

var messaging = firebase.messaging();

function initFirebaseMessagingRegistration() {
    messaging.requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (token) {
               
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("save-token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        
                    },
                    error: function (err) {
                        console.log('User Chat Token Error' + err);
                    }
                });
            }).catch(function (err) {
        console.log('User Chat Token Error' + err);
    });
}

messaging.onMessage(function (payload) {
    const string = payload.data.data;

    var obj = jQuery.parseJSON(payload.data.data);
const url = window.location.origin;
    const noteTitle = obj.title;
    const noteOptions = {
        body: obj.message,
        icon: obj.image,
        
       data:{
        time: new Date(Date.now()).toString(),
         click_action: '/orders'
    }
    };
    new Notification(noteTitle, noteOptions);
});

$(document).ready(initFirebaseMessagingRegistration());
</script>
