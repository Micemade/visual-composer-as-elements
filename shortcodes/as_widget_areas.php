<?php
function vc_ase_as_widget_areas_func( $atts, $content = null ) {

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

				'css'                 => '',
				'widget_area'         => '',
				'widgets_align'       => 'align_left',
				'orientation'         => 'vertical',
				'widg_margin_top'     => '',
				'widg_margin_bottom'  => '',

				'css_classes'         => '',
				'block_id'            => apply_filters( 'vc_ase_randomString', 10 ),

			), $atts
		)
	);

	####################  HTML STARTS HERE: #########################

	ob_start();

	$vc_css_class = vc_shortcode_custom_css_class( $css, ' ' );

	echo ( $css_classes || $vc_css_class ) ? '<div class="' . esc_attr( $css_classes . $vc_css_class ) . ' custom-widget-wrap">' : null;

	do_action( 'vc_ase_block_heading', $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );

	echo '<div class="vc-ase-element custom-widget-area widget-area ' . esc_attr( $orientation ) . ' ' . esc_attr( $widgets_align ) . '" id="widgets-elm-' . $block_id . '">';

	echo '<style scoped>';

	if ( $widg_margin_top || $widg_margin_bottom ) {
		echo '#widgets-elm-' . esc_attr( $block_id ) . '  aside, #widgets-elm-' . esc_attr( $block_id ) . ' section { ';
		echo $widg_margin_top ? ( 'margin-top:' . $widg_margin_top . ';' ) : '';
		echo $widg_margin_bottom ? ( 'margin-bottom:' . $widg_margin_bottom . ';' ) : '';
		echo '}';
	}
	echo '</style>';

	if ( is_active_sidebar( $widget_area ) ) {

		dynamic_sidebar( $widget_area );

	}

	echo '</div>';

	####################  HTML ENDS HERE: ###########################
	echo ( $css_classes || $vc_css_class ) ? '</div>' : null;

	$output_string = ob_get_contents();

	ob_end_clean();

	return $output_string;
	####################  HTML ENDS HERE: ###########################

}

add_shortcode( 'as_widget_areas', 'vc_ase_as_widget_areas_func' );

