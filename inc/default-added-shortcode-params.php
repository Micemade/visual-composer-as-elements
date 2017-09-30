<?php
function as_themes_params() {
	$as_themes_params = array();
	if( 'larix' == get_option( 'template' ) ) {
		$as_themes_params = array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Larix theme background",'vc_ase'),
				"param_name" => "as_theme_larix",
				"value" => array(
					'No theme back color'			=> 'none',
					'Content primary back color'	=> 'primary-customizer',
					'Content secondary back color'	=> 'secondary-customizer',
					),
				"std"	=> "none",
				"description" => __("Use Larix theme primary or secondary back color for content -<strong> THEME CUSTOMIZE changes will apply</strong> (will be discarded when theme is switched)"),
				"group"	=> "Design Options",
				"edit_field_class"=> "vc_col-sm-12"
			),
		);
	}
	
	return $as_themes_params;
}

/*
 *	HEADINGS PARAMS
 *	- parameters for headings for all (or most of) elements
 *
 */
add_filter("head_param_array", "head_param_array_func", 10,1); 
function head_param_array_func( $head_array = '' ){
	$head_array = array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Element title",'vc_ase'),
			"param_name" => "title",
			"value" => "",
			"description" => "",
			"admin_label" => true,
			"group"	=> "Title and subtitle settings",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Element subtitle",'vc_ase'),
			"param_name" => "subtitle",
			"value" => "",
			"description" => "",
			"group"	=> "Title and subtitle settings",
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
			"group"	=> "Title and subtitle settings",
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
			"group"	=> "Title and subtitle settings",
			"edit_field_class"=> "vc_col-sm-6"
		),
		
				
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title custom css",'vc_ase'),
			"param_name" => "title_custom_css",
			"value" => "",
			"description" => __('Custom css selector for title','vc_ase'),
			"group"	=> "Title and subtitle settings",
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
			"group"	=> "Title and subtitle settings",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-6"
		),
		

		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Title color",'vc_ase'),
			"param_name" => "title_color",
			"value" => '',
			"description" => "",
			"group"	=> "Title and subtitle settings",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Subtitle color",'vc_ase'),
			"param_name" => "subtitle_color",
			"value" => '#999',
			"description" => "",
			"group"	=> "Title and subtitle settings",
			"edit_field_class"=> "vc_col-sm-6"
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
				'Smaller'	=> '90%',
				'Small'		=> '80%',
				),
			"std"	=> "100%",
			"description" => "",
			"group"	=> "Title and subtitle settings",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'vc_ase' ),
			'param_name' => 'heading_css',
			'group' => __( 'Title and subtitle settings', 'vc_ase' ),
		),
		
	);
	return $head_array;
}

/**
 *	Additional ROW settings
 */

$add_row_params = array(
	
	array(
		'type' => 'dropdown',
		'heading' => __( 'Parallax background properties', 'js_composer' ),
		'param_name' => 'vc_ase_parallax_prop',
		'value' => array(
			"Cover"		=> "cover",
			"Contain"	=> "contain",
			"Repeat"	=> "repeat",
			"Repeat X"	=> "repeat-x",
			"Repeat Y"	=> "repeat-y",
		),
		'description' => __( 'set repeating or stretching parallax image. NOTE: row ID must be set (look above for ID field)', 'js_composer' ),
		'dependency' => array(
			'element' => 'parallax',
			'not_empty' => true,
		),
	),

	array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => __("Overlay color",'vc_ase'),
		"param_name" => "overlay_color",
		"value" => '',
		"description" => __("Choose color for overlay - between content and (paralax) background image",'vc_ase'),
		"edit_field_class"=> "vc_col-sm-6",
		'group' => __('VC ASE settings','vc_ase')
	),			
	array(
		"type" => "textfield",
		"class" => "",
		"heading" => __('Overlay opacity','vc_ase'),
		"param_name" => "overlay_opacity",
		"value" => '0.5',
		"description" => __('Default opacity for overlay - (change it, if you must)','vc_ase'),
		"edit_field_class"=> "vc_col-sm-6",
		'group' => __('VC ASE settings','vc_ase')
	),
	
	array(
		"type" => "separator",
		"class" => "",
		"heading" => "",
		"param_name" => "sep_0",
		"value" => '',
		"description" => "",
		"edit_field_class"=> "vc_col-sm-12",
		'group' => __('VC ASE settings','vc_ase')
	),
	

	array(
		"type" => "checkbox",
		"class" => "",
		"heading" => __("Equalize row columns",'vc_ase'),
		"param_name" => "equalize",
		"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
		"description" => __("make columns inside row to have equal heights.",'vc_ase'),
		"edit_field_class"=> "vc_col-sm-6",
		'group' => __('VC ASE settings','vc_ase')
	),
	
	array(
		"type" => "checkbox",
		"class" => "",
		"heading" => __("Row Z index above",'vc_ase'),
		"param_name" => "z_index_above",
		"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
		"description" => __("put this row in rendering above other rows (usefull when \"Custom menu\" element is inside row - to make sure submenus appear completely )",'vc_ase'),
		"edit_field_class"=> "vc_col-sm-6",
		'group' => __('VC ASE settings','vc_ase')
	),

	
);

$row_params = array_merge( as_themes_params() ,$add_row_params );

vc_add_params( 'vc_row', $row_params );

/*
 *	COLUMN ELEMENT - ADDITIONAL SETTINGS
 */
$add_column_params = array(
	
	array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => __("Text color",'vc_ase'),
		"param_name" => "font_color",
		"value" => '',
		"description" => __("Choose color for text - general column setting - can be overriden by inner elements settings",'vc_ase'),
		'group' => __('Design Options','vc_ase')
	),	
	array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => __("Column overlay color",'vc_ase'),
		"param_name" => "col_overlay_color",
		"value" => '',
		"description" => __("Choose color for overlay - a layer between column content and background.",'vc_ase'),
		'group' => __('Design Options','vc_ase')
	),
	array(
		"type" => "checkbox",
		"class" => "",
		"heading" => __('Sticky column settings','vc_ase'),
		"param_name" => "column_sticked",
		"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
		"description" => __("Best used with sidebar widgets element","vc_ase"),
		"edit_field_class"=> "vc_col-sm-3",
		'group' => __('VC ASE settings','vc_ase')
	),
	array(
		"type" => "checkbox",
		"class" => "",
		"heading" => __('Remove side grid spacing','vc_ase'),
		"param_name" => "no_spacing",
		"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
		"description" => __("reset side paddings to 0 with one click, best used for full width rows","vc_ase"),
		"edit_field_class"=> "vc_col-sm-3",
		'group' => __('VC ASE settings','vc_ase')
	),
	array(
		"type" => "checkbox",
		"class" => "",
		"heading" => __("Column Z index above",'vc_ase'),
		"param_name" => "col_z_index_above",
		"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
		"description" => __("put this column in rendering above other columns (usefull when \"Custom menu\" element is inside - to make sure submenus appear completely )",'vc_ase'),
		"edit_field_class"=> "vc_col-sm-3",
		'group' => __('VC ASE settings','vc_ase')
	),
);
$column_params = array_merge( as_themes_params() ,$add_column_params );

vc_add_params( 'vc_column', $column_params );
//
//
/**
 *	AS_VCE_SEPARATOR
 *	// separator for fields
 *	
 *	return string $separator_html
 */
function as_vce_separator($settings, $value) {
	
	$separator_html  = '<div class="separator"></div>';
	
	return $separator_html;
}
vc_add_shortcode_param('separator', 'as_vce_separator' );
?>