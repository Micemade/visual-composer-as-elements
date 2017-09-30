<?php
function vc_ase_as_social_func( $atts, $content = null ) {

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
		'heading_css'		=> '',
		
		'enter_anim'	=> 'none',
		
		'size'			=> 'default',
		'align'			=> 'center',
		'items'			=> 'stretched',
		
		'facebook'		=> '',
		'twitter'		=> '',
		'instagram'		=> '',
		'linkedin'		=> '',
		'gplus'			=> '',
		'pinterest'		=> '',
		'tumblr'		=> '',
		'dribbble'		=> '',
		'skype'			=> '',
		
		'css'			=> '',
		'css_classes'	=> '',
		'block_id'		=> apply_filters( 'vc_ase_randomString',10 )
		  
	), $atts ) );
	
$vc_css_class =  vc_shortcode_custom_css_class( $css, ' '  );

####################  HTML STARTS HERE: #########################

ob_start();
echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;

do_action('vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );


echo '<div class="vc-ase-element social-block '. esc_attr($size).' '.esc_attr($align). ' '. esc_attr($items) . esc_attr($vc_css_class) .'" id="social-'.$block_id.'">';

	
	echo '<div class="table"><div class="tablerow">'; // table layout start

		echo $facebook	? '<a class="tablecell facebook tip-top" href="' .esc_attr( $facebook ). '" target="_blank" title="Facebook"><span class="fa fa-facebook"></span></a>' : '';
		
		echo $twitter 	? '<a class="tablecell twitter tip-top" href="' .esc_attr( $twitter ). '" target="_blank" title="Twitter"><span class="fa fa-twitter"></span></a>' : '';
		
		echo $instagram	? '<a class="tablecell instagram tip-top" href="' .esc_attr( $instagram ). '" target="_blank" title="Instagram"><span class="fa fa-instagram"></span></a>' : '';
		
		echo $linkedin	? '<a class="tablecell linkedin tip-top" href="' .esc_attr( $linkedin ). '" target="_blank" title="LinkedIn"><span class="fa fa-linkedin"></span></a>' : '';
		
		echo $gplus	? '<a class="tablecell gplus tip-top" href="' .esc_attr( $gplus ). '" target="_blank" title="Google plus"><span class="fa fa-google-plus"></span></a>' : '';
		
		echo $pinterest	? '<a class="tablecell pinterest tip-top" href="' .esc_attr( $pinterest ). '" target="_blank" title="Pinterest"><span class="fa fa-pinterest-p"></span></a>' : '';
		
		echo $tumblr	? '<a class="tablecell tumblr tip-top" href="' .esc_attr( $tumblr ). '" target="_blank" title="Tumblr"><span class="fa fa-tumblr"></span></a>' : '';
		
		echo $dribbble	? '<a class="tablecell dribbble tip-top" href="' .esc_attr( $dribbble ). '" target="_blank" title="Dribbble"><span class="fa fa-dribbble"></span></a>' : '';

		echo $skype	? '<a class="tablecell skype tip-top" href="' .esc_attr( $skype ). '" target="_blank" title="Skype"><span class="fa fa-skype"></span></a>' : '';
	
	echo '</div></div>'; // table layout end

echo '</div>';//end .social-block

####################  HTML ENDS HERE: ###########################
echo $css_classes ? '</div>' : null;
	
$output_string = ob_get_contents();

ob_end_clean();

return $output_string ;
####################  HTML ENDS HERE: ###########################

}

add_shortcode( 'as_social', 'vc_ase_as_social_func' );
?>