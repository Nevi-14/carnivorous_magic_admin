<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;

class HomeController extends Controller {

    public function index() {

        $title = "Ecommerce | Full Store Website";

        $this->html('home', ['title' => $title], true);
    }

    public function page($slug) {

        $page = array(
            'privacy-policy' => 'privacy_policy',
            'tnc' => 'terms_conditions',
            'about' => 'about_us',
            'refund-policy' => 'refund_policy',
            'shipping-policy' => 'shipping_policy',
            'delivery-returns-policy' => 'delivery_returns_policy'
        );

        $title = array(
            'privacy-policy' => 'Privacy Policy',
            'tnc' => 'Terms & Conditions',
            'about' => 'About Us',
            'refund-policy' => 'Refund Policy',
            'shipping-policy' => 'Shipping Policy',
            'delivery-returns-policy' => 'Delivery Return Policy'
        );

        if (isset($page[$slug]) && Cache::has($page[$slug])) {

            $this->html('page', ['title' => $title[$slug], 'content' => Cache::get($page[$slug])]);
        } else {

            abort(404);
        }
    }

    public function faq(Request $request) {

        $page = 0;

        if ($request->has('page') && intval($request->page)) {

            $page = intval($request->page);
        }

        $limit = 50;

        $result = $this->post('faq', ['data' => [api_param('search') => $request->search ?? '', api_param('limit') => $limit, api_param('page') => $page + 1], 'data_param' => '']);

        if (isset($result['error']) && !($result['error'])) {

            $breadcrumb = array();

            $breadcrumb[] = array(
                'title' => 'Home',
                'link' => route('home')
            );

            $breadcrumb[] = array(
                'title' => 'Faq',
                'link' => '#'
            );

            $this->html('faq', ['title' => __('msg.faq'), 'breadcrumb' => $breadcrumb, 'faq' => $result['data'], 'page' => $page, 'limit' => $limit, 'total' => $result['total']]);
        } else {

            abort(404);
        }
    }

    public function contact_page(Request $request) {

        $this->html('contact', ['title' => __('msg.contact_page')]);
    }

    public function about_page(Request $request) {

        $slug = "about";

        $page = array(
            'about' => 'about_us'
        );

        $title = array(
            'about' => 'About Us'
        );

        $this->html('about', ['title' => $title[$slug], 'content' => Cache::get($page[$slug])]);
    }

    public function seller($slug) {

        $result = $this->post('get-seller', ['data' => ['get_seller_data' => 1, 'slug' => $slug]]);

        $result_products = $this->post('get-products', ['data' => ['get_all_products' => 1, 'seller_slug' => $slug]]);

        if (isset($result['error']) && !($result['error'])) {
            $this->html('seller-details', ['title' => $result['data'][0]->name, 'data' => $result['data'], 'products' => $result_products['data'] ?? ""]);
        } else {
            abort(404);
        }
    }

    public function product($slug) {

        $data = ['slug' => $slug];
        $product = $this->post('get-products', ['data' => ['slug' => $slug, 'get_all_products' => 1]]);
       
        if (isLoggedIn()) {
            $data[api_param('user_id')] = session()->get('user')['user_id'];
            $product = $this->post('get-products', ['data' => ['slug' => $slug, 'get_all_products' => 1, 'user_id' => session()->get('user')['user_id']]]);
        }
        $sections = $this->post('sections', ['data' => ['get-all-sections' => '']]);

        if (!$product['error']) {
            $product = $product['data'];
            $sections = $sections['sections'] ?? '';
            $product = $product[0];
            $similarProducts = array();
            $data = [api_param('category-id') => $product->category_id, api_param('product-id') => $product->id, api_param('get_similar_products') => 1];

            $result = $this->post('get-products', ['data' => $data]);

            if (isset($result['error']) && (!($result['error']))) {

                foreach ($result['data'] as $r) {

                    if ($r->slug != $slug) {
                        $similarProducts[] = $r;
                    }
                }
            }

            $this->html('product', ['title' => $product->name, 'product' => $product, 'similarProducts' => $similarProducts, 'sections' => $sections ?? '']);
        } else {
            abort(404);
        }
    }

