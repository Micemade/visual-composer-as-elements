<?php
/**
 *  SIMPLE LIST OF ALL IMAGE SIZES
 *
 *  @args   string $size
 *  @return array $sizes
 *
 */
function vc_ase_image_sizes_list_func( $size = '' ) {

	global $_wp_additional_image_sizes;

	$sizes                    = array();
	$intermediate_image_sizes = get_intermediate_image_sizes();
	$additional_image_sizes   = array_keys( $_wp_additional_image_sizes );

	$sizes = array_merge( $intermediate_image_sizes, $additional_image_sizes, array( 'full' ) );

	return $sizes;
}
add_filter( 'vc_ase_image_sizes_list', 'vc_ase_image_sizes_list_func', 10, 1 );
/**
 *  GET REGISTERED IMAGE SIZES WITH WIDTH / HEIGHT
 *
 *  @return array $sizes
 *
 *  @details Details
 */
function vc_ase_get_image_sizes_func( $size = '' ) {

	global $_wp_additional_image_sizes;

	$sizes                        = array();
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach ( $get_intermediate_image_sizes as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$sizes[ $_size ]['width']  = get_option( $_size . '_size_w' );
			$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
			$sizes[ $_size ]['crop']   = (bool) get_option( $_size . '_crop' );

		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);

		}
	}
	// Get only 1 size if found
	if ( $size ) {
		if ( isset( $sizes[ $size ] ) ) {
			return $sizes[ $size ];
		} else {
			return false;
		}
	}

	return $sizes;
}
add_filter( 'vc_ase_get_image_sizes', 'vc_ase_get_image_sizes_func', 10, 1 );

/**
 *  GET ALL IMAGE SIZES.
 *  @hook vc_ase_all_image_sizes
 *  merging WP default image sizes and global $_wp_additional_image_sizes to return all registered image sizes.
 */
function vc_ase_all_image_sizes_func( $default_sizes = array() ) {

	global $_wp_additional_image_sizes;
	$default_sizes = array();

	$default_sizes['thumbnail']['width']  = get_option( 'thumbnail_size_w' );
	$default_sizes['thumbnail']['height'] = get_option( 'thumbnail_size_h' );

	$default_sizes['medium']['width']  = get_option( 'medium_size_w' );
	$default_sizes['medium']['height'] = get_option( 'medium_size_h' );

	$default_sizes['large']['width']  = get_option( 'large_size_w' );
	$default_sizes['large']['height'] = get_option( 'large_size_h' );

	$imgSizes = array_merge( $default_sizes, $_wp_additional_image_sizes );

	return $imgSizes;
}
add_filter( 'vc_ase_all_image_sizes', 'vc_ase_all_image_sizes_func', 10, 1 );



/**
 *  GET FULL SIZE IMAGE URL.
 *
 *  get full size image url for post thumbnail, attachement image, gallery or AS gallery using attachment ID's.
 *
 *  var $get_image_ids - recieve image attachment ID's
 *  var $size - registered image size
 */
function vc_ase_get_full_img_url_func( $get_image_ids = '', $size = 'large', $url_or_id = 'url' ) {

	if ( VC_ASE_WPML_ON ) { // if WMPL is active
		$id = icl_object_id( get_the_ID(), get_post_type(), false, ICL_LANGUAGE_CODE );
	} else {
		$id = get_the_ID(); // post id
	}

	// WP Gallery image ID's
	$wpgall_ids = apply_filters( 'vc_ase_wp_gallery_ids', 'ids_wp_gallery' );
	// AS Gallery image ID's
	$gall_img_array = get_post_meta( get_the_ID(), 'as_gallery_images' );

	$images_ids = $get_image_ids ? $get_image_ids : '';

	if ( ! $get_image_ids ) { // if no img is send

		if ( ! empty( $wpgall_ids ) ) {
			$images_ids = implode( ', ', $wpgall_ids ); // get images from WP gallery
		} elseif ( ! empty( $gall_img_array ) ) {
			$images_ids = implode( ', ', $gall_img_array ); // get images from AS gallery or recieved args
		} else {
			$images_ids = '';
		}
	}

	if ( $images_ids ) {
		// Using WP3.5; use post__in orderby option
		$ids     = explode( ',', $images_ids );
		$id      = null;
		$orderby = 'post__in';
		$include = $ids;
	} else {
		$orderby = 'menu_order';
		$include = '';
	}

	$attached_images = get_posts(
		array(
			'include'        => $include,
			'post_parent'    => $id,
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'orderby'        => $orderby,
			'order'          => 'ASC',
			'post_status'    => null,
			'numberposts'    => 1,
		)
	);

	if ( has_post_thumbnail() && ! $get_image_ids ) {
		$img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $size );
		$img_url = $img_url[0];
		$img_id  = get_post_thumbnail_id( $id );
	} elseif ( count( $attached_images ) ) {
		$attached_image = $attached_images[0];
		$img_url        = wp_get_attachment_image_src( $attached_image->ID, $size );
		$img_url        = $img_url[0];
		$img_id         = $attached_image->ID;
	} else {
		$img_url = VC_ASE_PLACEHOLDER_IMAGE;
		$img_id  = null;
	}
	if ( $url_or_id == 'url' ) {

		return esc_url( $img_url );

	} elseif ( $url_or_id == 'id' ) {

		return esc_attr( $img_id );
	}
}
add_filter( 'vc_ase_get_full_img_url', 'vc_ase_get_full_img_url_func', 10, 3 );
//
/**
 * Action as_wpgallery_ids
 * get id's from WP gallery shortcode
 *
 * @return array $ids
 */

