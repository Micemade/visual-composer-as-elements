<?php
/**
 *	VC ADMIN :
 **/
function VC_ASE_admin_init() {
	
	if( VC_IS_ACTIVE ) {
				
		$vc_ase_path = plugin_dir_path( __FILE__ );
		
		vc_set_shortcodes_templates_dir( VC_ASE_DIR . 'vc_ase_templates');
		
		// include shortcode parameters :
		include( $vc_ase_path .'shortcodes-mapping/as_ajax_cats_params.php' );		// AJAXED CONTENT
		include( $vc_ase_path .'shortcodes-mapping/as_filter_cats_params.php' );	// FILTERED CONTENT
		include( $vc_ase_path .'shortcodes-mapping/as_slick_slider_params.php' ); 	// SLICK SLIDER
		include( $vc_ase_path .'shortcodes-mapping/as_superslides_params.php' ); 	// SUPERSLIDES
		include( $vc_ase_path .'shortcodes-mapping/as_menu_params.php' ); 			// CUSTOM MENU
		include( $vc_ase_path .'shortcodes-mapping/as_social_params.php' ); 		// SOCIAL
		include( $vc_ase_path .'shortcodes-mapping/as_banner_params.php' ); 		// BANNER
		include( $vc_ase_path .'shortcodes-mapping/as_testimonials_params.php' ); 	// TESTIMONIAL
		include( $vc_ase_path .'shortcodes-mapping/as_images_slider_params.php' ); 	// IMAGES SLIDER
		
		include( $vc_ase_path .'shortcodes-mapping/as_gmap_params.php' );			// GOOGLE MAP
		include( $vc_ase_path .'shortcodes-mapping/as_heading_params.php' );		// HEADING
		include( $vc_ase_path .'shortcodes-mapping/as_contact_params.php' );		// HEADING
		include( $vc_ase_path .'shortcodes-mapping/as_video_params.php' );			// VIDEO PLAYER
		include( $vc_ase_path .'shortcodes-mapping/as_widget_areas_params.php' );	// WIDGETS
		include( $vc_ase_path .'shortcodes-mapping/as_button_params.php' );			// BUTTON
		
		if( VC_ASE_WOO_ACTIVE ) {
			
			include( $vc_ase_path .'shortcodes-mapping/as_ajax_prod_params.php' );		// AJAXED PRODUCTS
			include( $vc_ase_path .'shortcodes-mapping/as_filter_prod_params.php' );	// FILTERED PRODUCTS
			include( $vc_ase_path .'shortcodes-mapping/as_prod_cats_params.php' );		// PRODUCT CATEGORIES
			include( $vc_ase_path .'shortcodes-mapping/as_single_prod_params.php' );	// SINGLE PRODUCT
			include( $vc_ase_path .'shortcodes-mapping/as_single_prod_cat_params.php' );// PRODUCTS FROM SINGLE CATEGORY
			include( $vc_ase_path .'shortcodes-mapping/as_prod_category_params.php' );	// SINGLE PRODUCT CATEGORY
			include( $vc_ase_path .'shortcodes-mapping/as_wc_catalog_view_params.php' );// WC CATALOG PAGE VIEW
		}
		
		
		include( $vc_ase_path ."inc/admin-functions.php");
		
		include( $vc_ase_path ."inc/default-added-shortcode-params.php");
		
		include( $vc_ase_path ."inc/Parsedown.php");
			
		
	} //end if VC_IS_ACTIVE
	
}
add_action('after_setup_theme','VC_ASE_admin_init');
/**
 *	VC FRONTEND :
 **/
function VC_ASE_init() {

	if( VC_IS_ACTIVE ) {
			
		$vc_ase_path = plugin_dir_path( __FILE__ );
		
		// include various functions:
		include(  $vc_ase_path .'helpers/helpers.php' );
		
		if( ! class_exists('blFile') ) {
			include( $vc_ase_path . 'helpers/freshizer.php');
		}
		
		if( ! function_exists( 'bfi_thumb' ) ) {
			include( $vc_ase_path . 'helpers/BFI_Thumb.php');	
		}
		
		
		include( $vc_ase_path .'helpers/post.php' );
		include( $vc_ase_path .'helpers/meta.php' );
		include( $vc_ase_path .'helpers/images.php' );
		include( $vc_ase_path .'helpers/formats.php' );
		include( $vc_ase_path .'helpers/vc-ase-ajax.php' );
		include( $vc_ase_path .'helpers/dynamic_image_downsize.php' );
		
		if( VC_ASE_WOO_ACTIVE ) {
			include( $vc_ase_path .'helpers/wc-functions.php' );
		}		
		
		########## VISUAL COMPOSER SHORTCODES
		
		include( $vc_ase_path .'shortcodes/as_ajax_cats.php' );		// PRODUCTS AJAXED BY CATEGORIES
		include( $vc_ase_path .'shortcodes/as_filter_cats.php' );	// POSTS, PORTFOLIO FILTERED BY CATEGORIES
		include( $vc_ase_path .'shortcodes/as_slick_slider.php' );	// SLICK SLIDER
		include( $vc_ase_path .'shortcodes/as_superslides.php' );	// SUPERLIDES
		include( $vc_ase_path .'shortcodes/as_menu.php' );			// CUSTOM MENU
		include( $vc_ase_path .'shortcodes/as_social.php' );		// SOCIAL
		include( $vc_ase_path .'shortcodes/as_banner.php' );		// BANNER
		include( $vc_ase_path .'shortcodes/as_images_slider.php' );	// IMAGES SLIDER
		include( $vc_ase_path .'shortcodes/as_testimonials.php' );	// TESTIMONIAL
		include( $vc_ase_path .'shortcodes/as_gmap.php' );			// GOOGLE MAP
		include( $vc_ase_path .'shortcodes/as_heading.php' );		// HEADING
		include( $vc_ase_path .'shortcodes/as_contact.php' );		// CONTACT
		include( $vc_ase_path .'shortcodes/as_video.php' );			// VIDEO PLAYER
		include( $vc_ase_path .'shortcodes/as_widget_areas.php' );	// WIDGETS
		include( $vc_ase_path .'shortcodes/as_button.php' );		// BUTTON
		
		if( VC_ASE_WOO_ACTIVE ) {
			include( $vc_ase_path .'shortcodes/as_ajax_prod.php' );			// POSTS, PORTFOLIO AJAXED BY CATEGORIES
			include( $vc_ase_path .'shortcodes/as_filter_prod.php' );		// PRODUCTS FILTERED BY CATEGORIES
			include( $vc_ase_path .'shortcodes/as_prod_cats.php' );			// PRODUCT  CATEGORIES
			include( $vc_ase_path .'shortcodes/as_single_product.php' );	// SINGLE PRODUCT
			include( $vc_ase_path .'shortcodes/as_single_prod_cat.php' );	// PRODUCTS FROM SINGLE CATEGORY
			include( $vc_ase_path .'shortcodes/as_prod_category.php' );		// SINGLE PRODUCT CATEGORY
			include( $vc_ase_path .'shortcodes/as_wc_catalog_view.php' );	// WC CATALOG PAGE VIEW
		}
		
		// VC ASE direct functions - include partials for frontend html shortcode rendering:
		include( $vc_ase_path .'inc/shortcodes-segments.php' );
				
		
	}// end if VC_IS_ACTIVE
	
}
add_action('init','VC_ASE_init');