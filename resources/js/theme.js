import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import select2 from 'select2';
import 'select2/dist/css/select2.css';
select2($);

import datepicker from 'bootstrap-datepicker';
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css';

// console.log(datepicker);

(function($) {
    "use strict"; // Start of use strict

    const Theme = {
      
      onWindowResize: function() {

        if ($(window).width() < 768) {
          $('.sidebar .collapse').collapse('hide');
        };
        
        // Toggle the side navigation when window is resized below 480px
        if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
          $("body").addClass("sidebar-toggled");
          $(".sidebar").addClass("toggled");
          $('.sidebar .collapse').collapse('hide');
        };

      },

      onSidebarToggle: function() {

        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
        if ($(".sidebar").hasClass("toggled")) {
          $('.sidebar .collapse').collapse('hide');
        };

      },

      toggleGoToTopButton: function() {

        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
          $('.scroll-to-top').fadeIn();
        } else {
          $('.scroll-to-top').fadeOut();
        }

      },

      smoothScroll: function() {

        let $anchor = $(this);
        $('html, body').stop().animate({
          scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        e.preventDefault();

      },

      togglePasswordFields: function() {

        $('.password, .confirm-password').slideToggle();

      },

      generateUserPassword: function() {
        // let pass = (Math.random() + 1).toString(36).substring(1, 30);
        let pass = Math.random().toString(36).slice(2);
        jQuery('#generated-password').text( 'Generated password: ' + pass );
        jQuery('#password, #password_confirmation').val( pass );
        // jQuery('#confirm-password').val( pass );
        
        // console.log(pass);
      }

    }

    jQuery(document).ready(function(){

      $('.cw-ext-select').select2();

      $('.cw-ext-datepicker').datepicker({
        format: 'yyyy-mm-dd'
      });

      // Toggle the side navigation
      $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
        Theme.onSidebarToggle();
      });

      // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
      $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
        if ($(window).width() > 768) {
          let e0 = e.originalEvent;
          let delta = e0.wheelDelta || -e0.detail;
          this.scrollTop += (delta < 0 ? 1 : -1) * 30;
          e.preventDefault();
        }
      });
    
      // Smooth scrolling using jQuery easing
      $(document).on('click', 'a.scroll-to-top', function(e) {
        Theme.smoothScroll();
      });

      $('body').on('click', '#change-user-pass', function(e){
        Theme.togglePasswordFields();
      });

      $('body').on('click', '#generate-password', function(e){
        Theme.generateUserPassword();
      });
    });

    // Close any open menu accordions when window is resized below 768px
    $(window).on('resize', function() {
      Theme.onWindowResize();
    });

    // Scroll to top button appear
    $(document).on('scroll', function() {
      Theme.toggleGoToTopButton();
    });
  
    

  
})(jQuery); // End of use strict
