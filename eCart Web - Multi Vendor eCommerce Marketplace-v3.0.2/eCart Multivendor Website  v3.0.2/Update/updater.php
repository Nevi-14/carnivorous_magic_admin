<?php

session_start();
error_reporting(true);
$latest_version = "v3.0.2";
/*
 *  Update script for Web eCart from v3.0.1 to v3.0.2
 *  All Right reserved to WRTeam.in
 *  
 */
if (!isset($_SESSION["count"]) && $_SESSION["count"] != "applied") {

    /* app folder starts */
    copy('update-files/app/Console/Kernel.php', '../app/Console/Kernel.php');
    copy('update-files/app/Exceptions/Handler.php', '../app/Exceptions/Handler.php');
    copy('update-files/app/Http/Controllers/Payments/FlutterwaveController.php', '../app/Http/Controllers/Payments/FlutterwaveController.php');
    copy('update-files/app/Http/Controllers/Payments/PaypalController.php', '../app/Http/Controllers/Payments/PaypalController.php');
    copy('update-files/app/Http/Controllers/Payments/PaystackController.php', '../app/Http/Controllers/Payments/PaystackController.php');
    copy('update-files/app/Http/Controllers/Payments/PaytmController.php', '../app/Http/Controllers/Payments/PaytmController.php');
    copy('update-files/app/Http/Controllers/Payments/PayumoneyboltController.php', '../app/Http/Controllers/Payments/PayumoneyboltController.php');
    copy('update-files/app/Http/Controllers/Payments/RazorpayController.php', '../app/Http/Controllers/Payments/RazorpayController.php');
    copy('update-files/app/Http/Controllers/Payments/SslCommerzPaymentController.php', '../app/Http/Controllers/Payments/SslCommerzPaymentController.php');
    copy('update-files/app/Http/Controllers/Payments/StripeController.php', '../app/Http/Controllers/Payments/StripeController.php');

    copy('update-files/app/Http/Controllers/CartController.php', '../app/Http/Controllers/CartController.php');
    copy('update-files/app/Http/Controllers/CheckoutController.php', '../app/Http/Controllers/CheckoutController.php');
    copy('update-files/app/Http/Controllers/Controller.php', '../app/Http/Controllers/Controller.php');
    copy('update-files/app/Http/Controllers/FavouriteController.php', '../app/Http/Controllers/FavouriteController.php');
    copy('update-files/app/Http/Controllers/HomeController.php', '../app/Http/Controllers/HomeController.php');
    copy('update-files/app/Http/Controllers/InvoiceController.php', '../app/Http/Controllers/InvoiceController.php');
    copy('update-files/app/Http/Controllers/MailController.php', '../app/Http/Controllers/MailController.php');
    copy('update-files/app/Http/Controllers/PaymentController.php', '../app/Http/Controllers/PaymentController.php');
    copy('update-files/app/Http/Controllers/PincodeController.php', '../app/Http/Controllers/PincodeController.php');
    copy('update-files/app/Http/Controllers/SearchController.php', '../app/Http/Controllers/SearchController.php');
    copy('update-files/app/Http/Controllers/SellerController.php', '../app/Http/Controllers/SellerController.php');
    copy('update-files/app/Http/Controllers/UserController.php', '../app/Http/Controllers/UserController.php');
    copy('update-files/app/Http/Controllers/WalletController.php', '../app/Http/Controllers/WalletController.php');
    copy('update-files/app/Http/Controllers/NotificationController.php', '../app/Http/Controllers/NotificationController.php');

    copy('update-files/app/Http/Middleware/Authenticate.php', '../app/Http/Middleware/Authenticate.php');
    copy('update-files/app/Http/Middleware/CheckForMaintenanceMode.php', '../app/Http/Middleware/CheckForMaintenanceMode.php');
    copy('update-files/app/Http/Middleware/EncryptCookies.php', '../app/Http/Middleware/EncryptCookies.php');
    copy('update-files/app/Http/Middleware/Loggedin.php', '../app/Http/Middleware/Loggedin.php');
    copy('update-files/app/Http/Middleware/RedirectIfAuthenticated.php', '../app/Http/Middleware/RedirectIfAuthenticated.php');
    copy('update-files/app/Http/Middleware/TrimStrings.php', '../app/Http/Middleware/TrimStrings.php');
    copy('update-files/app/Http/Middleware/TrustHosts.php', '../app/Http/Middleware/TrustHosts.php');
    copy('update-files/app/Http/Middleware/TrustProxies.php', '../app/Http/Middleware/TrustProxies.php');
    copy('update-files/app/Http/Middleware/VerifyCsrfToken.php', '../app/Http/Middleware/VerifyCsrfToken.php');

    copy('update-files/app/Http/Kernel.php', '../app/Http/Kernel.php');

    if (!is_dir('../app/Library')) {
        mkdir('../app/Library', 0777, true);
    }
    if (!is_dir('../app/Library/SslCommerz')) {
        mkdir('../app/Library/SslCommerz', 0777, true);
    }

    copy('update-files/app/Library/SslCommerz/AbstractSslCommerz.php', '../app/Library/SslCommerz/AbstractSslCommerz.php');
    copy('update-files/app/Library/SslCommerz/SslCommerzInterface.php', '../app/Library/SslCommerz/SslCommerzInterface.php');
    copy('update-files/app/Library/SslCommerz/SslCommerzNotification.php', '../app/Library/SslCommerz/SslCommerzNotification.php');

    copy('update-files/app/Providers/AppServiceProvider.php', '../app/Providers/AppServiceProvider.php');
    copy('update-files/app/Providers/AuthServiceProvider.php', '../app/Providers/AuthServiceProvider.php');
    copy('update-files/app/Providers/BroadcastServiceProvider.php', '../app/Providers/BroadcastServiceProvider.php');
    copy('update-files/app/Providers/EventServiceProvider.php', '../app/Providers/EventServiceProvider.php');
    copy('update-files/app/Providers/RouteServiceProvider.php', '../app/Providers/RouteServiceProvider.php');
   

    copy('update-files/app/User.php', '../app/User.php');
    copy('update-files/app/helper.php', '../app/helper.php');
    /* app folder end */

    /* bootstrap folder starts */
    copy('update-files/bootstrap/cache/packages.php', '../bootstrap/cache/packages.php');
    copy('update-files/bootstrap/cache/services.php', '../bootstrap/cache/services.php');
    copy('update-files/bootstrap/app.php', '../bootstrap/app.php');
    /* bootstrap folder end */

    /* config folder starts */
    copy('update-files/config/app.php', '../config/app.php');
    copy('update-files/config/auth.php', '../config/auth.php');
    copy('update-files/config/broadcasting.php', '../config/broadcasting.php');
    copy('update-files/config/cache.php', '../config/cache.php');
    copy('update-files/config/cors.php', '../config/cors.php');
    copy('update-files/config/database.php', '../config/database.php');
    copy('update-files/config/ekart.php', '../config/ekart.php');
    copy('update-files/config/filesystems.php', '../config/filesystems.php');
    copy('update-files/config/flare.php', '../config/flare.php');
    copy('update-files/config/hashing.php', '../config/hashing.php');
    copy('update-files/config/ignition.php', '../config/ignition.php');
    copy('update-files/config/logging.php', '../config/logging.php');
    copy('update-files/config/queue.php', '../config/queue.php');
    copy('update-files/config/services.php', '../config/services.php');
    copy('update-files/config/session.php', '../config/session.php');
    copy('update-files/config/sslcommerz.php', '../config/sslcommerz.php');
    copy('update-files/config/tinker.php', '../config/tinker.php');
    copy('update-files/config/trustedproxy.php', '../config/trustedproxy.php');
    copy('update-files/config/view.php', '../config/view.php');
    /* config folder end */

    /* public folder starts */
    copy('update-files/public/firebase-messaging-sw.js', '../public/firebase-messaging-sw.js');
    copy('update-files/public/images/stars.png', '../public/images/stars.png');
    copy('update-files/public/images/no-image.png', '../public/images/no-image.png');
    copy('update-files/public/images/loading.gif', '../public/images/loading.gif');
    copy('update-files/public/images/1614235219.png', '../public/images/1614235219.png');
    copy('update-files/public/images/1613622694.png', '../public/images/1613622694.png');
    copy('update-files/public/images/1614224721.png', '../public/images/1614224721.png');
    copy('update-files/public/images/cod.svg', '../public/images/cod.svg');
    copy('update-files/public/images/flutterwave.svg', '../public/images/flutterwave.svg');
    copy('update-files/public/images/midtrans.svg', '../public/images/midtrans.svg');
    copy('update-files/public/images/paypal.svg', '../public/images/paypal.svg');
    copy('update-files/public/images/paystack.svg', '../public/images/paystack.svg');
    copy('update-files/public/images/paytm.svg', '../public/images/paytm.svg');
    copy('update-files/public/images/payu.svg', '../public/images/payu.svg');
    copy('update-files/public/images/rozerpay.svg', '../public/images/rozerpay.svg');
    copy('update-files/public/images/stripe.svg', '../public/images/stripe.svg');
    copy('update-files/public/images/vag.svg', '../public/images/vag.svg');
    copy('update-files/public/images/nonvag.svg', '../public/images/nonvag.svg');
    copy('update-files/public/images/cancellable.svg', '../public/images/cancellable.svg');
    copy('update-files/public/images/not-cancellable.svg', '../public/images/not-cancellable.svg');
    copy('update-files/public/images/returnable.svg', '../public/images/returnable.svg');
    copy('update-files/public/images/not-returnable.svg', '../public/images/not-returnable.svg');
    copy('update-files/public/images/placeholder.png', '../public/images/placeholder.png');
    copy('update-files/public/images/sslecommerz.svg', '../public/images/sslecommerz.svg');
    copy('update-files/public/images/banktransfer.svg', '../public/images/banktransfer.svg');
    
    
    copy('update-files/public/js/accounts.js', '../public/js/accounts.js');
    copy('update-files/public/js/address.js', '../public/js/address.js');
    copy('update-files/public/js/checkout-payment.js', '../public/js/checkout-payment.js');
    copy('update-files/public/js/firebase.js', '../public/js/firebase.js');
    copy('update-files/public/js/firebase-analytics.js', '../public/js/firebase-analytics.js');
    copy('update-files/public/js/firebase-app.js', '../public/js/firebase-app.js');
    copy('update-files/public/js/firebase-auth.js', '../public/js/firebase-auth.js');
    copy('update-files/public/js/firebase-firestore.js', '../public/js/firebase-firestore.js');
    copy('update-files/public/js/jquery.combostars.js', '../public/js/jquery.combostars.js');
    copy('update-files/public/js/login.js', '../public/js/login.js');
    copy('update-files/public/js/payment-gateway-flutterwave.js', '../public/js/payment-gateway-flutterwave.js');
    copy('update-files/public/js/payment-gateway-paypal.js', '../public/js/payment-gateway-paypal.js');
    copy('update-files/public/js/payment-gateway-paystack.js', '../public/js/payment-gateway-paystack.js');
    copy('update-files/public/js/payment-gateway-paytm.js', '../public/js/payment-gateway-paytm.js');
    copy('update-files/public/js/payment-gateway-payumoney.js', '../public/js/payment-gateway-payumoney.js');
    copy('update-files/public/js/payment-gateway-razorpay.js', '../public/js/payment-gateway-razorpay.js');
    copy('update-files/public/js/payment-gateway-sslcommerz-live.js', '../public/js/payment-gateway-sslcommerz-live.js');
    copy('update-files/public/js/payment-gateway-sslcommerz.js', '../public/js/payment-gateway-sslcommerz.js');
    copy('update-files/public/js/payment-gateway-stripe.js', '../public/js/payment-gateway-stripe.js');
    copy('update-files/public/js/register.js', '../public/js/register.js');
    copy('update-files/public/js/script.js', '../public/js/script.js');
    copy('update-files/public/js/lottie-player.js', '../public/js/lottie-player.js');
    copy('update-files/public/js/lottie-player.json', '../public/js/lottie-player.json');
    
    copy('update-files/public/themes/eCart/css/alertify.min.css', '../public/themes/eCart/css/alertify.min.css');
    copy('update-files/public/themes/eCart/css/animate.css', '../public/themes/eCart/css/animatemin.css');
    copy('update-files/public/themes/eCart/css/bootstrap.min.css', '../public/themes/eCart/css/bootstrap.min.css');
    copy('update-files/public/themes/eCart/css/bootstrapalert.min.css', '../public/themes/eCart/css/bootstrapalert.min.css');
    copy('update-files/public/themes/eCart/css/bundle.css', '../public/themes/eCart/css/bundle.css');
    copy('update-files/public/themes/eCart/css/bundle.css.map', '../public/themes/eCart/css/bundle.css.map');
    copy('update-files/public/themes/eCart/css/calender.css', '../public/themes/eCart/css/calender.css');
    copy('update-files/public/themes/eCart/css/custom.css', '../public/themes/eCart/css/custom.css');
    copy('update-files/public/themes/eCart/css/default.min.css', '../public/themes/eCart/css/default.min.css');
    copy('update-files/public/themes/eCart/css/intlTelInput.css', '../public/themes/eCart/css/intlTelInput.css');
    copy('update-files/public/themes/eCart/css/jquery-ui.min.css', '../public/themes/eCart/css/jquery-ui.min.css');
    copy('update-files/public/themes/eCart/css/owl-carousel.css', '../public/themes/eCart/css/owl-carousel.css');
    copy('update-files/public/themes/eCart/css/plugins.css', '../public/themes/eCart/css/plugins.css');
    copy('update-files/public/themes/eCart/css/select2.min.css', '../public/themes/eCart/css/select2.min.css');
    copy('update-files/public/themes/eCart/css/semantic.min.css', '../public/themes/eCart/css/semantic.min.css');
    copy('update-files/public/themes/eCart/css/semanticalert.min.css', '../public/themes/eCart/css/semanticalert.min.css');
    copy('update-files/public/themes/eCart/css/sweetalert.min.css', '../public/themes/eCart/css/sweetalert.min.css');
    copy('update-files/public/themes/eCart/css/sweetalert2.css', '../public/themes/eCart/css/sweetalert2.css');
    copy('update-files/public/themes/eCart/css/switcherdemo.css', '../public/themes/eCart/css/switcherdemo.css');
    copy('update-files/public/themes/eCart/css/ui.css', '../public/themes/eCart/css/ui.css');
    copy('update-files/public/themes/eCart/css/spectrum.min.css', '../public/themes/eCart/css/spectrum.min.css');
    
    copy('update-files/public/themes/eCart/images/3.png', '../public/themes/eCart/images/3.png');
    copy('update-files/public/themes/eCart/images/aboutus.png', '../public/themes/eCart/images/aboutus.png');
    copy('update-files/public/themes/eCart/images/cart.png', '../public/themes/eCart/images/cart.png');
    copy('update-files/public/themes/eCart/images/darkmodegrid.png', '../public/themes/eCart/images/darkmodegrid.png');
    copy('update-files/public/themes/eCart/images/darkmodelist.png', '../public/themes/eCart/images/darkmodelist.png');
    copy('update-files/public/themes/eCart/images/darkmodephone.png', '../public/themes/eCart/images/darkmodephone.png');
    copy('update-files/public/themes/eCart/images/flags.png', '../public/themes/eCart/images/flags.png');
    copy('update-files/public/themes/eCart/images/flags@2x.png', '../public/themes/eCart/images/flags@2x.png');
    copy('update-files/public/themes/eCart/images/google1.png', '../public/themes/eCart/images/google1.png');
    copy('update-files/public/themes/eCart/images/login.png', '../public/themes/eCart/images/login.png');
    copy('update-files/public/themes/eCart/images/phone.png', '../public/themes/eCart/images/phone.png');
    copy('update-files/public/themes/eCart/images/search.png', '../public/themes/eCart/images/search.png');
    copy('update-files/public/themes/eCart/images/ui-icons_444444_256x240.png', '../public/themes/eCart/images/ui-icons_444444_256x240.png');
    copy('update-files/public/themes/eCart/images/user.png', '../public/themes/eCart/images/user.png');
    
    copy('update-files/public/themes/eCart/js/actionswitcher.js', '../public/themes/eCart/js/actionswitcher.js');
    copy('update-files/public/themes/eCart/js/alertify.min.js', '../public/themes/eCart/js/alertify.min.js');
    copy('update-files/public/themes/eCart/js/bootstrap.bundle.min.js', '../public/themes/eCart/js/bootstrap.bundle.min.js');
    copy('update-files/public/themes/eCart/js/cartajax.js', '../public/themes/eCart/js/cartajax.js');
    copy('update-files/public/themes/eCart/js/cartpageajax.js', '../public/themes/eCart/js/cartpageajax.js');
    copy('update-files/public/themes/eCart/js/counterup.js', '../public/themes/eCart/js/counterup.js');
    copy('update-files/public/themes/eCart/js/elevatezoom.js', '../public/themes/eCart/js/elevatezoom.js');
    copy('update-files/public/themes/eCart/js/footerbundle.js', '../public/themes/eCart/js/footerbundle.js');
    copy('update-files/public/themes/eCart/js/footerbundle.js.map', '../public/themes/eCart/js/footerbundle.js.map');
    copy('update-files/public/themes/eCart/js/headerbundle.js', '../public/themes/eCart/js/headerbundle.js');
    copy('update-files/public/themes/eCart/js/headerbundle.js.map', '../public/themes/eCart/js/headerbundle.js.map');
    copy('update-files/public/themes/eCart/js/intlTelInput.js', '../public/themes/eCart/js/intlTelInput.js');
    copy('update-files/public/themes/eCart/js/jquery-3.5.1.min.js', '../public/themes/eCart/js/jquery-3.5.1.min.js');
    copy('update-files/public/themes/eCart/js/jquery-ui.min.js', '../public/themes/eCart/js/jquery-ui.min.js');
    copy('update-files/public/themes/eCart/js/jquery.countdown.js', '../public/themes/eCart/js/jquery.countdown.js');
    copy('update-files/public/themes/eCart/js/lazy.js', '../public/themes/eCart/js/lazy.js');
    
    copy('update-files/public/themes/eCart/js/owl-carousel.js', '../public/themes/eCart/js/owl-carousel.js');
    copy('update-files/public/themes/eCart/js/plugins.js', '../public/themes/eCart/js/plugins.js');
    copy('update-files/public/themes/eCart/js/script.js', '../public/themes/eCart/js/script.js');
    copy('update-files/public/themes/eCart/js/select2.min.js', '../public/themes/eCart/js/select2.min.js');
    copy('update-files/public/themes/eCart/js/semantic.min.js', '../public/themes/eCart/js/semantic.min.js');
    copy('update-files/public/themes/eCart/js/spectrum.min.js', '../public/themes/eCart/js/spectrum.min.js');
    copy('update-files/public/themes/eCart/js/sweet-alert.init.js', '../public/themes/eCart/js/sweet-alert.init.js');
    copy('update-files/public/themes/eCart/js/sweetalert.min.js', '../public/themes/eCart/js/sweetalert.min.js');
    copy('update-files/public/themes/eCart/js/sweetalert2.all.js', '../public/themes/eCart/js/sweetalert2.all.js');
    copy('update-files/public/themes/eCart/js/swiper-bundle.min.js', '../public/themes/eCart/js/swiper-bundle.min.js');
    copy('update-files/public/themes/eCart/js/switcherdemo.js', '../public/themes/eCart/js/switcherdemo.js');
    copy('update-files/public/themes/eCart/js/wow.js', '../public/themes/eCart/js/wow.js');
    
   
    /* eCart_02 public files end here */
    
    /* public folder end */

    /* resources folder end */
    copy('update-files/resources/lang/en/auth.php', '../resources/lang/en/auth.php');
    copy('update-files/resources/lang/en/msg.php', '../resources/lang/en/msg.php');
    copy('update-files/resources/lang/en/validation.php', '../resources/lang/en/validation.php');
    copy('update-files/resources/sass/app.scss', '../resources/sass/app.scss');
    
    copy('update-files/resources/views/errors/401.blade.php', '../resources/views/errors/401.blade.php');
    copy('update-files/resources/views/errors/403.blade.php', '../resources/views/errors/403.blade.php');
    copy('update-files/resources/views/errors/404.blade.php', '../resources/views/errors/404.blade.php');
    copy('update-files/resources/views/errors/419.blade.php', '../resources/views/errors/419.blade.php');
    copy('update-files/resources/views/errors/429.blade.php', '../resources/views/errors/429.blade.php');
    copy('update-files/resources/views/errors/500.blade.php', '../resources/views/errors/500.blade.php');
    copy('update-files/resources/views/errors/503.blade.php', '../resources/views/errors/503.blade.php');
    copy('update-files/resources/views/errors/illustrated-layout.blade.php', '../resources/views/errors/illustrated-layout.blade.php');
    copy('update-files/resources/views/errors/layout.blade.php', '../resources/views/errors/layout.blade.php');
    copy('update-files/resources/views/errors/minimal.blade.php', '../resources/views/errors/minimal.blade.php');
    
    copy('update-files/resources/views/payment-gateways/flutterwave.blade.php', '../resources/views/payment-gateways/flutterwave.blade.php');
    copy('update-files/resources/views/payment-gateways/paypal.blade.php', '../resources/views/payment-gateways/paypal.blade.php');
    copy('update-files/resources/views/payment-gateways/paystack.blade.php', '../resources/views/payment-gateways/paystack.blade.php');
    copy('update-files/resources/views/payment-gateways/paytm.blade.php', '../resources/views/payment-gateways/paytm.blade.php');
    copy('update-files/resources/views/payment-gateways/payu-bolt.blade.php', '../resources/views/payment-gateways/payu-bolt.blade.php');
    copy('update-files/resources/views/payment-gateways/pgRedirect.blade.php', '../resources/views/payment-gateways/pgRedirect.blade.php');
    copy('update-files/resources/views/payment-gateways/razorpay.blade.php', '../resources/views/payment-gateways/razorpay.blade.php');
    copy('update-files/resources/views/payment-gateways/stripe.blade.php', '../resources/views/payment-gateways/stripe.blade.php');
    
   
    copy('update-files/resources/views/themes/eCart/common/header.blade.php', '../resources/views/themes/eCart/common/header.blade.php');
    copy('update-files/resources/views/themes/eCart/common/footer.blade.php', '../resources/views/themes/eCart/common/footer.blade.php');
    copy('update-files/resources/views/themes/eCart/common/msg.blade.php', '../resources/views/themes/eCart/common/msg.blade.php');
   
    copy('update-files/resources/views/themes/eCart/parts/categories.blade.php', '../resources/views/themes/eCart/parts/categories.blade.php');
    copy('update-files/resources/views/themes/eCart/parts/offers.blade.php', '../resources/views/themes/eCart/parts/offers.blade.php');
     copy('update-files/resources/views/themes/eCart/parts/seller.blade.php', '../resources/views/themes/eCart/parts/seller.blade.php');
    copy('update-files/resources/views/themes/eCart/parts/style_1.blade.php', '../resources/views/themes/eCart/parts/style_1.blade.php');
    copy('update-files/resources/views/themes/eCart/parts/style_2.blade.php', '../resources/views/themes/eCart/parts/style_2.blade.php');
    copy('update-files/resources/views/themes/eCart/parts/style_3.blade.php', '../resources/views/themes/eCart/parts/style_3.blade.php');
    
    copy('update-files/resources/views/themes/eCart/user/account.blade.php', '../resources/views/themes/eCart/user/account.blade.php');
    copy('update-files/resources/views/themes/eCart/user/addresses.blade.php', '../resources/views/themes/eCart/user/addresses.blade.php');
    copy('update-files/resources/views/themes/eCart/user/favorites.blade.php', '../resources/views/themes/eCart/user/favorites.blade.php');
    copy('update-files/resources/views/themes/eCart/user/notification.blade.php', '../resources/views/themes/eCart/user/notification.blade.php');
    copy('update-files/resources/views/themes/eCart/user/orders.blade.php', '../resources/views/themes/eCart/user/orders.blade.php');
    copy('update-files/resources/views/themes/eCart/user/order-sidebar.blade.php', '../resources/views/themes/eCart/user/order-sidebar.blade.php');
    copy('update-files/resources/views/themes/eCart/user/order-track.blade.php', '../resources/views/themes/eCart/user/order-track.blade.php');
    copy('update-files/resources/views/themes/eCart/user/password.blade.php', '../resources/views/themes/eCart/user/password.blade.php');
    copy('update-files/resources/views/themes/eCart/user/refer-earn.blade.php', '../resources/views/themes/eCart/user/refer-earn.blade.php');
    copy('update-files/resources/views/themes/eCart/user/sidebar.blade.php', '../resources/views/themes/eCart/user/sidebar.blade.php');
    copy('update-files/resources/views/themes/eCart/user/transaction-history.blade.php', '../resources/views/themes/eCart/user/transaction-history.blade.php');
    copy('update-files/resources/views/themes/eCart/user/wallet-history.blade.php', '../resources/views/themes/eCart/user/wallet-history.blade.php');
    copy('update-files/resources/views/themes/eCart/user/invoice.blade.php', '../resources/views/themes/eCart/user/invoice.blade.php');
    
    copy('update-files/resources/views/themes/eCart/about.blade.php', '../resources/views/themes/eCart/about.blade.php');
    copy('update-files/resources/views/themes/eCart/cart.blade.php', '../resources/views/themes/eCart/cart.blade.php');
    copy('update-files/resources/views/themes/eCart/categories_all.blade.php', '../resources/views/themes/eCart/categories_all.blade.php');
    copy('update-files/resources/views/themes/eCart/mail.blade.php', '../resources/views/themes/eCart/mail.blade.php');
    copy('update-files/resources/views/themes/eCart/page.blade.php', '../resources/views/themes/eCart/page.blade.php');
    copy('update-files/resources/views/themes/eCart/error.blade.php', '../resources/views/themes/eCart/error.blade.php');
    copy('update-files/resources/views/themes/eCart/sub-categories.blade.php', '../resources/views/themes/eCart/sub-categories.blade.php');
    copy('update-files/resources/views/themes/eCart/home.blade.php', '../resources/views/themes/eCart/home.blade.php');
    copy('update-files/resources/views/themes/eCart/faq.blade.php', '../resources/views/themes/eCart/faq.blade.php');
    copy('update-files/resources/views/themes/eCart/contact.blade.php', '../resources/views/themes/eCart/contact.blade.php');
    copy('update-files/resources/views/themes/eCart/register.blade.php', '../resources/views/themes/eCart/register.blade.php');
    copy('update-files/resources/views/themes/eCart/login.blade.php', '../resources/views/themes/eCart/login.blade.php');
    copy('update-files/resources/views/themes/eCart/checkout_summary.blade.php', '../resources/views/themes/eCart/checkout_summary.blade.php');
    copy('update-files/resources/views/themes/eCart/shop.blade.php', '../resources/views/themes/eCart/shop.blade.php');
    copy('update-files/resources/views/themes/eCart/checkout_payment.blade.php', '../resources/views/themes/eCart/checkout_payment.blade.php');
    copy('update-files/resources/views/themes/eCart/product.blade.php', '../resources/views/themes/eCart/product.blade.php');
    copy('update-files/resources/views/themes/eCart/checkout_address.blade.php', '../resources/views/themes/eCart/checkout_address.blade.php');
    copy('update-files/resources/views/themes/eCart/seller-details.blade.php', '../resources/views/themes/eCart/seller-details.blade.php');
    copy('update-files/resources/views/themes/eCart/seller_all.blade.php', '../resources/views/themes/eCart/seller_all.blade.php');
    copy('update-files/resources/views/themes/eCart/underconstruction.blade.php', '../resources/views/themes/eCart/underconstruction.blade.php');
    
  
    /* resources folder end */
    /* routes folder starts */
    copy('update-files/routes/api.php', '../routes/api.php');
    copy('update-files/routes/channels.php', '../routes/channels.php');
    copy('update-files/routes/console.php', '../routes/console.php');
    copy('update-files/routes/web.php', '../routes/web.php');
    /* routes folder end */

    /* root files start here */
    copy('update-files/artisan', '../artisan');
    copy('update-files/composer.json', '../composer.json');
    copy('update-files/composer.lock', '../composer.lock');
    copy('update-files/index.php', '../index.php');
    copy('update-files/package.json', '../package.json');
    copy('update-files/package-lock.json', '../package-lock.json');
    copy('update-files/phpunit.xml', '../phpunit.xml');
    copy('update-files/server.php', '../server.php');
    copy('update-files/webpack.mix.js', '../webpack.mix.js');
    copy('update-files/.editorconfig', '../.editorconfig');
    copy('update-files/.styleci.yml', '../.styleci.yml');
    copy('update-files/firebase-messaging-sw.js', '../firebase-messaging-sw.js');

    /* root files end here */

    echo "Congratulations! You have successfully upgraded your system!<br/><h4>If you liked our Auto Update system</h4>";

    $_SESSION['count'] = "applied";
    echo "Operation done successfully! Do not perform this second time! ";
} else {

    exit("Operation already applied! Cannot perform this second time! Please now delete the <b>/update</b> folder from your server directory");
}
