<?php
function vc_ase_as_ajax_prod_func( $atts, $content = null ) { 
  
	global $post ;

		extract( shortcode_atts( array(
			'title'				=> '',
			'subtitle'			=> '',
			'sub_position'		=> 'bellow',
			'title_style'		=> 'center',
			'title_custom_css'	=> '',
			'subtitle_custom_css'=> '',
			'title_color'		=> '',
			'subtitle_color'	=> '',
			'title_size'		=> '',
			'heading_css'		=> '',
			
			'enter_anim'		=> 'none',
			'product_cats'		=> '',
			
			'prod_cat_menu'		=> 'none',
			'menu_columns'		=> 'auto',
			'tax_menu_align'	=> 'center',
			'remove_gutter'		=> '',
			'img_format'		=> 'thumbnail',
			'qv_img_format'		=> 'thumbnail',
			
			'anim'				=> 'no-hover-anim',
			
			'filters'			=> 'latest',
			'shop_quick'		=> '',
			'shop_buy_action'	=> '',
			'shop_wishlist'		=> '',
			
			'total_items'		=> '',
			'hide_slider'		=> '',
			'slider_navig'		=> '',
			'slider_pagin'		=> '',
			'slider_timing'		=> '',
			
			'items_desktop'		=> '',
			'items_tablet'		=> '',
			'items_mobile'		=> '',
			
			'text_color'		=> '',
			'overlay_color'		=> '',
			'overlay_opacity'	=> 0,
			'overlay_opacity_hover'=> 70,
			'button_label'		=> '',
			'ap_link_button'	=> '',
			'btn_css'			=> '',
			
			'css_classes'		=> '',
			'block_id'			=> apply_filters( 'vc_ase_randomString',10 )
			  
		), $atts ) );
	
	
		$content = wpb_js_remove_wpautop($content, true);
		
		$button 	= vc_build_link( $ap_link_button );
		$but_url		= $button['url'];
		$but_title		= $button['title'];
		$but_target		= $button['target'];
		$btn_vc_css_class =  vc_shortcode_custom_css_class( $btn_css, ' '  );
		
		$total_items = $total_items ? $total_items : -1;

		// Enqueue WC image gallery scripts:
		$list = 'enqueued';
		if( $shop_quick == 'yes' ) {
			if( !wp_script_is('zoom', $list) ) {
				wp_enqueue_script( 'zoom' );
			}
			if( !wp_script_is('flexslider', $list) ) {
				wp_enqueue_script( 'flexslider' );
			}
			if( !wp_script_is('photoswipe-ui-default', $list) ) {
				wp_enqueue_script( 'photoswipe-ui-default' );
				wp_enqueue_style( 'photoswipe-default-skin' );
				add_action( 'wp_footer', 'woocommerce_photoswipe' );
			}
			if( !wp_script_is('wc-single-product', $list) ) {
				wp_enqueue_script( 'wc-single-product' );
			}
		}

		// SET POST TYPE VARIABLE
		$post_type = 'product';
		
		// PRODUCT FILTERS:
		$order_rand	= false;
		$args_filters = array();
		if ( $filters == 'featured' ){
			
			$args_filters['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
			);
			
		}elseif( $filters == 'on_sale' ) {
			
			$product_ids_on_sale    = wc_get_product_ids_on_sale();
			if( ! empty( $product_ids_on_sale ) ) {
				$args_filters['post__in'] = $product_ids_on_sale;
			}
		
		}elseif( $filters == 'best_sellers' ) {
			
			$args_filters['meta_key']	= 'total_sales';
			$args_filters['orderby']	= 'meta_value_num';
		
		}elseif( $filters == 'best_rated' ) {
			
			$args_filters['meta_key']	= '_wc_average_rating';
			$args_filters['orderby']	= 'meta_value_num';
			
		}elseif( $filters == 'random' ) {
		
			$order_rand	= true;
			$args_filters = array();
			$args_filters['orderby'] = 'rand menu_order date';
			
		}
		// end filters
		
		//
		// TAXONOMY FILTER ARGS
		if( $product_cats ){
			$tax_terms = $product_cats;
			$taxonomy = 'product_cat';
		}else{
			$tax_terms = '';
			$taxonomy = '';
		}
		
		####################  HTML STARTS HERE: ###########################
		ob_start();
		
		echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;
		
		echo '<div id="products-'. esc_attr($block_id) .'" class="vc-ase-element content-block ajax-prods'. ( $remove_gutter ? ' remove-gutter' : '' ) . '" >';
		
		do_action('vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );
				
		########## TAXONOMY (PRODUCT CATEGORIES) MENU CREATING ##########
		$tax_terms_arr = explode(',', $tax_terms );
		
		if( $tax_terms && $prod_cat_menu != 'none' ) {
		
		if( $prod_cat_menu == 'images' ){

			$cat_menu_css = 'cat-images';
			
		}elseif( $prod_cat_menu == 'no_images') {
			
			$cat_menu_css = 'cat-list' . ( $remove_gutter ? '' : ' column' ) ;
			
		}else{
			$cat_menu_css = '';
		}
		
		
		if ( $text_color ) {
			echo '<style scoped>';
			echo $text_color ? '#products-'.esc_attr($block_id).' ul .category-image .term h4 { color: '.esc_attr($text_color).';}' : null;
			echo '</style>';
		}
		if ( $overlay_color ) {
			echo '<style scoped>';
			echo $overlay_color ? '#products-'.esc_attr($block_id).' ul .category-image a .item-overlay { background-color: '.esc_attr($overlay_color).';}' : null;
			echo '</style>';
		}
		if ( $overlay_opacity || $overlay_opacity_hover ) {
			echo '<style scoped>';
			echo '#products-'.esc_attr($block_id).' ul .category-image a .item-overlay { opacity: '. $overlay_opacity / 100 .'; }';
			echo '#products-'.esc_attr($block_id).' ul .category-image a:hover .item-overlay { opacity: '. $overlay_opacity_hover / 100 .'}';
			echo '</style>';
		}
		
		// GET TAXONOMY OBJECT:
		$term_Objects = array();
		
		foreach ( $tax_terms_arr as $term ) {
			if( term_exists( $term,  $taxonomy ) ) {
				$term_Objects[] = get_term_by( 'slug', $term, $taxonomy ); // get term object using slug
			}
		}
		
		// MENU ITEMS COLUMNS	
		$grid_cat = $one_per_row = '';
			
		if( $menu_columns == 'stretch' ){
			$grid_cat	= ' large-' . floor( 12 / count($term_Objects) ) . ' small-12 left';
		}elseif( $menu_columns == 'auto' ) {
			$grid_cat	= '';
		}elseif( $menu_columns ) {
			$grid_cat	= ' large-' . floor( 12 / $menu_columns ) . ' small-12 left';
		}
			
		$one_per_row = ( $menu_columns == 1 ) ? ' one-item-in-row' : '';


		if( $prod_cat_menu == 'images' && !$remove_gutter ) {
			$grid_cat .= ' column';
		}
		
		echo '<ul class="taxonomy-menu '. esc_attr($cat_menu_css) .' '.esc_attr($tax_menu_align) . esc_attr( $one_per_row ) .'">';
		
		
		$num_terms = count($term_Objects);

		// DISPLAY TAXONOMY MENU:
		if( !empty( $term_Objects ) ) {
		
			if( $prod_cat_menu == 'no_images' ) {
				
				echo '<li><a href="#" class="ajax-products active"'. ( !empty( $tax_terms_arr ) ? ' data-id="' . implode(",", $tax_terms_arr) .'"' : '' ) . '>';
				echo '<div class="term">' . __('All','vc_ase') . '</div>';
				echo '</a></li>';
			} 
			
			
			foreach ( $term_Objects as $term_obj ) {
								
				if( $prod_cat_menu == 'images' ) { // if images should be displayed:
				
					$thumbnail_id = get_woocommerce_term_meta( $term_obj->term_id, 'thumbnail_id' );
					//$image = wp_get_attachment_image_src( $thumbnail_id, 'large' ); // attachment image url - $image[0]

					if ( $thumbnail_id ) {
			
						echo '<li class="category-image '. $grid_cat .'">';
						
						echo ($num_terms > 1) ? '<a href="#" class="'.$term_obj->slug .' ajax-products" data-id="'. $term_obj->slug .'">' : '<div>';
						
						echo '<div class="item-overlay"></div>';
						
						echo '<div class="term"><div class="table fullwidth"><div class="tablerow"><div class="tablecell">';
						
						echo '<h4 class="box-title"><span>' . $term_obj->name . '</span></h4></div></div></div></div>';

						echo wp_get_attachment_image( $thumbnail_id, array(600,250) );
						
						echo ( $num_terms > 1 ) ? '</a>' : '</div>';						
						
						echo '</li>';
						
					}else{
					
						echo '<li class="category-image '. $grid_cat .'">';
						
						echo ($num_terms > 1) ? '<a href="#" class="'.$term_obj->slug .' ajax-products" data-id="'. $term_obj->slug .'">' : '<div>';
						
						echo '<div class="item-overlay"></div>';
						
						echo '<div class="term"><div class="table fullwidth"><div class="tablerow"><div class="tablecell">';
						
						echo '<h4 class="box-title"><span>' . $term_obj->name . '</span></h4></div></div></div></div>';
						
						echo '<img src="' . fImg::resize( VC_ASE_PLACEHOLDER_IMAGE , 600, 250, true   ) . '" alt="' . $term_obj->name . '" />';
						
						echo ($num_terms > 1) ? '</a>' : '</div>';
						
						echo '</li>';
					}
					
				}elseif( $prod_cat_menu == 'no_images' ){
				
					echo '<li><a href="#" class="'.$term_obj->slug .' ajax-products" data-id="'. $term_obj->slug .'">';
					echo '<div class="term">' . $term_obj->name . '</div>';
					echo '</a></li>';
				}
			
			} // end foreach
		
		} // endif
		
		echo '</ul>';
		
		
		}// endif $tax_terms
		########## END TAXONOMY (PRODUCT CATEGORIES) MENU CREATING ##########
		?>
		
		<?php 
		
		// IN CASE NO SLIDER IS USED - ECHO THE GRID
		$l = 12 / ( $items_desktop ? $items_desktop : 3);
		$t = 12 / ( $items_tablet ? $items_tablet : 2 );
		$m = 12 / ( $items_mobile ? $items_mobile : 1 );
		
		if ( $hide_slider ) {
			$no_slider = ' large-'.$l.' medium-'. $t . ' small-'.$m;
		}else{
			$no_slider = '';
		}
		/*
		IMPORTANT: HIDDEN INPUT TYPE - HOLDER OF VARS SENT VIA POST BY AJAX :
		*/
		?>
		<input type="hidden" class="varsHolder" name="ajax-vars" data-block_id="<?php echo esc_attr($block_id); ?>" data-tax = "<?php echo esc_attr($taxonomy); ?>"  data-ptype = "<?php echo esc_attr($post_type); ?>" data-totitems = "<?php echo esc_attr($total_items); ?>" data-filters = "<?php echo esc_attr($filters); ?>"  data-img= "<?php echo esc_attr($img_format); ?>"  data-shop_quick ="<?php echo esc_attr($shop_quick); ?>"  data-qv_img_format ="<?php echo esc_attr($qv_img_format); ?>" data-shop_buy_action ="<?php echo esc_attr($shop_buy_action); ?>" data-shop_wishlist ="<?php echo esc_attr($shop_wishlist); ?>" data-enter_anim="<?php echo esc_attr($enter_anim); ?>" data-no_slider="<?php echo esc_attr($no_slider); ?>"  />
		
		
		<div class="clearfix"></div>

		<?php 
		
		// if there are taxonomies selected, turn on taxonomy filter:
		if( !empty($tax_terms) ) {
			
			$tax_filter_args = array('tax_query' => array(
								array(
									'taxonomy' => $taxonomy,
									'field' => 'slug', // can be 'slug' or 'id'
									'operator' => 'IN', // NOT IN to exclude
									'terms' => $tax_terms_arr,
									'include_children' => true
								)
							)
						);
		}else{
			$tax_filter_args = array();
		}
			
		
		$main_args = array(
			'no_found_rows'		=> 0,
			'post_status'		=> 'publish',
			'post_type'			=> $post_type,
			'post_parent'		=> 0,
			'suppress_filters'	=> false,
			'orderby'			=> $order_rand ? 'rand menu_order date' : 'menu_order date',
			'order'				=> 'DESC',
			'numberposts'		=> $total_items
		);
		
		$all_args = array_merge( $main_args, $args_filters, $tax_filter_args );

		$posts = get_posts($all_args);
		
		?>	
		
		<?php if( !empty( $tax_terms_arr )) {?>
				
			<a href="#" class="ajax-products reset-prod-cats"<?php echo !empty( $tax_terms_arr ) ? ' data-id="' . implode(",", $tax_terms_arr) .'"' : null; // array to string ?> title="<?php esc_attr_e('Reset categories','vc_ase'); ?>" aria-hidden="true">
				
				<span class="fa fa-times"></span>
			</a>

		<?php } ?>
		
		<div class="vc-ase-ajax-load" style="display: none;"><i class="fa fa-spinner fa-spin"></i></div>
		
		<?php if($enter_anim != 'none') {?>
		<script>
		(function( $ ){
			$.fn.anim_waypoints = function(blockId, enter_anim) {
				
				var thisBlock = $('#products-'+ blockId );
				if ( !window.vcase_isMobile && !window.isIE9 ) {
					var item = thisBlock.find('.item'),
						anim_wrap	= item.find('.anim-wrap');
					
					anim_wrap.waypoint(
						function(direction) {
							var item_ = $(this);
							if( direction === "up" ) {	
								item_.removeClass('animated '+ enter_anim).addClass('to-anim');
							}else if( direction === "down" ) {
								var i =  item_.attr('data-i');
								setTimeout(function(){
								   item_.addClass('animated '+ enter_anim).removeClass('to-anim');
								}, 100 * i);
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
						
			$(document).anim_waypoints("<?php echo esc_attr($block_id); ?>"," <?php echo esc_attr($enter_anim);?>");
		
		});
		</script>
		<?php } ?>
		
		<?php
		// if the slider will loop or not
		$minimum_items	= ( count($posts) < $items_desktop ) ? true : false ;
		$slider_loop	= ( $tax_terms || $minimum_items ) ? '0' : '1'; 
		?>
		
		<input type="hidden" class="slides-config" data-navigation="<?php echo $slider_navig ? '0' : '1'; ?>" data-pagination="<?php echo $slider_pagin ? '0' : '1'; ?>" data-auto="<?php echo esc_attr($slider_timing); ?>" data-desktop="<?php echo $items_desktop; ?>" data-tablet="<?php echo esc_attr($items_tablet); ?>" data-mobile="<?php echo esc_attr($items_mobile); ?>" data-loop="<?php echo esc_attr($slider_loop); ?>" />
		
		<div class="category-content row <?php echo !$hide_slider ? 'owl-carousel contentslides' : '';?><?php echo ' '. esc_attr($anim) ;?> woocommerce"  id="ajax-prod-<?php echo esc_attr($block_id); ?>" <?php echo $hide_slider ? "data-masonry-options='{  \"itemSelector\": \".item\" }'" : ''; ?>>
		
		<?php 
		$i = 1;
		
		//start products loop
		foreach ( $posts as $post ) {
						
			setup_postdata( $post );
			
			global $product, $yith_wcwl;
			
			if( VC_ASE_WPML_ON ) { // if WPML plugin is active
				$id	= icl_object_id( get_the_ID(), 'product', false, ICL_LANGUAGE_CODE ); 
				$lang_code	= ICL_LANGUAGE_CODE;
			}else{
				$id	= get_the_ID();
				$lang_code	= '';
			}
			
			// Back image and custom image size
			// 3.0.0 < Fallback conditional
			if( apply_filters( 'vc_ase_wc_version', '3.0.0' )	) {
				$attachment_ids   = $product->get_gallery_image_ids();
			}else{
				$attachment_ids   = $product->get_gallery_attachment_ids();
			}
			$img_width = $img_width = "";
			?>

			<div class="column item <?php echo esc_attr($no_slider); ?>">
				
				<div class="anim-wrap<?php echo ($enter_anim != 'none') ? ' to-anim' : '';  ?>" data-i="<?php echo esc_attr($i); ?>" >
				
				<?php apply_filters('vc_ase_wc_sales',''); ?>	
									
				<div class="item-img">
					
					<div class="front">
						
						<?php echo apply_filters( 'vc_ase_image', $img_format ); ?>
					
					</div>
					
					<div class="back<?php echo ( $attachment_ids ? ' has-image' : ''); ?>">
					
						<div class="item-overlay"></div>

						<?php 
													
						if ( $attachment_ids ) {
							
							if( $img_width && $img_height ) {
								
								//$custom_size = $img_width . 'x' . $img_height; // Deprecated - "Micemade_Custom_Image_Sizes" class in as_vc_init.php
								echo wp_get_attachment_image( $attachment_ids[0], array( $img_width, $img_height ) );	
								
							}else{
								echo wp_get_attachment_image( $attachment_ids[0], $img_format );
							}
						}
						?>
						
						<?php do_action( 'vc_ase_shop_buttons' , $shop_buy_action , $shop_wishlist, $shop_quick, $qv_img_format ); ?>
					
					</div>
					
				</div>
				
				<div class="item-data">
					
					<?php
					do_action( 'vc_ase_shop_title_price' );	
					
					apply_filters('vc_ase_wc_rating',''); 
					?>
					
				</div><?php //.item-data ?>
				
			
			</div><?php // .anim-wrap ?>
			
			</div><?php // .column ?>
							
			<?php 
			$i++;
		}// END foreach
		
		wp_reset_postdata();
		
		?>
					
		</div>
		
		
		<?php if( $button_label && $but_url ) { ?>
		<div class="bottom-block-link <?php echo ( $btn_vc_css_class ? $btn_vc_css_class : '' ); ?>">
		
			<a href="<?php echo esc_url( $but_url ); ?>" <?php echo ($but_target ? ' target="'.esc_attr($but_target).'" ' : '');?> class="button" <?php echo ($but_title ? 'title="'.esc_attr($but_title).'"' : 'title="'.esc_attr($button_label).'"'); ?> >
				<?php echo esc_html( $button_label ); ?>
			</a>
			
		</div>
		<?php } //endif; $button_label && $but_url ?>
		
		<?php // IF SLIDER IS ENABLED
		if ( !$hide_slider ) {?>
		<script>
		jQuery(document).ready( function($) {
			
			var thisBlock = $("#ajax-prod-<?php echo esc_attr($block_id); ?>");
			
			var thisMakeSlides = window.vcase_contentSlides( thisBlock );

		});
		</script>
		<?php } ?>
		
		<div class="clearfix"></div>
		
	</div><!-- /.content-block -->
			
	<?php
	echo $css_classes ? '</div>' : null;
	
	####################  HTML OUTPUT ENDS HERE: #########################

	$output_string = ob_get_contents();
   
	ob_end_clean();
	
	return $output_string ;

}

add_shortcode( 'as_ajax_prod', 'vc_ase_as_ajax_prod_func' );
?>