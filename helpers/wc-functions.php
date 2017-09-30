<?php
/**
 *  @file wc-functions.php
 *  @brief - functions to extend WooCommerce / VC ASE
 */
/**
 *  WC VERSION CONTROL
 *
 *  @param [string] $vers_to_check - WC version to check
 *  @return $version_is_higher
 *
 */
function vc_ase_wc_version_f( $vers_to_check ) {
	
	if( ! VC_ASE_WOO_ACTIVE ) return;
	
	if( ! defined( 'WOOCOMMERCE_VERSION' ) ) return;
	
	$version_is_higher = false;
	if ( version_compare( WOOCOMMERCE_VERSION, $vers_to_check ) >= 0 ) {
		$version_is_higher = true;
	}
	return $version_is_higher;
}
add_filter( 'vc_ase_wc_version','vc_ase_wc_version_f', 10, 1 );

/**
 * VC_ASE_SHOP_BUTTONS
 * echo shop action buttons - quick view, add to cart, wishlist
 * 
 * @param bovc_asen $shop_quick  
 * @param bovc_asen $shop_buy_action  
 * @param bovc_asen $shop_wishlist  
 * 
 * @return <type>
 */
function vc_ase_shop_buttons_func( $shop_buy_action = true, $shop_wishlist = true, $shop_quick = true, $qv_img_format = "thumbnail"  ) {
	
	
	if( VC_ASE_WPML_ON ) { // if WPML plugin is active
		$id			= icl_object_id( get_the_ID(), 'product', false, ICL_LANGUAGE_CODE ); 
		$lang_code	= ICL_LANGUAGE_CODE;
	}else{
		$id			= get_the_ID();
		$lang_code	= '';
	}
			
	echo '<div class="item-buttons-holder"><div class="button-row">';
	
	if( $shop_buy_action ) {
		echo '<div class="button-cell">';
			do_action( 'woocommerce_after_shop_loop_item' ); // "Add to cart button
		echo '</div>'; // button-cell
	}
	
	if( $shop_quick ) {
		echo '<div class="button-cell">';
		echo '<a href="#qv-holder'.esc_attr($id).'" class="vc-ase-quick-view tip-top" data-id="'.esc_attr($id).'" data-lang="'. esc_attr($lang_code) .'" data-qv_img_format="'.$qv_img_format.'" title="'.__('Quick view','vc_ase').'"><span class="fa fa-eye"></span></a>';
		echo '</div>'; // button-cell
		
		if ( !wp_script_is( 'wc-add-to-cart-variation', 'enqueued' )) {
	
			wp_register_script( 'wc-add-to-cart-variation', WP_PLUGIN_DIR . '/woocommerce/assets/frontend/add-to-cart-variation.min.js');
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			
		}
	}
	
	if( VC_ASE_WISHLIST_ACTIVE && $shop_wishlist ) {
		echo '<div class="button-cell">';
			do_action('vc_ase_wishlist_button'); // Wishlist button
		echo '</div>'; // button-cell
	}
	
	echo '</div></div>'; // .item-buttons-holder
	

} // end shop_buttons()
add_action('vc_ase_shop_buttons','vc_ase_shop_buttons_func',10,3);



/**
 * VC_ASE_SHOP_TITLE_PRICE
 * echo product title (product categories) and price
 * 
 * @param bovc_asen $shop_quick  
 * @param bovc_asen $shop_buy_action  
 * @param bovc_asen $shop_wishlist  
 * 
 * @return <type>
 */
function vc_ase_shop_title_price_func( $shop_quick = true, $shop_buy_action = true, $shop_wishlist = true ){
	
	global $product;
	
	// 3.0.0 < Fallback conditional
	$cats = "";
	if( apply_filters( 'vc_ase_wc_version', '3.0.0' ) ) {
		$cats =  wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' );
	}else{
		$cats = $product->get_categories( ', ', '<span class="posted_in">', '</span>' );
	}
			
	$prod_title = '<h4 class="prod-title"><a href="'. esc_attr(get_permalink()) .'" title="'. the_title_attribute(array('echo' => 0)).'"> ' . esc_html(get_the_title()) .'</a></h4>';
	
	$no_buttons =( !$shop_quick && !$shop_buy_action && !$shop_wishlist ) ?  true : false;
		
	$buttons = $no_buttons ? 'no-buttons' : '';
	echo '<div class="prod-title-price '. esc_attr($buttons) .'">';
						
	echo wp_kses_post( $prod_title );
	
	woocommerce_template_loop_price();

	echo '</div>';

}
add_action('vc_ase_shop_title_price','vc_ase_shop_title_price_func',10,3);

