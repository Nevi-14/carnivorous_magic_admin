<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SavelaterController extends Controller {

    public function index() {
        echo \GuzzleHttp\json_encode($this->post('products', ['data' => ['get_all_products_name' => '1']]));
    }

    public function saveforlater($p_id, $varient_id, $qty, Request $request) {
        if (!isLoggedIn()) {
            if (!in_array($varient_id, session()->get('savelater_variant_ids', []))) {
                session()->push('savelater_variant_ids', $varient_id);
            }

            //$id = $varient_id;

            $savelater = session()->get('savelater');

            // if cart is empty then this the first product
            if (!$savelater) {

                $savelater = [
                    $varient_id => [
                        "name" => $request->name,
                        "quantity" => $request->qty,
                        "price" => $request->price,
                        "image" => $request->image
                    ]
                ];

                session()->put('savelater', $savelater);
            }

            // if cart not empty then check if this product exist then increment quantity
//            if (isset($cart[$id])) {
//
//                $cart[$id]['quantity']++;
//
//                session()->put('cart', $cart); // this code put product of choose in cart
//            }
            // if item not exist in cart then add to cart with quantity = 1
            $savelater[$varient_id] = [
                "name" => $request->name,
                "quantity" => $request->qty,
                "price" => $request->price,
                "image" => $request->image
            ];

            session()->put('savelater', $savelater); // this code put product of choose in cart
            $savelater = session()->get('savelater');

            return json_encode(array(
                'varient_id' => $savelater,
                'status' => 'Moved Item to Save for later',
            ));
        }
        //return redirect()->route('home')->with('error_code', 5);
        else {

            $apidata = ['add_to_save_for_later' => 1, 'user_id' => session()->get('user')['user_id'], 'product_id' => $p_id, 'product_variant_id' => $varient_id, 'qty' => $qty];

            $result = $this->post('cart', ['data' => $apidata]);

            if ($result['error']) {
                return redirect()->back() > with('err', $result['message']);
            } else {
                $product = $result;
                $data = $this->getCart();
                $totalcart = $data['cart']['total'];
                $total = $data['subtotal'] ?? '0';
                $saved_price = $data['saved_price'] ?? '0';
                $tax_amount = $data['tax_amount'] ?? ' ';
                $shipping = $data['cart']['shipping'] ?? ' ';
                $items = $data['cart'];
                return json_encode(array(
                    'varient_id' => $varient_id,
                    'currency' => (Cache::has('currency') ? Cache::get('currency') : ''),
                    'min_order_amount' => Cache::get('min_order_amount'),
                    'is_pincode' => session()->has('pincode_no'),
                    'pincode_no' => session()->get('pincode_no'),
                    'max_cart_items_count' => Cache::get('max_cart_items_count'),
                    'product' => $product,
                    'totalcart' => $totalcart,
                    'tax_amount' => $tax_amount,
                    'shipping' => $shipping,
                    'total' => $total,
                    'saved_price' => $saved_price,
                    'items' => $items,
                    'status' => 'Moved Item to Save for later',
                ));
            }
        }
    }

    public function movetocart($p_id, $varient_id, $qty) {
        if (!isLoggedIn()) {
            return redirect()->route('home')->with('error_code', 5);
        } else {

            $data = ['add_to_cart' => 1, 'user_id' => session()->get('user')['user_id'], 'product_id' => $p_id, 'product_variant_id' => $varient_id, 'qty' => $qty];
            $result = $this->post('cart', ['data' => $data]);
           
            if (!$result) {
                return redirect()->back()->with('err', $result['message']);
            } else {
                if ($result != NULL) {
                    $product = $result;
                    $cart = $this->getCart();
                    $totalcart = count($cart['cart']);
                    $subtotal = $cart['subtotal'];
                    $tax_amount = $cart['tax_amount'] ?? ' ';
                    $shipping = $cart['shipping'] ?? ' ';
                    $total = $cart['total'] ?? ' ';
                    $saved_price = $cart['saved_price'] ?? ' ';
                    echo json_encode(array(
                        'varient_id' => $data,
                        'currency' => (Cache::has('currency') ? Cache::get('currency') : ''),
                        'cart'=>$cart,
                        'product' => $product,
                        'totalcart' => $totalcart,
                        'subtotal' => $subtotal,
                        'tax_amount' => $tax_amount,
                        'shipping' => $shipping,
                        'subtotal_msg' => __('msg.subtotal'),
                        'tax_msg' => __('msg.tax'),
                        'delivery_charge_msg' => __('msg.delivery_charge'),
                        'discount_msg' => __('msg.discount'),
                        'total_msg' => __('msg.total'),
                        'total' => $total,
                        'saved_price' => $saved_price,
                        'delete_all_msg' => __('msg.delete_all'),
                        'checkout_msg' => __('msg.checkout'),
                        'saved_price_msg' => __('msg.saved_price'),
                        'continue_shopping' => __('msg.continue_shopping'),
                        'empty_card_img' => asset('images/empty-cart.png'),
                        'you_must_have_to_purchase' => __('msg.you_must_have_to_purchase'),
                        'to_place_order' => __('msg.to_place_order'),
                        'you_can_get_free_delivery_by_shopping_more_than' => __('msg.you_can_get_free_delivery_by_shopping_more_than'),
                        'min_order_amount' => Cache::get('min_order_amount'),
                        'qty' => __('msg.qty'),
                        'price' => __('msg.price'),
                        'min_amount' => Cache::get('min_amount'),
                        'max_cart_items_count' => Cache::get('max_cart_items_count'),
                        'local_pickup' => Cache::get('local-pickup'),
                        'status' => 'Moved Item in Cart',
                    ));
                    die;
                    return;
                } else {
                    return redirect()->back()->with('err', $result['message']);
                }
            }
        }
    }

}
