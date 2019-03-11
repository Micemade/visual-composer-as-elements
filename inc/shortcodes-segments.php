<?php
/**
 *  CUSTOM MENU CSS TO BODY TAG
 */
function vc_ase_custom_menu_body_class( $c ) {
	global $post;
	if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'as_menu' ) ) {
		$c[] = 'has-custom-menu';
	}
	return $c;
}
add_filter( 'body_class', 'vc_ase_custom_menu_body_class' );

/**
 *  HEADINGS for all the blocks
 */
function vc_ase_block_heading_func( $title = '', $subtitle = '', $title_style = '', $sub_position = '', $title_custom_css = '', $subtitle_custom_css = '', $title_color = '', $subtitle_color = '', $title_size = '', $heading_css = '' ) {

	if ( ! $title && ! $subtitle ) {
		return;
	}

	$vc_css_class = vc_shortcode_custom_css_class( $heading_css, ' ' );

	$without_title = ! $title && $subtitle ? ' without-title' : '';

	$heading = '<div class="header-holder ' . $title_style . ' titles-holder' . esc_attr( $vc_css_class ) . '">';

	// DISPLAY BLOCK TITLE AND "SUBTITLE":
	$sub = $subtitle ? '<div class="block-subtitle ' . esc_attr( $sub_position ) . ' ' . esc_attr( $title_style ) . esc_attr( $without_title ) . esc_attr( ' ' . $subtitle_custom_css ) . '"' . ( esc_attr( $subtitle_color ) ? ' style="color:' . esc_attr( $subtitle_color ) . ';"' : '' ) . '>' . esc_html( $subtitle ) . '</div>' : '';

	$title_css  = 'style="';
	$title_css .= $title_color ? 'color:' . esc_attr( $title_color ) . '; ' : '';
	$title_css .= '"';

	$heading .= $sub_position == 'above' ? $sub : '';

	$span_start = $title_size ? '<span style="font-size: ' . esc_attr( $title_size ) . '">' : '';
	$span_end   = $title_size ? '</span>' : '';

	$heading .= $title ? '<h3 class="block-title ' . esc_attr( $title_style ) . esc_attr( ' ' . $title_custom_css ) . '" ' . $title_css . ' data-shadow-text="' . esc_attr( $title ) . '">' . $span_start . esc_html( $title ) . $span_end . '</h3>' : '';

	$heading .= $sub_position == 'bellow' ? $sub : '';

	$heading .= '</div>';

	echo wp_specialchars_decode( $heading );

}
add_action( 'vc_ase_block_heading', 'vc_ase_block_heading_func', 10, 10 );

