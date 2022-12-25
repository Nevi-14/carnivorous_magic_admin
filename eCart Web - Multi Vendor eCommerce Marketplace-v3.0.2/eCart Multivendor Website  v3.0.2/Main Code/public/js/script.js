"use strict";

$(document).ready(function () {
    $("body").on("submit", ".addToCart", function () {
        if ($(this).find("select[name=child_id] option:selected").val() == 0) {
            $(this)
                .find("select[name=child_id]")
                .focus()
                .vibrate({ stopAfterTime: 2 });
            return false;
        } else {
            return true;
        }
    });
    $("body").on("click", ".button-plus", function () {
        let qP = $(this).parent().parent().find(".qtyPicker");
        var v = $(".active input[type=radio][name=options]").data();
        var cpage_stock = $(this).parent().parent().find(".qtyPicker").data("max");
        var cpage_stock_allowed = $(this).parent().parent().find(".qtyPicker").data("max-allowed");
        let nP = parseInt(qP.val()) + 1;
        if (v) {
        var checkval = v.maxAllowedStock > v.stock ? v.stock : v.maxAllowedStock;
        var stock = v.stock;
        var maxAllowedStock = v.maxAllowedStock;
        } else {
        var checkval = cpage_stock_allowed > cpage_stock ? cpage_stock : cpage_stock_allowed;
        var stock = cpage_stock;
        var maxAllowedStock = cpage_stock_allowed;
        }
        if (checkval > nP - 1) {
            qP.val(nP);
            $(this)
                .parent()
                .parent()
                .find(".button-minus")
                .removeAttr("disabled");
        } else {
            $(this).attr("disabled", "disabled");
        }
        if (nP - 1 == parseInt(stock)) {
            alertify.set("notifier", "position", "top-center");
            alertify.warning("Oops! Limited stock available.");
        }
        if (nP - 1 == parseInt(maxAllowedStock)) {
            alertify.set("notifier", "position", "top-center");
            alertify.warning("Oops! You reached maximum items allowed in cart.");
        }
        var qty = $(".qtyPicker-single-page").val();
        $(".active input[type=radio][name=options]").attr("data-qty", qty).change();
    });
    
    $("body").on("click", ".button-minus", function () {
        let qP = $(this).parent().parent().find(".qtyPicker");
        let nP = parseInt(qP.val()) - 1;
        if (qP.data("min") <= nP) {
            qP.val(nP);
            $(this).parent().parent().find(".button-plus").removeAttr("disabled");
            $(this).parent().parent().find(".button-plus-cart").removeAttr("disabled");
        } else {
            $(this).attr("disabled", "disabled");
        }
        var qty = $(".qtyPicker-single-page").val();
        $(".active input[type=radio][name=options]").attr("data-qty", qty).change();
    });
    if ($('[data-toggle="tooltip"]').length > 0) {
        $('[data-toggle="tooltip"]').tooltip();
    }
    $("body").on("change", ".addToCart select[name=child_id]", function () {
        let val = $(this).find("option:selected").val();
        if (val > 0) {
            $(".actualPrice")
                .html($(this).find("option:selected").data("price"))
                .show();
            $(".rangePrice").hide();
        } else {
            $(".actualPrice").hide();
            $(".rangePrice").show();
        }
    });

    $("body").on("change", "select[name=child_id]", function () {
        let selected = $(this).find("option:selected");
        $("#productPrice" + $(this).data("id")).html(selected.data("price"));
        if (selected.data("mrp") == "") {
            $("#productMrp" + $(this).data("id")).hide();
        } else {
            $("#productMrp" + $(this).data("id"))
                .html(selected.data("mrp"))
                .show();
        }
        $("#productTitle" + $(this).data("id")).html(selected.text());
        if (selected.data("discount") != "") {
            $("#productDiscount" + $(this).data("id"))
                .html(selected.data("discount"))
                .show();
        } else {
            $("#productDiscount" + $(this).data("id")).hide();
        }
    });

    $(document).on("click", ".btnEdit", function () {
        $(this).closest("tr").find(".cartShow").toggle();
        $(this).closest("tr").find(".cartEdit").toggle();
    });

    $(document).on("click", ".cartSave", function () {
        let tr = $(this).closest("tr");
        if (
            tr.find("form.cartEdit").find("input[name=qty]").val() ==
            tr.find(".price-wrap.cartShow").html()
        ) {
            tr.find(".cartShow").toggle();
            tr.find(".cartEdit").toggle();
        } else {
            tr.find("form.cartEdit").submit();
        }
    });

    $("#btnRegister").on("click", function (e) {
        $("#cardLogin").hide();
        $("#registerError").hide();
        $("#phone").val("");
        $("#cardRegister input[type=hidden][name=action]").val("1");
        $("#cardRegister").show();
        $("#cardRegister .card-title").html("Register");
        $(".alreadyLogin").show();
        $(".backToLogin").hide();
    });
    $(".btnLogin").on("click", function (e) {
        $("#cardLogin").show();
        $("#cardRegister").hide();
        $("#cardOtp").hide();
    });
    $("#btnForgot").on("click", function (e) {
        $("#cardLogin").hide();
        $("#registerError").hide();
        $("#phone").val("");
        $("#cardRegister input[type=hidden][name=action]").val("0");
        $("#cardRegister .card-title").html("Forgot Password");
        $("#cardRegister").show();
        $(".alreadyLogin").hide();
        $(".backToLogin").show();
    });
    // search function -->
    $("#searchForm").on("submit", function (e) {
        e.preventDefault();
        let s = $(this).find("input[name=s][type=text]").val().trim();
        if (s != "") {
            window.location.href = $(this).attr("action") + "/" + s;
        }
    });
    // end search function -->

    $(document).on(
        "focus",
        ".select2-selection.select2-selection--single",
        function (e) {
            $(this)
                .closest(".select2-container")
                .siblings("select:enabled")
                .select2("open");
        }
    );

    // reset password -->
    $("#formResetPassword").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: $(this).serialize(),
            success: function (response) {
                let data = JSON.parse(response);
                if (data.status === false) {
                    $("#errorResetPassword").html(data.message).show();
                } else {
                    $("#successResetPassword").html(data.message).show();
                    window.location.href = home;
                }
            },
        });
    });
    // end reset password -->

    $(".ajax-form").on("submit", function (e) {
        e.preventDefault();

        let formResponse = $(this).find(".formResponse");

        formResponse.html("").hide();

        let submit = $(this).find("button[type=submit]");

        submit.attr("disabled", "disabled");

        $.ajax({
            url: $(this).attr("action"),

            type: $(this).attr("method"),

            data: $(this).serialize(),

            success: function (response) {
                

                let data = response;

                if (IsJsonString(response) == true) {
                    data = JSON.parse(response);
                }
                console.log(data);
                var discount = localStorage.setItem('discount', data.discount);
                let msg = "Something Went Wrong";

                if (data.error === true) {
                    if (data.message != "") {
                        msg = data.message;
                    }

                    formResponse
                        .html(
                            "<div class='alert alert-danger'>" + msg + "</div>"
                        )
                        .show();

                    submit.removeAttr("disabled");
                } else {
                    msg = "Success";

                    if (data.message != "") {
                        msg = data.message;
                    }

                    alertify.set("notifier", "position", "top-right");
                    alertify.success(msg);
                    window.timeout = setTimeout(function(){
                        alertify.dismissAll();
                      },2000);
                    //formResponse.html("<div class='alert alert-success'>" + msg + "</div>").show();
                }

                if (typeof data.url !== "undefined" && data.url != "") {
                    window.location.href = data.url;
                } else {
                    submit.removeAttr("disabled");
                }
            },
        });
    });

    $("#checkoutProceedBtn").on("click", function (e) {
        e.preventDefault();

        $("#paymentMethodError").html("").hide();

        let selectedPaymentMethod = $(
            "input[type=radio][name=paymentMethod]:checked"
        );

        if (typeof selectedPaymentMethod.val() === "undefined") {
            $("#paymentMethodError").show();
        } else {
            $("#checkoutProceed input[type=hidden][name=paymentMethod]").val(
                selectedPaymentMethod.val()
            );

            let deliveryTime = $(
                "input[type=radio][name=deliverTime]:checked"
            ).val();

            let deliverDay = $(
                "input[type=radio][name=deliverDay]:checked"
            ).val();

            $("#checkoutProceed input[type=hidden][name=deliveryTime]").val(
                deliveryTime + " - " + deliverDay
            );
        }
    });
    // favourite -->
    $("body").on("click", ".saved", function () {
        let i = $(this);
        i.removeClass("saved").addClass("save");
        var id = i.data("id");
        $.post(
            home + "favourite-post/remove",
            {
                id: i.data("id"),
            },
            function (data, status) {
                if (data == "login") {
                    $("#myModal").each(function () {
                        $(this).modal("show");
                    });
                } else {
                    try {
                        let r = JSON.parse(data);
                        console.log(data);
                        if ((r.error ?? true) == true) {
                            i.removeClass("saved").addClass("save");
                        }
                    } catch (e) {
                        i.removeClass("saved").addClass("save");
                    }
                    
                }
                $('#fav' + id).fadeOut(200, function(){
                $(this).remove();
                });
            }
        );
    });
    $("body").on("click", ".save", function () {
        let i = $(this);
        i.removeClass("save").addClass("saved");
        $.post(
            home + "favourite-post/add",
            {
                id: i.data("id"),
            },
            function (data, status) {
                if (data == "login") {
                    $("#myModal").each(function () {
                        $(this).modal("show");
                    });
                } else {
                    try {
                        let r = JSON.parse(data);
                        console.log(data);
                        if ((r.error ?? true) == true) {
                            i.removeClass("save").addClass("saved");
                        }
                    } catch (e) {
                        i.removeClass("save").addClass("saved");
                    }
                }
            }
        );
    });
    // end favourite -->
    $(document).on("click", ".variant .btn", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        console.log(id);
        let v = $(this).find("input[type=radio][name=options]").data();
        console.log(v);
        $("#child_" + id).val(v.id);
        $("#qtyPicker_" + id).attr("data-max", v.stock).change();
        $("#qtyPicker_" + id).attr("data-max-allowed", v.maxAllowedStock).change();
        $("#qtyPicker_" + id).attr("max", v.stock).change();
        $("#qtyPicker_" + id).attr("value", v.cart_count).change();
        if (v.mrp_number > 0) {
            $("#price_mrp_" + id)
                .show()
                .find(".value")
                .html(v.mrp);
            $("#price_savings_" + id)
                .show()
                .find(".value")
                .html(v.savings);
            $("#price_offer_" + id)
                .show()
                .find(".value")
                .html(v.price)
                .show();
            $("#price_regular_" + id).hide();
        } else {
            $("#price_mrp_" + id).hide();
            $("#price_savings_" + id).hide();
            $("#price_offer_" + id).hide();
            $("#price_regular_" + id)
                .show()
                .find(".value")
                .html(v.price);
        }
        var qty = $(this).find("input[type=radio][name=options]").attr("data-cart_count");
        console.log(qty);
        $("#qtyPicker_" + id).val(qty).change();
        $(".button-plus-single-page").removeAttr("disabled");
        $(".button-minus-single-page").removeAttr("disabled");
        
        //change product_variant_id
        $("input[name='product_variant_id']").attr("value", v.id).change();
    });
    $(document).on("click", ".button-plus-single-page", function (e) {
        var v = $(".active input[type=radio][name=options]").data();
        var qtylimit = $(".qtyPicker-single-page").val();
    });
    
    $("form").each(function (index, value) {
        $(this).find(".variant .btn:first").click();
    });

    $(".qtyPicker").on("change", function () {
        if (parseInt($(this).val()) < 1) {
            $(this).val(1);
        } else if (parseInt($(this).val()) >= $(this).data("max-allowed")) {
            $(this).val($(this).data("max-allowed"));
        }
    });

    $("select[name=varient]").on("change", function (e) {
        let id = $(this).data("id");
        let selected = $(this).find("option:selected");
        $("#price_" + id).html(selected.data("price"));
        $("#mrp_" + id).html(selected.data("mrp"));
        $("#savings_" + id).html(selected.data("savings"));
    });

    $(".footerfix").css("min-height", $(window).height() - 525);

    // home pade side menu category -->
    $("#navContainer").on("click", "li", function () {
        $(this).children("ul").toggleClass("active");
        $("#navContainer li").not(this).children("ul").removeClass("active");
    });

    // sub-header -->
    $(".dropdown").on(
        "hover",
        function () {
            $(this)
                .find(".dropdown-menu")
                .stop(true, true)
                .delay(200)
                .fadeIn(500);
        },
        function () {
            $(this)
                .find(".dropdown-menu")
                .stop(true, true)
                .delay(200)
                .fadeOut(500);
        }
    );

    $("#myCarouselArticle").carousel({
        interval: 10000,
    });

    $("#address").addClass("address-show");

    $("#editAddress").addClass("address-hide");

    $("#addAddress").addClass("address-hide");

    $("#dateError").addClass("error-hide");

    $("#timeError").addClass("error-hide");

    $("#paymentError").addClass("error-hide");

    $("#otp-error").addClass("error-hide");

    $("#otpError").addClass("error-hide");

    $("#errorResetPassword").addClass("error-hide");

    $("#registerError").addClass("error-hide");

    $("#cardOtp").addClass("card-hide");

    $("#cardResetPassword").addClass("card-hide");

    $("#registerError").addClass("error-hide");

    $("#backToLogin").addClass("error-hide");

    $("a[data-confirm]").on("click", function (ev) {
        let href = $(this).attr("href");

        $("#orderConfirm")
            .find(".modal-title")
            .text($(this).attr("data-confirm"));

        $("#modal-btn-yes").attr("href", href);

        $("#orderConfirm").modal({ show: true });

        return false;
    });

    $("a[data-confirm]").on("click", function (ev) {
        let href = $(this).attr("href");

        $("#modal").find(".modal-title").text($(this).attr("data-confirm"));

        $("#modal-btn-yes").attr("href", href);

        $("#modal").modal("show");

        return false;
    });

    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 200) {
            $("#scroll").fadeIn();
        } else {
            $("#scroll").fadeOut();
        }
    });
    $("#scroll").on("click", function () {
        return $("html, body").animate({ scrollTop: 0 }, 600);
    });

    $("#list").on("click",function (event) {
        event.preventDefault();
        $("#products .item1").addClass("list-group-item");
    });
    $("#grid").on("click",function (event) {
        event.preventDefault();
        $("#products .item1").removeClass("list-group-item");
        $("#products .item1").addClass("grid-group-item");
    });
    $("#sort").on("change", function (e) {
        $("input[type=hidden][name=sort]").val($(this).val());
        $("#filter").submit();
    });
    $(".subs").on("change", function () {
        let sub_ids = [];
        $(".subs:checked").each(function () {
            sub_ids.push($(this).val());
        });
        if (sub_ids.length > 0) {
            $("#filter input[type=hidden][name=sub-category]").val(
                sub_ids.join(",")
            );
        } else if (sub_ids.length == 0) {
            $("#filter input[type=hidden][name=sub-category]").val("");
        }
        $("#filter").submit();
    });
    $(".cats").on("change", function () {
        let cat_ids = [];
        $(".cats:checked").each(function () {
            cat_ids.push($(this).val());
        });
        if (cat_ids.length > 0) {
            $("#filter input[type=hidden][name=category]").val(
                cat_ids.join(",")
            );
        }
        else if (cat_ids.length == 0) {
            $("#filter input[type=hidden][name=category]").val("");
        }
        $("#filter").submit();
    });
    $(".discount_filter").on("change", function () {
        let discount_ids = [];
        $(".discount_filter:checked").each(function () {
            discount_ids.push($(this).val());
        });
        if (discount_ids.length > 0) {
            $("#filter input[type=hidden][name=discount_filter]").val(
                discount_ids.join(",")
            );
            $("#filter").submit();
        }
    });
    $(".out_of_stock").on("change", function () {
        let out_of_stock_ids = [];
        $(".out_of_stock:checked").each(function () {
            out_of_stock_ids.push($(this).val());
        });
        if (out_of_stock_ids.length > 0) {
            $("#filter input[type=hidden][name=out_of_stock]").val(
                out_of_stock_ids.join(",")
            );
            $("#filter").submit();
        }
    });
    let slider = $("#slider-range");
    slider.slider({
        range: true,
        min: slider.data("min"),
        max: slider.data("max"),
        values: [slider.data("selected-min"), slider.data("selected-max")],
        slide: function (event, ui) {
            $("input[type=number][name=min_price]").val(ui.values[0]);
            $("input[type=number][name=max_price]").val(ui.values[1]);
        },
    });
    $("#filter").on("submit", function () {
        $(this).find("button[type=submit]").click();
    });
});

