<?php

function vc_ase_map_as_slick_slider() {

	// IF WOOCOMMERCE IS ACTIVATED:
	$is_product_tax = taxonomy_exists( 'product_cat' );
	$is_port_tax    = taxonomy_exists( 'portfolio_category' );

	if ( $is_product_tax ) {

		$prod_cats_array = array(
			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Product categories', 'vc_ase' ),
				'param_name'       => 'product_cats',
				'value'            => apply_filters( 'as_vce_terms', 'product_cat', 'product' ),
				'description'      => __( 'select one or multiple, "Post types" must be set to "Products"', 'vc_ase' ),
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-4',
				//"weight" => 1
			),
		);
	} else {
		$prod_cats_array = array();
	}

	if ( $is_port_tax ) {

		$portfolio_cats_array = array(
			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Portfolio categories', 'vc_ase' ),
				'param_name'       => 'portfolio_cats',
				'value'            => apply_filters( 'as_vce_terms', 'portfolio_category', 'portfolio' ),
				'description'      => __( 'select one or multiple, "Post types" must be set to "Portfolio categories"', 'vc_ase' ),
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-4',
				//"weight" => 2
			),
		);

	} else {
		$portfolio_cats_array = array();
	}

	$main_array = array(

		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Post type and categories', 'vc_ase' ),
			'param_name'       => 'sep_1',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Post type', 'vc_ase' ),
			'param_name'       => 'post_type',
			'value'            => array(
				'Post'      => 'post',
				'Portfolio' => 'portfolio',
				'Product'   => 'product',
			),
			'std'              => 'post',
			'description'      => '',
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-12',
		),
	);

		$main_array_2 = array(
			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Blog post categories', 'vc_ase' ),
				'param_name'       => 'post_cats',
				'value'            => apply_filters( 'as_vce_terms', 'category', 'post' ),
				'description'      => __( 'select one or multiple, "Post types" must be set to "Post"', 'vc_ase' ),
				'edit_field_class' => 'vc_col-sm-4',
				//"weight" => 100
			),

			array(
				'type'             => 'separator',
				'class'            => '',
				'heading'          => __( 'Image settings and filtering', 'vc_ase' ),
				'param_name'       => 'sep_2',
				'value'            => '',
				'edit_field_class' => 'vc_col-sm-12',
			),

			array(
				'type'             => 'textfield',
				'class'            => '',
				'heading'          => __( 'Custom image width', 'vc_ase' ),
				'param_name'       => 'custom_image_width',
				'value'            => '',
				'description'      => __( 'enter only value, units are hardcoded in pixels', 'vc_ase' ),
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-6',
			),

			array(
				'type'             => 'textfield',
				'class'            => '',
				'heading'          => __( 'Custom image height', 'vc_ase' ),
				'param_name'       => 'custom_image_height',
				'value'            => '',
				'description'      => __( 'enter only value, units are hardcoded in pixels', 'vc_ase' ),
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-6',
			),

			array(
				'type'             => 'separator',
				'class'            => '',
				'heading'          => '',
				'description'      => __( 'custom image width and height will override image format setting, but both width and height values must be set', 'vc_ase' ),
				'param_name'       => 'sep_2',
				'value'            => '',
				'edit_field_class' => 'vc_col-sm-12',
			),

			array(
				'type'             => 'dropdown',
				'class'            => '',
				'heading'          => __( 'Image format', 'vc_ase' ),
				'param_name'       => 'img_format',
				'value'            => apply_filters( 'vc_ase_image_sizes', '' ),
				'std'              => 'large',
				'description'      => __( 'list of registered image sizes. WARNING: in case of theme switch some sizes will be removed.', 'vc_ase' ),
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'             => 'dropdown',
				'class'            => '',
				'heading'          => __( 'Special filters', 'vc_ase' ),
				'param_name'       => 'filters',
				'value'            => array(
					'Latest'                          => 'latest',
					'Featured'                        => 'featured',
					'Random'                          => 'random',
					'Best selling (only WC products)' => 'best_sellers',
					'Best rated (only WC products)'   => 'best_rated',
				),
				'std'              => 'latest',
				'description'      => '',
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'             => 'textfield',
				'class'            => '',
				'heading'          => __( 'Total items', 'vc_ase' ),
				'param_name'       => 'total_items',
				'value'            => '8',
				'description'      => __( 'how many items will scroll in slick scroller ?', 'vc_ase' ),
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'             => 'separator',
				'class'            => '',
				'heading'          => __( 'Style and effects settings', 'vc_ase' ),
				'param_name'       => 'sep_3',
				'value'            => '',
				'edit_field_class' => 'vc_col-sm-12',
			),

			array(
				'type'             => 'dropdown',
				'class'            => '',
				'heading'          => __( 'Text layer style', 'vc_ase' ),
				'param_name'       => 'text_layer_style',
				'value'            => array(
					'Light' => 'light',
					'Dark'  => 'dark',
				),
				'std'              => 'light',
				'description'      => __( 'Light style has white gradient background with dark text, dark style has dark gradient background with white text', 'vc_ase' ),
				'edit_field_class' => 'vc_col-sm-12',
			),

			array(
				'type'             => 'separator',
				'class'            => '',
				'heading'          => '',
				'param_name'       => 'sep_3_1',
				'value'            => '',
				'edit_field_class' => 'vc_col-sm-12',
			),

			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Use KenBurns effect ?', 'vc_ase' ),
				'param_name'       => 'kenburns',
				'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'description'      => __( 'KenBurns effect is slowly zooming and panning image', 'vc_ase' ),
				'edit_field_class' => 'vc_col-sm-3',
			),

			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Hide text layer (title and excerpt)', 'vc_ase' ),
				'param_name'       => 'hide_text',
				'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'description'      => '',
				'edit_field_class' => 'vc_col-sm-3',
			),

			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Text layer animation ?', 'vc_ase' ),
				'param_name'       => 'text_layer_anim',
				'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'description'      => '',
				'edit_field_class' => 'vc_col-sm-3',
			),

			array(
				'type'             => 'dropdown',
				'class'            => '',
				'heading'          => __( 'Text layer animation type', 'vc_ase' ),
				'param_name'       => 'text_layer_anim_type',
				'value'            => apply_filters( 'as_vce_anim_array', 'enter_animation' ),
				'std'              => 'none',
				'description'      => '',
				'edit_field_class' => 'vc_col-sm-3',
			),

			array(
				'type'             => 'separator',
				'class'            => '',
				'heading'          => __( 'Slider settings', 'vc_ase' ),
				'param_name'       => 'sep_4',
				'value'            => '',
				'edit_field_class' => 'vc_col-sm-12',
			),

			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Show navigation arrows ?', 'vc_ase' ),
				'param_name'       => 'slider_navig',
				'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'description'      => '',
				'edit_field_class' => 'vc_col-sm-3',
			),
			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Show navigation dots ?', 'vc_ase' ),
				'param_name'       => 'slider_pagin',
				'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'description'      => '',
				'edit_field_class' => 'vc_col-sm-3',
			),
			array(
				'type'             => 'textfield',
				'class'            => '',
				'heading'          => __( 'Slider timing', 'vc_ase' ),
				'param_name'       => 'slider_auto',
				'value'            => '',
				'description'      => __( 'type in the timing for auto sliding items. If left blank no auto sliding will occur.', 'vc_ase' ),
				'edit_field_class' => 'vc_col-sm-3',
			),

			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Fade images', 'vc_ase' ),
				'param_name'       => 'fade_images',
				'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'description'      => __( 'Use fading images instead of sliding', 'vc_ase' ),
				'edit_field_class' => 'vc_col-sm-3',
			),

			array(
				'type'             => 'dropdown',
				'class'            => '',
				'heading'          => __( 'Thumbnails format', 'vc_ase' ),
				'param_name'       => 'thumbs_format',
				'value'            => apply_filters( 'vc_ase_image_sizes', '' ),
				'std'              => 'thumbnail',
				'description'      => '',
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'             => 'checkbox',
				'class'            => '',
				'heading'          => __( 'Hide thumbnails navigation ?', 'vc_ase' ),
				'param_name'       => 'hide_thumbs',
				'value'            => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'description'      => '',
				'edit_field_class' => 'vc_col-sm-3',
			),

			array(
				'type'             => 'textfield',
				'class'            => '',
				'heading'          => __( 'Additional CSS classes', 'vc_ase' ),
				'param_name'       => 'css_classes',
				'value'            => '',
				'description'      => __( 'add your custom css classes', 'vc_ase' ),
				'edit_field_class' => 'vc_col-sm-12',
			),
		);

	$params_array = array_merge( apply_filters( 'head_param_array', '' ), $main_array, $prod_cats_array, $portfolio_cats_array, $main_array_2 );

	vc_map(
		array(
			'name'        => __( 'Slick slider', 'vc_ase' ),
			'base'        => 'as_slick_slider',
			'class'       => '',
			'weight'      => 1,
			'icon'        => 'as_slick_slider',
			'category'    => __( 'VC Aligator Studio Elements', 'vc_ase' ),
			'description' => __( 'special slider for posts, portfolios', 'vc_ase' ),
			//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
			//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
			'params'      => $params_array, // end params array
		) // end array vc_map()
	); // end vc_map()

}
add_action( 'init', 'vc_ase_map_as_slick_slider' );
