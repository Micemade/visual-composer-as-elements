<?php
/**
 *  PARAMETERS FOR ELEMENT
 *  array_merge with apply_filters("head_param_array","") in vc_map() function bellow
 *
 */
function as_social_array() {

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
			'type'             => 'separator',
			'class'            => '',
			'heading'          => __( 'Enter social links', 'vc_ase' ),
			'param_name'       => 'sep_1',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-12',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Facebook', 'vc_ase' ),
			'param_name'       => 'facebook',
			'value'            => '',
			'description'      => __( 'add link to your Facebook profile/page/group', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Twitter', 'vc_ase' ),
			'param_name'       => 'twitter',
			'value'            => '',
			'description'      => __( 'add link to your Twitter account', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Instagram', 'vc_ase' ),
			'param_name'       => 'instagram',
			'value'            => '',
			'description'      => __( 'add link to your Instagram account', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'LinkedIn', 'vc_ase' ),
			'param_name'       => 'linkedin',
			'value'            => '',
			'description'      => __( 'add link to your LinkedIn account', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Google +', 'vc_ase' ),
			'param_name'       => 'gplus',
			'value'            => '',
			'description'      => __( 'add link to your Google plus account', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Pinterest', 'vc_ase' ),
			'param_name'       => 'pinterest',
			'value'            => '',
			'description'      => __( 'add link to your Pinterest account', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Tubmlr', 'vc_ase' ),
			'param_name'       => 'tumblr',
			'value'            => '',
			'description'      => __( 'add link to your Tumblr page', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Dribbble', 'vc_ase' ),
			'param_name'       => 'dribbble',
			'value'            => '',
			'description'      => __( 'add link to your Dribbble account', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
		),

		array(
			'type'             => 'textfield',
			'class'            => '',
			'heading'          => __( 'Skype', 'vc_ase' ),
			'param_name'       => 'skype',
			'value'            => '',
			'description'      => __( 'add your Skype contact', 'vc_ase' ),
			'edit_field_class' => 'vc_col-sm-4',
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
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Social icons size', 'vc_ase' ),
			'param_name'       => 'size',
			'value'            => array(
				'Default (large)' => 'default',
				'Smaller'         => 'smaller',
			),
			'std'              => 'default',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
			'admin_label'      => true,
		),

		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Social icons align', 'vc_ase' ),
			'param_name'       => 'align',
			'value'            => array(
				'Center' => 'center',
				'Left'   => 'left',
				'Right'  => 'right',
			),
			'std'              => 'center',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => __( 'Social icons in row', 'vc_ase' ),
			'param_name'       => 'items',
			'value'            => array(
				'Stretched'     => 'stretched',
				'not-stretched' => 'not-stretched',
			),
			'std'              => 'stretched',
			'description'      => '',
			'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type'             => 'separator',
			'class'            => '',
			'heading'          => '',
			'param_name'       => 'sep_3',
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
		array(
			'type'       => 'css_editor',
			'heading'    => __( 'Css', 'vc_ase' ),
			'param_name' => 'css',
			'group'      => __( 'Design options', 'vc_ase' ),
		),
	);

	return $elm_array;
};

function vc_ase_map_as_social() {
	vc_map(
		array(
			'name'        => __( 'Social links', 'vc_ase' ),
			'base'        => 'as_social',
			'class'       => '',
			'weight'      => 1,
			'icon'        => 'as_social',
			'category'    => __( 'VC Aligator Studio Elements', 'vc_ase' ),
			'description' => __( 'social buttons with links', 'vc_ase' ),
			//'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ).'/vc_extend/bartag.js'),
			//'admin_enqueue_css' => array( plugin_dir_url( __FILE__ ).'/as_vc_extend/shotcodes/css/input.css'),
			'params'      => array_merge( apply_filters( 'head_param_array', '' ), as_social_array() ),

		) // end array vc_map()
	); // end vc_map()
}
add_action( 'init', 'vc_ase_map_as_social' );

