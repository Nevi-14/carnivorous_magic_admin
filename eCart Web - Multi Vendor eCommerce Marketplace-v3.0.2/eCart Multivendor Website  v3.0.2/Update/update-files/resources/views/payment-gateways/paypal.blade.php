<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ Cache::get('app_name', get('name')) }}</title>
    </head>
    <body>
        <form action="{{ $payment_url }}" method="post">
            <input type='hidden' name='business' value='{{ $paymentMethods->paypal_business_email }}'> 
            <input type='hidden' name='item_name' value='{{ get('name') }}'>
            <input type='hidden' name='item_number' value='{{ substr(hash('sha256', getTxnId() . microtime()), 0, 20) }}'>
            <input type='hidden' name='amount' value='{{ $amount }}'>
            <input type='hidden' name='no_shipping' value='1'>
            <input type='hidden' name='currency_code' value='{{ $paymentMethods->paypal_currency_code }}'>
            <input type='hidden' name='notify_url' value='{{ get('api_url').get('apis.paypal-ipn') }}'>
            <input type='hidden' name='cancel_return' value='{{ route('checkout-paypal', 'cancel') }}'>
            <input type='hidden' name='return' value='{{ route('checkout-paypal','return') }}'>
            <input type="hidden" name="cmd" value="_xclick">
        </form>
    </body>
    <script src="{{ asset('js/payment-gateway-paypal.js') }}"></script>
</html>