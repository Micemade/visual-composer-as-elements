<?php

function vc_ase_as_banner_func( $atts, $content = '' ) { 
  		
	extract( shortcode_atts( array(
		
		'css'				=> '',
				
		'title' 			=> '',
		'type_eff' 			=> '',
		'subtitle' 			=> '',
		'title_custom_css' 	=> '',
		'subtitle_custom_css' => '',

		'title_size'		=> '100%',
		'vertical_align'	=> 'middle',
		'align_float'		=> 'center',
		'text_padding'		=> '',
		'text_color'		=> '',
		'border'			=> 'none',
		
		'disable_invert'	=> '',
		'block_overlay'		=> '',
		'block_opacity'		=> '',
		'overlay'			=> '',
		'banner_height'		=> '',
		
		'button_label'		=> '',
		'link_button'		=> '',
		
		'enter_anim'		=> 'none',
		'anim_delay'		=> '',
		'css_classes'		=> '',
		'block_id'			=> apply_filters( 'vc_ase_randomString',10 ),
		  
	), $atts ) );
	

	$button 	= vc_build_link( $link_button );
	$but_url	= $button['url'];
	$but_title	= $button['title'];
	$but_target	= $button['target'];
	
	$vc_css_class =  vc_shortcode_custom_css_class( $css, ' '  );
	
	$text		=  wpb_js_remove_wpautop( $content, true );
	
	####################  HTML STARTS HERE: ###########################
	ob_start();
	;
	echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;	
	?>

	<?php echo (  $but_url && !$button_label ) ? '<a href="'.esc_url( $but_url ).'" '. ($but_target ? 'target="'.esc_attr($but_target).'"' : '') .''. ($but_title ? 'title="'.esc_attr($but_title).'"' : '') .'>' : null; ?>
	
	
	<div id="banner-block-<?php echo esc_attr($block_id); ?>" class="vc-ase-element banner-block content-wrapper<?php echo ($enter_anim != 'none') ? ' to-anim' :'';  ?><?php echo $disable_invert ? ' disable-invert' : null; ?> <?php echo esc_attr($vc_css_class) ; ?> table">	
	
	
		<?php
		// SCOPED CSS :
		echo '<style scoped>';
		
		if(  $block_opacity || $banner_height  ) {
			echo '#banner-block-'. esc_attr($block_id).' { ';
			echo $block_opacity ? 'opacity:'. esc_attr($block_opacity) / 100 .'; ' : '';
			echo $banner_height ? 'height:' .$banner_height. ';' : '';
			echo '}';
		}
		
		// TEXT
		if( $title || $subtitle || $text ) {
			echo '#banner-block-'.$block_id.' .text-holder, #banner-block-'.$block_id.' .text-holder h4 { color: '.$text_color.'; }';
		}
		
		// BLOCK OVERAL OVERLAY
		if( $block_overlay ) {
			echo '#banner-block-'. $block_id.' .banner-overlay { ';
			echo 'background-color: '.$block_overlay.';';
			echo '}';
		}
		
		// BORDER & TEXT OVERLAY:
		
		$border_width = ($border == 'double') ? 'border-width: 4px;' : 'border-width: 1px;';
		echo '#banner-block-'.$block_id.' .text-holder:before { ';
		echo $border ? 'border-style: '.$border.'; '.$border_width.'; ' : '';
		echo '}';
		echo $overlay ? '#banner-block-'.$block_id.' .item-overlay { background-color: '.$overlay.';' : '';
		echo '}';
		
		echo '</style>'; // end SCOPED CSS
		?>
		
		<input type="hidden" class="varsHolder" data-boxColor = "<?php echo esc_attr($overlay); ?>"  data-fontColor = "<?php echo esc_attr($text_color); ?>" />
		
		<?php 
		
		if( $block_overlay ) {
			echo '<div class="banner-overlay"></div>';
		}
		
		$padd = 'style="padding:'. ( $text_padding ? $text_padding  : '3rem' ) . '; "';
		
		echo '<div class="text-holder '. esc_attr($align_float) .' tablecell '. esc_attr($vertical_align) .'" '. $padd .'>';
			
			echo $overlay	? '<div class="item-overlay"></div>' : ''; 
			
			// TYPEWRITER EFFECT:
			if ( $type_eff ) {
				$type_text_arr	= array();	
				$type_text_arr	= explode("|", $title );
				$last			= end( $type_text_arr );
				$type_text		= '';
				foreach ( $type_text_arr as $type ) {
					
					$type_text .= '"'. $type .'"' . ( ( $type !== $last ) ? ',' : '' );
				}
				
			}
			
			echo $title		? '<h3 class="block-title '. esc_attr( $align_float ) . esc_attr( ' '. $title_custom_css ) . '"><span'. ( $title_size ? ' style="font-size:'. $title_size .'"' : '' ) .'>' . ( !$type_eff ? wp_kses_post( $title ) : '' ) . '</span></h3>' :  null; 
			
			echo $subtitle	? '<div class="block-subtitle'.esc_attr( ' '. $subtitle_custom_css ) .'">'. wp_kses_post( $subtitle ).'</div>' :  null; 
			
			echo $text		? '<div class="banner-text text'. (!$subtitle ? ' no-subtitle' : '') .'">'. wp_kses_post( $text ) .'</div>' : null; 
			
			if ( $button_label && $but_url ) {
							
				echo '<a href="'.esc_url( $but_url ).'"'. ( $but_target ? ' target="'.esc_attr( $but_target ).'" ' : '') .' class="button" '.($but_title ? 'title="'.esc_attr( $but_title ).'"' : 'title="'.esc_attr( $button_label ).'"') .' id="button-'.$block_id.'">';
				
				echo esc_html( $button_label );
				
				echo '</a>';
				
			} 
			
		echo '</div>'; // .text-holder
		
		?>
		
	</div>
	
	<?php
	####################  HTML ENDS HERE: ###########################
	echo $css_classes ? '</div>' : null;
	?>
	
	<?php if( $enter_anim != 'none') { ?>
	
	<?php $delay = $anim_delay ? $anim_delay : 100 ?>
	
	<script>
	(function($) {
		
		"use strict";
		
		$(document).ready( function($) {
			
			var thisBlock = $('#banner-block-<?php echo esc_js($block_id);?>');
			
			if ( !window.vcase_isMobile && !window.isIE9 ) {

				thisBlock.waypoint(
				
					function(direction) {
						
						if( direction === "up" ) {	
							
							thisBlock.removeClass('animated <?php echo esc_js($enter_anim);?>').addClass('to-anim');
							
						}else if( direction === "down" ) {
							
							setTimeout(function(){
							   thisBlock.addClass('animated <?php echo esc_js($enter_anim);?>').removeClass('to-anim');
							}, <?php echo esc_js($delay); ?>);
						}
					}, 
					{ offset: "98%" }	
				
				);

			}else{
		
				thisBlock.each( function() {
					
					$(this).removeClass('to-anim');
				
				});
				
			}
			
		});
	})( jQuery );
	</script>
	<?php } // end if( $enter_anim != 'none' )?>
	
	<?php if( $type_eff && $title ) { ?>
	<script>
	jQuery(document).ready( function($) {
		
		$.fn.isOnScreen = function(){
    
			var win = $(window);
			
			var viewport = {
				top : win.scrollTop(),
				left : win.scrollLeft()
			};
			viewport.right = viewport.left + win.width();
			viewport.bottom = viewport.top + win.height();
			
			var bounds = this.offset();
			bounds.right = bounds.left + this.outerWidth();
			bounds.bottom = bounds.top + this.outerHeight();
			
			return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
			
		};
		
		
		$(function(){
			
			var thisBlock	= $('#banner-block-<?php echo esc_js($block_id);?>'),
				type_elm	= thisBlock.find(".block-title span");
				
			
			$(document).on("scroll", function() {
				var isOnScreen = thisBlock.isOnScreen();
				
				if( isOnScreen ) {
					type_elm.typed({
						strings		: [<?php echo wp_kses_post( $type_text )?>],
						typeSpeed	: 50,
						backSpeed	: 10,
						backDelay	: 3000,
						loop		: true,
						preStringTyped: function() {
							var cursor		= thisBlock.find(".typed-cursor");
							cursor.css("font-size" , <?php echo $title_size ? '"' .esc_js( $title_size ). '"'  : "\"100%\""; ?>);					
						},
					});
					
				}
				
			});
			
			$(document).trigger("scroll");

		});
	});
	</script>
	<?php } ?>
	
	
	<?php echo (  $but_url && !$button_label ) ? '</a>' : null; ?>
		
	<?php 
	####################  HTML OUTPUT ENDS HERE: ###########################
	$output_string = ob_get_contents();
	   
	ob_end_clean();
		
	return $output_string ;
	
}

add_shortcode( 'as_banner', 'vc_ase_as_banner_func' );
?>