/**
 *	Quick view images
 *
 */
add_action( 'vc_ase_quick_view_images', 'vc_ase_quick_view_images_func', 25, 1 );
function vc_ase_quick_view_images_func( $qv_img_format = "thumbnail" ) {
	
	global $post, $woocommerce, $product ;
		
	// 3.0.0 < Fallback conditional
	if( apply_filters( 'vc_ase_wc_version', '3.0.0' )	) {
		$attachment_ids   = $product->get_gallery_image_ids();
	}else{
		$attachment_ids   = $product->get_gallery_attachment_ids();
	}
	
	echo '<div class="images">';
	
	echo ( $attachment_ids ? '<div class="owl-carousel  productslides">'  : '');
	
	// MAIN PRODUCT IMAGE - POST THUMBNAIL (FEATURED IMAGE ETC.) 
	if ( has_post_thumbnail() ) {

		$post_thumb_id				= get_post_thumbnail_id();
		$default_product_image_src	= wp_get_attachment_image_src( $post_thumb_id, $qv_img_format );
		$default_product_image_url  = $default_product_image_src[0];
		
		$image_link  		= wp_get_attachment_url( $post_thumb_id );
		$image_class 		= 'attachment-' . $post_thumb_id ;
		$image_title 		= strip_tags( get_the_title( $post_thumb_id ) ) ;
		$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', $qv_img_format ), array(
			'title' => esc_attr( $image_title ),
			'alt'	=> esc_attr( $image_title ),
			'class'	=> esc_attr( $image_class. ' featured' )
			) );
		$full_image			= larix_micemade_get_full_img_url();
		$product_title		= esc_attr( strip_tags(get_the_title()));
		$product_link		= esc_attr( get_permalink() );

		echo apply_filters( 'woocommerce_single_product_image_html',sprintf('<div class="item-img"><a href="%2$s" data-o_href="%2$s" data-zoom-image="%4$s" class="larger-image-link woocommerce-main-image zoom" itemprop="image" data-gal="prettyPhoto[pp_gal-'.$post->ID.']" title="%3$s">%1$s</a></div>',
		
			$image,						// %1$s
			$full_image,				// %2$s
			$product_title,				// %3$s
			$default_product_image_url	// %4$s

		),  $post->ID );

	} else {

		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ) );

	}
	
	// PRODUCT GALLERY IMAGES 
	if ( $attachment_ids ) {

		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
			
				continue;
			$image_title = esc_attr( strip_tags( get_the_title( $attachment_id ) ) );
			$image       = wp_get_attachment_image( $attachment_id,  $qv_img_format , array(
				'title' => $image_title
				));
			$image_class = esc_attr( implode( ' ', $classes ) );
			

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="item-img">%4$s</div>', 
			$image_link, 
			$image_class, 
			$image_title, 
			$image ), $attachment_id, $post->ID, $image_class );
			
			$loop++;
		}

	}
	echo '</div></div>';//. images
}
/**
 *	Single product display images
 *	- OWL-Carousel slider images
 *	- used in as-single-product-block.php
 */
add_action( 'vc_ase_single_product_images', 'vc_ase_single_product_images_func', 25, 2 );

