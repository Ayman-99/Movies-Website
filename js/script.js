/**
 * The script is encapsulated in an self-executing anonymous function,
 * to avoid conflicts with other libraries
 */
$(window).on('load', function () {
    /*------------------
     Preloder
     --------------------*/
    $(".loader").fadeOut();
    $("#preloder").delay(400).fadeOut("slow");

});
(function($) {


	/**
	 * Declare 'use strict' to the more restrictive code and a bit safer,
	 * sparing future problems
	 */
	"use strict";



	/***********************************************************************/
	/*****************************  $Content  ******************************/
	/**
	* + Content
	* + Animate Itemas on Start
	* + Isotope
	* + Menu Animation
	* + One Page Scroll
	* + Owl Carousel
	* + Preloader
	* + Newsletter and Register
	* + Sticky menu
	* + Tootips
	*/




	/*********************  $Animate Itemas on Start  **********************/
	$('.animated').appear(function() {
		var elem = $(this);
		var animation = elem.data('animation');
		if ( !elem.hasClass('visible') ) {
			var animationDelay = elem.data('animation-delay');
			
			if ( animationDelay ) {
				setTimeout(function(){
					elem.addClass( animation + " visible" );
				}, animationDelay);

			} else {
				elem.addClass( animation + " visible" );

			}
		}
	});



	/*****************************  $Isotope  ******************************/
	function startIsotope(){
		// cache container
		var $container = $('.premium-tv-grid');
		
		// initialize isotope
		if(jQuery().isotope) {
 			$container.isotope();
		}

		$('.filters a').click(function(e){
			e.preventDefault();
			
			$('.filters a').removeClass('active');
			$(this).addClass('active');
						
			refreshIsotope();
		});

		function refreshIsotope() {
			var $filters = $('.filters a.active'),
				selectors = '';

			$filters.each(function( index ) {
				if (selectors != ''){selectors += ', '}
				selectors += $( this ).attr('data-filter');
			});

			$container.isotope({ filter: selectors });
		}
	}

	$(window).load( startIsotope() );



	/**************************  $Menu Animation  **************************/
	if ($(window).width() >= 768) {
		$('.dropdown').hover(function() {
			$(this)
					.find('.dropdown-menu')
					.first()
					.stop(true, true)
					.delay(100)
					.fadeIn()
					.slideDown('fast')
		}, function() {
			$(this)
					.find('.dropdown-menu')
					.first()
					.stop(true, true)
					.delay(250)
					.fadeOut()
					.slideUp('slow')
		});
	}



	/*************************  $One Page Scroll  **************************/
	$('.navbar-nav').onePageNav({
		currentClass: 'active',
		filter: ':not(.exclude)',
	});



	/***************************  $Owl Carousel  ***************************/
	$("#carousel-testimonials").owlCarousel({
		slideSpeed: 300,
		paginationSpeed: 400,
		singleItem: true
	});
	$("#carousel-testimonials").find('.owl-pagination').append('<div class="owl-page"><!-- dummy dot --></div>');



	/****************************  $Preloader  *****************************/
	$(window).load(function() {
		$('#preloader').fadeOut('slow'); 
	});


	/****************************  $Newsletter and Register  *****************************/
    $("#newsletter, #register").submit(function() {
        var elem = $(this);
        var urlTarget = $(this).attr("action");
        $.ajax({
            type : "POST",
            url : urlTarget,
            dataType : "html",
            data : $(this).serialize(),
            beforeSend : function() {
                elem.prepend("<div class='loading alert'>" + "<a class='close' data-dismiss='alert'>×</a>" + "Loading" + "</div>");
                //elem.find(".loading").show();
            },
            success : function(response) {
                elem.prepend(response);
                //elem.find(".response").html(response);
                elem.find(".loading").hide();
                elem.find("input[type='text'],input[type='email'],textarea").val("");
            }
        });
        return false;
    });


	/***************************  $Sticky menu  ****************************/
	$("header").sticky({topSpacing:0, wrapperClassName: 'stickyWrapper'});



	/*****************************  $Tootips  ******************************/
	function changeTooltipColorTo(color) {
		//solution from: http://stackoverflow.com/questions/12639708/modifying-twitter-bootstraps-tooltip-colors-based-on-position
		$('.tooltip-inner').css('background-color', color)
		$('.tooltip.top .tooltip-arrow').css('border-top-color', color);
		$('.tooltip.right .tooltip-arrow').css('border-right-color', color);
		$('.tooltip.left .tooltip-arrow').css('border-left-color', color);
		$('.tooltip.bottom .tooltip-arrow').css('border-bottom-color', color);
	}


	$('.device a').tooltip({placement: 'bottom'})
	$('.device a').hover(function() {changeTooltipColorTo('#01b9ff')});

	$('.social a').tooltip({placement: 'top'})
	$('.social a').hover(function() {changeTooltipColorTo('#01b9ff')});


	/*************************  $Video Background  *************************/
	$(".player").mb_YTPlayer();
	$("#bgndVideo").hide();


})(jQuery);
