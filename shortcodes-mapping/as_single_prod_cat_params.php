<?php
/**
 *  PARAMETERS FOR ELEMENT
 *  array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_single_prod_cat_array() {

	$elm_array = array(

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Viewport enter animation', 'vc_ase' ),
			'param_name'       => 'enter_anim',
			'value'            => apply_filters( 'as_vce_anim_array', 'enter_animation' ),
			'std'              => 'none',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Product category', 'vc_ase' ),
			'param_name'       => 'sep_3',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Product category', 'vc_ase' ),
			'param_name'       => 'product_category',
			'value'            => apply_filters( 'as_vce_terms', 'product_cat', 'product' ),
			'description'      => __( 'select one product category to display products from.', 'vc_ase' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Force hiding title (category name)', 'vc_ase' ),
			'param_name'       => 'force_hide_title',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => __( 'by default, if no elements title set, category name will be displayed. This will force hide it. ', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Force hiding subtitle (category description)', 'vc_ase' ),
			'param_name'       => 'force_hide_subtitle',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => __( 'by default, if no elements subtitle set, category description (if entered in Products > Categories > [category]) will be displayed. This will force hide it. ', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Menu color settings', 'vc_ase' ),
			'param_name'       => 'sep_4',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'colorpicker',
			'class'            => '',
			'heading'          => __( 'Text color', 'vc_ase' ),
			'param_name'       => 'text_color',
			'value'            => '',
			'description'      => __( 'If categories images - choose color for text', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'colorpicker',
			'class'            => '',
			'heading'          => __( 'Overlay color', 'vc_ase' ),
			'param_name'       => 'overlay_color',
			'value'            => '',
			'description'      => __( 'If categories images - choose color for image overlay', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Image settings', 'vc_ase' ),
			'param_name'       => 'sep_4',
			'value'            => '',
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
			'heading'          => __( 'Quick view image format', 'vc_ase' ),
			'param_name'       => 'qv_img_format',
			'value'            => apply_filters( 'vc_ase_image_sizes', '' ),
			'description'      => __( 'select image format for popup "Quick view" window.', 'vc_ase' ),
			'std'              => 'thumbnail',
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Animations settings for items', 'vc_ase' ),
			'param_name'       => 'sep_7',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),
		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Hover image animation', 'vc_ase' ),
			'param_name'       => 'anim',
			'value'            => apply_filters( 'as_vce_anim_array', 'hover_animation' ),
			'std'              => 'none',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Products settings', 'vc_ase' ),
			'param_name'       => 'sep_8',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Show "Quick view" button ?', 'vc_ase' ),
			'param_name'       => 'shop_quick',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Show "Add to cart/Select options" button ?', 'vc_ase' ),
			'param_name'       => 'shop_buy_action',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Show "Add to wishlist" button ?', 'vc_ase' ),
			'param_name'       => 'shop_wishlist',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => __( 'Yith WooCommerce Wishlist plugin must be installed', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => '',
			'param_name'       => 'sep_8_2',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
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
			'description'      => __( 'make a special selection with these filters', 'vc_ase' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-12',
		),
		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => '',
			'param_name'       => 'sep_9',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Total items', 'vc_ase' ),
			'param_name'       => 'total_items',
			'value'            => '12',
			'description'      => __( 'If empty, all items will e showed.', 'vc_ase' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-3',
		),

		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Disable slider', 'vc_ase' ),
			'param_name'       => 'hide_slider',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Hide slider navigation?', 'vc_ase' ),
			'param_name'       => 'slider_navig',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => __( 'use prev / next arrows', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type'             => 'checkbox',
			'class'            => '',
			'heading'          => __( 'Hide slider pagination?', 'vc_ase' ),
			'param_name'       => 'slider_pagin',
			'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			'description'      => __( 'pagination dots bellow the slider', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-3',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Slider timing', 'vc_ase' ),
			'param_name'       => 'slider_timing',
			'value'            => '',
			'description'      => __( 'If empty, no automatic sliding will happen.', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-6',
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
			'heading'          => __( 'Additional settings', 'vc_ase' ),
			'param_name'       => 'sep_7',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Button label', 'vc_ase' ),
			'param_name'       => 'button_label',
			'value'            => '',
			'description'      => __( 'If this setting is empty, and link is set, link will apply to whole banner.', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type'             => 'vc_link',
			'class'            => '',
			'heading'          => __( 'Add link', 'vc_ase' ),
			'param_name'       => 'ap_link_button', // ap_ prefix as "Ajax products"
			'value'            => '',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-6',
		),

		array(
			'type'        => 'css_editor',
			'heading'     => __( 'Button holder css', 'vc_ase' ),
			'param_name'  => 'btn_css',
			'description' => __( 'Apply css to button holder element (not button itself)-', 'vc_ase' ),
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

function vc_ase_map_as_single_prod_cat() {
	vc_map(
		array(
			'name'        => __( 'Single category products', 'vc_ase' ),
			'base'        => 'as_single_prod_cat',
			'class'       => '',
			'weight'      => 1,
			'icon'        => 'as_single_prod_cat',
			'category'    => __( 'VC Aligator Studio Elements', 'vc_ase' ),
			'description' => __( 'products from single category', 'vc_ase' ),
			//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
			//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
			'params'      => array_merge( apply_filters( 'head_param_array', '' ), as_single_prod_cat_array() ),

		) // end array vc_map()
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_as_single_prod_cat' );
