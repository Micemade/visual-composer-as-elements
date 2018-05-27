<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function filter_prod_array(){
	
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
			"type" => "separator",
			"class" => "",
			"heading" => __("Product categories and categories menu",'vc_ase'),
			"param_name" => "sep_2",
			//"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Product categories",'vc_ase'),
			"param_name" => "product_cats",
			"value" => apply_filters('as_vce_terms', 'product_cat', 'product' ),
			"description" => __('select one or multiple product categories','vc_ase'),
			"admin_label" => true,
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_3",
			//"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Categories menu style",'vc_ase'),
			"param_name" => "tax_menu_style",
			"value" => array(
				'None'		=>'none',				
				'Inline menu'	=> 'inline',
				),
			"std"	=> "none",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),

		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Categories menu alignment",'vc_ase'),
			"param_name" => "tax_menu_align",
			"value" => array(
				'Center'		=> 'center',
				'Align left'	=> 'align_left',
				'Align right'	=> 'align_right',
				),
			"std"	=> "center",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Filters and image settings",'vc_ase'),
			"param_name" => "sep_31",
			//"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Special filters",'vc_ase'),
			"param_name" => "filters",
			"value" => array(
				'Latest products'		=> 'latest',
				'Featured products'		=> 'featured',
				'Best selling products'	=> 'best_sellers',
				'Best rated products'	=> 'best_rated',
				'Products on sale'		=> 'on_sale',
				'Random products'		=> 'random'
				),
			"std"	=> "latest",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Image format",'vc_ase'),
			"param_name" => "img_format",
			"value" => apply_filters('vc_ase_image_sizes',''),
			"std"	=> "none",
			"description" => __("list of registered image sizes. WARNING: in case of theme switch some sizes will be removed.",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Custom image width",'vc_ase'),
			"param_name" => "custom_image_width",
			"value" => '',
			"description" => 'set custom image width - must use height, too. This setting will override "Image format"',
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Custom image height",'vc_ase'),
			"param_name" => "custom_image_height",
			"value" => '',
			"description" => 'set custom image height - must use width, too. This setting will override "Image format"',
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Item buttons and quick view images format",'vc_ase'),
			"param_name" => "sep_4",
			//"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show quick view: ",'vc_ase'),
			"param_name" => "shop_quick",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('show button for quick product view','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show buy button: ",'vc_ase'),
			"param_name" => "shop_buy_action",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('show button for add to cart/select options','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show wishlist button: ",'vc_ase'),
			"param_name" => "shop_wishlist",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('show button for add to wishlist (YITH WC Wishlist plugin must be activated)','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Quick view image format",'vc_ase'),
			"param_name" => "qv_img_format",
			"value" => apply_filters('vc_ase_image_sizes',''),
			"description" => __("select image format for popup \"Quick view\" window.",'vc_ase'),
			"std"	=> "thumbnail",
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Item settings",'vc_ase'),
			"param_name" => "sep_5",
			//"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Total items",'vc_ase'),
			"param_name" => "total_items",
			"value" => '',
			"description" => __('If empty, all items will be displayed.','vc_ase'),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Items in row (desktop)",'vc_ase'),
			"param_name" => "items_desktop",
			"value" => array(
				'1'	=> '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'6' => '6'
				),
			'std' => '3',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Items in row (tablet)",'vc_ase'),
			"param_name" => "items_tablet",
			"value" => array(
				'1'	=> '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'6' => '6'
				),
			'std' => '2',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-3"
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Items in row (mobile)",'vc_ase'),
			"param_name" => "items_mobile",
			"value" => array(
				'1'	=> '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'6' => '6'
				),
			'std' => '1',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-3"
		),

			
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Additional settings",'vc_ase'),
			"param_name" => "sep_5_5",
			//"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Hover image animation",'vc_ase'),
			"param_name" => "anim",
			"value" => apply_filters( 'as_vce_anim_array','hover_animation'),
			"std"	=> "none",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Remove items gutter",'vc_ase'),
			"param_name" => "remove_gutter",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('remove spaces between items and on element sides, created by grid','vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
	
	
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Additional settings",'vc_ase'),
			"param_name" => "sep_6",
			//"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Button label','vc_ase'),
			"param_name" => "button_label",
			"value" => '',
			"description" => __("If this setting is empty, and link is set, link will apply to whole banner.",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "vc_link",
			"class" => "",
			"heading" => __("Add link",'vc_ase'),
			"param_name" => "afp_link_button", // ap_ prefix as "Ajax filter products"
			"value" => "",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			'type' => 'css_editor',
			"heading" => __("Button holder css",'vc_ase'),
			'param_name' => 'btn_css',
			"description" => __('Apply css to button holder element (not button itself)-','vc_ase'),
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Additional CSS classes','vc_ase'),
			"param_name" => "css_classes",
			"value" => '',
			"description" => __('Adds a wrapper div with additional css classes for more styling control','vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		)
	);
	
	return $elm_array;
};

function vc_ase_map_as_filter_prod() {
	vc_map( array(
		"name" => __("Products (masonry/filter)",'vc_ase'),
		"base" => "as_filter_prod",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_filter_prod',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'products filtered by category', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), filter_prod_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_as_filter_prod' );