    public function check_product_availability(Request $request) {

        $product_id = $request->product_id;

        $pincode = $request->pincode;

        $slug = $request->slug;

        if (isLoggedIn()) {
            $data[api_param('user_id')] = session()->get('user')['user_id'];
        }

        $product = $this->post('get-products', ['data' => ['slug' => $slug, 'get_all_products' => 1]]);

        $pincodedata = $this->post('get-products', ['data' => ['product_id' => $product_id, 'get_all_products' => 1, 'pincode' => $pincode]]);

        if (!(isset($product['error']) && $product['error'])) {
            $product = $product['data'];
            $product = $product[0];
            $similarProducts = array();
            $data = [api_param('category-id') => $product->category_id, api_param('product-id') => $product->id, api_param('get_similar_products') => 1];

            $result = $this->post('get-products', ['data' => $data]);

            if (isset($result['error']) && (!($result['error']))) {
                foreach ($result['data'] as $r) {
                    if ($r->slug != $slug) {
                        $similarProducts[] = $r;
                    }
                }
            }

            $this->html('product', ['title' => $product->name, 'product' => $product, 'similarProducts' => $similarProducts, 'pincodedata' => $pincodedata, 'pincode_no' => $pincode]);
        } else {
            abort(404);
        }
    }

    public function productajax($slug) {

        $data = ['slug' => $slug];

        $product = $this->post('get-products', ['data' => ['slug' => $slug, 'get_all_products' => '1']]);

        if (isLoggedIn()) {

            $data[api_param('user-id')] = session()->get('user') ['user_id'];

            $product = $this->post('get-products', ['data' => ['slug' => $slug, 'get_all_products' => '1', 'user_id' => $data[api_param('user-id')]]]);
        }



        $settings = $this->post('settings', ['data' => ['all' => true]]);

        if (!(isset($product['error']) && $product['error'])) {

            $product = $product['data'][0];

            $settings = $settings['data'];

            $currency = $settings->currency;

            $max_product_return_days = $settings->max_product_return_days;

            return response()->json(['title' => $product->name, 'product' => $product, 'settings' => $settings, 'max_product_return_days' => $max_product_return_days, 'price' => 'Price', 'offer_price' => 'Offer Price', 'currency' => $currency, 'you_save' => __('msg.option_from'), 'option_from' => __('msg.option_from'), 'nonvagimg' => asset('images/nonvag.svg'), 'vagimg' => asset('images/vag.svg'), 'not' => __('msg.not'), 'vegetarian' => __('msg.vegetarian'), 'v_product' => __('msg.v_product'), 'this_is' => __('msg.this_is'), 'add_to_cart' => __('msg.add_to_cart'), 'buy_now' => __('msg.buy_now'), 'returnableimg' => asset('images/returnable.png'), 'days' => __('msg.days'), 'returnable' => __('msg.returnable'), 'not_returnableimg' => asset('images/not-returnable.svg'), 'not_returnable' => __('msg.not_returnable'), 'cancellableimg' => asset('images/cancellable.png'), 'order_can_cancel_till_order' => __('msg.order_can_cancel_till_order'), 'not_cancellableimg' => asset('images/not-cancellable.svg'), 'not_cancellable' => __('msg.not_cancellable'), 'pincode_no' => session()->get('pincode_no'), 'is_pincode' => session()->has('pincode_no'), 'you_save' => __('msg.you_save')]);
        } else {

            abort(404);
        }
    }

    public function get_shop_params_category(Request $request) {

        $selectedCategoryIds = [];

        $selectedSubCategoryIds = [];

        $selectedSubCategory = explode(",", $request->get('sub-category', ""));

        $selectedCategory = explode(",", $request->get('category', ""));

        $categories = Cache::get('categories');

        foreach ($selectedCategory as $cat) {

            if (isset($categories[$cat])) {

                $selectedCategoryIds[intval($categories[$cat]->id ?? 0)] = intval($categories[$cat]->id ?? 0);

                $childs = (array) $categories[$cat]->childs;

                foreach ($selectedSubCategory as $sub) {

                    if (isset($childs[$sub])) {

                        $selectedCategoryIds[] =intval($categories[$cat]->id??0);

                        $selectedSubCategoryIds[] = intval($childs[$sub]->id ?? 0);
                    }
                }
            }
        }

        return ['selectedCategory' => $selectedCategory, 'selectedCategoryIds' => $selectedCategoryIds, 'selectedSubCategory' => $selectedSubCategory, 'selectedSubCategoryIds' => $selectedSubCategoryIds];
    }