function vc_ase_wp_gallery() {

	global $post;
	$attachment_ids = array();
	$pattern        = get_shortcode_regex();
	$ids            = array();
	//finds the "gallery" shortcode and puts the image ids in an associative array at $matches[3]
	if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches ) ) {
		$count = count( $matches[3] );      //in case there is more than one gallery in the post.
		for ( $i = 0; $i < $count; $i++ ) {
			$atts = shortcode_parse_atts( $matches[3][ $i ] );
			if ( isset( $atts['ids'] ) ) {
				$attachment_ids = explode( ',', $atts['ids'] );
				$ids            = array_merge( $ids, $attachment_ids );
			}
		}
	}
	return $ids;
}
add_filter( 'vc_ase_wp_gallery_ids', 'vc_ase_wp_gallery' );
//
/**
 * GALLERY OUTPUT
 *
 * @param string $postid
 * @param string $images_ids
 * @param string $slider_thumbs
 * @param int    $thumb_columns
 * @param string $thumb_size
 * @param int    $number_posts
 *
 * @return echo string
 */


function vc_ase_gallery_output_func( $postid, $images_ids, $slider_thumbs = 'slider', $thumb_columns = 3, $thumb_size = 'thumbnail', $number_posts = -1 ) {

	global $post;

	$imgSize = apply_filters( 'vc_ase_get_image_sizes', $thumb_size ); // in this file up
	$img_W   = isset( $imgSize['width'] ) ? $imgSize['width'] : 300;
	$img_H   = isset( $imgSize['height'] ) ? $imgSize['height'] : 300;

	if ( $slider_thumbs == 'thumbnails' ) {
		$thumb_class  = $thumb_columns ? ' large-' . floor( 12 / $thumb_columns ) : ' large-4 column';
		$thumb_class .= ' medium-6 small-12 column';
	} else {
		$thumb_class = ' column';
	}

	if ( $images_ids ) {
		// Using WP3.5; use post__in orderby option
		$image_ids = explode( ',', $images_ids );
		$postid    = null;
		$orderby   = 'post__in';
		$include   = $image_ids;
	} else {
		$orderby = 'menu_order';
		$include = '';
	}

	$gallery_images = get_posts(
		array(
			'include'        => $include,
			'post_parent'    => $postid,
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'orderby'        => $orderby,
			'order'          => 'ASC',
			'post_status'    => null,
			'numberposts'    => $number_posts,
		)
	);

	if ( $gallery_images ) {

		if ( VC_ASE_WPML_ON ) { // if WMPL is active
			$pid = icl_object_id( get_the_ID(), get_post_type(), false, ICL_LANGUAGE_CODE );
		} else {
			$pid = get_the_ID();
		}

		$output  = '';
		$output .= '<div id="gallery-' . $pid . '" class="gallery-main gallery-type-' . $slider_thumbs . '">';

		$output .= '<div class="gallery-wrap">';
		// POST META FOR SLIDER CONTROLS:
		if ( $slider_thumbs == 'slider' ) {
			$slider_nav    = get_post_meta( $pid, 'as_slider_nav', true );
			$slider_pagin  = get_post_meta( $pid, 'as_slider_pagin', true );
			$slider_timer  = get_post_meta( $pid, 'as_slider_timer', true );
			$slider_trans  = get_post_meta( $pid, 'as_slider_trans', true );
			$items_desktop = get_post_meta( $pid, 'as_items_desktop', true );
			$items_tablet  = get_post_meta( $pid, 'as_items_tablet', true );
			$items_mobile  = get_post_meta( $pid, 'as_items_mobile', true );

			$s_nav   = isset( $slider_nav ) ? ' data-navigation="' . $slider_nav . '"' : ' data-navigation="0"';
			$s_pag   = isset( $slider_pagin ) ? ' data-pagination="' . $slider_pagin . '"' : ' data-pagination="0"';
			$s_tim   = isset( $slider_timer ) ? ' data-auto="' . $slider_timer . '"' : ' data-auto="0"';
			$s_trans = isset( $slider_trans ) ? ' data-trans="' . $slider_trans . '"' : '';
			$s_trans = ( $slider_trans == 'none' ) ? '' : $s_trans;

			$it_desk   = isset( $items_desktop ) ? ' data-desktop="' . $items_desktop . '"' : ' data-desktop="4"';
			$it_tablet = isset( $items_tablet ) ? ' data-tablet="' . $items_tablet . '"' : ' data-tablet="2"';
			$it_mobile = isset( $items_mobile ) ? ' data-mobile="' . $items_mobile . '"' : ' data-mobile="1"';

			$output .= '<input type="hidden" class="slides-config" ' . $s_nav . $s_pag . $s_tim . $s_trans . $it_desk . $it_tablet . $it_mobile . '  />';
		}

		$output .= ( $slider_thumbs == 'slider' ) ? '<div class="owl-carousel contentslides">' : '';

		$i = 0;

		foreach ( $gallery_images as $image ) :

			$total_images = count( $gallery_images );
			$atts         = array(
				'class' => "attachment-image-$thumb_size",
				'alt'   => the_title_attribute( array( 'echo' => 0 ) ),
				'title' => the_title_attribute( array( 'echo' => 0 ) ),

			);

			$img_url = apply_filters( 'vc_ase_get_full_img_url', $image->ID );

			$thumb = wp_get_attachment_image( $image->ID, $thumb_size, false, $atts );

			$output .= '<div class="item' . $thumb_class . '"><div class="item-img">';

			$output .= '<div class="front">';
			$output .= $thumb;
			$output .= '</div>'; //  .front

			$output .= '<div class="back"><div class="item-overlay"></div>';
			$output .= '<div class="back-buttons"><a data-gal="prettyPhoto[gallery_' . $pid . ']"  href="' . $img_url . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . ' " class="accent-1-light-30" >';
			$output .= '<div class="icon icon-zoom-in" aria-hidden="true"></div></a>';
			$output .= '</div>'; // .back-buttons

			$output .= $thumb; // <---- OUTPUT THE IMAGE

			$output .= '</div>'; // .back

			$output .= '</div></div>';

			$allowed = array(
				'div'   => array(
					'id'         => array(),
					'class'      => array(),
					'aria-hidde' => array(),
				),
				'a'     => array(
					'href'     => array(),
					'class'    => array(),
					'rel'      => array(),
					'data-gal' => array(),
				),
				'input' => array(
					'type'            => array(),
					'class'           => array(),
					'data-navigation' => array(),
					'data-pagination' => array(),
					'data-auto'       => array(),
					'data-trans'      => array(),
					'data-desktop'    => array(),
					'data-tablet'     => array(),
					'data-mobile'     => array(),
				),
				'img'   => array(
					'src'    => array(),
					'class'  => array(),
					'alt'    => array(),
					'title'  => array(),
					'width'  => array(),
					'height' => array(),
				),
			);

			$i++;

		endforeach;

		$output .= ( $slider_thumbs == 'slider' ) ? '</div>' : '';

		$output .= '</div></div>'; // .gallery-main / .gallery-wrap

		echo wp_kses( $output, $allowed );

	}; // $gallery_images
}
add_action( 'vc_ase_gallery_output', 'vc_ase_gallery_output_func', 10, 6 );
//
//
//
/**
 *  VC ASE IMAGE - custom function to retrieve image from posts or custom post types
 *
 *  var $img_format - registered image size
 *  var $img_width - desired image width (to use with image resize script)
 *  var $img_height - desired image size (to use with image resize script)
 */
