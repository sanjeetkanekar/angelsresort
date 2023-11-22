'use strict';

(function ($) {
    
     /*------------------
        Sticky header
    --------------------*/

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        var headerheight = document.getElementById('menu').offsetHeight;
        var nav = document.getElementById('lowernav');
    
        if (scroll >= headerheight && screen.width > 990 ) {          
            nav.classList.add("background-header");
        } else {
            nav.classList.remove("background-header");
        }
      });

      $(window).scroll(function() {
        if (window.location.pathname !== '/gallery.html' && window.location.pathname !== '/') {
        var scroll = $(window).scrollTop();
        var headerheight = document.getElementById('lowernav').offsetHeight;
        var nav = document.getElementById('currentsearch');
        var distanceTop = document.getElementById('roomdetails').getBoundingClientRect().top;
    
        if (scroll > distanceTop) {        
            nav.classList.add("recentsearch-header");
            nav.style.top = headerheight + "px";
        } else {
            nav.classList.remove("recentsearch-header");
            nav.style.top = 0;
        }
    }
      });
    /*------------------
        Pay Now button
    --------------------*/
    if(document.getElementById("paynowBtn")){
        let mybutton = document.getElementById("paynowBtn");

    // When the user scrolls down 200px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
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

    $( ".img-wrapper" ).hover(
        function() {
          $(this).find(".img-overlay").animate({opacity: 1}, 600);
        }, function() {
          $(this).find(".img-overlay").animate({opacity: 0}, 600);
        }
      );
      
      // Lightbox
      var $overlay = $('<div id="overlay"></div>');
      var $image = $("<img>");
      var $prevButton = $('<div id="prevButton"><i class="fa fa-chevron-left"></i></div>');
      var $nextButton = $('<div id="nextButton"><i class="fa fa-chevron-right"></i></div>');
      var $exitButton = $('<div id="exitButton"><i class="fa fa-times"></i></div>');
      
      // Add overlay
      $overlay.append($image).prepend($prevButton).append($nextButton).append($exitButton);
      $("#gallery").append($overlay);
      
      // Hide overlay on default
      $overlay.hide();
      
      // When an image is clicked
      $(".img-overlay").click(function(event) {
        // Prevents default behavior
        event.preventDefault();
        // Adds href attribute to variable
        var imageLocation = $(this).prev().attr("href");
        // Add the image src to $image
        $image.attr("src", imageLocation);
        // Fade in the overlay
        $overlay.fadeIn("slow");
      });
      
      // When the overlay is clicked
      $overlay.click(function() {
        // Fade out the overlay
        $(this).fadeOut("slow");
      });
      
      // When next button is clicked
      $nextButton.click(function(event) {
        // Hide the current image
        $("#overlay img").hide();
        // Overlay image location
        var $currentImgSrc = $("#overlay img").attr("src");
        // Image with matching location of the overlay image
        var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
        // Finds the next image
        var $nextImg = $($currentImg.closest(".image").next().find("img"));
        // All of the images in the gallery
        var $images = $("#image-gallery img");
        // If there is a next image
        if ($nextImg.length > 0) { 
          // Fade in the next image
          $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
        } else {
          // Otherwise fade in the first image
          $("#overlay img").attr("src", $($images[0]).attr("src")).fadeIn(800);
        }
        // Prevents overlay from being hidden
        event.stopPropagation();
      });
      
      // When previous button is clicked
      $prevButton.click(function(event) {
        // Hide the current image
        $("#overlay img").hide();
        // Overlay image location
        var $currentImgSrc = $("#overlay img").attr("src");
        // Image with matching location of the overlay image
        var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
        // Finds the next image
        var $nextImg = $($currentImg.closest(".image").prev().find("img"));
        // Fade in the next image
        $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
        // Prevents overlay from being hidden
        event.stopPropagation();
      });
      
      // When the exit button is clicked
      $exitButton.click(function() {
        // Fade out the overlay
        $("#overlay").fadeOut("slow");
      });
    

})(jQuery);


$(function(){
    var dtToday = new Date();
    
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    
    var minDate= year + '-' + month + '-' + day;
    
    $('.mydate').attr('min', minDate);
});

function openModal(){
  $("#mydateModal").modal('show');
}

function dateupdatevalue() {
  var newindate = document.getElementsByClassName("t-input-check-in")[0].value;
  var newoutdate = document.getElementsByClassName("t-input-check-out")[0].value;

  document.getElementById("myindate").value = newindate;
  document.getElementById("myoutdate").value = newoutdate;
  document.getElementById("myindate1").value = newindate;
  document.getElementById("myoutdate1").value = newoutdate;
  $("#mydateModal").modal('hide');
}