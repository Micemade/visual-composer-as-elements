<?php

/**
 *	AS_VCE_TERMS_FUNC ( as_vce_terms hook )
 *	get terms array for shortcodes settings
 *
 * return array $terms_arr
 */
function as_vce_terms_func( $taxonomy ) {

	if( ! taxonomy_exists( $taxonomy ) ) return;
	
	$terms_arr		= array();
	if( VC_ASE_WPML_ON ) { // IF WPML IS ACTIVATED
				
		$terms = get_terms( $taxonomy,'hide_empty=1, hierarchical=0' );
		if ( !empty( $terms ) ){
			foreach ( $terms as $term ) {
				if($term->term_id == icl_object_id($term->term_id, $taxonomy,false,ICL_LANGUAGE_CODE)){
					$terms_arr[$term->name]= $term->slug ;
				}
			}
		}else{
			$terms_arr = array();
		}
		
	}else{
		
		$terms = get_terms( $taxonomy,'hide_empty=1, hierarchical=0');
		if ( $terms ) {
			foreach ($terms as $term) {
				$terms_arr[$term->name] = $term->slug ;
			}
		}else{
			$terms_arr = array();
		}
	}
	
	return $terms_arr;

}
add_filter('as_vce_terms','as_vce_terms_func', 10, 1);
//
//
/**
 *	GET POSTS ARRAY (by post type)
 *
 */
add_filter("vc_ase_posts_array","vc_ase_posts_array_func", 10, 1);
function vc_ase_posts_array_func( $post_type = "post") {
	
	$args = array(
		'post_type'			=> $post_type,
		'posts_per_page'	=> -1,
		'suppress_filters'	=> true
	);
	$posts_arr	= array();
	$posts_obj	= get_posts($args);
	if ( $posts_obj ) {
		foreach( $posts_obj as $prod ) {
			
			$posts_arr[$prod->ID] = strip_tags( $prod->post_title )  ;
		}
	}else{
		$posts_arr[0] = '';
	}
	
	$posts_arr = array_flip($posts_arr); 
	
	return $posts_arr; 
	
}
 /**
 *	GET MENUS ARRAY FOR SHORTCODES SETTINGS
 *
 */
function vc_ase_get_menus_func( $hide_empty = true ) {

	$menus = get_terms( 'nav_menu', array( 'hide_empty' =>  $hide_empty ) );
	$menu_array = array();
	foreach( $menus as $menu ) {
		$menu_array[$menu->name] = $menu->slug ;
	}
	
	return $menu_array;
	
}
add_filter( 'vc_ase_get_menus','vc_ase_get_menus_func', 10 );
/**
 * VC_ASE_GET_WIDGET_AREAS
 * 
 * 
 * @return <array>
 */

function vc_ase_get_widget_areas( $empty = false ) {
	
	$sidebar_options["Select widget area"] = "select-widget-area";
	foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ){
		$sidebar_options[$sidebar['name']] = $sidebar['id'];
	}
	
	return $sidebar_options;
}
add_filter( 'vc_ase_get_widgets','vc_ase_get_widget_areas', 10 );
/**
 *	Animations for css classes array
 *  var $block_enter_anim_arr - for block viewport entering animation
 */
function as_vce_anim_array_func ( $anim_type ) {
	
	include ( VC_ASE_DIR . 'helpers/data-arrays.php' );
	
	$anim_array = array();
	
	if( $anim_type == 'enter_animation' ) {
		$anim_array = array_flip ( $block_enter_anim_arr );
	}elseif( $anim_type == 'hover_animation' ) {
		$anim_array = array_flip ( $hover_animation );
	}elseif( $anim_type == 'info_animation' ) {
		$anim_array = array_flip ( $info_animation );
	}
	
	return $anim_array;

}
add_filter('as_vce_anim_array','as_vce_anim_array_func',10,1);
/**
 *	Array od styles for Google maps
 *  var $block_enter_anim_arr - for block viewport entering animation
 */
function as_vce_gmap_array_func ( $dummy ) {
	
	include ( VC_ASE_DIR . 'helpers/data-arrays.php' );
	
	return $gmap_styles;

}
add_filter('as_vce_gmap_array','as_vce_gmap_array_func',10,1);

/**
 *	If taxonomies exist:
 */
function as_vce_tax_posts() {
	$is_port_tax	= taxonomy_exists( 'category' );
	return $is_post_tax;
}
function as_vce_tax_products() {
	$is_port_tax	= taxonomy_exists( 'product_cat' );
	return $is_product_tax;
}
function as_vce_tax_portfolio() {
	$is_port_tax	= taxonomy_exists( 'portfolio_category' );
	return $is_port_tax;
}

/**
 *	VC_ASE_IMAGE_SIZES hook
 *	- create array of all registered image sizes
 *	- dependency - function title_it()
 */
add_filter('vc_ase_image_sizes','vc_ase_image_sizes_arr',10,1);
function vc_ase_image_sizes_arr( $size = '' ) {

	global $_wp_additional_image_sizes;

	$sizes = array();
	$intermediate_image_sizes = get_intermediate_image_sizes();
	$additional_image_sizes = array_keys( $_wp_additional_image_sizes );
	
	$sizes_arr = array_merge( $intermediate_image_sizes, $additional_image_sizes, array("full") );
	
	foreach( $sizes_arr as $size ) {
		
		$title = title_it( $size );
		$sizes[ $title ] = $size;
	}

	return $sizes;
}
function title_it( $slug ) {
	
	$title = ucfirst( $slug );
	$title = str_replace("_"," ", $title);
	$title = str_replace("-"," ", $title);
	
	return $title;
}
?>