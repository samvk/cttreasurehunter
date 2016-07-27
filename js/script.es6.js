/* jshint esversion: 6 */
/* global $, document, Image, window, setTimeout, setInterval, clearInterval */

$(document).ready(function () {
    "use strict";
    
    /************** Nav autoscroller **************/

    $.fn.scrollTo = function () {
        return this.each(function () {
            //Both "html" and "body" required for browser compatibility
            $("html, body").stop().animate({
                scrollTop: $(this).offset().top
            }, 1500, "easeInOutQuart");
        });
    };

    $(".autoscroll").click(function (e) {
        e.preventDefault();
        let anchor = $(this).attr("href");
        $(anchor).scrollTo();
    });

    /****** nav--list Hamburger slideToggle() ******/

    $(".nav__hamburger").click(function () {
        $(".nav-list").stop().slideToggle(350);
    });

    $(".nav--logo, .nav-list li").click(function () {
        if (window.matchMedia("(max-width: 767px)").matches) {
            $(".nav-list").stop().delay(600).slideUp(500);
        }
    });
    
    /********* Navbar-related scrolling functions *********/
    
    $(window).scroll(function () {
        let windowTopLine = $(window).scrollTop();

        /*********** Nav size change on scroll ***********/
        if (windowTopLine > 200) {
            $("nav").addClass("is-small");
        } else {
            $("nav").removeClass("is-small");
        }

        /*********** Nav section highlighting ************/
        $("header, body>section").each(function () {
            let sectionTopLine = $(this).offset().top - 60;
            let sectionBottomLine = $(this).offset().top + $(this).innerHeight() - 60;
            let thisSectionID = "#" + $(this).attr("id");

            let $myNavAnchor = $(`[href="${thisSectionID}"]`);

            //If the object is  visible        
            if (sectionTopLine < windowTopLine && windowTopLine < sectionBottomLine) {
                $myNavAnchor.addClass("is-highlighted");
            } else {
                $myNavAnchor.removeClass("is-highlighted");
            }
        });

    });
    
    /*********** Service buttons auto-select service type ***********/

    $(".service__button").click(function(){
        let $select = $(".contact__select--service")
        let service = $(this).data("service");
        
        $select.val(service);
        $select.siblings(".input__placeholder").addClass("is-focused").addClass("loud");
    });

    /*********** Contact form placeholder text ***********/

    $(":input").focus(function () {
        $(".input__placeholder").removeClass("loud")
        $(this).siblings(".input__placeholder").addClass("is-focused").addClass("loud");
    }).blur(function () {
        $(this).siblings(".input__placeholder").removeClass("loud");
    });
    
    /*************** Privacy policy modal ***************/

    $(".privacy-policy__open-button").click(function (e) {
        e.preventDefault();
        $("#privacy-policy").toggleClass("is-hidden");
    });

    $(".privacy-policy__close-button, .privacy-policy__close-icon").click(function() {
        $("#privacy-policy").addClass("is-hidden");
    });

});