//
add_filter( 'vc_ase_image', 'vc_ase_image_func', 10, 3 );
function vc_ase_image_func( $img_format = 'thumbnail', $img_width = '', $img_height = '' ) {

	global $post;

	if ( VC_ASE_WPML_ON ) { // if WMPL is active
		$id = icl_object_id( $post->ID, get_post_type(), false, ICL_LANGUAGE_CODE );
	} else {
		$id = $post->ID;
	}

	$title = strip_tags( $post->post_title );
	$atts  = array(
		'class' => "attachment-image-$img_format ",
		'alt'   => esc_attr( $title ),
		'title' => esc_attr( $title ),
	);

	if ( has_post_thumbnail( $id ) ) {

		// if custom (non-registered) image size is used:
		if ( $img_width && $img_height ) {

			//$custom_size = $img_width . 'x' . $img_height; // Deprecated - "Micemade_Custom_Image_Sizes" class in as_vc_init.php
			$slika = wp_get_attachment_image( get_post_thumbnail_id(), array( $img_width, $img_height ) );

		} // else use registered image sizes
		elseif ( $img_format && ( ! $img_width && ! $img_height ) ) {

			$slika = wp_get_attachment_image( get_post_thumbnail_id(), $img_format, false, $atts );

		}
	} // if not post thumbnail:
	else {

		// GET IMAGE
		if ( $img_format == 'full' ) {

			$img_W = 1400;
			$img_H = 1000;

		} elseif ( $img_width && $img_height ) {
			$img_W = $img_width;
			$img_H = $img_height;

		} else {
			$imgSizes = apply_filters( 'vc_ase_all_image_sizes', '' ); // get registered img sizes
			$img_W    = $imgSizes[ $img_format ]['width'];
			$img_H    = $imgSizes[ $img_format ]['height'];
		}

		$slika = '<img src="' . fImg::resize( VC_ASE_PLACEHOLDER_IMAGE, $img_W, $img_H, true ) . '" title="' . $atts['title'] . '" alt="' . $atts['title'] . '" class="' . $atts['class'] . '" />';

	}

	$output = '<div class="entry-image">';
	// finaly - output the image:
	$output .= $slika;
	$output .= '</div>';

	return wp_kses_post( $output );

}//function vc_ase_image_func

