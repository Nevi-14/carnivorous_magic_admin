<div class="account-sidebar account-tab px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
    <div class="dark-bg tab-title-bg">
       <div class="heading-part">
          <div class="sub-title text-center"><span></span><em class="far fa-user"></em> {{__('msg.my_account')}}
          </div>
       </div>
    </div>
    <div class="account-tab-inner">
       <ul class="account-tab-stap">
          <li>
             <a href="{{ route('my-account') }}"><em class="fas fa-user"></em>{{__('msg.my_profile')}}<em class="fa fa-angle-right"></em> </a>
           </li>
          <li>
             <a href="{{ route('change-password') }}"><em class="fas fa-asterisk"></em>{{__('msg.change_password')}}<em class="fa fa-angle-right"></em> </a>
           </li>
          <li>
             <a href="{{ route('my-orders') }}"><em class="fas fa-taxi"></em>{{__('msg.my_orders')}}<em class="fa fa-angle-right"></em> </a>
           </li>
          <li>
             <a href="{{ route('notification') }}"><em class="fas fa-bell"></em>{{__('msg.notifications')}}<em class="fa fa-angle-right"></em> </a>
           </li>
          <li>
             <a href="{{ route('favourite') }}"><em class="fas fa-heart"></em>{{__('msg.favourite')}}<em class="fa fa-angle-right"></em> </a>
           </li>
          <li>
             <a href="{{ route('transaction-history') }}"><em class="fas fa-outdent"></em>{{__('msg.transaction_history')}}<em class="fa fa-angle-right"></em> </a>
           </li>
          <li>
             <a href="{{ route('addresses') }}"><em class="fas fa-wrench"></em>{{__('msg.manage_addresses')}}<em class="fa fa-angle-right"></em> </a>
           </li>
          <li>
             <a href="{{ route('logout') }}"><em class="fas fa-sign-out-alt"></em>{{__('msg.logout')}}<em class="fa fa-angle-right"></em> </a>
           </li>
       </ul>
    </div>
 </div>