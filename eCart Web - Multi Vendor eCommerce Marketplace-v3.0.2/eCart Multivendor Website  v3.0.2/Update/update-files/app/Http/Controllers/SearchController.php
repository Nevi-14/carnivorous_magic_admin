<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class SearchController extends Controller {

    public function index() {
        
        $product = $this->post('get-products', ['data' => ['get_all_products_name' => '1']]);
        if (session()->has('shipping_type') && session()->get('shipping_type') == 'local') {
            $product = $this->post('get-products', ['data' => ['get_all_products_name' => '1','pincode_id' => session()->get('pincode') ]]);
        }
        echo \GuzzleHttp\json_encode( $product['data']);

    }

}
