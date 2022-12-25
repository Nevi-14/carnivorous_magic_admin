document.addEventListener("DOMContentLoaded", function () {
    ("use strict");

    //**************Scroll-To-Top Button **************//

    $(window).on("scroll", function () {
        $(this).scrollTop() >= 100 ? $("#return-to-top").fadeIn(200) : $("#return-to-top").fadeOut(200);
    });
    $("#return-to-top").on("click", function () {
        $("body,html").animate(
            {
                scrollTop: 0,
            },
            500
        );
    });

     //switcher color
     $(document).ready(function () {
        $('#toggle-switcher').click(function () {
            if ($(this).hasClass('open')) {
                $(this).removeClass('open');
                $('#switch-style').animate({ 'left': '-200px' });
            } else {
                $(this).addClass('open');
                $('#switch-style').animate({ 'left': '0' });
            }
        });
    });

    // custom spectrum color
    $("#theme-color-master").spectrum({
        type: "component",
        showPalette: "false",
        showInput: "true",
        allowEmpty: "false",
        move: function (color) {
            let primClrA = color.toHexString();
            $(":root").css("--buttons", primClrA);
        },
    });

    // preloader
    setTimeout(function () {
        $(".loader").fadeOut("slow", function () {});
    }, 1000);

    /*--- niceSelect---*/
    $(".select_option").niceSelect();

    /*---niceSelect---*/
    $(".niceselect_option").niceSelect();

    /*---categories slideToggle---*/
    $(".title_content").on("click", function () {
        $(this).toggleClass("active");
        $(".categories_content_toggle").slideToggle("medium");
    });

    /*---stickey menu---*/
    $(window).on("scroll", function () {
        let scroll = $(window).scrollTop();
        if (scroll < 100) {
            $(".sticky-header").removeClass("sticky");
        } else {
            $(".sticky-header").addClass("sticky");
        }
    });

       //************Dark-mode****************//

       $("#switch-mode").on("click", function () {
        $("body").toggleClass("dark-mode");
        if ($("body").hasClass("dark-mode")) {
            $(this).find(".dark-mode").addClass("d-none");
            $(this).find(".light-mode").removeClass("d-none");
        } else {
            $(this).find(".dark-mode").removeClass("d-none");
            $(this).find(".light-mode").addClass("d-none");
        }
    });


    /*----------  Category more toggle  ----------*/

    $(".categories_content_toggle li.hidden").hide();
    $("#more-btn").on("click", function (e) {
        e.preventDefault();
        $(".categories_content_toggle li.hidden").toggle(500);
        let htmlBefore = '<i class="fa fa-minus" aria-hidden="true"></i> Less Categories';
        let htmlAfter = '<i class="fa fa-plus" aria-hidden="true"></i> More Categories';

        if ($(this).html() == htmlBefore) {
            $(this).html(htmlAfter);
        } else {
            $(this).html(htmlBefore);
        }
    });

    /*---search box slideToggle---*/
    $(".search-box > a").on("click", function () {
        $(this).toggleClass("active");
        $(".search_widget").slideToggle("medium");
    });

    /*---header account slideToggle---*/
    $(".header_account > a").on("click", function () {
        $(this).toggleClass("active");
        $(".dropdown_account").slideToggle("medium");
    });

    /*---slide toggle activation---*/

    /*---Category menu---*/
    function SubMenuToggle() {
        $(".categories_content_toggle li.menu_item_content > a").on("click", function () {
            if ($(window).width() < 991) {
                $(this).removeAttr("href");
                let element = $(this).parent("li");
                if (element.hasClass("open")) {
                    element.removeClass("open");
                    element.find("li").removeClass("open");
                    element.find("ul").slideUp();
                } else {
                    element.addClass("open");
                    element.children("ul").slideDown();
                    element.siblings("li").children("ul").slideUp();
                    element.siblings("li").removeClass("open");
                    element.siblings("li").find("li").removeClass("open");
                    element.siblings("li").find("ul").slideUp();
                }
            }
        });
        $(".categories_content_toggle li.menu_item_content > a").append('<span class="expand"></span>');
    }
    SubMenuToggle();

    /*---mini cart activation---*/
    $(".mini_cart_wrapper > a").on("click", function () {
        $(".mini_cart,.off_canvars_overlay").addClass("active");
    });

    $(".mini_cart_close,.off_canvars_overlay").on("click", function () {
        $(".mini_cart,.off_canvars_overlay").removeClass("active");
    });

    /*---canvas menu activation---*/
    $(".mobile_canvas_open,.off_canvars_overlay").on("click", function () {
        $(".mobile_wrapper,.off_canvars_overlay").addClass("active");
    });

    $(".mobile_canvas_close,.off_canvars_overlay").on("click", function () {
        $(".mobile_wrapper,.off_canvars_overlay").removeClass("active");
    });

    /*---Off Canvas mobile Menu---*/
    let $mobilecontent = $(".offcanvas_main_menu"),
        $mobileSubMenu = $mobilecontent.find(".sub-menu");
    $mobileSubMenu.parent().prepend('<span class="menu-expand"><i class="fa fa-angle-down"></i></span>');

    $mobileSubMenu.slideUp();

    $mobilecontent.on("click", "li a, li .menu-expand", function (e) {
        let $this = $(this);
        if (
            $this
                .parent()
                .attr("class")
                .match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/) &&
            ($this.attr("href") === "#" || $this.hasClass("menu-expand"))
        ) {
            e.preventDefault();
            if ($this.siblings("ul:visible").length) {
                $this.siblings("ul").slideUp("slow");
            } else {
                $this.closest("li").siblings("li").find("ul:visible").slideUp("slow");
                $this.siblings("ul").slideDown("slow");
            }
        }
        if ($this.is("a") || $this.is("span") || $this.attr("clas").match(/\b(menu-expand)\b/)) {
            $this.parent().toggleClass("menu-open");
        } else if ($this.is("li") && $this.attr("class").match(/\b('menu-item-has-children')\b/)) {
            $this.toggleClass("menu-open");
        }
    });

    /* Slider active */
    $(".slider-activation").owlCarousel({
        loop: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 5000,
        navText: ['<i class="fas fa-angle-up"></i>', '<i class="fas fa-angle-down"></i>'],
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        dotsData: true,
        item: 1,
        rtl: true,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });

    /*---deals activation---*/
    let $deals_carousel = $(".deals_carousel");
    if ($deals_carousel.length > 0) {
        $deals_carousel
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 1,
                rtl: true,
                dots: false,
                margin: 20,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 1,
                    },
                },
            });
    }
    /*---product trending sec---*/
    let $product_right_Carousel = $(".product_right_Carousel");
    if ($product_right_Carousel.length > 0) {
        $product_right_Carousel
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 15,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 4,
                    },
                    1400: {
                        items:5,
                    },
                    1600: {
                        items: 6,
                    },
                },
            });
    }

    // popular categories
    let $popularcategory = $(".popular-cat");
    if ($popularcategory.length > 0) {
        $popularcategory
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 15,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 3,
                    },
                    1600: {
                        items: 4,
                    },
                },
            });
    }

    /*---subcategories sec---*/
    let $subcategoriescarousel = $(".subcategory-carousel");
    if ($subcategoriescarousel.length > 0) {
        $subcategoriescarousel
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 15,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    992: {
                        items: 4,
                    },
                    1200: {
                        items: 4,
                    },
                    1600: {
                        items: 6,
                    },
                },
            });
    }

    /*--- featured-product activation---*/
    let $featuredproduct = $(".featured-product");
    if ($featuredproduct.length > 0) {
        $featuredproduct
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 20,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 3,
                    },
                    1600: {
                        items: 4,
                    },
                },
            });
    }

    /*---single product activation---*/
    $(".single-product-active").owlCarousel({
        autoplay: false,
        loop: false,
        nav: true,
        autoplayTimeout: 8000,
        items: 4,
        rtl: true,
        margin: 15,
        dots: false,
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            320: {
                items: 4,
            },
            992: {
                items: 4,
            },
            1200: {
                items: 4,
            },
        },
    });

    /*---quick_view activation---*/
    $(".quick_view_carousel").owlCarousel({
        autoplay: false,
        loop: false,
        nav: true,
        autoplayTimeout: 8000,
        items: 4,
        rtl: true,
        margin: 15,
        dots: false,
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            320: {
                items: 4,
            },
            992: {
                items: 4,
            },
            1200: {
                items: 4,
            },
        },
    });

    /*---product-detail featured-sec---*/
    let $profeatureddetail = $(".pro-featured-detail");
    if ($profeatureddetail.length > 0) {
        $(".pro-featured-detail")
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 1,
                rtl: true,
                stagePadding: 1,
                dots: false,
                margin: 20,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    768: {
                        items: 1,
                    },
                    992: {
                        items: 1,
                    },
                },
            });
    }

    /*--- similar-product sec---*/
    let $similarprocarousel = $(".similar-pro-carousel");
    if ($similarprocarousel.length > 0) {
        $similarprocarousel
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 15,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    992: {
                        items: 4,
                    },
                    1200: {
                        items: 5,
                    },
                },
            });
    }

    /*--- team carousel sec---*/
    let $teamcarousel = $(".team-carousel");
    if ($teamcarousel.length > 0) {
        $teamcarousel
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 10,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    992: {
                        items: 4,
                    },
                    1200: {
                        items: 5,
                    },
                },
            });
    }

    /*--- testimonial sec---*/
    let $testimonial = $(".testimonial-active");
    if ($testimonial.length > 0) {
        $testimonial
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 10,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 2,
                    },
                    1200: {
                        items: 2,
                    },
                    1600: {
                        items: 3,
                    },
                },
            });
    }

    /*--- brand partners sec---*/
    let $brandpartners = $(".brand-logo-active-2");
    if ($brandpartners.length > 0) {
        $brandpartners
            .on("changed.owl.carousel initialized.owl.carousel", function (event) {
                $(event.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(event.item.index + event.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: false,
                autoplay: true,
                autoplayTimeout: 3000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 10,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 3,
                    },
                    768: {
                        items: 4,
                    },
                    992: {
                        items: 4,
                    },
                    1200: {
                        items: 6,
                    },
                },
            });
    }

    /*--- quickview sec---*/
    let $productNavactive = $(".product_navactive");
    if ($productNavactive.length > 0) {
        $(".product_navactive").owlCarousel({
            loop: false,
            nav: true,
            autoplay: false,
            autoplayTimeout: 8000,
            items: 4,
            rtl: true,
            dots: false,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                250: {
                    items: 2,
                },
                480: {
                    items: 3,
                },
                768: {
                    items: 4,
                },
            },
        });
    }

    $(".modal").on("shown.bs.modal", function (e) {
        $(".product_navactive").resize();
    });

    $(".product_navactive a").on("click", function (e) {
        e.preventDefault();

        let $href = $(this).attr("href");

        $(".product_navactive a").removeClass("active");
        $(this).addClass("active");

        $(".product-details-large .tab-pane").removeClass("active show");
        $(".product-details-large " + $href).addClass("active show");
    });
    /*---elevateZoom---*/

    $("#zoom1").elevateZoom({
        gallery: "gallery_01",
        responsive: true,
        cursor: "crosshair",
        zoomWindowWidth: 200,
        zoomWindowHeight: 300,
        zoomType: "inner",
    });
    $(window).resize(function (e) {
        $(".zoomContainer").remove();
        $("#zoom1").elevateZoom({
            gallery: "gallery_01",
            responsive: true,
            zoomWindowWidth: 200,
            zoomWindowHeight: 300,
            zoomType: "inner",
        });
    });

    /*---shop grid activation---*/
    $(".shop_toolbar_btn > button").on("click", function (e) {
        e.preventDefault();

        $(".shop_toolbar_btn > button").removeClass("active");
        $(this).addClass("active");

        let parentsDiv = $(".right_shop_content");
        let viewMode = $(this).data("role");

        parentsDiv.removeClass("grid-view list-view").addClass(viewMode);

        if (viewMode == "grid-view") {
            parentsDiv.children().addClass("col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6").removeClass("col-lg-4 col-cust-5 col-12");
        }

        if (viewMode == "list-view") {
            parentsDiv.children().addClass("col-12").removeClass("col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-cust-5");
        }
    });

     /*---sub cat grid activation---*/
     $(".shop_toolbar_btn.sub_Cat > button").on("click", function (e) {
        e.preventDefault();

        $(".shop_toolbar_btn > button").removeClass("active");
        $(this).addClass("active");

        let parentsDiv = $(".right_shop_content");
        let viewMode = $(this).data("role");

        parentsDiv.removeClass("grid-view list-view").addClass(viewMode);

        if (viewMode == "grid-view") {
            parentsDiv.children().addClass("col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6").removeClass("col-lg-4 col-cust-5 col-12");
        }

        if (viewMode == "list-view") {
            parentsDiv.children().addClass("col-12").removeClass("col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-cust-5");
        }
    });
    /*---slider-range here---*/

    //************** shop left toggle **************//

    $(".categories_title").on("click", function () {
        $(this).toggleClass("active");
        $(".header_categories_toggle").slideToggle("medium");
    });

    $(".sub_categories1 > a").on("click", function () {
        $(this).toggleClass("active");
        $(".dropdown_categories1").slideToggle("medium");
    });

    $(".sub_categories2 > a").on("click", function () {
        $(this).toggleClass("active");
        $(".dropdown_categories2").slideToggle("medium");
    });

    $(".sub_categories3 > a").on("click", function () {
        $(this).toggleClass("active");
        $(".dropdown_categories3").slideToggle("medium");
    });

    // faq
    $(".faq-content .collapse").on("show.bs.collapse", function () {
        let id = $(this).attr("id");
        $('a[href="#' + id + '"]')
            .closest(".panel-heading")
            .addClass("active-accordion");
        $('a[href="#' + id + '"] .panel-title span').html('<i class="fas fa-minus"></i>');
    });

    $(".faq-content .collapse").on("hide.bs.collapse", function () {
        let id = $(this).attr("id");
        $('a[href="#' + id + '"]')
            .closest(".panel-heading")
            .removeClass("active-accordion");
        $('a[href="#' + id + '"] .panel-title span').html('<i class="fas fa-plus"></i>');
    });

    // seller

    /*---product new arrival sec---*/
    let $newarrivalcarousel = $(".new-arrival-carousel");
    if ($newarrivalcarousel.length > 0) {
        $newarrivalcarousel
            .on("changed.owl.carousel initialized.owl.carousel", function (e) {
                $(e.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(e.item.index + e.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 15,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    992: {
                        items: 4,
                    },
                    1200: {
                        items: 4,
                    },
                    1400: {
                        items: 5,
                    },
                    1600: {
                        items: 6,
                    },
                },
            });
    }
    /*---seller homepage---*/
    let $seller_carouselcarousel = $(".seller-carousel");
    if ($seller_carouselcarousel.length > 0) {
        $seller_carouselcarousel
            .on("changed.owl.carousel initialized.owl.carousel", function (e) {
                $(e.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(e.item.index + e.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 10,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    992: {
                        items: 4,
                    },
                    1200: {
                        items: 5,
                    },
                    1400: {
                        items: 6,
                    },
                    1600: {
                        items: 7,
                    }
                },
            });
    }

    /*--- seller-details---*/
    let $sellerdetails = $(".seller-details");
    if ($sellerdetails.length > 0) {
        $sellerdetails
            .on("changed.owl.carousel initialized.owl.carousel", function (e) {
                $(e.target)
                    .find(".owl-item")
                    .removeClass("last")
                    .eq(e.item.index + e.page.size - 1)
                    .addClass("last");
            })
            .owlCarousel({
                loop: false,
                nav: true,
                autoplay: false,
                autoplayTimeout: 8000,
                items: 3,
                rtl: true,
                dots: false,
                margin: 20,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 1,
                    },
                    992: {
                        items: 1,
                    },
                    1200: {
                        items: 2,
                    },
                    1600: {
                        items: 3,
                    },
                },
            });
    }

    /* ---- For Footer Start ---- */

    let $headingFooterhome3 = $("footer h3");
    $(window)
        .resize(function () {
            if ($(window).width() <= 768) {
                $headingFooterhome3.attr("data-toggle", "collapse");
            } else {
                $headingFooterhome3.removeAttr("data-toggle", "collapse");
            }
        })
        .resize();
    $headingFooterhome3.on("click", function () {
        $(this).toggleClass("opened");
    });

    $("#iconfooter3 h3").on("click", function () {
        $(this).next("ul").slideToggle(1000);
        $(this).find("em").toggleClass("fa-angle-down fa-angle-up");
    });
    /* ---- For Footer End ---- */
    $(function () {
        $("#logintTab")
            .find("a")
            .click(function (e) {
                e.preventDefault();
                $(this.hash).show().siblings().hide();
                $("#logintTab").find("a").parent().removeClass("active");
                $(this).parent().addClass("active");
            })
            .filter(":first")
            .click();
    });

    /*---mini cart activation---*/
    $(document).on("click", ".mini_cart_wrapper > a", function () {
        $(".mini_cart,.mobile_overlay").addClass("active");
    });

    $(document).on("click", ".mini_cart_close,.mobile_overlay", function () {
        $(".mini_cart,.mobile_overlay").removeClass("active");
    });

    $(document).on("click", ".checkout-dbutton", function () {
        swal("", "Some Items is not deliverable to selected pincode.", "error");
    });

    $(document).on("click", ".checkout-spincode-button", function () {
        $("#pincodeModal").modal("show");
    });

    $(".close-pincode-modal").on("click", function () {
        $("#pincodeModal").modal("toggle");
    });

    function DropDown(el) {
        this.dd = el;
        this.initEvents();
    }
    DropDown.prototype = {
        initEvents: function () {
            let obj = this;
            obj.dd.on("click", function (event) {
                $(this).toggleClass("active");
                event.stopPropagation();
            });
        },
    };

    jQuery(document).ready(function ($) {
        let dd = new DropDown($(".dd"));
        $(".wrapper-dropdown-5").removeClass("active");

        $("li.item").on("click", function () {
            let li_val = $(this).text();
        });
    });
    $(".live-search-list li.item").each(function () {
        $(this).attr("data-search-term", $(this).text().toLowerCase());
    });

    $(".live-search-box").on("keyup", function () {
        let searchTerm = $(this).val().toLowerCase();

        $(".live-search-list li.item").each(function () {
            if ($(this).filter("[data-search-term *= " + searchTerm + "]").length > 0 || searchTerm.length < 1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $(document).on("click", ".file-upload", function () {
        let file = $(this).parent().parent().parent().find(".file");
        file.trigger("click");
    });

    $('input[type="file"]').on("change", function (e) {
        let fileName = e.target.files[0].name;
        $("#file1").val(fileName);
        let reader = new FileReader();
        reader.onload = function (f) {
            document.getElementById("user_profile").src = f.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });

    $("#profile_form").on("submit", function (e) {
        e.preventDefault();
        let fd = new FormData(this);
        fd.append("accesskey", "90336");
        fd.append("type", "edit-profile");
        fd.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            type: "POST",
            url: profile_api_url,
            data: fd,
            headers: {
                Authorization: "Bearer " + token,
            },
            beforeSend: function () {
                $("#submit_btn").html("Please wait..");
            },
            contentType: false,
            processData: false,
            success: function (result) {
                console.log(result);
                $("#submit_btn").html("Update");
            },
        });
    });
    //Sweet Alert message
    if (suc_msg && suc_msg != null) {
        swal("Success!", suc_msg, "success");
    }
    if (err_msg && err_msg != null) {
        swal("Error!", err_msg, "error");
    }
    if (error_code && error_code != null && error_code == 5) {
        $(function () {
            $("#myModal").modal("show");
        });
    }
    $(document).on("click", ".login-popup", function () {
        $("#myModal").modal("show");
    });
    //Passive Wheel Controller
    const eventListenerOptionsSupported = () => {
        let supported = false;
        try {
            const opts = Object.defineProperty({}, "passive", {
                get() {
                    supported = true;
                },
            });
            window.addEventListener("test", null, opts);
            window.removeEventListener("test", null, opts);
        } catch (e) {}
        return supported;
    };
    const defaultOptions = {
        passive: false,
        capture: false,
    };
    const supportedPassiveTypes = ["scroll", "wheel", "touchstart", "touchmove", "touchenter", "touchend", "touchleave", "mouseout", "mouseleave", "mouseup", "mousedown", "mousemove", "mouseenter", "mousewheel", "mouseover"];
    const getDefaultPassiveOption = (passive, eventName) => {
        if (passive !== undefined) return passive;
        return supportedPassiveTypes.indexOf(eventName) === -1 ? false : defaultOptions.passive;
    };
    const getWritableOptions = (options) => {
        const passiveDescriptor = Object.getOwnPropertyDescriptor(options, "passive");
        return passiveDescriptor && passiveDescriptor.writable !== true && passiveDescriptor.set === undefined ? Object.assign({}, options) : options;
    };
    const overwriteAddEvent = (superMethod) => {
        EventTarget.prototype.addEventListener = function (type, listener, options) {
            const usesListenerOptions = typeof options === "object" && options !== null;
            const useCapture = usesListenerOptions ? options.capture : options;
            options = usesListenerOptions ? getWritableOptions(options) : {};
            options.passive = getDefaultPassiveOption(options.passive, type);
            options.capture = useCapture === undefined ? defaultOptions.capture : useCapture;
            superMethod.call(this, type, listener, options);
        };
        EventTarget.prototype.addEventListener._original = superMethod;
    };
    const supportsPassive = eventListenerOptionsSupported();
    if (supportsPassive) {
        const addEvent = EventTarget.prototype.addEventListener;
        overwriteAddEvent(addEvent);
    }
});

function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
     the text field element and an array of possible autocompleted values:*/
    let  currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function (e) {
        let  a,
            b,
            i,
            val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            let  pos = arr[i].toUpperCase().indexOf(val.toUpperCase());
            /*check if the item starts with the same letters as the text field value:*/
            if (pos > -1) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = arr[i].substr(0, pos);
                b.innerHTML += "<strong>" + arr[i].substr(pos, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(pos + val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function (e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                     (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function (e) {
        let  x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
             increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) {
            //up
            /*If the arrow UP key is pressed,
             decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = x.length - 1;
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (let i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
         except the one passed as an argument:*/
        let x = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

$(function () {
    $.ajax({
        url: home + "autocomplete",
        method: "GET",
        dataType: "json",
        success: function (response) {
            let availableTags = response;

            /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
            autocomplete(document.getElementById("search"), availableTags);
            autocomplete(document.getElementById("searchm"), availableTags);
        },
    });
});

let arraynew = ["5"];
let limit = arraynew[0];
let offset = 0;
function searchclick() {
    let serch_input = document.getElementById("searchclick").value;

    //HomeGetPincode(offset, sublimit);

    $.ajax({
        url: home + "pincode_search",
        type: "POST",
        dataType: "json",
        data: {
            search: serch_input,
        },
        async: true,
        cache: false,
        success: function (response) {
            let count_pincode = response.pincode.length;

            let html = "";
            html += '<li class="item" data-search-term="All"><a class="close-pincode-modal" href="/pincodeclear"> All</a></li>';
            if (count_pincode > 0) {
                for (let i = 0; i < count_pincode; i++) {
                    html += '<li class="item" data-search-term="' + response.id[i] + '"><a class="close-pincode-modal" href="/pincode/' + response.pincode[i] + '">' + response.pincode[i] + "</a></li>";
                }
            }

            $(".live-search-list").html(html);

            //$( ".live-search-list" ).html( html );
        },
    });
}

$(".select2-search input").focus(function () {
    $(this).addClass("red");
});

$(document).ready(function () {
    $("img.lazy").lazyload({
        placeholder: home + "public/images/placeholder.png",
    });
});
$("body").on("click", ".user_deactive_btn", function () {
    alertify.set("notifier", "position", "top-center");
    alertify.warning(msg.Your_Account_is_De_active_ask_on_Customer_Support);
});
if (deactivate_user == "0") {
    $(function () {
        $("button").addClass("disabled");
        $("button").parent("").addClass("user_deactive_btn");
        $(".btn").addClass("disabled");
        $(".btn").parent("").addClass("user_deactive_btn");
        $(".save_for_later").addClass("disabled");
        $(".save_for_later").parent("").addClass("user_deactive_btn");
        $(".move_to_cart").addClass("disabled");
        $(".move_to_cart").parent("").addClass("user_deactive_btn");
    });
}