//
/**
 *  GET IMAGES BY ATTACHMENT ID.
 *
 *  get images independent of attachment - used for WP gallery
 *  - in "helpers/formats.php"
 */

function vc_ase_get_unattached_image_func( $imageID, $thumb_size = 'thumbnail', $img_width = '', $img_height = '', $caption = '' ) {

	// get image caption for atts
	$unattach_img = get_posts(
		array(
			'p'         => $imageID,
			'post_type' => 'attachment',
		)
	);
	if ( $unattach_img && isset( $unattach_img[0] ) ) {
		$caption = $unattach_img[0]->post_excerpt;
		$alt     = $unattach_img[0]->post_excerpt;
	}
	$atts = array(
		'class' => "attachment-image-$thumb_size ",
		'alt'   => $caption ? $caption : $imageID,
		'title' => $caption ? $caption : $imageID,
	);

	if ( $imageID ) {

		if ( $img_width && $img_height ) { // if custom (non-registered) image size is used:

			//$custom_size = $img_width . 'x' . $img_height; // Deprecated - "Micemade_Custom_Image_Sizes" class in as_vc_init.php
			$slika = wp_get_attachment_image( $imageID, array( $img_width, $img_height ) );

		} elseif ( ! $img_width && ! $img_height ) { // else use registered image sizes

			$slika = wp_get_attachment_image( $imageID, $thumb_size, false, $atts );

		} else {

			$slika = wp_get_attachment_image( get_post_thumbnail_id(), '1400x1000' );

		}
	} else {

		if ( $img_width && $img_height ) {
			$img_W = $img_width;
			$img_H = $img_height;

		} else {
			$imgSizes = apply_filters( 'vc_ase_all_image_sizes', '' ); // get registered img sizes
			$img_W    = $imgSizes[ $thumb_size ]['width'];
			$img_H    = $imgSizes[ $thumb_size ]['height'];
		}

		$slika = '<img src="' . fImg::resize( VC_ASE_PLACEHOLDER_IMAGE, $img_W, $img_H, true ) . '" title="' . $atts['title'] . '" alt="' . $atts['title'] . '" class="' . $atts['class'] . '" />';

	}

	$output = '<div class="entry-image">';
	// show actual image
	$output .= $slika;
	$output .= '<div class="clearfix"></div>';
	$output .= '</div>';

	return wp_kses_post( $output );
}
add_filter( 'vc_ase_get_unattached_image', 'vc_ase_get_unattached_image_func', 10, 5 );
/**
 *  get images independent of attachment - used for WP gallery
 */

