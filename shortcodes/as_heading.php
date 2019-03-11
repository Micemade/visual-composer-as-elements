<?php
function vc_ase_as_heading_func( $atts, $content = null ) {

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
				'bck_color'           => '',
				'tag'                 => '',
				'enter_anim'          => 'none',
				'anim_delay'          => 0,
				'type_eff'            => '',

				'title_size'          => 'normal',
				'abs_heading'         => '',
				'abs_top'             => '',
				'abs_left'            => '',
				'abs_right'           => '',

				'css'                 => '',
				'css_classes'         => '',
				'block_id'            => apply_filters( 'vc_ase_randomString', 10 ),

			), $atts
		)
	);

	$vc_css_class = vc_shortcode_custom_css_class( $css, ' ' );

	####################  HTML STARTS HERE: #########################

	ob_start();
	echo $css_classes ? '<div class="' . esc_attr( $css_classes ) . '">' : null;
	?>



<div class="vc-ase-element header-holder <?php echo esc_attr( $title_style . $vc_css_class ); ?> titles-holder<?php echo $abs_heading ? ' absolute' : ''; ?>" id="heading-<?php echo esc_attr( $block_id ); ?>">

	<?php
	if ( $abs_heading || $bck_color ) {
		echo '<style scoped>';
		echo '#heading-' . $block_id . ' {';
		echo $abs_top ? 'top:' . $abs_top . ';' : '';
		echo $abs_left ? 'left:' . $abs_left . ';' : '';
		echo $abs_right ? 'right:' . $abs_right . ';' : '';
		echo $bck_color ? 'background-color: ' . $bck_color . ';' : '';
		echo '}';
		echo '</style>';
	}
	?>
	
	<div class="anim-wrap<?php echo ( $enter_anim == 'none' ? '' : ' to-anim' ); ?>">
	
		<?php
		// DISPLAY BLOCK TITLE AND "SUBTITLE":
		$without_title = ! $title && $subtitle ? ' without-title' : '';

		$sub = $subtitle ? '<div class="block-subtitle ' . esc_attr( $sub_position ) . ' ' . esc_attr( $title_style ) . esc_attr( $without_title ) . esc_attr( ' ' . $subtitle_custom_css ) . '"' . ( $subtitle_color ? ' style="color:' . $subtitle_color . ';"' : '' ) . '>' . esc_html( $subtitle ) . '</div>' : '';

		$title_css  = 'style="';
		$title_css .= $title_color ? 'color:' . esc_attr( $title_color ) . '; ' : '';
		$title_css .= '"';

		echo $sub_position == 'above' ? wp_kses_post( $sub ) : '';

		$span_start = $title_size ? '<span style="font-size: ' . esc_attr( $title_size ) . '">' : '';
		$span_end   = $title_size ? '</span>' : '';

		// TYPEWRITER EFFECT:
		if ( $type_eff ) {
			$type_text_arr = array();
			$type_text_arr = explode( '|', $title );
			$last          = end( $type_text_arr );
			$type_text     = '';
			foreach ( $type_text_arr as $type ) {

				$type_text .= '"' . $type . '"' . ( ( $type !== $last ) ? ',' : '' );
			}
		}

		$h = $tag ? $tag : 'h3';
		echo $title ? '<' . $h . ' class="block-title ' . esc_attr( $title_style ) . esc_attr( ' ' . $title_custom_css ) . '" ' . $title_css . ' data-shadow-text="' . esc_attr( $title ) . '">' . $span_start . ( ! $type_eff ? wp_kses_post( $title ) : '' ) . $span_end . '</' . $h . '>' : '';

		echo $sub_position == 'bellow' ? wp_kses_post( $sub ) : '';
		?>
		
	</div>
	
</div> 

	<?php $delay = $anim_delay ? $anim_delay : 100; ?>

<script>
jQuery(document).ready( function($) {

var thisBlock = $('#heading-<?php echo esc_js( $block_id ); ?>');

if ( !window.vcase_isMobile && !window.isIE9 ) {

	var anim_wrap = thisBlock.find('.anim-wrap');
	
	thisBlock.waypoint(
	
		function(direction) {
			
			if( direction === "up" ) {	
				
				anim_wrap.removeClass('animated <?php echo esc_js( $enter_anim ); ?>').addClass('to-anim');
				
			}else if( direction === "down" ) {
				
				setTimeout(function(){
				   anim_wrap.addClass('animated <?php echo esc_js( $enter_anim ); ?>').removeClass('to-anim');
				}, <?php echo esc_js( $delay ); ?>);
			}
		}, 
		{ offset: "98%" }	
	
	);

}else{

	anim_wrap.each( function() {
		
		$(this).removeClass('to-anim');
	
	});
	
}

});
</script>

	<?php
	// TYPEWRITTER EFFECT SCRIPTS:
	if ( $type_eff && $title ) {
		?>
<script>
(function($) {
		
	"use strict";
	
	$(document).ready( function($) {
		$(function(){
			
			var thisBlock	= $('#heading-<?php echo esc_js( $block_id ); ?>'),
				type_elm	= thisBlock.find(".block-title span");
				
			
			type_elm.typed({
				strings		: [<?php echo wp_kses_post( $type_text ); ?>],
				typeSpeed	: 150,
				backSpeed	: 0,
				backDelay	: 3000,
				loop		: true,
				preStringTyped: function() {
					var cursor		= thisBlock.find(".typed-cursor");
					cursor.css("font-size" , <?php echo $title_size ? '"' . esc_js( $title_size ) . '"' : '"100%"'; ?>);					
				},
			});
			
		});
	});
})( jQuery );
</script>
<?php } ?>

	<?php
	####################  HTML ENDS HERE: ###########################
	echo $css_classes ? '</div>' : null;

	$output_string = ob_get_contents();

	ob_end_clean();

	return $output_string;
	####################  HTML ENDS HERE: ###########################

}

add_shortcode( 'as_heading', 'vc_ase_as_heading_func' );
?>
