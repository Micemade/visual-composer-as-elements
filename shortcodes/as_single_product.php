<?php
function vc_ase_as_single_prod_func( $atts, $content = null ) { 
  
	global $post, $wp_query;
	
	extract( shortcode_atts( array(
			'title'				=> '',
			'subtitle'			=> '',
			'sub_position'		=> 'bellow',
			'title_style'		=> 'center',
			'title_color'		=> '',
			'subtitle_color'	=> '',
			'title_size'		=> '',
			
			'enter_anim'		=> 'none',
			'block_style'		=> 'images_right',
			
			'img_format'		=> 'thumbnail',
			'no_gallery'		=> '',
			'slider_navig'		=> '',
			'slider_pagin'		=> '',
			'slider_timing'		=> '',
			
			'back_color'		=> '',
			
			'product_options'	=> 'reduced',
			'hide_short_desc'	=> '',
			'hide_image'		=> '',
			'single_product'	=> '',

			'css'				=> '',
			'css_item_data'		=> '',
			'css_classes'		=> '',
			'block_id'			=> apply_filters( 'vc_ase_randomString',10 )
			  
		), $atts ) );
		
	$content = wpb_js_remove_wpautop($content, true);
	
		
	// Enqueue variation scripts
	wp_enqueue_script( 'wc-add-to-cart-variation' );
	
	
	####################  HTML STARTS HERE: ###########################
	ob_start();
	
	echo $css_classes ? '<div class="'.esc_attr( $css_classes ).'">' : null;

	do_action( 'vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_color, $subtitle_color,  $title_size );
	
	$vc_css_class			=  vc_shortcode_custom_css_class( $css, ' '  );
	$vc_css_item_data_class =  vc_shortcode_custom_css_class( $css_item_data, ' '  );
	?>
	
	<?php echo '<input type="hidden" class="single-prod-data" data-block_id="'. esc_attr($block_id).'" data-single_product="'. esc_attr($single_product).'" data-block_style="'. esc_attr($block_style).'" data-back_color="'. esc_attr($back_color).'" data-hide_image ="'. esc_attr($hide_image ).'" data-img_format ="'. esc_attr($img_format ).'" data-no_gallery ="'. ( $no_gallery ? '1' : '0' ).'" data-slider_navig ="'. ($slider_navig ? '0' : '1') .'" data-slider_pagin ="'. ($slider_pagin ? '0' : '1') .'" data-slider_timing ="'. esc_attr($slider_timing).'" data-product_options ="'. esc_attr($product_options ).'" data-hide_short_desc ="'. ( $hide_short_desc ? '1' : '0' ).'" data-vc_css_item_data_class ="'. esc_attr($vc_css_item_data_class ).'">'; ?>
	
	<?php
	

	if( $back_color ) {
		
		if( $block_style == 'images_right') {
			$arrow_color = 'border-left-color: '. $back_color .'  !important;' ;
		}elseif( $block_style == 'images_left'){
			$arrow_color = 'border-right-color: '. $back_color .'  !important;' ;
		}elseif( $block_style == 'centered'){
			$arrow_color = 'border-bottom-color: '. $back_color.'  !important;' ;
		}elseif( $block_style == 'centered_alt'){
			$arrow_color = 'border-top-color: '. $back_color .'  !important;' ;
		}else{
			$arrow_color = '';
		}
		$block_css = '<style>';
		$block_css .= '#'. esc_attr($block_id) .' .anim-wrap { background-color: '. $back_color .' !important;}';
		$block_css .= '#'. esc_attr($block_id) .'.single-item-element .images-holder:after { '. $arrow_color .'  opacity: 1 !important; 
		}';
		$block_css .= '@media only screen and (max-width: 48.0625em) { ';
		$block_css .= '#'. esc_attr($block_id) .'.single-item-element .images-holder:before {';
		$block_css .= 'border-bottom-color: '. $back_color.'  !important; }';
		$block_css .= '} ';
		$block_css .= '</style>';
		
		add_action('wp_print_scripts', $block_css);
		
		//elements_custom_css( $block_id, $block_css );
		/* 
		$inline_css_func = function ( $block_id, $block_css ) {
			wp_enqueue_style(
				'vcase-single-prod-custom-css-'.$block_id,
				plugin_dir_url( __FILE__ ) . 'assets/css/custom_css_empty.css'
			);
				
			wp_add_inline_style( 'vcase-single-prod-custom-css-'.$block_id, $block_css );
			
		};
		add_action( 'wp_enqueue_scripts', $inline_css_func ,1000,2 ); */
	}

	?>
	
	<div id="<?php echo esc_attr($block_id); ?>" class="vc-ase-element content-block single-item-element woocommerce <?php echo esc_attr($vc_css_class) ; ?>">			
	
		<span class="load-product"><?php esc_html_e("Loading product","vc_ase") ?></span>
		
		<div class="vc-ase-ajax-load"><i class="fa fa-spinner fa-spin"></i></div>
	
	</div><!-- /.single-item-block -->
	
	<script>
		(function( $ ){
			$(document).ready( function() {
				
				// #########################################################
				$(window).on("load", function(e) {
			
					var ajaxurl = vc_ase_jsvars.vc_ase_ajax_url;
					
					var	single_prod_block	= $("#<?php echo esc_attr($block_id); ?>"),
						hidden_input		= single_prod_block.prev( "input.single-prod-data" );
						
					var block_id			= hidden_input.data("block_id"),
						single_product 		= hidden_input.data("single_product"),
						block_style			= hidden_input.data("block_style"),
						back_color 			= hidden_input.data("back_color"),
						hide_image 			= hidden_input.data("hide_image"),
						img_format 			= hidden_input.data("img_format"),
						no_gallery 			= hidden_input.data("no_gallery"),
						slider_navig 		= hidden_input.data("slider_navig"),
						slider_pagin 		= hidden_input.data("slider_pagin"),
						slider_timing		= hidden_input.data("slider_timing"),
						product_options 	= hidden_input.data("product_options"),
						hide_short_desc 	= hidden_input.data("hide_short_desc"),
						vc_css_item_data_class 	= hidden_input.data("vc_css_item_data_class");
					
					$.ajax({
					
						type: "POST",
						url: ajaxurl,
						data: { "action": "load-single-product", block_id: block_id, single_product: single_product, block_style : block_style,back_color : back_color, hide_image : hide_image, img_format : img_format, no_gallery: no_gallery, slider_navig: slider_navig, slider_pagin:slider_pagin, slider_timing: slider_timing, product_options : product_options, hide_short_desc : hide_short_desc, vc_css_item_data_class : vc_css_item_data_class  },
						success: function(response) {
							// ajax response:
							single_prod_block.html(response);
							
							var singleSlides	= single_prod_block.find(".singleslides"),
								product_div		= single_prod_block.find(">.item"),
								product_div_data= single_prod_block.find(".item-data"),
								item_data		= product_div.find(".item-data").find("> .table"),
								images			= product_div.find(".images-holder");

							var	config	= singleSlides.prev('input.slides-config');
							
							var sp_navig		= config.attr('data-navigation'),
								sp_pagin		= config.attr('data-pagination'),
								sp_auto			= config.attr('data-auto'),
								sp_transition	= config.attr('data-trans');			

							// OWL 2
							singleSlides.owlCarousel({
								items				: 1,
								loop				:true,
								margin				:0,
								responsiveClass		:true,
								nav					: sp_navig == '1' ? true : false,
								dots				: sp_pagin == '1' ? true : false,
								autoplay			: sp_auto ? true : false,
								autoplayTimeout		: sp_auto  ? sp_auto : 0,
								autoplayHoverPause	: true,
								navText				: ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"]
								
							});
							
							// if images are smaller then product info :
							$(window).resize( function() {
								if( item_data.height() > images.height() ) { 
									item_data.parent().css("position","relative");
								}else{
									item_data.parent().css("position","absolute");
								}
							});
							
							// make nav arrows move with mouse hover (up/down)
							var moveArrowsSP = window.vcase_moveArrows( $(".owl-carousel"), ".owl-nav" );
							
							Foundation.libs.equalizer.reflow();
							
							product_div.animate(
								{ "opacity": 1 }, 
								{ duration: 800, 
								  complete: function(){ 
									Foundation.libs.equalizer.reflow();
									$(window).trigger("resize"); 
								} 
							});
							
							// PRETTYPHOTO :	
							$("a[class^=\"prettyPhoto\"], a[data-gal^=\"prettyPhoto\"]").prettyPhoto(
								{	theme: "micemade_default",
									slideshow:5000, 
									social_tools: "",
									autoplay_slideshow:false,
									deeplinking: false,
									markup: window.prettyPhotoMarkup
								});
							
							
						}// end succes
					});// end $.ajax
				
				});
				// #########################################################
				
			}); // end doc ready
		})( jQuery );
	</script>
	
	<?php
	####################  HTML ENDS HERE: ###########################
	echo $css_classes ? '</div>' : null;

	####################  HTML OUTPUT ENDS HERE: #########################

	$output_string = ob_get_contents();
   
	ob_end_clean();
	
	return $output_string ;
}

add_shortcode( 'as_single_prod', 'vc_ase_as_single_prod_func' );
?>