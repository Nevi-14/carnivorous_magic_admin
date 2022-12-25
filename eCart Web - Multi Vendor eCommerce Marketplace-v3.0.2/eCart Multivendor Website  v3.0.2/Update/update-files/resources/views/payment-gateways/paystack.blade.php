<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <title>{{ Cache::get('app_name', get('name')) }}</title>
  </head>
  <body>
  <form>
    <input type='hidden' name='key' id='key' value='{{ $paymentMethods->paystack_public_key }}'> 
    <input type='hidden' name='email' id='email' value='{{ $loggedInUser['email'] }}'>
    <input type='hidden' name='amount' id='amount' value='{{ floatval($amount) }}'>
    <input type='hidden' name='ref' id='ref' value='{{ round(microtime(true) * 1000).'Ref' }}'>
    <input type='hidden' name='close_url' id='close_url' value='{{ route('payment-paystack-complete', 'cancel') }}'>
    <input type='hidden' name='callback_url' id='callback_url' value='{{ route('payment-paystack-complete', 'success') }}'>
  </form>
  </body>
<script src="{{ asset('js/payment-gateway-paystack.js') }}"></script>
</html>