<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_gmap_array(){
	
	$elm_array = array(
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Google maps API key",'vc_ase'),
			"description" => __("Google Maps API key must be entered to enable Google Map Element. Learn how to obtain API key: https://developers.google.com/maps/documentation/javascript/get-api-key ","vc_ase"),
			"param_name" => "sep_0",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("API key",'vc_ase'),
			"param_name" => "api_key",
			"value" => '',
			"description" => __("","vc_ase"),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"description" => "",
			"param_name" => "sep_0_1",
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
			"heading" => __("Animation delay ( in milliseconds )",'vc_ase'),
			"param_name" => "anim_delay",
			"value" => '500',
			"description" => __("Type the value for delay of block animation delay. Use the miliseconds ( 1second = 1000 miliseconds; example: 100 for 1/10th of second )",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Enter full address for google map search",'vc_ase'),
			"param_name" => "sep_1",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Address (street)",'vc_ase'),
			"param_name" => "address2",
			"value" => '',
			"description" => "",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Address (town, country)",'vc_ase'),
			"param_name" => "address3",
			"value" => '',
			"description" => "",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_2",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "textarea",
			"class" => "",
			"heading" => __("Address ( additional info )",'vc_ase'),
			"param_name" => "address4",
			"value" => '',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "attach_image",
			"heading" => __("Location image", 'vc_ase'),
			"param_name" => "attach_id",
			"value" => "",
			"description" => __("Select image for location.", 'vc_ase'),
			"edit_field_class"=> "vc_col-sm-8"
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
			"heading" => __("Location latitude",'vc_ase'),
			"param_name" => "latitude",
			"value" => '',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Location longitude",'vc_ase'),
			"param_name" => "longitude",
			"value" => '',
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
			"heading" => __("Map width",'vc_ase'),
			"param_name" => "width",
			"value" => '100%',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Map height",'vc_ase'),
			"param_name" => "height",
			"value" => '420px',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Map zoom level",'vc_ase'),
			"param_name" => "zoom",
			"value" => '15',
			"description" => __("Enter a number value from 0 - 20, WITHOUT any units",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Disable scroll zoom",'vc_ase'),
			"param_name" => "scroll_zoom",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('Disable map zooming on mousewheel scroll','vc_ase'),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_5",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Select map style",'vc_ase'),
			"param_name" => "gmap_styles",
			"value" => apply_filters( 'as_vce_gmap_array',''),
			"std"	=> "none",
			"description" => __("choose style generated by authors in https://snazzymaps.com (styles names are created by style authors)","vc_ase"),
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_6",
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
				
	);
	
	return $elm_array;
};

function vc_ase_map_gmap() {
	vc_map( array(
		"name" => __("Google map",'vc_ase'),
		"base" => "as_gmap",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_gmap',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'single google map per template', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), as_gmap_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_gmap' );
