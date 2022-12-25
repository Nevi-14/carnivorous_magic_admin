<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use File;

class UserController extends Controller {

    public function index(Request $request) {
        $user = $this->post('get-user', ['data' => ['get_user_data' => 1, 'user_id' => session()->get('user')['user_id']]]);

        if (isset($user['error']) && !$user['error']) {
            $data['profile'] = $user['data'];
            $data['title'] = __('msg.my_account');
            $data['token'] = $this->generate_token();

            //add session cart data in login user
            $get_session_varient_ids = session()->get('variant_ids', []);
            $varient_ids = implode(',', $get_session_varient_ids);
            $data['cart_session'] = session()->get('cart');
            if (!empty($data['cart_session'])) {
                foreach ($data['cart_session'] as $entry) {
                    $qtydata[] = $entry['quantity'];
                }
                $qtys = implode(',', $qtydata);
                $result = $this->post('cart', ['data' => ['add_multiple_items' => 1, 'user_id' => session()->get('user') ['user_id'], 'product_variant_id' => $varient_ids, 'qty' => $qtys]]);
                session()->forget('cart_session');
            }

            //add session favourite data in login user
            if (session()->has('favourite')) {
                $favourite = session()->get('favourite', []);
                $product_ids = implode(',', $favourite);
                $list = $this->post('favorites', ['data' => ['add_multiple_products_to_favorites' => 1, 'user_id' => session()->get('user') ['user_id'], 'product_ids' => $product_ids]]);
                session()->forget('favourite');
            }
            $this->html('user.account', $data);
        } else {
            return redirect()->route('logout');
        }
    }

    public function orders(Request $request, $type = "") {

        $limit = 5;

        $page = $request->page ?? 0;

        $data = [api_param('get-orders') => api_param('get-val'), api_param('user-id') => session()->get('user') ['user_id'], 'limit' => $limit, 'offset' => ($page * $limit)];

        if (in_array($type, ['cancelled', 'processed', 'delivered', 'received', 'returned', 'shipped'])) {

            $data['status'] = $type;
        }

        $list = $this->post('order-process', ['data' => $data, 'data_param' => '']);
        
        $total = $list['total'] ?? 0;

        $lastPage = "";

        if (intval($page - 1) > - 1) {

            if (intval($page - 1) == 0) {

                $lastPage = route('my-orders', ['type' => $type]);
            } else {

                $lastPage = route('my-orders', ['type' => $type, 'page' => $page - 1]);
            }
        }

        $nextPage = "";

        if (intval($total / $limit) > $page + 1) {

            $nextPage = route('my-orders', ['type' => $type, 'page' => $page + 1]);
        }

        $this->html('user.orders', ['title' => __('msg.my_orders'), 'list' => $list, 'limit' => $limit, 'total' => $total, 'next' => $nextPage, 'last' => $lastPage]);
    }

    public function track($orderId) {


        $data = [api_param('get-orders') => api_param('get-val'), api_param('user-id') => session()->get('user')['user_id'], 'order_id' => $orderId];

        $list = $this->post('order-process', ['data' => $data]);
        
        if (count($list) && isset($list['data'][0])) {

            $this->html('user.order-track', ['title' => __('msg.my_orders'), 'list' => $list['data'][0]]);
        } else {

            abort(404);
        }
    }

    public function order_status_update($orderId, $orderItemId, $status) {

        $response = $this->post('order-process', ['data' => ['update_order_status' => 1, 'user_id' => session()
                        ->get('user') ['user_id'], 'order_item_id' => $orderItemId, 'order_id' => $orderId, 'status' => $status]]);

        if (isset($response['error']) && !$response['error']) {

            return redirect()->back()
                            ->with('suc', $response['message'] ?? "Order's Status Updated Successfully.");
        } else {

            return redirect()->back()
                            ->with('err', $response['message'] ?? "Unable To Update Order's Status");
        }
    }

    public function fullorder_status_update($orderId, $status) {
        $response = $this->post('order-process', ['data' => ['update_order_status' => 1, 'order_id' => $orderId, 'status' => $status]]);

        if (isset($response['error']) && !$response['error']) {
            return redirect()->back()->with('suc', $response['message']);
        } else {
            return redirect()->back()->with('err', $response['message']);
        }
    }

