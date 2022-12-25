<!-- Login / Register Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog" role="document">
      <div class="login_section modal-content">
         <button type="button" class="loginpopup close close-btn" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <!-- Nav tabs -->
         <!-- Tab panes -->
         <div class="tab-content">
            <div class="row justify-content-md-center">
               <div class="col-md-12">
                  <div class="{{ (isset($data['code']) && $data['code'] != '') ? 'error-hide' : '' }}" id="cardLogin">
                     <div class="card mx-auto">
                        <div class="card-body loginsec modal-body">
                           <h4 class="card-title mb-4">{{__('msg.sign_in')}}</h4>
                           <form method="POST" action="{{route('login')}}">
                              <input type="hidden" name="last_url" value="{{ session()->get('last-url') }}">
                              @csrf
                              <div class="form-group">
                                 <input class="form-control" placeholder="Mobile No." name="mobile" type="number" required>
                              </div>
                              <div class="form-group">
                                 <input name="password" class="form-control" placeholder="Password" type="password">
                              </div>
                              <div class="form-group">
                                 <a href="#" class="float-right" id='btnForgot'>{{__('msg.forgot_password')}}</a>
                              </div>
                              <div class="form-group">
                                 <button type="submit" class="btn btn-primary btn-block"> {{__('msg.login')}}  </button>
                              </div>
                           </form>
                           <p class="text-center mt-4">{{__('msg.don')}}'{{__('msg.t_have_account')}} <a href="#" id="btnRegister" class="btn btn-primary btn-block">{{__('msg.sign_up')}}</a></p>
                        </div>
                     </div>
                  </div>
                  <div class="{{ (isset($data['code']) && $data['code'] != '') ? '' : 'error-hide' }}" id="cardRegister">
                     <div class="card mx-auto">
                        <div class="card-body modal-body">
                           <h4 class="card-title mb-4">{{__('msg.register')}} </h4>
                           <form id="formRegister" method="POST">
                              <input type="hidden" name="country_code" value="+1">
                              <input type="hidden" name='action' value='1'>
                              @csrf
                              <div class="form-group">
                                 <div class="alert alert-danger error-hide" id="registerError"></div>
                              </div>
                              <div class="input-group">
                                 <input type="tel" id="phone" class="form-control" required>
                              </div>
                              <br/>
                              <div class="form-group">
                                 <button type="submit" class="btn btn-primary btn-block"> {{__('msg.next')}} </button>
                              </div>
                              <div id="recaptcha-container"></div>
                           </form>
                           <p class="text-center mt-4 alreadyLogin">{{__('msg.already_have_account')}}<a href="#" class="btn btn-primary btnLogin">{{__('msg.login')}} </a></p>
                           <p class="text-center mt-4 backToLogin error-hide" id="backToLogin">{{__('msg.back_to')}} <a href="#" class="btn btn-primary btnLogin">{{__('msg.login')}} </a></p>
                        </div>
                     </div>
                  </div>
                  <div class="card-hide" id="cardOtp">
                     <div class="card mx-auto">
                        <div class="card-body modal-body">
                           <h4 class="card-title mb-4">{{__('msg.verify_your_mobile_number')}}</h4>
                           <form action="{{ route('register') }}" id="formOtpVerification" method="POST">
                              @csrf
                              <input type="hidden" name="auth_uid" required>
                              <input type="hidden" name="country_code" required>
                              <input type="hidden" name='friends_code' value='{{ (isset($data['code']) && $data['code'] != '') ? $data['code'] : '' }}'>
                              <div class="form-group" id="otpSuccess">
                                 <div class="alert alert-success">{{ __('msg.otp_sent_to_mobile_number') }}</div>
                              </div>
                              <div class="form-group">
                                 <div class="alert alert-danger error-hide" id="otpError"></div>
                              </div>
                              <div class="form-group">
                                 <input type="text" name="mobile" class="form-control" readonly>
                              </div>
                              <div class="form-group">
                                 <input type="number" name="otp" class="form-control">
                                 <span id="otp-error"><small class="text-danger error-hide">{{__('msg.please_enter_valid_otp')}}.</small></span>
                              </div>
                              <div class="form-group">
                                 <button id="verifyOtp" class="btn btn-primary btn-block"> {{__('msg.verify_otp')}} </button>
                              </div>
                           </form>
                           <p class="text-center mt-4 alreadyLogin">{{__('msg.already_have_account')}} <a href="#" class="btn btn-primary btnLogin">{{__('msg.login')}}</a></p>
                           <p class="text-center mt-4 backToLogin error-hide" id="backToLogin">{{__('msg.back_to')}} <a href="#" class="btn btn-primary btnLogin">{{__('msg.login')}}</a></p>
                        </div>
                     </div>
                  </div>
                  <div class="card-hide" id="cardResetPassword">
                     <div class="card mx-auto">
                        <div class="card-body modal-body">
                           <h4 class="card-title mb-4">{{__('msg.reset_password')}}</h4>
                           <form action="{{ route('reset-password') }}" id="formResetPassword" method="POST">
                              @csrf
                              <input type="hidden" name="auth_uid" required>
                              <input type="hidden" name="mobile" required>
                              <div class="form-group">
                                 <div class="alert alert-danger error-hide" id="errorResetPassword"></div>
                                 <div class="alert alert-success error-hide" id="successResetPassword"></div>
                              </div>
                              <div class="form-group">
                                 <label>{{__('msg.mobile_number')}}</label>
                                 <input type="text" id="mobileResetPassword" class="form-control" readonly>
                              </div>
                              <div class="form-group">
                                 <label>{{__('msg.new_password')}}</label>
                                 <input type="password" name="password" class="form-control">
                              </div>
                              <div class="form-group">
                                 <label>{{__('msg.confirm_new_password')}}</label>
                                 <input type="password" name="password_confirmation" class="form-control">
                              </div>
                              <div class="form-group">
                                 <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block"> {{__('msg.reset')}}  </button>
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
</div>
{{-- eof signup form --}}
<script src="{{ asset('js/login.js') }}"></script>
