<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>{{ Cache::get('app_name', get('name')) }}</title>
</head>
<body>
	<form method="POST" action="{{ route('pgRedirect') }}">
		<input type="hidden" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo  "ORDS" . random_int(0,99)?>">
		<input type="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="{{ $loggedInUser['user_id'] }}"></td>
		<input type="hidden" id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail"></td>
		<input type="hidden" id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
		<input title="TXN_AMOUNT" tabindex="10" type="hidden" name="TXN_AMOUNT" value="{{ $tmp['final_total'] }}">
	</form>
</body>
<script src="{{ asset('js/payment-gateway-paytm.js') }}"></script>
</html>