    public function get_shop_params(Request $request) {

        $limit = 12;

        $page = (!$request->page || $request->page == '1') ? 0 : $request->page;

        $offset = (!$request->page || $request->page == '1') ? 0 : (($page - 1) * $limit);
        $data = ['limit' => $limit, 'offset' => $offset];

        $param = [];

        if (isLoggedIn()) {

            $data[api_param('user-id')] = session()->get('user') ['user_id'];
        }

        $data['s'] = trim($request->s ?? "");

        $param['s'] = trim($request->s ?? "");

        if ($request->has('section') && trim($request->section) != "") {

            $sections = Cache::get('sections');

            if (isset($sections[$request->section])) {

                $data['section'] = intval($sections[$request->section]->id ?? 0);

                $param['section'] = trim($request->section);
            }
        }

        extract($this->get_shop_params_category($request));
        $cache_pincode_no = session()->get('pincode_no');

        $param['sub-category'] = trim($request->{'sub-category'});

        $param['category'] = trim($request->category);

        $data['category'] = implode(",", $selectedCategoryIds);

        $data['sub-category'] = implode(",", $selectedSubCategoryIds);

        $data[api_param('sort')] = trim($request->sort ?? "");

        $param[api_param('sort')] = trim($request->sort ?? "");

        $param['out_of_stock'] = trim($request->{'out_of_stock'});

        $data['out_of_stock'] = $request->out_of_stock ?? 0;

        $param['min_price'] = trim($request->{'min_price'});

        $param['max_price'] = trim($request->{'max_price'});

        $data['min_price'] = $request->min_price ?? 0;

        $data['max_price'] = $request->max_price ?? 0;

        $data['pincode'] = $cache_pincode_no;

        return ['data' => $data, 'param' => $param, 'page' => $page, 'limit' => $limit, 'selectedCategory' => $selectedCategory, 'selectedSubCategory' => $selectedSubCategory];
    }

    public function shop(Request $request) {

        extract($this->get_shop_params($request));

        $list = $this->post('shop', ['data' => $data, 'limit' => 1, 'data_param' => '']);

        $total = $list['total'] ?? 0;
        $limit = 12;
        $min_price = $list['min_price'] ?? 0;

        $max_price = $list['max_price'] ?? 0;

        $total_min_price = $list['total_min_price'] ?? 0;

        $total_max_price = $list['total_max_price'] ?? 0;

        $selectedMaxPrice = ($request->max_price ?? 0) < $max_price ? $max_price : ($request->max_price ?? 0);

        $selectedMinPrice = ($request->min_price ?? 0) < $min_price ? $min_price : ($request->min_price ?? 0);

        if (isset($list['category']) && is_array($list['category']) && count($list['category'])) {

            $this->all_data($list['category']);
        }

        $lastPage = "";

        if (intval($page - 1) > - 1) {

            if (intval($page - 1) == 0) {

                $lastPage = route('shop', $param);
            } else {

                $param['page'] = $page - 1;

                $lastPage = route('shop', $param);
            }
        }

        $nextPage = "";

        if (intval($total / $limit) > $page) {

            $param['page'] = $page + 1;

            $nextPage = route('shop', $param);
        }
        $number_of_pages = $total / $limit;
        $categories = Cache::get('categories', []);

        $this->html('shop', ['title' => __('msg.shop'), 'list' => $list, 'limit' => $limit, 'total' => $total, 'min_price' => $min_price, 'max_price' => $max_price, 'total_min_price' => $total_min_price, 'total_max_price' => $total_max_price, 'selectedMinPrice' => $selectedMinPrice, 'selectedMaxPrice' => $selectedMaxPrice, 'next' => $nextPage, 'last' => $lastPage, 'categories' => $categories, 'selectedCategory' => $selectedCategory, 'selectedSubCategory' => $selectedSubCategory, 'number_of_pages' => $number_of_pages]);
    }

