var App = function () {

	var $ = jQuery;
     // IE mode
    var isRTL = false;
    var isIE8 = false;
    var isIE9 = false;
    var isIE10 = false;

    var handleInit = function() {

        if (jQuery('body').css('direction') === 'rtl') {
            isRTL = true;
        }

        isIE8 = !! navigator.userAgent.match(/MSIE 8.0/);
        isIE9 = !! navigator.userAgent.match(/MSIE 9.0/);
        isIE10 = !! navigator.userAgent.match(/MSIE 10.0/);
        
        if (isIE10) {
            jQuery('html').addClass('ie10'); // detect IE10 version
        }
    }

    function handleIEFixes() {
        //fix html5 placeholder attribute for ie7 & ie8
        if (isIE8 || isIE9) { // ie8 & ie9
            // this is html5 placeholder fix for inputs, inputs with placeholder-no-fix class will be skipped(e.g: we need this for password fields)
            jQuery('input[placeholder]:not(.placeholder-no-fix), textarea[placeholder]:not(.placeholder-no-fix)').each(function () {

                var input = jQuery(this);

                if (input.val() == '' && input.attr("placeholder") != '') {
                    input.addClass("placeholder").val(input.attr('placeholder'));
                }

                input.focus(function () {
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                });

                input.blur(function () {
                    if (input.val() == '' || input.val() == input.attr('placeholder')) {
                        input.val(input.attr('placeholder'));
                    }
                });
            });
        }
    }

    jQuery(window).scroll(function() {
        if ($(window).scrollTop()>300){
            $(".header").addClass("scrolling-fixed").removeClass("no-scrolling-fixed");
        }
        else {
            $(".header").removeClass("scrolling-fixed").addClass("no-scrolling-fixed");
        };
    });

    function handleBootstrap() {
        jQuery('.carousel').carousel({
            interval: 15000,
            pause: 'hover'
        });
        jQuery('.tooltips').tooltip();
        jQuery('.popovers').popover();
    }

    function handleMisc() {
        jQuery('.top').click(function () {
            jQuery('html,body').animate({
                scrollTop: jQuery('body').offset().top
            }, 'slow');
        }); //move to top navigator
    }


    function handleSearch() {    
    	jQuery('.nav-login-form a.search-btn').click(function () {            
            if(jQuery('.nav-login-form a.search-btn').hasClass('show-search-icon')){
            	jQuery('.login-menu-linker .search-box').fadeOut(300);
            	jQuery('.nav-login-form .search-btn').removeClass('show-search-icon');
            } else {
                if (global_enable_overlay) {
                    $("body").append('<div class="modalOverlay">');  
                    $('div.modalOverlay').fadeIn();
                }
            	jQuery('.login-menu-linker .search-box').fadeIn(300);
            	jQuery('.nav-login-form a.search-btn').addClass('show-search-icon');
                jQuery('.login-menu-linker .search-box input[type=text]:first').focus();
            }
            global_enable_overlay = false;
        }); 
        jQuery('.login-menu-linker a#btn-close').click(function() {
            if (global_old_login_redirect_url.length > 0)
                $(".login-menu-linker form").attr('action', global_old_login_redirect_url);
            
            jQuery('.nav-login-form a.search-btn').trigger('click');
            $('div.modalOverlay').remove();
        });
    }

    function handleUniform() {
        if (!jQuery().uniform) {
            return;
        }
        var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
        if (test.size() > 0) {
            test.each(function () {
                    if ($(this).parents(".checker").size() == 0) {
                        $(this).show();
                        $(this).uniform();
                    }
                });
        }
    }

    var handleFancybox = function () {
        if (!jQuery.fancybox) {
            return;
        }

        if (jQuery(".fancybox-button").size() > 0) {            
            jQuery(".fancybox-button").fancybox({
                groupAttr: 'data-rel',
                prevEffect: 'none',
                nextEffect: 'none',
                closeBtn: true,
                helpers: {
                    title: {
                        type: 'inside'
                    }
                }
            });

            $('.fancybox-video').fancybox({
                type: 'iframe'
            });
        }
    }
	
    var handleFixedHeader = function() {

            if (!window.addEventListener) {
        window.attachEvent( 'scroll', function( event ) {
                    if ($('body').hasClass("page-header-fixed") === false) {
                        return;
                    }
        if( !didScroll ) {
        didScroll = true;
        setTimeout( scrollPage, 250 );
        }
        });
            } else {
                window.addEventListener( 'scroll', function( event ) {
                    if ($('body').hasClass("page-header-fixed") === false) {
                        return;
                    }
                    if( !didScroll ) {
                        didScroll = true;
                        setTimeout( scrollPage, 250 );
                    }
                }, false );
            }
        var docElem = document.documentElement,
        header = $( '.navbar-inner' ),
        headerwrap = $( '.front-header' ),
        slider = $( '.slider-main' ),
        didScroll = false,
        changeHeaderOn = 300;

        function scrollPage() {
        var sy = scrollY();
        if ( sy >= changeHeaderOn ) {
                headerwrap.addClass('front-header-shrink');
                header.addClass('navbar-inner-shrink');
                jQuery('#logoimg').attr('width', '120px');
                jQuery('#logoimg').attr('height', '18px');
            } else {
                headerwrap.removeClass('front-header-shrink');
                header.removeClass('navbar-inner-shrink');
                jQuery('#logoimg').attr('width', '142px');
                jQuery('#logoimg').attr('height', '21px');
            }
            didScroll = false;
        }

        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }

    }

    var handleTheme = function () {
	
        var panel = $('.color-panel');
	
        // handle theme colors
        var setColor = function (color) {
            $('#style_color').attr("href", "assets/css/themes/" + color + (isRTL ? '-rtl' : '') + ".css");
            $('#logoimg').attr("src", "assets/img/logo_" + color + ".png");
            $('#rev-hint1').attr("src", "assets/img/sliders/revolution/hint1-" + color + ".png");
            $('#rev-hint2').attr("src", "assets/img/sliders/revolution/hint2-" + color + ".png");
        }

        $('.icon-color', panel).click(function () {
            $('.color-mode').show();
            $('.icon-color-close').show();
        });

        $('.icon-color-close', panel).click(function () {
            $('.color-mode').hide();
            $('.icon-color-close').hide();
        });

        $('li', panel).click(function () {
            var color = $(this).attr("data-style");
            setColor(color);
            $('.inline li', panel).removeClass("current");
            $(this).addClass("current");
        });
		
		$('.header-option', panel).change(function(){
			if($('.header-option').val() == 'fixed'){
	            $("body").addClass("page-header-fixed");
                $('.header').addClass("navbar-fixed-top").removeClass("navbar-static-top");
				App.scrollTop();
				
			} else if($('.header-option').val() == 'default'){
	            $("body").removeClass("page-header-fixed");
                $('.header').addClass("navbar-static-top").removeClass("navbar-fixed-top");
				$('.navbar-inner').removeClass('navbar-inner-shrink');
				$('.front-header').removeClass('front-header-shrink');
				App.scrollTop();
			}
		});
		
	}
	
    return {
        init: function () {
            handleInit();
            handleBootstrap();
            handleIEFixes();
            handleMisc();
            handleSearch();
			handleTheme(); // handles style customer tool
            handleFancybox();
			handleFixedHeader();
                        
            // wordpress custom
            jQuery(".login-menu-linker #loginform #wp-submit").addClass("btn btn-warning");
            jQuery(".login-menu-linker #loginform label:eq(0)").hide();
            jQuery(".login-menu-linker #loginform label:eq(1)").hide();
            jQuery(".login-menu-linker #loginform #user_login").removeAttr('size');
            jQuery(".login-menu-linker #loginform #user_login").wrap('<div class="form-group">'
            + '<div class="input-group group1">'
            + '</div></div>');
            jQuery(".login-menu-linker #loginform .group1").prepend('<span class="input-group-addon"><i class="fa fa-user"></i></span>');
            jQuery(".login-menu-linker #loginform #user_login").addClass("form-control");
            
            jQuery(".login-menu-linker #loginform #user_pass").wrap('<div class="form-group">'
            + '<div class="input-group group2">'
            + '</div></div>');
            jQuery(".login-menu-linker #loginform .group2").prepend('<span class="input-group-addon"><i class="fa fa-lock"></i></span>');
            jQuery(".login-menu-linker #loginform #user_pass").addClass("form-control");
            jQuery(".login-menu-linker #loginform #user_login").attr("placeholder", "Username");
            jQuery(".login-menu-linker #loginform #user_pass").attr("placeholder", "Password");
            
            jQuery("#fscf_submit1").addClass("btn btn-default theme-btn");
            jQuery("#fscf_form1 input[type=text]").addClass("form-control");
            jQuery("#fscf_form1 textarea").addClass("form-control");
            jQuery("#fscf_form1 label").addClass("control-label");
            jQuery("#fscf_form1 label > span").addClass("color-red");
            
            jQuery("form#adduser input[type=text]").addClass("form-control");
            jQuery("form#adduser textarea").addClass("form-control");
            jQuery("form#adduser input[type=password]").addClass("form-control");
            jQuery("form#adduser input[type=submit]").removeClass("submit");
            jQuery("form#adduser input[type=submit]").removeClass("button");
            jQuery("form#adduser input[type=submit]").addClass("btn btn-default theme-btn pull-right");
            jQuery("form#adduser input[type=submit]").css({"margin": "30px 80px 30px 0"});
            jQuery("form#adduser label").addClass("control-label");
            jQuery("form#searchform input[type=text]").addClass("form-control");
            jQuery("form#searchform label").addClass("control-label");
            jQuery("form#searchform input[type=submit]").hide();
            
           // jQuery("div.footer-columns ul.menu li").prepend("<i class='fa fa-globe'></i> ");
        },

        initUniform: function (els) {
            if (els) {
                jQuery(els).each(function () {
                        if ($(this).parents(".checker").size() == 0) {
                            $(this).show();
                            $(this).uniform();
                        }
                    });
            } else {
                handleUniform();
            }
        },

        initBxSlider: function () {
            $('.bxslider').show();
            $('.bxslider').bxSlider({
                minSlides: 3,
                maxSlides: 3,
                slideWidth: 360,
                slideMargin: 10,
                moveSlides: 1,
                responsive: true,
            });

            $('.bxslider1').show();            
            $('.bxslider1').bxSlider({
                minSlides: 6,
                maxSlides: 6,
                slideWidth: 360,
                slideMargin: 2,
                moveSlides: 2,
                responsive: false,
            });            
        },

        // wrapper function to scroll to an element
        scrollTo: function (el, offeset) {
            pos = el ? el.offset().top : 0;
            jQuery('html,body').animate({
                    scrollTop: pos + (offeset ? offeset : 0)
                }, 'slow');
        },

        scrollTop: function () {
            App.scrollTo();
        },

        gridOption1: function () {
            $(function(){
                $('.grid-v1').mixitup();
            });    
        }

    };
    
    // Handles Bootstrap Accordions.
    var handleAccordions = function () {
        var lastClicked;
        //add scrollable class name if you need scrollable panes
        jQuery('body').on('click', '.accordion.scrollable .accordion-toggle', function () {
            lastClicked = jQuery(this);
        }); //move to faq section

        jQuery('body').on('show.bs.collapse', '.accordion.scrollable', function () {
            jQuery('html,body').animate({
                scrollTop: lastClicked.offset().top - 150
            }, 'slow');
        });
    }

    // Handles Bootstrap Tabs.
    var handleTabs = function () {
        // fix content height on tab click
        $('body').on('shown.bs.tab', '.nav.nav-tabs', function () {
            handleSidebarAndContentHeight();
        });

        //activate tab if tab id provided in the URL
        if (location.hash) {
            var tabid = location.hash.substr(1);
            $('a[href="#' + tabid + '"]').click();
        }
    }
}();