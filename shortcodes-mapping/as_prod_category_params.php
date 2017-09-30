<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_prod_cat_single_array(){
	
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
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Product categories",'vc_ase'),
			"param_name" => "product_cats",
			"value" => apply_filters('as_vce_terms', 'product_cat' ),
			"description" => __('select single product category','vc_ase'),
			"admin_label" => true,
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Image width",'vc_ase'),
			"param_name" => "img_width",
			"value" => '300',
			"description" => 'set custom image width - must use height, too. This setting will override "Image format"',
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Image height",'vc_ase'),
			"param_name" => "img_height",
			"value" => '180',
			"description" => 'set custom image height - must use width, too. This setting will override "Image format"',
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "separator",
			"class" => "",
			"heading" => '',
			"param_name" => "sep_0",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Text over category image color",'vc_ase'),
			"param_name" => "text_color",
			"value" => '',
			"description" => __("Choose text color",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Category image overlay color",'vc_ase'),
			"param_name" => "overlay_color",
			"value" => '',
			"description" => __("Choose text color",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Overlay opacity",'vc_ase'),
			"param_name" => "overlay_opacity",
			"value" => 0,
			"description" => 'set category image overlay opacity, from 0 - 100 (only number)',
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Overlay opacity on hover",'vc_ase'),
			"param_name" => "overlay_opacity_hover",
			"value" => 70,
			"description" => 'set category image overlay opacity when mouse hovers image, from 0 - 100 (only number)',
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide category description",'vc_ase'),
			"param_name" => "force_hide_desc",
			"value" =>  array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('category descirptions are added in "Products" > "Categories"','vc_ase'),
			"admin_label" => true,
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
add_action( 'vc_before_init', 'vc_ase_map_as_prod_cat_single' );
function vc_ase_map_as_prod_cat_single() {
	vc_map( array(
		"name" => __("Product category",'vc_ase'),
		"base" => "as_prod_cat_single",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_prod_cat_single',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'single product category image', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), as_prod_cat_single_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
?>