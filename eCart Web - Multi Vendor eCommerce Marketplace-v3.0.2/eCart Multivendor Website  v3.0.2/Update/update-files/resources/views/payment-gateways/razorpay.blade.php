<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ Cache::get('app_name', get('name')) }}</title>
    </head>
    <body>
        <form action="<?php echo route('checkout-razorpay'); ?>" method="POST">
            <input type="hidden" name="data" value='{{ json_encode($response) }}'>

            <input type="hidden" name="amount" value='{{ $amount }}'>
            <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" value="">
            <input type="hidden" id="razorpay_order_id" name="razorpay_order_id" value="">
            <input type="hidden" id="razorpay_signature" name="razorpay_signature" value="">
            <input type="hidden" id="razorpay_key" name="razorpay_key" value="{{ Cache::get('payment_methods')->razorpay_key }}">
            <input type="hidden" id="razorpay_amount" name="razorpay_amount" value="{{ $response['amount'] }}">
            <input type="hidden" id="razorpay_currency" name="razorpay_currency" value="{{ $response['currency'] }}">
            <input type="hidden" id="razorpay_name" name="razorpay_name" value="{{ get('name') }}">
            <input type="hidden" id="razorpay_id" name="razorpay_id" value="{{ $response['id'] }}">
            <input type="hidden" id="logo" name="logo" value="{{ asset('images/headerlogo.png') }}">
            <input type="hidden" id="loggedin_name" name="loggedin_name" value="{{ $loggedInUser['name'] }}">
            <input type="hidden" id="loggedin_email" name="loggedin_email" value="{{ $loggedInUser['email'] }}">
            <input type="hidden" id="loggedin_contact" name="loggedin_contact" value="{{ $loggedInUser['mobile'] }}">
            <input type="hidden" id="cancel_url" value="{{ route('checkout-payment') }}">
        </form>
    </body>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="{{ asset('js/payment-gateway-razorpay.js') }}"></script>
</html>
