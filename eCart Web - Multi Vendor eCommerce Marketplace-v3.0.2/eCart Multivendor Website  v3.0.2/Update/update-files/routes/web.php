<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('clear-cache', function() {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');

    return redirect()->route('home')->with('suc', 'Cache Cleared!');
});

Route::get('/ekart', 'Controller@ekart');

Route::get('/', 'HomeController@index')->name('home');

Route::get('/pincode/{pincode}', 'PincodeController@index_pincode')->name('home-pincode');

Route::get('/pincodeclear', 'PincodeController@index_pincode_clear')->name('home-pincode-clear');

Route::post('/login', 'HomeController@login')->name('login');

Route::post('/register', 'HomeController@register')->name('register');

Route::get('/already-registered', 'HomeController@already_registered')->name('already-registered');

Route::get('/forgot-password', 'HomeController@forgot_password')->name('forgot-password');

Route::post('/coupon/apply', 'PaymentController@coupon_apply')->name('coupon-apply');

Route::get('/coupon/remove', 'PaymentController@coupon_remove')->name('coupon-remove');

Route::get('/page/faq/', 'HomeController@faq')->name('faq');

Route::get('/about', 'HomeController@about_page')->name('about');

Route::get('/blog', 'HomeController@getblog')->name('blog');

Route::get('/blog/{slug}', 'HomeController@getblogsingle')->name('blog-single');

Route::get('/blogcategory/{slug}', 'HomeController@blogcategory')->name('blog-category');

Route::get('/flash-sale/{slug}', 'HomeController@flash_sale')->name('sale-products');

Route::get('/seller/{slug}', 'HomeController@seller')->name('seller');

Route::get('/contact', 'HomeController@contact_page')->name('contact');

Route::post('/contact', 'MailController@sendEmail');

Route::get('/page/{slug}', 'HomeController@page')->name('page');

Route::get('/shop', 'HomeController@shop')->name('shop');

Route::get('/nekot', 'HomeController@nekot')->name('nekot');

Route::get('/ipa_lru', 'HomeController@ipa_lru')->name('ipa_lru');

Route::get('/search/{s?}', 'HomeController@shop')->name('search');

Route::get('/category/{slug}', 'HomeController@category')->name('category');

Route::get('/category/{categorySlug}/{subCategorySlug}/{offset?}', 'HomeController@sub_category')->name('sub-category');

Route::get('/product/{slug}', 'HomeController@product')->name('product-single');

Route::get('/productajax/{slug}', 'HomeController@productajax')->name('product-singleajax');

Route::get('cities', 'PincodeController@city')->name('cities');

Route::post('pincode_list', 'PincodeController@pincode_list')->name('pincode_list');

Route::post('pincode_search', 'PincodeController@pincode_search')->name('pincode_search');

Route::post('track_order_view', 'UserController@track_order_view')->name('track_order_view');

Route::post('get_shipdel_charge', 'CheckoutController@get_shipdel_charge')->name('get_shipdel_charge');

Route::get('city/{city_id}', 'PincodeController@area')->name('area');

Route::get('area/{area_id}', 'PincodeController@pincode')->name('pincode');

Route::get('refer/{code}', 'HomeController@refer')->name('refer');

Route::post('newsletter', 'HomeController@newsletter')->name('newsletter');

Route::post('/product/{slug}', 'HomeController@check_product_availability')->name('check-product-availability');

Route::get('/seller_all', 'SellerController@seller_all')->name('seller_all');

Route::get('/categories_all', 'SellerController@categories_all')->name('categories_all');

Route::get('autocomplete', 'SearchController@index')->name('autocomplete');

Route::get('/token', 'HomeController@generate_token')->name('token');

/** If User's Logged In */

Route::get('/logout', 'UserController@logout')->name('logout');

Route::get('/cart', 'CartController@index')->name('cart');

Route::get('/cartajax', 'CartController@cartajax')->name('cartajax');

Route::get('/cart/empty', 'CartController@empty')->name('cart-empty');