function loadOptions(
    element,
    url,
    clear = false,
    open = false,
    triggerChange = false,
    selected = 0
) {
    if (clear == true) {
        element.find("option").remove();
    }
    $.ajax({
        url: url,
        success: function (response) {
            let data = JSON.parse(response);
            console.log(data);
            $.each(data, function (id, item) {
                if (element.val() != item.id) {
                    let isSelected = false;
                    if (selected == item.id) {
                        isSelected = true;
                    }
                    element.append(
                        new Option(item.name, item.id, isSelected, isSelected)
                    );
                }
            });
            element.select2("close");
            if (open == true) {
                element.select2("open");
            }
            if (triggerChange == true) {
                element.trigger("change");
            }
        },
    });
}
function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function address() {
    if ($("#address").hasClass("address-show")) {
        $("#addAddress").removeClass("address-hide");
        $("#addAddress").addClass("address-show");
        $("#address").removeClass("address-show");
        $("#address").addClass("address-hide");
    } else {
        $("#editAddress").addClass("address-hide");
        $("#addAddress").addClass("address-show");
    }
}
function copycode() {
    /* Get the text field */
    let copyText = document.getElementById("referCode");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");
}

$(".content_dropdown_categories").css('display', 'block');

$("input[type=radio][name=payment_method]").change(function () {
    let paybtn = document.getElementsByClassName("paybtn");
    let sslbuttons = document.getElementsByClassName("sslbuttons");
    let total_payble = $("input[name='total_payable']").val();
   
    if (this.value == "sslecommerz") {
        if ($("#wallet").prop("checked") == true) {
            if (total_payble == 0) {
                $(paybtn).show();
                $(sslbuttons).hide();
            } else {
                $(paybtn).hide();
                $(sslbuttons).show();
            }
        } else {
            $(paybtn).hide();
            $(sslbuttons).show();
        }
    } else {
        $(paybtn).show();
        $(sslbuttons).hide();
    }

    let ddate = document.getElementsByClassName("deliverDay");
   
        var payment_type = this.value;
        //console.log(payment_type);
        $.ajax({
        url: home + "get_shipdel_charge",
                type: "POST",
                dataType: "json",
                data: {
                payment_type: payment_type,
                },
                async: true,
                cache: false,
                beforeSend: function () {
                $("#proceed").html('Please Wait...');
                $("#proceed").prop('disabled', true);
                },
                success: function (response) {
                    console.log(response); 
                var discount = $('.promo_code_discount').text() ? $('.promo_code_discount').text() : 0; 
               
                if($('input#wallet').is(':checked')) {
                var wallet_amount = $('#wallet').attr("data-amount"); 
                console.log(wallet_amount);
                var shipping_type = localStorage.getItem('shipping_type');
                console.log(shipping_type);
                }
                console.log(wallet_amount);
                $("#proceed").html('Proceed');
                        $("#proceed").prop('disabled', false);
                        if(response.delivery_charge_without_cod > 0){
                        if (payment_type == 'cod'){
                var totalpluscharge = parseFloat(response.sub_total) + parseFloat(response.delivery_charge_with_cod) - parseFloat(discount);
               
                        $('.standard_shipping').text('+ ' + response.currency + ' ' + parseFloat(response.delivery_charge_with_cod).toFixed(2));
                        $('.total_amount').text(response.currency + ' ' + parseFloat(totalpluscharge).toFixed(2));
                        $('.finaltotalamount_walletnotused').text(response.currency + ' ' + parseFloat(totalpluscharge).toFixed(2));
                        $('.finaltotalamount_walletused').text(response.currency + ' ' + (parseFloat(totalpluscharge)-parseFloat(wallet_amount)).toFixed(2));
                }
                else{
                var totalpluscharge = parseFloat(response.sub_total) + parseFloat(response.delivery_charge_without_cod)- parseFloat(discount);
                        $('.standard_shipping').text('+ ' + response.currency + ' ' + parseFloat(response.delivery_charge_without_cod).toFixed(2));
                        $('.total_amount').text(response.currency + ' ' + parseFloat(totalpluscharge).toFixed(2));
                        $('.finaltotalamount_walletnotused').text(response.currency + ' ' + parseFloat(totalpluscharge).toFixed(2));
                        $('.finaltotalamount_walletused').text(response.currency + ' ' + (parseFloat(totalpluscharge-wallet_amount)).toFixed(2));
                }
            }

                }
        });
   
    
   
});

