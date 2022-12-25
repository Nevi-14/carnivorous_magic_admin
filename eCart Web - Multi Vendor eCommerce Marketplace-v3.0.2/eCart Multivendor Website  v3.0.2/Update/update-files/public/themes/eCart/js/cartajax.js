$(document).ready(function () {
    $(".productmodal").click(function (a) {
        a.preventDefault();
        a.stopPropagation();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var slug = $(this).closest(".inner").find(".slug").val();
        console.log(slug);
        $.ajax({
            url: home + "productajax/" + slug,
            method: "GET",
            cache: false,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#loader2").show();
            },
            success: function (response) {
                $("#loader2").hide();
                $("#productvariant").modal("show");
                console.log(response);

                var html = "";
                html +=
                        '<div class="row">' +
                        '<div class="col-lg-6 col-md-12 col-12">' +
                        '<div class="product-details-tab">' +
                        '<div id="img-1" class="zoomWrapper single-zoom">' +
                        '<a href="#"><img id="zoom1" src="' +
                        response.product.image +
                        '" alt="" data-zoom-image="' +
                        response.product.image +
                        '"></a>' +
                        "</div>" +
                        ' <div class="single-zoom-thumb">' +
                        '<ul class="s-tab-zoom owl-carousel single-product-active thumb" id="gallery_01">';
                var count_other_image = response.product.other_images.length;
                html +=
                        "<li>" +
                        '<a class="elevatezoom-gallery active" data-update="" data-image="' +
                        response.product.image +
                        '" data-zoom-image="' +
                        response.product.image +
                        '"><img  src="' +
                        response.product.image +
                        '" alt=""></a>' +
                        "</li>";
                if (count_other_image > 0) {
                    for (var i = 0; i < count_other_image; i++) {
                        html +=
                                "<li>" +
                                '<a class="elevatezoom-gallery active" data-update="" data-image="' +
                                response.product.other_images[i] +
                                '" data-zoom-image="' +
                                response.product.other_images[i] +
                                '"><img  src="' +
                                response.product.other_images[i] +
                                '" alt=""></a>' +
                                "</li>";
                    }
                }
                html += "</ul>" + "</div>" + "</div>" + "</div>";
                var saving1 = parseFloat(response.product.variants[0].price) - parseFloat(response.product.variants[0].discounted_price);
                var saving1_percentage = parseInt(100 - parseInt((response.product.variants[0].discounted_price * 100) / response.product.variants[0].price));

                html +=
                        '<div class=" col-lg-6 col-md-12 col-12">' +
                        '<div class="product_details_right">' +
                        '<form action="#">' +
                        "<h1><a>" +
                        response.title +
                        "</a></h1>" +
                        '<div class="price_box">' +
                        '<span class="current_price" id="price_offer_' +
                        response.product.id +
                        '"> ' +
                        response.currency +
                        '<span class="value"></span></span>' +
                        '<span class="old_price" id="price_mrp_' +
                        response.product.id +
                        '"> ' +
                        response.currency +
                        '<span class="value single_p"></span></span>' +
                        '<span class="current_price" id="price_regular_' +
                        response.product.id +
                        '"> ' +
                        response.currency +
                        '<span class="value"></span></span>' +
                        '<small class="pro_savings" id="price_savings_' +
                        response.product.id +
                        '"> ' +
                        response.you_save +
                        ": " +
                        response.currency +
                        ' <span class="value"></span></small>' +
                        "</div>" +
                        '<div class="product_desc">' +
                        "<p>" +
                        response.product.description +
                        "</p>" +
                        "</div>" +
                        '<div class="form product_data productmodal_data">' +
                        '<input type="hidden" class="name" name="name" value="' +
                        response.title +
                        '" data-name="' +
                        response.title +
                        '">' +
                        '<input type="hidden" class="image" name="image" value="' +
                        response.product.image +
                        '" data-image="' +
                        response.product.image +
                        '">' +
                        '<input type="hidden" name="id" class="productmodal_id" value="' +
                        response.product.id +
                        '" data-id="' +
                        response.product.id +
                        '">' +
                        '<input type="hidden" name="type" value="add">' +
                        '<input type="hidden" name="child_id" class="productmodal_varient"  value="' +
                        response.product.variants[0].id +
                        '" id="child_' +
                        response.product.id +
                        '">' +
                        '<div class="product-variant1">' +
                        '<div class="product-variant__label">Available in:</div>' +
                        '<div class="btn-group-toggle variant" data-toggle="buttons">';
                var firstSelected = "active";
                var checked = "checked";
                $.each(response.product.variants, function (i, e) {
                    html += '<button class="btn product-variant__btn ' + firstSelected + '" data-id="' + response.product.id + '">' + e.measurement + " " + e.measurement_unit_name;
                    var tax_discounted_price = parseFloat(e.discounted_price) + parseFloat((e.discounted_price * response.product.tax_percentage) / 100);
                    var tax_mrp_price = parseFloat(e.price) + parseFloat((e.price * response.product.tax_percentage) / 100);
                    if (tax_discounted_price == 0) {
                        tax_discounted_price = tax_mrp_price;
                        tax_mrp_price = 0;
                    }
                    var saving = parseFloat(tax_mrp_price - tax_discounted_price);
                    var saving1_percentage = parseInt(100 - parseInt((tax_discounted_price * 100) / tax_mrp_price));
                    var max_cart_items_count = parseInt(response.settings.max_cart_items_count);
                    var cart_count = e.cart_count > 0 ? e.cart_count : 1;
                    html +=
                            '<input type="radio" hidden name="options"  class="productmodal_varient" id="option' +
                            e.id +
                            '" data-varient="' +
                            e.id +
                            '"  value="' +
                            e.id +
                            '" data-id="' +
                            e.id +
                            '" data-price="' +
                            parseFloat(tax_discounted_price).toFixed(2) +
                            '" data-tax="' +
                            response.product.tax_percentage +
                            '" data-mrp="' +
                            parseFloat(tax_mrp_price).toFixed(2) +
                            '" data-mrp_number="' +
                            tax_mrp_price.toString().replace("/,/g", "") +
                            '" data-savings="' +
                            parseFloat(saving).toFixed(2) +
                            " ( " +
                            saving1_percentage +
                            ' %Off)" data-stock="' +
                            e.stock +
                            '" data-max-allowed-stock = "' +
                            max_cart_items_count +
                            '"data-cart_count = "' +
                            cart_count +
                            '" data-main-image="' + response.product.image +
                            '" data-gallery-images = "' + e.images.join(',') +
                            '"data-qty = "1" autocomplete="off" ' +
                            checked +
                            ">" +
                            "</button>";
                    if (firstSelected == "active") {
                        firstSelected = "";
                    }
                    if (checked == "checked") {
                        checked = "";
                    }
                });

                html +=
                        "</div>" +
                        "</div><br/>" +
                        '<div class="product_variant quantity productmodal_data">' +
                        "<label>quantity</label>" +
                        '<button class="cart-qty-minus button-minus button-minus-single-page" type="button" id="button-minus" value="-">-</button>' +
                        '<input class="qtyPicker qtyPicker-single-page qty productmodal_qty" id="qtyPicker_' +
                        response.product.id +
                        '"  type="number" name="qty" data-min="1" min="1" data-max="' +
                        response.product.variants[0].stock +
                        '" max="' +
                        response.product.variants[0].stock +
                        '" data-max-allowed="1" value="1">' +
                        '<button class="cart-qty-plus button-plus button-plus-single-page" type="button" id="button-plus" value="+">+</button>' +
                        '<button class="btn btn-primary  outline-inward addtocart" name="submit" type="submit"><em class="fas fa-shopping-cart pr-2"></em>add to cart</button>' +
                        '<li class=" btn pro_fav ';
                if (response.product.is_favorite == true) {
                    html += "saved";
                } else {
                    html += "save";
                }

                html += '" data-id=' + response.product.id + "> </li>" + "</div>" + "</div>" + '<div class="product_meta">' + "</div>" + "</form>" + "</div>";
                html += "<div class='col-lg-12 col-md-12'>" + "<ul class='top_bar_left mb-3'>" + "<li class='price-marquee'>";
                if (response.is_pincode == true) {
                    html += "<p>" + "<button type='button' class='btn btn-primary'>" + "<i class='fas fa-map-marker-alt'>&nbsp;<span class='pincode_msg'>Deliverable to:  " + response.pincode_no + "</span></i>" + "</button>" + "</p>";
                } else {
                    html += "<p>" + "<button type='button' class='btn btn-primary'>" + "<i class='fas fa-map-marker-alt'>&nbsp;<span class='pincode_msg'>Select a location to see product availability</span></i>" + "</button>" + "</p>";
                }
                html += "</li>" + "</ul>";
                html += "</div><span class='delivery_charges'></span>";
                html +=
                        "<div class='row'><div class='col-lg-6 col-12'>" +
                        "<h6>Check Pincode</h6>" +
                        "<form  method='POST' class='pincode_form'>" +
                        '<input type="text" name="product_variant_id" class="form-control" value="' +
                        response.product.variants[0].id +
                        ' " hidden>' +
                        '<input type="text" name="slug" class="form-control" value="' +
                        response.product.slug +
                        ' " hidden>' +
                        '<div class="quick_deliver"><input type="text" name="pincode" class="form-control mr-10" id="pincode_no" placeholder="Enter a Pincode">' +
                        '<button class="btn btn-primary" type="submit" name="submit">Apply</button></div>' +
                        "</form>";

                html += "</div></div>";

                html += " </div>";

                $(".productmodaldetails").html(html);
                jQuery(function () {
                    jQuery(document).ready(function () {
                        setInterval(function () {
                            jQuery(".owl-carousel").owlCarousel({
                                items: 4,
                                loop: false,
                                margin: 10,
                                autoplay: true,
                                autoplayTimeout: 1000,
                                autoplayHoverPause: true,
                                nav: true,
                                navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
                            });
                            $("#zoom1").elevateZoom({
                                gallery: "gallery_01",
                                responsive: true,
                                cursor: "crosshair",
                                zoomWindowWidth: 200,
                                zoomWindowHeight: 300,
                                zoomType: "inner",
                            });
                        }, 150);
                    });
                });

                jQuery(function () {
                    jQuery(".variant .btn:first").click();
                });
            },
        });
    });
});

