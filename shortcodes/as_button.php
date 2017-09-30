<?php
function vc_ase_as_button_func( $atts, $content = null ) { 
  
	
	extract( shortcode_atts( array(
		// element title settings
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
		// button settings
		'button_label'		=> '',
		'button_align'		=> 'center',
		'button_size'		=> 'normal',
		'button_style'		=> 'normal',
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
	
	
	####################  HTML STARTS HERE: ###########################
	ob_start();
	
	echo $css_classes ? '<div class="'.esc_attr($css_classes).'">' : null;
	
	echo '<div id="button-'. esc_attr($block_id). '" class="vc-ase-element vc-ase-button">';
	
	do_action('vc_ase_block_heading',  $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css );
	?>
	 
	<?php if( $button_label && $but_url ) { ?>
	<div class="button-wrapper <?php echo ( ( $btn_vc_css_class ? $btn_vc_css_class : '' ) . ' ' . $button_align ) ; ?>">
	
		<a href="<?php echo esc_url( $but_url ); ?>" <?php echo ($but_target ? ' target="'.esc_attr($but_target).'" ' : '');?> class="button <?php echo esc_attr( $button_size . ' ' .$button_style );?>" <?php echo ($but_title ? 'title="'.esc_attr($but_title).'"' : 'title="'.esc_attr($button_label).'"'); ?> >
			<?php echo esc_html( $button_label ); ?>
		</a>
		
	</div>
	<?php } //endif; $button_label && $but_url ?>
	
	
	
	<div class="clearfix"></div>
		
	</div><!-- / .vc-ase-element -->
		
	<?php
	####################  HTML ENDS HERE: ###########################
	echo $css_classes ? '</div>' : null;
	####################  HTML OUTPUT ENDS HERE: ###########################
	
	$output_string = ob_get_contents();
   
	ob_end_clean();
	
	return $output_string ;

}

add_shortcode( 'as_button', 'vc_ase_as_button_func' );
?>