$("#proceed").on("click", function () {
    let paybtn = document.getElementsByClassName("paybtn");
    let sslbuttons = document.getElementsByClassName("sslbuttons");
    let total_payble = $("input[name='total_payable']").val();
    let sslecommerz = $("input[name='payment_method']:checked").val();
    console.log(sslecommerz);
    if (sslecommerz == "sslecommerz") {
        if ($("#wallet").prop("checked") == true) {
            if (total_payble == 0) {
                $(paybtn).show();
                $(sslbuttons).hide();
            } else {
                $(paybtn).hide();
                $(sslbuttons).show();
            }
        } else {
            $(paybtn).hide();
            $(sslbuttons).show();
        }
    } else {
        $(paybtn).show();
        $(sslbuttons).hide();
    }

    let ddate = document.getElementsByClassName("deliverDay");
    var payment_type = $("input[name='payment_method']:checked").val();
        //console.log(payment_type);
        $.ajax({
        url: home + "get_shipdel_charge",
                type: "POST",
                dataType: "json",
                data: {
                payment_type: payment_type,
                },
                async: true,
                cache: false,
                beforeSend: function () {
                    $("#loader2").show();
                },
                success: function (response) {
                    $("#loader2").hide();
                    $("#orderConfirm").modal('show');
                    console.log(response); 
                var discount = $('.promo_code_discount').text() ? $('.promo_code_discount').text() : 0; 
               
                if($('input#wallet').is(':checked')) {
                var wallet_amount = $('#wallet').attr("data-amount"); 
                console.log(wallet_amount);
                var shipping_type = localStorage.getItem('shipping_type');
                console.log(shipping_type);
                }
                console.log(wallet_amount);
                $("#proceed").html('Proceed');
                        $("#proceed").prop('disabled', false);
                        if(response.delivery_charge_without_cod > 0){
                        if (payment_type == 'cod'){
                var totalpluscharge = parseFloat(response.sub_total) + parseFloat(response.delivery_charge_with_cod) - parseFloat(discount);
               
                        $('.standard_shipping').text('+ ' + response.currency + ' ' + parseFloat(response.delivery_charge_with_cod).toFixed(2));
                        $('.total_amount').text(response.currency + ' ' + parseFloat(totalpluscharge).toFixed(2));
                        $('.finaltotalamount_walletnotused').text(response.currency + ' ' + parseFloat(totalpluscharge).toFixed(2));
                        $('.finaltotalamount_walletused').text(response.currency + ' ' + (parseFloat(totalpluscharge)-parseFloat(wallet_amount)).toFixed(2));
                }
                else{
                var totalpluscharge = parseFloat(response.sub_total) + parseFloat(response.delivery_charge_without_cod)- parseFloat(discount);
                        $('.standard_shipping').text('+ ' + response.currency + ' ' + parseFloat(response.delivery_charge_without_cod).toFixed(2));
                        $('.total_amount').text(response.currency + ' ' + parseFloat(totalpluscharge).toFixed(2));
                        $('.finaltotalamount_walletnotused').text(response.currency + ' ' + parseFloat(totalpluscharge).toFixed(2));
                        $('.finaltotalamount_walletused').text(response.currency + ' ' + (parseFloat(totalpluscharge-wallet_amount)).toFixed(2));
                }
            }

                }
        });
});