    public function category(Request $request, $slug) {
        $breadcrumb = array();
        $breadcrumb[] = array(
            'title' => 'Home',
            'link' => route('home')
        );
        $breadcrumb[] = array(
            'title' => 'Shop',
            'link' => route('shop')
        );
        if (Cache::has('categories') && is_array(Cache::get('categories')) && isset(Cache::get('categories') [$slug])) {
            $category = Cache::get('categories') [$slug];

            $subCategory = $this->post('get-sub-categories', ['data' => [api_param('category_id') => $category->id]]);

            if (!(isset($subCategory['error']))) {
                $breadcrumb[] = array(
                    'title' => $category->name,
                    'link' => route('category', $category->slug)
                );
                $list = $this->post('get-products-by-category', ['data' => [api_param('category-id') => $category->id, 'limit'=>200]]);

                $limit = 200;

                $this->html('sub-categories', ['title' => $category->name, 'breadcrumb' => $breadcrumb, 'category' => $category, 'list' => $list, 'limit' => $limit]);
            } else {

                $s = Cache::get('sub-categories') ?? [];

                foreach ($subCategory['data'] as $t) {
                    $s[$t->slug] = $t;
                }

                Cache::put('sub-categories', $s);
                $breadcrumb[] = array(
                    'title' => $category->name,
                    'link' => route('category', $category->slug)
                );
                $list = $this->post('get-products', ['data' => [api_param('category-id') => $category->id, 'get_all_products' => 1, 'limit'=>200]]);
                $list = $list['data'] ?? '';

                $limit = 200;

                $this->html('sub-categories', ['title' => $category->name, 'breadcrumb' => $breadcrumb, 'category' => $category, 'sub-categories' => $subCategory['data'], 'list' => $list, 'limit' => $limit]);
            }
        } else {
            return redirect()->route('shop');
        }
    }

    public function sub_category(Request $request, $categorySlug = "", $subCategorySlug = "", $offset = 0) {

        $subTitle = '';

        $products = [];

        $total = 0;

        $breadcrumb = array();

        $breadcrumb[] = array(
            'title' => 'Home',
            'link' => route('home')
        );

        $breadcrumb[] = array(
            'title' => 'Shop',
            'link' => route('shop')
        );

        if (Cache::has('categories') && is_array(Cache::get('categories')) && isset(Cache::get('categories') [$categorySlug])) {

            $category = Cache::get('categories') [$categorySlug];

            $breadcrumb[] = array(
                'title' => $category->name,
                'link' => route('category', $category->slug)
            );

            $more = false;

            if (Cache::has('sub-categories') && isset(Cache::get('sub-categories') [$subCategorySlug])) {

                $subCategory = Cache::get('sub-categories') [$subCategorySlug];

                $title = $subCategory->name;

                $breadcrumb[] = array(
                    'title' => $title,
                    'link' => route('sub-category', [$category->slug, $subCategory->slug])
                );

                $response = $this->post('get-products-by-subcategory', ['data_param' => '', 'data' => [api_param('limit') => get('load-item-limit'), api_param('offset') => intval($offset * get('load-item-limit')), api_param('sub-category-id') => $subCategory->id]]);

                if (isset($response['data']) && is_array($response['data']) && count($response['data'])) {

                    $products = $response['data'];

                    $total = $response['total'];

                    if ($total > ($response['limit'] ?? get('load-item-limit'))) {

                        $more = true;
                    }
                }

                $this->html('shop', ['title' => $title, 'subTitle' => $subTitle, 'products' => $products, 'more' => $more, 'breadcrumb' => $breadcrumb, 'total' => $total]);
            } else {

                return redirect()->route('category', $categorySlug);
            }
        } else {

            return redirect()->route('shop');
        }
    }

    public function login_page() {

        if (isLoggedIn()) {

            return redirect()
                            ->route('home');
        }

        $this->html('login', ['title' => __('msg.login')]);
    }

