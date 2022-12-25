<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ Cache::get('app_name', get('name')) }}</title>
    </head>
    <body>
    <form>
      <input type='hidden' name='public_key' id='public_key' value='{{ $paymentMethods->flutterwave_public_key }}'> 
      <input type='hidden' name='tx_ref' id='tx_ref' value='{{ round(microtime(true) * 1000).'Ref' }}'>
      <input type='hidden' name='amount' id='amount' value='{{ floatval($amount) }}'>
      <input type='hidden' name='currency' id='currency' value='{{ $paymentMethods->flutterwave_currency_code }}'>
      <input type='hidden' name='payment_options' id='payment_options' value='card, mobilemoneyghana, ussd'>
      <input type='hidden' name='currency_code' id='currency_code' value='{{ $paymentMethods->paypal_currency_code }}'>
      <input type='hidden' name='redirect_url' id='redirect_url' value="{{ route('payment-flutterwave-complete', ['type' => 'success']) }}">
      <input type='hidden' name='email' id='email' value="{{ $loggedInUser['email'] }}">
      <input type='hidden' name='phone_number' id='phone_number' value="{{ $loggedInUser['mobile'] }}">
      <input type="hidden" name="name" id="name" value="{{ $loggedInUser['name'] }}">
      <input type="hidden" name="cancel_return" id='cancel_return' value="{{ route('payment-flutterwave-complete', 'cancel') }}">
      <input type="hidden" name="title" id='title' value="{{ Cache::get('app_name', get('name')) }}">
      <input type="hidden" name="description" id='description' value="Towards Purchase From {{ Cache::get('app_name', get('name')) }}">
      <input type="hidden" name="logo" id='logo' value="{{ _asset(Cache::get('logo')) }}" id="logo">
  </form>
</body>
  <script src="{{ asset('js/payment-gateway-flutterwave.js') }}"></script>
</html>