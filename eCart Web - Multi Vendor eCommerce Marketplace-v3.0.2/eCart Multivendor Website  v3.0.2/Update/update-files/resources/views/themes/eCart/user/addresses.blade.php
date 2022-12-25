<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{__('msg.my_address')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">{{__('msg.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{__('msg.my_address')}}
                    </li>
                </ol>
                <div class="divider-15 d-none d-xl-block"></div>
            </div>
        </div>
    </div>
</section>
<!-- eof breadcumb -->
<div class="main-content">
    <section class="checkout-section ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 mb-4">
                    @include("themes.".get('theme').".user.sidebar")
                </div>
                <div class="col-lg-9 col-md-12 col-12">
                    @if(isset($data['address']) && is_array($data['address']) && count($data['address']))
                    <div id="data-step1" class="">
                        <div class="m-0 outer_box px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded"  id="address">

                            <div class="row" id="mydesc">
                                <div class="section_title d-flex mb-3 align-items-baseline border-bottom pl-0">
                                    <h2>
                                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block ">{{__('msg.Account Information')}}</span>
                                    </h2>
                                </div>

                                <form action="{{ route('checkout') }}" method="POST">
                                    <div class="row">
                                        @foreach($data['address'] as $a)
                                        @if(isset($a->id) && intval($a->id))
                                        <div class="col-md-6 mb-1">
                                            <div class="cart-total-table address-box commun-table">
                                                <div class="table-responsive">
                                                    <table class="table table-shopping-cart" aria-describedby="mydesc" aria-hidden="true">
                                                        <thead>
                                                            <tr class="delivery-address">
                                                                @if(Cache::has('local_shipping') && Cache::get('local_shipping') == '1' )
                                                                @if($a->city_id != '0')
                                                                <th scope="col"><input type="radio"  name="id" value="{{ $a->id }}" {{ (count($data['address']) == 1 || (isset($a->is_default) && intval($a->is_default)) ? 'checked=checked' : '') }}> {{ $a->type }}
                                                                    @else
                                                                <th scope="col"><input type="radio" disabled name="id" value="{{ $a->id }}"> {{ $a->type }} <em data-tooltip-address title="{{__('msg.Address is not selectable because selected address is belongs to local shipping')}}" class="fas fa-info-circle tip"></em>
                                                                    @endif
                                                                    @else
                                                                    @if($a->city_id == '0')
                                                                <th scope="col"><input type="radio"  disable name="id" value="{{ $a->id }}"> {{ $a->type }}
                                                                    @else
                                                                <th scope="col"><input type="radio"  name="id" value="{{ $a->id }}" {{ (count($data['address']) == 1 || (isset($a->is_default) && intval($a->is_default)) ? 'checked=checked' : '') }}> {{ $a->type }} <em data-tooltip-address title="{{__('msg.Address is not selectable because selected address is belongs to standard shipping')}}" class="fas fa-info-circle tip"></em>
                                                                    @endif
                                                                    @endif
                                                                    <span class="form-group edit-delete">
                                                                        <button class="btn editAddress" data-data='{{ json_encode($a) }}'> <em class="fa fa-pencil-alt"></em></button>
                                                                        <a href="{{ route('address-remove', $a->id) }}" class="btn"> <em class="fas fa-times text-danger"></em></a>
                                                                    </span>
                                                                </th>
                                                            </tr>
                                                        </thead>


                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <ul class="address__data">
                                                                        <li class="inner-heading"> <strong>{{ $a->name ?? '' }}</strong></li>
                                                                        <li>
                                                                            <p>{{ $a->address ?? '' }}, {{ $a->area ?? '' }}<br>
                                                                                {{ $a->city ?? ''}} - {{ $a->pincode ?? '' }}<br>
                                                                                {{__('msg.mobile')}}: {{ ($a->country_code ?? '') ." ". ($a->mobile ?? '-') }}
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="add_new_address_btn">
                                            <span onclick="address()" class="btn btn-primary">{{__('msg.add_new_address')}}&nbsp;&nbsp;<em class="fas fa-plus"></em></span>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12" id="editAddress">
                                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                                    <div class="section_title d-flex mb-3 align-items-baseline border-bottom pl-0">
                                        <h2>
                                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block ">{{__('msg.edit_address')}}</span>
                                        </h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg">
                                                <form action="{{ route('address-add') }}" id='formEditAddress' method="POST">
                                                    <input type="hidden" name="id">
                                                    <input type="hidden" name="latitude" value="0">
                                                    <input type="hidden" name="longitude" value="0">
                                                    <input type="hidden" name="country_code" value="0">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.name')}}</label>
                                                            <div class="ui search focus">
                                                                <div class="ui left icon input card-detail-desc">
                                                                    <input class="form-control" name="name" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.mobile_no')}}</label>
                                                            <div class="ui search focus">
                                                                <div class="ui left icon input card-detail-desc">
                                                                    <input class="form-control" id='editPhone' type="number" name="mobile">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.alternate_mobile_no')}}</label>
                                                            <div class="ui search focus">
                                                                <div class="ui left icon input card-detail-desc">
                                                                    <input class="form-control" type="number" name="alternate_mobile">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.address')}}</label>
                                                            <div class="ui search focus">
                                                                <div class="ui left icon input card-detail-desc">
                                                                    <input class="form-control" type="text" name="address">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.landmark')}}</label>
                                                            <div class="ui search focus">
                                                                <div class="ui left icon input card-detail-desc">
                                                                    <input class="form-control" type="text" name="landmark">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.select_city')}}</label>
                                                            <br>

                                                            <select name='city_id' class="form-control" required></select>

                                                            <div class="ui search focus">
                                                                <div class="ui left icon input card-detail-desc">
                                                                    <input class="form-control" type="text" placeholder="City" name="city_name" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.select_area')}}</label>
                                                            <br>

                                                            <select name='area_id' class="form-control" required></select>

                                                            <div class="ui search focus">
                                                                <div class="ui left icon input card-detail-desc">
                                                                    <input class="form-control" type="text" placeholder="Area" name="area_name" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.pincode')}}</label>
                                                            <br>

                                                            <select name='pincode_id' class="form-control" required readonly></select>

                                                            <div class="ui search focus">
                                                                <div class="ui left icon input card-detail-desc">
                                                                    <input class="form-control" type="text" placeholder="Pincode" name="pincode" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.state')}}</label>
                                                            <input class="form-control" type="text" name="state" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('msg.country')}}</label>
                                                            <input class="form-control" type="text" name="country" required>
                                                        </div>
                                                    </div>
                                                    <br/>


                                                    <div class="d-flex">
                                                        <div class="form-group mr-20">
                                                            <label class="radio-inline">
                                                                <input class="mr-2" type="radio" name="type" checked value="Home">{{__('msg.home')}}
                                                            </label>
                                                        </div>
                                                        <div class="form-group mr-20">
                                                            <label class="radio-inline  ml-5">
                                                                <input class="mr-2" type="radio" name="type" value="Work">{{__('msg.work')}}
                                                            </label>
                                                        </div>
                                                        <div class="form-group mr-20">
                                                            <label class="radio-inline  ml-5">
                                                                <input class="mr-2" type="radio" name="type" value="Other">{{__('msg.other')}}
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <br/>
                                                    <div class="form-group mt-1">
                                                        <input type="checkbox" name="is_default" class=" mt-1" />
                                                        <label class="control-label" for="default-address"> {{__('msg.set_as_default_address')}}</label>
                                                    </div>
                                                    <br/>
                                                    <hr>
                                                    <div class="form-group text-end">
                                                        <button type="submit" class="btn btn-primary btn-block text-uppercase"> {{__('msg.update')}} {{__('msg.address')}}</button>
                                                        <button class="btn btn-primary btn-block text-uppercase AddEditAddressCancel"> {{__('msg.cancel')}} </button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row padding-bottom {{ count($data['address']) > 0 ? '' : 'visible' }}">
                        <div class="col-md-12" id="addAddress">
                            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded">
                                <div class="section_title d-flex mb-3 align-items-baseline border-bottom pl-0">
                                    <h2>
                                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block ">{{__('msg.add_new_address')}}</span>
                                    </h2>
                                </div>
                                <div class="card-body add-cash-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <form action="{{ route('address-add') }}" id='formAddAddress' method='POST'>
                                                <input type="hidden" name="latitude" value="0">
                                                <input type="hidden" name="longitude" value="0">
                                                <input type="hidden" name="country_code" value="0">
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-12">
                                                        <label class="">{{__('msg.name')}}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="card-inputfield" name="name" type="text" placeholder="Name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>{{__('msg.mobile_no')}}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="form-control card-inputfield" id='addPhone' type="number" placeholder="Mobile No" name="mobile" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="form-group  col-md-6 col-12">
                                                        <label>{{__('msg.alternate_mobile_no')}}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="form-control" type="number" placeholder="Altername Mobile No" name="alternate_mobile">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>{{__('msg.address')}}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="form-control" type="text" placeholder="Address" name="address" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>{{__('msg.landmark')}}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="form-control" type="text" placeholder="Landmark" name="landmark" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>{{__('msg.select_city')}}</label>
                                                        <br>
                                                        @if(Cache::get('local_shipping')=='1')
                                                        <select name='city_id' class="form-control" required></select>
                                                        @else
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="form-control" type="text" placeholder="City" name="city_name" required>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>

                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>{{__('msg.select_area')}}</label>
                                                        <br>
                                                        @if(Cache::get('local_shipping')=='1')
                                                        <select name='area_id' class="form-control" required></select>
                                                        @else
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="form-control" type="text" placeholder="Area" name="area_name" required>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>{{__('msg.pincode')}}</label>
                                                        @if(Cache::get('local_shipping')=='1')
                                                        <select name='pincode_id' class="form-control" required readonly></select>
                                                        @else
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="form-control" type="text" placeholder="Pincode" name="pincode" required>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <br/>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>{{__('msg.state')}}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="form-control" type="text" name="state" required placeholder="State">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>{{__('msg.country')}}</label>
                                                        <div class="ui search focus">
                                                            <div class="ui left icon input card-detail-desc">
                                                                <input class="form-control" type="text" name="country" required placeholder="Country">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-4">
                                                    <div class="form-group mr-20">
                                                        <label class="radio-inline">
                                                            <input class="mr-2 " type="radio" name="type" value="Home" checked>{{__('msg.home')}}
                                                        </label>
                                                    </div>
                                                    <div class="form-group mr-20">
                                                        <label class="radio-inline  ml-5">
                                                            <input class="mr-2" type="radio" name="type" value="Work">{{__('msg.work')}}
                                                        </label>
                                                    </div>
                                                    <div class="form-group mr-20">
                                                        <label class="radio-inline  ml-5">
                                                            <input class="mr-2" type="radio" name="type" value="Other">{{__('msg.other')}}
                                                        </label>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="form-group mt-1 mb-4 mt-3">
                                            <input type="checkbox" name="is_default" class=" mt-1" />
                                            <label class="control-label" for="default-address"> {{__('msg.set_as_default_address')}}</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group text-end">
                                        <button type="submit" class="btn btn-primary btn-block text-uppercase"> {{__('msg.add_new_address')}} </button>
                                        <button class="btn btn-primary btn-block text-uppercase AddEditAddressCancel"> {{__('msg.cancel')}} </button>
                                    </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ theme('js/select2.min.js') }}"></script>
<script src="{{ asset('js/address.js') }}"></script>
