<?php
add_action( 'vc_before_init', 'vc_ase_map_as_heading' );
function vc_ase_map_as_heading() {
	vc_map( array(
		"name" => __("Heading",'vc_ase'),
		"base" => "as_heading",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_heading',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'custom title with controls', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array(

			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Element title",'vc_ase'),
				"param_name" => "title",
				"value" => "",
				"description" => "",
				"admin_label" => true,
				"edit_field_class"=> "vc_col-sm-6"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Element subtitle",'vc_ase'),
				"param_name" => "subtitle",
				"value" => "",
				"description" => "",
				
				"edit_field_class"=> "vc_col-sm-6"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Element title style",'vc_ase'),
				"param_name" => "title_style",
				"value" => array(
					'Center'		=> 'center',
					'Float left'	=> 'float_left',
					'Float right'	=> 'float_right'
					),
				"std"	=> "center",
				"description" => "",
				
				"edit_field_class"=> "vc_col-sm-6"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Element subtitle style",'vc_ase'),
				"param_name" => "sub_position",
				"value" => array(
					'Bellow heading'	=> 'bellow',
					'Above heading'		=> 'above',
					),
				"std"	=> "bellow",
				"description" => "",
				
				"edit_field_class"=> "vc_col-sm-6"
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
				"type" => "separator",
				"class" => "",
				"heading" => "",
				"param_name" => "sep2",
				"value" => '',
				"desc" =>"",
				"edit_field_class"=> "vc_col-sm-12"
			),
			
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Title color",'vc_ase'),
				"param_name" => "title_color",
				"value" => '',
				"description" => "",
				"edit_field_class"=> "vc_col-sm-4"
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Subtitle color",'vc_ase'),
				"param_name" => "subtitle_color",
				"value" => '#999',
				"description" => "",
				
				"edit_field_class"=> "vc_col-sm-4"
			),
			
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Background color",'vc_ase'),
				"param_name" => "bck_color",
				"value" => '',
				"description" => "",
				"edit_field_class"=> "vc_col-sm-4"
			),
			
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Title additional sizing",'vc_ase'),
				"param_name" => "title_size",
				"value" => array(
					'Normal'	=> '100%',
					'Larger'	=> '125%',
					'Big'		=> '150%',
					'Bigger'	=> '200%',
					'Really Big'=> '300%',
					'Smaller'	=> '90%',
					'Small'		=> '80%',
					'Even smaller'=> '70%',					
					),
				"std"	=> "100%",
				"description" => "",
				"edit_field_class"=> "vc_col-sm-6"
			),
			
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Heading tag",'vc_ase'),
				"param_name" => "tag",
				"value" => array(
					''		=> '',
					'h1'	=> 'h1',
					'h2'	=> 'h2',
					'h3'	=> 'h3',
					'h4'	=> 'h4',
					'h5'	=> 'h5',
					'h6'	=> 'h6',
					),
				"description" => __("Use wisely - heading tag affects the semantic structure and SEO.",'vc_ase'),
				"edit_field_class"=> "vc_col-sm-12"
			),
			
			array(
				"type" => "separator",
				"class" => "",
				"heading" => '',
				"param_name" => "sep_1",
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
				"edit_field_class"=> "vc_col-sm-6",
				
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Animation delay ( in milliseconds )",'vc_ase'),
				"param_name" => "anim_delay",
				"value" => '500',
				"description" => __("Type the value for delay of block animation delay. Use the miliseconds ( 1second = 1000 miliseconds; example: 100 for 1/10th of second )",'vc_ase'),
				"edit_field_class"=> "vc_col-sm-6",
				
			),
			
			array(
				"type" => "separator",
				"class" => "",
				"heading" => __("Absolute heading positioning",'vc_ase'),
				"param_name" => "sep_2",
				"value" => '',
				"edit_field_class"=> "vc_col-sm-12"
			),
			
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Position heading to absolute ?",'vc_ase'),
				"param_name" => "abs_heading",
				"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				"description" => __('absolute heading is related to first relative parent','vc_ase'),
				"admin_label" => true,
				"edit_field_class"=> "vc_col-sm-3",
				
			),
			
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Top position",'vc_ase'),
				"param_name" => "abs_top",
				"value" => "",
				"description" => __("enter value AND unit (px, em, rem or %)",'vc_ase'),
				"edit_field_class"=> "vc_col-sm-3",
				
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Left position",'vc_ase'),
				"param_name" => "abs_left",
				"value" => '11.5%',
				"description" => __("enter value AND unit (px, em, rem or %)",'vc_ase'),
				"edit_field_class"=> "vc_col-sm-3",	
			),
			
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Right position",'vc_ase'),
				"param_name" => "abs_right",
				"value" => '11.5%',
				"description" => __("enter value AND unit (px, em, rem or %)",'vc_ase'),
				"edit_field_class"=> "vc_col-sm-3",	
			),
			
			array(
				"type" => "separator",
				"class" => "",
				"heading" => "",
				"param_name" => "sep_3",
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
				"edit_field_class"=> "vc_col-sm-12",
				
			),
			
			
			array(
				"type" => "separator",
				"class" => "",
				"heading" => "",
				"param_name" => "sep_1_1",
				"value" => '',
				"description" => __("Settings bellow will apply to heading ONLY and not subititle",'vc_ase'),
				"edit_field_class"=> "vc_col-sm-12",
				'group' => __( 'Design options', 'vc_ase' ),
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'Css', 'vc_ase' ),
				'param_name' => 'css',
				'group' => __( 'Design options', 'vc_ase' ),
			),
			
			
		) // end params array
		) // end array vc_map()
	); // end vc_map()
}
?>