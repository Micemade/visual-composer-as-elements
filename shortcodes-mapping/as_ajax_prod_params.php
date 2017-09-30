<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function ajax_prod_array(){
	
	$elm_array = array(
				
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Viewport enter animation",'vc_ase'),
			"param_name" => "enter_anim",
			"std"	=> "none",
			"value" => apply_filters('as_vce_anim_array','enter_animation'),
			"description" => "",
			"edit_field_class"=> "vc_col-sm-12"
		),
					
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_3",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Product categories",'vc_ase'),
			"param_name" => "product_cats",
			"value" => apply_filters('as_vce_terms', 'product_cat' ),
			"description" => __('select one or multiple product categories (if none, it will display all)','vc_ase'),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Product categories menu settings",'vc_ase'),
			"param_name" => "sep_3_1",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Product categories menu",'vc_ase'),
			"param_name" => "prod_cat_menu",
			"value" => array(
				'None'					=> 'none',
				'With category images'	=> 'images',
				'Without category images'=> 'no_images',
				),
			"std"	=> "none",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Menu items in a row",'vc_ase'),
			"param_name" => "menu_columns",
			"value" => array(
				'Auto float'	=> 'auto',
				'1'				=> '1',
				'2'				=> '2',
				'3'				=> '3',
				'4'				=> '4',
				'6'				=> '6',
				'Auto stretch'	=> 'stretch',
				),
			"std"	=> "auto",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Menu alignment",'vc_ase'),
			"param_name" => "tax_menu_align",
			"value" => array(
				'Center'		=> 'center',
				'Align left'	=> 'align_left',
				'Align right'	=> 'align_right',
				),
			"std"	=> "center",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),

		
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Product categories menu colors",'vc_ase'),
			"param_name" => "sep_4",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Text color",'vc_ase'),
			"param_name" => "text_color",
			"value" => '',
			"description" => __("If categories images - choose color for text",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Overlay color",'vc_ase'),
			"param_name" => "overlay_color",
			"value" => '', 
			"description" => __("If categories images - choose color for image overlay",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Overlay opacity",'vc_ase'),
			"param_name" => "overlay_opacity",
			"value" => 0,
			"description" => 'set category image overlay opacity, from 0 - 100 (only number)',
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Overlay opacity on hover",'vc_ase'),
			"param_name" => "overlay_opacity_hover",
			"value" => 70,
			"description" => 'set category image overlay opacity when mouse hovers image, from 0 - 100 (only number)',
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Image settings",'vc_ase'),
			"description" => __("list of registered image sizes. WARNING: in case of theme switch some sizes will be removed.",'vc_ase'),
			"param_name" => "sep_4",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Image format",'vc_ase'),
			"param_name" => "img_format",
			"value" => apply_filters('vc_ase_image_sizes',''),
			"description" => __("select image format for element items.",'vc_ase'),
			"std"	=> "thumbnail",
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Quick view image format",'vc_ase'),
			"param_name" => "qv_img_format",
			"value" => apply_filters('vc_ase_image_sizes',''),
			"description" => __("select image format for popup \"Quick view\" window.",'vc_ase'),
			"std"	=> "thumbnail",
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Animations settings for items",'vc_ase'),
			"param_name" => "sep_7",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Hover image animation",'vc_ase'),
			"param_name" => "anim",
			"value" => apply_filters('as_vce_anim_array','hover_animation'),
			"std"	=> "none",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-12"
		),

		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Products settings",'vc_ase'),
			"param_name" => "sep_8",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show \"Quick view\" ?",'vc_ase'),
			"param_name" => "shop_quick",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => '',
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show \"Add to cart/Select options\" button ?",'vc_ase'),
			"param_name" => "shop_buy_action",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => '',
			"edit_field_class"=> "vc_col-sm-4"
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show \"Add to wishlist\" button ?",'vc_ase'),
			"param_name" => "shop_wishlist",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('Yith WooCommerce Wishlist plugin must be installed','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		

		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_8_2",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Special filters",'vc_ase'),
			"param_name" => "filters",
			"value" => array(
				'Latest products'		=> 'latest',
				'Featured products'		=> 'featured' ,
				'Best selling products'	=> 'best_sellers',
				'Best rated products'	=> 'best_rated',
				'Products on sale'		=> 'on_sale',
				'Random products'		=> 'random'
				),
			"std"	=> "latest",
			"description" => __("make a special selection with these filters",'vc_ase') ,
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => '',
			"param_name" => "sep_9",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Total items",'vc_ase'),
			"param_name" => "total_items",
			"value" => '12',
			"description" => __('If empty, all items will e showed.','vc_ase'),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Disable slider",'vc_ase'),
			"param_name" => "hide_slider",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => '',
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide slider navigation?",'vc_ase'),
			"param_name" => "slider_navig",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('use prev / next arrows','vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide slider pagination?",'vc_ase'),
			"param_name" => "slider_pagin",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('pagination dots bellow the slider','vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Slider timing",'vc_ase'),
			"param_name" => "slider_timing",
			"value" => '',
			"description" => __('If empty, no automatic sliding will happen.','vc_ase'),
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Remove items gutter",'vc_ase'),
			"param_name" => "remove_gutter",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __("remove spaces between items and on element sides, created by grid (applied both to category images and product items )","vc_ase"),
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Responsive slider settings",'vc_ase'),
			"param_name" => "sep_6",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Items in desktop view",'vc_ase'),
			"param_name" => "items_desktop",
			"value" => "3",
			"description" => __("If slider is disabled, this setting convert to \"Items in row\"","vc_ase"),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Items in tablet view",'vc_ase'),
			"param_name" => "items_tablet",
			"value" => "2",
			"description" => __("If slider is disabled, this setting convert to \"Items in row\"","vc_ase"),
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Items in mobile view",'vc_ase'),
			"param_name" => "items_mobile",
			"value" => "1",
			"description" => __("If slider is disabled, this setting convert to \"Items in row\"","vc_ase"),
			"edit_field_class"=> "vc_col-sm-4"
		),
		


		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Additional settings",'vc_ase'),
			"param_name" => "sep_7",
			"value" => '',
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
			"param_name" => "ap_link_button", // ap_ prefix as "Ajax products"
			"value" => "",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),

		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_8",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
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
			"edit_field_class"=> "vc_col-sm-12"
		)
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

add_action( 'vc_before_init', 'vc_ase_map_as_ajax_prod' );
function vc_ase_map_as_ajax_prod() {
	vc_map( array(
		"name" => __("Products (ajax)",'vc_ase'),
		"base" => "as_ajax_prod",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_ajax_prod',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'products via ajax', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), ajax_prod_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
?>