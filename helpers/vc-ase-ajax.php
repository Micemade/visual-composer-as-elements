<?php
/**
 *  @file vc-ase-ajax.php
 *  @brief Brief contains all ajax VC ASE functions
 */


/**
 * AJAX LOAD STUFF.
 *	
 * - loading items from product categories ( has special product features).
 * - loading items from posts, portfolio or categories ( has common features for selected post types).
 * - quick view (buy).
 * - single product
 * - contact form
 */
/**
 *   AJAX PRODUCTS FROM PRODUCT CATEGORIES:
 */
add_action( 'wp_ajax_nopriv_load-prod-cats', 'vc_ase_ajax_products' ); // for NOT logged in users
add_action( 'wp_ajax_load-prod-cats', 'vc_ase_ajax_products' );// for logged in users

function vc_ase_ajax_products () {
	
	global $post, $product, $woocommerce_loop, $wp_query, $woocommerce;
	
	if( VC_ASE_WOO_ACTIVE ) {
	
	// get variables using $_POST
	$tax_term		= $_POST[ 'termID' ];
	$taxonomy		= $_POST[ 'tax' ];
	$post_type		= $_POST[ 'post_type' ];
	$total_items	= $_POST[ 'total_items' ];
	$filters		= $_POST[ 'filters' ];
	$img_format		= $_POST[ 'img_format' ];
	$shop_quick		= $_POST[ 'shop_quick' ];
	$qv_img_format	= $_POST[ 'qv_img_format' ];
	$shop_buy_action= $_POST[ 'shop_buy_action' ];
	$shop_wishlist	= $_POST[ 'shop_wishlist' ];
	$enter_anim		= $_POST[ 'enter_anim' ];
	$no_slider		= $_POST[ 'no_slider' ];
	//
	// PRODUCT FILTERS:
	$order_rand	= false;
	$args_filters = array();
	if ( $filters == 'featured' ){
		
		$args_filters['tax_query'][] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
		);
		
	}elseif( $filters == 'on_sale' ) {
		
		$product_ids_on_sale    = wc_get_product_ids_on_sale();
		if( ! empty( $product_ids_on_sale ) ) {
			$args_filters['post__in'] = $product_ids_on_sale;
		}
	
	}elseif( $filters == 'best_sellers' ) {
		
		$args_filters['meta_key']	= 'total_sales';
		$args_filters['orderby']	= 'meta_value_num';
	
	}elseif( $filters == 'best_rated' ) {
		
		$args_filters['meta_key']	= '_wc_average_rating';
		$args_filters['orderby']	= 'meta_value_num';
		
	}elseif( $filters == 'random' ) {
	
		$order_rand	= true;
		$args_filters = array();
		$args_filters['orderby'] = 'rand menu_order date';
		
	}
	// end filters
	
	if( !empty($tax_term) ) {

		$tax_term = explode(",", $tax_term); // back to array
		
		$tax_filter_args = array('tax_query' => array(
							array(
								'taxonomy' => $taxonomy,
								'field' => 'slug', // can be 'ID' too
								'operator' => 'IN', // NOT IN to exclude
								'terms' => $tax_term
							)
						)
					);
	}else{
		$tax_filter_args = array();
	}
	$main_args = array(
		'no_found_rows' => 1,
		'post_status' => 'publish',
		'post_type' => $post_type,
		'post_parent' => 0,
		'suppress_filters' => false,
		'orderby'     => $order_rand ? 'rand menu_order date' : 'menu_order date',
		'order'       => 'ASC',
		'numberposts' => $total_items
	);
	$all_args = array_merge( $main_args, $args_filters, $tax_filter_args );
	
	$content = get_posts($all_args);
		
	ob_start ();

	$i = 1;
	
	if( count( $content ) == 0 ) {
		echo '<h4 class="no-category-item column">'.__('No product was found for this category.','larix').'</h4>';
	} 
	
	
	foreach ( $content as $post ) {
		setup_postdata( $post );
		
		global $product, $yith_wcwl;
		
		if( VC_ASE_WPML_ON ) { // if WPML plugin is active
			$id	= icl_object_id( get_the_ID(), 'product', false, ICL_LANGUAGE_CODE ); 
			$lang_code	= ICL_LANGUAGE_CODE;
		}else{
			$id	= get_the_ID();
			$lang_code	= '';
		}
		$link = esc_url( get_permalink($id));
		
		
		// DATA for back image
		// 3.0.0 < Fallback conditional
		if( apply_filters( 'vc_ase_wc_version', '3.0.0' )	) {
			$attachment_ids   = $product->get_gallery_image_ids();
		}else{
			$attachment_ids   = $product->get_gallery_attachment_ids();
		}
		
		$img_url = $img_width = $img_height = "";
		if ( $attachment_ids ) {
			$image_url = wp_get_attachment_image_src( $attachment_ids[0], 'full'  );
			$img_url = $image_url[0];

		}
		// end DATA for back image
				
		
		// 3.0.0 < Fallback conditional
		$cats = "";
		if( apply_filters( 'vc_ase_wc_version', '3.0.0' ) ) {
			$cats =  wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' );
		}else{
			$cats = $product->get_categories( ', ', '<span class="posted_in">', '</span>' );
		}
		
		$prod_title = '<h4 class="prod-title">'.$cats.'<a href="'. $link .'" title="'. the_title_attribute(array('echo' => 0)) .'"> ' . esc_attr(get_the_title()) .'</a></h4>';
		?>	
		
		<div class="column item <?php echo esc_attr($no_slider); ?>" >
					
			<div class="anim-wrap<?php echo ($enter_anim != 'none') ? ' to-anim' : '';  ?>" data-i="<?php echo esc_attr($i); ?>" >
				
				<?php apply_filters('vc_ase_wc_sales',''); ?>	
									
				<div class="item-img">
					
					<div class="front">
						
						<?php echo apply_filters( 'vc_ase_image', $img_format ); ?>
					
					</div>
					
					<div class="back<?php echo ($img_url ? ' has-image' : ''); ?>">
					
						<div class="item-overlay"></div>

						<?php 
						
						if ( $attachment_ids ) {
							
							if( $img_width && $img_height ) {
								
								//$custom_size = $img_width . 'x' . $img_height; // Deprecated - "Micemade_Custom_Image_Sizes" class in as_vc_init.php
								echo wp_get_attachment_image( $attachment_ids[0], array( $img_width, $img_height ) );
								
							}else{
								echo wp_get_attachment_image( $attachment_ids[0], $img_format );
							}
						}
						?>
						
						<?php do_action( 'vc_ase_shop_buttons' , $shop_buy_action , $shop_wishlist, $shop_quick, $qv_img_format ); ?>
						
					</div>
					
					
				</div>
				
				<div class="item-data">
					
					<?php
					do_action( 'vc_ase_shop_title_price' );	
					
					apply_filters('vc_ase_wc_rating',''); 
					?>
					
				</div><?php //.item-data ?>
				
			
			</div><?php // .anim-wrap ?>
			
		
		</div><?php // .column ?>
						
		<?php 
		$i++;
	}// END foreach
	
	/* reset, clean buffer and respond with content */
	wp_reset_postdata();
	$response = ob_get_contents();
	ob_flush();

	// do_action( 'vc_ase_ajax_response', $response );
	
	die(1);

	}else{
		echo '<h5 class="no-woo-notice">' . __('AJAX PRODUCTS BLOCK DISABLED.<br> Sorry, it seems like WooCommerce is not active. Please install and activate last version of WooCommerce.','larix') . '</h5>';
			return;
	} // if VC_ASE_WOO_ACTIVE
	
} // end AJAX PRODUCTS FROM PRODUCT CATEGORIES
//
//
/** 
 *	POSTS, PORTFOLIO or PRODUCT CATEGORIES.
 *
 *	primarily for posts and portfolios, but can be used for products (product image gallery?)
 */
