<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
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
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		
		<script>
	"use strict";
window.onload = function(){
    document.forms[0].submit();
}
</script>
	</form>
</body>

</html>