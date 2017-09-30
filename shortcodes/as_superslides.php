<?php

function vc_ase_as_superslides_func( $atts, $content = null ) { 
  		
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
		
		'post_type'			=> 'post',
		'images'			=> '',
		'post_cats'			=> '',
		'portfolio_cats'	=> '',
		'product_cats'		=> '',
		'img_format'		=> 'thumbnail',
		'custom_img_width'	=> '',
		'custom_img_height'	=> '',		
		'total_items'		=> '',
		'text_layer_style'	=> 'light',
		'kenburns'			=> '',
		'text_layer_anim'	=> '',
		'filters'			=> 'latest',
		'slider_navig'		=> '',
		'slider_pagin'		=> '',
		'slider_auto'		=> '',
		'fade_images'		=> '',
		'set_height'		=> '',
		'abs_stretched'		=> 'fixed',
		'css_classes'		=> '',
		'block_id'			=> apply_filters( 'vc_ase_randomString',10 )
		  
	), $atts ) );
	
	
	global $post;

	
	/* POSTS, PORTFOLIO OR PRODUCT FILTER ARGS 
	 *  - featured (sticky), latest, best seller, best rated (WC)
	 *
	 */
	$order_rand	= false;
	$args_filters = array();
	if ( $post_type == 'post'  ) {

		if ( $filters == 'featured' ){
			$sticky_array = get_option( 'sticky_posts' );
			$args_filters = array('post__in' => $sticky_array);
		}elseif ( $filters == 'random' ){
			$order_rand	= true;
		}

	}elseif ( $post_type == 'portfolio' ){

		if ( $filters == 'featured' ){
			$args_filters = array( 
				'meta_key' => 'micemade_featured_item',
				'meta_value' => 1
			);
		}elseif ( $filters == 'random' ){
			$order_rand	= true;
		}
		
	}elseif( $post_type == 'product' ){

		
		// PRODUCT FILTERS:
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

	}

	//
	// TAXONOMY FILTER ARGS
	if( $post_cats &&  $post_type == 'post' ) {
		$tax_terms = $post_cats;
		$taxonomy = 'category';
	}elseif( $portfolio_cats && $post_type == 'portfolio' ){
		$tax_terms = $portfolio_cats;
		$taxonomy = 'portfolio_category';
	}elseif( $product_cats && $post_type == 'product' ){
		$tax_terms = $product_cats;
		$taxonomy = 'product_cat';
	}else{
		$tax_terms = '';
		$taxonomy = '';
	}

	
	$tax_terms_arr = explode(',', $tax_terms );
	if( !empty($tax_terms_arr) ) {

		$tax_filter_args = array('tax_query' => array(
							array(
								'taxonomy' => $taxonomy,
								'field' => 'slug', // can be 'slug' or 'id'
								'operator' => 'IN', // NOT IN to exclude
								'terms' => $tax_terms_arr
							)
						)
					);
	}else{
		$tax_filter_args = array();
	}

	$main_args = array(
		'no_found_rows' 	=> 1,
		'post_status' 		=> 'publish',
		'post_type' 		=> $post_type,
		'post_parent' 		=> 0,
		'suppress_filters'	=> false,
		'orderby'    		=> $order_rand ? 'rand menu_order date' : 'menu_order date',
		'order'       		=> 'DESC',
		'numberposts' 		=> $total_items
	);

	$all_args = array_merge( $main_args, $args_filters, $tax_filter_args );

	$posts = get_posts($all_args);

	####################  HTML STARTS HERE: ###########################
	ob_start();
	
	echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;
	
	do_action('vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color,  $title_size, $heading_css );
	
	?>
	
	<div id="holder-<?php echo esc_attr($block_id); ?>" class="vc-ase-element superslides-holder">
		
		<?php 
		if( $set_height || $abs_stretched ) {
			echo '<style scoped>'; 
			
			if( $set_height ) {
				echo '#holder-'. esc_attr($block_id).' { height:'. esc_attr($set_height) .'; position:relative; }';
				
			}elseif( $abs_stretched == "stretched" ) {
				echo '#holder-'. esc_attr($block_id).' { position: absolute; z-index:0; top: 0; bottom: 0; left: 0; right: -1px; height: auto;}';
			}
			
			$height = ( $set_height && $abs_stretched == "fixed" ) ? $set_height : "450px";
			
			echo '@media only screen and (max-width: 768px) { #holder-'. esc_attr($block_id).' { height: calc('. esc_attr($height) .' / 1.2); }}';
			echo '@media only screen and (max-width: 548px) { #holder-'. esc_attr($block_id).' { height: calc('. esc_attr($height) .' / 1.8); }}';
			
			echo '</style>'; 
		}
		?>
		<?php if( $slider_auto ) {
			$duration = $slider_auto / 1000;
		?>
		<style scoped>
		#holder-<?php echo esc_attr($block_id); ?> .slider .slide-item  img {
			-webkit-animation-duration: <?php echo $duration ? esc_attr($duration) : '7'; ?>s;
			-moz-animation-duration: <?php echo $duration ? esc_attr($duration) : '7'; ?>s;
			-o-animation-duration: <?php echo $duration ? esc_attr($duration) : '7'; ?>s;
			animation-duration: <?php echo $duration ? esc_attr($duration) : '7'; ?>s;
		}
		</style>
		<?php } ?>
		
		
		
		<div id="slides-main-<?php echo esc_attr($block_id); ?>" class="superslides" style="opacity:0">
		
			<ul class="slides-container slider<?php echo $kenburns ? ' kenburns' : ''; ?>">
				
				<?php
				if( $post_type == "images" && !empty($images) ) {
					$img_arr = explode(',', $images);
				
					foreach ( $img_arr as $img ) {
						
					?>
					
					<li class="slide-item">
					
						<?php echo wp_get_attachment_image( $img, $img_format, false ); ?>
				
					</li><?php // .slide-item ?>
					
					<?php 
					
					}
					
				}else{
				
					foreach ( $posts as $post ) {
					
						setup_postdata( $post );
						$id = get_the_ID();
						
						if( VC_ASE_WOO_ACTIVE && $post_type == 'product' ) {
				
							global  $product, $wp_query;
							
						}
						$thumb_id	= get_post_thumbnail_id( $id );
						$img_arr	= wp_get_attachment_image_src( $thumb_id, $img_format);
						$img		= $img_arr[0];
					?>

					<li class="slide-item<?php echo $text_layer_anim ? ' to-animate' : ''; ?>">
						
						<img src="<?php echo esc_attr($img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
												
						<div class="text <?php echo esc_attr( $text_layer_style )?>">
							
							<div class="table">		
							
								<div class="tablerow">
								
									<div class="tablecell">
									<?php 
																		
									$posted_in = get_the_term_list( $post->ID, $taxonomy, '<span class="posted_in">', ', ','</span>' );
																		
									echo '<h3 class="box-title">'.$posted_in.'<span><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) .'</a></span></h3>';
									
									( VC_ASE_WOO_ACTIVE && $post_type=='product') ? woocommerce_template_loop_price() : '';
									
									echo (  get_the_content() ) ? '<div class="addendum">' : '';
																
									echo get_the_content() ? '<p>' . apply_filters('vc_ase_custom_excerpt', 50, false ) . '</p>' : '';
									
									echo ( get_the_content() ) ? '</div>' : '';
									
									?>
									</div><?php // .tablecell ?>
									
								</div><?php // .tablerow ?>
								
							</div><?php // .table ?>
							
						</div><?php // .text ?>
					
					</li><?php // .slide-item ?>
					
					<?php }// END foreach 
					
					} // end if $post_type == "images" && !empty($images)
					?>
				
			</ul>
			
			<?php if( $slider_navig ) { ?>
			<div class="slides-navigation" id="nav-<?php echo esc_attr($block_id); ?>" >
				<a href="#" class="next"><i class="fa fa-angle-right"></i></a>
				<a href="#" class="prev"><i class="fa fa-angle-left"></i></a>
			</div>
			<?php }?>
			
		</div>
		
	
	<script>
	(function( $ ) {
		"use strict";
		$(document).ready( function() {
			
			$(function() {
			
				
				var $slides		= "",
					$slidesNav	= "";
				
				$slides		= $('#slides-main-<?php echo esc_attr($block_id); ?>');
				$slidesNav	= $slides.find(".slides-navigation");
				
				// WHEN SLIDES STARTED - can be started.slides, too
				$slides.on('init.slides', function() {
					Foundation.libs.equalizer.reflow();
					$slides.css("opacity", 1);
				});
				 // WHEN SLIDES STARTS ANIM
				$slides.on('animating.slides', function() {});
				
				$slides.on('animated.slides', function() {});
				 
				// START PLUGIN
				$slides.superslides({
					play:	<?php echo $slider_auto ? esc_js($slider_auto) : '0' ?>,
					pagination: <?php echo ( $slider_pagin ? "true" : "false" ); ?>,
					hashchange: false,
					scrollable: true,
					animation:	<?php echo $fade_images ? "'fade'" : "'slide'" ?>,
					inherit_width_from: "#holder-<?php echo esc_attr($block_id); ?>",
					inherit_height_from: "#holder-<?php echo esc_attr($block_id); ?>",
					animation_easing: "easeInOutCubic"
				});
				
				/* Swiping */
				Hammer($slides[0]).on("swipeleft", function(e) {
				$slides.data('superslides').animate('next');
				});

				Hammer($slides[0]).on("swiperight", function(e) {
				$slides.data('superslides').animate('prev');
				});
								
				
				if( window.vcase_isMobile ) {
					$slidesNav.css('opacity', 1);
				}else{
					$slides.mouseenter(function (){
						$slidesNav.addClass('active');
					}).mouseleave(function (){
						$slidesNav.removeClass('active');
					})						
				}
				
				$(window).one("load", $slides,function() {
					Foundation.libs.equalizer.reflow();
					setTimeout(function(){ 
						
						$slides.css("height","100%");
						
					},1500);
					
				});
				
				var fixImgResize = setInterval( function() { $(window).trigger("resize"); } ,2000);
				setTimeout(function( ) { clearInterval( fixImgResize ); }, 8000);
				
			});

		});
		
	})( jQuery );
	</script>
	
	</div><!-- /.holder -->
	
	<?php echo $css_classes ? '</div>' : null; ?>
	
	<div class="clearfix"></div>
	
	<?php 
	####################  HTML OUTPUT ENDS HERE: ###########################
	$output_string = ob_get_contents();
	   
	ob_end_clean();
		
	return $output_string ;
	
}

add_shortcode( 'as_superslides', 'vc_ase_as_superslides_func' );?>