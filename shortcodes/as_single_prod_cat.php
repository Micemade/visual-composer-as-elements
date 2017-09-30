<?php
/**
 * as_single_prod_cat_func
 * - DISPLAY PRODUCTS FROM SINGLE CATEGORY
 * 
 * @param array $atts 
 * @param string $content  
 * 
 * @return string $output_string
 */
function vc_ase_as_single_prod_cat_func( $atts, $content = null ) {
  
	global $post, $wp_query, $woocommerce;

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
			
			'product_category'	=> '',
			'force_hide_title'	=> '',
			'force_hide_subtitle'=> '',
			'img_format'		=> 'thumbnail',
			'qv_img_format'		=> 'thumbnail',

			'anim'				=> 'none',
			'data_anim'			=> 'none',
			
			'shop_quick'		=> '',
			'shop_buy_action'	=> '',
			'shop_wishlist'		=> '',
			'smaller'			=> '',
			
			'filters'			=> 'latest',
			
			'total_items'		=> 8,
			'hide_slider'		=> '',
			'slider_navig'		=> '',
			'slider_pagin'		=> '',
			'slider_timing'		=> '',
			
			'items_desktop'		=> 4,
			'items_tablet'		=> 2,
			'items_mobile'		=> 1,
			
			
			'text_color'		=> '',
			'overlay_color'		=> '',
			'button_label'		=> '',
			'ap_link_button'	=> '',
			'btn_css'			=> '',
			
			'css_classes'		=> '',
			'block_id'			=> apply_filters( 'vc_ase_randomString',10 )
			  
		), $atts ) );
	
	$content = wpb_js_remove_wpautop($content, true);
	
	
	$button 	= vc_build_link( $ap_link_button );
	$but_url	= $button['url'];
	$but_title	= $button['title'];
	$but_target	= $button['target'];
	
	$btn_vc_css_class =  vc_shortcode_custom_css_class( $btn_css, ' '  );
		
	$total_items = $total_items ? $total_items : -1;
	
	
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
	
	####################  HTML STARTS HERE: ###########################
	ob_start();
	
	echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;
	
	echo '<div id="single-cat-prods-'.esc_attr($block_id).'" class="vc-ase-element single-cat-prods">';	
	
		if( term_exists( $product_category, 'product_cat') ) {
			
			// Get prod category name and description
			$prod_cat_object = get_term_by( 'slug', $product_category, "product_cat" ); // get term object using slug
			$cat_name = $prod_cat_object->name;
			$cat_name = $force_hide_title ? '' : $cat_name ;
			
			$cat_desc = $prod_cat_object->description ? $prod_cat_object->description : '';
			$cat_desc = $force_hide_subtitle ? '' : $cat_desc;
				
			// Use category name and description as block title if no title and subtitle
			$title		= $title ? $title : $cat_name;
			$subtitle	= $subtitle ? $subtitle : $cat_desc;		
			
		}
		
		do_action('vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );	
		

		if( term_exists( $product_category, 'product_cat') ) {
		?>
		
		<?php 
		// IN CASE NO SLIDER IS USED - ECHO THE GRID
		$l = 12 / $items_desktop;
		$t = 12 / $items_tablet;
		$m = 12 / $items_mobile;
		
		if ( $hide_slider ) {
			$no_slider = ' large-'.$l.' medium-'. $t . ' small-'.$m;
		}else{
			$no_slider = '';
		}
		
		$tax_filter_args = array(
			'tax_query' => array(
					array(
						'taxonomy'	=> 'product_cat',
						'field'		=> 'slug', // can be 'slug' or 'id'
						'operator'	=> 'IN', // NOT IN to exclude
						'terms'		=> $product_category,
						'include_children' => true
					)
				)
			);
			
		
		$main_args = array(
			'no_found_rows'		=> 0,
			'post_status'		=> 'publish',
			'post_type'			=> 'product',
			'post_parent'		=> 0,
			'suppress_filters'	=> false,
			'orderby'			=> $order_rand ? 'rand menu_order date' : 'menu_order date',
			'order'				=> 'DESC',
			'numberposts'		=> $total_items
		);
		
		$all_args	= array_merge( $main_args, $args_filters, $tax_filter_args );

		$posts		= get_posts($all_args);
		
		$post_count	= count($posts);
		
		$no_loop	= ( $post_count <= $items_desktop ) ? true : false;
		?>	

		<div class="loading-animation" style="display: none;"></div>
		
		<?php if($enter_anim != 'none') {?>
		<script>
		(function( $ ){
			$.fn.anim_waypoints = function(blockId, enter_anim) {
				
				var thisBlock = $('#products-'+ blockId );
				if ( !window.vcase_isMobile && !window.isIE9 ) {
					
					var item		= thisBlock.find('.item'),
						anim_wrap	= item.find('.anim-wrap');
					
					anim_wrap.waypoint(
						function(direction) {
							var item_ = $(this);
							if( direction === "up" ) {	
								item_.removeClass('animated '+ enter_anim).addClass('to-anim');
							}else if( direction === "down" ) {
								item_.addClass('animated '+ enter_anim).removeClass('to-anim');
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
		
		
		<div id="products-<?php echo esc_attr($block_id); ?>" class="content-block  woocommerce" >
			
			<input type="hidden" class="slides-config" data-navigation="<?php echo $slider_navig ? '0' : '1'; ?>" data-pagination="<?php echo $slider_pagin ? '0' : '1'; ?>" data-auto="<?php echo esc_attr($slider_timing); ?>" data-desktop="<?php echo $items_desktop; ?>" data-tablet="<?php echo esc_attr($items_tablet); ?>" data-mobile="<?php echo esc_attr($items_mobile); ?>" data-loop="<?php echo ($no_loop ? '0' : '1'); ?>" />
			
			<div class="category-content <?php echo !$hide_slider ? 'owl-carousel contentslides' : 'shuffle';?><?php echo ' '. esc_attr($anim) ;?> <?php echo $data_anim == 'none' ? '' : esc_attr($data_anim); ?>"  id="ajax-prod-<?php echo esc_attr($block_id); ?>">
			
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
				
				// DATA for back image
				// 3.0.0 < Fallback conditional
				if( apply_filters( 'vc_ase_wc_version', '3.0.0' )	) {
					$attachment_ids   = $product->get_gallery_image_ids();
				}else{
					$attachment_ids   = $product->get_gallery_attachment_ids();
				}
				$img_url = $img_width = $img_height = "";
				if ( $attachment_ids ) {
					$image_url = wp_get_attachment_image_src( $attachment_ids[0], 'full'  );
					$img_url = $image_url[0];
					// CURRENTLY REGISTERED IMAGE SIZES:
					$imgSizes	= apply_filters('vc_ase_all_image_sizes',''); // plugin custom function
					// if current img_format not exsist in registered img sizes (theme switch case)
					// set WP default image format
					$imgSizes_array = array_keys($imgSizes);
					if( !in_array( $img_format, $imgSizes_array ) ) {
						$img_format = 'thumbnail';
					}
					
					$img_width	= $imgSizes[$img_format]['width'];
					$img_height = $imgSizes[$img_format]['height'];

				}
				// end DATA
				?>

				<div class="column item<?php echo esc_attr($no_slider); ?>" >
					
					<div class="anim-wrap<?php echo ($enter_anim != 'none') ? ' to-anim' : '';  ?>">
					
					<?php apply_filters('vc_ase_wc_sales',''); ?>	
					
					<div class="item-img">
						
						<div class="front">
							
							<?php echo apply_filters( 'vc_ase_image', $img_format ); ?>
						
						</div>
						
						<div class="back">
						
							<div class="item-overlay"></div>

							<?php 
														
							if ( $attachment_ids ) {
								
								if( $img_width && $img_height ) {
									
									// $custom_size = $img_width . 'x' . $img_height; // Deprecated - "Micemade_Custom_Image_Sizes" class in as_vc_init.php
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
					
					</div>
					
				
				</div><!-- .anim-wrap -->
				
				</div><!-- .column -->
								
				<?php
								
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
			
			
			<div class="clearfix"></div>
			
		</div><!-- /.content-block cb-1 -->
	
		<?php }else{
		 
		 echo '<p class="warning">'. __("Product category name (slug) has changed, category doesn't exist, or doesn't contain any products.",'vc_ase') .'</p>';
		 
		}// end if term exists ?>
	
	</div><!-- .content-wrapper-->
	
	<?php
	####################  HTML ENDS HERE: ################################
	echo $css_classes ? '</div>' : null;
	
	####################  HTML OUTPUT ENDS HERE: #########################

	$output_string = ob_get_contents();
   
	ob_end_clean();
	
	return $output_string ;

}

add_shortcode( 'as_single_prod_cat', 'vc_ase_as_single_prod_cat_func' );
?>