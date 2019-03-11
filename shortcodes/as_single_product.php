<?php
function vc_ase_as_single_prod_func( $atts, $content = null ) {

	global $post, $wp_query;

	extract(
		shortcode_atts(
			array(
				'title'           => '',
				'subtitle'        => '',
				'sub_position'    => 'bellow',
				'title_style'     => 'center',
				'title_color'     => '',
				'subtitle_color'  => '',
				'title_size'      => '',

				'enter_anim'      => 'none',
				'block_style'     => 'images_right',

				'img_format'      => 'thumbnail',
				'no_gallery'      => '',
				'slider_navig'    => '',
				'slider_pagin'    => '',
				'slider_timing'   => '',

				'back_color'      => '',

				'product_options' => 'reduced',
				'hide_short_desc' => '',
				'hide_image'      => '',
				'single_product'  => '',

				'css'             => '',
				'css_item_data'   => '',
				'css_classes'     => '',
				'block_id'        => apply_filters( 'vc_ase_randomString', 10 ),

			), $atts
		)
	);

	$content = wpb_js_remove_wpautop( $content, true );

	// Enqueue variation scripts
	wp_enqueue_script( 'wc-add-to-cart-variation' );

	####################  HTML STARTS HERE: ###########################
	ob_start();

	echo $css_classes ? '<div class="' . esc_attr( $css_classes ) . '">' : null;

	do_action( 'vc_ase_block_heading', $title, $subtitle, $title_style, $sub_position, $title_color, $subtitle_color, $title_size );

	$vc_css_class           = vc_shortcode_custom_css_class( $css, ' ' );
	$vc_css_item_data_class = vc_shortcode_custom_css_class( $css_item_data, ' ' );
	?>
	
	<?php echo '<input type="hidden" class="single-prod-data" data-block_id="' . esc_attr( $block_id ) . '" data-single_product="' . esc_attr( $single_product ) . '" data-block_style="' . esc_attr( $block_style ) . '" data-back_color="' . esc_attr( $back_color ) . '" data-hide_image ="' . esc_attr( $hide_image ) . '" data-img_format ="' . esc_attr( $img_format ) . '" data-no_gallery ="' . ( $no_gallery ? '1' : '0' ) . '" data-slider_navig ="' . ( $slider_navig ? '0' : '1' ) . '" data-slider_pagin ="' . ( $slider_pagin ? '0' : '1' ) . '" data-slider_timing ="' . esc_attr( $slider_timing ) . '" data-product_options ="' . esc_attr( $product_options ) . '" data-hide_short_desc ="' . ( $hide_short_desc ? '1' : '0' ) . '" data-vc_css_item_data_class ="' . esc_attr( $vc_css_item_data_class ) . '">'; ?>
	
	<?php

	if ( $back_color ) {

		if ( $block_style == 'images_right' ) {
			$arrow_color = 'border-left-color: ' . $back_color . '  !important;';
		} elseif ( $block_style == 'images_left' ) {
			$arrow_color = 'border-right-color: ' . $back_color . '  !important;';
		} elseif ( $block_style == 'centered' ) {
			$arrow_color = 'border-bottom-color: ' . $back_color . '  !important;';
		} elseif ( $block_style == 'centered_alt' ) {
			$arrow_color = 'border-top-color: ' . $back_color . '  !important;';
		} else {
			$arrow_color = '';
		}
		$block_css  = '<style>';
		$block_css .= '#' . esc_attr( $block_id ) . ' .anim-wrap { background-color: ' . $back_color . ' !important;}';
		$block_css .= '#' . esc_attr( $block_id ) . '.single-item-element .images-holder:after { ' . $arrow_color . '  opacity: 1 !important; 
		}';
		$block_css .= '@media only screen and (max-width: 48.0625em) { ';
		$block_css .= '#' . esc_attr( $block_id ) . '.single-item-element .images-holder:before {';
		$block_css .= 'border-bottom-color: ' . $back_color . '  !important; }';
		$block_css .= '} ';
		$block_css .= '</style>';

		add_action( 'wp_print_scripts', $block_css );
	}

	?>
	
	<div id="<?php echo esc_attr( $block_id ); ?>" class="vc-ase-element content-block single-item-element woocommerce <?php echo esc_attr( $vc_css_class ); ?>">
	
		<?php vc_ase_single_product( $block_id, $single_product, $block_style, $back_color, $hide_image, $img_format, $no_gallery, $slider_navig, $slider_pagin, $slider_timing, $product_options, $hide_short_desc, $vc_css_item_data_class ); ?>
	
	</div><!-- /.single-item-block -->
	
	
	
	<?php
	####################  HTML ENDS HERE: ###########################
	echo $css_classes ? '</div>' : null;

	####################  HTML OUTPUT ENDS HERE: #########################

	$output_string = ob_get_contents();

	ob_end_clean();

	return $output_string;
}

add_shortcode( 'as_single_prod', 'vc_ase_as_single_prod_func' );