Route::post('/cart/add', 'CartController@add')->name('cart-add');

Route::get('/cart/single/add', 'CartController@add');

Route::get('/cart/add/{id}/{varient_id}', 'CartController@add_single')->name('cart-add-single');

Route::post('/cart/single/add', 'CartController@add_single_varient')->name('cart-add-single-varient');

Route::post('/cart/single/addajax', 'CartController@add_single_varientajax')->name('cart-add-single-varientajax');

Route::post('/cart/update/{id}', 'PaymentController@update')->name('cart-update');

Route::post('/cart/update_cart/{id}', 'PaymentController@cart_update')->name('cart-update-cartpage');

Route::get('/cart/remove/{id}', 'PaymentController@remove')->name('cart-remove');

Route::get('/cart/remove_cart/{id}', 'PaymentController@cart_remove')->name('cart-remove-cartpage');

Route::post('/save-for-later/{p_id}/{varient_id}/{qty}', 'SavelaterController@saveforlater')->name('save-for-later');

Route::post('/move-to-cart/{p_id}/{varient_id}/{qty}', 'SavelaterController@movetocart')->name('move-to-cart');

Route::get('/checkout', 'CheckoutController@index')->name('checkoutcoupon');

Route::post('/checkout/summary', 'CheckoutController@summary')->name('checkout');

Route::get('/checkout/address', 'CheckoutController@address')->name('checkout-address');

Route::post('/checkout/address', 'CheckoutController@address');

Route::get('/checkout/payment', 'CheckoutController@payment')->name('checkout-payment');

Route::post('/checkout/proceed', 'CheckoutController@proceed')->name('checkout-proceed');

Route::get('/checkout/razorpay', 'CartController@checkout_razorpay_init')->name('checkout-razorpay-init');

Route::post('/checkout/razorpay', 'CartController@checkout_razorpay')->name('checkout-razorpay');

Route::get('/checkout/paypal', 'CartController@checkout_paypal_init')->name('checkout-paypal-init');

Route::get('/checkout/paypal/{type}', 'CartController@checkout_paypal')->name('checkout-paypal');

Route::get('/checkout/payu', 'CartController@checkout_payu_init')->name('checkout-payu-init');

Route::post('/checkout/payu', 'CartController@checkout_payu')->name('checkout-payu');

Route::get('/checkout/payu-bolt', 'CartController@checkout_payu_bolt_init')->name('checkout-payu-init-bolt');

Route::post('/checkout/payu-bolt', 'CartController@checkout_payu_bolt')->name('checkout-payu-bolt');

Route::get('/favorites', 'FavouriteController@index')->name('favourite');

Route::get('/favourite/remove/{id}', 'FavouriteController@remove')->name('favourite-remove');

Route::post('/favourite-post/add', 'FavouriteController@add_ajax');

Route::post('/favourite-post/remove', 'FavouriteController@remove_ajax');

Route::get('/my-account', 'UserController@index')->name('my-account')->middleware('loggedin');

Route::post('/my-account', 'UserController@update_profile');

Route::post('/upload_profile', 'UserController@upload_profile');

Route::get('/orders/{type?}', 'UserController@orders')->name('my-orders');

Route::get('/orders/status/{orderId}/{orderItemId}/{status}', 'UserController@order_status_update')->name('order-item-status');

Route::get('/orders/status/{orderId}/{status}', 'UserController@fullorder_status_update')->name('order-status');

Route::get('/re-orders/{orderId}', 'UserController@re_order')->name('re-order');

Route::get('/orders/track/{orderId}', 'UserController@track')->name('order-track-item');

Route::get('/invoice_pdf/{orderId}', 'InvoiceController@invoice_pdf')->name('invoice_pdf');

Route::get('/change-password', 'UserController@password')->name('change-password');

Route::post('/change-password', 'UserController@change_password');

Route::post('/reset-password', 'UserController@reset_password')->name('reset-password');

