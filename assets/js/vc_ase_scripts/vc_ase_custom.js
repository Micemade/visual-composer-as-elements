(function() {
"use strict";
//
/*********************************************************
 *	MICEMADE FUNCTION DEFINITIONS
 ********************************************************/
/**
 *	FILTER ITEMS (Isotope) :
 *	var function filterItems
 *	var arg container
 *	var arg filter
 */
 (function( $ ){
	
	window.filterItems = function( container, filter ) {
		
		container.imagesLoaded( function(){
		// init Isotope
			container.isotope({
				itemSelector: '.item',
				layoutMode: 'masonry',
				containerStyle: {
					position: 'relative',
					overflow: 'hidden'
				},
				transitionDuration: '0.5s'
			});
			// filter items on button click
			if( filter ) {
				filter.on( 'click', 'a', function() {
					var filterValue = $(this).attr('data-filter');
					container.isotope({ filter: filterValue });
				});				
			}
			
			//container.on( 'arrangeComplete', function() { Foundation.libs.equalizer.reflow(); console.log("Finished"); } );
			container.on( 'arrangeComplete', function() { 
				$(document).foundation('equalizer', 'reflow');
				$.waypoints('refresh');
				} );
		
		});
	};
	
})( jQuery );
/**
 *	OWL SLIDERS:
 *	var function vcase_contentSlides
 *	var arg slidesObj
 */
(function( $ ){
	
	window.vcase_contentSlides = function( slidesObj ) {
		
		var	config	= slidesObj.prev('input.slides-config');
		
		var cs_navig	= config.attr('data-navigation'),
			cs_pagin	= config.attr('data-pagination'),
			cs_auto		= config.attr('data-auto'),
			sc_desk		= config.attr('data-desktop'),
			sc_tablet	= config.attr('data-tablet'),
			sc_mobile	= config.attr('data-mobile'),
			sc_loop		= config.attr('data-loop');
		
		$(document).foundation('equalizer');
		
		//WHEN CAROUSEL IS INITALIZED (must be before owlCarousel() call):	
		$(window).on('initialized.owl.carousel', slidesObj,function(event) {
			Foundation.libs.equalizer.reflow();
		});
		//WHEN CAROUSEL IS RESIZED (must be before owlCarousel() call):	
		$(window).on('resized.owl.carousel', slidesObj,function(event) {
			Foundation.libs.equalizer.reflow();
		});
		// OWL 2
		slidesObj.owlCarousel({
			//loop:true,
			margin:0,
			navRewind: true,
			responsiveClass:true,
			nav: cs_navig == '1' ? true : false,
			dots:  cs_pagin == '1' ? true : false,
			autoplay:  cs_auto ? true : false,
			autoplayTimeout:  cs_auto  ? cs_auto : 0,
			autoplayHoverPause: true,
			navText: ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
			responsive:{
				0:{
					items:sc_mobile ? sc_mobile : 1,
					nav:true
				},
				600:{
					items:sc_tablet ? sc_tablet : 2,
					nav:false
				},
				1000:{
					items: sc_desk ? sc_desk : 3,
					nav:cs_navig	==	'1' ? true : false,
					loop: sc_loop	==	'1' ? sc_loop : false
				}
			}
		});
					
	}; // end 
	
})( jQuery );
//
/**
 *	SLIDERS NAV ARROWS:
 *	var vcase_moveArrows (function)
 */
(function( $ ){
	window.vcase_moveArrows = function ( relHolder, arrows ){
			
		relHolder.on( 'mousemove',function(e){
			
			var parentOffset = $j(this).offset(),
				nav = $j(this).find( arrows ),
				navM = Math.abs( parseInt(nav.css("margin-top")) /2 ); 
			
			//or $(this).offset(); if you really just want the current element's offset
			var relY = e.pageY - parentOffset.top;
			
			nav.each(function(){
				$j(this).css("top", relY + navM );
			});
		
		});
		
	};
})( jQuery );

/*********************************************************
 *	AS FUNCTIONS AND PLUGINS CALLS
 ********************************************************/
var $j = jQuery.noConflict();
$j(document).ready(function() {
	
	/***************************************
	 *
	 *	DO THE FOUNDATION SCRIPTS:	
	 *
	 *************************************/
	$j(document).foundation();
	/**
	 *	INTERNET EXPLORERS "SNIFFER":
	 *
	 */
	var ua = navigator.userAgent,
		isIE11	= ua.match(/Trident\/7\./), //  is Internet Explorer 11
		isIE10	= /MSIE 10.0/.test(ua), //  is Internet Explorer 10
		isIE9	= /MSIE 9.0/.test(ua), //  is Internet Explorer 9
		isMobWebkit = /WebKit/.test(ua) && /Mobile/.test(ua); //  is iPad / iPhone
	
	if( isIE9 ) {
		$j('html').addClass('ie9');
	}else if( isIE10 ) {
		$j('html').addClass('ie10');
	}else if( isIE11 ) {
		$j('html').addClass('ie11');
	}
 

/**	
 *	REMOVE CLASS TO ANIM FOR MOBILE DEVICES
 * 	no viewport entering animation
 *
 */	
	if( window.vcase_isMobile ) {
		$j('.to-anim').removeClass('to-anim');
	
	}
	


	/**
	 *	BEGIN ON WINDOW LOAD 
	 *
	 */	
	
	$j(window).load(function(){
		
		/**
		 *	BANNER and PRODUCT CATEGORIES ANIMATE COLOR (transitions in css)
		 *
		 */ 
		
		$j('.banner-block').each(function () {
		
			 var $this= $j(this);
			
			if( $this.hasClass('disable-invert') ) {
			
				return;
				
			}else{
				// from block settings:
				var fontSet	= $this.find('.varsHolder').attr('data-fontColor'),
					boxSet	= $this.find('.varsHolder').attr('data-boxColor');
				
				// define all inner elements:
				var box			= $this.find('.item-overlay'),
					title		= $this.find('.box-title, .block-title'),
					text		= $this.find('.text'),
					subtitle	= $this.find('.block-subtitle');
					
				// get elem. default vaules:
				var box_Def			= box.css('background-color'),
					title_Def		= title.css('color'),
					text_Def		= text.css('color'),
					subtitle_Def 	= subtitle.css('color');
					
				//invert values on hover:
				$this.hover(
					function (){

						if(fontSet)	{ box.css('background-color', fontSet);}else{ box.css('background-color', title_Def);}
						if( $this.hasClass("banner-block") ){
							if(boxSet) { title.css('color', boxSet); }else{ title.css('color', box_Def);}
						}					
						
						if(boxSet) { text.css('color', boxSet); }else{ text.css('color', box_Def); }  
						if(boxSet) { subtitle.css('color', boxSet); }else{ subtitle.css('color', box_Def);} 

						},
					function () {
						
						if(boxSet) { box.css('background-color', boxSet); }else{ box.css('background-color', box_Def); }  
						if( $this.hasClass("banner-block") ) {
							if(fontSet) { title.css('color', fontSet); }else{  title.css('color', title_Def); }
						}
									
						if(fontSet) { text.css('color', fontSet); }else{ text.css('color', text_Def); }  	
						if(fontSet) { subtitle.css('color', fontSet); }else{ subtitle.css('color',subtitle_Def); } 

						}
				);
			
			} // end if
		
		});
		
		/**
		 *	PRETTYPHOTO
		 *
		 */
				
		$j('#review_form_wrapper').hide();
					
			$j('a[data-gal^="prettyPhoto"]').prettyPhoto(
				{	theme: 				'as_default',
					slideshow:			5000, 
					social_tools:		false,
					autoplay_slideshow:	false,
					show_title:			false,
					deeplinking:		false,
					markup: 			'<div class="pp_pic_holder">'+
								'<div class="ppt">&nbsp;</div>'+
								'<div class="pp_top">'+
									'<div class="pp_left"></div>'+
									'<div class="pp_middle"></div>'+
									'<div class="pp_right"></div>'+
								'</div>'+
								'<div class="pp_content_container">'+
									'<div class="pp_left">'+
									'<div class="pp_right">'+
										'<div class="pp_content">'+
											'<div class="pp_loaderIcon"></div>'+
											'<div class="pp_fade">'+
											'<a href="#" class="pp_expand" title="Expand the image"></a>'+
											'<a class="pp_close" href="#"></a>'+
												'<div class="pp_hoverContainer">'+
													'<a class="pp_next" href="#"></a>'+
													'<a class="pp_previous" href="#"></a>'+
												'</div>'+
												'<div id="pp_full_res"></div>'+
												'<div class="pp_details">'+
													'<div class="pp_nav">'+
														'<a href="#" class="pp_arrow_previous"></a>'+
														'<p class="currentTextHolder">0/0</p>'+
														'<a href="#" class="pp_arrow_next"></a>'+
													'</div>'+
													'<p class="pp_description"></p>'+
													'{pp_social}'+
												'</div>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'</div>'+
								'</div>'+
								'<div class="pp_bottom">'+
									'<div class="pp_left"></div>'+
									'<div class="pp_middle"></div>'+
									'<div class="pp_right"></div>'+
								'</div>'+
							'</div>'+
							'<div class="pp_overlay"></div>',
						ajaxcallback: function(){
							if( $j("video,audio").length ) {
								$j("video,audio").mediaelementplayer();
							}
						}
				});
				
	/** END PRETTYPHOTO */



	/**
	 *	STICKY ONEPAGER MENU
	 *		
	 **/		
			
	/* 		
		$j('.sticky-block').waypoint('sticky', { 
			stuckClass: 'stuck', 
			offset: 1,
			handler:	function(){
				var stickyBlock		= $j('.sticky-block'),
					stickHeader		= $j('.stick-it-header'),
					stickHeadHeight = stickHeader.outerHeight(true),
					wpadminbarH		= $j('#wpadminbar').outerHeight(true);
				
					stickyBlock.css('top', stickHeadHeight + wpadminbarH );
				}
		});


		function correctStickyWidth() {
		
			var stickyBlock = $j('.sticky-block');
			stickyBlock.width( stickyBlock.parent().width() );
			
			stickyBlock.parent().closest('.aq-block').css('z-index', '10');
			
		}
		
		function correctStickyTop() { // same function as handler in waypoint 
		
			var stickyBlock		= $j('.sticky-block'),
				stickHeader		= $j('.stick-it-header'),
				stickHeadHeight = stickHeader.outerHeight(true),
				wpadminbarH		= $j('#wpadminbar').outerHeight(true);
			
			stickyBlock.css('top', stickHeadHeight + wpadminbarH );
		}
		
		$j( window ).resize( function () {
			correctStickyWidth();
			correctStickyTop();
		});
		
		correctStickyWidth();	
		correctStickyTop();
		 */

		
	});// ||||||||||||||| 	END ON WINDOW LOAD

	// continue on document ready:


	//############ MENU SYSTEM ###########
	function customMenu() {
		var dropdown = $j(".custom-nav").find("li.dropdown");
		dropdown.each( function(){
			
			var $_this		= $j(this),
				sub			= $_this.find(" > .sub-menu"),
				docWidth	= $j(document).width();

			$_this.hover(
			
			   function () {
				  if( $_this.parent().hasClass("as-megamenu") && docWidth >= 768 ) return;
				  
				  sub.css("display", "block");
				  sub.addClass("active");
				  sub.animate({ "opacity": 1}, { duration: 100, complete: function(){ megaWidth( $_this ); } });
			   }, 
				
			   function () {
				   if( $_this.parent().hasClass("as-megamenu") && docWidth >= 768 ) return;
				   sub.removeClass("active");
				  sub.animate({ "opacity": 0}, { duration: 100, complete: function(){ sub.css("display", "none"); } });
			   }
			);
				
		});
	}
	customMenu();

	function megaWidth( parentOfMega ) {
		
		var docWidth	= $j(document).width();
		
		var mega		= parentOfMega.find(".as-megamenu");
		
		if( !mega.length || docWidth <= 768 ) return;
		
		var	megaLeft	= mega.offset().left,
			megaWidth	= mega.outerWidth(true),
			megaRight	= Math.round( megaLeft + megaWidth );
		
		
		if( megaRight >= docWidth ) {
			
			var diff	= megaRight - docWidth,
				extract	= megaWidth - diff - 30 ;
				
			mega.css( "width", extract );
			
		}else if( megaRight <= docWidth){
			
		}
		
	}
	$j(window).resize(function() {
		
		customMenu(); // refresh menu
		
		var mega = $j(".as-megamenu");
		mega.each(function() {
			$j(this).css( "width" , $j(this).data("width"));
		});
		
			
	});
	//############ end MENU SYSTEM ###########



	/**
	 *	WAYPOINTS REFRESH
	 *
	*/	 
	$j(window).resize(function() {
		$j.waypoints('refresh');
	});

	// prevent empty a href
	$j('a[href=""]').attr('href', '#');


	/**
	 *	ADD GRAB / GRABBING CURSOR ON CAROUSELS
	 *
	 */		
	$j( ".slick-list, .owl-carousel, .superslides" )
		.hover(function() {
				$j( this ).addClass( 'to-drag');
			},
			function() {
				$j( this ).removeClass( 'to-drag');
			}
		)
		.mouseup(function() {
			$j( this ).removeClass( 'dragged').addClass( 'to-drag');
		})
		.mousedown(function() {
			$j( this ).addClass( 'dragged' ).removeClass( 'to-drag');
		});


/**
 *	GRID / LIST FUNCTIONS FOR WOOCOMMERCE CATALOG PAGE
 *
 */	
	var itemsHolder		= $j('ul.products'),
		masterParent	= itemsHolder.parent().hasClass("vc_ase_wc_gridlist");
	
	if( itemsHolder.length && masterParent ) {
	
		var default_view = 'grid'; // choose the view to show by default (grid/list)
		
		// check the presence of the cookie, if not create view cookie with the default view value
		if($j.cookie('view') !== 'undefined'){
			$j.cookie('view', default_view, { expires: 7, path: '/' });
		}
		
		var itemList	= $j('.item-data-list');
		
		if($j.cookie('view') == 'list'){ 
			// we dont use the get_list function here to avoid the animation
			$j('.grid-button').removeClass('active');
			$j('.list-button').addClass('active');
			
			itemsHolder.css("opacity",0);
			itemsHolder.addClass('list');
			itemList.css('display','block');
			
			itemsHolder.css("opacity",1);
			$j.waypoints('refresh');
		} 

		if($j.cookie('view') == 'grid'){ 
			$j('.list-button').removeClass('active');
			$j('.grid-button').addClass('active');
			
			itemsHolder.css("opacity",0);
				itemsHolder.removeClass('list');
				itemList.css('display','none');
				
				itemsHolder.css("opacity",1);
				$j.waypoints('refresh');
		}
		
		$j('.list-button').click(function(event){  
			event.preventDefault();
			$j.cookie('view', 'list'); 
			get_list();
		});

		$j('.grid-button').click(function(event){ 
			event.preventDefault();
			$j.cookie('view', 'grid'); 
			get_grid();
		});		
		
	}
	function get_list(){
		$j('.grid-button').removeClass('active');
		$j('.list-button').addClass('active');
		itemsHolder.animate({opacity:0},function(){
			itemsHolder.addClass('list');
			itemList.css('display','block');
			itemsHolder.css("opacity",1);
			$j.waypoints('refresh');
			$j('.shuffle').shuffle('layout');
			console.log("VCASE list");
		});
	} // end get_list function
	
	function get_grid(){
		$j('.list-button').removeClass('active');
		$j('.grid-button').addClass('active');
		itemsHolder.animate({opacity:0},function(){
			itemsHolder.removeClass('list');
			itemList.css('display','none');
			itemsHolder.css("opacity",1);
			$j.waypoints('refresh');
			$j('.shuffle').shuffle('update');
			console.log("VCASE grid");
		});
	} // end get_grid function	

	
	/**
	 *	VISUAL COMPOSER "TWEAKS"
	 *
	 */
	$j('.ui-tabs-nav li').mousedown(function() {
		var tabsParent	= $j(this).closest('.ui-tabs'),
			tabContent	= tabsParent.find('.wpb_tab');
		
		tabContent.each(function(){
			$j(this).css('opacity', 0 ).animate( {opacity:1});
		});
		
	});
	$j('.ui-tabs-nav li').mouseup(function() {
		setTimeout( 
			function() { 
				$j.waypoints('refresh');
				$j(window).trigger('resize');
				Foundation.libs.equalizer.reflow();
			} ,1000);
	});

	/**
	 *	STICKED SIDEBAR
	 */	
	$j('.special-stick').stickit({
		scope: StickScope.Parent,
		className: 'sticked-column',
		top: 0,
		extraHeight:0,
	});

	$j(window).on("load resize",function(e){
		
		var equalize = true;
		
		if ($j(document).width() <= 768) {
			
			equalize = false;
			if( typeof $j("div").data('equalizer-watch') !== 'undefined' ) {
				$j("div").removeAttr("data-equalizer-watch");
			}
		}else{
			equalize = true;
		}
		setTimeout( 
			function() { 
				/* $j(document).foundation({
					equalizer : {
						equalize_on_stack: equalize
					}
				}); */
				//Foundation.libs.equalizer.reflow();
				Foundation.utils.debounce(function(e){
					$j(document).foundation('equalizer', 'reflow');
				}, 10);
			} ,1000);
		
	});

	var generalArrows = window.vcase_moveArrows( $j(".owl-carousel"), ".owl-nav");
	var slickArrows = window.vcase_moveArrows( $j(".slick-slider"), "button[class*='slick-']");
	var superslidesArrows = window.vcase_moveArrows( $j(".superslides"), ".slides-navigation");
	
	 	 
}); // end document.ready


})();
//})(jQuery);