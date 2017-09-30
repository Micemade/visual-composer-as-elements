<?php 
function vc_ase_as_wc_catalog_view_func( $atts, $content = null ) { 

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

		'product_cats'		=> '',
		'cat_titles'		=> '',
		'filters'			=> 'latest',

		'total_items'		=> '',
		'items_row'			=> '',
		'grid_list'			=> 'show_grid',

		'css_classes'		=> '',
		'block_id'			=> apply_filters( 'vc_ase_randomString',10 )
		  
	), $atts ) );

	
	$content = wpb_js_remove_wpautop($content, true);

	
	if( VC_ASE_WOO_ACTIVE ) {
		
		if( ! wp_script_is( 'larix_micemade-cookies', 'enqueued' ) ) {
			wp_register_script( 'vc_ase-cookies', VC_ASE_URL . 'assets/js/vendors/jquery.cookie.js');
			wp_enqueue_script( 'vc_ase-cookies', VC_ASE_URL . 'assets/js/vendors/jquery.cookie.js', array('jQuery'), '1.0', true );
		}
		
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
		//
		
		// TAXONOMY FILTER ARGS
		$tax_terms = $taxonomy = '';
		if( $product_cats  ) {
			$tax_terms = $product_cats;
			$taxonomy = 'product_cat';
		}

		
		####################  HTML STARTS HERE: ###########################
		
		ob_start();
		
		echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;
		
		echo '<div id="wc-catalog-'. esc_attr($block_id).'" class="vc-ase-element content-block filter-prods">';
			
			do_action('vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color,  $title_size, $heading_css );
			?>
			
			<?php
			// GET TAXONOMY OBJECT:
			$tax_terms_arr = array();
			if( $tax_terms ) {
				$term_Objects	= array();
				$tax_terms_arr	= explode(',', $tax_terms );
				
				foreach ( $tax_terms_arr as $term ) {
					if( term_exists( $term,  $taxonomy) ) {
						$term_Objects[] = get_term_by( 'slug', $term, $taxonomy );
					}
				}
			}
			?>
		
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
				'post_type'			=> 'product',
				'post_parent'		=> 0,
				'suppress_filters'	=> false,
				'orderby'			=> $order_rand ? 'rand menu_order date' : 'menu_order date',
				'order'				=> 'DESC',
				'posts_per_page'	=> $total_items
			);
			
			$all_args = array_merge( $main_args, $args_filters, $tax_filter_args );

			$posts = get_posts($all_args);
			?>
			
			<script>
			(function($) {
				"use strict";
				var catalog = '';
				$( document ).ready(
					function() {
						// get WC catalog page cookie
						catalog = $.cookie('view');

						var grid_list_wrap = $("#grid-list-wrap-<?php echo esc_js($block_id); ?>"),
							grid_or_list = "<?php echo esc_js( $grid_list ); ?>";
						
						// default state
						if( grid_or_list === "show_list" || grid_or_list === "hide_list" ) {
							$.cookie('view','list');
							grid_list_wrap.find(".list-button").addClass("active");
							grid_list_wrap.find(".grid-button").removeClass("active");
						}else{
							$.cookie('view','grid');
							grid_list_wrap.find(".list-button").removeClass("active");
							grid_list_wrap.find(".grid-button").addClass("active");
						}
						
						grid_list_wrap.addClass( "active" );
						
						// show or hide grid/list buttons
						if( grid_or_list === "hide_list" || grid_or_list === "hide_grid" ) {
							$('.gridlist-toggle').css("display", "none" );
						}
						
					}
					
				);
				$( window ).unload(function() {
					 if( catalog ) {
						$.cookie('view', catalog );
					 }
				});
			})(jQuery);
			</script>

			<?php
			global $woocommerce_loop;

			$products                    = new WP_Query( $all_args );
			$woocommerce_loop['columns'] = $items_row;

			echo '<div class="woocommerce columns-' . esc_attr($items_row) . ' vc_ase_wc_gridlist" id="grid-list-wrap-'. esc_attr($block_id) .'">';
			 
			if( $tax_terms && $cat_titles ) {	?> 
				
				<h3 class="taxonomy-menu">
					
					<small><?php esc_html_e("Products from selected categories","vc_ase")?>: </small><br>

					<?php
					// SHOW TAXONOMIES:
					if( !empty( $term_Objects ) ) {
						$count	= count( $term_Objects );
						$i		= 1;
						foreach ( $term_Objects as $term_obj ) {
							
							$term_link =  get_term_link( $term_obj->term_id );
							if ( is_wp_error( $term_link ) ) {
								continue;
							}
							
							echo '<a href="'. $term_link .'">';
							echo esc_attr($term_obj->name) ;
							echo '</a>';
							echo ( $i == $count ) ? '' : ', ';
							$i++;
						}
					}
					?>
				</h3>				
				
			<?php }  // endif $tax_terms 
			
			if ( $products->have_posts() ) : ?>

				<?php do_action( "woocommerce_before_shop_loop" ); ?>

				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

				<?php do_action( "woocommerce_after_shop_loop" ); ?>

			<?php else: ?> 
			
				<?php echo '<h5 class="no-woo-notice">' . __('No products to display.','vc_ase') . '</h5>';?>
			
			<?php endif;

			woocommerce_reset_loop();
			wp_reset_postdata();

			echo '</div>';
			?>
			
			<div class="clearfix"></div>
			
		</div><!-- .content-block -->
		
		
		<?php echo $css_classes ? '</div>' : null;	?>
		
		
	<?php
		####################  HTML OUTPUT ENDS HERE: ###########################
		$output_string = ob_get_contents();
	   
		ob_end_clean();
		
		return $output_string ;
	
	
	}else{
		
		echo '<h5 class="no-woo-notice">' . __('WC LIST/GRID BLOCK DISABLED.<br> Sorry, it seems like WooCommerce is not active. Please install and activate last version of WooCommerce.','vc_ase') . '</h5>';
		
		return;
	}
	
}

add_shortcode( 'as_wc_catalog_view', 'vc_ase_as_wc_catalog_view_func' );
?>