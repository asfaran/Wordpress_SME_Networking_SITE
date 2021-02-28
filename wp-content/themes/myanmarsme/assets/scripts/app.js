var App = function () {

     // IE mode
    var isRTL = false;
    var isIE8 = false;
    var isIE9 = false;
    var isIE10 = false;
    var $ = jQuery;
    
    // start directory
    
    var directory_count = 20;
    var directory_offset = 0;
    var directory_total = 0;
    var directory_filter_industries = [];
    var directory_filter_alpha = '';
    var directory_filter_q = '';
    var load_fresh = true;
    
    var handleDirectory = function() {
		
    	if ($("#directory_window").length > 0) {
    		
    		load_directory_listings($("#directory_window"));
    		
    		$(".btn_filter_directory").click(function(e) {    			
    			e.preventDefault();
    			directory_filter_industries = [];
    			directory_offset = 0;
    			load_fresh = true;
    			$('.chk_industries').each(function() {
    				var status = $(this).is(':checked');
    				if (status) {
    					directory_filter_industries.push($(this).val());
    				}
    			});
    			$('.btn_filter_directory_clear').removeClass('hidden');
    			load_directory_listings_fetch($("#directory_window"));
    		});
    		
    		// load more
    		$("#directory_window").on("click", '.btn_load_more', function() {
    			directory_offset = directory_offset + directory_count;
    			$('.loading').removeClass('hidden');
    			load_fresh = false;
    			load_directory_listings_fetch($("#directory_window"));
    		});
    		
    		$("#directory_window .alpha-box a").click(function(e) {
    			e.preventDefault();
    			directory_offset = 0;
    			directory_filter_alpha = '';
    			directory_filter_alpha = $(this).attr('rel');
    			load_fresh = true;
    			load_directory_listings_fetch($("#directory_window"));
    		});
    		
    		// Clear
    		$(".btn_filter_directory_clear").click(function(e) {
    			directory_clear_search_vars();
    			directory_clear_search_fields();
    			$(this).addClass('hidden');
    			load_directory_listings_fetch($("#directory_window"));
    		});
    		
    		$('.dropdown-menu input[type=checkbox]').click(function(e) {
    		    e.stopPropagation();
    		});
    		$('.dropdown-menu label').click(function(e) {
    		    e.stopPropagation();
    		});
    	}
    }
    
    var directory_clear_search_vars = function() {
    	directory_offset = 0;
    	directory_filter_industries = [];
    	directory_filter_alpha = '';
    	directory_filter_q = '';
    	load_fresh = true;
    }
    var directory_clear_search_fields = function() {
    	$('.chk_industries').each(function() {
    		$(this).prop('checked', false);
    	});
    }
    
    var load_directory_listings = function(target) {    	
    	target.on('show.bs.modal', function(e) {
    		load_directory_listings_fetch(target);
		});
    }
    
    var load_directory_listings_fetch = function(target) {    	
    	var dir = '';
    	if (typeof directory != 'undefined')
    		dir = directory;
    	
    	//console.log(directory);
    	
    	if (load_fresh) {
    		$("#scroller_window", target).html("<div class='loading' style='text-align:center;margin-top:100px;'>Please wait ..</div>");
    	}
    	$.ajax({
				type:"POST",
				url:site_url + "/ajax/",
				dataType:'json',
				data:{mode:'GET_DIRECTORY', filter_offset: directory_offset, 
					filter_count: directory_count, 
					filter_industries: directory_filter_industries,
					filter_alpha: directory_filter_alpha,
					filter_q: directory_filter_q,
					filter_dir: dir},
				success: function(data){
					if (data.hasOwnProperty('success') && data.success === true) {
						$('.loading').remove();
						if (data.hasOwnProperty('html')) {
							if (load_fresh) {								
								var html_value = data.html;
								if (html_value.length == 0) html_value = '<li style="margin-top:100px;">Your search did not match any companies. Please try with different search options.</li>';
								$("#scroller_window", target).html('<ul class="directory_list">' + html_value + '</ul>');
							}
							else if ($("#scroller_window .directory_list", target).length > 0) {	
								$('#scroller_window li.tools', target).remove();
								$("#scroller_window .directory_list", target).append(data.html);
							}
						}
						else {
							$("#scroller_window", target).html("<div style='text-align:center;margin-top:100px;'>Sorry, we could not fetch the directory this time. Please try again later.</div>");
						}
						if (data.hasOwnProperty('offset'))
							directory_offset = data.offset;
						if (data.hasOwnProperty('total'))
							directory_total = data.total;
					}   
					else {
						$("#scroller_window", target).html("<div style='text-align:center;margin-top:100px;'>Sorry, we could not fetch the directory this time. Please try again later.</div>");
					}
				}
		  });
    }
    
    // end directory

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

    /*$(window).scroll(function() {
        if ($(window).scrollTop()>300){
            $(".header").addClass("scrolling-fixed").removeClass("no-scrolling-fixed");
        }
        else {
            $(".header").removeClass("scrolling-fixed").addClass("no-scrolling-fixed");
        };
    });*/

    function handleBootstrap() {
        jQuery('.carousel').carousel({
            interval: 12000,
            pause: 'hover'
        });
        
        jQuery('.testimonials-v1 #success_stories').carousel({
            interval: 5000,
            pause: 'hover'
        });
        jQuery('#carousel-directory').carousel({
            interval: 5000,
            pause: 'hover'
        });
        
        jQuery('.testimonials-v1 #resources_stories').carousel({
            interval: 8000,
            pause: 'hover'
        });
        
        jQuery('.carousel_success_stories').carousel({
            interval: 8000,
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
    	jQuery('.search-btn').click(function () {            
            if(jQuery('.search-btn').hasClass('show-search-icon')){
            	jQuery('.search-box').fadeOut(300);
            	jQuery('.search-btn').removeClass('show-search-icon');
            } else {
            	jQuery('.search-box').fadeIn(300);
            	jQuery('.search-btn').addClass('show-search-icon');
            } 
        }); 
    }

    function handleUniform() {
        if (!jQuery().uniform) {
            return;
        }
        var test = jQuery("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
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
                closeBtn: false,
                scrolling   : 'no',
				arrows : false,
                helpers: {
                    title: {
                        type: 'inside'
                    }
                }
            });

            jQuery('.fancybox-video').fancybox({
                type: 'iframe',
				
            });
        }
    }
	
	// Handles scrollable contents using jQuery SlimScroll plugin.
    var handleScrollers = function () {
    	jQuery('.scroller').each(function () {
            var height;
            if ($(this).attr("data-height")) {
                height = $(this).attr("data-height");
            } else {
                height = $(this).css('height');
            }
            $(this).slimScroll({
                size: '7px',
                color: ($(this).attr("data-handle-color")  ? $(this).attr("data-handle-color") : '#a1b2bd'),
                railColor: ($(this).attr("data-rail-color")  ? $(this).attr("data-rail-color") : '#333'),
                position: isRTL ? 'left' : 'right',
                height: height,
                alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : false),
                railVisible: ($(this).attr("data-rail-visible") == "1" ? true : false),
                disableFadeOut: true
            });
        });
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
                    if (jQuery('body').hasClass("page-header-fixed") === false) {
                        return;
                    }
                    if( !didScroll ) {
                        didScroll = true;
                        setTimeout( scrollPage, 250 );
                    }
                }, false );
            }
        var docElem = document.documentElement,
        header = jQuery( '.navbar-inner' ),
        headerwrap = jQuery( '.front-header' ),
        slider = jQuery( '.slider-main' ),
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
	
	// Handle Select2 Dropdowns
    var handleSelect2 = function() {
        if (jQuery().select2) {
        	jQuery('.select2me').select2({
                placeholder: "Select",
                allowClear: true
            });
        }
    }
	
	// Handles the horizontal menu
    var handleHorizontalMenu = function () {
        //handle hor menu search form toggler click
    	jQuery('.header').on('click', '.hor-menu .hor-menu-search-form-toggler', function (e) {
            if (jQuery(this).hasClass('off')) {
            	jQuery(this).removeClass('off');
                jQuery('.header .hor-menu .search-form').hide();
            } else {
            	jQuery(this).addClass('off');
            	jQuery('.header .hor-menu .search-form').show();
            }
            e.preventDefault();
        });

        //handle hor menu search button click
    	jQuery('.header').on('click', '.hor-menu .search-form .btn', function (e) {
    		jQuery('.form-search').submit();
            e.preventDefault();
        });

        //handle hor menu search form on enter press
    	jQuery('.header').on('keypress', '.hor-menu .search-form input', function (e) {
            if (e.which == 13) {
            	jQuery('.form-search').submit();
                return false;
            }
        });
    }
	
	// Handles the filter menu
    var handleFilterMenu = function () {
        //handle hor menu search form toggler click
    	jQuery('.filter_class').on('click', '.hor-menu .hor-menu-search-form-toggler', function (e) {
            if ($(this).hasClass('off')) {
                $(this).removeClass('off');
                jQuery('.hor-menu .search-form').hide();
            } else {
            	jQuery(this).addClass('off');
            	jQuery('.hor-menu .search-form').show();
            }
            e.preventDefault();
        });

        //handle hor menu search button click
    	jQuery('.filter_class').on('click', '.hor-menu .search-form .btn', function (e) {
    		jQuery('.form-search').submit();
            e.preventDefault();
        });

        //handle hor menu search form on enter press
    	jQuery('.filter_class').on('keypress', '.hor-menu .search-form input', function (e) {
            if (e.which == 13) {
            	jQuery('.form-search').submit();
                return false;
            }
        });
    }
	

    var handleTheme = function () {
	
        var panel = jQuery('.color-panel');
	
        // handle theme colors
        var setColor = function (color) {
        	jQuery('#style_color').attr("href", "assets/css/themes/" + color + (isRTL ? '-rtl' : '') + ".css");
        	jQuery('#logoimg').attr("src", "assets/img/logo_" + color + ".png");
        	jQuery('#rev-hint1').attr("src", "assets/img/sliders/revolution/hint1-" + color + ".png");
        	jQuery('#rev-hint2').attr("src", "assets/img/sliders/revolution/hint2-" + color + ".png");
        }

        jQuery('.icon-color', panel).click(function () {
        	jQuery('.color-mode').show();
        	jQuery('.icon-color-close').show();
        });

        jQuery('.icon-color-close', panel).click(function () {
        	jQuery('.color-mode').hide();
        	jQuery('.icon-color-close').hide();
        });

        jQuery('li', panel).click(function () {
            var color = $(this).attr("data-style");
            setColor(color);
            $('.inline li', panel).removeClass("current");
            $(this).addClass("current");
        });
		
        jQuery('.header-option', panel).change(function(){
			if(jQuery('.header-option').val() == 'fixed'){
				jQuery("body").addClass("page-header-fixed");
				jQuery('.header').addClass("navbar-fixed-top").removeClass("navbar-static-top");
				App.scrollTop();
				
			} else if(jQuery('.header-option').val() == 'default'){
				jQuery("body").removeClass("page-header-fixed");
				jQuery('.header').addClass("navbar-static-top").removeClass("navbar-fixed-top");
				jQuery('.navbar-inner').removeClass('navbar-inner-shrink');
				jQuery('.front-header').removeClass('front-header-shrink');
				App.scrollTop();
			}
		});
		
	}
    
    var handleCarousel_front = function() {
    	var height_wrapper = jQuery('#myCarousel').height();
    	var height_carousel = jQuery('div.front-carousel').height();
    	
    	//console.log(height_wrapper + ' - ' + height_carousel);
    	
    	var difference = parseInt(height_wrapper) - parseInt(height_carousel);
    	if (difference > 0) {
    		//$('.front-carousel').css({'margin-top':'87px'});
    		//$('.front-carousel').offset({top:(difference+height_carousel)});
    	}
    }
	
    return {
        init: function () {
            handleInit();
            handleBootstrap();
            handleIEFixes();
            handleMisc();
			handleSelect2();
			handleScrollers(); // handles slim scrolling contents 
			handleHorizontalMenu(); // handles horizontal menu
			handleFilterMenu();
            handleSearch();
			handleTheme(); // handles style customer tool
            handleFancybox();
			handleFixedHeader();
			handleCarousel_front();
			handleDirectory();
        },        
        

        initUniform: function (els) {
            if (els) {
                jQuery(els).each(function () {
                        if (jQuery(this).parents(".checker").size() == 0) {
                        	jQuery(this).show();
                        	jQuery(this).uniform();
                        }
                    });
            } else {
                handleUniform();
            }
        },

        initBxSlider: function () {
        	jQuery('.bxslider').show();
        	jQuery('.bxslider').bxSlider({
                minSlides: 3,
                maxSlides: 3,
                slideWidth: 360,
                slideMargin: 10,
                moveSlides: 1,
                responsive: true,
            });

        	jQuery('.bxslider1').show();            
        	jQuery('.bxslider1').bxSlider({
                minSlides: 6,
                maxSlides: 6,
                slideWidth: 360,
                slideMargin: 2,
                moveSlides: 1,
                responsive: true,
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
        	jQuery(function(){
        		jQuery('.grid-v1').mixitup();
            });    
        },
		
		 //public function to get a paremeter by name from URL
        getURLParameter: function (paramName) {
            var searchString = window.location.search.substring(1),
                i, val, params = searchString.split("&");

            for (i = 0; i < params.length; i++) {
                val = params[i].split("=");
                if (val[0] == paramName) {
                    return unescape(val[1]);
                }
            }
            return null;
        },

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
    	jQuery('body').on('shown.bs.tab', '.nav.nav-tabs', function () {
            handleSidebarAndContentHeight();
        });

        //activate tab if tab id provided in the URL
        if (location.hash) {
            var tabid = location.hash.substr(1);
            jQuery('a[href="#' + tabid + '"]').click();
        }
    }
}();