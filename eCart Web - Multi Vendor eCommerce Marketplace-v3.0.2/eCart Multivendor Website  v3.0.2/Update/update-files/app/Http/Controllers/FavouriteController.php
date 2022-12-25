<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;

class FavouriteController extends UserController {

    public function index(Request $request) {

        if (!isLoggedIn()) {
            $favourite = session()->get('favourite', []);
            $product_ids = implode(',', $favourite);
            $list = $this->post('get-products', ['data' => ['get_products_offline' => 1, 'product_ids' => $product_ids]]);

            $this->html('user.favorites', ['title' => __('msg.favourites'), 'list' => $list]);
        } else {

            $limit = 12;

            $page = $request->page ?? 0;

            $list = $this->post('favorites', ['data' => ['get_favorites' => 1, api_param('user-id') => session()->get('user')['user_id'], 'limit' => $limit, 'offset' => ($page * $limit)], 'data_param' => '']);

            $data = $this->pagination($list, "favourite", $page, $limit);

            \extract($data);

            $this->html('user.favorites', ['title' => __('msg.favourites'), 'list' => $list, 'limit' => $limit, 'total' => $total, 'next' => $nextPage, 'last' => $lastPage]);
        }
    }

    public function remove(Request $request, $id) {

        if (!isLoggedIn()) {

            return redirect()->back()->with('error_code', 5);
        }

        $results = $this->post('favorites', ['data' => ['remove_from_favorites' => 1, api_param('product-id') => $id, api_param('user-id') => session()->get('user')['user_id']]]);

        $request->id = $id;

        $this->remove_ajax($request);

        if (isset($results['error']) && !$results['error']) {

            return redirect()->back()->with('suc', "Item removed from user's favorite list successfully");
        } else {

            return redirect()->back()->with('err', $results['message'] ?? msg('error'));
        }
    }

    public function add_ajax(Request $request) {

        if (!isLoggedIn()) {

            if (!in_array($request->id, session()->get('favourite', []))) {
                session()->push('favourite', $request->id);
            }

            $id = $request->id;

            $favourite = session()->get('favourite');

            // if cart is empty then this the first product
            if (!$favourite) {

                $favourite = [
                    $id => $request->id
                ];

                session()->put('favourite', $favourite);
                $favourite = session()->get('favourite');
            }
            echo json_encode(['data' => $favourite]);
        } else {

            echo json_encode($this->post('favorites', ['data' => ['add_to_favorites' => 1, api_param('product-id') => $request->id, api_param('user-id') => session()->get('user')['user_id']]]));
        }
    }

    public function remove_ajax(Request $request) {

        if (!isLoggedIn()) {
            $id = $request->id;
            $favourite = session()->get('favourite');
            if (($id = array_search($id, $favourite)) !== false) {
                session()->pull('favourite.' . $id);
            }

            $favourite = session()->get('favourite', []);
            echo json_encode(['data' => $favourite]);
        } else {

            echo json_encode($this->post('favorites', ['data' => ['remove_from_favorites' => 1, api_param('product-id') => $request->id, api_param('user-id') => session()->get('user')['user_id']]]));
        }
    }

}
