<?php
/**
 * VC ADMIN
 */
function vc_ase_admin_init() {

	if ( VC_IS_ACTIVE ) {

		vc_set_shortcodes_templates_dir( VC_ASE_DIR . 'vc_ase_templates' );

		// include shortcode parameters :
		include VC_ASE_DIR . 'shortcodes-mapping/as_ajax_cats_params.php';     // AJAXED CONTENT.
		include VC_ASE_DIR . 'shortcodes-mapping/as_filter_cats_params.php';   // FILTERED CONTENT.
		include VC_ASE_DIR . 'shortcodes-mapping/as_slick_slider_params.php';  // SLICK SLIDER.
		include VC_ASE_DIR . 'shortcodes-mapping/as_superslides_params.php';   // SUPERSLIDES.
		include VC_ASE_DIR . 'shortcodes-mapping/as_menu_params.php';          // CUSTOM MENU.
		include VC_ASE_DIR . 'shortcodes-mapping/as_social_params.php';        // SOCIAL.
		include VC_ASE_DIR . 'shortcodes-mapping/as_banner_params.php';        // BANNER.
		include VC_ASE_DIR . 'shortcodes-mapping/as_testimonials_params.php';  // TESTIMONIAL.
		include VC_ASE_DIR . 'shortcodes-mapping/as_images_slider_params.php'; // IMAGES SLIDER.

		include VC_ASE_DIR . 'shortcodes-mapping/as_gmap_params.php';         // GOOGLE MAP.
		include VC_ASE_DIR . 'shortcodes-mapping/as_heading_params.php';      // HEADING.
		include VC_ASE_DIR . 'shortcodes-mapping/as_contact_params.php';      // CONTACT.
		include VC_ASE_DIR . 'shortcodes-mapping/as_video_params.php';        // VIDEO PLAYER.
		include VC_ASE_DIR . 'shortcodes-mapping/as_widget_areas_params.php'; // WIDGETS.
		include VC_ASE_DIR . 'shortcodes-mapping/as_button_params.php';       // BUTTON.

		if ( VC_ASE_WOO_ACTIVE ) {

			include VC_ASE_DIR . 'shortcodes-mapping/as_ajax_prod_params.php';       // AJAXED PRODUCTS.
			include VC_ASE_DIR . 'shortcodes-mapping/as_filter_prod_params.php';     // FILTERED PRODUCTS.
			include VC_ASE_DIR . 'shortcodes-mapping/as_prod_cats_params.php';       // PRODUCT CATEGORIES.
			include VC_ASE_DIR . 'shortcodes-mapping/as_single_prod_params.php';     // SINGLE PRODUCT.
			include VC_ASE_DIR . 'shortcodes-mapping/as_single_prod_cat_params.php'; // PRODUCTS FROM SINGLE CATEGORY.
			include VC_ASE_DIR . 'shortcodes-mapping/as_prod_category_params.php';   // SINGLE PRODUCT CATEGORY.
			include VC_ASE_DIR . 'shortcodes-mapping/as_wc_catalog_view_params.php'; // WC CATALOG PAGE VIEW.
		}

		include VC_ASE_DIR . 'inc/admin-functions.php';

		include VC_ASE_DIR . 'inc/default-added-shortcode-params.php';

		include VC_ASE_DIR . 'inc/Parsedown.php';

	} //end if VC_IS_ACTIVE.

}
add_action( 'after_setup_theme', 'vc_ase_admin_init' );

/**
 * VC FRONTEND :
 */
function vc_ase_init() {

	if ( VC_IS_ACTIVE ) {

		// Include various functions.
		include VC_ASE_DIR . 'helpers/helpers.php';

		// Include files for contact form.
		include VC_ASE_DIR . 'inc/class-wp-mail.php';

		if ( ! class_exists( 'blFile' ) ) {
			include VC_ASE_DIR . 'helpers/freshizer.php';
		}

		if ( ! function_exists( 'bfi_thumb' ) ) {
			include VC_ASE_DIR . 'helpers/BFI_Thumb.php';
		}

		include VC_ASE_DIR . 'helpers/post.php';
		include VC_ASE_DIR . 'helpers/meta.php';
		include VC_ASE_DIR . 'helpers/images.php';
		include VC_ASE_DIR . 'helpers/formats.php';
		include VC_ASE_DIR . 'helpers/vc-ase-ajax.php';
		include VC_ASE_DIR . 'helpers/dynamic_image_downsize.php';

		if ( VC_ASE_WOO_ACTIVE ) {
			include VC_ASE_DIR . 'helpers/wc-functions.php';
		}

		// VISUAL COMPOSER SHORTCODES.
		include VC_ASE_DIR . 'shortcodes/as_ajax_cats.php';     // PRODUCTS AJAXED BY CATEGORIES.
		include VC_ASE_DIR . 'shortcodes/as_filter_cats.php';   // POSTS, PORTFOLIO FILTERED BY CATEGORIES.
		include VC_ASE_DIR . 'shortcodes/as_slick_slider.php';  // SLICK SLIDER.
		include VC_ASE_DIR . 'shortcodes/as_superslides.php';   // SUPERLIDES.
		include VC_ASE_DIR . 'shortcodes/as_menu.php';          // CUSTOM MENU.
		include VC_ASE_DIR . 'shortcodes/as_social.php';        // SOCIAL.
		include VC_ASE_DIR . 'shortcodes/as_banner.php';        // BANNER.
		include VC_ASE_DIR . 'shortcodes/as_images_slider.php'; // IMAGES SLIDER.
		include VC_ASE_DIR . 'shortcodes/as_testimonials.php';  // TESTIMONIAL.
		include VC_ASE_DIR . 'shortcodes/as_gmap.php';          // GOOGLE MAP.
		include VC_ASE_DIR . 'shortcodes/as_heading.php';       // HEADING.
		include VC_ASE_DIR . 'shortcodes/as_contact.php';       // CONTACT.
		include VC_ASE_DIR . 'shortcodes/as_video.php';         // VIDEO PLAYER.
		include VC_ASE_DIR . 'shortcodes/as_widget_areas.php';  // WIDGETS.
		include VC_ASE_DIR . 'shortcodes/as_button.php';        // BUTTON.

		if ( VC_ASE_WOO_ACTIVE ) {
			include VC_ASE_DIR . 'shortcodes/as_ajax_prod.php';       // POSTS, PORTFOLIO AJAXED BY CATEGORIES.
			include VC_ASE_DIR . 'shortcodes/as_filter_prod.php';     // PRODUCTS FILTERED BY CATEGORIES.
			include VC_ASE_DIR . 'shortcodes/as_prod_cats.php';       // PRODUCT  CATEGORIES.
			include VC_ASE_DIR . 'shortcodes/as_single_product.php';  // SINGLE PRODUCT.
			include VC_ASE_DIR . 'shortcodes/as_single_prod_cat.php'; // PRODUCTS FROM SINGLE CATEGORY.
			include VC_ASE_DIR . 'shortcodes/as_prod_category.php';   // SINGLE PRODUCT CATEGORY.
			include VC_ASE_DIR . 'shortcodes/as_wc_catalog_view.php'; // WC CATALOG PAGE VIEW.
		}

		// VC ASE direct functions - include partials for frontend html shortcode rendering:
		include VC_ASE_DIR . 'inc/shortcodes-segments.php';

	}// end if VC_IS_ACTIVE.

}
add_action( 'init', 'vc_ase_init' );
