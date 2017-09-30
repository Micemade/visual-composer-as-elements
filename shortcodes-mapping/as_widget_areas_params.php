<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_widget_areas_array(){
	
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
			"heading" => __("Widget area to display",'vc_ase'),
			"param_name" => "widget_area",
			"value" => apply_filters('vc_ase_get_widgets', ''),
			"description" => __("To add widgets in widget area (sidebar), go to Apparance > Widgets",'vc_ase'),
			"admin_label" => true,
		),
		
		
		array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'vc_ase' ),
			'param_name' => 'css',
			//'group' => __( 'Design options', 'vc_ase' ),
		),
		

		array(
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __("Widgets alignment",'vc_ase'),
			"param_name"	=> "widgets_align",
			"value" => array(
					'Align left'	=> 'align_left',
					'Align right'	=> 'align_right'
				),
			"std"			=> "align_left",
			"description"	=> "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("WIDGETS SECTION MARGINS",'vc_ase'),
			"param_name" => "sep_1",
			"description" => __('Override widgets container margins (applies to each individual widget)','vc_ase'),
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Widgets section TOP margin','vc_ase'),
			"param_name" => "widg_margin_top",
			"value" => '',
			"description" => __('Override top margin','vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Widgets section BOTTOM margin','vc_ase'),
			"param_name" => "widg_margin_bottom",
			"value" => '',
			"description" => __('Override bottom margin','vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
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
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_2",
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
add_action( 'vc_before_init', 'vc_ase_map_as_widget_areas' );
function vc_ase_map_as_widget_areas() {
	vc_map( array(
		"name" => __("Widget area",'vc_ase'),
		"base" => "as_widget_areas",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_widget_areas',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'add widget area (sidebar)', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), as_widget_areas_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
?>