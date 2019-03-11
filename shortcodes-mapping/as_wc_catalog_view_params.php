<?php
/**
 *  PARAMETERS FOR ELEMENT
 *  array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_wc_catalog_view_array() {

	$elm_array = array(

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Product categories and categories menu', 'vc_ase' ),
			'param_name'       => 'sep_2',
			//"value" => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Product categories', 'vc_ase' ),
			'param_name'       => 'product_cats',
			'value'            => apply_filters( 'as_vce_terms', 'product_cat', 'product' ),
			'description'      => __( 'select one or multiple categories', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
			'admin_label'      => true,
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Display titles of selected categories ?', 'vc_ase' ),
			'param_name'       => 'cat_titles',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Special filters', 'vc_ase' ),
			'param_name'       => 'filters',
			'value'            => array(
				'Latest products'       => 'latest',
				'Featured products'     => 'featured',
				'Best selling products' => 'best_sellers',
				'Best rated products'   => 'best_rated',
				'Random products'       => 'random',
			),
			'std'              => 'latest',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Item settings', 'vc_ase' ),
			'param_name'       => 'sep_5',
			//"value" => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Total items', 'vc_ase' ),
			'param_name'       => 'total_items',
			'value'            => '',
			'description'      => __( 'If empty, all items will be displayed.', 'vc_ase' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Items in row', 'vc_ase' ),
			'param_name'       => 'items_row',
			'value'            => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'6' => '6',
			),
			'std'              => '3',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-3',
		),

	);

	return $elm_array;

};
/**
 *  LARIX_GRID_LIST_ARRAY
 *
 *  @return array $grid_list_select
 *
 *  If Larix (Micemade) theme is activated, control the grid / list view, otherwise ignore
 */
function larix_grid_list_array() {

	$grid_list_select = array();

	if ( LARIX_THEME_ACTIVE ) {
		$grid_list_select = array(

			array(
				'type'             => 'dropdown',
				'class'            => '',
				'heading'          => __( 'Grid / list control', 'vc_ase' ),
				'param_name'       => 'grid_list',
				'value'            => array(
					'Show buttons, "grid view" default' => 'show_grid',
					'Show buttons, "list view" default' => 'show_list',
					'Hide buttons, "grid view" default' => 'hide_grid',
					'Hide buttons, "list view" default' => 'hide_list',
				),
				'std'              => 'show_grid',
				'description'      => '',
				'edit_field_class' => 'vc_col-sm-6',
			),
		);
	}

	return $grid_list_select;
};

function additional_classes_param() {

	$elm_array = array(

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

function vc_ase_map_as_wc_catalog_view() {
	vc_map(
		array(
			'name'        => __( 'WC catalog page view', 'vc_ase' ),
			'base'        => 'as_wc_catalog_view',
			'class'       => '',
			'weight'      => 1,
			'icon'        => 'as_wc_catalog_view',
			'category'    => __( 'VC Aligator Studio Elements', 'vc_ase' ),
			'description' => __( 'WC shop/catalog view', 'vc_ase' ),
			//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
			//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
			'params'      => array_merge( apply_filters( 'head_param_array', '' ), as_wc_catalog_view_array(), larix_grid_list_array(), additional_classes_param() ),

		) // end array vc_map()
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_as_wc_catalog_view' );
