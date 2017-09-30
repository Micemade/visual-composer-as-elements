<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_menu_array(){
	
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
			"heading" => __("Select menu to display",'vc_ase'),
			"param_name" => "menu",
			"value" => apply_filters('vc_ase_get_menus', true),
			"description" => __("Menu must be created first, in WP admin - Appearance > Menus",'vc_ase'),
			"admin_label" => true,
		),
		/* 
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Menu orientation",'vc_ase'),
			"param_name" => "orientation",
			"value" => array(
				'Vertical'		=> 'vertical',
				'Horizontal'	=> 'horizontal'
				),
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		*/
		array(
			'type' => 'css_editor',
			"heading" => __("CSS",'vc_ase'),
			'param_name' => 'menu_holder_css',
			"description" => __('Apply css to menu holder element (not menu itself)-','vc_ase'),
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
add_action( 'vc_before_init', 'vc_ase_map_as_menu' );
function vc_ase_map_as_menu() {
	vc_map( array(
		"name" => __("Custom menu",'vc_ase'),
		"base" => "as_menu",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_menu',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'select from created menus', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), as_menu_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
?>