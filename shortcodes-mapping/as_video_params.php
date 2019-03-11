<?php
/**
 *  PARAMETERS FOR ELEMENT
 *  array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_video_array() {

	$elm_array = array(

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Video hosting site', 'vc_ase' ),
			'param_name'       => 'site',
			'value'            => array(
				'Youtube'      => 'youtube',
				'Vimeo'        => 'vimeo',
				'Daily motion' => 'dailymotion',
				'Yahoo'        => 'yahoo',
				'Bliptv'       => 'bliptv',
				'Veoh'         => 'veoh',
				'Viddler'      => 'viddler',
			),
			'std'              => 'youtube',
			'description'      => '',
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Video ID', 'vc_ase' ),
			'param_name'       => 'id',
			'value'            => '',
			'description'      => __( 'Copy only video ID here, not the whole address', 'vc_ase' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Video width', 'vc_ase' ),
			'param_name'       => 'w',
			'value'            => '100%',
			'description'      => '',
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Video height', 'vc_ase' ),
			'param_name'       => 'h',
			'value'            => '450px',
			'description'      => '',
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-6',
		),
		/*
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Viewport enter animation",'vc_ase'),
			"param_name" => "enter_anim",
			"value" => apply_filters( 'as_vce_anim_array','enter_animation'),
			"description" => ""
		),
		 */

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Additional CSS classes', 'vc_ase' ),
			'param_name'       => 'css_classes',
			'value'            => '',
			'description'      => __( 'Adds a wrapper div with additional css classes for more styling control', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-12',
		),
	);

	return $elm_array;
};

function vc_ase_map_as_video() {
	vc_map(
		array(
			'name'        => __( 'Video player', 'vc_ase' ),
			'base'        => 'as_video',
			'class'       => '',
			'weight'      => 1,
			'icon'        => 'as_video',
			'category'    => __( 'VC Aligator Studio Elements', 'vc_ase' ),
			'description' => __( 'insert YouTube, Vimeo etc. videos', 'vc_ase' ),
			//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
			//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
			'params'      => array_merge( apply_filters( 'head_param_array', '' ), as_video_array() ),

		)
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_as_video' );
