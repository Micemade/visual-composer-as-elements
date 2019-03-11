<?php
/**
 *  PARAMETERS FOR ELEMENT
 *  array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_images_slider_array() {

	$elm_array = array(

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Viewport enter animation', 'vc_ase' ),
			'param_name'       => 'enter_anim',
			'value'            => apply_filters( 'as_vce_anim_array', 'enter_animation' ),
			'std'              => 'none',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Hover image animation', 'vc_ase' ),
			'param_name'       => 'anim',
			'value'            => apply_filters( 'as_vce_anim_array', 'hover_animation' ),
			'std'              => 'none',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => '',
			'param_name'       => 'sep_5',
			'value'            => '',
			'description'      => __( 'Title and description can be added for each image.', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'attach_images',
			'heading'          => __( 'Images', 'vc_ase' ),
			'param_name'       => 'images',
			'value'            => '',
			'description'      => __( 'Select images from media library.', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Image format', 'vc_ase' ),
			'param_name'       => 'img_format',
			'value'            => apply_filters( 'vc_ase_image_sizes', '' ),
			'std'              => 'thumbnail',
			'description'      => __( 'list of registered image sizes. WARNING: in case of theme switch some sizes will be removed.', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Image style', 'vc_ase' ),
			'param_name'       => 'image_style',
			'value'            => array(
				'Square'  => 'square',
				'Round'   => 'round',
				'Diamond' => 'diamond',
			),
			'std'              => 'square',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type'        => 'exploded_textarea',
			'heading'     => __( 'Titles', 'vc_ase' ),
			'param_name'  => 'titles',
			'value'       => __( 'Image title 1,Image title 2,Image title 3', 'vc_ase' ),
			'description' => __( 'Use new line (press Enter) for each author', 'vc_ase' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea_html',
			'heading'     => __( 'Description', 'vc_ase' ),
			'param_name'  => 'content',
			'value'       => "Image description one - optional text to add on image hover.\n\nImage description one - optional text to add on image hover.\n\nImage description one - optional text to add on image hover.",
			'description' => __( 'Use new line (press Enter) for each description text', 'vc_ase' ),
		),

		array(
			'type'             => 'colorpicker',
			'class'            => '',
			'heading'          => __( 'Description text color', 'vc_ase' ),
			'param_name'       => 'text_color',
			'value'            => '',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type'             => 'colorpicker',
			'class'            => '',
			'heading'          => __( 'Title color', 'vc_ase' ),
			'param_name'       => 'titles_color',
			'value'            => '',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type'             => 'colorpicker',
			'class'            => '',
			'heading'          => __( 'Hover overlay color', 'vc_ase' ),
			'param_name'       => 'overlay_color',
			'value'            => '',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => '',
			'param_name'       => 'sep_6',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Hide slider navigation?', 'vc_ase' ),
			'param_name'       => 'slider_navig',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => __( 'use prev / next arrows', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Hide slider pagination?', 'vc_ase' ),
			'param_name'       => 'slider_pagin',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => __( 'pagination dots bellow the slider', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Slider timing', 'vc_ase' ),
			'param_name'       => 'slider_timing',
			'value'            => '',
			'description'      => __( 'If empty, no automatic sliding will happen. Set value in milliseconds, for example: 5000 for 5 seconds.', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Responsive slider settings', 'vc_ase' ),
			'param_name'       => 'sep_6',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Items in desktop view', 'vc_ase' ),
			'param_name'       => 'items_desktop',
			'value'            => '3',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Items in tablet view', 'vc_ase' ),
			'param_name'       => 'items_tablet',
			'value'            => '2',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Items in mobile view', 'vc_ase' ),
			'param_name'       => 'items_mobile',
			'value'            => '1',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => '',
			'param_name'       => 'sep_8',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

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

function vc_ase_map_as_images_slider() {
	vc_map(
		array(
			'name'        => __( 'Images slider', 'vc_ase' ),
			'base'        => 'as_images_slider',
			'class'       => '',
			'weight'      => 1,
			'icon'        => 'as_images_slider',
			'category'    => __( 'VC Aligator Studio Elements', 'vc_ase' ),
			'description' => __( 'simple images slider', 'vc_ase' ),
			//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
			//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
			'params'      => array_merge( apply_filters( 'head_param_array', '' ), as_images_slider_array() ),

		) // end array vc_map()
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_as_images_slider' );
