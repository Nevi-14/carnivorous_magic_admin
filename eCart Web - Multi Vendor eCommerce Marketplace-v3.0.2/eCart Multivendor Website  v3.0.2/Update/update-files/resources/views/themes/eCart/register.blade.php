<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1>{{__('msg.register')}}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('home') }}">{{__('msg.home')}}</a>
               </li>
               <li class="breadcrumb-item active">
                  {{__('msg.register')}}
               </li>
            </ol>
            <div class="divider-15 d-none d-xl-block"></div>
         </div>
      </div>
   </div>
</section>
<section class="footerfix section-content mt-5 padding-bottom mb-4">
   <div class="container">
   <div class="card mx-auto register-card card dash-bg-right dash-bg-right1">
      <article class="card-body modal-body">
         <header class="mb-4">
            <h4 class="card-title">{{__('msg.sign_up')}}</h4>
         </header>
         <form method='POST' id='registerForm'>
            @csrf
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="auth_uid" value="{{ $data['auth_uid'] }}">
            <input type="hidden" name="mobile" value="{{ $data['mobile'] }}">
            <input type="hidden" name="country" value="{{ $data['country'] }}">
            <div class="form-group">
               <div class="alert alert-danger error-hide" id="registerError"></div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-6 col-12">
                  <div class="form-group mt-1">
                     <label>{{__('msg.full_name')}}</label>
                     <div class="ui search focus">
                        <div class="ui left icon input card-detail-desc">
                           <input type="text" name='display_name' class="form-control" value='{{ $data['display_name'] }}' required autofocus>
                        </div>
                     </div>
                  </div>
               </div>
               <br/>
               <div class="col-md-6 col-12">
                  <div class="form-group mt-1">
                     <label>{{__('msg.email')}}</label>
                     <div class="ui search focus">
                        <div class="ui left icon input card-detail-desc">
                           <input type="email" class="form-control" name='email' placeholder="" value='{{ $data['email'] }}' required>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-6 col-12">
                   <div class="form-row mt-1">
                     <label>{{__('msg.mobile')}}</label>
                     <div class="ui search focus">
                        <div class="ui left icon input card-detail-desc">
                           <input type="text" class="form-control" name='mobile' placeholder="" value='{{ $data['mobile'] }}' readonly>
                        </div>
                     </div>
                  </div>
               </div>
               <br/>
               <div class="col-md-6 col-12">
                  <div class="form-row mt-1">
                     <div class="form-group">
                        <label>{{__('msg.create_password')}}</label>
                        <div class="ui search focus">
                           <div class="ui left icon input card-detail-desc">
                              <input class="form-control" name='password' type="password" required>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-6 col-12">
                     <div class="form-group mt-1">
                     <label>{{__('msg.repeat_password')}}</label>
                     <div class="ui search focus">
                        <div class="ui left icon input card-detail-desc">
                           <input class="form-control" name='password_confirmation' type="password" required>
                        </div>
                     </div>
                  </div>
               </div>
               <br/>
               <div class="col-md-6 col-12">
                  <div class="form-row mt-1">
                     <label>{{__('msg.referral_code')}}</label>
                     <div class="ui search focus">
                        <div class="ui left icon input card-detail-desc">
                           <input class="form-control" name='friends_code' type="text" value='{{ $data['friends_code'] }}'>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <br/>
            <div class="form-group mt-1">
               <div class="ui search focus">
                  <div class="ui left icon input ">
                     <input type="checkbox" class="custom-control-input" required>&nbsp;&nbsp;
                     <div class="custom-control-label">   {{__('msg.I am agree with')}} <a href="{{ route('page', 'tnc') }}" target="_blank">{{__('msg.terms and contitions')}}</a>  </div>
                  </div>
               </div>
               <br/>
               <div class="form-group mt-1">
                  <button type="submit" class="btn btn-primary btn-block"> {{__('msg.register')}}  </button>
               </div>
         </form>
      </article>
      </div>
   </div>
</section>
<script src="{{ asset('js/register.js') }}"></script>