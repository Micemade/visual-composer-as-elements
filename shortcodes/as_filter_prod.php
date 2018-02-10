<?php 
function vc_ase_as_filter_prod_func( $atts, $content = null ) { 
  
	global $post, $wp_query;
	
	
	
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
		
		'enter_anim'		=> '',
		'post_type'			=> 'product',
		'img_format'		=> 'thumbnail',
		'qv_img_format'		=> 'thumbnail',
		'custom_image_width'=> '',
		'custom_image_height'=> '',
		'product_cats'		=> '',
		'filters'			=> 'latest',
		
		'shop_quick'		=> '',
		'shop_buy_action'	=> '',
		'shop_wishlist'		=> '',
		'remove_gutter'		=> '',
		'hide_prod_data'	=> '',
		
		'anim'				=> 'no-hover-anim',
		
		'tax_menu_style'	=> 'none',
		'tax_menu_align'	=> 'center',
		'custom_img_width'	=> '',
		'custom_img_height'	=> '',
		
		'total_items'		=> '',
		'items_desktop'		=> '',
		'items_tablet'		=> '',
		'items_mobile'		=> '',
		
		'button_label'		=> '',
		'afp_link_button'	=> '',
		'btn_css'			=> '',

		'css_classes'		=> '',
		'block_id'			=> apply_filters( 'vc_ase_randomString',10 )
		  
	), $atts ) );

	
	$content = wpb_js_remove_wpautop($content, true);
		
		
	$button 	= vc_build_link( $afp_link_button );
	$but_url	= $button['url'];
	$but_title	= $button['title'];
	$but_target	= $button['target'];
	
	$btn_vc_css_class =  vc_shortcode_custom_css_class( $btn_css, ' '  );
	
	if( VC_ASE_WOO_ACTIVE ) {
		
		$sticky_array = get_option( 'sticky_posts' );
		$total_items = $total_items ? $total_items : -1;
		
		
		// SET POST TYPE VARIABLE
		$post_type = 'product';
		
		// PRODUCT FILTERS:
		$order_rand	= false;
		if ( $filters == 'featured' ){
			
			if( apply_filters( 'vc_ase_wc_version', '3.0.0' ) ) {
				$args_filters['tax_query'] = array(
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					)
				);
			}else{
				$args_filters = array( 
					'meta_key' => '_featured',
					'meta_value' => 'yes'
				);
			}
			remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
			
		}elseif( $filters == 'best_sellers' ){
			
			$args_filters = array( 
				'meta_key' 	 => 'total_sales',
				'orderby'	=> 'meta_value_num'
			);
			remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
		
		}elseif( $filters == 'best_rated' ){
			
			$args_filters = array();
			add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
			
		}elseif( $filters == 'latest' ){
			
			$args_filters = array();
			remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
		
		}elseif( $filters == 'random' ){
		
			$order_rand	= true;
			$args_filters = array();
			remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
			
		}elseif( $filters == 'on_sale' ){
			
			$product_ids_on_sale    = wc_get_product_ids_on_sale();
			$product_ids_on_sale[]  = 0;
			$args_filters = array(
				'post__in' => $product_ids_on_sale
			);

			remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
		
		}
		//
		
		// TAXONOMY FILTER ARGS
		if( $product_cats  ){
			$tax_terms = $product_cats;
			$taxonomy = 'product_cat';
		}else{
			$tax_terms = '';
			$taxonomy = '';
		}
				
		/**
		 * IMAGE FORMAT AND SIZES:
		 *
		 * if current img_format not exsist in registered img sizes (theme switch case),
		 * set WP default image format
		 */
		// currently registered image sizes:
		$imgSizes			= apply_filters( 'vc_ase_image_sizes_list','' );	// simple list of sizes
		$imgSize_values		= apply_filters( 'vc_ase_get_image_sizes','' );		// get width / height values

		if( !in_array( $img_format, $imgSizes ) ) {
			$img_format = 'thumbnail';
		}
		// if custom img size is set:
		$img_width = $img_height = "";
		if( $custom_image_width && $custom_image_height ) {
			
			$img_width	= $custom_image_width ? $custom_image_width : 450;
			$img_height = $custom_image_height ? $custom_image_height : 300;
			
		}		
		// end IMAGE FORMAT AND SIZES
		
		// Items grid: 
		$l = 12 / ( $items_desktop ? $items_desktop : 3);
		$m = 12 / ( $items_tablet ? $items_tablet : 2 );
		$s = 12 / ( $items_mobile ? $items_mobile : 1 );
		
		$grid_css = 'large-'.$l.' medium-'. $m . ' small-'.$s;
		
		####################  HTML STARTS HERE: ###########################
		
		ob_start();
		
		echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;
		
		echo '<div id="filter-prod-'. esc_attr($block_id).'" class="vc-ase-element content-block filter-prods'. ( $remove_gutter ? ' remove-gutter' : '' ) . '">';
			
			do_action('vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color,  $title_size, $heading_css );
			?>
			
			<?php
			// GET TAXONOMY OBJECT:
			$tax_terms_arr = array();
			if( $tax_terms ) {
				$term_Objects = array();
				$tax_terms_arr = explode(',', $tax_terms );
				foreach ( $tax_terms_arr as $term ) {
					if( term_exists( $term,  $taxonomy) ) {
						$term_Objects[] = get_term_by( 'slug', $term, $taxonomy );
					}
				}
			}
			
			if( $tax_terms && $tax_menu_style != 'none') {	
			?> 
				
				<ul class="taxonomy-menu tax-filters <?php echo esc_attr($tax_menu_align) . ( $remove_gutter ? '' : ' column' ); ?>">
					
					<li class="all category-link"><a href="#" class="active" data-filter="*"><div class="term"><?php esc_attr_e('All','vc_ase'); ?></div></a></li>
					
					<?php
					// DISPLAY TAXONOMY MENU:
					if( !empty( $term_Objects ) ) {
						foreach ( $term_Objects as $term_obj ) {
						
							echo '<li class="'. esc_attr($term_obj->slug) .' category-link">';
							echo '<a href="#" data-filter=".'. esc_attr($term_obj->slug) .'">';
							echo '<div class="term">' . esc_attr($term_obj->name) . '</div>';
							echo '</a>';
							echo '</li>';
							
							
						}
					}
					?>
				</ul>				
				
			<?php } // endif $tax_terms ?>
		
			<div class="clearfix"></div>
		
			<?php 
			// if there are taxonomies selected, turn on taxonomy filter:
			if( !empty($tax_terms_arr) ) {

				$tax_filter_args = array('tax_query' => array(
									array(
										'taxonomy' => $taxonomy,
										'field' => 'slug', // can be 'slug' too
										'operator' => 'IN', // NOT IN to exclude
										'terms' => $tax_terms_arr
									)
								)
							);
			}else{
				$tax_filter_args = array();
			}
			
			$order_random = ($filters == 'random') ? 'rand ' : '';
			
			$main_args = array(
				'no_found_rows'		=> 1,
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
		
			<ul class="row vcase-masonry<?php echo ' '. esc_attr($anim) ;?> woocommerce" id="masonry-filter-<?php echo esc_attr($block_id); ?>">
			
			<?php 
	
			$i = 1;			
			
			//start products loop
			foreach ( $posts as $post ) {
				
				setup_postdata( $post );
				
				global $product;
				
				if ( ! $product || ! $product->is_visible() || !$product->is_in_stock() ) {
					continue;
				}
				
				// GET LIST OF ITEM CATEGORY (CATEGORIES) for FILTERING jquery.shuffle
				$terms = get_the_terms( $post->ID, $taxonomy );
				if ( $terms && ! is_wp_error( $terms ) ) : 
					
					$terms_str = '';
					
					foreach ( $terms as $term ) {

						$terms_str .= $term->slug . ' '; 
						$t++;
					}
					
				else :
					$terms_str = '';
				endif;
				
				if( VC_ASE_WPML_ON ) { // if WPML plugin is active
					$id			= icl_object_id( get_the_ID(), 'product', false, ICL_LANGUAGE_CODE ); 
					$lang_code	= ICL_LANGUAGE_CODE;
				}else{
					$id			= get_the_ID();
					$lang_code	= '';
				}
				$link =  get_permalink($id);
				
				// 3.0.0 < Fallback conditional
				if( apply_filters( 'vc_ase_wc_version', '3.0.0' )	) {
					$attachment_ids   = $product->get_gallery_image_ids();
				}else{
					$attachment_ids   = $product->get_gallery_attachment_ids();
				}
				
				$image_url = "";
				if ( $attachment_ids ) {
					$image_url = wp_get_attachment_image_src( $attachment_ids[0], 'full'  );
					$img_url = $image_url[0];
					
				}
				// end DATA for back image
				
				
				// PRODUCT TITLE AND PRODUCT CATS
				// 3.0.0 < Fallback conditional
				$cats = "";
				if( apply_filters( 'vc_ase_wc_version', '3.0.0' ) ) {
					$cats =  wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' );
				}else{
					$cats = $product->get_categories( ', ', '<span class="posted_in">', '</span>' );
				}
				
				$prod_title = '<h4 class="prod-title">'.wp_kses_post($cats).'<a href="'. esc_url($link) .'" title="'. the_title_attribute (array('echo' => 0)) .'"> ' . esc_attr(get_the_title()) .'</a></h4>';
				?>
					
				
				<li class="<?php echo ($grid_css ? esc_attr($grid_css) : '') . esc_attr(' '.$terms_str); ?> item column" data-id="id-<?php echo esc_attr($i);?>" <?php echo $terms_str ? 'data-groups="'. esc_attr($terms_str). '"'  : null ; ?> data-date-created="<?php echo get_the_date( 'Y-m-d' ); ?>" data-title="<?php echo the_title_attribute ();?>" data-i="<?php echo esc_attr($i); ?>">

					<div class="anim-wrap<?php echo ($enter_anim != 'none') ? ' to-anim' : '';  ?>">
					
						<?php apply_filters('vc_ase_wc_sales',''); ?>	
													
						<div class="item-img">
							
							<div class="front">
								
								<?php echo apply_filters( 'vc_ase_image', $img_format, $img_width, $img_height );?>
							
							</div>
							
							<div class="back<?php echo ($img_url ? ' has-image' : ''); ?>">
							
								<div class="item-overlay"></div>

								<?php 
															
								if ( $attachment_ids ) {
									
									if( $img_width && $img_height ) {
										
										$custom_size = $img_width . 'x' . $img_height;
										echo wp_get_attachment_image( $attachment_ids[0], $custom_size );	
										
									}else{
										echo wp_get_attachment_image( $attachment_ids[0], $img_format );
									}
								}
								?>
								
								<?php do_action( 'vc_ase_shop_buttons', $shop_buy_action , $shop_wishlist, $shop_quick, $qv_img_format ); ?>
								
							</div>
							
						</div>
						
						
						<div class="item-data">
						
							<?php
							do_action( 'vc_ase_shop_title_price' );	
						
							apply_filters('vc_ase_wc_rating',''); 
							?>

						</div>
						
					</div><!-- .anim-wrap -->
					
				
				</li>
				
				<?php 
				$i++;
			}// END foreach
			
			wp_reset_postdata();
			
			?>
			</ul>
					
			<?php if( $button_label && $but_url ) { ?>
			<div class="bottom-block-link <?php echo ( $btn_vc_css_class ? $btn_vc_css_class : '' ); ?>">
			
				<a href="<?php echo esc_url( $but_url ); ?>" <?php echo ($but_target ? ' target="'.esc_attr($but_target).'" ' : '');?> class="button" <?php echo ($but_title ? 'title="'.esc_attr($but_title).'"' : 'title="'.esc_attr($button_label).'"'); ?> >
					<?php echo esc_html( $button_label ); ?>
				</a>
				
			</div>
			<?php } //endif; $button_label && $but_url ?>
			
			<div class="clearfix"></div>
			
		</div><!-- .content-block -->
		
		
		<?php echo $css_classes ? '</div>' : null;	?>
		
		<script>
		
		jQuery(document).ready( function($) {
			
			var thisBlock = $("#filter-prod-<?php echo esc_attr($block_id); ?>");
			
			var container	= thisBlock.find(".vcase-masonry"),
				filter		= thisBlock.find(".tax-filters");

			// init filtering function
			var filterProducts	= window.filterItems( container, filter );
			
			var filter_btns =  filter.find(".category-link").find("a");
			
			filter_btns.on("click", 
					function(e) { 
						e.preventDefault();
						var _this = $(this),
						isActive = _this.hasClass( 'active' );
						// Hide current label, show current label in title
						if ( !isActive ) {
							$('ul.tax-filters .active').removeClass('active');
						}

						_this.toggleClass('active');
					});

		});
		
		(function( $ ){
			$.fn.anim_waypoints_filter_prod = function(blockId, enter_anim) {
				
				var thisBlock = $('#filter-prod-'+ blockId );
				if ( !window.vcase_isMobile && !window.isIE9 ) {
					
					var item = thisBlock.find('.item');
					
					item.waypoint(
						function(direction) {
						
							var anim_wrap = $(this).find('.anim-wrap');
							
							if( direction === "up" ) {	
								anim_wrap.removeClass('animated '+ enter_anim).addClass('to-anim');
							}else if( direction === "down" ) {
								var i =  $(this).attr('data-i');
								setTimeout(function(){
								   anim_wrap.addClass('animated '+ enter_anim).removeClass('to-anim');
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
			
			$(document).anim_waypoints_filter_prod("<?php echo esc_attr($block_id); ?>"," <?php echo esc_attr($enter_anim);?>");
			function onLayout_filter_prod() {
				Foundation.libs.equalizer.reflow();
			}
			$("#filter-prod-<?php echo esc_attr($block_id); ?>").on( "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", onLayout_filter_prod );
		});
		</script>
		
	<?php
		####################  HTML OUTPUT ENDS HERE: ###########################
		$output_string = ob_get_contents();
	   
		ob_end_clean();
		
		return $output_string ;
	
		//return "<div style='color:{$color};' data-foo='${foo}'>{$content}${foo}</div>";
	
	}else{
		
		echo '<h5 class="no-woo-notice">' . __('FILTERED PRODUCTS BLOCK DISABLED.<br> Sorry, it seems like WooCommerce is not active. Please install and activate last version of WooCommerce.','vc_ase') . '</h5>';
		
		return;
	}
}

add_shortcode( 'as_filter_prod', 'vc_ase_as_filter_prod_func' );
?>