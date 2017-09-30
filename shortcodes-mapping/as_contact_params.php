<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_contact_array(){
	
	$elm_array = array(
				
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Viewport enter animation",'vc_ase'),
			"param_name" => "enter_anim",
			"value" => apply_filters( 'as_vce_anim_array','enter_animation'),
			"std"	=> "none",
			"description" => ""
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Recipient email address (required)','vc_ase'),
			"param_name" => "contact_email",
			"value" => get_option('admin_email') ? get_option('admin_email') : '',
			"description" => "",
			"admin_label" => true,
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
			"type" => "attach_image",
			"heading" => __("Location image (optional)", 'vc_ase'),
			"param_name" => "attach_id",
			"value" => "",
			"description" => __("Select image to represent your location.", 'vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		 ),
		 
		 array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Image format",'vc_ase'),
			"param_name" => "img_format",
			"value" => apply_filters('vc_ase_image_sizes',''),
			"std"	=> "thumbnail",
			"description" => __("list of registered image sizes. WARNING: in case of theme switch some sizes will be removed.",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "separator",
			"class" => "",
			"heading" => '',
			"param_name" => "sep_2",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show location desciption",'vc_ase'),
			"param_name" => "show_desc",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "textarea_html",
			"class" => "",
			"heading" => __('Location description','vc_ase'),
			"param_name" => "content",
			//"value" => '',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-12"
		),

		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => '',
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
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
				'type' => 'css_editor',
				'heading' => __( 'Css', 'vc_ase' ),
				'param_name' => 'css',
				'group' => __( 'Design options', 'vc_ase' ),
			),
	);
	
	return $elm_array;
};
add_action( 'vc_before_init', 'vc_ase_map_as_contact' );
function vc_ase_map_as_contact() {
	vc_map( array(
		"name" => __("Contact form",'vc_ase'),
		"base" => "as_contact",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_contact',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'simple contact form', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), as_contact_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
?>