    public function re_order($orderId) {
        $response = $this->post('order-process', ['data' => ['get_reorder_data' => '1', 'id' => $orderId]]);

        if (!empty($response['data'])) {
            foreach ($response['data']->items as $item) {
                $reorderproduct_variant_id[] = $item->product_variant_id;
                $reorderqtydata[] = $item->quantity;
            }
            $reorderproduct_variant_ids = implode(',', $reorderproduct_variant_id);
            $reorderqtys = implode(',', $reorderqtydata);
        }
        $response_order = $this->multiple_addtocart($reorderproduct_variant_ids, $reorderqtys);

        if (isset($response_order['error']) && !$response_order['error']) {
            return redirect()->back()->with('suc', $response_order['message'] ?? "Cart Updated successfully!.");
        } else {
            return redirect()->back()->with('err', $response_order['message'] ?? "Unable To Update Cart");
        }
    }

    public function multiple_addtocart($varientIds, $qtys) {
        return $response_order = $this->post('cart', ['data' => ['add_multiple_items' => 1, 'user_id' => session()->get('user') ['user_id'], 'product_variant_id' => $varientIds, 'qty' => $qtys]]);
    }

    public function walletHistory(Request $request) {

        $limit = 10;

        $page = $request->page ?? 0;

        $list = $this->post('wallet-history', ['data' => ['get_user_transactions' => 1, 'user_id' => session()
                        ->get('user') ['user_id'], 'type' => 'wallet_transactions', 'limit' => $limit, 'offset' => ($page * $limit)]]);

        $data = $this->pagination($list, "wallet-history", $page, $limit);

        \extract($data);

        $this->html('user.wallet-history', ['title' => __('msg.wallet_history'), 'list' => $list, 'limit' => $limit, 'total' => $total, 'next' => $nextPage, 'last' => $lastPage]);
    }

    public function transactionHistory(Request $request, $type = 'wallet') {

        $limit = 10;

        $page = $request->page ?? 0;

        $list = $this->post('wallet-history', ['data' => ['get_user_transactions' => 1, api_param('user-id') => session()
                        ->get('user') ['user_id'], 'type' => 'transactions', 'limit' => $limit, 'offset' => ($page * $limit)], 'data_param' => '']);

        $data = $this->pagination($list, "transaction-history", $page, $limit);

        \extract($data);

        $this->html('user.transaction-history', ['title' => __('msg.transaction_history'), 'list' => $list, 'limit' => $limit, 'total' => $total, 'next' => $nextPage, 'last' => $lastPage]);
    }

    public function notification(Request $request) {

        $limit = 10;

        $page = $request->page ?? 0;

        $list = $this->post('sections', ['data' => ['get-notifications' => 1, 'limit' => $limit, 'offset' => ($page * $limit), 'sort' => 'id', 'order' => 'DESC'], 'data_param' => '']);

        $total = $list['total'] ?? 0;

        $lastPage = "";

        if (intval($page - 1) > - 1) {

            if (intval($page - 1) == 0) {

                $lastPage = route('notification');
            } else {

                $lastPage = route('notification', ['page' => $page - 1]);
            }
        }

        $nextPage = "";

        if (intval($total / $limit) > $page) {

            $nextPage = route('notification', ['page' => $page + 1]);
        }

        $this->html('user.notification', ['title' => __('msg.notifications'), 'list' => $list, 'limit' => $limit, 'total' => $total, 'next' => $nextPage, 'last' => $lastPage]);
    }

    public function update_profile(Request $request) {
        $params = $request->only('name', 'email');

        $request->validate(['name' => 'required|max:255', 'email' => 'email',
        ]);
        $params['type'] = api_param('edit-profile');

        $params['id'] = session()->get('user')->user_id;

        $update = $this->post('user-registration', ['data' => $params]);

        if (isset($update['error']) && $update['error'] === false) {

            $update = $this->post('user-registration', ['data' => $params]);
            $msg = $update['message'] ?? 'Profile Updated Successfully';
            $user = session()->get('user');
            foreach ($params as $k => $v) {
                $user[$k] = $v;
            }
            session()->put('user', $user);
            return back()->with('suc', $msg);
        } else {
            $msg = $update['message'] ?? msg('error');
            return back()->with('err', $msg);
        }
    }

    public function password() {
        $this->html('user.password', ['title' => __('msg.change_password')]);
    }

    public function change_password(Request $request) {
        $request->validate(['current_password' => 'required', 'new_password' => 'required|confirmed|min:5',]);
        if ($request->current_password == $request->new_password) {
            return back()->with('err', 'New Password and Old Password Can not Be Same');
        } else {
            $login = $this->post('login', ['data' => [api_param('mobile') => session()->get('user') ['mobile'], api_param('password') => $request->current_password, 'login' => 1]]);
           
            if (isset($login['error']) && !$login['error']) {
                $login = $login['data'][0];

                if (isset($login->user_id) && intval($login->user_id) && $login->user_id == session()->get('user') ['user_id']) {
                    $params[api_param('password')] = $request->new_password;
                    $params[api_param('type')] = api_param('change-password');
                    $params[api_param('user_id')] = session()->get('user')['user_id'];
                    $update = $this->post('user-registration', ['data' => $params]);

                    if (isset($update['error']) && $update['error'] === false) {
                        return redirect()->route('my-account')->with('suc', 'Profile Changed Successfully');
                    } else {
                        $err = $update['message'] ?? msg('error');
                    }
                } else {
                    $err = "Your Old Password is Incorrect";
                }
            }
            return back()->with('err', $err ?? $login['error']);
        }
    }