    public function login(Request $request) {

        $error = msg('error');

        $validator = Validator::make($request->all(), [
                    'mobile' => 'required',
                    'password' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->messages()->all();

            $response['message'] = $errors[0];
        } else {

            $login = $this->post('login', ['data' => [api_param('mobile') => $request->mobile, api_param('password') => $request->password, 'login' => 1]]);

            if (isset($login['user_id']) && intval($login['user_id'])) {
                $get_session_varient_ids = session()->get('variant_ids', []);

                $varient_ids = implode(',', $get_session_varient_ids);
                $data['cart_session'] = session()->get('cart');
                if (!empty($data['cart_session'])) {
                    foreach ($data['cart_session'] as $entry) {
                        $qtydata[] = $entry['quantity'];
                    }
                    $qtys = implode(',', $qtydata);
                    $result = $this->post('cart', ['data' => ['add_multiple_items' => 1, 'user_id' => $login['user_id'], 'product_variant_id' => $varient_ids, 'qty' => $qtys]]);
                    session()->forget('cart_session');
                }
                $favourite = session()->get('favourite', []);
                $product_ids = implode(',', $favourite);
                $list = $this->post('favorites', ['data' => ['add_multiple_products_to_favorites' => 1, 'user_id' => $login['user_id'], 'product_ids' => $product_ids]]);
                session()->forget('favourite');
                $msg = $login['message'];

                unset($login['message']);

                unset($login['error']);

                $request->session()->put('user', $login);
                return redirect()->back();
            } elseif (isset($login['message']) && trim($login['message']) != "") {

                $error = $login['message'];
            }
            return back()->with("err", $error);
        }
    }

    public function already_registered(Request $request) {
        $response = ['error' => false, 'message' => 'Enter Valid Mobile Number'];
        if (strlen(trim($request->get('mobile', ""))) > 0) {
            $response = $this->post('user-registration', ['data' => [api_param('mobile') => $request->mobile, api_param('type') => api_param('verify-user'), 'web' => '1']]);

            if ($response['error']) {
                session()->put('temp_user', $response);
            }
        }
        echo json_encode($response);
    }

    public function register(Request $request) {
        $factory = (new Factory)->withServiceAccount(base_path('config/firebase.json'));
        $auth = $factory->createAuth();
        $user = $auth->getUser($request->auth_uid);
        if ($user->uid == $request->auth_uid) {
            if ($request->has('action') && $request->action == 'save') {
                $response = array(
                    'error' => true,
                    'message' => 'Something Went Wrong'
                );
                $validator = Validator::make($request->all(), ['password' => 'required|min:5|confirmed',]);
                if ($validator->fails()) {
                    $errors = $validator->messages()->all();
                    $response['message'] = $errors[0];
                } else {
                    $param = array();
                    $session = session()->get('registeration');
                    $mobile = substr($user->phoneNumber, strlen($session['country'] ?? $request->country));
                    $param[api_param('type')] = api_param('register');
                    $param[api_param('name')] = $request->display_name;
                    $param[api_param('friends-code')] = $request->friends_code ?? session()
                                    ->get('friends_code', '');
                    $param[api_param('email')] = $request->email;
                    $param[api_param('mobile')] = $mobile ?? $session['mobile'] ?? $request->mobile;
                    $param[api_param('password')] = $request->password;
                    $param[api_param('pincode')] = $request->pincode ?? '';
                    $param[api_param('city-id')] = $request->city ?? '';
                    $param[api_param('area-id')] = $request->area ?? '';
                    $param[api_param('street')] = $request->address ?? '';
                    $param[api_param('latitude')] = 0;
                    $param[api_param('longitude')] = 0;
                    $param[api_param('country-code')] = $session['country'] ?? $request->country;
                    $registration = $this->post('user-registration', ['data' => $param]);
                    if ($registration['error'] === false) {
                        $response['error'] = false;
                        $response['message'] = $registration['message'];
                        unset($registration['friends_code']);
                        unset($registration['message']);
                        unset($registration['error']);
                        session()->put('user', $registration);
                    } else {
                        $response = $registration;
                    }
                }
                echo json_encode($response);
            } else {
                $data = array();
                $data['email'] = $user->email;
                $data['display_name'] = $user->displayName;
                $data['country'] = $request->country_code;
                $data['mobile'] = substr($request->mobile, strlen($request->country_code));
                $data['auth_uid'] = $request->auth_uid;
                $data['friends_code'] = $request->friends_code ?? session()->get('friends_code', '');
                session()->put('register', $data);
                $this->html('register', $data);
                $data['title'] = __('msg.register');
            }
        } else {
            return back()->with("err", 'Auth Token Not Matched');
        }
    }

    public function refer($code) {

        session()->put('friends_code', $code);

        $this->html('home', ['title' => __('msg.refer_and_earn'), 'code' => $code, 'f_code' => $code]);
    }

    public function newsletter(Request $request) {

        $rules = [
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $messages = $validator->messages();

            return res(false, $messages->all());
        } else {

            $result = $this->post('newsletter', ['data' => ['email' => $request->email]]);

            return res(!$result['error'], $result['message']);
        }
    }

}
