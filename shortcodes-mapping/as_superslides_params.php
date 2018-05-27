<?php
function vc_ase_map_as_superslides() {

	// Product categories params.
	$product_params   = array();
	$product_cats_arr = apply_filters( 'as_vce_terms', 'product_cat' );
	if ( ! empty( $product_cats_arr ) ) {

		$product_params = array(
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Product categories",'vc_ase'),
				"param_name" => "product_cats",
				"value" => $product_cats_arr,
				"description" => __('select one or multiple, "Post types" must be set to "Products"','vc_ase'),
				"admin_label" => true,
				"edit_field_class"=> "vc_col-sm-4"
				//"weight" => 1
			)
		);
	}
	// Portfolio categories params.
	$portfolio_params   = array();
	$portfolio_cats_arr = apply_filters( 'as_vce_terms', 'portfolio_category', 'portfolio' );
	if ( ! empty( $portfolio_cats_arr ) ) {

		$portfolio_params = array(
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Portfolio categories",'vc_ase'),
				"param_name" => "portfolio_cats",
				"value" => $portfolio_cats_arr,
				"description" => __('select one or multiple, "Post types" must be set to "Portfolio categories"','vc_ase'),
				"admin_label" => true,
				"edit_field_class"=> "vc_col-sm-4"
				//"weight" => 2 
			)
		);
	}

	$main_array = array(

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Stretched of fixed",'vc_ase'),
				"param_name" => "abs_stretched",
				"value" => array(
					'Fixed'		=> 'fixed',
					'Stretch'	=> 'stretched',
					),
				"std"	=> "fixed",
				"description" => __("- If <strong>\"Stretch\"</strong>, the slider will resize (width and height) with other elements in row.<strong><br>NOTE:<br>- Row settings must have checked \"Equalize row columns\" (Theme row settings tab)<br>- If set to \"Stretched\" the \"Set slides height\" will be overriden<br>- Use \"Stretched\" only with other elements in row. </strong>",'vc_ase'),
				"admin_label" => true,
				"edit_field_class"=> "vc_col-sm-12"
			),

			array(
				"type" => "separator",
				"class" => "",
				"heading" => __("Post type and categories",'vc_ase'),
				"param_name" => "sep_1",
				"value" => '',
				"edit_field_class"=> "vc_col-sm-12"
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Post type or images",'vc_ase'),
				"param_name" => "post_type",
				"value" => array(
					'Post'		=> 'post',
					'Portfolio'	=> 'portfolio',
					'Product'	=> 'product',
					'Images'	=> 'images'
					),
				"std"	=> "post",
				"description" => __("Display post, products, portfolio or selection of images from media library",'vc_ase'),
				"admin_label" => true,
				"edit_field_class"=> "vc_col-sm-12"
			),
			array(
				"type" => "attach_images",
				"heading" => __("Slide images", 'vc_ase'),
				"param_name" => "images",
				"value" => "",
				"description" => __("Select images from media library images for slide. Must have selected \"Images\" from option above", 'vc_ase'),
				"edit_field_class"=> "vc_col-sm-12"
			),

		);

		$main_array_2 = array(
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Blog post categories",'vc_ase'),
				"param_name" => "post_cats",
				"value" => apply_filters('as_vce_terms', 'category', 'post' ),
				"description" => __('select one or multiple, "Post types" must be set to "Post"','vc_ase'),
				"edit_field_class"=> "vc_col-sm-4"
				//"weight" => 100 
			),

			array(
				"type" => "separator",
				"class" => "",
				"heading" => __("Image settings and filtering",'vc_ase'),
				"param_name" => "sep_2",
				"value" => '',
				"edit_field_class"=> "vc_col-sm-12"
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Image format",'vc_ase'),
				"param_name" => "img_format",
				"value" => apply_filters('vc_ase_image_sizes',''),
				"std"	=> "thumbnail",
				"description" => __("list of registered image sizes. WARNING: in case of theme switch some sizes will be removed.",'vc_ase'),
				"admin_label" => true,
				"edit_field_class"=> "vc_col-sm-4"
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Special filters",'vc_ase'),
				"param_name" => "filters",
				"value" => array(
					'Latest'		=> 'latest',
					'Featured'		=> 'featured',
					'Random'		=> 'random',
					'Best selling (only WC products)'	=> 'best_sellers',
					'Best rated (only WC products)'	=> 'best_rated'
					),
				"std"	=> "latest",
				"description" => "",
				"edit_field_class"=> "vc_col-sm-4"
			),
			
			array(
				"type" => "separator",
				"class" => "",
				"heading" => __("Style and effects settings",'vc_ase'),
				"param_name" => "sep_3",
				"value" => '',
				"edit_field_class"=> "vc_col-sm-12"
			),
			
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Text layer style",'vc_ase'),
				"param_name" => "text_layer_style",
				"value" => array(
					'Light'		=> 'light',
					'Dark'		=> 'dark',
					),
				"std"	=> "light",
				"description" => __("Light style has white gradient background with dark text, dark style has dark gradient background with white text","vc_ase"),
				"edit_field_class"=> "vc_col-sm-12"
			),

			
			array(
				"type" => "separator",
				"class" => "",
				"heading" => __("Slider settings",'vc_ase'),
				"param_name" => "sep_4",
				"value" => '',
				"edit_field_class"=> "vc_col-sm-12"
			),
			
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Total items (slides)",'vc_ase'),
				"param_name" => "total_items",
				"value" => '8',
				"description" => __("how many items will scroll in slick scroller ?",'vc_ase'),
				"admin_label" => true,
				"edit_field_class"=> "vc_col-sm-4"
			),
			
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show navigation arrows ?",'vc_ase'),
				"param_name" => "slider_navig",
				"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				"description" => '',
				"edit_field_class"=> "vc_col-sm-4"
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show navigation dots ?",'vc_ase'),
				"param_name" => "slider_pagin",
				"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				"description" => '',
				"edit_field_class"=> "vc_col-sm-4"
			),
			array(
				"type" => "separator",
				"class" => "",
				"heading" => "",
				"param_name" => "sep_4_1",
				"value" => '',
				"edit_field_class"=> "vc_col-sm-12"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Slider timing",'vc_ase'),
				"param_name" => "slider_auto",
				"value" => '',
				"description" => __('type in the timing for auto sliding items. If left blank no auto sliding will occur.','vc_ase'),
				"edit_field_class"=> "vc_col-sm-3"
			),
			
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Fade images",'vc_ase'),
				"param_name" => "fade_images",
				"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				"description" => __("Use fading images instead of sliding",'vc_ase'),
				"edit_field_class"=> "vc_col-sm-3"
			),
			
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Use KenBurns effect ?",'vc_ase'),
				"param_name" => "kenburns",
				"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				"description" => __("KenBurns effect is slowly zooming and panning image",'vc_ase'),
				"edit_field_class"=> "vc_col-sm-3"
			),
			
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Set slides height",'vc_ase'),
				"param_name" => "set_height",
				"value" => '',
				"description" => __('Will add responsiveness to slides.<br>Enter the value <strong>AND</strong> units (<strong>px</strong>, <strong>pt</strong>,<strong> em</strong> or <strong>rem</strong>)','vc_ase'),
				"edit_field_class"=> "vc_col-sm-3"
			),

			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Additional CSS classes",'vc_ase'),
				"param_name" => "css_classes",
				"value" => '',
				"description" => __("add your custom css classes",'vc_ase'),
				"edit_field_class"=> "vc_col-sm-12"
			)
		);
	
	$params_array = array_merge( apply_filters("head_param_array",""), $main_array, $product_params, $portfolio_params ,$main_array_2 );
	
	vc_map( array(
		"name" => __("Superslides",'vc_ase'),
		"base" => "as_superslides",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_superslides',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'adaptive slider for posts, products', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => $params_array // end params array
		) // end array vc_map()
	); // end vc_map()

}
add_action( 'init', 'vc_ase_map_as_superslides', 20 );
