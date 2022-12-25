{{-- big Offer banner --}}
@if(Cache::has('offers') && is_array(Cache::get('offers')) && count(Cache::get('offers')))
@foreach(Cache::get('offers') as $o)
@if(isset($o->image) && trim($o->image) !== "")
<div class="main-content">
   
    <div class="container-fluid">
        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="col-md-12">
                <div class="banner_box_content">
                    <img class="lazy" data-original="{{ $o->image }}" alt="ad-1">
                </div>
            </div>
        </div>
    </div>
    
</div>
@endif
@endforeach
@endif