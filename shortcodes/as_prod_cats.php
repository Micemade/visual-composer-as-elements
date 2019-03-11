<?php
function vc_ase_as_prod_cats_func( $atts, $content = null ) {

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
				'prod_cat_menu'         => 'images',
				'menu_columns'          => 'auto',
				'tax_menu_align'        => 'center',
				'remove_gutter'         => '',
				'text_color'            => '',
				'overlay_color'         => '',
				'overlay_opacity'       => 0,
				'overlay_opacity_hover' => 70,
				'force_hide_desc'       => '',
				'product_cats'          => '',
				'css_classes'           => '',
				'block_id'              => apply_filters( 'vc_ase_randomString', 10 ),

			), $atts
		)
	);

	if ( VC_ASE_WOO_ACTIVE ) {

		//
		// TAXONOMY FILTER ARGS
		if ( isset( $product_cats ) ) {
			$tax_terms = $product_cats;
			$taxonomy  = 'product_cat';
		} else {
			$tax_terms = '';
			$taxonomy  = '';
		}

		####################  HTML STARTS HERE: ###########################

		ob_start();

		echo $css_classes ? '<div class="' . esc_attr( $css_classes ) . '">' : null;

		echo '<div id="prod-cats-' . $block_id . '"  class="vc-ase-element content-block prod-cats row">';

		if ( $tax_terms ) {

			// FIRST - scoped CSS (must be right after opening tag from scoped css - #prod-cats-'.esc_attr($block_id) , in this case )
			if ( $text_color ) {
				echo '<style scoped>';
				echo $text_color ? '#prod-cats-' . esc_attr( $block_id ) . ' ul .category-image .term h4 { color: ' . esc_attr( $text_color ) . ';}' : null;
				echo '</style>';
			}
			if ( $overlay_color ) {
				echo '<style scoped>';
				echo $overlay_color ? '#prod-cats-' . esc_attr( $block_id ) . ' ul .category-image a .item-overlay { background-color: ' . esc_attr( $overlay_color ) . ';}' : null;
				echo '</style>';
			}
			if ( $overlay_opacity || $overlay_opacity_hover ) {
				echo '<style scoped>';
				echo '#prod-cats-' . esc_attr( $block_id ) . ' ul .category-image a .item-overlay { opacity: ' . $overlay_opacity / 100 . '; }';
				echo '#prod-cats-' . esc_attr( $block_id ) . ' ul .category-image a:hover .item-overlay { opacity: ' . $overlay_opacity_hover / 100 . '}';
				echo '</style>';
			}

			do_action( 'vc_ase_block_heading', $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );

			if ( $prod_cat_menu == 'images' ) {
				 $cat_menu_css = 'cat-images';
			} elseif ( $prod_cat_menu == 'no_images' ) {
				$cat_menu_css = 'cat-list';
			} else {
				$cat_menu_css = '';
			}

			// GET TAXONOMY OBJECT:
			$term_Objects  = array();
			$tax_terms_arr = explode( ',', $tax_terms );
			foreach ( $tax_terms_arr as $term ) {
				if ( term_exists( $term, $taxonomy ) ) {
					$term_Objects[] = get_term_by( 'slug', $term, $taxonomy ); // get term object using slug
				}
			}
			// MENU ITEMS COLUMNS
			$grid_cat = $one_per_row = '';

			if ( $menu_columns == 'stretch' ) {
				$grid_cat = ' large-' . floor( 12 / count( $term_Objects ) ) . ' small-12 left';
			} elseif ( $menu_columns == 'auto' ) {
				$grid_cat = '';
			} elseif ( $menu_columns ) {
				$grid_cat = ' large-' . floor( 12 / $menu_columns ) . ' small-12 left';
			}

			$one_per_row = ( $menu_columns == 1 ) ? ' one-item-in-row' : '';

			if ( $prod_cat_menu == 'images' && ! $remove_gutter ) {
				$grid_cat .= ' column';
			}

			echo '<ul class="taxonomy-menu row ' . esc_attr( $cat_menu_css ) . ' ' . esc_attr( $tax_menu_align ) . esc_attr( $one_per_row ) . '">';

			// DISPLAY TAXONOMY MENU:
			$i          = 1;
			$img_width  = $img_width ? $img_width : 300;
			$img_height = $img_height ? $img_height : 180;
			$anim       = ( $enter_anim != 'none' ) ? ' to-anim' : '';

			if ( ! empty( $term_Objects ) ) {

				foreach ( $term_Objects as $term_obj ) {

					$term_link = get_term_link( $term_obj->slug, 'product_cat' );

					if ( is_wp_error( $term_link ) ) {
						continue;
					}

					if ( $prod_cat_menu == 'images' ) { // if images should be displayed:

						$thumbnail_id = get_woocommerce_term_meta( $term_obj->term_id, 'thumbnail_id' );
						$image        = wp_get_attachment_image_src( $thumbnail_id, 'large' ); // attachment image url - $image[0]

						if ( $thumbnail_id ) {

							echo '<li class="category-image anim-wrap' . esc_attr( $grid_cat ) . ' ' . esc_attr( $anim ) . '" data-i="' . $i . '" >';
							echo '<a href="' . esc_url( $term_link ) . '" class="' . esc_attr( $term_obj->slug ) . '" data-id="' . esc_attr( $term_obj->slug ) . '">';

							echo '<div class="item-overlay"></div>';

							echo '<div class="term"><div class="table fullwidth"><div class="tablerow"><div class="tablecell">';

							echo '<h4 class="box-title"><span>' . esc_html( $term_obj->name ) . '</span></h4>';

							echo ! $force_hide_desc ? ( '<p class="block-subtitle">' . esc_html( strip_shortcodes( strip_tags( $term_obj->description ) ) ) . '</p>' ) : '';

							echo '</div></div></div></div>';// end .term and table divs

							// $custom_size = $img_width . 'x' . $img_height; // Deprecated - "Micemade_Custom_Image_Sizes" class in as_vc_init.php
							echo wp_get_attachment_image( $thumbnail_id, array( $img_width, $img_height ) );

							echo '</a>';

							echo '</li>';

						} else {

							echo '<li class="category-image anim-wrap' . esc_attr( $grid_cat ) . ' ' . esc_attr( $anim ) . '" data-i="' . $i . '" >';
							echo '<a href="' . esc_url( $term_link ) . '" class="' . esc_attr( $term_obj->slug ) . '" data-id="' . esc_attr( $term_obj->slug ) . '">';

							echo '<div class="item-overlay"></div>';

							echo '<div class="term"><div class="table fullwidth"><div class="tablerow"><div class="tablecell">';

							echo '<h4 class="box-title"><span>' . esc_html( $term_obj->name ) . '</span></h4>';

							echo '</div></div></div></div>'; // end .term and table divs

							echo '<img src="' . fImg::resize( VC_ASE_PLACEHOLDER_IMAGE, $img_width, $img_height, true ) . '" alt="" />';
							echo '</a>';
							echo '</li>';
						}
					} elseif ( $prod_cat_menu == 'no_images' ) {

						echo '<li class="category-link' . esc_attr( $grid_cat ) . '">';
						echo '<a href="' . esc_url( $term_link ) . '" class="' . esc_attr( $term_obj->slug ) . '" data-id="' . esc_attr( $term_obj->slug ) . '">';
						echo '<div class="term">' . esc_html( $term_obj->name ) . '</div>';
						echo '</a>';
						echo '</li>';

					}
					$i++;
				}
			} else {

				echo '<li class="warning">' . __( 'Product category names (slugs) changed, or no product category exists.', 'vc_ase' ) . '</li>';

			} // end if(!empty($term_Objects))

			echo '</ul>';

		}// endif $tax_terms

		echo '</div>';

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
				var item = thisBlock.find('.category-image');
				
				item.waypoint(
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
				thisBlock.find('.category-image').each( function() {
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

	} else {

		echo '<h5 class="no-woo-notice">' . __( 'PRODUCT CATEGORIES BLOCK DISABLED.<br> Sorry, it seems like WooCommerce is not active. Please install and activate last version of WooCommerce.', 'vc_ase' ) . '</h5>';
			return;
	} // if ( VC_ASE_WOO_ACTIVE )

}

add_shortcode( 'as_prod_cats', 'vc_ase_as_prod_cats_func' );
?>
