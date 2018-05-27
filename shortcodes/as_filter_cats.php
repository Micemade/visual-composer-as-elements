<?php 
function vc_ase_as_filter_cats_func( $atts, $content = null ) { 

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

		'enter_anim'		=> 'none',
		'block_style'		=> 'style1',
		'block_style_color'	=> 'light',

		'post_type'			=> 'post',
		'post_cats'			=> '',
		'portfolio_cats'	=> '',

		'tax_menu_style'	=> 'none',
		'tax_menu_align'	=> 'center',

		'img_format'		=> '',
		'custom_image_width'=> '',
		'custom_image_height'=> '',
		'zoom_button'		=> '',
		'link_button'		=> '',
		'total_items'		=> '',
		'remove_gutter'		=> '',
		
		'items_desktop'		=> '',
		'items_tablet'		=> '',
		'items_mobile'		=> '',
		
		'only_featured' 	=> '',
		
		'anim'				=> 'no-hover-anim',
		'button_label'		=> '',
		'afc_link_button'	=> '',
		'btn_css'			=> '',
		
		'css_classes'		=> '',
		'block_id'			=> apply_filters( 'vc_ase_randomString',10 )
		  
	), $atts ) );

	$content = wpb_js_remove_wpautop($content, true);
	
	
	$button 	= vc_build_link( $afc_link_button );
	$but_url	= $button['url'];
	$but_title	= $button['title'];
	$but_target	= $button['target'];
	
	$btn_vc_css_class =  vc_shortcode_custom_css_class( $btn_css, ' '  );
	
	$sticky_array = get_option( 'sticky_posts' );
	$total_items = $total_items ? $total_items : -1;
	
	
	// FEATURED POSTS FILTER ARGS
	if ( $post_type == 'post' && $only_featured ) {
		$args_only_featured = array('post__in' => $sticky_array);
	}elseif ( $post_type == 'portfolio' && $only_featured ){
		$args_only_featured = array( 
			'meta_key' => 'micemade_featured_item',
			'meta_value' => 1
		);
	}else{
		$args_only_featured = array();
	}
	//

	// TERMS ARGS
	if( $post_cats &&  $post_type == 'post' ) {
		$tax_terms = $post_cats;
	}elseif( $portfolio_cats && $post_type == 'portfolio' ){
		$tax_terms = $portfolio_cats;
	}else{
		$tax_terms = '';
	}
	// TAXONOMY:
	if( $post_type == 'post' ) {
		$taxonomy = 'category';
	}elseif( $post_type == 'portfolio' ){
		$taxonomy = 'portfolio_category';
	}else{
		$taxonomy = '';
	}

	/**
	 * IMAGE FORMAT AND SIZES:
	 *
	 * if current img_format not exsist in registered img sizes (theme switch case),
	 * set WP default image format
	 */
	// currently registered image sizes:
	// simple list of sizes
	$img_sizes = apply_filters( 'vc_ase_image_sizes_list','' );
	// get width / height values
	$img_size_values = apply_filters( 'vc_ase_get_image_sizes','' );

	if ( ! in_array( $img_format, $img_sizes ) ) {
		$img_format = 'thumbnail';
	}
	// if custom img size is set:
	if ( $custom_image_width && $custom_image_height ) {
		$img_width  = $custom_image_width ? $custom_image_width : 450;
		$img_height = $custom_image_height ? $custom_image_height : 300;
	} else {
		$img_width  = '';
		$img_height = "";
	}
	// end IMAGE FORMAT AND SIZES

	/**
	 * Items grid:
	 *
	 */
	$l = 12 / ( $items_desktop ? $items_desktop : 3);
	$t = 12 / ( $items_tablet ? $items_tablet : 2 );
	$m = 12 / ( $items_mobile ? $items_mobile : 1 );

	$grid_css = 'grid-d-' . $l . ' grid-t-' . $t . ' grid-m-' . $m;

	###### HTML OUTPUT STARTS HERE
	ob_start();

	echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;
	?>
	
	<div class="vc-ase-element content-block filter-cats<?php echo $remove_gutter ? ' remove-gutter' : '' ; echo esc_attr( ' ' . $block_style_color ) ; ?>" id="filter-post-<?php echo esc_attr( $block_id ); ?>">	
	
	<?php
	// Block title and subtitle:
	do_action( 'vc_ase_block_heading', $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color,  $title_size, $heading_css );
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

	if( $tax_terms && 'none' !== $tax_menu_style ) {

		$terms_menu = '<ul class="taxonomy-menu tax-filters ' . esc_attr( $tax_menu_align ) . ' column">';

		$terms_menu .= '<li class="all category-link"><a href="#" class="active" data-filter="*"><div class="term">' . esc_html__( 'All', 'vc_ase' ) . '</div></a></li>';

		// DISPLAY TAXONOMY MENU:
		if ( ! empty( $term_Objects ) ) {
			foreach ( $term_Objects as $term_obj ) {

				$terms_menu .= '<li class="'. esc_attr($term_obj->slug) .' category-link">';
				$terms_menu .= '<a href="#" data-filter=".'. esc_attr($term_obj->slug) .'">';
				$terms_menu .= '<div class="term">' . esc_attr($term_obj->name) . '</div>';
				$terms_menu .= '</a>';
				$terms_menu .= '</li>';
			}
		}

		$terms_menu .= '</ul>';

		echo wp_specialchars_decode( $terms_menu );

	} // endif $tax_terms

		// if there are taxonomies selected, turn on taxonomy filter:
		if ( ! empty($tax_terms_arr) ) {

			$tax_filter_args = array( 'tax_query' => array(
								array(
									'taxonomy' => $taxonomy,
									'field'    => 'slug', // can be 'slug' too
									'operator' => 'IN', // NOT IN to exclude
									'terms'    => $tax_terms_arr,
								)
							)
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
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'numberposts'      => $total_items
		);

		$all_args = array_merge( $main_args, $args_only_featured, $tax_filter_args );

		$posts = get_posts( $all_args );
		?>
		
		<ul class="container vcase-masonry<?php echo ' ' . esc_attr( $anim );?> <?php echo ' ' . esc_attr( $block_style ); ?>" id="masonry-filter-<?php echo esc_attr( $block_id ); ?>">
			
			<?php
			$i = 1;

			// start posts loop
			foreach ( $posts as $post ) {

				setup_postdata( $post );

				// GET LIST OF ITEM CATEGORY (CATEGORIES) for FILTERING jquery.shuffle.
				$terms = get_the_terms( $post->ID, $taxonomy );

				if ( $terms && ! is_wp_error( $terms ) ) :

					$terms_str = ''; 
					foreach ( $terms as $term ) {
						$terms_str .=  $term->slug . ' '; 
						$t++;
					}

				else :
					$terms_str = '';
				endif;

				if( VC_ASE_WPML_ON ) { // if WPML plugin is active
					$post_id   = icl_object_id( get_the_ID(), get_post_type(), false, ICL_LANGUAGE_CODE ); 
					$lang_code = ICL_LANGUAGE_CODE;
				}else{
					$post_id   = get_the_ID();
					$lang_code = '';
				}

				$link        =  esc_attr( get_permalink( $post_id ) );
				$post_title  = '<h4><a href="' . $link . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">' . esc_html( strip_tags( get_the_title() ) ) . '</a></h4>';
				$post_format = get_post_format();
				$pp_rel      = '';

				$post_formats = apply_filters( 'vc_ase_post_formats_media', $post_id, $block_id, $img_format, $img_width, $img_height );

				$img_url          = $post_formats['img_url'];
				$image_output     = $post_formats['image_output'];
				$pp_rel           = $post_formats['pP_rel'];
				$img_urls_gallery = $post_formats['img_urls_gallery'];
				$quote_html       = $post_formats['quote_html'];
				?>
					
				
				<li class="<?php echo ( $grid_css ? esc_attr( $grid_css ) : '' ) . esc_attr(' '.$terms_str); ?> item" data-id="id-<?php echo $i;?>"  <?php echo $terms_str ? 'data-groups="'. esc_attr($terms_str) . '"'  : null ; ?> data-date-created="<?php echo get_the_date( 'Y-m-d' ); ?>" data-title="<?php echo the_title_attribute ();?>" data-i="<?php echo esc_attr($i); ?>">
					
					<div class="anim-wrap<?php echo ($enter_anim != 'none') ? ' to-anim' : '';  ?>">
					
					<?php echo ($zoom_button && $link_button) ? '<a href="'. $link.'" title="'. the_title_attribute( 'echo=0' ) .'">' : ''; ?>
					
					<div class="item-img">

						<div class="front">
							
							<?php echo wp_kses_post($image_output) ; ?>
							
						</div>
						
						
						<?php if( $block_style == "style3") { 
							
							do_action( "vc_ase_content_style3", $post_id, $link, $post_type, $taxonomy );
						
						}elseif( $block_style == "style4" ) {
							
							do_action( "vc_ase_content_style4",  $post_id, $link, $post_type, $taxonomy );
							
						}else{ ?>
						
							<div class="back">
						
								<div class="item-overlay"></div>
								
								<div class="back-buttons">
							
								<?php
								echo !$zoom_button ? '<a href="'.esc_url($img_url).'"  data-gal="prettyPhoto'.$pp_rel.'" title="'.the_title_attribute(array('echo' => 0)).'">'. apply_filters('vc_ase_post_format_icon','').'</a>' : null;
								
								echo !$link_button ? '<a href="'. $link.'"  title="'. the_title_attribute(array('echo' => 0)).'"><i class="fa fa-link" aria-hidden="true"></i></a>' : null;
								?>
								
								</div>
								
							</div>
						
						<?php } ?>
						
						<?php
						$allowed = array(
							'a' => array(
								'href' => array(),
								'class' => array(),
								'rel' => array(),
								'data-gal' => array(),
							)
						);
						echo $img_urls_gallery ? wp_kses( $img_urls_gallery, $allowed ) : null; // for usage with prettPhoto
						
						echo $post_format == 'quote' ? '<div class="hidden-quote" id="quote-'.esc_attr($post_id.'-'.$block_id).'">'. esc_html($quote_html) .'</div>' : null;
						?>
					
					</div><!-- .item-img -->
						
					<?php echo ($zoom_button && $link_button) ? '</a>' : ''; ?>
						
					
					<?php if( $block_style != "style3" && $block_style != "style4" ) { ?>
					<div class="item-data">
					
						<?php echo wp_kses_post($post_title); ?>
						
						<div class="vcase-post-meta">
							<?php 
							do_action('vc_ase_entry_date');
							do_action('vc_ase_entry_author');
							?>
						</div>

						<?php 
						echo '<div class="excerpt">';
						do_action('vc_ase_archive_content'); //
						echo '</div>';
						?>

						<div class="clearfix"></div>
					
					</div><!-- .item-data -->
					<?php } // end if( $block_style != "style3")?>
					
					</div><!-- .anim-wrap -->

				</li>
				
				<?php 
				$i++;
			}// END foreach
			
			wp_reset_postdata();
			?>
			</ul>
			
			<?php if( $block_style == "style3") {  // HIDING EXCERPT IF ITEM GETS SMALLER ?>
			<script>
			jQuery(document).ready( function($) {
				
				function style3_excerpt() {
					
					var style3_elm = $(".style3").find(".item-img");
					
					$(window).on( "mouseover" ,style3_elm, function() {
						
						style3_elm.each( function() {
							
							var title		= $(this).find("h4"),
								excerpt		= $(this).find(".excerpt"),
								bott_bound	= excerpt.position().top + excerpt.outerHeight(),
								top_bound	= title.position().top;
							
							if( bott_bound >= top_bound ) {
								excerpt.css("opacity", 0);
							}else{
								excerpt.css("opacity", 1);
							}
							
						});		
						
					});

				}
				
				style3_excerpt();
				
			});
			</script>
			<?php } ?>
			<script type="text/javascript">
			jQuery(document).ready( function($) {
				
				var thisBlock = $("#filter-post-<?php echo esc_attr($block_id); ?>");
				
				var container	= thisBlock.find(".vcase-masonry"),
					filter		= thisBlock.find(".tax-filters");

				// init filtering function
				var filterPosts	= window.filterItems( container, filter );

				
				var filter_btns =  filter.find(".category-link").find("a");

				filter_btns.on("click", 
					function(e) { 
						e.preventDefault();
						var _this = $(this),
						isActive = _this.hasClass( 'active' );
						// Hide current label, show current label in title
						if ( !isActive ) {
							filter.find('.active').removeClass('active');
						}

						_this.toggleClass('active');
					});
			

			});
			</script>
			
			<?php if( $button_label && $but_url ) { ?>
			<div class="bottom-block-link <?php echo ( $btn_vc_css_class ? $btn_vc_css_class : '' ); ?>">
			
				<a href="<?php echo esc_url( $but_url ); ?>" <?php echo ($but_target ? ' target="'.esc_attr($but_target).'" ' : '');?> class="button" <?php echo ($but_title ? 'title="'.esc_attr($but_title).'"' : 'title="'.esc_attr($button_label).'"'); ?> >
					<?php echo esc_html( $button_label ); ?>
				</a>
				
			</div>
			<?php } //endif; $button_label && $but_url ?>

		
		</div><!-- .filter-cats -->
		
		
		<?php echo $css_classes ? '</div>' : null; ?>
		
		<?php if( $enter_anim != 'none' ) {?>
		<script>
		(function( $ ){
			$.fn.anim_waypoints_filter_post = function(blockId, enter_anim) {
				
				var thisBlock = $('#filter-post-'+ blockId );
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
			
			$(document).anim_waypoints_filter_post("<?php echo esc_attr($block_id); ?>"," <?php echo esc_attr($enter_anim);?>");
			
			var thisBlock = $('#filter-post-<?php echo esc_attr($block_id); ?>' );
			
			function onLayout_filter_posts() {
				$(window).trigger('resize'); 
			}
			
			$("#filter-post-<?php echo esc_attr($block_id); ?>").on( "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", onLayout_filter_posts );
			
			thisBlock.on( 'layoutComplete', onLayout_filter_posts );
			
		});
		</script>
		<?php } ?>
<?php
	####################  HTML OUTPUT ENDS HERE: ###########################
	$output_string = ob_get_contents();
   
	ob_end_clean();
	
	return $output_string ;
	//return "<div style='color:{$color};' data-foo='${foo}'>{$content}${foo}</div>";
}

add_shortcode( 'as_filter_cats', 'vc_ase_as_filter_cats_func' );
?>