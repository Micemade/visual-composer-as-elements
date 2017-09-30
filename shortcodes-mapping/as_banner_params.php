<?php
function as_banner_array(){
	
	$elm_array = array(
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Banner text settings",'vc_ase'),
			"param_name" => "sep_3",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Banner title",'vc_ase'),
			"param_name" => "title",
			"value" => "",
			"description" => "",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Add typewriter effect on title",'vc_ase'),
			"param_name" => "type_eff",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __("add typewriter effect with multiple senteces to title, divided by sign \"|\" (without quotation)","vc_ase"),
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Title size",'vc_ase'),
			"param_name" => "title_size",
			"value" => array(
				'Normal'	=> '100%',
				'Larger'	=> '125%',
				'Big'		=> '150%',
				'Smaller'	=> '90%',
				'Small'		=> '80%',
				),
			"std"	=> "100%",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Banner subtitle",'vc_ase'),
			"param_name" => "subtitle",
			"value" => "",
			"description" => "",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title custom css",'vc_ase'),
			"param_name" => "title_custom_css",
			"value" => "",
			"description" => __('Custom css selector for title','vc_ase'),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Subtitle custom css",'vc_ase'),
			"param_name" => "subtitle_custom_css",
			"value" => "",
			"description" => __('Custom css selector for subtitle','vc_ase'),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-6"
		),
		
	
		
		array(
			"type" => "textarea_html",
			"class" => "",
			"heading" => __("Banner text",'vc_ase'),
			"param_name" => "content",
			//"value" => "",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Text vertical align",'vc_ase'),
			"param_name" => "vertical_align",
			"value" => array(
				'Top'		=> 'top',
				'Middle'	=> 'middle',
				'Bottom'	=> 'bottom'
				),
			"std"	=> "middle",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Text (elements) float",'vc_ase'),
			"param_name" => "align_float",
			"value" => array(
				'Center'		=> 'center',
				'Align left'	=> 'float_left',
				'Align right'	=> 'float_right'
				),
			"std"	=> "center",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Text padding",'vc_ase'),
			"param_name" => "text_padding",
			"value" => "",
			"description" => __("If zero or empty, it will be ignored",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Text color",'vc_ase'),
			"param_name" => "text_color",
			"value" => '',
			"description" => __("Choose text color",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Text border style",'vc_ase'),
			"param_name" => "border",
			"value" => array(
				'None'		=> 'none',
				'Solid'		=> 'solid',
				'Dashed'	=> 'dashed',
				'Dotted'	=> 'dotted',
				'Double'	=> 'double'
				),
			"std"	=> "none",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_0",
			"value" => '',
			"desc" =>"",
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Disable invert colors on hover effect",'vc_ase'),
			"param_name" => "disable_invert",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("TEXT overlay color",'vc_ase'),
			"param_name" => "overlay",
			"value" => '',
			"description" => __("Choose overlay color",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_3_0",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Banner overlay color",'vc_ase'),
			"param_name" => "block_overlay",
			"value" => '',
			"description" => __("Choose overlay color for all block (text block has it's separate color controls )",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Banner opacity",'vc_ase'),
			"param_name" => "block_opacity",
			"value" => "",
			"description" => __("Enter value AND unit (px, em, rem, %)",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Banner height",'vc_ase'),
			"param_name" => "banner_height",
			"value" => "",
			"description" => __("add value AND unit ( px, em, rem, % ) for stretch banner height ",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
					
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Additional layout and styles settings",'vc_ase'),
			"param_name" => "sep_1_1",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'vc_ase' ),
			'param_name' => 'css',
			//'group' => __( 'Design options', 'vc_ase' ),
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Animation settings",'vc_ase'),
			"param_name" => "sep_2",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Viewport enter animation",'vc_ase'),
			"param_name" => "enter_anim",
			"value" => apply_filters( 'as_vce_anim_array','enter_animation'),
			"std"	=> "none",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Animation delay",'vc_ase'),
			"param_name" => "anim_delay",
			"value" => "",
			"description" => __("Type the value for delay of block animation delay. Use the miliseconds ( 1second = 1000 miliseconds; example: 100 for 1/10th of second )",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Button settings",'vc_ase'),
			"param_name" => "sep_3",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Button label','vc_ase'),
			"param_name" => "button_label",
			"value" => '',
			"description" => __("If this setting is empty, and link is set, link will apply to whole banner.",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "vc_link",
			"class" => "",
			"heading" => __("Add link",'vc_ase'),
			"param_name" => "link_button",
			"value" => "",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
					
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_4",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Additional CSS classes','vc_ase'),
			"param_name" => "css_classes",
			"value" => '',
			"description" => __('Adds a wrapper div with additional css classes for more styling control','vc_ase'),
			"edit_field_class"=> "vc_col-sm-12"
		)
		/*
		array(
			"type" => "textarea_html",
			"class" => "",
			"heading" => __("Content"),
			"param_name" => "content",
			"value" => __("<p>I am test text block. Click edit button to change this text.</p>"),
			"description" => __("Enter your content.")
		)
		*/
	);
	
	return $elm_array;
}
add_action( 'vc_before_init', 'vc_ase_map_as_banner' );
function vc_ase_map_as_banner() {
	vc_map( array(
		
		"name" => __("Banner",'vc_ase'),
		"base" => "as_banner",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_banner',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'custom image with callout', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => as_banner_array()
		
		) // end array vc_map()
	); // end vc_map()
}
?>