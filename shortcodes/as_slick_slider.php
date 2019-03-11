<?php

function vc_ase_as_slick_slider_func( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'title'                => '',
				'subtitle'             => '',
				'sub_position'         => 'bellow',
				'title_style'          => 'center',
				'title_custom_css'     => '',
				'subtitle_custom_css'  => '',
				'title_color'          => '',
				'subtitle_color'       => '',
				'title_size'           => '',
				'heading_css'          => '',

				'post_type'            => 'post',
				'post_cats'            => '',
				'portfolio_cats'       => '',
				'product_cats'         => '',
				'img_format'           => 'thumbnail',
				'custom_image_width'   => '',
				'custom_image_height'  => '',
				'total_items'          => '',
				'text_layer_style'     => 'light',

				'kenburns'             => '',
				'text_layer_anim'      => '',
				'text_layer_anim_type' => '',
				'hide_text'            => '',
				'filters'              => 'latest',
				'slider_navig'         => '',
				'slider_pagin'         => '',
				'slider_auto'          => '',
				'fade_images'          => '',
				'hide_thumbs'          => '',
				'thumbs_format'        => 'thumbnail',
				'css_classes'          => '',
				'block_id'             => apply_filters( 'vc_ase_randomString', 10 ),

			), $atts
		)
	);

	global $post;

	/**
	 * IMAGE FORMAT AND SIZES:
	 *
	 * if current img_format not exsist in registered img sizes (theme switch case),
	 * set WP default image format
	 */
	// currently registered image sizes:
	$imgSizes       = apply_filters( 'vc_ase_image_sizes_list', '' );    // simple list of sizes
	$imgSize_values = apply_filters( 'vc_ase_get_image_sizes', '' );     // get width / height values

	if ( ! in_array( $img_format, $imgSizes ) ) {
		$img_format = 'thumbnail';
	}
	// if custom img size is set:
	if ( $custom_image_width && $custom_image_height ) {

		$img_width  = $custom_image_width ? $custom_image_width : 450;
		$img_height = $custom_image_height ? $custom_image_height : 300;

	} else {

		$img_width  = '';
		$img_height = '';
	}
	// end IMAGE FORMAT AND SIZES

	/**
	 *  POSTS, PORTFOLIO OR PRODUCT FILTER ARGS
	 *  - featured (sticky), latest, best seller, best rated (WC)
	 *
	 */
	$order_rand   = false;
	$args_filters = array();

	if ( $post_type == 'post' ) {

		if ( $filters == 'featured' ) {
			$sticky_array = get_option( 'sticky_posts' );
			$args_filters = array( 'post__in' => $sticky_array );
		} elseif ( $filters == 'random' ) {
			$order_rand = true;
		}
	} elseif ( $post_type == 'portfolio' ) {

		if ( $filters == 'featured' ) {
			$args_filters = array(
				'meta_key'   => 'micemade_featured_item',
				'meta_value' => 1,
			);
		} elseif ( $filters == 'random' ) {
			$order_rand = true;
		}
	} elseif ( $post_type = 'product' ) {

		// PRODUCT FILTERS:
		if ( $filters == 'featured' ) {

			$args_filters['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
			);

		} elseif ( $filters == 'on_sale' ) {

			$product_ids_on_sale = wc_get_product_ids_on_sale();
			if ( ! empty( $product_ids_on_sale ) ) {
				$args_filters['post__in'] = $product_ids_on_sale;
			}
		} elseif ( $filters == 'best_sellers' ) {

			$args_filters['meta_key'] = 'total_sales';
			$args_filters['orderby']  = 'meta_value_num';

		} elseif ( $filters == 'best_rated' ) {

			$args_filters['meta_key'] = '_wc_average_rating';
			$args_filters['orderby']  = 'meta_value_num';

		} elseif ( $filters == 'random' ) {

			$order_rand              = true;
			$args_filters            = array();
			$args_filters['orderby'] = 'rand menu_order date';

		}
		// end filters

	}

	//
	// TAXONOMY FILTER ARGS
	if ( $post_cats && $post_type == 'post' ) {
		$tax_terms = $post_cats;
		$taxonomy  = 'category';
	} elseif ( $portfolio_cats && $post_type == 'portfolio' ) {
		$tax_terms = $portfolio_cats;
		$taxonomy  = 'portfolio_category';
	} elseif ( $product_cats && $post_type == 'product' ) {
		$tax_terms = $product_cats;
		$taxonomy  = 'product_cat';
	} else {
		$tax_terms = '';
		$taxonomy  = '';
	}

	$tax_terms_arr = explode( ',', $tax_terms );
	if ( ! empty( $tax_terms_arr ) ) {

		$tax_filter_args = array(
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug', // can be 'slug' or 'id'
					'operator' => 'IN', // NOT IN to exclude
					'terms'    => $tax_terms_arr,
				),
			),
		);
	} else {
		$tax_filter_args = array();
	}

	$main_args = array(
		'no_found_rows'    => 1,
		'post_status'      => 'publish',
		'post_type'        => $post_type,
		'post_parent'      => 0,
		'suppress_filters' => false,
		'orderby'          => $order_rand ? 'rand menu_order date' : 'menu_order date',
		'order'            => 'DESC',
		'numberposts'      => $total_items,
	);

	$all_args = array_merge( $main_args, $args_filters, $tax_filter_args );

	$posts = get_posts( $all_args );

	####################  HTML STARTS HERE: ###########################
	ob_start();

	echo $css_classes ? '<div class="' . esc_attr( $css_classes ) . '">' : null;

	do_action( 'vc_ase_block_heading', $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );

	?>
	
	<div id="slick-<?php echo esc_attr( $block_id ); ?>" class="vc-ase-element slick-slider-holder">
				
		
		<?php
		if ( $slider_auto ) {
				$duration = $slider_auto / 1000;
			?>
			<style scoped>
			#slick-<?php echo esc_attr( $block_id ); ?> .slider .slide-item .entry-image img {
				-webkit-animation-duration: <?php echo $duration ? esc_attr( $duration ) : '7'; ?>s;
				-moz-animation-duration: <?php echo $duration ? esc_attr( $duration ) : '7'; ?>s;
				-o-animation-duration: <?php echo $duration ? esc_attr( $duration ) : '7'; ?>s;
				animation-duration: <?php echo $duration ? esc_attr( $duration ) : '7'; ?>s;
			}
			</style>
			<?php } ?>
		
		<div id="slick-main-<?php echo esc_attr( $block_id ); ?>" class="slider">
			
			<?php
			foreach ( $posts as $post ) {

				setup_postdata( $post );
				$id = get_the_ID();
				//$post_type = get_post_type();

				if ( VC_ASE_WOO_ACTIVE && $post_type == 'product' ) {

					global  $product, $wp_query;

				}

				?>

			<div class="slide-item"  title="<?php echo esc_attr( get_the_title() ); ?>">
				
				<?php echo apply_filters( 'vc_ase_image', $img_format, $img_width, $img_height ); ?>
				
				<?php if ( ! $hide_text ) { ?>
				<div class="text <?php echo esc_attr( $text_layer_style ); ?>">
				
					<div class="table">
						
						<div class=" tablerow">
							
							<div class="tablecell">
							<?php
							$css_anim = $text_layer_anim ? ' to-animate' : '';

							$posted_in = get_the_term_list( $post->ID, $taxonomy, '<span class="posted_in">', ', ', '</span>' );

							echo '<h3 class="box-title' . $css_anim . '">' . $posted_in . '<span><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></span></h3>';

							if ( VC_ASE_WOO_ACTIVE && $post_type == 'product' ) {
								echo '<div class="price_holder' . $css_anim . '">';
								woocommerce_template_loop_price();
								echo '</div>';
							}

							echo ( get_the_content() ) ? ( '<div class="addendum' . $css_anim . '">' ) : '';

							echo get_the_content() ? '<p>' . apply_filters( 'vc_ase_custom_excerpt', 50, false ) . '</p>' : '';

							echo ( get_the_content() ) ? '</div>' : '';
							?>
							</div>
						
						</div>
					
					</div>
					
				</div>
				<?php } ?>
			
			</div>
			
			<?php }// END foreach ?>
			
		</div> <!-- /#slick-main-ID  -->
		
		
		
		<?php if ( ! $hide_thumbs ) { // NOT TO DISPLAY THUMBS FOR SLIDER NAVIGATION ?>
	
		<div id="slick-nav-<?php echo esc_attr( $block_id ); ?>" class="slick-nav">
		
			<?php
			foreach ( $posts as $post ) {

				setup_postdata( $post );
				$id = get_the_ID();

				echo '<div class="slide-item">';

				echo '<div class="thumb-title">'; // table div's

				echo '<h6>' . esc_html( get_the_title() ) . '</h6>';

				echo '</div>'; // table div's

				echo '<div class="nav-image">' . apply_filters( 'vc_ase_image', $thumbs_format ) . '</div>';

				echo '</div>';
			}
			?>
		
		</div>
		
		<?php } ?>

	</div><!-- /.slick -->

	
	<script>
	(function( $ ){

		"use strict";
		
		$(document).ready( function() {
				
		<?php
		// IF TEXT LAYER ANIMATION
		if ( $text_layer_anim && $text_layer_anim_type !== 'none' ) {
			?>
			
			$('#slick-main-<?php echo esc_js( $block_id ); ?>').on('init', function(event, slick ){
				activeSlide( slick );
			});
			
			
			$('#slick-main-<?php echo esc_js( $block_id ); ?>').on('afterChange', function(event, slick, currentSlide, direction){
				//var currSlide	= $(this).find('.slide-item').eq(currentSlide);
				activeSlide( slick );
			});
			
			
			function activeSlide( slick ) {
								
				var slides 		= slick.$slides;							 // slides object
					
				var	activeSlide = slides.find(".slick-active"),				 // find active slide-item
					title		= $(activeSlide.selector).find(".box-title"),// in active slide, find title
					addendum	= $(activeSlide.selector).find(".addendum"), // .. find text
					price		= $(activeSlide.selector).find(".price_holder"), // ... find price
					postedIn	= $(activeSlide.selector).find(".posted_in"); //... find ".posted_in"
					
				var	otherSlides = $(activeSlide.selector).siblings(),
					otherTitles = slides.find(".box-title"),				//  in ALL slides find titles,text, price and posted in
					otherAdds 	= slides.find(".addendum"),
					otherPrices	= slides.find(".price_holder"),
					otherPosted	= slides.find(".posted_in");				
				
					otherSlides.removeClass("kenburns");
					otherTitles.removeClass("<?php echo esc_js( $text_layer_anim_type ); ?>"); // reset all animation css in ALL slides
					otherAdds.removeClass("<?php echo esc_js( $text_layer_anim_type ); ?>");
					otherPrices.removeClass("<?php echo esc_js( $text_layer_anim_type ); ?>");
					otherPosted.removeClass("<?php echo esc_js( $text_layer_anim_type ); ?>");
					
					
					
				title.addClass("<?php echo esc_js( $text_layer_anim_type ); ?>");			// then add animation on active slide
				setTimeout(function(){
						addendum.addClass("<?php echo esc_js( $text_layer_anim_type ); ?>");
					
				}, 200);
				setTimeout(function(){
					price.addClass("<?php echo esc_js( $text_layer_anim_type ); ?>");
					postedIn.addClass("<?php echo esc_js( $text_layer_anim_type ); ?>");
				}, 300);
				   
			<?php if ( $kenburns ) { ?>
				$(activeSlide.selector).addClass("kenburns");
			<?php } ?>
			
			}
			
			
			$('#slick-main-<?php echo esc_js( $block_id ); ?>').on('beforeChange', function(event, slick, currentSlide, nextSlide, direction){
				//var currentSlide	= $(this).find('.slide-item').eq(currentSlide);
			});
			
		<?php } // END IF TEXT LAYER ANIMATION ?>

			 $('#slick-main-<?php echo esc_js( $block_id ); ?>').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: <?php echo $slider_navig ? 'true' : 'false'; ?>,
				prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
				dots: <?php echo $slider_pagin ? 'true' : 'false'; ?>,
				fade: <?php echo $fade_images ? 'true' : 'false'; ?>,
				autoplay: <?php echo $slider_auto ? 'true' : 'false'; ?>,
				<?php echo $slider_auto ? 'autoplaySpeed:' . esc_js( $slider_auto ) . ',' : ''; ?>
				<?php echo ! $hide_thumbs ? 'asNavFor: "#slick-nav-' . esc_js( $block_id ) . '",' : ''; ?>
			});
			
			<?php if ( ! $hide_thumbs ) { ?>
			$('#slick-nav-<?php echo esc_js( $block_id ); ?>').slick({
				slidesToShow: 3,
				slidesToScroll: 1,
				asNavFor: '#slick-main-<?php echo esc_js( $block_id ); ?>',
				arrows: false,
				dots: false,
				centerMode: true,
				focusOnSelect: true,
				adaptiveHeight: true,
				responsive: [
					{
					  breakpoint: 1024,
					  settings: {
						slidesToShow: 3,
						slidesToScroll: 3,
						infinite: true,
						dots: true
					  }
					},
					{
					  breakpoint: 600,
					  settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					  }
					},
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					  }
					}
				]
			});
			<?php } ?>
			
			// FADE IN SLIDER AFTER IMAGES LOADED ( ImagesLoaded jQuery plugin )
			$("#slick-<?php echo esc_js( $block_id ); ?>").imagesLoaded( function() {
				$("#slick-<?php echo esc_js( $block_id ); ?>").css("opacity", 1);
			});
		});
		
	})( jQuery );
	</script>
	
	
	<?php echo $css_classes ? '</div>' : null; ?>
	
	<div class="clearfix"></div>
	
	<?php
	####################  HTML OUTPUT ENDS HERE: ###########################
	$output_string = ob_get_contents();

	ob_end_clean();

	return $output_string;

}

add_shortcode( 'as_slick_slider', 'vc_ase_as_slick_slider_func' );?>
