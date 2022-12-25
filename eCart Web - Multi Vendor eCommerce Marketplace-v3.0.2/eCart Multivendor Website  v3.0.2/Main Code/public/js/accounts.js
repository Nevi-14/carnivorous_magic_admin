"use strict";

$(document).ready(function(){
    $('select[name=city_id]').select2();
    $('select[name=area_id]').select2();
    $('select[name=pincode_id]').select2();
    loadOptions($("select[name=city_id]"), "{{route('cities')}}");
    loadOptions($("select[name=area_id]"), "{{ route('area', $data['profile']['city_id'] ?? 0 ) }}");
    loadOptions($("select[name=pincode_id]"), "{{ route('pincode', $data['profile']['area_id'] ?? 0 ) }}");
    console.log($data['profile']['city_id']);
    console.log($data['profile']['area_id']);
    $('select[name=city_id]').change(function(){
        loadOptions($("select[name=area_id]"), "{{ route('area','') }}/" + $('select[name=city_id]').val(), true);
    });
    $('select[name=area_id]').change(function(){
        loadOptions($("select[name=pincode_id]"), "{{ route('pincode','') }}/" + $('select[name=area_id]').val(), true);
    });
});