function vc_ase_single_product_images_func( $img_format = 'thumbnail', $no_gallery = true ) {
	
	global $post, $product;
	
	
	// images in product gallery:
	// 3.0.0 < Fallback conditional
	if( apply_filters( 'vc_ase_wc_version', '3.0.0' )	) {
		$attachment_ids   = $product->get_gallery_image_ids();
	}else{
		$attachment_ids   = $product->get_gallery_attachment_ids();
	}
	
	$attachment_ids = $no_gallery ? array() : $attachment_ids;
	
	echo '<div class="images">';
	
	echo ( !empty( $attachment_ids ) && !$no_gallery ) ? '<div class="owl-carousel singleslides">': '';
	
	// MAIN PRODUCT IMAGE - post thumbnail (featured image etc.)
	if ( has_post_thumbnail() ) {
	
		$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
		$image_class 		= esc_attr( 'attachment-' . get_post_thumbnail_id() );
		$image_title 		= esc_attr( strip_tags( get_the_title( get_post_thumbnail_id() ) ) );
		$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', $img_format ), array(
			'title' => $image_title
			) );
		$full_image			= apply_filters("vc_ase_get_full_img_url" , get_post_thumbnail_id());
		$product_title		= esc_attr( strip_tags(get_the_title()));
		$product_link		= esc_attr( get_permalink() );
		$attachment_count   = count( $attachment_ids );

		echo apply_filters( 'woocommerce_single_product_image_html',sprintf('<div class="item"><div class="anim-wrap"><div class="item-img"><div class="front">%4$s</div><div class="back"><div class="item-overlay"></div><div class="back-buttons" itemscope><a href="%5$s" data-o_href="%5$s" class="woocommerce-main-image zoom accent-1-light-40" itemprop="image" data-gal="prettyPhoto[pp_gal-'.$post->ID.']" title="%6$s"><div class="fa fa-plus" aria-hidden="true"></div></a>%7$s</div></div></div></div></div>',
		// ending divs: item-img / anim-wrap / item
			$image_link,	// 1
			$image_class,	// 2
			$image_title,	// 3
			$image,			// 4
			$full_image,	// 5
			$product_title,	// 6
			is_product() ? null : '<a href="'.$product_link .'" title="%6$s" class="accent-1-light-30"><div class="icon icon-link" aria-hidden="true"></div></a>'	// 7

		),  $post->ID );

	} else {

		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ) );

	}
	
	/**	Product gallery images */
	
	if ( !empty($attachment_ids) ) {

		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;
			$image_class	= esc_attr( implode( ' ', $classes ) );
			$image_title	= esc_attr( strip_tags(get_the_title()) );
			$image			= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', $img_format ), array(
				'title' => $image_title
				));
			$attachment_src = wp_get_attachment_image_src( $attachment_id, 'large' );
			
			$full_image		= esc_url( $attachment_src[0] );
			$product_title	= esc_attr( strip_tags( get_the_title() ) );
			$product_link	= esc_attr( get_permalink() );
			
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="item"><div class="anim-wrap"><div class="item-img"><div class="front">%4$s</div><div class="back"><div class="item-overlay"></div><div class="back-buttons"><a href="%5$s" data-rel="prettyPhoto[pp_gal-'.$post->ID.']" title="%6$s"><div class="fa fa-plus accent-1-light-30" aria-hidden="true"></div></a> %7$s </div></div></div></div></div>', 
			// ending divs: item-img / anim-wrap / item
				$image_link,	// 1
				$image_class,	// 2
				$image_title,	// 3
				$image,			// 4
				$full_image,	// 5
				$product_title,	// 6
				is_product() ? null : '<a href="'.$product_link .'" title="%6$s"><div class="icon icon-link" aria-hidden="true"></div></a>'	// 7
				
			), $attachment_id, $post->ID, $image_class );
			
			$loop++;
		}

	}
	
	echo ( !empty( $attachment_ids ) && !$no_gallery ) ? '</div>' : ''; //. owl-carousel
	
	echo '</div>';//. images
}
/**
 *	WC Rating
 *
 */
function vc_ase_wc_rating_func() {
	if( function_exists('woocommerce_template_loop_rating') ) {
		echo '<div class="rating-wrapper">';
		woocommerce_template_loop_rating();
		echo '</div>';
	}
}
add_filter('vc_ase_wc_rating','vc_ase_wc_rating_func',10);
/**
 *	WC Sales
 *
 */
