<?php
function vc_ase_as_menu_func( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'title'               => '',
				'subtitle'            => '',
				'sub_position'        => 'bellow',
				'title_style'         => 'center',
				'title_custom_css'    => '',
				'subtitle_custom_css' => '',
				'title_color'         => '',
				'subtitle_color'      => '',
				'title_size'          => '',
				'heading_css'         => '',

				'enter_anim'          => 'none',

				'menu'                => 'none',
				'orientation'         => 'vertical',

				'menu_holder_css'     => '',
				'css_classes'         => '',
				'block_id'            => apply_filters( 'vc_ase_randomString', 10 ),

			), $atts
		)
	);

	$vc_menu_holder_css = vc_shortcode_custom_css_class( $menu_holder_css, ' ' );

	####################  HTML STARTS HERE: #########################
	ob_start();
	echo $css_classes ? '<div class="' . esc_attr( $css_classes ) . '">' : null;

	do_action( 'vc_ase_block_heading', $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );

	echo '<div class="vc-ase-element custom-menu ' . esc_attr( $orientation ) . ' ' . ( $vc_menu_holder_css ? esc_attr( $vc_menu_holder_css ) : '' ) . '">';

	wp_nav_menu(
		array(
			'theme_location' => 'custom-menu' . $block_id,
			'menu'           => $menu,
			'link_before'    => '',
			'link_after'     => '',
			'menu_id'        => 'menu' . $block_id,
			'menu_class'     => 'custom-nav navigation vertical',
			'container'      => false,
		)
	);

	echo '</div>';

	####################  HTML ENDS HERE: ###########################
	echo $css_classes ? '</div>' : null;

	$output_string = ob_get_contents();

	ob_end_clean();

	return $output_string;
	####################  HTML ENDS HERE: ###########################

}

add_shortcode( 'as_menu', 'vc_ase_as_menu_func' );