add_action( 'wp_ajax_nopriv_load-cat-posts', 'vc_ase_ajax_posts' );// for NOT logged in users
add_action( 'wp_ajax_load-cat-posts', 'vc_ase_ajax_posts' );// for logged in users

function vc_ase_ajax_posts () {
	
	global $post;
	
	// get all variables using $_POST
	$block_id			= $_POST[ 'block_id' ];
	$tax_term			= $_POST[ 'termID' ];
	$taxonomy			= $_POST[ 'tax' ];
	$post_type			= $_POST[ 'post_type' ];
	$img_format			= $_POST[ 'img_format' ];
	$tax_menu_style		= $_POST[ 'tax_menu_style' ];
	$custom_image_width	= $_POST[ 'custom_image_width' ];
	$custom_image_height= $_POST[ 'custom_image_height' ];
	$total_items		= $_POST[ 'total_items' ];
	$only_featured		= $_POST[ 'only_featured' ];
	$enter_anim			= $_POST[ 'enter_anim' ];
	$block_style		= $_POST[ 'block_style' ];
	$no_slider			= $_POST[ 'no_slider' ];
	$zoom_button		= $_POST[ 'zoom_button' ];
	$link_button		= $_POST[ 'link_button' ];
	$offset				= $_POST[ 'offset' ];
	$no_post_thumb		= $_POST[ 'no_post_thumb' ];

	//
	$sticky_array = get_option( 'sticky_posts' );
	$total_items = $total_items ? $total_items : -1;
	//
	/*
	 *	IF POSTS, PORTFOLIOS OR PRODUCTS SHOULD BE ONLY FEATURED (STICKY)
	 *
	 */
	if ( $post_type == 'post' && $only_featured ) {
		$args_only_featured = array('post__in' => $sticky_array);
	}elseif ( $post_type == 'portfolio' && $only_featured ){
		$args_only_featured = array( 
			'meta_key' => 'as_featured_item',
			'meta_value' => 1
		);
	}elseif ( $post_type == 'product' && $only_featured ){
		$args_only_featured = array( 
			'meta_key' => '_featured',
			'meta_value' => 'yes'
		);
	}else{
		$args_only_featured = array();
	}
	
	if( !empty($tax_term) ) {

		$tax_term = explode(",", $tax_term); // back to array
		
		$tax_filter_args = array('tax_query' => array(
							array(
								'taxonomy' => $taxonomy,
								'field' => 'slug', // can be 'slug' too
								'operator' => 'IN', // NOT IN to exclude
								'terms' => $tax_term
							)
						)
					);
	}else{
		$tax_filter_args = array();
	}
	$main_args = array(
		'no_found_rows'		=> 1,
		'post_status' 		=> 'publish',
		'post_type' 		=> $post_type,
		'post_parent' 		=> 0,
		'suppress_filters'	=> false,
		'orderby'     		=> 'post_date',
		'order'       		=> 'DESC',
		'numberposts'		=> $total_items,
		'offset'			=> $offset ? $offset : 0
	);
	$all_args = array_merge( $main_args, $args_only_featured, $tax_filter_args );
	
	$content = get_posts($all_args);
				
	// if custom img size is set:
	if( $custom_image_width && $custom_image_height ) {
		
		$img_width	= $custom_image_width ? $custom_image_width : 450;
		$img_height = $custom_image_height ? $custom_image_height : 300;
		
	}else{			

		$img_width	= "";
		$img_height = "";
	}	
		
	ob_start ();
	
	$i = 1;
	
	foreach ( $content as $post ) {
		
		setup_postdata( $post );
		
		if( VC_ASE_WPML_ON ) { // if WPML plugin is active
			$post_id	= icl_object_id( get_the_ID(), 'product', false, ICL_LANGUAGE_CODE ); 
			$lang_code	= ICL_LANGUAGE_CODE;
		}else{
			$post_id	= get_the_ID();
			$lang_code	= '';
		}
		$link				= get_permalink($post_id);
		$post_title			= '<h4><a href="'. $link.'" title="'. the_title_attribute(array('echo' => 0)) .'">'. esc_html( strip_tags(get_the_title()) ) .'</a></h4>';
		$post_format		= get_post_format();
		$pP_rel				= '';
			
		$post_formats		= apply_filters('vc_ase_post_formats_media', $post_id, $block_id, $img_format, $img_width, $img_height );
				
		$img_url			= $post_formats['img_url'];
		$image_output		= $post_formats['image_output'];
		$pP_rel				= $post_formats['pP_rel'];
		$img_urls_gallery	= $post_formats['img_urls_gallery'];
		$quote_html			= $post_formats['quote_html'];
		
		?>
			
		<div class="column item <?php echo $no_slider; ?><?php echo ($enter_anim != 'none') ? ' to-anim' : '';  ?>" data-i="<?php echo esc_attr($i); ?>">
			
			<div class="anim-wrap">
			
			<?php if( !$no_post_thumb ) { ?>
			
			<?php echo ($zoom_button && $link_button) ? '<a href="'. $link.'" title="'. the_title_attribute (array('echo' => 0)).'">' : ''; // if hiding buttons link the image ?>
			
			<div class="item-img">
			
				<div class="front">
					
					<?php echo wp_kses_post($image_output) ;?>
					
				</div>
				
				<?php if( $block_style == "style3") { 
							
					do_action( "vc_ase_content_style3", $post_id, $link, $post_type, $taxonomy );
				
				}elseif( $block_style == "style4" ) {
					
					do_action( "vc_ase_content_style4", $post_id, $link, $post_type, $taxonomy );
					
				}else{ ?>
				
					<div class="back">
				
						<div class="item-overlay"></div>
																			
						<div class="back-buttons">
					
						<?php
						echo !$zoom_button ? '<a href="'.esc_url($img_url).'"  data-gal="prettyPhoto'.$pP_rel.'" title="'.the_title_attribute (array('echo' => 0)).'">'. apply_filters('vc_ase_post_format_icon','').'</a>' : null;
						
						echo !$link_button ? '<a href="'. $link.'"  title="'. the_title_attribute (array('echo' => 0)).'"><i class="fa fa-link" aria-hidden="true"></i></a>' : null;
						?>
						
						</div>
						
					</div>
				
				<?php } ?>
				
				
				<?php
				$allowed = array(
					'a' => array(
						'href' => array(),
						'class' => array(),
						'rel' => array(),
						'data-gal' => array(),
					)
				);
				echo $img_urls_gallery ? wp_kses( $img_urls_gallery, $allowed ) : null; // for usage with prettPhoto
				
				echo $post_format == 'quote' ? '<div class="hidden-quote" id="quote-'.esc_attr($post_id).'">'. esc_html($quote_html) .'</div>' : null;
				?>
			
			</div><?php //.item-img ?>
				
			<?php echo ( $zoom_button && $link_button ) ? '</a>' : ''; // if hiding buttons link the image ?>
				
			<?php } // end if (!$no_post_thumb)?>
			
			
			<?php if( $block_style != "style3" && $block_style != "style4" ) { ?>
			<div class="item-data<?php echo $no_post_thumb ? ' no-post-thumb' : ''; ?>">
				
				<?php echo wp_kses_post($post_title); ?>
										
				<div class="vcase-post-meta">
				
					<?php 
					do_action('vc_ase_entry_date');
					do_action('vc_ase_entry_author');
					?>
				
				</div>						
				
				<?php 
				echo '<div class="excerpt">';
				do_action('vc_ase_archive_content');
				echo '</div>'; 
				?>

				<div class="clearfix"></div>
			
			</div><?php // .item-data ?>
			<?php } // end if( $block_style != "style3")?>
			
			
		</div><?php // .anim-wrap ?>
		
		</div><?php // .column ?>

		<?php
		
		$i++;
		
	}// END foreach
		
	/* reset, clean buffer and respond with content */
	wp_reset_postdata();
	$response = ob_get_contents();
	ob_flush();
	
	// do_action( 'vc_ase_ajax_response', $response );
	
	die(1);

}// end POSTS, PORTFOLIO or PRODUCT CATEGORIES.