function vc_ase_wc_sales_func() {
	if( function_exists('woocommerce_show_product_loop_sale_flash') ) {
		woocommerce_show_product_loop_sale_flash();
	} 
}
add_filter('vc_ase_wc_sales','vc_ase_wc_sales_func',10);

/**
 *  YITH WC WISHLIST FUNCTIONS
 *  
 */

if( VC_ASE_WISHLIST_ACTIVE ) {
	
	add_action('vc_ase_remove_YITH_wishlist_hooks', 'vc_ase_remove_anonymous_YITH_hooks');
	function vc_ase_remove_anonymous_YITH_hooks() {
		
		// vc_ase_remove_anonymous_function_filter - in helpers/helpers.php
		vc_ase_remove_anonymous_function_filter(
			'woocommerce_single_product_summary',
			YITH_WCWL_DIR . 'class.yith-wcwl-init.php',
			31
		);
		vc_ase_remove_anonymous_function_filter(
			'woocommerce_product_thumbnails',
			YITH_WCWL_DIR . 'class.yith-wcwl-init.php',
			21
		);
		vc_ase_remove_anonymous_function_filter(
			'woocommerce_after_single_product_summary',
			YITH_WCWL_DIR . 'class.yith-wcwl-init.php',
			11
		);
		
	}
	
	
	if( !function_exists( 'vc_ase_wishlist_locate_template' ) ) {
		/**
		 * Locate the templates and return the path of the file found
		 *
		 * @param string $path
		 * @param array $var
		 * @return void
		 * @since 1.0.0
		 */
		function vc_ase_wishlist_locate_template( $path, $var = NULL ){
			global $woocommerce;

			if( function_exists( 'WC' ) ){
				$woocommerce_base = WC()->template_path();
			}
			elseif( defined( 'WC_TEMPLATE_PATH' ) ){
				$woocommerce_base = WC_TEMPLATE_PATH;
			}
			else{
				$woocommerce_base = $woocommerce->plugin_path() . '/templates/';
			}

			$template_woocommerce_path =  $woocommerce_base . $path;
			$template_path = '/' . $path;
			$vc_ase_plugin_path = VC_ASE_DIR . 'wishlist-templates/' . $path;
			$plugin_path = YITH_WCWL_DIR . 'templates/' . $path;
			
			$located = locate_template( array(
				$template_woocommerce_path, // Search in <theme>/woocommerce/
				$template_path,             // Search in <theme>/
			) );

			
			if( ! $located && file_exists( $vc_ase_plugin_path ) ){
				return apply_filters( 'vc_ase_wishlist_locate_template', $vc_ase_plugin_path, $path );
			}		
			
			if( ! $located && file_exists( $plugin_path ) ){
				return apply_filters( 'vc_ase_wishlist_locate_template', $plugin_path, $path );
			}
	 
			
			return apply_filters( 'vc_ase_wishlist_locate_template', $located, $path );
		}
	}

	if( !function_exists( 'vc_ase_wishlist_get_template' ) ) {
		/**
		 * Retrieve a template file.
		 * 
		 * @param string $path
		 * @param mixed $var
		 * @param bool $return
		 * @return void
		 * @since 1.0.0
		 */
		function vc_ase_wishlist_get_template( $path, $var = null, $return = false ) {
			$located = vc_ase_wishlist_locate_template( $path, $var );      
			
			if ( $var && is_array( $var ) ) 
				extract( $var );
								   
			if( $return )
				{ ob_start(); }   
																		 
			// include file located
			include( $located );
			
			if( $return )
				{ return ob_get_clean(); }
		}
	}
		
	
	
	/**
	 *	YITH WC Wishlist template - a template for add to Wishlist
	 *  
	 *  @return void
	 */
	
	add_action('vc_ase_wishlist_button','vc_ase_wishlist_button_func', 10);
	function vc_ase_wishlist_button_func() {
		
		vc_ase_wishlist_get_template( 'add-to-wishlist.php' );
		
	}
	
	
} // end if( VC_ASE_WISHLIST_ACTIVE )
?>