//check user login or not
if (document.getElementById("user_id")) {
    var user_id = document.getElementById("user_id");
}
// Delete Cart Data
$(function () {
    $(document).on('click', '.cartDeletepage', function (e) {
        e.preventDefault();
        var varient = $(this).data('varient');
        console.log(varient);
        var data = {
            '_token': $('input[name=_token]').val(),
            'varient': varient
        };
        $.ajax({
            url: "/cart/remove/" + varient,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                console.log(response);
                var html = '';
                var ready_to_checkout = "1";
                if (response.items.total > 0) {

                    var html = '';
                    $.each(response.items.data, function (i, e) {
                        if (e.qty > 0) {
                            var qty = e.qty;
                        } else {
                            var qty = response.cart_session[e.id].quantity;
                        }
                        html += '<tr>';
                        if (e.item[0].is_item_deliverable == false && response.is_pincode == true) {
                            html += '<p class="deliver_notice">Not Deliverable for ' + response.pincode_no + " </p>";
                            ready_to_checkout = "0";
                        }
                        html += '<td class="header_product_thumb"><span class="cart__page">' + msg.Image + '</span><a href="#"><img src="' + e.item[0].image + '" alt=""></a></td>' +
                                '<td class="header_product_name"><span class="cart__page pt-3">' + msg.product + '</span><a href="#">' + e.item[0].name + '</a><p class="small text-muted text-center">' + e.item[0].measurement + ' ' + e.item[0].unit;
                        if (e.item[0].discounted_price > 0) {
                            var priqt = '(' + e.item[0].discounted_price + ' X ' + qty + ')';
                            html += priqt;
                        } else {
                            var priqt = '(' + e.item[0].price + 'X' + qty + ')';
                            html += priqt;
                        }
                        html += '<br>' + msg.tax + '(' + e.item[0].tax_percentage + '% ' + e.item[0].tax_title + ')</p></td>' +
                                '<td class="header_product-price""><span class="cart__page">' + msg.price + '</span>';
                        if (e.item[0].discounted_price > 0) {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                html += tax_price;
                            } else {
                                html += e.item[0].discounted_price;
                            }
                        } else {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = e.item[0].price + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100).toFixed(2);
                                html += tax_price;
                            } else {
                                html += e.item[0].price;
                            }
                        }

                        html += '</td>' +
                                '<td class="cart sep_cart"><span class="cart__page">' + msg.qty + '</span><div class="price-wrap cartShow product_data">' + qty + '</div>' +
                                '<form action="cart/update/' + e.item[0].product_id + '" method="POST" class="cartEdit cartEditpage">' +
                                '<input type="hidden" class="id" name="id" value="' + e.item[0].product_id + '" data-id="{{ $p - > id }}">' +
                                '<input type="hidden" class="varient" data-varient="' + e.product_variant_id + '" name="varient" value="' + e.product_variant_id + '" checked>' +
                                '<input type="hidden" name = "child_id" value = "' + e.product_variant_id + '" >' +
                                '<input type="hidden" name="product_id" value="' + e.item[0].product_id + '">' +
                                '<div class="button-container col pr-0 my-1">' +
                                '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' +
                                e.product_variant_id +
                                '" value="-">-</button>' +
                                '<input class="form-control qtyPicker"  type="number" name="qty" data-min="1" min="1" data-max="' +
                                e.item[0].stock +
                                '" max="' +
                                e.item[0].stock +
                                '" data-max-allowed="' +
                                response.max_cart_items_count +
                                '" value="' +
                                qty +
                                '" readonly>' +
                                '<button class="cart-qty-plus button-plus" type="button" id="button-plus-' +
                                e.product_variant_id +
                                '" value="+">+</button>' +
                                "</div>" +
                                '</form></td>' +
                                '<td class="header_product-price"><span class="cart__page">' + msg.price + '</span>';
                        if (e.item[0].discounted_price > 0) {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                                html += parseFloat(tax_price * qty);
                            } else {
                                html += parseFloat(e.item[0].discounted_price * qty);
                            }
                        } else {
                            if (e.item[0].tax_percentage > 0) {
                                var tax_price = parseFloat(e.item[0].price) + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100);
                                html += parseFloat(tax_price * qty);
                            } else {
                                html += parseFloat(e.item[0].price * qty);
                            }
                        }
                        html += '</td>' +
                                '<td class="text-right checktrash">' +
                                '<button class="btn btn-light btn-round btnEdit cartShow"> <em class="fa fa-pencil-alt"></em></button>' +
                                '<button class="btn btn-light btn-round cartSave cartEdit cartEditpage"> <em class="fas fa-check"></em></button>' +
                                '<button class="btn btn-light btn-round btnEdit cartEdit"> <em class="fa fa-times"></em></button>' +
                                '<button class="btn btn-light btn-round cartDeletepage" data-varient="' + e.product_variant_id + '"><em class="fas fa-trash-alt"></em></button></td></tr>';

                    });
                    html += '<tr><td colspan="3" class="py-3 text-start"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + msg.continue_shopping + '</a></span></strong></td><td class="text-end" colspan="2"><p class="product-name deleviry__option">' + msg.subtotal + ' : <span>' + response.currency + ' ' + response.total + '</span></p></td>' +
                            '<td colspan="" class="text-end checkoutbtn">';
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

                    html += '</td></tr>';
                    $("#movecart").html(html);
                    $("#price_section").empty();
                } else {
                    html += '<tr>' +
                            '<td colspan="6" class="text-center">' +
                            '<img src="' + response.empty_card_img + '" alt="No Items In Cart">' +
                            '<br><br>' +
                            '<a href="' + home + '/shop" class="btn btn-primary"><em class="fa fa-chevron-left  mr-1"></em>' + response.continue_shopping + ' </a>' +
                            '</td>' +
                            '</tr> ';
                }
                $("#movecart").html(html);
                $("#price_section").empty();
                html += '</tbody>' +
                        '<tfoot id="price_section">';
                if (response.subtotal > 0) {
                    html += '<tr>' +
                            '<td colspan="2">';
                    if (response.local_pickup && response.local_pickup === '1') {
                        html += '<a class="deleviry__option">' +
                                '<input type="radio" name="pickup" value="door_step_delivery" checked>' + msg.door_step_delivery +
                                '<input type="radio" name="pickup" value="pickup_from_store" class="ms-3">' + msg.pickup_from_store +
                                '</a>';
                    }
                    html += '</td>' +
                            '<td class="text-right" colspan="2">' +
                            '<p class="product-name">' + response.subtotal_msg + '  : <span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span></p>';
                    html += '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td class="continue-shopping"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + response.continue_shopping + '</a></span></strong></td>' +
                            '<td></td>' +
                            '<td colspan="2" class="text-end">' +
                            '<a href="" class="btn btn-primary cartDeleteallpage mx-1">' + response.delete_all_msg + '  <em class="fa fa-trash"></em></a>';
                    if (user_id === '') {
                        html += '<a class="btn btn-primary login-popup">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                    } else {
                        if (response.subtotal >= response.min_order_amount) {
                            html += '<a id="door_step_delivery" href="' + home + 'checkout/address" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>  <a id="pickup_from_store" href="' + home + 'checkout" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                        } else {
                            html += '<button class="btn btn-primary" disabled>' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></button>';
                        }
                    }
                    html += '</td></tr>';
                }
                html += '</tfoot></table></div></div></main></div>';
                $('.cartpageajax').html(html);
            }
        });
    });
});
// Delete ALL DATA Cart Data
$(function () {
    $(document).on('click', '.cartDeleteallpage', function (e) {

        e.preventDefault();
        var varient = 'all';
        var data = {
            '_token': $('input[name=_token]').val(),
            'varient': varient,
        };
        $.ajax({
            url: "/cart/remove/" + varient,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.subtotal > 0) {
                    var html = '';
                    if (response.subtotal > 0) {

                    } else {
                        html += '<tr>' +
                                '<td colspan="4" class="text-center">' +
                                '<img src="' + response.empty_card_img + '" alt="No Items In Cart">' +
                                '<br><br>' +
                                '<a href="/shop" class="btn btn-primary"><em class="fa fa-chevron-left  mr-1"></em>' + response.continue_shopping + ' </a>' +
                                ' </td>' +
                                '</tr> ';
                    }
                    html += '</tbody>' +
                            '<tfoot id="price_section">';
                    if (response.subtotal > 0) {
                        html += '<tr>' +
                                '<td colspan="2">';
                        if (response.local_pickup && response.local_pickup === '1') {
                            html += '<a class="deleviry__option">' +
                                    '<input type="radio" name="pickup" value="door_step_delivery" checked>' + msg.door_step_delivery +
                                    '<input type="radio" name="pickup" value="pickup_from_store" class="ms-3">' + msg.pickup_from_store +
                                    '</a>';
                        }
                        html += '</td>' +
                                '<td class="text-right" colspan="2">' +
                                '<p class="product-name">' + response.subtotal_msg + '  : <span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span></p>';
                        html += '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="continue-shopping"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + response.continue_shopping + '</a></span></strong></td>' +
                                '<td></td>' +
                                '<td colspan="2" class="text-end">' +
                                '<a href="" class="btn btn-primary cartDeleteallpage mx-1">' + response.delete_all_msg + '  <em class="fa fa-trash"></em></a>';
                        if (user_id == '') {
                            html += '<a class="btn btn-primary login-popup">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                        } else {
                            if (response.subtotal >= response.min_order_amount) {
                                html += '<a id="door_step_delivery" href="' + home + 'checkout/address" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>  <a id="pickup_from_store" href="' + home + 'checkout" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                html += '<button class="btn btn-primary" disabled>' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></button>';
                            }
                        }
                        html += '</td></tr>';
                    }
                    html += '</tfoot></table></div></div></main></div>';
                    $('.cartpageajax').html(html);
                } else {
                    var html = "";
                    html +=
                            '<span class="mini_cart_close"><a href="#"><em class="fas fa-times"></em></a></span><div class="text-center"><img src="' +
                            response.empty_card_img +
                            '" alt="No Items In Cart"><br><br><a href="' + home + 'shop" class="btn btn-primary text-white mx-1"><em class="fa fa-chevron-left  mr-1"></em>' +
                            response.continue_shopping +
                            '</a><a href="/cart" class="btn btn-primary text-white"><em class="fab fa-opencart  mr-1"></em> View Cart</a></div>';
                    $(".cartpageajax").html(html);
                }
            }
        });
    });
});
//edit cart quantity
$(document).on("submit", ".cartEditpage", function (e) {
    $.ajax({
        async: true,
        type: "POST",
        url: $(this).attr('action'),
        data: $(this).closest('form').serialize(),
        dataType: 'json',
        success: function (response) {
            console.log(response);

            var html = '';
            var ready_to_checkout = "1";
            if (response.items.total > 0) {

                var html = '';
                $.each(response.items.data, function (i, e) {
                    if (e.qty > 0) {
                        var qty = e.qty;
                    } else {
                        var qty = response.cart_session[e.id].quantity;
                    }
                    html += '<tr>';
                    if (e.item[0].is_item_deliverable == false && response.is_pincode == true) {
                        html += '<p class="deliver_notice">Not Deliverable for ' + response.pincode_no + " </p>";
                        ready_to_checkout = "0";
                    }
                    html += '<td class="header_product_thumb"><span class="cart__page">' + msg.Image + '</span><a href="#"><img src="' + e.item[0].image + '" alt=""></a></td>' +
                            '<td class="header_product_name"><span class="cart__page pt-3">' + msg.product + '</span><a href="#">' + e.item[0].name + '</a><p class="small text-muted text-center">' + e.item[0].measurement + ' ' + e.item[0].unit;
                    if (e.item[0].discounted_price > 0) {
                        var priqt = '(' + e.item[0].discounted_price + ' X ' + qty + ')';
                        html += priqt;
                    } else {
                        var priqt = '(' + e.item[0].price + 'X' + qty + ')';
                        html += priqt;
                    }
                    html += '<br>' + msg.tax + '(' + e.item[0].tax_percentage + '% ' + e.item[0].tax_title + ')</p></td>' +
                            '<td class="header_product-price""><span class="cart__page">' + msg.price + '</span>';
                    if (e.item[0].discounted_price > 0) {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                            html += tax_price;
                        } else {
                            html += e.item[0].discounted_price;
                        }
                    } else {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = e.item[0].price + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100).toFixed(2);
                            html += tax_price;
                        } else {
                            html += e.item[0].price;
                        }
                    }

                    html += '</td>' +
                            '<td class="cart sep_cart"><span class="cart__page">' + msg.qty + '</span><div class="price-wrap cartShow product_data">' + qty + '</div>' +
                            '<form action="cart/update/' + e.item[0].product_id + '" method="POST" class="cartEdit cartEditpage">' +
                            '<input type="hidden" class="id" name="id" value="' + e.item[0].product_id + '" data-id="{{ $p - > id }}">' +
                            '<input type="hidden" class="varient" data-varient="' + e.product_variant_id + '" name="varient" value="' + e.product_variant_id + '" checked>' +
                            '<input type="hidden" name = "child_id" value = "' + e.product_variant_id + '" >' +
                            '<input type="hidden" name="product_id" value="' + e.item[0].product_id + '">' +
                            '<div class="button-container col pr-0 my-1">' +
                            '<button class="cart-qty-minus button-minus" type="button" id="button-minus-' +
                            e.product_variant_id +
                            '" value="-">-</button>' +
                            '<input class="form-control qtyPicker"  type="number" name="qty" data-min="1" min="1" data-max="' +
                            e.item[0].stock +
                            '" max="' +
                            e.item[0].stock +
                            '" data-max-allowed="' +
                            response.max_cart_items_count +
                            '" value="' +
                            qty +
                            '" readonly>' +
                            '<button class="cart-qty-plus button-plus" type="button" id="button-plus-' +
                            e.product_variant_id +
                            '" value="+">+</button>' +
                            "</div>" +
                            '</form></td>' +
                            '<td class="header_product-price"><span class="cart__page">' + msg.price + '</span>';
                    if (e.item[0].discounted_price > 0) {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                            html += parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += parseFloat(e.item[0].discounted_price * qty).toFixed(2);
                        }
                    } else {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].price) + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100);
                            html += parseFloat(tax_price * qty).toFixed(2);
                        } else {
                            html += parseFloat(e.item[0].price * qty).toFixed(2);
                        }
                    }
                    html += '</td>' +
                            '<td class="text-right checktrash">' +
                            '<button class="btn btn-light btn-round btnEdit cartShow"> <em class="fa fa-pencil-alt"></em></button>' +
                            '<button class="btn btn-light btn-round cartSave cartEdit cartEditpage"> <em class="fas fa-check"></em></button>' +
                            '<button class="btn btn-light btn-round btnEdit cartEdit"> <em class="fa fa-times"></em></button>' +
                            '<button class="btn btn-light btn-round cartDeletepage" data-varient="' + e.product_variant_id + '"><em class="fas fa-trash-alt"></em></button></td></tr>';

                });
                html += '<tr><td colspan="3" class="py-3 text-start"><strong><span><a href="' + home + 'shop class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + msg.continue_shopping + '</a></span></strong></td><td class="text-end" colspan="2"><p class="product-name deleviry__option">' + msg.subtotal + ' : <span>' + response.currency + ' ' + response.total + '</span></p></td>' +
                        '<td colspan="" class="text-end checkoutbtn">';
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

                html += '</td></tr>';
                $("#movecart").html(html);
                $("#price_section").empty();
            } else {
                html += '<tr>' +
                        '<td colspan="4" class="text-center">' +
                        '<img src="' + response.empty_card_img + '" alt="No Items In Cart">' +
                        '<br><br>' +
                        '<a href="/shop" class="btn btn-primary"><em class="fa fa-chevron-left  mr-1"></em>' + response.continue_shopping + ' </a>' +
                        ' </td>' +
                        '</tr> ';
            }
            html += '</tbody>' +
                    '<tfoot id="price_section">';
            if (response.subtotal > 0) {
                html += '<tr>' +
                        '<td colspan="2">';
                if (response.local_pickup && response.local_pickup === '1') {
                    html += '<a class="deleviry__option">' +
                            '<input type="radio" name="pickup" value="door_step_delivery" checked>' + msg.door_step_delivery +
                            '<input type="radio" name="pickup" value="pickup_from_store" class="ms-3">' + msg.pickup_from_store +
                            '</a>';
                }
                html += '</td>' +
                        '<td class="text-right" colspan="2">' +
                        '<p class="product-name">' + response.subtotal_msg + '  : <span>' + response.currency + parseFloat(response.subtotal).toFixed(2) + '</span></p>';
                html += '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td class="continue-shopping"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + response.continue_shopping + '</a></span></strong></td>' +
                        '<td></td>' +
                        '<td colspan="2" class="text-end">' +
                        '<a href="" class="btn btn-primary cartDeleteallpage mx-1">' + response.delete_all_msg + '  <em class="fa fa-trash"></em></a>';
                if (user_id == '') {
                    html += '<a class="btn btn-primary login-popup">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                } else {
                    if (response.subtotal >= response.min_order_amount) {
                        html += '<a id="door_step_delivery" href="' + home + 'checkout/address" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>  <a id="pickup_from_store" href="' + home + 'checkout" class="btn btn-primary">' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></a>';
                    } else {
                        html += '<button class="btn btn-primary" disabled>' + response.checkout_msg + ' <em class="fa fa-arrow-right"></em></button>';
                    }
                }
                html += '</td></tr>';
            }
            html += '</tfoot></table></div></div></main></div>';
            $('.cartpageajax').html(html);
        }
    });
    e.preventDefault();
});
// Save For Later ADD
$(function () {
    $(document).on('click', '.save_for_later', function (e) {
        var el = this;
        e.preventDefault();
        var pid = $(this).data('pid');
        var varient = $(this).data('varient');
        var qty = $(this).data('qty');
        $.ajax({
            url: home + "save-for-later/" + pid + "/" + varient + "/" + qty,
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                $(el).closest('tr').css('background', 'tomato');
                $(el).closest('tr').fadeOut(800, function () {
                    $(this).remove();
                });

                var savelater = '<tr>' +
                        '<td class="header_product_thumb"><span class="cart__page">' + msg.Image + '</span><a href="#"><img src="' + response.product.data[0].item[0].image + '" alt=""></a></td>' +
                        '<td class="header_product_name"><span class="cart__page pt-3">' + msg.product + '</span><a href="#">' + response.product.data[0].item[0].name + '</a><p class="small text-muted text-center">' + response.product.data[0].item[0].measurement + ' ' + response.product.data[0].item[0].unit;
                if (response.product.data[0].item[0].discounted_price > 0) {
                    var priqt = '(' + response.product.data[0].item[0].discounted_price + ' X ' + response.product.data[0].qty + ')';
                    savelater += priqt;
                } else {
                    var priqt = '(' + response.product.data[0].item[0].price + 'X' + response.product.data[0].qty + ')';
                    savelater += priqt;
                }
                savelater += '<br>' + msg.tax + '(' + response.product.data[0].item[0].tax_percentage + '% ' + response.product.data[0].item[0].tax_title + ')</p></td>' +
                        '<td class="header_product-price""><span class="cart__page">' + msg.price + '</span>';
                if (response.product.data[0].item[0].discounted_price > 0) {
                    if (response.product.data[0].item[0].tax_percentage > 0) {
                        var tax_price = parseFloat(response.product.data[0].item[0].discounted_price) + parseFloat((response.product.data[0].item[0].discounted_price * response.product.data[0].item[0].tax_percentage) / 100);
                        savelater += tax_price;
                    } else {
                        savelater += response.product.data[0].item[0].discounted_price;
                    }
                } else {
                    if (response.product.data[0].item[0].tax_percentage > 0) {
                        var tax_price = response.product.data[0].item[0].price + parseFloat((response.product.data[0].item[0].price * response.product.data[0].item[0].tax_percentage) / 100).toFixed(2);
                        savelater += tax_price;
                    } else {
                        savelater += response.product.data[0].item[0].price;
                    }
                }

                savelater += '</td>' +
                        '<td class="cart sep_cart"><span class="cart__page">' + msg.qty + '</span><div class="price-wrap cartShow product_data">' + response.product.data[0].qty + '</div>' +
                        '<form action="cart/update/' + response.product.data[0].item[0].product_id + '" method="POST" class="cartEdit">' +
                        '<input type="hidden" class="id" name="id" value="' + response.product.data[0].item[0].product_id + '" data-id="{{ $p - > id }}">' +
                        '<input type="hidden" class="qtyPicker qtyPicker-single-page qty" name="qty" type="number" id="qty-' + response.product.data[0].product_variant_id + '" name="qty" data-min="1" min="1" readonly data-qty="' + response.product.data[0].qty + '">' +
                        '<input type="hidden" class="varient" data-varient="' + response.product.data[0].product_variant_id + '" name="varient" value="' + response.product.data[0].product_variant_id + '" checked>' +
                        '<input type="hidden" name = "child_id" value = "' + response.product.data[0].product_variant_id + '" >' +
                        '<input type="hidden" name="product_id" value="' + response.product.data[0].item[0].product_id + '"></form></td>' +
                        '<td class="header_product-price"><span class="cart__page">' + msg.price + '</span>';
                if (response.product.data[0].item[0].discounted_price > 0) {
                    if (response.product.data[0].item[0].tax_percentage > 0) {
                        var tax_price = parseFloat(response.product.data[0].item[0].discounted_price) + parseFloat((response.product.data[0].item[0].discounted_price * response.product.data[0].item[0].tax_percentage) / 100);
                        savelater += parseFloat(tax_price * response.product.data[0].qty);
                    } else {
                        savelater += parseFloat(response.product.data[0].item[0].discounted_price * response.product.data[0].qty);
                    }
                } else {
                    if (response.product.data[0].item[0].tax_percentage > 0) {
                        var tax_price = parseFloat(response.product.data[0].item[0].price) + parseFloat((response.product.data[0].item[0].price * response.product.data[0].item[0].tax_percentage) / 100);
                        savelater += parseFloat(tax_price * response.product.data[0].qty);
                    } else {
                        savelater += parseFloat(response.product.data[0].item[0].price * response.product.data[0].qty);
                    }
                }
                savelater += '</td><td class="text-end checktrash"><p class="move_to_cart" data-pid="' + response.product.data[0].item[0].product_id + '" data-varient="' + response.product.data[0].item[0].product_variant_id + '" data-qty="' + response.product.data[0].qty + '"> Move to Cart </p></td></tr>';
                '</tr>';

                $("#savelater").append(savelater);
                var ready_to_checkout = "1";
                var movecart = "";
                $.each(response.items.data, function (i, e) {
                    if (e.item[0].is_item_deliverable == false && response.is_pincode == true) {
                        movecart += '<p class="deliver_notice">Not Deliverable for ' + response.pincode_no + " </p>";
                        ready_to_checkout = "0";
                    }
                    movecart += '<tr>' +
                            '<td class="header_product_thumb"><span class="cart__page">' + msg.Image + '</span><a href="#"><img src="' + e.item[0].image + '" alt=""></a></td>' +
                            '<td class="header_product_name"><span class="cart__page pt-3">' + msg.product + '</span><a href="#">' + e.item[0].name + '</a><p class="small text-muted text-center">' + e.item[0].measurement + ' ' + e.item[0].unit;
                    if (e.item[0].discounted_price > 0) {
                        var priqt = '(' + e.item[0].discounted_price + ' X ' + e.qty + ')';
                        movecart += priqt;
                    } else {
                        var priqt = '(' + e.item[0].price + 'X' + e.qty + ')';
                        movecart += priqt;
                    }
                    movecart += '<br>' + msg.tax + '(' + e.item[0].tax_percentage + '% ' + e.item[0].tax_title + ')</p></td>' +
                            '<td class="header_product-price""><span class="cart__page">' + msg.price + '</span>';
                    if (e.item[0].discounted_price > 0) {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                            movecart += tax_price;
                        } else {
                            movecart += e.item[0].discounted_price;
                        }
                    } else {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = e.item[0].price + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100).toFixed(2);
                            movecart += tax_price;
                        } else {
                            movecart += e.item[0].price;
                        }
                    }

                    movecart += '</td>' +
                            '<td class="cart sep_cart"><span class="cart__page">' + msg.qty + '</span><div class="price-wrap cartShow product_data">' + e.qty + '</div>' +
                            '<form action="' + home + 'cart/update/' + e.item[0].product_id + '" method="POST" class="cartEdit">' +
                            '<input type="hidden" class="id" name="id" value="' + e.item[0].product_id + '" data-id="{{ $p - > id }}">' +
                            '<input type="hidden" class="qtyPicker qtyPicker-single-page qty" name="qty" type="number" id="qty-' + e.product_variant_id + '" name="qty" data-min="1" min="1" readonly data-qty="' + e.qty + '">' +
                            '<input type="hidden" class="varient" data-varient="' + e.product_variant_id + '" name="varient" value="' + e.product_variant_id + '" checked>' +
                            '<input type="hidden" name = "child_id" value = "' + e.product_variant_id + '" >' +
                            '<input type="hidden" name="product_id" value="' + e.item[0].product_id + '">' +
                            '<div class="button-container col">' +
                            '<button class="cart-qty-minus button-minus" type="button" id="button-minus" value="-">-</button>' +
                            '<input class="form-control qtyPicker productmodal_qty" type="number" name="qty" data-min="1" min="1" max="' + e.item[0].stock + '" data-max="' + e.item[0].stock + '" data-max-allowed="' + response.max_cart_items_count + '" value="' + e.qty + '" readonly>' +
                            '<button class="cart-qty-plus button-plus" type="button" id="button-plus" value="+">+</button>' +
                            '</div></form></td><td class="header_product-price"><span class="cart__page">' + msg.price + '</span>';
                    if (e.item[0].discounted_price > 0) {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                            movecart += parseFloat(tax_price * e.qty);
                        } else {
                            movecart += parseFloat(e.item[0].discounted_price * e.qty);
                        }
                    } else {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].price) + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100);
                            movecart += parseFloat(tax_price * e.qty);
                        } else {
                            movecart += parseFloat(e.item[0].price * e.qty);
                        }
                    }
                    movecart += '</td>' +
                            '<td class="text-right checktrash">' +
                            '<button class="btn btn-light btn-round btnEdit cartShow"> <em class="fa fa-pencil-alt"></em></button>' +
                            '<button class="btn btn-light btn-round cartSave cartEdit cartEditpage"> <em class="fas fa-check"></em></button>' +
                            '<button class="btn btn-light btn-round btnEdit cartEdit"> <em class="fa fa-times"></em></button>' +
                            '<button class="btn btn-light btn-round cartDeletepage" data-varient="' + e.item[0].product_variant_id + '"><em class="fas fa-trash-alt"></em></button>';

                    movecart += '<br/>  <p class="save_for_later" data-varient="' + e.item[0].product_variant_id + '"> Save for Later </p>';

                    movecart += '</td></tr>';

                });
                movecart += '<tr><td colspan="3" class="py-3 text-start"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + msg.continue_shopping + '</a></span></strong></td><td class="text-end" colspan="2"><p class="product-name deleviry__option">' + msg.subtotal + ' : <span>' + response.currency + ' ' + response.total + '</span></p></td>' +
                        '<td colspan="" class="text-end checkoutbtn">';
                if (response.total >= response.min_order_amount) {
                    if (response.is_pincode === true && response.is_local_shipping === '1') {
                        if (ready_to_checkout === "1") {
                            if (user_id) {
                                movecart += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                movecart += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        } else {
                            movecart += '<a class="btn btn-primary checkout-dbutton">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                        }
                    } else if (response.is_local_shipping === '1') {

                        movecart += '<a class="btn btn-primary checkout-spincode-button">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                    } else {
                        movecart += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                    }
                } else {
                    movecart += '<button class="btn btn-primary" disabled> ' + msg.checkout + '  <em class="fa fa-arrow-right"></em></button>';
                }

                movecart += '</td></tr>';
                $("#movecart").html(movecart);
                $("#price_section").empty();
            }
        });
    });
});
// Move to Cart ADD
$(function () {
    $(document).on('click', '.move_to_cart', function (e) {
        var el = this;
        e.preventDefault();
        var pid = $(this).data('pid');
        var varient = $(this).data('varient');
        var qty = $(this).data('qty');
        $.ajax({
            url: home + "move-to-cart/" + pid + "/" + varient + "/" + qty,
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                $(el).closest('tr').css('background', 'tomato');
                $(el).closest('tr').fadeOut(800, function () {
                    $(this).remove();
                });
                var movecart = '';
                $.each(response.cart.cart.data, function (i, e) {
                    movecart += '<tr>' +
                            '<td class="header_product_thumb"><span class="cart__page">' + msg.Image + '</span><a href="#"><img src="' + e.item[0].image + '" alt=""></a></td>' +
                            '<td class="header_product_name"><span class="cart__page pt-3">' + msg.product + '</span><a href="#">' + e.item[0].name + '</a><p class="small text-muted text-center">' + e.item[0].measurement + ' ' + e.item[0].unit;
                    if (e.item[0].discounted_price > 0) {
                        var priqt = '(' + e.item[0].discounted_price + ' X ' + e.qty + ')';
                        movecart += priqt;
                    } else {
                        var priqt = '(' + e.item[0].price + 'X' + e.qty + ')';
                        movecart += priqt;
                    }
                    movecart += '<br>' + msg.tax + '(' + e.item[0].tax_percentage + '% ' + e.item[0].tax_title + ')</p></td>' +
                            '<td class="header_product-price""><span class="cart__page">' + msg.price + '</span>';
                    if (e.item[0].discounted_price > 0) {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                            movecart += tax_price;
                        } else {
                            movecart += e.item[0].discounted_price;
                        }
                    } else {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = e.item[0].price + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100).toFixed(2);
                            movecart += tax_price;
                        } else {
                            movecart += e.item[0].price;
                        }
                    }

                    movecart += '</td>' +
                            '<td class="cart sep_cart"><span class="cart__page">' + msg.qty + '</span><div class="price-wrap cartShow product_data">' + e.qty + '</div>' +
                            '<form action="cart/update/' + e.item[0].product_id + '" method="POST" class="cartEdit">' +
                            '<input type="hidden" class="id" name="id" value="' + e.item[0].product_id + '" data-id="{{ $p - > id }}">' +
                            '<input type="hidden" class="qtyPicker qtyPicker-single-page qty" name="qty" type="number" id="qty-' + e.product_variant_id + '" name="qty" data-min="1" min="1" readonly data-qty="' + e.qty + '">' +
                            '<input type="hidden" class="varient" data-varient="' + e.product_variant_id + '" name="varient" value="' + e.product_variant_id + '" checked>' +
                            '<input type="hidden" name = "child_id" value = "' + e.product_variant_id + '" >' +
                            '<input type="hidden" name="product_id" value="' + e.item[0].product_id + '"></form></td>' +
                            '<td class="header_product-price"><span class="cart__page">' + msg.price + '</span>';
                    if (e.item[0].discounted_price > 0) {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].discounted_price) + parseFloat((e.item[0].discounted_price * e.item[0].tax_percentage) / 100);
                            movecart += parseFloat(tax_price * e.qty);
                        } else {
                            movecart += parseFloat(e.item[0].discounted_price * e.qty);
                        }
                    } else {
                        if (e.item[0].tax_percentage > 0) {
                            var tax_price = parseFloat(e.item[0].price) + parseFloat((e.item[0].price * e.item[0].tax_percentage) / 100);
                            movecart += parseFloat(tax_price * e.qty);
                        } else {
                            movecart += parseFloat(e.item[0].price * e.qty);
                        }
                    }
                    movecart += '</td>' +
                            '<td class="text-end checktrash"><p class="move_to_cart" data-pid="' + e.item[0].product_id + '" data-varient="' + e.item[0].product_variant_id + '" data-qty="' + e.qty + '"> Move to Cart </p></td></tr>';

                });
                movecart += '<tr><td colspan="3" class="py-3 text-start"><strong><span><a href="' + home + 'shop" class="btn btn-primary"><em class="fa fa-chevron-left mr-1"></em>' + msg.continue_shopping + '</a></span></strong></td><td class="text-end" colspan="2"><p class="product-name deleviry__option">' + msg.subtotal + ' : <span>' + response.currency + ' ' + response.total + '</span></p></td>' +
                        '<td colspan="" class="text-end checkoutbtn">';
                if (response.total >= response.min_order_amount) {
                    if (response.is_pincode === true && response.is_local_shipping === '1') {
                        if (ready_to_checkout === "1") {
                            if (user_id) {
                                movecart += '<a href="' + home + 'checkout/address" class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            } else {
                                movecart += '<a class="btn btn-primary login-popup">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                            }
                        } else {
                            movecart += '<a class="btn btn-primary checkout-dbutton">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                        }
                    } else if (response.is_local_shipping === '1') {

                        movecart += '<a class="btn btn-primary checkout-spincode-button">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                    } else {
                        movecart += '<a class="btn btn-primary">' + msg.checkout + ' <em class="fa fa-arrow-right"></em></a>';
                    }
                } else {
                    movecart += '<button class="btn btn-primary" disabled> ' + msg.checkout + '  <em class="fa fa-arrow-right"></em></button>';
                }

                movecart += '</td></tr>';
                $("#movecart").html(movecart);

                $("#price_section").empty();
            }
        });
    });
});