/**
 *	QUICK VIEW - Products popup
 *
 */
// for NOT logged in users:
add_action( 'wp_ajax_nopriv_load-quick-view', 'vc_ase_quick_view' );
// for logged in users:
add_action( 'wp_ajax_load-quick-view', 'vc_ase_quick_view' );

function vc_ase_quick_view () {

	global $post;
	
	$productID		= $_POST[ 'productID' ];
	$lang 			= isset($_POST[ 'lang' ]) ? $_POST[ 'lang' ] : '';
	$qv_img_format 	= isset($_POST[ 'qv_img_format' ]) ? $_POST[ 'qv_img_format' ] : 'thumbnail';
		
	$prodID = $lang ? icl_object_id( $productID, 'product', false, $lang ) : $productID;
	
	$display_args = array(
			'no_found_rows'		=> 1,
			'post_status'		=> 'publish',
			'post_type'			=> 'product',
			'post_parent'		=> 0,
			'suppress_filters'	=> false,
			'numberposts'		=> 1,
			'include'			=> $prodID
		);
			
	$content = get_posts($display_args);
	
	ob_start ();
	
	foreach ( $content as $post ) {
			
		setup_postdata( $post );
	
		global $post, $product, $woocommerce, $wp_query;
		
		$postClassarr	= get_post_class();
		$postClassarr[] = "qv-wrapper";
		$postClass = implode(" ", $postClassarr );
		
		echo '<div itemscope itemtype="http://schema.org/Product" id="product-'. esc_attr($productID) .'" class="'. esc_attr($postClass) .' product">';
		
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );

		echo '<div class="summary entry-summary">';
		
		echo '<div class="inner-wrap">';
		
		echo '<h4><a href="' . esc_attr(get_permalink()) . '" title="'. the_title_attribute(array('echo' => 0)).'">' . esc_html(get_the_title()) .'</a></h4>';
		 
		// DON'T DO SHARETHIS ON QUICK VIEW
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		
		do_action( 'woocommerce_single_product_summary' );
		
		echo '</div>'; // end .summary

		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		//do_action( 'woocommerce_after_single_product_summary' );


	echo '</div>'; // .inner-wrap
	echo '</div>'; // div itemscope

	}
	?>
	<script>
	(function($) {
		"use strict";
		
		$(document).ready(function () {
			// First - the MAIN var, that is - OBJECT
			var qv_holder	= $('#qv-holder-<?php echo esc_js($productID) ?>'),
				qv_overlay	= $('.qv-overlay'),
				qv_wrap			= qv_holder.find(".qv-wrapper");

				setTimeout( function() {
					qv_wrap.addClass('active')
				},600 );
				
					
			// Get those variations forms to work ;) 
			$( function() {
				
				if ( typeof wc_add_to_cart_variation_params !== "undefined" ) {
					$( ".variations_form" ).each( function() {
						$( this ).wc_variation_form().find(".variations select:eq(0)").change();
						$( this ).on("change", function() { 
							setTimeout( function() {
							$(window).trigger('resize');
							} ,200 );

						})
					});
				}
			});
		
			/* Animate and display after images are loaded */
			qv_holder.imagesLoaded()
			.always( function( instance ) {
				
				var qv_wrap_h		= qv_wrap.outerHeight(),
					qv_overlay_H	= qv_overlay.outerHeight(true);

				var	qv_top		= (qv_overlay_H / 2) - (qv_wrap_h/2);
				
				if ( qv_top <=  55 ) { // if modal goes off the top
					qv_top = 75;
				}
				
				qv_holder.stop(true,false).animate({'top': qv_top },{ duration:200, easing: 'easeOutQuart', complete: 
					function() {

						qv_holder.stop(true,false).delay(300).animate({'height': qv_wrap_h },
						{	duration:300, 
							easing: 'easeOutQuart',
						});
						
					}
				});
			})

			
			/*	QUICK VIEW WINDOW VERTICAL CENTER POSITION :	*/
			$(window).resize(function() {
				
				var qv_height = qv_overlay_H = '';

				var qv_wrap			= qv_holder.find(".qv-wrapper"),
					qv_height		= qv_wrap.outerHeight(true),
					qv_overlay_H	= qv_overlay.outerHeight(true);
				
							
					var	qv_top		= (qv_overlay_H / 2) - (qv_height/2);
					
					if ( qv_top <=  55 ) { // if modal goes off the top
						qv_top = 75;
					}
					
					qv_holder.css("height",qv_height );
					qv_holder.stop(true,false).delay(200).animate({'top': qv_top },{ duration:400, easing: 'easeOutQuart'} );
					

			});
			
			var	wc_prod_gall = qv_holder.find('.woocommerce-product-gallery');
			wc_prod_gall.each( function() {
				$( this ).wc_product_gallery();
				$( this ).resize( function() { 
					$(window).trigger("resize");
				});
			} );
			
			$(document).on("ajaxComplete", function() {
				 $(window).trigger("resize");
			});
			
		});
	
	})(jQuery);
	</script>
	<?php 
	
	
	/* reset, clean buffer and respond with content */
	wp_reset_postdata();
	$response = ob_get_contents();
	ob_flush();

	// do_action( 'vc_ase_ajax_response', $response );
	
	die(1);
	
} // QUICK VIEW - Products popup