$(document).ready(function () {
    $(document).on("submit", ".pincode_form", function (e) {
        e.preventDefault();
        var fd = new FormData(this);
        var pincode_no = document.getElementById("pincode_no").value;
        var url = ipa_lru + "get-products.php";

        fd.append("accesskey", "90336");
        fd.append("check_deliverability", "1");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: url,
            data: fd,
            headers: {
                Authorization: "Bearer " + nekot,
            },
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (result) {
                console.log(result);
                if (result["error"] == true) {
                    $(".pincode_msg").html("Can not deliverable to " + pincode_no);
                    $(".delivery_charges").empty();
                }
                if (result["error"] == false) {

                    if (result["estimated_date"]) {
                        $(".pincode_msg").html("Deliverable to " + pincode_no + " on " + result["estimated_date"]);
                        $(".delivery_charges").html("Delivery Charges: <br/><b>COD Payment: " + result["currency"] + result["delivery_charge_with_cod"] + " | Online Payment: " + result["currency"] + result["delivery_charge_without_cod"] + "<br/>");
                    } else {
                        $(".pincode_msg").html("Deliverable to " + pincode_no);
                    }
                }
            },
        });
    });
});
////////////Add to cart Single product///////////////////////////////////////////////////////////////////
$(document).ready(function () {
    $(".addtocart_single").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var id = $(this).closest(".product_data").find(".id").val();
        var varient = $(this).closest(".product_data").find(".varient").val();
        var qty = $(this).closest(".product_data").find(".qty").val();
        var qty_allow_check = $(this).closest(".product_data").find(".qty").attr("data-max-allowed");
        var maxqty = $(this).closest(".product_data").find(".qty").attr("data-max");
        var name = $(this).closest(".product_data").find(".name").val();
        var image = $(this).closest(".product_data").find(".image").val();
        var price = $(this).closest(".product_data").find(".price").val();
        if (parseInt(qty) == parseInt(qty_allow_check)) {
            alertify.set("notifier", "position", "top-center");
            alertify.warning(msg.Oops_You_reached_maximum_items_allowed_in_cart);
        } else if (parseInt(qty) == parseInt(maxqty)) {
            alertify.set("notifier", "position", "top-center");
            alertify.warning(msg.Oops_Limited_stock_available);
        } else {
            $.ajax({
                url: home + "cart/single/addajax",
                method: "POST",
                cache: false,
                dataType: "json",

                data: {
                    id: id,
                    varient: varient,
                    qty: qty,
                    name: name,
                    image: image,
                    price: price,
                },
                success: function (response) {
                    $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
                    alertify.set("notifier", "position", "top-right");
                    alertify.success(response.status);
                    window.timeout = setTimeout(function(){
                        alertify.dismissAll();
                      },2000);

                    console.log(response);
                },
            });
        }
    });
});
////////////Add to cart varient product///////////////////////////////////////////////////////////////////
$(function () {
    $(document).on("click", ".addtocart", function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        var id = $(".productmodal_id").val();
        var varient = $(".productmodal_varient").val();
        var qty = $(this).closest(".product_data").find(".qty").val();
        var name = $(this).closest(".product_data").find(".name").val();
        var image = $(this).closest(".product_data").find(".image").val();
        var price = $(this).closest(".product_data").find(".price").val();

        $.ajax({
            url: home + "cart/single/addajax",
            method: "POST",
            data: {
                id: id,
                varient: varient,
                qty: qty,
                name: name,
                image: image,
                price: price,
            },
            success: function (response) {
                $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
                alertify.set("notifier", "position", "top-right");
                alertify.success(response.status);
                window.timeout = setTimeout(function(){
                    alertify.dismissAll();
                  },2000);
                console.log(response);
            },
        });
    });
});
////////////Add to cart varient product///////////////////////////////////////////////////////////////////
$(function () {
    $(document).on("click", ".addtocart", function (e) {
        setTimeout(function () {
            e.preventDefault();

            var data = {
                _token: $("input[name=_token]").val(),
            };
            $.ajax({
                url: home + "cartajax",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
                    var html = "";
                    html +=
                            '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            "<tbody>" +
                            "<tr>" +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            "</span>" +
                            '<span class="text-end innersubtotal">';
                    if (response.total > 0) {
                        html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.total).toFixed(2) + "</span>" + "</p>";
                    }
                    html += "</span>" + "</td>" + "</tr>";
                    var ready_to_checkout = "1";
                    $.each(response.items.data, function (i, e) {
                        if (e.qty > 0) {
                            var qty = e.qty;
                        } else {
                            var qty = response.cart_session[e.id].quantity;
                        }
                        html += '<tr class="cart1price">' + '<td class="text-end checktrash cart">';
                        if (e.item[0].is_item_deliverable == false && response.is_pincode == true) {
                            html += '<p class="deliver_notice">Not Deliverable for ' + response.pincode_no + " </p>";
                            ready_to_checkout = "0";
                        }
                        var varient = e.id;
                        html +=
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' +
                                e.item[0].image +
                                '" class="img-sm" alt="">' +
                                "</div>" +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="" class="title text-dark">' +
                                e.item[0].name +
                                "</a>" +
                                '<span class="small text-muted">' +
                                e.item[0].measurement +
                                " " +
                                e.item[0].unit +
                                "</span><br/>" +
                                '<span class="price-wrap cartShow">' +
                                qty +
                                "</span>" +
                                '<form action="' +
                                home +
                                "cart/update/" +
                                e.product_id +
                                '" method="POST" class="cartEdit cartEditmini" >' +
                                //'@csrf'+

                                '<input type="hidden" name="child_id" value="' +
                                e.product_variant_id +
                                '">' +
                                '<input type="hidden" name="product_id" value="' +
                                e.product_id +
                                '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' +
                                e.product_variant_id +
                                '" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                                e.item[0].stock +
                                '" max="' +
                                e.item[0].stock +
                                '" data-max-allowed="' +
                                response.max_cart_items_count +
                                '" value="' +
                                qty +
                                '" readonly>' +
                                '<button class="cart-qty-plus button-plus-cart" type="button" id="button-plus-' +
                                e.product_variant_id +
                                '" value="+">+</button>' +
                                "</div>" +
                                "</form>";
                        if (qty > 1) {
                            if (e.item[0].discounted_price > 0) {
                                if (e.item[0].tax_percentage > 0) {
                                    var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].discounted_price).toFixed(2) + " </small>";
                                }
                            } else {
                                if (e.item[0].tax_percentage > 0) {
                                    var tax_price = e.item[0].price + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100).toFixed(2);
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].price).toFixed(2) + " </small>";
                                }
                            }
                        }

                        html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
                        if (e.item[0].discounted_price > 0) {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.item[0].discounted_price * qty).toFixed(2);
                            }
                        } else {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].price) + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.item[0].price * qty).toFixed(2);
                            }
                        }

                        html +=
                                "</var>" +
                                "</div>" +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                                e.product_variant_id +
                                '" ><em class="fas fa-trash-alt"></em></button>' +
                                "</td>" +
                                "</tr>";
                    });

                    html += "</tbody>" + "<tfoot>" + "<tr>" + '<td colspan="" class="text-end checkoutbtn">';

                    if (response.total >= response.min_order_amount) {
                        if (response.is_pincode === true && response.is_local_shipping === '1') {
                            if (ready_to_checkout === "1") {
                                if (user_id) {
                                    html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                                } else {
                                    html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                                }
                            } else {
                                html += '<a class="btn btn-primary checkout-dbutton">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        } else if (response.is_local_shipping === '1') {

                            html += '<a class="btn btn-primary checkout-spincode-button">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                        } else {
                            if (user_id) {
                                html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        }
                    } else {
                        html += '<button class="btn btn-primary" disabled> ' + msg.checkout + '  <em class="fa fa-arrow-right"></em></button>';
                    }

                    html += '<a href="' + home + 'cart" class="btn btn-primary">' + response.viewcart + ' <em class="fa fa-arrow-right"></em></a>';
                    html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                    
                    html += "</td>" + "</tr>" + "</tfoot>" + "</table>" + "</div>";
                    $(".mini_cart").html(html);
                },
            });
        }, 2000);
    });
});

