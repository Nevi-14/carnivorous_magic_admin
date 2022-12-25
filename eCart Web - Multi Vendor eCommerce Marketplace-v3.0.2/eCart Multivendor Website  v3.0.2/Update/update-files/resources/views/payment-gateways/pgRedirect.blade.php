<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>{{ Cache::get('app_name', get('name')) }}</title>
</head>
<body>
	@php
	 $paymentMethods = Cache::get('payment_methods');
        if(isset($paymentMethods->paytm_payment_method) && $paymentMethods->paytm_payment_method == 1){
        $mode = $paymentMethods->paytm_mode;
            if($mode=="sandbox"){
                $paytm_url ="https://securegw-stage.paytm.in/order/process";
            }
            else{
                $paytm_url ="https://securegw.paytm.in/order/process";
            }
        }
    @endphp
	<form action="{{ $paytm_url }}" name="f1" id="f1">
		<table>
			<caption>{{__('msg.paytm_payment')}}</caption>
			<tbody>
			<tr>
			<th scope="col">
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</th>
			</tr>
			</tbody>
		</table>
	</form>
	<script src="{{ asset('js/payment-gateway-paytm.js') }}"></script>
</body>

</html>