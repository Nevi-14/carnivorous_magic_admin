@if ($errors->any())
<div class="container">
   <div class="row">
      <div class="col-md-12 mt-5">
         <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      </div>
   </div>
</div>
@endif
@if(session()->has('suc') && session()->get('suc') != "")
<div class="container">
   <div class="row">
      <div class="col-md-12 mt-5">
         <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session()->get('suc') }}
         </div>
      </div>
   </div>
</div>
@php
session()->put('suc', '');
@endphp
@endif
@if(session()->has('err') && session()->get('err') != "")
<div class="container">
   <div class="row">
      <div class="col-md-12 mt-5">
         <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session()->get('err') }}
         </div>
      </div>
   </div>
</div>
@php
session()->put('err', '');
@endphp
@endif