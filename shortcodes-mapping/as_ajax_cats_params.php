<?php
function ajax_cats_array(){
	$elm_array = array(

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Viewport enter animation",'vc_ase'),
			"param_name" => "enter_anim",
			"value" => apply_filters( 'as_vce_anim_array','enter_animation'),
			"std"	=> "none",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Block style",'vc_ase'),
			"param_name" => "block_style",
			"value" => array(
				'Style 1 (blog posts)'		=> 'style1',
				'Style 2 (blog posts alt)'	=> 'style2',
				'Style 3 (portfolio)'		=> 'style3',
				'Style 4 (portfolio)'		=> 'style4',
				),
			"std"	=> "style1",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Block style color",'vc_ase'),
			"param_name" => "block_style_color",
			"value" => array(
				'Light'				=> 'light',
				'Dark'				=> 'dark',
				'Light expanded'	=> 'light_expanded',
				'Dark expanded'		=> 'dark_expanded',
				),
			"std"	=> "light",
			"description" => __("<strong>Applies only to  Style 3 and Style 4.</strong> Light: white gradient background with dark text; Dark : dark gradient background with white text. Expanded: expand color overlay to item image edges.","vc_ase"),
			"edit_field_class"=> "vc_col-sm-12"
		),		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => '',
			"param_name" => "sep_3",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),

		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Post types and categories",'vc_ase'),
			"param_name" => "sep_3",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Post types",'vc_ase'),
			"param_name" => "post_type",
			"value" => array(
				'Post'=> 'post',
				'Portfolio' => 'portfolio',
				'Product' => 'product'
				),
			"std"	=> "post",
			"description" => "",
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-4"
			
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Taxonomy menu style",'vc_ase'),
			"param_name" => "tax_menu_style",
			"value" => array(
				'None'			=> 'none', 
				'Inline menu'	=> 'inline',
				
				),
			"std"	=> "none",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Taxonomy menu alignment",'vc_ase'),
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
			"heading" => '',
			"param_name" => "sep_4",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Post categories",'vc_ase'),
			"param_name" => "post_cats",
			"value" => apply_filters('as_vce_terms', 'category', 'post' ),
			"description" => __('select one or multiple, "Post types" must be set to "Post"','vc_ase'),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-4"
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Portfolio  categories",'vc_ase'),
			"param_name" => "portfolio_cats",
			"value" => apply_filters('as_vce_terms', 'portfolio_category', 'portfolio' ),
			"description" => __('select one or multiple, "Post types" must be set to "Portfolio"','vc_ase'),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Product  categories",'vc_ase'),
			"param_name" => "product_cats",
			"value" => apply_filters('as_vce_terms', 'product_cat', 'product' ),
			"description" => __('select one or multiple, "Post types" must be set to "Portfolio"','vc_ase'),
			"admin_label" => true,
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Image settings",'vc_ase'),
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
			"std"	=> "thumbnail",
			"description" => __("list of registered image sizes. WARNING: in case of theme switch some sizes will be removed.",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Custom image width",'vc_ase'),
			"param_name" => "custom_image_width",
			"value" => '',
			"description" => 'set custom image width - must use height, too. This setting will override "Image format"',
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Custom image height",'vc_ase'),
			"param_name" => "custom_image_height",
			"value" => '',
			"description" => 'set custom image height - must use width, too. This setting will override "Image format"',
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => '',
			"param_name" => "sep_6",
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
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Offset",'vc_ase'),
			"param_name" => "offset",
			"value" => '',
			"description" => __('if offset is 3, posts list will start with 3rd post (first 2 are skipped)','vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("No post thumbnail",'vc_ase'),
			"param_name" => "no_post_thumb",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('Display only item title and excerpt (simple posts list).','vc_ase'),
			"edit_field_class"=> "vc_col-sm-3"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show only featured ?",'vc_ase'),
			"param_name" => "only_featured",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('show only featured posts or portfolio items','vc_ase'),
			"edit_field_class"=> "vc_col-sm-3",
		),
		array(
			"type" => "separator",
			"class" => "",
			"heading" => '',
			"param_name" => "sep_6_2",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
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
			"heading" => __("Disable masonry",'vc_ase'),
			"param_name" => "no_masonry",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('if slider is disabled, mansory is automatically on.','vc_ase'),
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
			"edit_field_class"=> "vc_col-sm-12"
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
			"heading" => '',
			"param_name" => "sep_8",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide zoom button?",'vc_ase'),
			"param_name" => "zoom_button",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('display button for zooming image (not applied to "style3" and "style4")','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide link button ?",'vc_ase'),
			"param_name" => "link_button",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('display button with link to post/portfolio item (not applied to "style3" and "style4")','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Remove items gutter",'vc_ase'),
			"param_name" => "remove_gutter",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __("remove spaces between items and on element sides, created by grid","vc_ase"),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => __("Animations settings for items",'vc_ase'),
			"param_name" => "sep_6",
			"value" => '',
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
			"param_name" => "ac_link_button", //ap_ prefix as "Ajax content"
			"value" => "",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),

		array(
			'type' => 'css_editor',
			"heading" => __("Button holder css",'vc_ase'),
			'param_name' => 'btn_css',
			"description" => __('Apply css to button wrapper element (not button itself)','vc_ase'),
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
		
		
		
		/* Textarea_html must have param_name "content"
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
}

function vc_ase_map_as_ajax_cats() {
	vc_map( array(
			"name" => __("Content (ajax)",'vc_ase'),
			"base" => "as_ajax_cats",
			"class" => "",
			"weight"=> 1,
			'icon' =>'as_ajax_cats',
			"category" => __('VC Aligator Studio Elements','vc_ase'),
			'description' => __( 'posts (or portfolio) via ajax', 'vc_ase' ),
			//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
			//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
			"params" => array_merge( apply_filters("head_param_array",""), ajax_cats_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_as_ajax_cats' );
