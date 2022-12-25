"use strict";

$(document).ready(function(){
    /* datepicker start*/
    $('#datepicker').datepicker({
        dateFormat:'dd-mm-yy',
        minDate: $("#datepicker").data('start') + 'd',
        maxDate: $("#datepicker").data('end') + "d",
        todayHighlight: true,
        inline: true,
        altField: "#date",
    }).on("change", function(e){
        var daySelected = $("[name=deliverDay]").val();
        $("#deliveryDatePrint").html(daySelected);

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        var todayDate = dd + '-' + mm + '-' + yyyy;
        var currentTime = new Date();
        var currentHours = currentTime.getHours();
        if(daySelected == todayDate){
            $("input[type=radio][name=deliverTime]").each(function(){
                if(currentHours < parseInt($(this).data('last'))){
                    $(this).removeAttr('disabled');
                }else{
                    $(this).attr('disabled', 'disabled');
                }
            });
        }else {
            $("input[type=radio][name=deliverTime]").removeAttr('disabled', 'disabled');
        }
        $("input[type=radio][name=deliverTime]:not(:disabled):first").prop('checked', true);

        $("input[type=radio][name=deliverTime]:not(:disabled):first").attr('checked', true);

    }).change();

    $("input[type=radio][name=deliverTime]").on("change", function(e){
        $("input[type=hidden][name=deliveryTime]").val($(this).val());
    }).change();

    $("input[type=radio][name=payment_method]").on("change", function(e){
        $("input[type=hidden][name=paymentMethod]").val($(this).val());
    });
    $("input[type=radio][name=payment_method]:first").change();
    $("input[type=radio][name=deliverTime]:checked").change();
    $("#proceed").on("click", function(e){
        $("#paymentError").hide();
        $("#timeError").hide();
        $("#dateError").hide();
        var availablePaymentMethods = ["cod", "paypal", "payumoney", "payumoney-bolt", "razorpay", "stripe", "midtrans", "flutterwave", "paystack", "paytm", "sslecommerz", "bank_transfer"]
        var paymentMethod = $("input[type=radio][name=payment_method]:checked").val();
            
                
    });
    $("#wallet").on("change", function(e){
        e.preventDefault();
        if ($(this).prop('checked')==true){
            $("input[type=hidden][name=wallet_used]").val('true');
            $(".walletNotUsed").hide();
            $(".walletUsed").show();
        }else{
            $("input[type=hidden][name=wallet_used]").val('false');
            $(".walletNotUsed").show();
            $(".walletUsed").hide();
        }
    });
});