<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_single_prod_array(){
	
	$elm_array = array(

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Block style",'vc_ase'),
			"param_name" => "block_style",
			"value" => array(
				'Image right'	=> 'images_right',
				'Image left'	=> 'images_left',
				'Centered'		=> 'centered',
				),
			"std"	=> "images_right",
			"description" => "",
			"admin_label" => true,
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
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Select product",'vc_ase'),
			"param_name" => "single_product",
			"value" => apply_filters("vc_ase_posts_array" ,"product"), 
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Product image and gallery slider settings",'vc_ase'),
			"param_name" => "sep_3",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
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
			"type" => "checkbox",
			"class" => "",
			"heading" => __("No image gallery (only featured image)",'vc_ase'),
			"param_name" => "no_gallery",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('display only product featured image','vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_3_b",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Slider navigation?",'vc_ase'),
			"param_name" => "slider_navig",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('use prev / next arrows','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Slider pagination?",'vc_ase'),
			"param_name" => "slider_navig",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('pagination dots bellow the slider','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Slider timing",'vc_ase'),
			"param_name" => "slider_timing",
			"value" => '',
			"description" => __('If empty, no automatic sliding will happen.','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Display options",'vc_ase'),
			"param_name" => "sep_4",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Product info background",'vc_ase'),
			"param_name" => "back_color",
			"value" => '',
			"description" => __("Choose background color",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
					
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Product details options",'vc_ase'),
			"param_name" => "product_options",
			"value" => array(
				'Reduced product options'	=> 'reduced',
				'Full product options'		=> 'full'
				),
			"std"	=> "reduced",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide product short description ?",'vc_ase'),
			"param_name" => "hide_short_desc",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => "",
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide product image ?",'vc_ase'),
			"param_name" => "hide_image",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __("if you hide product image, there's still an option of row background image.",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		

		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Animations settings for items",'vc_ase'),
			"param_name" => "sep_6",
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
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Hover image animation",'vc_ase'),
			"param_name" => "anim",
			"value" => apply_filters( 'as_vce_anim_array','hover_animation'),
			"std"	=> "none",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Additional settings",'vc_ase'),
			"param_name" => "sep_7",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			'type' => 'css_editor',
			'heading' => __( 'Product info css', 'vc_ase' ),
			'param_name' => 'css_item_data',
			//'group' => __( 'Design options', 'vc_ase' ),
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
};

function vc_ase_map_as_single_prod() {
	vc_map( array(
		"name" => __("Single product",'vc_ase'),
		"base" => "as_single_prod",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_single_prod',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'single product with action buttons', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), as_single_prod_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_as_single_prod' );
