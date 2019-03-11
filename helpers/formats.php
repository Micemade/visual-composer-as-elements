<?php
add_filter( 'vc_ase_post_formats_media', 'vc_ase_post_formats_media_func', 10, 5 );
function vc_ase_post_formats_media_func( $post_id, $block_id = null, $img_format = null, $img_width = null, $img_height = null ) {

	$post_format = get_post_format();

	if ( $post_format == 'gallery' ) { // <------------- GALLERY POST FORMAT

		// IF LARIX THEME IS ACTIVE:
		$theme_custom_meta_prefix = LARIX_THEME_ACTIVE ? 'larix_micemade_' : '';

		// WP gallery img id's:
		$wp_gallery_ids = apply_filters( 'vc_ase_wp_gallery_ids', 'vc_ase_wp_gallery' );

		// Theme gallery img id's ( from custom meta - micemade themes ):
		$theme_gallery_id_array = get_post_meta( get_the_ID(), $theme_custom_meta_prefix . 'gallery_images' );

		$img_urls_gallery = '';
		$n                = 0;

		if ( ! empty( $wp_gallery_ids ) ) {

			foreach ( $wp_gallery_ids as $wpgall_img_id ) {

				if ( $n == 0 ) {
					$img_url = apply_filters( 'vc_ase_get_full_img_url', $wpgall_img_id );
				} else {
					$img_urls_gallery .= '<a href="' . apply_filters( 'vc_ase_get_full_img_url', $wpgall_img_id ) . '" class="invisible-gallery-urls" data-gal="prettyPhoto[pp_gal-' . $post_id . '-' . $block_id . ']"></a>';
				}
				$n++;
			}

			$feat_gall_image_id = $wp_gallery_ids[0];

		} elseif ( ! empty( $theme_gallery_id_array ) && $theme_custom_meta_prefix ) {

			foreach ( $theme_gallery_id_array as $gall_img_id ) {

				if ( $n == 0 ) {
					$img_url = apply_filters( 'vc_ase_get_full_img_url', $gall_img_id );
				} else {
					$img_urls_gallery .= '<a href="' . apply_filters( 'vc_ase_get_full_img_url', $gall_img_id ) . '" class="invisible-gallery-urls" data-gal="prettyPhoto[pp_gal-' . $post_id . '-' . $block_id . ']"></a>';
				}
				$n++;

			}

			$feat_gall_image_id = $theme_gallery_id_array[0];
		}

		// IF POST THUMBNAIL IS SET:
		if ( has_post_thumbnail() ) {
			$image_output = apply_filters( 'vc_ase_image', $img_format, $img_width, $img_height );
		} else {
			// IF NO POST THUMB, TAKE FIRST IMAGE FROM GALLERY
			$image_output = apply_filters( 'vc_ase_get_unattached_image', $feat_gall_image_id, $img_format, $img_width, $img_height );
		}

		$pP_rel     = '[pp_gal-' . $post_id . '-' . $block_id . ']';
		$quote_html = '';

	} else { // <---------------- STANDARD ( and every other, BUT the gallery ) POST FORMAT

		$img_url          = apply_filters( 'vc_ase_get_full_img_url', '' );
		$image_output     = apply_filters( 'vc_ase_image', $img_format, $img_width, $img_height );
		$pP_rel           = '';
		$img_urls_gallery = ''; // avoid duplicate gallery image urls
		$quote_html       = '';
	}

	$func_output                     = array();
	$func_output['img_url']          = $img_url;
	$func_output['image_output']     = $image_output;
	$func_output['pP_rel']           = $pP_rel;
	$func_output['img_urls_gallery'] = $img_urls_gallery;
	$func_output['quote_html']       = $quote_html;

	return $func_output;
}

