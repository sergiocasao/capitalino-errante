/* !
 * Customizr WordPress theme Javascript code
 * Copyright (c) 2014-2015 Nicolas GUILLAUME (@nicguillaume), Themes & Co.
 * GPL2+ Licensed
*/
//ON DOM READY
jQuery(function ($) {
    var _p = TCParams;

    //CENTER VARIOUS IMAGES
    setTimeout( function() {
      //Featured Pages
      $('.widget-front .thumb-wrapper').centerImages( {
        enableCentering : 1 == _p.centerAllImg,
        enableGoldenRatio : false,
        disableGRUnder : 0,//<= don't disable golden ratio when responsive
        zeroTopAdjust : 1,
        leftAdjust : 2.5,
        oncustom : ['smartload', 'simple_load']
      });
      //POST LIST THUMBNAILS + FEATURED PAGES
      //Squared, rounded
      $('.thumb-wrapper', '.hentry' ).centerImages( {
        enableCentering : 1 == _p.centerAllImg,
        enableGoldenRatio : false,
        disableGRUnder : 0,//<= don't disable golden ratio when responsive
        oncustom : ['smartload', 'simple_load']
      });

      //rectangulars
      $('.tc-rectangular-thumb').centerImages( {
        enableCentering : 1 == _p.centerAllImg,
        enableGoldenRatio : true,
        disableGRUnder : 0,//<= don't disable golden ratio when responsive
        oncustom : ['smartload', 'refresh-height', 'simple_load'], //bind 'refresh-height' event (triggered to the the customizer preview frame)
      });

      //SINGLE POST THUMBNAILS
      $('.tc-rectangular-thumb' , '.single').centerImages( {
        enableCentering : 1 == _p.centerAllImg,
        enableGoldenRatio : false,
        disableGRUnder : 0,//<= don't disable golden ratio when responsive
        oncustom : ['smartload', 'refresh-height', 'simple_load'], //bind 'refresh-height' event (triggered to the the customizer preview frame)
      });

      //POST GRID IMAGES
      $('.tc-grid-figure').centerImages( {
        enableCentering : 1 == _p.centerAllImg,
        oncustom : ['smartload', 'simple_load'],
        enableGoldenRatio : true,
        goldenRatioLimitHeightTo : _p.gridGoldenRatioLimit || 350
      } );
    }, 300 );

    //helper to trigger a simple load
    //=> allow centering when smart load not triggered by smartload
    var _trigger_simple_load = function( $_imgs ) {
      if ( 0 === $_imgs.length )
        return;

      $_imgs.map( function( _ind, _img ) {
        $(_img).load( function () {
            $(_img).trigger('simple_load');
        });//end load
        if ( $(_img)[0] && $(_img)[0].complete )
          $(_img).load();
      } );//end map
    };//end of fn


    //SLIDER IMG + VARIOUS
    //adds a specific class to the carousel when automatic centering is enabled
    $('#customizr-slider .carousel-inner').addClass('center-slides-enabled');

    setTimeout( function() {
      $( '.carousel .carousel-inner').centerImages( {
        enableCentering : 1 == _p.centerSliderImg,
        imgSel : '.item .carousel-image img',
        oncustom : ['slid', 'simple_load'],
        defaultCSSVal : { width : '100%' , height : 'auto' },
        useImgAttr : true
      } );
      $('.tc-slider-loader-wrapper').hide();
    } , 50);

    _trigger_simple_load( $( '.carousel .carousel-inner').find('img') );


    //IMG SMART LOAD
    //.article-container covers all post / page content : single and list
    //__before_main_wrapper covers the single post thumbnail case
    //.widget-front handles the featured pages
    if ( 1 == _p.imgSmartLoadEnabled )
      $( '.article-container, .__before_main_wrapper, .widget-front' ).imgSmartLoad( _.size( _p.imgSmartLoadOpts ) > 0 ? _p.imgSmartLoadOpts : {} );
    else {
      //if smart load not enabled => trigger the load event on img load
      var $_to_center = $( '.article-container, .__before_main_wrapper, .widget-front' ).find('img');
      _trigger_simple_load($_to_center);
    }//end else


    //DROP CAPS
    if ( _p.dropcapEnabled && 'object' == typeof( _p.dropcapWhere ) ) {
      $.each( _p.dropcapWhere , function( ind, val ) {
        if ( 1 == val ) {
          $( '.entry-content' , 'body.' + ( 'page' == ind ? 'page' : 'single-post' ) ).children().first().addDropCap( {
            minwords : _p.dropcapMinWords,//@todo check if number
            skipSelectors : _.isObject(_p.dropcapSkipSelectors) ? _p.dropcapSkipSelectors : {}
          });
        }
      });
    }

    //EXT LINKS
    //May be add (check if activated by user) external class + target="_blank" to relevant links
    //images are excluded by default
    //links inside post/page content
    if ( _p.extLinksStyle || _p.extLinksTargetExt ) {
      $('a' , '.entry-content').extLinks({
        addIcon : _p.extLinksStyle,
        newTab : _p.extLinksTargetExt,
        skipSelectors : _.isObject(_p.extLinksSkipSelectors) ? _p.extLinksSkipSelectors : {}
      });
    }



    //FANCYBOX
    //Fancybox with localized script variables
    var b = _p.FancyBoxState,
        c = _p.FancyBoxAutoscale;
    if ( 1 == b ) {
            $("a.grouped_elements").fancybox({
            transitionOut: "elastic",
            transitionIn: "elastic",
            speedIn: 200,
            speedOut: 200,
            overlayShow: !1,
            autoScale: 1 == c ? "true" : "false",
            changeFade: "fast",
            enableEscapeButton: !0
         });
         //replace title by img alt field
         $('a[rel*=tc-fancybox-group]').each( function() {
            var title = $(this).find('img').prop('title');
            var alt = $(this).find('img').prop('alt');
            if (typeof title !== 'undefined' && 0 !== title.length) {
                $(this).attr('title',title);
            }
            else if (typeof alt !== 'undefined' &&  0 !== alt.length) {
                $(this).attr('title',alt);
            }
         });
    }


    //Slider with localized script variables
    var d = _p.SliderName,
        e = _p.SliderDelay;
        j = _p.SliderHover;

    if (0 !== d.length) {
        if (0 !== e.length && !j) {
            $("#customizr-slider").carousel({
                interval: e,
                pause: "false"
            });
        } else if (0 !== e.length) {
            $("#customizr-slider").carousel({
                interval: e
            });
        } else {
            $("#customizr-slider").carousel();
        }
    }

    //add a class to the slider on hover => used to display the navigation arrow
    $(".carousel").hover( function() {
            $(this).addClass('tc-slid-hover');
        },
        function() {
            $(this).removeClass('tc-slid-hover');
        }
    );

    //Smooth scroll but not on bootstrap buttons. Checks if php localized option is active first.
    var SmoothScroll = _p.SmoothScroll;

    if ('easeOutExpo' == SmoothScroll) {
        $('a[href^="#"]', '#content').not('[class*=edd], .tc-carousel-control, .carousel-control, [data-toggle="modal"], [data-toggle="dropdown"], [data-toggle="tooltip"], [data-toggle="popover"], [data-toggle="collapse"], [data-toggle="tab"]').click(function () {
            var anchor_id = $(this).attr("href");
            if ('#' != anchor_id) {
                $('html, body').animate({
                    scrollTop: $(anchor_id).offset().top
                }, 700, SmoothScroll);
            }
            return false;
        });
    }

    //BACK TO TOP
    function g($) {
        return ($.which > 0 || "mousedown" === $.type || "mousewheel" === $.type) && f.stop().off("scroll mousedown DOMMouseScroll mousewheel keyup", g);
    }
    //Stop the viewport animation if user interaction is detected
    var f = $("html, body");
    $(".back-to-top, .tc-btt-wrapper, .btt-arrow").on("click touchstart touchend", function ($) {
            f.on("scroll mousedown DOMMouseScroll mousewheel keyup", g);
            f.animate({
                scrollTop: 0
            }, 1e3, function () {
                f.stop().off("scroll mousedown DOMMouseScroll mousewheel keyup", g);
                //$(window).trigger('resize');
            });
            $.preventDefault();
    });


    //DISPLAY BACK TO TOP BUTTON ON SCROLL
    function btt_scrolling_actions() {
      if ( $(window).scrollTop() > 100 )
        $('.tc-btt-wrapper').addClass('show');
      else
        $('.tc-btt-wrapper').removeClass('show');
    }
    //use of a timer instead of attaching handler directly to the window scroll event
    //@uses _p.timerOnScrollAllBrowsers : boolean set to true by default
    //http://ejohn.org/blog/learning-from-twitter/
    //https://dannyvankooten.com/delay-scroll-handlers-javascript/
    var btt_timer,
        btt_increment = 1,//used to wait a little bit after the first user scroll actions to trigger the timer
        btt_triggerHeight = 20; //0.5 * windowHeight;

    $(window).scroll(function() {
      if ( btt_timer) {
          btt_increment++;
          window.clearTimeout(btt_timer);
      }
      if ( 1 == _p.timerOnScrollAllBrowsers ) {
          btt_timer = window.setTimeout(function() {
              btt_scrolling_actions();
           }, btt_increment > 5 ? 50 : 0 );
      } else if ( $('body').hasClass('ie') ) {
           btt_timer = window.setTimeout(function() {
              btt_scrolling_actions();
           }, btt_increment > 5 ? 50 : 0 );
      }
    });//end of window.scroll()



    //Detects browser with CSS
    // Chrome is Webkit, but Webkit is also Safari. If browser = ie + strips out the .0 suffix
    if ( $.browser.chrome )
        $("body").addClass("chrome");
    else if ( $.browser.webkit )
        $("body").addClass("safari");
    else if ( $.browser.msie || '8.0' === $.browser.version || '9.0' === $.browser.version || '10.0' === $.browser.version || '11.0' === $.browser.version )
        $("body").addClass("ie").addClass("ie" + $.browser.version.replace(/[.0]/g, ''));

    //Adds version if browser = ie
    if ( $("body").hasClass("ie") )
        $("body").addClass($.browser.version);


    //handle some dynamic hover effects
    $(".widget-front, article").hover(function () {
        $(this).addClass("hover");
    }, function () {
        $(this).removeClass("hover");
    });

    $(".widget li").hover(function () {
        $(this).addClass("on");
    }, function () {
        $(this).removeClass("on");
    });

    $("article.attachment img").delay(500).animate({
            opacity: 1
        }, 700, function () {}
    );

    //Change classes of the comment reply and edit to make the whole button clickable (no filters offered in WP to do that)
    if ( _p.HasComments ) {
       //edit
       $('cite p.edit-link').each(function() {
            $(this).removeClass('btn btn-success btn-mini');
       });
       $('cite p.edit-link > a').each(function() {
            $(this).addClass('btn btn-success btn-mini');
       });
       //reply
       $('.comment .reply').each(function() {
            $(this).removeClass('btn btn-small');
       });
       $('.comment .reply .comment-reply-link').each(function() {
            $(this).addClass('btn btn-small');
       });
    }


    //Detect layout and reorder content divs
    var LeftSidebarClass    = _p.LeftSidebarClass || '.span3.left.tc-sidebar',
        RightSidebarClass   = _p.RightSidebarClass || '.span3.right.tc-sidebar',
        wrapper             = $('#main-wrapper .container[role=main] > .column-content-wrapper'),
        content             = $("#main-wrapper .container .article-container"),
        left                = $("#main-wrapper .container " + LeftSidebarClass),
        right               = $("#main-wrapper .container " + RightSidebarClass),
        reordered           = false;

    function BlockPositions() {
        //15 pixels adjustement to avoid replacement before real responsive width
        WindowWidth = $(window).width();
        if ( WindowWidth > 767 - 15 && reordered ) {
            //$(window).width();
            if ( $(left).length ) {
                $(left).detach();
                $(content).detach();
                $(wrapper).append($(left)).append($(content));
            }
            if ( $(right).length ) {
                $(right).detach();
                $(wrapper).append($(right));
            }
            reordered = false; //this could stay in both if blocks instead
        } else if ( ( WindowWidth <= 767 - 15 ) && ! reordered ) {
            if ( $(left).length ) {
                 $(left).detach();
                $(content).detach();
                $(wrapper).append($(content)).append( $(left) );
            }
            if ( $(right).length ) {
                $(right).detach();
                $(wrapper).append($(right));
            }
            reordered = true; //this could stay in both if blocks instead
        }
    }//end function

    //Enable reordering if option is checked in the customizer.
    if ( 1 == _p.ReorderBlocks ) {
        //trigger the block positioning only when responsive
        WindowWidth = $(window).width();
        if ( WindowWidth <= 767 - 15 && ! reordered ) {
            BlockPositions();
        }

        $(window).resize(function () {
            setTimeout(BlockPositions, 200);
        });
    }

    //SLIDER ARROWS
    function _center_slider_arrows() {
        if ( 0 === $('.carousel').length )
            return;
        $('.carousel').each( function() {
            var _slider_height = $( '.carousel-inner' , $(this) ).height();
            $('.tc-slider-controls', $(this) ).css("line-height", _slider_height +'px').css("max-height", _slider_height +'px');
        });
    }
    //Recenter the slider arrows
    $(window).resize(function(){
        _center_slider_arrows();
    });
    _center_slider_arrows();


    //Slider swipe support with hammer.js
    if ( 'function' == typeof($.fn.hammer) ) {

        //prevent propagation event from sensible children
        $(".carousel input, .carousel button, .carousel textarea, .carousel select, .carousel a").
            on("touchstart touchmove", function(ev) {
                ev.stopPropagation();
        });

        $('.carousel' ).each( function() {
            $(this).hammer().on('swipeleft tap', function() {
                $(this).carousel('next');
            });
            $(this).hammer().on('swiperight', function(){
                $(this).carousel('prev');
            });
        });
    }

    //Handle dropdown on click for multi-tier menus
    var $dropdown_ahrefs    = $('.tc-open-on-click .menu-item.menu-item-has-children > a[href!="#"]'),
        $dropdown_submenus  = $('.tc-open-on-click .dropdown .dropdown-submenu');


    // go to the link if submenu is already opened
    $dropdown_ahrefs.on('tap click', function(evt) {
        if ( ( $(this).next('.dropdown-menu').css('visibility') != 'hidden' &&
                $(this).next('.dropdown-menu').is(':visible')  &&
                ! $(this).parent().hasClass('dropdown-submenu') ) ||
             ( $(this).next('.dropdown-menu').is(':visible') &&
                $(this).parent().hasClass('dropdown-submenu') ) )
            window.location = $(this).attr('href');
    });
    // make sub-submenus dropdown on click work
    $dropdown_submenus.each(function(){
        var $parent = $(this),
            $children = $parent.children('[data-toggle="dropdown"]');
        $children.on('tap click', function(){
            var submenu   = $(this).next('.dropdown-menu'),
                openthis  = false;
            if ( ! $parent.hasClass('open') ) {
              openthis = true;
            }
            // close opened submenus
            $($parent.parent()).children('.dropdown-submenu').each(function(){
                $(this).removeClass('open');
            });
            if ( openthis )
                $parent.addClass('open');

            return false;
        });
    });
});