$("#sslczPayBtn").on("click", function () {
    $("#orderConfirm").modal("hide");
});

$("body").on("click", ".button-plus-cart", function () {
    var button_id = $(this).attr("id");
        //console.log(button_id);

    var qP = $(this).parent().parent().find(".qtyPicker");
    var qPdata = qP.data();
        //console.log(qPdata.max);
    var nP = parseInt(qP.val()) + 1;
    var checkval = qPdata.maxAllowed > qPdata.max ? qPdata.max : qPdata.maxAllowed;
    if (checkval > nP - 1) {
        qP.val(nP);
        $(this).parent().parent().find(".button-minus").removeAttr("disabled");
    } else {
        $(this).attr("disabled", "disabled");
    }

    if (nP - 1 == parseInt(qPdata.max)) {
        alertify.set("notifier", "position", "top-center");
        alertify.warning(msg.Oops_Limited_stock_available);
    }
    if (nP - 1 == parseInt(qPdata.maxAllowed)) {
        alertify.set("notifier", "position", "top-center");
        alertify.warning(msg.Oops_You_reached_maximum_items_allowed_in_cart);
    }
});

//button variant active
$(document).on("click", ".variant .btn", function (e) {
    e.preventDefault();
    $("#varients button.active").removeClass("active");
    $(this).addClass("active");
});

