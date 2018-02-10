
(function( $ ) {
"use strict";
$(document).ready(function() {	
	
	var ajaxurl = vc_ase_jsvars.vc_ase_ajax_url;

	var prettyPhotoMarkup = '<div class="pp_pic_holder">'+
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
							'<div class="pp_overlay"></div>';
	
	/**
	 * AJAX - PRODUCT CATEGORIES
	 * 
	 */	
	$(document).on("click", "a.ajax-products", function(e) {

		e.preventDefault();
		
		var aLink			= $(this),
			item			= aLink.parent(),
			block			= aLink.parent().parent().parent(),
			parentVars		= block.find(".varsHolder"),
			cat_content		= block.find(".category-content"),
			load_anim		= block.find(".vc-ase-ajax-load");
		
		
		var t_ID			= aLink.attr("data-id"),
			taxonomy		= parentVars.attr("data-tax"),
			tax_name		= aLink.find(".box-title").text(),
			block_id		= parentVars.attr("data-block_id"),
			ptype			= parentVars.attr("data-ptype"),
			totitems		= parentVars.attr("data-totitems"),
			data_filters	= parentVars.attr("data-filters"),
			img				= parentVars.attr("data-img"),
			shop_quick		= parentVars.attr("data-shop_quick"),
			shop_buy_action	= parentVars.attr("data-shop_buy_action"),
			shop_wishlist	= parentVars.attr("data-shop_wishlist"),
			qv_img_format	= parentVars.attr("data-qv_img_format"),
			enter_anim		= parentVars.attr("data-enter_anim"),
			no_slider		= parentVars.attr("data-no_slider"),
			smaller			= parentVars.attr("data-smaller");
		
		// START ACTION:
		
		// 1 - remove all classes "active":
		$("a.ajax-products").removeClass("active");
		
		load_anim.fadeToggle(500);
		 
		item.parent().find(".reset-prod-cats").remove();
		
		cat_content.stop(false,true).animate({opacity: 0.3 }, 500, function() {
			
			aLink.addClass("active");
			
		});
		
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {"action": "load-prod-cats", block_id: block_id, termID: t_ID, tax: taxonomy, post_type: ptype, total_items: totitems, filters: data_filters,  img_format: img,  shop_quick: shop_quick, qv_img_format: qv_img_format,  shop_buy_action: shop_buy_action, shop_wishlist: shop_wishlist, enter_anim: enter_anim, no_slider: no_slider,  smaller: smaller },
			
			success: function(response) {

				load_anim.fadeToggle(300);
									
				// BACK TO FULL OPACITY:
				
				cat_content.stop(false,true).animate({opacity: 1 }, 500);
				
				if( ! aLink.hasClass("reset-prod-cats") && ! item.parent().hasClass('cat-list') ) {
					block.find(".reset-prod-cats").clone().appendTo( item );
				}
				
				
				/*  SUPPORT FOR PLUGINS AND FUNCTIONS AFTER AJAX LOAD */
				
				// OWL CAROUSEL :
				if( cat_content.hasClass("contentslides") ) {
					 
					cat_content.owlCarousel("replace", response).owlCarousel("refresh");
				
				}else{

					cat_content.html($.trim(response));
						
					cat_content.stop().delay(300).animate({opacity: 1 }, 500);
					
				}
				
				// PRETTYPHOTO :
						
				$("a[class^=\"prettyPhoto\"], a[data-gal^=\"prettyPhoto\"]").prettyPhoto(
					{	theme: "micemade_default",
						slideshow:5000, 
						social_tools: "",
						autoplay_slideshow:false,
						deeplinking: false,
						markup: prettyPhotoMarkup
					});
				
				
				if( enter_anim !== "none") {
					$(document).anim_waypoints(block_id,enter_anim);
				}
				
				$.waypoints("refresh");
				
				$(document).foundation();
	
				return false;
				
			}, // end success
			error: function () {
				alert("Ajax fetching or transmitting data error");
			}
		});
			

	});

	/**
	 *	AJAX - POSTS and PORTFOLIO CATEGORIES
	*
	*/
 
	$(document).on("click", "a.ajax-posts", function(e) {

		e.preventDefault();
		
		var aLink			= $(this);
		var block			= aLink.parent().parent().parent();
		var parentVars		= block.find(".varsHolder");
		var cat_content		= block.find(".category-content");
		var load_anim		= block.find(".vc-ase-ajax-load");
		
		var t_ID			= aLink.attr("data-id");
		var taxonomy		= parentVars.attr("data-tax");
		var tax_name		= aLink.find(".term").text();
		var block_id		= parentVars.attr("data-block_id");
		var ptype			= parentVars.attr("data-ptype");
		var totitems		= parentVars.attr("data-totitems");
		var feat			= parentVars.attr("data-feat");
		var img				= parentVars.attr("data-img");
		var custom_img_w	= parentVars.attr("data-custom-img-w");
		var custom_img_h	= parentVars.attr("data-custom-img-h");
		var icons			= parentVars.attr("data-icons");
		var taxmenu_style	= parentVars.attr("data-taxmenustlye");
		var enter_anim		= parentVars.attr("data-enter_anim");
		var block_style		= parentVars.attr("data-block_style");
		var no_slider		= parentVars.attr("data-no_slider");
		var zoom_button		= parentVars.attr("data-zoom");
		var link_button		= parentVars.attr("data-link");
		var offset			= parentVars.attr("data-offset");
		var no_post_thumb	= parentVars.attr("data-no_post_thumb");
		
		
		// START ACTION:
		
		// 1 - remove all classes "active":
		$("a.ajax-posts").removeClass("active");
		
		load_anim.fadeToggle(500);
		// 2 - HIDE THE CAT TITLE:		
		
		cat_content.stop(false,true).animate({opacity: 0.3 }, 500, function() {
			
			aLink.addClass("active");
			
		});
		
		
		$.ajax({
				type: "POST",
				url: ajaxurl,
				data: {"action": "load-cat-posts", termID: t_ID, tax: taxonomy, post_type: ptype, total_items: totitems, only_featured: feat,  img_format: img, custom_image_width: custom_img_w , custom_image_height: custom_img_h, display_icons: icons, tax_menu_style: taxmenu_style, block_id: block_id, enter_anim: enter_anim, block_style: block_style, no_slider: no_slider, zoom_button: zoom_button, link_button: link_button, offset: offset, no_post_thumb: no_post_thumb  },
				success: function(response) {


					load_anim.fadeToggle(300);
								
					// BACK TO FULL OPACITY:
					cat_content.stop(false,true).animate({opacity: 1 }, 500);
					
					/*  SUPPORT FOR PLUGINS AND FUNCTIONS AFTER AJAX LOAD */
					
					// OWL CAROUSEL :
					if( cat_content.hasClass("contentslides") ) {

						cat_content.owlCarousel("replace", response).owlCarousel("refresh");
						
					}else{
						
						cat_content.html($.trim(response));
						
						cat_content.stop().delay(300).animate({opacity: 1 }, 500);

					}	
					
					
					// PRETTYPHOTO :
					$("a[data-rel]").each(function() {
						$(this).attr("rel", $(this).data("rel"));
					});		
					$("a[class^=\"prettyPhoto\"], a[rel^=\"prettyPhoto\"]").prettyPhoto(
						{	theme: "micemade_default",
							slideshow:5000, 
							social_tools: "",
							autoplay_slideshow:false,
							deeplinking: false,
							markup: prettyPhotoMarkup,
							ajaxcallback: function(){
								//$("video,audio").mediaelementplayer();
							}
					});
					
					
					if( enter_anim !== "none") {
						$(document).anim_waypoints_posts(block_id, enter_anim);
					}
					
					if( cat_content.hasClass("js-masonry") ) {
						cat_content.masonry('layout');
					}			
					
					$.waypoints("refresh");
					
					$(document).foundation();
					
					return false;
					
				}, // end success
				error: function () {
					alert("Ajax fetching or transmitting data error");
				}
			});
			
			
			
	});
/**
 *	AJAX - QUICK VIEW:
 *
 */
	$(document).on("click", "a.vc-ase-quick-view", function(e) {

		e.preventDefault();
		
		var aLink		= $(this);
		var	prod_ID		= aLink.attr("data-id");
		
		var WP_adminbar =  $("#wpadminbar").length ? $("#wpadminbar").height() : 0;
		var aLink_offset = aLink.offset().top;
		
		// IF TO APPEND TO ITEM OR BODY (EXPANDER OR MODAL)
		var holder ="",
			toAdd = "";
		if( $(this).hasClass("expand") ){
			
			aLink.find(".vc-ase-loading").remove();
			aLink.prepend("<div class=\"vc-ase-loading\"><i class=\"fa fa-spinner fa-spin\"></i></div>");
			
			holder		= $(this).closest(".item");

			toAdd	= "<div class=\"qv-holder expander woocommerce\" id=\"qv-holder-"+prod_ID+"\"></div>";
			
			var existing_qv = holder.parent().find(".qv-holder");
			
			if( existing_qv.length ){
				existing_qv.fadeOut( 700, function() {
					$(this).remove();
				});
			}
			
			holder.after(toAdd);	
			
		}else{
			
			holder		= $("body");
			toAdd	= "<div class=\"qv-overlay\"><div class=\"qv-holder woocommerce\" id=\"qv-holder-"+prod_ID+"\"><div class=\"vc-ase-loading\"><i class=\"fa fa-spinner fa-spin\"></i><span>"+ vc_ase_jsvars.vc_ase_loading_qv + "</span></div></div></div>"
			holder.append( toAdd );
			
		}
		
		var	lang			= aLink.attr("data-lang"),
			qv_holder		= $("#qv-holder-"+prod_ID+""),
			qv_overlay		= $(".qv-overlay"),
			load_anim		= qv_holder.find(".vc-ase-loading"),
			load_anim_item	= aLink.find(".vc-ase-loading"),
			qv_img_format	= aLink.attr("data-qv_img_format");
		
		qv_overlay.fadeIn();
		
		// REMOVE IF CLICKED ON OVERLAY:
		qv_overlay.on("click", function(e) {

			if(e.target == this ) $(this).fadeOut("slow", function() { this.remove(); });

		});
		
		$.ajax({
			
			type: "POST",
			url: ajaxurl,
			data: { "action": "load-quick-view", productID: prod_ID, lang: lang, qv_img_format: qv_img_format  },
			success: function(response) {
				
				load_anim.fadeToggle(500);
				load_anim_item.fadeToggle(500);
				
				// fill with response from server:
				qv_holder.html(response);
				
				// -------- > REMOVING ACTIONS:
				// add QV window remover:
				qv_holder.append("<div class=\"vc-ase-remove fa fa-times \"></div>");
				// on remover click:	
				qv_holder.find(".vc-ase-remove").on("click", function(e) {
					
					var	wc_prod_gall = qv_holder.find('.woocommerce-product-gallery');

					qv_overlay.fadeOut( 300, function() { qv_overlay.remove(); });
				
				});
				// end removing actions
				
				
			}, // end success
			error: function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
 
	});

	/**
	 *	MINI WISHLIST
	 *	- for AS themes only ( Larix )
	 */	
	$(document).on("click", "a.vc_ase_add_to_wishlist", function(e) {
		
		var	prod_ID		= $(this).attr("data-product-id");
		
		$.ajax({
		
			type: "POST",
			url: ajaxurl,
			data: { "action": "add_miniwishlist", productID: prod_ID },
			success: function(response) {
				
				var miniWishlist	= $(".mini-wishlist"),
					productExists 	= miniWishlist.find("a.vc-ase-quick-view").data("id");
				
					if( productExists == prod_ID ) return;
				
					miniWishlist.find(".wishlist-empty").remove();
					miniWishlist.append( response );
			}
		})
	
	});

/**
 * end AJAX
 *
 */
}) // end (document).ready
})(window.jQuery);