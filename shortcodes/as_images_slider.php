<?php
function vc_ase_as_images_slider_func( $atts, $content = null ) {

extract( shortcode_atts( array(
		'title'			=> '',
		'subtitle'		=> '',
		'sub_position'	=> 'bellow',
		'title_style'	=> 'center',
		'title_custom_css'	=> '',
		'subtitle_custom_css'=> '',
		'title_color'	=> '',
		'subtitle_color'=> '',
		'title_size'	=> '',
		'heading_css'	=> '',
		
		'enter_anim'	=> 'none',
		'anim'			=> 'no-hover-anim',
		'images'		=> '',
		'img_format'	=> 'thumbnail',
		'image_style'	=> 'square',
		'titles'		=> '',
		'text_color'	=> '',
		'titles_color'	=> '',
		'overlay_color'	=> '',
		
		'slider_navig'	=> '',
		'slider_pagin'	=> '',
		'slider_timing'	=> '',
		'items_desktop'	=> '',
		'items_tablet'	=> '',
		'items_mobile'	=> '',
	
		'css_classes'	=> '',
		'block_id'		=> apply_filters( 'vc_ase_randomString',10 )
		  
	), $atts ) );
	

####################  HTML STARTS HERE: #########################

ob_start();
echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;

echo '<div id="image-slides-'. esc_attr($block_id) .'" class="vc-ase-element image-slides-block">';

do_action('vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );
?>

<?php
$img_arr	= explode(',', $images);
$titles_arr = explode(',', $titles);

$content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
$desc_arr = preg_split("/\r\n|\n|\r/", $content);


if( $overlay_color || $titles_color || $text_color ){
	echo '<style scoped>';
	echo $overlay_color ? '#image-slides-'. esc_attr($block_id) .' .item-overlay { background-color: '.$overlay_color.'; opacity: 1; }' : '';
	echo $titles_color ? '#image-slides-'. esc_attr($block_id) .' h4 { color: '. $titles_color .';  }' : '';
	echo $text_color ? '#image-slides-'. esc_attr($block_id) .' .back { color: '. $text_color .';  }' : '';
	echo '</style>';
}


echo '<input type="hidden" class="slides-config" data-navigation="'. ($slider_navig ? '0' : '1') .'" data-pagination="'. ($slider_pagin ? '0' : '1') .'" data-auto="'. esc_attr($slider_timing) .'" data-desktop="'. esc_attr($items_desktop) .'" data-tablet="'. esc_attr($items_tablet) .'" data-mobile="'. esc_attr($items_mobile) .'" data-loop="1"  />';

?>
<div class="image-slides<?php echo ((count($img_arr) > 1) ? ' owl-carousel contentslides' : '') . esc_attr(' '.$image_style) . esc_attr(' '.$anim);?>">

<?php 
$i = 0;
$e_anim = ($enter_anim != 'none') ? ' to-anim' : '';
$output = '';
foreach( $img_arr as $image ) {
	
	$img				= isset($img_arr[$i]) 		? $img_arr[$i] : '';
	$description		= isset($desc_arr[$i])		? $desc_arr[$i] : '';
	$title 				= isset($titles_arr[$i])	? $titles_arr[$i] : '';

	// clean up description from paragraphs
	$paragraphs   = array("<p>", "</p>");
	$description = str_replace($paragraphs, '', $description);
	
					
	$output .= '<div class="single-slide column item">';

		if( $img ) {
			
			$output .= '<div class="anim-wrap '. esc_attr($e_anim) .'" data-i="'. esc_attr($i) .'"><div class="item-img">';
			
			$output .= '<div class="back">';
							
				$output .= '<div class="item-overlay"></div>';
				
				$output .= '<div class="table"><div class="tablerow"><div class="tablecell">';
									
					$output .= $title ? '<h4>'. esc_html($title) .'</h4>' : '';
					
					$output .= '<div class="text">' . $description .'</div>' ;
				
				$output .= '</div></div></div>'; // table divs
			
			
			$output .= '</div>'; // .back
			
			$output .= '<div class="image"><div class="image-container">';
			
				$attr = array(
					'class' => 'attachment-image',
					'title'	=> $title ? esc_attr($title) : '',
					'alt'	=> $title ? esc_attr($title) : ''
				);
				
				$output .= wp_get_attachment_image( $img, $img_format, false,  $attr ); 
			
			$output .= '</div></div>'; // .image-container .image
			
			$output .= '</div></div>'; // .it.anim-wrap
		}
	
	$output .= '</div>'; // .single-slide
	$i++;
}

echo wp_kses_post($output);
?>

</div>
<script>
(function( $ ){
	$.fn.anim_waypoints_img_tests = function(blockId, enter_anim) {
		
		var thisBlock = $('#image-slides-'+ blockId );
		if ( !window.vcase_isMobile && !window.isIE9 ) {
			var item		= thisBlock.find('.single-slide'),
				anim_wrap	= item.find(".anim-wrap");
			
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
			anim_wrap.each( function() {
				$(this).removeClass('to-anim');
			});
		}
		
	}
})( jQuery );

jQuery(document).ready( function($) {
	
	$(document).anim_waypoints_img_tests("<?php echo esc_js($block_id); ?>"," <?php echo esc_js($enter_anim);?>");
	
	var thisBlock = $("image-slides-<?php echo esc_attr($block_id); ?>");
	
	var thisMakeSlides = window.vcase_contentSlides( thisBlock );

});
</script>

<?php 

echo '</div>'; // #testimonial-slides

echo $css_classes ? '</div>' : null;
	
$output_string = ob_get_contents();

ob_end_clean();

return $output_string ;
####################  HTML ENDS HERE: ###########################

}

add_shortcode( 'as_images_slider', 'vc_ase_as_images_slider_func' );
?>