//Bank Transfer Warning show at payment page
$("input[type=radio][name=payment_method]").change(function() {
    if (this.value == "bank_transfer") {
        $('.bank_transfer_warning').show();
    } else {
        $('.bank_transfer_warning').hide();
    }
});

//upload bank transfer attachment
$("#bank_receipt_form").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    if (confirm("Are you sure?")) {
        $.ajax({
            type: "POST",
            url: ipa_lru + 'order-process.php',
            data: formData,
            dataType: "json",
            headers: {
                Authorization: "Bearer " + nekot,
            },
            beforeSend: function() {
                $("#submit_btn").html("Please wait..");
            },
            contentType: false,
            processData: false,
            success: function(result) {
                console.log(result);
                console.log(result.data[0].attachment);
                if (!result["error"]) {
                    $("#submit_btn").html("Update");
                    swal("Success!", result["message"], "success");
                    var image_add = '';
                    $.each(result.data[0].attachment, function(i, e) {

                        image_add += '<span class="image_data" id="image_data' + e.id + '">' +
                            '<input type="hidden" name="order_id" value="' + result.data[0].id + '" class="order_id">' +
                            '<input type="hidden" name="accesskey" value="90336" class="accesskey">' +
                            '<input type="hidden" name="delete_bank_transfers_attachment" value="1" class="delete_bank_transfers_attachment">' +
                            '<input type="hidden" name="id" value="' + e.id + '" class="id">' +
                            '<a href="' + e.image + '" target="_blank" class="outer_receipt"><img src="' + e.image + '" class="receipt_img img-fluid"></a><i class="fa fa-times attach_image_delete"></i>' +
                            '</span>';
                    });
                    $('.r_attach').html(image_add);
                }
            },
        });
    }
});

//Delete bank transfer attachment
$(function() {
    $(document).on('click', '.attach_image_delete', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var accesskey = $(this).closest(".image_data").find(".accesskey").val();
        var delete_bank_transfers_attachment = $(this).closest(".image_data").find(".delete_bank_transfers_attachment").val();
        var order_id = $(this).closest(".image_data").find(".order_id").val();
        var id = $(this).closest(".image_data").find(".id").val();
        console.log(id);
        if (confirm("Are you sure?")) {
            $.ajax({
                method: "POST",
                url: ipa_lru + 'order-process.php',
                data: {
                    accesskey: accesskey,
                    delete_bank_transfers_attachment: delete_bank_transfers_attachment,
                    order_id: order_id,
                    id: id
                },
                headers: {
                    Authorization: "Bearer " + nekot,
                },
                success: function(result) {
                    console.log(result);
                    if (!result["error"]) {

                        swal("Success!", "Image deleted successfully!", "success");

                        $('#image_data' + id).fadeOut(200, function() {
                            $(this).remove();
                        });
                    }
                },
            });
        }
    });
});