    public function reset_password(Request $request) {
        $response = array(
            'status' => false,
            'message' => msg('error')
        );
        $validator = Validator::make($request->all(), ['password' => 'required|min:5|confirmed',]);
        if ($validator->fails()) {
            $errors = $validator->messages()->all();
            $response['message'] = $errors[0];
        } else {
            $tmp_user = session()->get('temp_user');
            $data = ['data' => [api_param('type') => api_param('change-password'), api_param('password') => $request->password, api_param('user_id') => $tmp_user['id']]];
            $response = $this->post('user-registration', $data);
            if (!$response['error']) {
                //session()->put('suc', 'Password Reset Successfully.');
                //return redirect()->route('shop')->with('suc', 'Password Reset Successfully.');
            }
        }
        echo json_encode($response);
    }

    public function referearn(Request $request) {

        $user = $this->post('get-user', ['data' => ['get_user_data' => 1, 'user_id' => session()->get('user') ['user_id']]]);

        if (isset($user['error']) && !$user['error']) {

            $data['profile'] = $user['data'][0];

            $data['title'] = __('msg.refer_and_earn');

            $this->html('user.refer-earn', $data);
        } else {

            return redirect()->route('logout');
        }
    }

    public function logout(Request $request) {

        $request->session()->flush();

        return redirect()->route('home');
    }

    public function address(Request $request) {

        $address = $this->post('addresses', ['data' => ['get_addresses' => 1, 'user_id' => session()->get('user') ['user_id']]]);

        if ($address['error']) {

            $address['data'] = [];
        } else {

            if ($address['data'] && count($address['data'])) {

                $data['address'] = $address;
            }
        }

        $this->html('user.addresses', ['title' => __('msg.manage_addresses'), 'address' => $address['data']]);
    }

    public function address_add(Request $request) {

        $params = $request->only('name', 'mobile', 'alternate_mobile', 'address', 'landmark', 'pincode_id', 'pincode', 'city_id', 'city_name', 'area_id', 'area_name', 'state', 'country', 'type', 'latitude', 'longitude', 'country_code');

        $request->validate(['name' => 'required|max:255', 'mobile' => 'required|numeric', 'address' => 'required', 'state' => 'required', 'country' => 'required',]);
        if ($request->has('id') && intval($request->id)) {
            $params['update_address'] = 1;
            $params['id'] = intval($request->id);
        } else {
            $params['add_address'] = 1;
        }
        if ($request->has('is_default') && $request->is_default == "on") {
            $params['is_default'] = 1;
        } else {
            $params['is_default'] = 0;
        }

        if (isset($params['city_id'])) {
            $params['city_id'] = $params['city_id'] ?? '';
            $params['area_id'] = $params['area_id'] ?? '';
            $params['pincode_id'] = $params['pincode_id'] ?? ''; 
        } else {
            $params['city_id'] = 0;
            $params['area_id'] = 0;
            $params['pincode_id'] = 0;
        }

        $params['user_id'] = session()->get('user')['user_id'];

        $result = $this->post('addresses', ['data' => $params, ' add_address' => '1']);

        if (isset($result['error']) && !$result['error']) {

            return redirect()->back()->with('suc', $result['message'] ?? 'Address Added Successfully');
        } else {

            return redirect()->back()->with('err', $result['message'] ?? msg('error'));
        }
    }

    public function address_remove($id) {

        $result = $this->post('addresses', ['data' => ['delete_address' => 1, 'id' => $id]]);

        if (isset($result['error']) && !$result['error']) {

            return redirect()->back()->with('suc', $result['message'] ?? 'Address Removed Successfully');
        } else {

            return redirect()->back()->with('err', $result['message'] ?? msg('error'));
        }
    }
    
     public function track_order_view(Request $request) {
        $shipment_id = $request->shipment_id;
        $order_item_id = $request->order_item_id;
        if(intval($shipment_id)){
        $track_data = $this->post('order-process', ['data' => ['track_order' => '1', 'shipment_id' => $shipment_id]]);
        }
        else{
            $track_data = $this->post('order-process', ['data' => ['track_order' => '1', 'order_item_id' => $order_item_id]]);
        }

        echo json_encode($track_data);
       
    }

}