###############################################################

/**
 * VC ASE AJAX RESPONSE
 * - display ajax response from various blocks
 * 
 * @param string $response 
 * 
 * @return string
 */

function vc_ase_ajax_response_func($response) {
	echo wp_specialchars_decode( $response );
}
add_action('vc_ase_ajax_response','vc_ase_ajax_response_func',10,1);
/**
 *  VC ASE CF
 *  
 *  code for sending email messages
 */
add_action( 'wp_ajax_nopriv_vc_ase_contactform', 'vc_ase_cf' );	// for not-logged in users
add_action( 'wp_ajax_vc_ase_contactform', 'vc_ase_cf' );	// for logged in users

function vc_ase_cf() {
	
	$to			= sanitize_email( $_POST["recipient"] );
	$subject	= sanitize_text_field( $_POST["subject"] );
	$message	= sanitize_text_field( $_POST["message"] );
	$headers	= "From: " . sanitize_text_field( $_POST["userName"] ) . "<". sanitize_email( $_POST["userEmail"] ) .">\r\n";
	
	if( wp_mail( $to, $subject ,$message, $headers ) ) {

		$mailsent = $_POST["mailsent"];
		print "<div class='emailform-message success alert-box' data-alert>$mailsent<a href='#' class='close-alert'>&times;</a></div>";
		
	}else{

		$error = $_POST["mailerror"];
		print  "<div class='emailform-message error alert-box' data-alert>$error<a href='#' class='close-alert'>&times;</a></div>";
	}
	
	die(1);
}

/**
 * end AJAX LOAD STUFF
 */