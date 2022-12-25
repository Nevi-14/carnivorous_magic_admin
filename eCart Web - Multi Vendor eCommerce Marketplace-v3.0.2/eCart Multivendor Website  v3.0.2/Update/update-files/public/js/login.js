"use strict";

$( document ).ready(function() {

    var input = document.querySelector("#phone");

    window.intlTelInput(input);

    $("#formRegister").on("submit", function(e){

        e.preventDefault();

        $("#registerError").fadeOut();

        var c = $(".iti__selected-flag").attr('title').split(" ");

        c = c[c.length -1];

        $("input[name=country_code]").val(c);

        $("#formRegister").find("button[type=submit]").attr('disabled', 'disabled');

        $.ajax({

            type : "GET",

            cache : false,

            url : home + 'already-registered',

            data : { mobile : $("#phone").val()},  

            success: function (response) {

                var obj = JSON.parse(response);

                var action = $("input[type=hidden][name=action]").val();

                var goAhead = false;

                if(action == 0){

                    if(obj.error === true){

                        goAhead = true;

                    }else{

                        $("#registerError").html('Mobile number is not registered.').show();

                        $("#formRegister").find("button[type=submit]").removeAttr('disabled');

                    }

                }else{

                    if(obj.error === true){

                        $("#registerError").html(obj.message).show();

                        $("#formRegister").find("button[type=submit]").removeAttr('disabled');

                    }else{

                        goAhead = true

                    }

                }

                if(goAhead){

                    var phoneNumber = c + $("#phone").val();

                    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {

                        'size': 'invisible',

                        'callback': function(res) {

                            // reCAPTCHA solved, allow signInWithPhoneNumber.

                            onSignInSubmit();

                        }

                    });

                    var appVerifier = window.recaptchaVerifier;



                    firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier).then(function (confirmationResult) {

                        // confirmationResult can resolve with the whitelisted testVerificationCode above.

                        $("#cardRegister").hide();

                        $("#cardOtp").show();

                        $("#formOtpVerification input[type=text][name=mobile]").val(phoneNumber);

                        $("#formOtpVerification input[type=number][name=otp]").focus();

                        console.log("confirmation");

                        console.log(confirmationResult);



                        $("#verifyOtp").on("click", function(ev){

                            ev.preventDefault();

                            var otp = $("#formOtpVerification input[type=number][name=otp]");

                            if(otp.val().length == 6){

                                var code = otp.val();

                                confirmationResult.confirm(code).then(function (result) {

                                    var user = result.user;

                                    if(action == 0){

                                        $("#cardResetPassword").show();

                                        $("#cardOtp").hide();

                                        $("#cardResetPassword input[name=mobile]").val(phoneNumber);

                                        $("#mobileResetPassword").val(phoneNumber);

                                        $("#cardResetPassword input[type=password][name=password]").focus();

                                    }else if(action == 1){

                                        $("#formOtpVerification input[type=hidden][name=auth_uid]").val(user.uid);

                                        $("#formOtpVerification").submit();

                                    }

                                }).catch(function (error) {

                                    console.log(error.message);

                                    $("#otpSuccess").hide();

                                    $("#otpError").html("Invalid OTP. Please Enter Valid OTP").show();

                                });

                            }else{

                                otp.focus();

                                $("#otp-error").show();

                                otp.parent().vibrate({stopAfterTime:2});

                            }

                        });

                    }).catch(function (error) {

                        $("#registerError").html('Unable To Send OTP SMS. Kindly Contact administrator').show();

                        console.log('sms not sent');

                        console.log(error);

                    });

                }

            }

        });

    });

});
