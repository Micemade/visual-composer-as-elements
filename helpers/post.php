<?php
/**
 * AS ARCHIVE CONTENT
 * - used for content display on archive pages (taxonomies)
 *
 * @return string html content
 */
function vc_ase_archive_content_func() {
	global $post;

	if ( ! post_password_required() ) {

		if ( strpos( $post->post_content, '<!--more-->' ) ) {
			$readmore = '<a class="button small readmore" href="' . get_permalink( get_the_ID() ) . '">' . esc_html( __( 'Read More', 'vc_ase' ) ) . ' <span class="more-icon icon-arrow-right2"></span></a>';
			the_content( $readmore );
		} else {
			the_excerpt();
		}
	} else {
		echo '<p>' . esc_html__( 'This post is password protected', 'vc_ase' ) . '</p>';
	}

}
add_action( 'vc_ase_archive_content', 'vc_ase_archive_content_func', 10 );

/**
 *  NATIVE EXCERPT LENGTH
 */
function vc_ase_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'vc_ase_custom_excerpt_length', 999 );

/**
 *  AS CUSTOM EXCERPT LENGTH
 *
 *  @param int $chars - length of excerpt in characters
 *  @param boolean $has_readmore - if has "Read more" button
 */
function vc_ase_custom_excerpt_func( $chars = 150, $has_readmore = true ) {

	global $post;
	$ellipsis = false;
	$text     = get_the_content();
	$readmore = '<br /><a href="' . get_permalink() . '" class="tiny button">' . esc_html( 'Read more', 'vc_ase' ) . '<span class="more-icon icon-arrow-right2"></span></a>';
	$text     = $text . ' ';
	$text     = strip_tags( $text );
	$text     = strip_shortcodes( $text );  //strip_shortcodes - WP core function (WP Codex)

	if ( $chars != 'full' ) {
		if ( strlen( $text ) > $chars ) {
			$ellipsis = true;
		}
		$text = substr( $text, 0, $chars );
		$text = substr( $text, 0, strrpos( $text, ' ' ) );
		if ( $ellipsis == true ) {
			$text = $text . '... ' . ( $has_readmore ? $readmore : '' );
		}
	}
	return $text;
}
add_filter( 'vc_ase_custom_excerpt', 'vc_ase_custom_excerpt_func', 10, 2 );
//
/**
 *  MENU EXCERPT
 *
 *  @param string $text
 *  @param int $chars - length of excerpt in characters
 */
function vc_ase_menu_excerpt_func( $text, $chars = 150 ) {

	$ellipsis = false;
	$text     = $text . ' ';
	$text     = strip_tags( $text );
	$text     = strip_shortcodes( $text );  //strip_shortcodes - WP core function (WP Codex)

	if ( $chars != 'full' ) {
		if ( strlen( $text ) > $chars ) {
			$ellipsis = true;
		}
		$text = substr( $text, 0, $chars );
		$text = substr( $text, 0, strrpos( $text, ' ' ) );
		if ( $ellipsis == true ) {
			$text = $text . '...';
		}
	}
	return $text;
}
add_filter( 'vc_ase_menu_excerpt', 'vc_ase_menu_excerpt_func', 10, 2 );
//
//
/**
 *  POST FORMAT ICON function.
 *
 *  create icons using icon font using class html attribute.
 *
 */

function vc_ase_post_format_icon_func( $empty = '' ) {
	global $post;
	$id          = get_the_ID();
	$post_type   = get_post_type( $id );
	$post_format = get_post_format( $id );

	if ( $post_type == 'product' ) {

		$icon_class = 'fa fa-shopping-cart';

	} elseif ( $post_format == 'video' ) {
		$icon_class = 'fa fa-play';
	} elseif ( $post_format == 'audio' ) {
		$icon_class = 'fa fa-volume-up';
	} elseif ( $post_format == 'gallery' ) {
		$icon_class = 'fa fa-image';
	} elseif ( $post_format == 'image' ) {
		$icon_class = 'fa fa-image';
	} elseif ( $post_format == 'quote' ) {
		$icon_class = 'fa fa-quote-left';
	} elseif ( $post_format == '' ) {
		$icon_class = 'fa fa-plus';
	} else {
		$icon_class = 'fa fa-plus';
	}

	if ( $icon_class ) {
		$post_format_icon_output = '<i class="' . esc_attr( $icon_class ) . '" aria-hidden="true" ></i>';
		return $post_format_icon_output;
	}
}
add_filter( 'vc_ase_post_format_icon', 'vc_ase_post_format_icon_func', 10, 1 );

/**
 *  POST FORMAT ACTION ICON.
 *
 *  create icons using icon font using class attribute.
 *  used in items hover for prettyPhoto modal window opening big image, gallery, video, audio or quote
 *
 */
function vc_ase_post_format_icon_action_func( $empty = '' ) {
	global $post;
	$id          = get_the_ID();
	$post_format = get_post_format( $id );

	$icon_class = 'fa fa-plus';

	if ( $post_format == 'video' || $post_format == 'audio' ) {
		$icon_class = 'fa fa-play';
	}

	$post_format_icon_action = '<i class="' . esc_attr( $icon_class ) . '" aria-hidden="true"></i>';

	return $post_format_icon_action;
}
add_filter( 'vc_ase_post_format_icon_action', 'vc_ase_post_format_icon_action_func', 10, 1 );

