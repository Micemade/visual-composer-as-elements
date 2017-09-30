<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_button_array(){
	
	$elm_array = array(
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Button text','vc_ase'),
			"param_name" => "button_label",
			"value" => __('Enter your text here','_vc_ase'),
			"description" =>"",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button size",'vc_ase'),
			"param_name" => "button_size",
			"value" => array(
				'Normal'	=> 'normal',
				'Smaller'	=> 'tiny',
				'Large'		=> 'large',
				'Expand'	=> 'expand',
				
				),
			"std"	=> "normal",
			"description" => "",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button alignment",'vc_ase'),
			"param_name" => "button_align",
			"value" => array(
				'Center'		=> 'center',
				'Align left'	=> 'align_left',
				'Align right'	=> 'align_right',
				
				),
			"std"	=> "center",
			"description" => "",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button style",'vc_ase'),
			"param_name" => "button_style",
			"value" => array(
				'Normal'		=> 'normal',
				'Border radius'	=> 'radius',
				'Rounded'	=> 'round',
				
				),
			"std"	=> "normal",
			"description" => "",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-4"
		),

		array(
			"type" => "vc_link",
			"class" => "",
			"heading" => __("Add link",'vc_ase'),
			"param_name" => "ac_link_button",
			"value" => "",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			'type' => 'css_editor',
			"heading" => __("Button holder css",'vc_ase'),
			'param_name' => 'btn_css',
			"description" => __('Apply css to button wrapper element (not the button itself) ','vc_ase'),
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
	);
	
	return $elm_array;
};
add_action( 'vc_before_init', 'vc_ase_map_as_button' );
function vc_ase_map_as_button() {
	vc_map( array(
		"name" => __("Button",'vc_ase'),
		"base" => "as_button",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_button',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'insert button and set it\'s options', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), as_button_array() )
		
		)
	); // end vc_map()
}
?>