///////////////////// GET Count of cart/////////////////////////////////
$(document).ready(function () {
    $(".addtocart_single").click(function (e) {
        setTimeout(function () {
            e.preventDefault();
            e.stopPropagation();
            var data = {
                _token: $("input[name=_token]").val(),
            };
            $.ajax({
                url: home + "cartajax",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
                    var html = "";
                    html +=
                            '<div class="cart_gallery">' +
                            '<div class="cart_close"> </div>' +
                            '<table id="myTable" class="table">' +
                            "<tbody>" +
                            "<tr>" +
                            '<td class="mini_cart-subtotal">' +
                            '<span class="mini_cart_close">' +
                            '<a href="#"><em class="fas fa-times"></em></a>' +
                            "</span>" +
                            '<span class="text-end innersubtotal">';
                    if (response.total > 0) {
                        html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.total).toFixed(2) + "</span>" + "</p>";
                    }
                    html += "</span>" + "</td>" + "</tr>";
                    var ready_to_checkout = "1";
                    $.each(response.items.data, function (i, e) {
                        if (e.qty > 0) {
                            var qty = e.qty;
                        } else {
                            var qty = response.cart_session[e.id].quantity;
                        }
                        var qtyincrease = parseInt(qty) + 1;
                        $("#qty-" + e.product_variant_id)
                                .val(qtyincrease)
                                .change();
                        $("#qty-" + e.product_variant_id)
                                .attr("data-qty", qtyincrease)
                                .change();
                        html += '<tr class="cart1price">' + '<td class="text-end checktrash cart">';
                        if (e.item[0].is_item_deliverable === false && response.is_pincode === true) {
                            html += '<p class="deliver_notice">Not Deliverable for ' + response.pincode_no + " </p>";
                            ready_to_checkout = "0";
                        }

                        html +=
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' +
                                e.item[0].image +
                                '" class="img-sm" alt="">' +
                                "</div>" +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="" class="title text-dark">' +
                                e.item[0].name +
                                "</a>" +
                                '<span class="small text-muted">' +
                                e.item[0].measurement +
                                " " +
                                e.item[0].unit +
                                "</span><br/>" +
                                '<span class="price-wrap cartShow">' +
                                qty +
                                "</span>" +
                                '<form action="' +
                                home +
                                "cart/update/" +
                                e.product_id +
                                '" method="POST" class="cartEdit cartEditmini" >' +
                                //'@csrf'+

                                '<input type="hidden" name="child_id" value="' +
                                e.product_variant_id +
                                '">' +
                                '<input type="hidden" name="product_id" value="' +
                                e.product_id +
                                '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' +
                                e.product_variant_id +
                                '" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                                e.item[0].stock +
                                '" max="' +
                                e.item[0].stock +
                                '" data-max-allowed="' +
                                response.max_cart_items_count +
                                '" value="' +
                                qty +
                                '" readonly>' +
                                '<button class="cart-qty-plus button-plus-cart" type="button" id="button-plus-' +
                                e.product_variant_id +
                                '" value="+">+</button>' +
                                "</div>" +
                                "</form>";
                        if (qty > 1) {
                            if (e.item[0].discounted_price > 0) {
                                if (e.item[0].tax_percentage > 0) {
                                    var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].discounted_price).toFixed(2) + " </small>";
                                }
                            } else {
                                if (e.item[0].tax_percentage > 0) {
                                    var tax_price = e.item[0].price + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100).toFixed(2);
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].price).toFixed(2) + " </small>";
                                }
                            }
                        }

                        html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
                        if (e.item[0].discounted_price > 0) {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.item[0].discounted_price * qty).toFixed(2);
                            }
                        } else {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].price) + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.item[0].price * qty).toFixed(2);
                            }
                        }

                        html +=
                                "</var>" +
                                "</div>" +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                                e.product_variant_id +
                                '" ><em class="fas fa-trash-alt"></em></button>' +
                                "</td>" +
                                "</tr>";
                    });
                    html += "</tbody>" + "<tfoot>" + "<tr>" + '<td colspan="" class="text-end checkoutbtn">';
                    if (response.total >= response.min_order_amount) {
                        if (response.is_pincode === true && response.is_local_shipping === '1') {
                            if (ready_to_checkout === "1") {
                                if (user_id) {
                                    html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                                } else {
                                    html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                                }
                            } else {
                                html += '<a class="btn btn-primary checkout-dbutton">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        } else if (response.is_local_shipping === '1') {

                            html += '<a class="btn btn-primary checkout-spincode-button">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                        } else {
                            if (user_id) {
                                html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        }
                    } else {
                        html += '<button class="btn btn-primary" disabled> ' + msg.checkout + '  <em class="fa fa-arrow-right"></em></button>';
                    }
                    html += '<a href="' + home + 'cart" class="btn btn-primary">' + response.viewcart + ' <em class="fa fa-arrow-right"></em></a>';
                    html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                   
                    html += "</td>" + "</tr>" + "</tfoot>" + "</table>" + "</div>";
                    $(".mini_cart").html(html);
                },
            });
        }, 2000);
    });
});
// Delete Cart Data
$(function () {
    $(document).on("click", ".cartDelete", function (e) {
        e.preventDefault();
        var varient = $(this).data("varient");
        var data = {
            _token: $("input[name=_token]").val(),
            varient: varient,
        };
        $.ajax({
            url: home + "cart/remove/" + varient,
            type: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response);
                $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
                // console.log(response);
                alertify.set("notifier", "position", "top-right");
                alertify.success(response.status);
                var html = "";
                html +=
                        '<div class="cart_gallery">' +
                        '<div class="cart_close"> </div>' +
                        '<table id="myTable" class="table">' +
                        "<tbody>" +
                        "<tr>" +
                        '<td class="mini_cart-subtotal">' +
                        '<span class="mini_cart_close">' +
                        '<a href="#"><em class="fas fa-times"></em></a>' +
                        "</span>" +
                        '<span class="text-end innersubtotal">';
                if (response.total > 0) {
                    html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.total).toFixed(2) + "</span>" + "</p>";
                }
                html += "</span>" + "</td>" + "</tr>";
                var ready_to_checkout = "1";
                if (response.items) {
                    $.each(response.items.data, function (i, e) {
                        if (e.qty > 0) {
                            var qty = e.qty;
                        } else {
                            var qty = response.cart_session[e.id].quantity;
                        }
                        $("#qty-" + varient).val("1");
                        $("#qty-" + varient)
                                .attr("data-qty", "1")
                                .change();
                        var qtyincrease = parseInt(qty) + 1;
                        $("#qty-" + e.product_variant_id).val(qtyincrease);
                        $("#qty-" + e.product_variant_id)
                                .attr("data-qty", qtyincrease)
                                .change();
                        html += '<tr class="cart1price">' + '<td class="text-end checktrash cart">';
                        if (e.item[0].is_item_deliverable == false && response.is_pincode == true) {
                            html += '<p class="deliver_notice">Not Deliverable for ' + response.pincode_no + " </p>";
                            ready_to_checkout = "0";
                        }
                        html +=
                                '<figure class="itemside">' +
                                '<div class="aside">' +
                                '<img src="' +
                                e.item[0].image +
                                '" class="img-sm" alt="">' +
                                "</div>" +
                                '<figcaption class="info minicartinfo">' +
                                '<a href="" class="title text-dark">' +
                                e.item[0].name +
                                "</a>" +
                                '<span class="small text-muted">' +
                                e.item[0].measurement +
                                " " +
                                e.item[0].unit +
                                "</span><br/>" +
                                '<span class="price-wrap cartShow">' +
                                qty +
                                "</span>" +
                                '<form action="' +
                                home +
                                "cart/update/" +
                                e.product_id +
                                '" method="POST" class="cartEdit cartEditmini" >' +
                                //'@csrf'+

                                '<input type="hidden" name="child_id" value="' +
                                e.product_variant_id +
                                '">' +
                                '<input type="hidden" name="product_id" value="' +
                                e.product_id +
                                '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' +
                                e.product_variant_id +
                                '" value="-">-</button>' +
                                '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                                e.item[0].stock +
                                '" max="' +
                                e.item[0].stock +
                                '" data-max-allowed="' +
                                response.max_cart_items_count +
                                '" value="' +
                                qty +
                                '" readonly>' +
                                '<button class="cart-qty-plus button-plus-cart" type="button" id="button-plus-' +
                                e.product_variant_id +
                                '" value="+">+</button>' +
                                "</div>" +
                                "</form>";
                        if (qty > 1) {
                            if (e.item[0].discounted_price > 0) {
                                if (e.item[0].tax_percentage > 0) {
                                    var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].discounted_price).toFixed(2) + " </small>";
                                }
                            } else {
                                if (e.item[0].tax_percentage > 0) {
                                    var tax_price = e.item[0].price + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100).toFixed(2);
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                                } else {
                                    html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].price).toFixed(2) + " </small>";
                                }
                            }
                        }

                        html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
                        if (e.item[0].discounted_price > 0) {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.item[0].discounted_price * qty).toFixed(2);
                            }
                        } else {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].price) + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100);
                                html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                            } else {
                                html += response.currency + parseFloat(e.item[0].price * qty).toFixed(2);
                            }
                        }

                        html +=
                                "</var>" +
                                "</div>" +
                                '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                                '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                                e.product_variant_id +
                                '" ><em class="fas fa-trash-alt"></em></button>' +
                                "</td>" +
                                "</tr>";
                    });
                    html += "</tbody>" + "<tfoot>" + "<tr>" + '<td colspan="" class="text-end checkoutbtn">';
                    if (response.total >= response.min_order_amount) {
                        if (response.is_pincode === true && response.is_local_shipping === '1') {
                            if (ready_to_checkout === "1") {
                                if (user_id) {
                                    html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                                } else {
                                    html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                                }
                            } else {
                                html += '<a class="btn btn-primary checkout-dbutton">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        } else if (response.is_local_shipping === '1') {

                            html += '<a class="btn btn-primary checkout-spincode-button">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                        } else {
                            if (user_id) {
                                html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        }
                    } else {
                        html += '<button class="btn btn-primary" disabled> ' + msg.checkout + '  <em class="fa fa-arrow-right"></em></button>';
                    }
                    html += '<a href="' + home + 'cart" class="btn btn-primary">' + response.viewcart + ' <em class="fa fa-arrow-right"></em></a>';
                    html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                    
                }
                html += "</td>" + "</tr>" + "</tfoot>" + "</table>" + "</div>";
                $(".mini_cart").html(html);
            },
        });
    });
});
// Delete ALL DATA Cart Data
$(function () {
    $(document).on("click", ".cartDeleteallmini", function (e) {
        e.preventDefault();
        var varient = "all";
        var data = {
            _token: $("input[name=_token]").val(),
            varient: varient,
        };
        $.ajax({
            url: home + "cart/remove/" + varient,
            type: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response);
                $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
                //console.log(response);
                alertify.set("notifier", "position", "top-right");
                alertify.success(response.status);
                var html = "";
                html +=
                        '<div class="cart_gallery">' +
                        '<div class="cart_close"> </div>' +
                        '<table id="myTable" class="table">' +
                        "<tbody>" +
                        "<tr>" +
                        '<td class="mini_cart-subtotal">' +
                        '<span class="mini_cart_close">' +
                        '<a href="#"><em class="fas fa-times"></em></a>' +
                        "</span>" +
                        '<span class="text-end innersubtotal">';
                if (response.total > 0) {
                    html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.total).toFixed(2) + "</span>" + "</p>";
                }
                html += "</span>" + "</td>" + "</tr>";
                var ready_to_checkout = "1";
                $.each(response.items.data, function (i, e) {
                    if (e.qty > 0) {
                        var qty = e.qty;
                    } else {
                        var qty = response.cart_session[e.id].quantity;
                    }
                    var qtyincrease = parseInt(qty) + 1;
                    $("#qty-" + e.product_variant_id).val(qtyincrease);
                    $("#qty-" + e.product_variant_id)
                            .attr("data-qty", qtyincrease)
                            .change();
                    html += '<tr class="cart1price">' + '<td class="text-end checktrash cart">';
                    if (e.item[0].is_item_deliverable === false && response.is_pincode === true) {
                        html += '<p class="deliver_notice">Not Deliverable for ' + response.pincode_no + " </p>";
                        ready_to_checkout = "0";
                    }
                    html +=
                            '<figure class="itemside">' +
                            '<div class="aside">' +
                            '<img src="' +
                            e.item[0].image +
                            '" class="img-sm" alt="">' +
                            "</div>" +
                            '<figcaption class="info minicartinfo">' +
                            '<a href="" class="title text-dark">' +
                            e.item[0].name +
                            "</a>" +
                            '<span class="small text-muted">' +
                            e.item[0].measurement +
                            " " +
                            e.item[0].unit +
                            "</span><br/>" +
                            '<span class="price-wrap cartShow">' +
                            qty +
                            "</span>" +
                            '<form action="' +
                            home +
                            "cart/update/" +
                            e.product_id +
                            '" method="POST" class="cartEdit cartEditmini" >' +
                            //'@csrf'+

                            '<input type="hidden" name="child_id" value="' +
                            e.product_variant_id +
                            '">' +
                            '<input type="hidden" name="product_id" value="' +
                            e.product_id +
                            '">' +
                            '<div class="button-container col pr-0 my-1">' +
                            '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' +
                            e.product_variant_id +
                            '" value="-">-</button>' +
                            '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                            e.item[0].stock +
                            '" max="' +
                            e.item[0].stock +
                            '" data-max-allowed="' +
                            response.max_cart_items_count +
                            '" value="' +
                            qty +
                            '" readonly>' +
                            '<button class="cart-qty-plus button-plus-cart" type="button" id="button-plus-' +
                            e.product_variant_id +
                            '" value="+">+</button>' +
                            "</div>" +
                            "</form>";
                    if (qty > 1) {
                        if (e.item[0].discounted_price > 0) {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                            } else {
                                html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].discounted_price).toFixed(2) + " </small>";
                            }
                        } else {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = e.item[0].price + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100).toFixed(2);
                                html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                            } else {
                                html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].price).toFixed(2) + " </small>";
                            }
                        }
                    }

                    html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
                    if (e.item[0].discounted_price > 0) {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                            html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += response.currency + parseFloat(e.item[0].discounted_price * qty).toFixed(2);
                        }
                    } else {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].price) + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100);
                            html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += response.currency + parseFloat(e.item[0].price * qty).toFixed(2);
                        }
                    }

                    html +=
                            "</var>" +
                            "</div>" +
                            '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                            '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                            '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                            '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                            e.product_variant_id +
                            '" ><em class="fas fa-trash-alt"></em></button>' +
                            "</td>" +
                            "</tr>";
                });
                html += "</tbody>" + "<tfoot>" + "<tr>" + '<td colspan="" class="text-end checkoutbtn">';
                if (response.total >= response.min_order_amount) {
                    if (response.is_pincode === true && response.is_local_shipping === '1') {
                        if (ready_to_checkout === "1") {
                            if (user_id) {
                                html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        } else {
                            html += '<a class="btn btn-primary checkout-dbutton">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                        }
                    } else if (response.is_local_shipping === '1') {

                        html += '<a class="btn btn-primary checkout-spincode-button">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                    } else {
                        if (user_id) {
                                html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                    }
                } else {
                    html += '<button class="btn btn-primary" disabled> ' + msg.checkout + '  <em class="fa fa-arrow-right"></em></button>';
                }
                html += '<a href="' + home + 'cart" class="btn btn-primary">' + response.viewcart + ' <em class="fa fa-arrow-right"></em></a>';
                html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                
                html += "</td>" + "</tr>" + "</tfoot>" + "</table>" + "</div>";
                $(".mini_cart").html(html);
            },
        });
    });
});
//edit cart quantity
$(function () {
    $(document).on("submit", ".cartEditmini", function (e) {
        var URL = $(this).attr("action");
        console.log(URL);
        $.ajax({
            async: true,
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).closest("form").serialize(),
            dataType: "json",
            success: function (response) {
                console.log(response);
                $(".cart_count").html($('<span class="item_count" id="item_count">' + response.totalcart + "</span>"));
                var html = "";
                html +=
                        '<div class="cart_gallery">' +
                        '<div class="cart_close"> </div>' +
                        '<table id="myTable" class="table">' +
                        "<tbody>" +
                        "<tr>" +
                        '<td class="mini_cart-subtotal">' +
                        '<span class="mini_cart_close">' +
                        '<a href="#"><em class="fas fa-times"></em></a>' +
                        "</span>" +
                        '<span class="text-end innersubtotal">';
                if (response.total > 0) {
                    html += '<p class="product-name">' + response.total_msg + " : " + "<span>" + response.currency + parseFloat(response.total).toFixed(2) + "</span>" + "</p>";
                }
                html += "</span>" + "</td>" + "</tr>";
                var ready_to_checkout = "1";
                $.each(response.items.data, function (i, e) {
                    if (e.qty > 0) {
                        var qty = e.qty;
                    } else {
                        var qty = response.cart_session[e.id].quantity;
                    }
                    var qtyincrease = parseInt(qty) + 1;
                    $("#qty-" + e.product_variant_id).val(qtyincrease);
                    $("#qty-" + e.product_variant_id)
                            .attr("data-qty", qtyincrease)
                            .change();
                    html += '<tr class="cart1price">' + '<td class="text-end checktrash cart">';
                    if (e.item[0].is_item_deliverable === false && response.is_pincode === true) {
                        html += '<p class="deliver_notice">Not Deliverable for ' + response.pincode_no + " </p>";
                        ready_to_checkout = "0";
                    }
                    html +=
                            '<figure class="itemside">' +
                            '<div class="aside">' +
                            '<img src="' +
                            e.item[0].image +
                            '" class="img-sm" alt="">' +
                            "</div>" +
                            '<figcaption class="info minicartinfo">' +
                            '<a href="" class="title text-dark">' +
                            e.item[0].name +
                            "</a>" +
                            '<span class="small text-muted">' +
                            e.item[0].measurement +
                            " " +
                            e.item[0].unit +
                            "</span><br/>" +
                            '<span class="price-wrap cartShow">' +
                            qty +
                            "</span>" +
                            '<form action="' +
                            home +
                            "cart/update/" +
                            e.product_id +
                            '" method="POST" class="cartEdit cartEditmini" >' +
                            //'@csrf'+

                            '<input type="hidden" name="child_id" value="' +
                            e.product_variant_id +
                            '">' +
                            '<input type="hidden" name="product_id" value="' +
                            e.product_id +
                            '">' +
                            '<div class="button-container col pr-0 my-1">' +
                            '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' +
                            e.product_variant_id +
                            '" value="-">-</button>' +
                            '<input class="form-control qtyPicker productmodal_qty"  type="number" name="qty" data-min="1" min="1" data-max="' +
                            e.item[0].stock +
                            '" max="' +
                            e.item[0].stock +
                            '" data-max-allowed="' +
                            response.max_cart_items_count +
                            '" value="' +
                            qty +
                            '" readonly>' +
                            '<button class="cart-qty-plus button-plus-cart" type="button" id="button-plus-' +
                            e.product_variant_id +
                            '" value="+">+</button>' +
                            "</div>" +
                            "</form>";
                    if (qty > 1) {
                        if (e.item[0].discounted_price > 0) {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                            } else {
                                html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].discounted_price).toFixed(2) + " </small>";
                            }
                        } else {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = e.item[0].price + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100).toFixed(2);
                                html += 'x<small class="text-muted">' + response.currency + parseFloat(tax_price).toFixed(2) + " </small>";
                            } else {
                                html += 'x<small class="text-muted">' + response.currency + parseFloat(e.item[0].price).toFixed(2) + " </small>";
                            }
                        }
                    }

                    html += "</figcaption>" + "</figure>" + '<div class="price-wrap">' + '<var class="price">';
                    if (e.item[0].discounted_price > 0) {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                            html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += response.currency + parseFloat(e.item[0].discounted_price * qty).toFixed(2);
                        }
                    } else {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].price) + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100);
                            html += response.currency + parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += response.currency + parseFloat(e.item[0].price * qty).toFixed(2);
                        }
                    }

                    html +=
                            "</var>" +
                            "</div>" +
                            '<button class="btn btn-light btn-round btnEdit cartShow"><em class="fa fa-pencil-alt"></em></button>' +
                            '<button class="btn btn-light btn-round cartSave cartEdit"><em class="fas fa-check"></em></button>' +
                            '<button class="btn btn-light btn-round btnEdit cartEdit"><em class="fa fa-times"></em></button>' +
                            '<button type="submit" class="btn btn-light btn-round btnDelete cartDelete" data-varient="' +
                            e.product_variant_id +
                            '" ><em class="fas fa-trash-alt"></em></button>' +
                            "</td>" +
                            "</tr>";
                });
                html += "</tbody>" + "<tfoot>" + "<tr>" + '<td colspan="" class="text-end checkoutbtn">';
                if (response.total >= response.min_order_amount) {
                    if (response.is_pincode === true && response.is_local_shipping === '1') {
                        if (ready_to_checkout === "1") {
                            if (user_id) {
                                html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        } else {
                            html += '<a class="btn btn-primary checkout-dbutton">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                        }
                    } else if (response.is_local_shipping === '1') {

                        html += '<a class="btn btn-primary checkout-spincode-button">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                    } else {
                        if (user_id) {
                                html += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                html += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                    }
                } else {
                    html += '<button class="btn btn-primary" disabled> ' + msg.checkout + '  <em class="fa fa-arrow-right"></em></button>';
                }
                html += '<a href="' + home + 'cart" class="btn btn-primary">' + response.viewcart + ' <em class="fa fa-arrow-right"></em></a>';
                html += "</td>" + '<td colspan="" class="text-end mini_cart-subtotal ">';
                
                html += "</td>" + "</tr>" + "</tfoot>" + "</table>" + "</div>";
                $(".mini_cart").html(html);
            },
        });
        e.preventDefault();
    });
});


