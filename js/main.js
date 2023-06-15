'use strict';

(function ($) {

    var sticky = $('.sticky');
    var contentOffset;

    var sticky = $('.sticky');
    var contentOffset;
    var nav_height;

    if (sticky.length) {

        if (sticky.data('offset')) {
            contentOffset = sticky.data('offset');
        } else {
            contentOffset = sticky.offset().top;
        }
        nav_height = sticky.height();
    }

    var scrollTop = $(window).scrollTop();
    var window_height = $(window).height();
    var doc_height = $(document).height();

    $(window).bind('resize', function () {
        scrollTop = $(window).scrollTop();
        window_height = $(window).height();
        doc_height = $(document).height();
        navHeight();
    });

    $(window).bind('scroll', function () {
        stickyNav();
    });

    function navHeight() {
        sticky.css('max-height', window_height + 'px');
    }

    function stickyNav() {
        scrollTop = $(window).scrollTop();
        if (scrollTop > contentOffset) {
            sticky.addClass('fixed');
        } else {
            sticky.removeClass('fixed');
        }
    };
    
    //  $("#roomtype").change(function () {
    //     var roomtype = $(this).val();
    //     var pricetextBox = document.getElementById("price");
    //     if (roomtype == "Standard") {
    //         pricetextBox.value = "3500";
    //     } else {
    //         pricetextBox.value = "5000";
    //     }
    // });

    let mybutton = document.getElementById("paynowBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Offcanvas Menu
    $(".canvas-open").on('click', function () {
        $(".offcanvas-menu-wrapper").addClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").addClass("active");
    });

    $(".canvas-close, .offcanvas-menu-overlay").on('click', function () {
        $(".offcanvas-menu-wrapper").removeClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").removeClass("active");
    });

    // Search model
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Hero Slider
    --------------------*/
   $(".hero-slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        mouseDrag: false
    });

    /*------------------------
		Testimonial Slider
    ----------------------- */
    $(".testimonial-slider").owlCarousel({
        items: 1,
        dots: false,
        autoplay: true,
        loop: true,
        smartSpeed: 1200,
        nav: true,
        navText: ["<i class='arrow_left'></i>", "<i class='arrow_right'></i>"]
    });

    /*------------------
        Magnific Popup
    --------------------*/
    $('.video-popup').magnificPopup({
        type: 'iframe'
    });

    /*------------------
		Date Picker
	--------------------*/
    $(".date-input").datepicker({
        minDate: 0,
        dateFormat: 'dd MM, yy'
    });

    /*------------------
		Nice Select
	--------------------*/
    $("select").niceSelect();

})(jQuery);