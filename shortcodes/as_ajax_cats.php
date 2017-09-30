<?php
function vc_ase_as_ajax_cats_func( $atts, $content = null ) { 
  
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
			'tax_menu_style'	=> 'none',
			'tax_menu_align'	=> 'center',
			
			
			'post_cats'			=> '',
			'portfolio_cats'	=> '',
			'product_cats'		=> '',
			
			'img_format'		=> '',
			'custom_image_width'	=> '',
			'custom_image_height'	=> '',
			'total_items'		=> '',
			'offset'			=> '',
			'no_post_thumb'		=> '',
			'only_featured' 	=> '',
			'items_desktop'		=> '',
			'items_tablet'		=> '',
			'items_mobile'		=> '',
			
			'zoom_button'		=> '',
			'link_button'		=> '',
			'remove_gutter'		=> '',
			
			'hide_slider'		=> '',
			'no_masonry'		=> '',
			'slider_navig'		=> '',
			'slider_pagin'		=> '',
			'slider_timing'		=> '',
			'anim'				=> 'no-hover-anim',
			'button_label'		=> '',
			'ac_link_button'	=> '',
			'btn_css'			=> '',
			
			'css_classes'		=> '',
			'block_id'			=> apply_filters( 'vc_ase_randomString',10 )
			  
		), $atts ) );

	$content = wpb_js_remove_wpautop($content, true);
	
	
	$button 	= vc_build_link( $ac_link_button );
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
		}elseif ( $post_type == 'product' && $only_featured ){
			
			if( apply_filters( 'vc_ase_wc_version', '3.0.0' ) ) {
				$args_only_featured['tax_query'] = array(
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					)
				);
			}else{
				$args_only_featured = array( 
					'meta_key' => '_featured',
					'meta_value' => 'yes'
				);
			}
			
		}else{
			$args_only_featured = array();
		}
		//
		
		// TERMS ARGS
		if( $post_cats &&  $post_type == 'post' ) {
			$tax_terms = $post_cats;
		}elseif( $portfolio_cats && $post_type == 'portfolio' ){
			$tax_terms = $portfolio_cats;
		}elseif( $product_cats && $post_type == 'product' ){
			$tax_terms = $product_cats;
		}else{
			$tax_terms = '';
		}
		// TAXONOMY:
		if( $post_type == 'post' ) {
			$taxonomy = 'category';
		}elseif( $post_type == 'portfolio' ){
			$taxonomy = 'portfolio_category';
		}elseif( $post_type == 'product' ){
			$taxonomy = 'product_cat';
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
		$imgSizes			= apply_filters( 'vc_ase_image_sizes_list','' );	// simple list of sizes
		$imgSize_values		= apply_filters( 'vc_ase_get_image_sizes','' );		// get width / height values

		if( !in_array( $img_format, $imgSizes ) ) {
			$img_format = 'thumbnail';
		}
		// if custom img size is set:
		if( $custom_image_width && $custom_image_height ) {
			
			$img_width	= $custom_image_width ? $custom_image_width : 450;
			$img_height = $custom_image_height ? $custom_image_height : 300;
			
		}else{			

			$img_width	= "";
			$img_height = "";
		}				
		// end IMAGE FORMAT AND SIZES
		
		// IN CASE NO SLIDER IS USED - ECHO THE GRID AND INCLUDE ISOTOPE
		$l = 12 / ( $items_desktop ? $items_desktop : 3);
		$t = 12 / ( $items_tablet ? $items_tablet : 2 );
		$m = 12 / ( $items_mobile ? $items_mobile : 1 );
		
		$no_slider = '';
		if ( $hide_slider ) {	
			$no_slider = 'large-'.$l.' medium-'. $t . ' small-'.$m;
		}

		
		####################  HTML STARTS HERE: ###########################
		ob_start();
		
		echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;
		
		echo '<div id="posts-'. esc_attr($block_id). '" class="vc-ase-element content-block ajax-cats'. ( $remove_gutter ? ' remove-gutter' : '' ) . esc_attr(' '.$block_style_color ) .'">';
		
		do_action('vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );
		
		$tax_terms_arr = explode(",", $tax_terms);
				
		if( $tax_terms && $tax_menu_style != 'none') {
			?>
			
			<ul class="taxonomy-menu category-list<?php echo ' '. esc_attr($tax_menu_align); ?> column" >
			
			<?php 
			// GET TAXONOMY OBJECT to build menu:
			$term_Objects = array();
			foreach ( $tax_terms_arr as $term ) {
				if( term_exists( $term,  $taxonomy ) ) {
					$term_Objects[] = get_term_by( 'slug', $term, $taxonomy );
				}
			}
			// DISPLAY TAXONOMY MENU:
			if( !empty( $term_Objects ) ) {
				
				echo '<li><a href="#" class="ajax-posts" '.( $tax_terms ? ' data-id="' .  $tax_terms.'"' : '') .'>' . esc_html__('All','vc_ase'). '</a></li>';
				
				foreach ( $term_Objects as $term_obj ) {
				
					echo '<li>';
					echo '<a href="#" class="'.esc_attr($term_obj->slug) .' ajax-posts" data-id="'. esc_attr( $term_obj->slug ) .'">';
					echo '<div class="term">' . esc_html($term_obj->name) . '</div>';
					echo '</a>';
					echo '</li>';
					
				}
			}
			?>
			</ul>
		
		<?php } // ENDIF $TAX_TERMS ?>
		
		
		<div class="clearfix"></div>
		
		<?php 
		// if there are taxonomies selected, turn on taxonomy filter:
		if( $tax_terms ) {

			$tax_filter_args = array('tax_query' => array(
								array(
									'taxonomy'	=> $taxonomy,
									'field'		=> 'slug', // can be 'slug' too
									'operator'	=> 'IN', // NOT IN to exclude
									'terms'		=> $tax_terms_arr
								)
							)
						);
		}else{
			$tax_filter_args = array();
		}
		$main_args = array(
			'no_found_rows' => 1,
			'post_status'	=> 'publish',
			'post_type'		=> $post_type,
			'post_parent'	=> 0,
			'suppress_filters' => false,
			'orderby'     	=> 'post_date',
			'order'       	=> 'DESC',
			'numberposts' 	=> $total_items,
			'offset'		=> $offset ? $offset : 0
		);
		
		$all_args = array_merge( $main_args, $args_only_featured, $tax_filter_args );

		$posts = get_posts($all_args);

		
		/*
		IMPORTANT: HIDDEN INPUT TYPE - HOLDER OF VARS SENT VIA POST BY AJAX :
		*/
		
		?>
		<input type="hidden" class="varsHolder" data-tax="<?php echo esc_attr($taxonomy); ?>" data-block_id="<?php echo esc_attr($block_id); ?>"  data-ptype = "<?php echo esc_attr($post_type); ?>" data-totitems = "<?php echo esc_attr($total_items); ?>" data-feat="<?php echo esc_attr($only_featured); ?>"  data-img="<?php echo esc_attr($img_format); ?>"  data-custom-img-w="<?php echo esc_attr($custom_image_width); ?>" data-custom-img-h="<?php echo esc_attr($custom_image_height); ?>"  data-taxmenustlye="<?php echo esc_attr($tax_menu_style); ?>"  data-enter_anim="<?php echo esc_attr($enter_anim); ?>"  data-block_style="<?php echo esc_attr($block_style); ?>" data-no_slider="<?php echo esc_attr($no_slider); ?>" data-zoom="<?php echo esc_attr($zoom_button); ?>" data-link="<?php echo esc_attr($link_button); ?>" data-offset="<?php echo esc_attr($offset); ?>" data-no_post_thumb="<?php echo esc_attr($no_post_thumb); ?>" />
		
		
		<div class="vc-ase-ajax-load" style="display: none;"><i class="fa fa-spinner fa-spin"></i></div>
		
		<?php if( $enter_anim != 'none' ) {?>
		<script>
		(function( $ ){
			
			"use strict";
			
			$.fn.anim_waypoints_posts = function(blockId, enter_anim) {
				
				var thisBlock = $('#posts-'+ blockId );
				if ( !window.vcase_isMobile && !window.isIE9 ) {
					var item		= thisBlock.find('.item'),
						anim_wrap	= item.find('.anim-wrap');
					
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
			
			$(document).anim_waypoints_posts("<?php echo esc_attr($block_id); ?>"," <?php echo esc_attr($enter_anim);?>");
				
			
		});
		</script>
		<?php } // end if( $enter_anim != 'none' ) ?>

			
			<?php
			// if the slider will loop or not
			$minimum_items	= ( count($posts) < $items_desktop ) ? true : false ;
			$slider_loop	= ( $tax_terms || $minimum_items ) ? '0' : '1'; 
			?>

			
			<input type="hidden" class="slides-config" data-navigation="<?php echo $slider_navig ? '0' : '1'; ?>" data-pagination="<?php echo $slider_pagin ? '0' : '1'; ?>" data-auto="<?php echo esc_attr($slider_timing); ?>" data-desktop="<?php echo esc_attr($items_desktop); ?>" data-tablet="<?php echo esc_attr($items_tablet); ?>" data-mobile="<?php echo esc_attr($items_mobile); ?>"  data-loop="<?php echo esc_attr($slider_loop); ?>" />
						
			
			<?php
			$sm_css = "";
			if( !$hide_slider ) {
				$sm_css = "owl-carousel contentslides ";
			}elseif( !$no_masonry ) {
				$sm_css = "js-masonry ";
			}
			?>
			
			<div class="category-content <?php echo esc_attr($sm_css) . esc_attr($anim) . esc_attr(' '.$block_style) ; ?>" id="ajax-cats-<?php echo esc_attr($block_id); ?>" > 
			
			<?php 			
			$i = 1;

			foreach ( $posts as $post ) {
				
				setup_postdata( $post );
				
				if( VC_ASE_WPML_ON ) { // if WPML plugin is active
					$post_id	= icl_object_id( get_the_ID(), get_post_type(), false, ICL_LANGUAGE_CODE ); 
					$lang_code	= ICL_LANGUAGE_CODE;
				}else{
					$post_id	= get_the_ID();
					$lang_code	= '';
				}
				
				$link			= esc_attr( get_permalink($post_id) );
				$post_title		= '<h4><a href="'. $link.'" title="'. the_title_attribute(array('echo' => 0)).'">'.  get_the_title()  .'</a></h4>';
				$post_format	= get_post_format();
				$pP_rel			= '';
				
				$post_formats 	= apply_filters('vc_ase_post_formats_media', $post_id, $block_id, $img_format, $img_width, $img_height );
				
				$img_url			= $post_formats['img_url'];
				$image_output		= !$no_post_thumb ? $post_formats['image_output'] : '';
				$pP_rel				= $post_formats['pP_rel'];
				$img_urls_gallery	= $post_formats['img_urls_gallery'];
				$quote_html			= $post_formats['quote_html'];
				?>
					
				<div class="column item <?php echo $no_slider; ?>">
					
					<div class="anim-wrap<?php echo ($enter_anim != 'none') ? ' to-anim' : '';  ?>" data-i="<?php echo esc_attr($i); ?>">
					
					<?php if( !$no_post_thumb ) { ?>
					
					<?php echo ($zoom_button && $link_button) ? '<a href="'. $link.'" title="'. the_title_attribute ().'">' : ''; // if hiding buttons link the image ?>
					
					<div class="item-img">
					
						<div class="front">
							
							<?php echo wp_kses_post($image_output) ;?>
							
						</div>
									
						
						<?php if( $block_style == "style3") { 
							
							do_action( "vc_ase_content_style3", $post_id, $link, $post_type, $taxonomy );
						
						}elseif( $block_style == "style4" ) {
							
							do_action( "vc_ase_content_style4", $post_id, $link, $post_type, $taxonomy );
							
						}else{ ?>
						
							<div class="back">
						
								<div class="item-overlay"></div>
																					
								<div class="back-buttons">
							
								<?php
								echo !$zoom_button ? '<a href="'.esc_url($img_url).'"  data-gal="prettyPhoto'.$pP_rel.'" title="'.the_title_attribute(array('echo' => 0)).'">'. apply_filters('vc_ase_post_format_icon','').'</a>' : null;
								
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
						
						echo $post_format == 'quote' ? '<div class="hidden-quote" id="quote-'.esc_attr($post_id).'">'. esc_html($quote_html) .'</div>' : null;
						?>
					
					</div><?php //.item-img ?>
						
					<?php echo ( $zoom_button && $link_button ) ? '</a>' : ''; // if hiding buttons link the image ?>
						
					<?php } // end if (!$no_post_thumb)?>
					
					
					<?php if( $block_style != "style3" && $block_style != "style4" ) { ?>
					<div class="item-data<?php echo $no_post_thumb ? ' no-post-thumb' : ''; ?>">
						
						<?php echo wp_kses_post($post_title); ?>
												
						<div class="vcase-post-meta">
						
							<?php 
							do_action('vc_ase_entry_date');
							do_action('vc_ase_entry_author');
							?>
						
						</div>						
						
						<?php 
						echo '<div class="excerpt">';
						do_action('vc_ase_archive_content');
						echo '</div>'; 
						?>

						<div class="clearfix"></div>
					
					</div><?php // .item-data ?>
					<?php } // end if( $block_style != "style3")?>
					
					
				</div><?php // .anim-wrap ?>
				
				</div><?php // .column ?>
				
				<?php 
				
				$i++;
				
			}// END foreach
			
			wp_reset_postdata();
			
			?>
			</div>
			
			
			
			<?php if( $block_style == "style3") {  // HIDING EXCERPT IF ITEM GETS SMALLER ?>
			<script>
			(function($) {
				"use strict";
				$(document).ready( function($) {
					
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
					
					$( document ).ajaxComplete(function( event,request, settings ) {
						style3_excerpt();					
					});
									
				});
			})(jQuery);
			</script>
			<?php } ?>
			
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
				
				if(jQuery().foundation) {
					 Foundation.utils.debounce(function(e){
						$(document).foundation('equalizer', 'reflow');
					}, 10);
				}
				var thisBlock = $("#ajax-cats-<?php echo esc_attr($block_id); ?>");
				
				var thisMakeSlides = window.vcase_contentSlides( thisBlock );

			});
			</script>
			<?php // IF SLIDER IS ENABLED and MASONRY isn't disabled - make Foundation equalizer reflow
			} elseif ( $hide_slider && !$no_masonry ) {?>
			<script>
			jQuery(document).ready( function($) {
				
				var thisBlock	= $("#posts-<?php echo esc_attr($block_id); ?>");
					
				var container	= thisBlock.find(".js-masonry");
				// initialize isotope (masonry) on items
				var masonryPosts	= window.filterItems( container, "" );
				
			});
			</script>
			<?php } ?>
			
			<div class="clearfix"></div>
			
		</div><!-- /.content-block -->
		
	<?php
	####################  HTML ENDS HERE: ###########################
	echo $css_classes ? '</div>' : null;
	####################  HTML OUTPUT ENDS HERE: ###########################
	
	$output_string = ob_get_contents();
   
	ob_end_clean();
	
	return $output_string ;

}

add_shortcode( 'as_ajax_cats', 'vc_ase_as_ajax_cats_func' );
?>