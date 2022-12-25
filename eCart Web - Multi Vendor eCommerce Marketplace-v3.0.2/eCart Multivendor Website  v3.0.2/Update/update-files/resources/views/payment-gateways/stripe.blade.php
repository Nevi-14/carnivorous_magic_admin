<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ Cache::get('app_name', get('name')) }}</title>
        <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
        <script src="https://js.stripe.com/v3/"></script>    
    </head>
    <script type="text/javascript">
        Stripe("{{ $paymentMethods->stripe_publishable_key }}").redirectToCheckout({ sessionId: '{{ $checkout_session->id }}' });
    </script>
</html>