/* Sticky header since v3.2.0 */
jQuery(function ($) {
    var   _p              = TCParams,
          $tcHeader       = $('.tc-header'),
          elToHide        = [], //[ '.social-block' , '.site-description' ],
          isUserLogged    = $('body').hasClass('logged-in') || 0 !== $('#wpadminbar').length,
          isCustomizing   = $('body').hasClass('is-customizing'),
          customOffset    = +_p.stickyCustomOffset,
          logosH     = [],
          logosW      = [],
          logosRatio      = [];

    function _is_scrolling() {
        return $('body').hasClass('sticky-enabled') ? true : false;
    }

    function _is_sticky_enabled() {
        return $('body').hasClass('tc-sticky-header') ? true : false;
    }

    function _get_initial_offset() {
        //initialOffset     = ( 1 == isUserLogged &&  580 < $(window).width() ) ? $('#wpadminbar').height() : 0;
        var initialOffset   = 0;
        if ( 1 == isUserLogged && ! isCustomizing ) {
            if ( 580 < $(window).width() )
                initialOffset = $('#wpadminbar').height();
            else
                initialOffset = ! _is_scrolling() ? $('#wpadminbar').height() : 0;
        }
        return initialOffset + customOffset;
    }

    function _set_sticky_offsets() {
        if ( ! _is_sticky_enabled() )
            return;

        //Reset all values first
        $tcHeader.css('top' , '');
        $('.tc-header').css('height' , 'auto' );
        $('#tc-reset-margin-top').css('margin-top' , '' ).show();

        //What is the initial offset of the header ?
        var headerHeight    = $tcHeader.height();
        //set initial margin-top = initial offset + header's height
        $('#tc-reset-margin-top').css('margin-top' , ( +headerHeight + customOffset ) + 10 + 'px' ); //10 = header bottom border
    }


    function _set_header_top_offset() {
        //set header initial offset
        $tcHeader.css('top' , _get_initial_offset() );
    }


    function _set_logo_height(){
        if ( 0 === $('img' , '.site-logo').length )
            return;
        $.each($('img', '.site-logo'), function( $i ){
            if ( ! logosRatio[$i] )
              return;
            var logoHeight   = $(this).width() / logosRatio[$i];
            $(this).css('height' , logoHeight );
        });
        setTimeout( function() {
            _set_sticky_offsets();
            _set_header_top_offset();
        } , 200 );
    }


    //set site logo width and height if exists
    //=> allow the CSS3 transition to be enabled
    if ( _is_sticky_enabled() && 0 !== $('img' , '.site-logo').length ) {
        $.each($('img', '.site-logo'), function( $i ){
            logosW[$i]  = $(this).attr('width');
            logosH[$i]  = $(this).attr('height');

            //check that all numbers are valid before using division
            if ( 0 === _.size( _.filter( [ logosW[$i], logosH[$i] ], function(num){ return _.isNumber(num) && 0 !== num; } ) ) )
              return;

            logosRatio[$i]  = logosW[$i] / logosH[$i];
            $(this).css('height' , logosH[$i]  ).css('width' , logosW[$i] );
        });
    }

    //LOADING ACTIONS
    if ( _is_sticky_enabled() )
        setTimeout( function() { _refresh(); } , 20 );

    //RESIZING ACTIONS
    $(window).resize(function() {
        if ( ! _is_sticky_enabled() )
            return;
        _set_sticky_offsets();
        _set_header_top_offset();
        _set_logo_height();
    });

    function _refresh() {
        setTimeout( function() {
            _set_sticky_offsets();
            _set_header_top_offset();
        } , 20 );
        $(window).trigger('resize');
    }

    //SCROLLING ACTIONS
    var timer,
        increment = 1;//used to wait a little bit after the first user scroll actions to trigger the timer

    //var windowHeight = $(window).height();
    var triggerHeight = 20; //0.5 * windowHeight;

    function _scrolling_actions() {
        _set_header_top_offset();
        //process scrolling actions
        if ( $(window).scrollTop() > triggerHeight ) {
            $('body').addClass("sticky-enabled").removeClass("sticky-disabled");
        }
        else {
            $('body').removeClass("sticky-enabled").addClass("sticky-disabled");
            setTimeout( function() { _refresh();} ,
              $('body').hasClass('is-customizing') ? 100 : 20
            );
            //additional refresh for some edge cases like big logos
            setTimeout( function() { _refresh(); } , 200 );
        }
    }//end of fn

    $(window).scroll(function() {
        if ( ! _is_sticky_enabled() )
            return;
        //use a timer
        if ( timer) {
            increment++;
            window.clearTimeout(timer);
         }

         if ( 1 == _p.timerOnScrollAllBrowsers ) {
            timer = window.setTimeout(function() {
                _scrolling_actions();
             }, increment > 5 ? 50 : 0 );
         } else if ( $('body').hasClass('ie') ) {
             timer = window.setTimeout(function() {
                _scrolling_actions();
             }, increment > 5 ? 50 : 0 );
        }
    });//end of window.scroll()
});