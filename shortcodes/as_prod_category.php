<?php
/**
 * as_prod_cat_single_func
 * - DISPLAY SINGLE CATEGORY WITH ITS IMAGE
 *
 * @param array $atts
 * @param string $content
 *
 * @return string $output_string
 */
function vc_ase_as_prod_cat_single_func( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'title'                 => '',
				'subtitle'              => '',
				'sub_position'          => 'bellow',
				'title_style'           => 'center',
				'title_custom_css'      => '',
				'subtitle_custom_css'   => '',
				'title_color'           => '',
				'subtitle_color'        => '',
				'title_size'            => '',
				'heading_css'           => '',

				'enter_anim'            => 'none',
				'img_width'             => '',
				'img_height'            => '',
				'text_color'            => '',
				'overlay_color'         => '',
				'overlay_opacity'       => 0,
				'overlay_opacity_hover' => 70,
				'product_cats'          => '',
				'force_hide_desc'       => '',
				'css_classes'           => '',
				'block_id'              => apply_filters( 'vc_ase_randomString', 10 ),

			), $atts
		)
	);

	####################  HTML STARTS HERE: ###########################

	ob_start();

	$img_width  = $img_width ? $img_width : 300;
	$img_height = $img_height ? $img_height : 180;

	$anim = ( $enter_anim != 'none' ) ? ' to-anim' : '';

	echo $css_classes ? '<div class="' . esc_attr( $css_classes ) . '">' : null;

	echo '<div id="prod-cats-' . $block_id . '"  class="vc-ase-element content-wrapper single-prod-category">';

		do_action( 'vc_ase_block_heading', $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );

	// CHECK IF THERE TERM EXISTS - when categories are changed, VC elements must be updated.
	if ( term_exists( $product_cats, 'product_cat' ) ) {

		// set styles
		if ( $text_color ) {
			echo '<style scoped>';
			echo $text_color ? '#prod-cats-' . esc_attr( $block_id ) . ' .category-image .term h4 { color: ' . esc_attr( $text_color ) . ';}' : null;
			echo '</style>';
		}
		if ( $overlay_color ) {
			echo '<style scoped>';
			echo $overlay_color ? '#prod-cats-' . esc_attr( $block_id ) . ' .category-image a .item-overlay { background-color: ' . esc_attr( $overlay_color ) . ';}' : null;
			echo '</style>';
		}
		if ( $overlay_opacity || $overlay_opacity_hover ) {
			echo '<style scoped>';
			echo '#prod-cats-' . esc_attr( $block_id ) . ' .category-image a .item-overlay { opacity: ' . $overlay_opacity / 100 . '; }';
			echo '#prod-cats-' . esc_attr( $block_id ) . ' .category-image a:hover .item-overlay { opacity: ' . $overlay_opacity_hover / 100 . '}';
			echo '</style>';
		}

		// GET TAXONOMY OBJECT:
		$prod_cat_object = get_term_by( 'slug', $product_cats, 'product_cat' ); // get term object using slug

		$term_link = get_term_link( $prod_cat_object->slug, 'product_cat' );

		if ( is_wp_error( $term_link ) ) {
			return;
		}

		$thumbnail_id = get_woocommerce_term_meta( $prod_cat_object->term_id, 'thumbnail_id' );

		echo '<div class="anim-wrap ' . esc_attr( $anim ) . '"><div class="cat-images">';

		if ( $thumbnail_id ) {

			echo '<div class="category-image">';

			echo '<a href="' . esc_url( $term_link ) . '" class="' . esc_attr( $prod_cat_object->slug ) . '" data-id="' . esc_attr( $prod_cat_object->slug ) . '">';

			echo '<div class="item-overlay"></div>';

			echo '<div class="term"><div class="table"><div class="tablerow"><div class="tablecell">';

			echo '<h4 class="box-title"><span>' . esc_html( $prod_cat_object->name ) . '</span></h4>';

			echo ! $force_hide_desc ? ( '<p class="block-subtitle">' . esc_html( strip_shortcodes( strip_tags( $prod_cat_object->description ) ) ) . '</p>' ) : '';

			echo '</div></div></div></div>'; // .tablecell .tablerow .table .term

			// $custom_size = $img_width . 'x' . $img_height; // Deprecated - "Micemade_Custom_Image_Sizes" class in as_vc_init.php
			echo wp_get_attachment_image( $thumbnail_id, array( $img_width, $img_height ) );

			echo '</a>';// .category-image

			echo '</div>';

		} else {

			echo '<a href="' . esc_url( $term_link ) . '" class="' . esc_attr( $prod_cat_object->slug ) . '" data-id="' . esc_attr( $prod_cat_object->slug ) . '">';

			echo '<div class="item-overlay"></div>';

			echo '<div class="term"><div class="table"><div class="tablerow"><div class="tablecell">';

			echo '<h4 class="box-title"><span>' . esc_html( $prod_cat_object->name ) . '</span></h4>';

			echo '</div></div></div></div>';// .tablecell .tablerow .table .term

			echo '<img src="' . fImg::resize( VC_ASE_PLACEHOLDER_IMAGE, $img_width, $img_height, true ) . '" alt="" />';
			echo '</a>';
		}
	} else {

		echo '<p class="warning">' . __( "Product category name (slug) has changed, category doesn't exist, or doesn't contain any products.", 'vc_ase' ) . '</p>';

	}// end if term exists

	 echo '</div></div>'; // .cat-images // .anim-wrap

	 echo '</div>'; // .single-prod-category

	?>
	
	<?php
	####################  HTML ENDS HERE: ###########################
	echo $css_classes ? '</div>' : null;
	?>
	
	<?php if ( $enter_anim != 'none' ) { ?>
	<script>
	(function( $ ){
		$.fn.anim_waypoints_prod_cat = function(blockId, enter_anim) {
			
			var thisBlock = $('#prod-cats-'+ blockId );
			if ( !window.vcase_isMobile && !window.isIE9 ) {
				var anim_wrap = thisBlock.find('.anim-wrap');
				
				anim_wrap.waypoint(
					function(direction) {
						var item_ = $(this);
						if( direction === "up" ) {	
							item_.removeClass('animated '+ enter_anim).addClass('to-anim');
						}else if( direction === "down" ) {
							var i =  $(this).attr('data-i');
							setTimeout(function(){
							   item_.addClass('animated '+ enter_anim).removeClass('to-anim');
							}, 50 * i);
						}
					}
					
				,{ offset: "98%" });
			}else{
				thisBlock.find('.anim-wrap').each( function() {
					$(this).removeClass('to-anim');
				});
			}
			
		}
	})( jQuery );
	
	jQuery(document).ready( function($) {
		
		$(document).anim_waypoints_prod_cat("<?php echo esc_js( $block_id ); ?>"," <?php echo esc_js( $enter_anim ); ?>");
	
	});
	</script>
	<?php } ?>

	<?php

	$output_string = ob_get_contents();

	ob_end_clean();

	return $output_string;

}

add_shortcode( 'as_prod_cat_single', 'vc_ase_as_prod_cat_single_func' );
?>
