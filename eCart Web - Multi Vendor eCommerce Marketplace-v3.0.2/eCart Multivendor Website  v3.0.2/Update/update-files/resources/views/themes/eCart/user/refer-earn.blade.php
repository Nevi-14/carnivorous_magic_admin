<section class="section-content footerfix padding-bottom">
    <a href="#" id="scroll"><span></span></a>
    <div class="container mt-5 ">
        <div class="row">
            <div class="col-md-3 col-12 mb-4">
               @include("themes.".get('theme').".user.sidebar")
            </div>
            <div class="col-md-9 col-12 referearn">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded w-100 mb-3">
                    <div class="card-body">
                        <p class="card-text ">
                            <em class="fas fa-wallet align-content-left wallet"></em>
                            <span class="text-wrap ">{{__('msg.refer_earn')}}.
                                {{__('msg.minimun_order_amount_soul')}}
                                {{__('msg.which_allows_you')}}.
                            </span>
                        </p>
                    </div>
                </div>
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded w-100">
                    <div class="row text-center mb-2">
                        <div class="col gift">
                            <em class="fa fa-gift"></em>
                        </div>
                     </div>
                    <div class="row text-center mb-3">
                        <div class="col">
                            <span class="text-center">{{__('msg.refer_and_earn')}}</span>
                        </div>
                    </div>
                    <div class="row text-center mb-4">
                        <div class="col">
                            <span class="text-danger">{{__('msg.your_referral_link')}}</span>
                        </div>
                    </div>
                    <div class="copycode_refer">
                        <input type="text" name="refercode" id='referCode' class="rounded text-center refer-border" value="{{  env("APP_URL", "") .'refer/' .$data['profile']->referral_code }}">
                        <button class="copy-btn">
                            <span class="icon1">
                               <a href="#" onclick="copycode()"> <i class="fas fa-copy"></i>&nbsp;{{__('msg.tap_to_copy')}}</a>
                            </span>

                        </button>
                    </div>

                    <div class="row text-center mt-2 mb-3 refernow">
                        <div class="col">
                            <a href="{{ route('refer', $data['profile']->referral_code) }}" target="_blank" class="btn btn-primary rounded text-capitalize refer-share"><em class="fa fa-share-alt"></em> {{__('msg.refer_now')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>