<?php
/**
 * @var $this WPBakeryShortCode_VC_Column
 */
$output = $font_color = $el_class = $width = $offset = '';
extract(
	shortcode_atts(
		array(
			'font_color'        => '',
			'el_class'          => '',
			'width'             => '1/1',
			'css'               => '',
			'offset'            => '',

			// VC ASE SETTING:
			'col_overlay_color' => '',
			'column_sticked'    => '',
			'no_spacing'        => '',
			'col_z_index_above' => '',
			// MICEMADE themes
			'as_theme_larix'    => '',
		), $atts
	)
);

// AS THEMES SUPPORT:
$as_theme_css = $as_theme_larix ? ( ' ' . $as_theme_larix ) : '';

$column_id = apply_filters( 'vc_ase_randomString', 10 );

$el_class  = $this->getExtraClass( $el_class );
$width     = wpb_translateColumnWidthToSpan( $width );
$width     = vc_column_offset_class_merge( $offset, $width );
$el_class .= ' wpb_column vc_column_container';
$el_class .= $col_z_index_above ? ' z-index-above' : '';

$style        = $this->buildStyle( $font_color );
$css_class    = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class, $this->settings['base'], $atts );
$custom_class = vc_shortcode_custom_css_class( $css, ' ' );
$output      .= "\n\t" . '<div class="' . $css_class . ' ' . $custom_class . ( $no_spacing ? ' no-spacing' : '' ) . esc_attr( $as_theme_css ) . '"' . $style . ' id="column-' . $column_id . '" data-equalizer-watch>';


$output .= $font_color ? '<style scoped>#column-' . $column_id . ' .block-title, #column-' . $column_id . ' p, #column-' . $column_id . ' a:not(.tip-top) { color: ' . $font_color . '; }</style>' : '';

$output .= $col_overlay_color ? ( '<div class="column-overlay" style="background-color:' . $col_overlay_color . '"></div>' ) : '';

$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= $column_sticked ? "\n\t\t\t" . '<div class="special-stick">' : '';

$output .= "\n\t\t\t\t" . wpb_js_remove_wpautop( $content );

$output .= $column_sticked ? "\n\t\t\t" . '</div> ' . $this->endBlockComment( '.special-stick' ) : '';
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( $el_class ) . "\n";
echo $output;

