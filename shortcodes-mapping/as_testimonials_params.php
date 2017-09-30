<?php
/**
 *	PARAMETERS FOR ELEMENT
 *	array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_testimonials_array(){
	
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
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Testimonial items alignment",'vc_ase'),
			"param_name" => "align",
			"value" =>  array(
				'Align left'	=> 'align_left',
				'Centered'		=> 'center',
				'Align right'	=> 'align_right'
				),
			"std"	=> "align_left",	
			"description" => ""
		),
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_5",
			"value" => '',
			"description" => __("For each testimonial item, add image, add testimonial text and testimonial auhor name, separated by new line",'vc_ase'),
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "attach_images",
			"heading" => __("Testimonial author images", 'vc_ase'),
			"param_name" => "images",
			"value" => "",
			"description" => __("Select images from media library.", 'vc_ase'),
			"edit_field_class"=> "vc_col-sm-8"
		 ),
		 array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Image style",'vc_ase'),
			"param_name" => "image_style",
			"value" => array(
				'Square'=> 'square',
				'Round' => 'round',
				'Diamond' => 'diamond'
			),
			"std"	=> "square",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "exploded_textarea",
			"heading" => __("Testimonial author name", 'vc_ase'),
			"param_name" => "authors",
			"value" => __("Annette Begin,Humphrey Bogota,David Letterson", 'vc_ase'),
			"description" => __("Use new line (press Enter) for each author", 'vc_ase'),
			"admin_label" => true,
		),
		array(
			"type" => "textarea_html",
			"heading" => __("Testimonial text", 'vc_ase'),
			"param_name" => "content",
			"value" => "Testimonial text one - this is the best place to input your testimonial. Don't use any other.\n\nTestimonial text two - this is the best place to input your testimonial. Don't use any other.\n\nTestimonial text three - this is the best place to input your testimonial. Don't use any other.",
			"description" => __("Use new line (press Enter) for each testimonial text", 'vc_ase')
		),
		
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Testimonial text color",'vc_ase'),
			"param_name" => "text_color",
			"value" => '',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Testimonial author color",'vc_ase'),
			"param_name" => "author_color",
			"value" => '#999',
			"description" => "",
			"edit_field_class"=> "vc_col-sm-6"
		),
		
		
		array(
			"type" => "separator",
			"class" => "",
			"heading" => "",
			"param_name" => "sep_6",
			"value" => '',
			"edit_field_class"=> "vc_col-sm-12"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide slider navigation?",'vc_ase'),
			"param_name" => "slider_navig",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('use prev / next arrows','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide slider pagination?",'vc_ase'),
			"param_name" => "slider_pagin",
			"value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			"description" => __('pagination dots bellow the slider','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Slider timing",'vc_ase'),
			"param_name" => "slider_timing",
			"value" => '',
			"description" => __('If empty, no automatic sliding will happen.','vc_ase'),
			"edit_field_class"=> "vc_col-sm-4"
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
			"value" => "1",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Items in tablet view",'vc_ase'),
			"param_name" => "items_tablet",
			"value" => "1",
			"description" => "",
			"edit_field_class"=> "vc_col-sm-4"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Items in mobile view",'vc_ase'),
			"param_name" => "items_mobile",
			"value" => "1",
			"description" => "",
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
			"type" => "textfield",
			"class" => "",
			"heading" => __('Additional CSS classes','vc_ase'),
			"param_name" => "css_classes",
			"value" => '',
			"description" => __('Adds a wrapper div with additional css classes for more styling control','vc_ase'),
			"edit_field_class"=> "vc_col-sm-12"
		)
			
	);
	
	return $elm_array;
};
add_action( 'vc_before_init', 'vc_ase_map_as_testimonials' );
function vc_ase_map_as_testimonials() {
	vc_map( array(
		"name" => __("Testimonials",'vc_ase'),
		"base" => "as_testimonials",
		"class" => "",
		"weight"=> 1,
		'icon' =>'as_testimonials',
		"category" => __('VC Aligator Studio Elements','vc_ase'),
		'description' => __( 'testimonials with slider', 'vc_ase' ),
		//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
		"params" => array_merge( apply_filters("head_param_array",""), as_testimonials_array() )
		
		) // end array vc_map()
	); // end vc_map()
}
?>