<?php
/**
 *  PARAMETERS FOR ELEMENT
 *  array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_prod_cats_array() {

	$elm_array = array(

		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => __( 'Viewport enter animation', 'vc_ase' ),
			'param_name'  => 'enter_anim',
			'value'       => apply_filters( 'as_vce_anim_array', 'enter_animation' ),
			'std'         => 'none',
			'description' => '',
		),

		array(
			'type'        => 'checkbox',
			'class'       => '',
			'heading'     => __( 'Product categories', 'vc_ase' ),
			'param_name'  => 'product_cats',
			'value'       => apply_filters( 'as_vce_terms', 'product_cat', 'product' ),
			'description' => __( 'select one or multiple product categories', 'vc_ase' ),
			'admin_label' => true,
		),
		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => '',
			'param_name'       => 'sep_0',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),
		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Categories menu', 'vc_ase' ),
			'param_name'       => 'prod_cat_menu',
			'value'            => array(
				'With category images'    => 'images',
				'Without category images' => 'no_images',
			),
			'std'              => 'images',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Menu columns', 'vc_ase' ),
			'param_name'       => 'menu_columns',
			'value'            => array(
				'Auto float'   => 'auto',
				'1'            => '1',
				'2'            => '2',
				'3'            => '3',
				'4'            => '4',
				'6'            => '6',
				'Auto stretch' => 'stretch',
			),
			'std'              => 'auto',
			'description'      => __( 'applies only if categories menu is "With images"' ),
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Categories menu alignment', 'vc_ase' ),
			'param_name'       => 'tax_menu_align',
			'value'            => array(
				'Center'      => 'center',
				'Align left'  => 'align_left',
				'Align right' => 'align_right',
			),
			'std'              => 'center',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Remove items gutter', 'vc_ase' ),
			'param_name'       => 'remove_gutter',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => __( 'remove spaces between items and on element sides, created by grid', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => '',
			'param_name'       => 'sep_1',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Image width', 'vc_ase' ),
			'param_name'       => 'img_width',
			'value'            => '300',
			'description'      => 'set custom image width - must use height, too.',
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Image height', 'vc_ase' ),
			'param_name'       => 'img_height',
			'value'            => '180',
			'description'      => 'set custom image height - must use width, too.',
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'colorpicker',
			'class'            => '',
			'heading'          => __( 'Text over category image color', 'vc_ase' ),
			'param_name'       => 'text_color',
			'value'            => 'rgba(0,0,0,0.8)',
			'description'      => __( 'Choose text color', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type'             => 'colorpicker',
			'class'            => '',
			'heading'          => __( 'Category image overlay color', 'vc_ase' ),
			'param_name'       => 'overlay_color',
			'value'            => 'rgba(255,255,255,0.3)',
			'description'      => __( 'Choose overlay color', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Overlay opacity', 'vc_ase' ),
			'param_name'       => 'overlay_opacity',
			'value'            => 0,
			'description'      => 'set category image overlay opacity, from 0 - 100 (only number)',
			'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Overlay opacity on hover', 'vc_ase' ),
			'param_name'       => 'overlay_opacity_hover',
			'value'            => 70,
			'description'      => 'set category image overlay opacity when mouse hovers image, from 0 - 100 (only number)',
			'edit_field_class' => 'vc_col-sm-3',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Hide category description', 'vc_ase' ),
			'param_name'       => 'force_hide_desc',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => __( 'category descirptions are added in "Products" > "Categories"', 'vc_ase' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => '',
			'param_name'       => 'sep_2',
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

function vc_ase_map_as_prod_cats() {
	vc_map(
		array(
			'name'        => __( 'Product categories', 'vc_ase' ),
			'base'        => 'as_prod_cats',
			'class'       => '',
			'weight'      => 1,
			'icon'        => 'as_prod_cats',
			'category'    => __( 'VC Aligator Studio Elements', 'vc_ase' ),
			'description' => __( 'product categories with images', 'vc_ase' ),
			//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
			//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
			'params'      => array_merge( apply_filters( 'head_param_array', '' ), as_prod_cats_array() ),

		) // end array vc_map()
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_as_prod_cats' );