Route::get('/wallet-history','UserController@walletHistory')->name('wallet-history');

Route::get('/transaction-history','UserController@transactionHistory')->name('transaction-history');

Route::get('/notification','UserController@notification')->name('notification');

Route::get('/refer-earn','UserController@referearn')->name('refer-earn');

Route::get('/addresses', 'UserController@address')->name('addresses');

Route::post('/address/add', 'UserController@address_add')->name('address-add');

Route::get('/address/remove/{id}', 'UserController@address_remove')->name('address-remove');

/** Stripe Payment Gateway */
Route::get('/payment/stripe', 'Payments\StripeController@index')->name('payment-stripe-start');

Route::get('/payment/stripe/{type}/{orderId?}', 'Payments\StripeController@complete')->name('payment-stripe-complete');
/** Stripe Payment Gateway End */

/** Flutterwave Payment Gateway */
Route::get('/payment/flutterwave', 'Payments\FlutterwaveController@index')->name('payment-flutterwave-start');

Route::get('/payment/flutterwave/{type}', 'Payments\FlutterwaveController@complete')->name('payment-flutterwave-complete');
/** Flutterwave Payment Gateway End */

/** Paystack Payment Gateway */
Route::get('/payment/paystack', 'Payments\PaystackController@index')->name('payment-paystack-start');

Route::get('/payment/paystack/{type}', 'Payments\PaystackController@complete')->name('payment-paystack-complete');
/** Paystack Payment Gateway End */

/** PayTm Payment Gateway */
Route::get('txnTest', 'PaymentController@txnTest')->name('txnTest');
Route::post('pgRedirect', 'PaymentController@pgRedirect')->name('pgRedirect');
Route::post('paytm/success', 'PaymentController@pgResponse')->name('success');
/** PayTm Payment Gateway End */

// SSLCOMMERZ Start
Route::get('/sslecommerz', 'Payments\SslCommerzPaymentController@sslecommerz')->name('sslecommerz');
Route::post('/pay-via-ajax', 'Payments\SslCommerzPaymentController@payViaAjax')->name('pay-via-ajax');

Route::post('/success', 'Payments\SslCommerzPaymentController@success')->name('success');
Route::post('/fail', 'Payments\SslCommerzPaymentController@fail')->name('fail');
Route::post('/cancel', 'Payments\SslCommerzPaymentController@cancel')->name('cancel');

Route::post('/ipn', 'Payments\SslCommerzPaymentController@ipn')->name('ipn');
//SSLCOMMERZ END
Route::get('/wallet-history','WalletController@index')->name('wallet-history');
Route::post('/wallet/topup','WalletController@topup')->name('wallet-topup');

Route::get('/checkout/razorpay', 'Payments\RazorpayController@index')->name('checkout-razorpay-init');
Route::post('/checkout/razorpay', 'Payments\RazorpayController@complete')->name('checkout-razorpay');

Route::get('/checkout/payu-bolt', 'Payments\PayumoneyboltController@index')->name('checkout-payu-init-bolt');
Route::post('/checkout/payu-bolt', 'Payments\PayumoneyboltController@complete')->name('checkout-payu-bolt');

Route::get('/checkout/paypal', 'Payments\PaypalController@index')->name('checkout-paypal-init');
Route::get('/checkout/paypal/{type}', 'Payments\PaypalController@complete')->name('checkout-paypal');

Route::get('/checkout/paytm', 'Payments\PaytmController@index')->name('checkout-paytm-init');
Route::post('paytm/success', 'Payments\PaytmController@complete')->name('checkout-paytm');

Route::post('/pay-via-ajax', 'Payments\SslCommerzPaymentController@payViaAjax')->name('checkout-sslecommerz-init');

//fcm notification
Route::get('/chat', 'NotificationController@index')->name('chat');
Route::post('/save-token', 'NotificationController@saveToken')->name('save-token');
Route::post('/send-notification', 'NotificationController@sendNotification')->name('sendnotification');



