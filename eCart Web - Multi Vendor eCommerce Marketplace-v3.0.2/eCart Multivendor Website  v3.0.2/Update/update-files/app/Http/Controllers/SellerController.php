<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;

class SellerController extends Controller {

    public function seller_all() {
        $title = "All Seller";
        $all_seller = $this->post('get-seller', ['data' => ['get_seller_data' => 1, 'pincode_id' => session()->get('pincode')]]);
        
        if (isset($all_seller['error']) && !$all_seller['error']) {
            $all_seller_data = $all_seller['data'];
        } else {
            abort(404);
        }

        $this->html('seller_all', ['title' => $title, 'data' => $all_seller_data]);
    }
    
    public function categories_all() {
        $title = "All Categories";
        $all_categories = $this->post('get-categories', ['data' => ['data' => 'data']]);
        
        if (isset($all_categories['error']) && !$all_categories['error']) {
            $all_categories_data = $all_categories['data'];
            
        } else {
            abort(404);
        }

        $this->html('categories_all', ['title' => $title, 'data' => $all_categories_data]);
    }

}
