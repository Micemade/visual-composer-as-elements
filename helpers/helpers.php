<?php
/**
 * RANDOM STRING GENERATOR.
 * Used for: generated unique block ID (js and customizing actions)
 * Used in:
 * - /shortcodes/ - all files in dir
 * - /vc_ase_templates/vc_row.php
 * - used in FRONTEND
 */
function vc_ase_generateRandomString( $length = 10 ) {
	$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen( $characters );
	$randomString     = '';
	for ( $i = 0; $i < $length; $i++ ) {
		$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
	}
	return $randomString;
}
add_filter( 'vc_ase_randomString', 'vc_ase_generateRandomString', 10, 1 );
/**
 *  CONTACT FORM FUNCTIONS
 *
 */
function vc_ase_hexstr( $hexstr ) {
	  $hexstr = str_replace( ' ', '', $hexstr );
	  $hexstr = str_replace( '\x', '', $hexstr );
	  $retstr = pack( 'H*', $hexstr );
	  return $retstr;
}
function vc_ase_strhex( $string ) {
	$hexstr = unpack( 'H*', $string );
	return array_shift( $hexstr );
}
/**
 *  VC_ASE_CONTENT_STYLE3
 *
 *  @param $link (string)
 *  @return string
 *
 *  @details alternate style for posts / portfolio
 */

function vc_ase_content_style3_func( $post_id, $link, $post_type, $taxonomy ) {

	$terms = get_the_term_list( $post_id, $taxonomy, '<span class="posted_in">', ', ', '</span>' );

	echo '<h4>';
	echo wp_kses_post( $terms );
	echo '<a href="' . esc_url( $link ) . '">' . esc_html( strip_tags( get_the_title() ) ) . '</a>';
	echo '</h4>';

	if ( $post_type === 'post' ) {
		echo '<div class="vcase-post-meta">';

		do_action( 'vc_ase_entry_date' ) . '</div>';

		echo '</div>';
	}
	echo '<div class="item-overlay alter"></div>';

	echo '<div class="back">';

	if ( $post_type === 'product' ) {
		do_action( 'vc_ase_shop_buttons', true, true, true, 'thumbnail' );
	}

		echo '<div class="excerpt">';

	if ( $post_type != 'product' ) {
		do_action( 'vc_ase_archive_content' );
	}

			echo '<div class="back-buttons">';

				echo '<a href="' . $link . '"  title="' . the_title_attribute( array( 'echo' => 0 ) ) . '"></a>';

			echo '</div>'; // back-buttons

		echo '</div>'; // excerpt

	echo '</div>'; // back

}
add_action( 'vc_ase_content_style3', 'vc_ase_content_style3_func', 10, 4 );
/**
 *  VC_ASE_CONTENT_STYLE 4
 *
 *  @param $link (string)
 *  @return string
 *
 *  @details alternate style for posts / portfolio
 */

function vc_ase_content_style4_func( $post_id, $link, $post_type, $taxonomy ) {

	echo '<div class="back">';

	echo '<div class="item-overlay alter"></div>';

		echo '<div class="back-buttons">';

			$terms = get_the_term_list( $post_id, $taxonomy, '<span class="posted_in">', ', ', '</span>' );

			echo '<h4>' . $terms . '<a href="' . $link . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">' . esc_html( strip_tags( get_the_title() ) ) . '</a></h4>';

	if ( $post_type === 'post' ) {

		echo '<div class="vcase-post-meta">';

		do_action( 'vc_ase_entry_date' ) . '</div>';

		echo '</div>';
	}

		echo '</div>'; // back-buttons

	if ( $post_type == 'product' ) {
		do_action( 'vc_ase_shop_buttons', true, true, true, 'thumbnail' );
	}

	echo '</div>'; // back

}
add_action( 'vc_ase_content_style4', 'vc_ase_content_style4_func', 10, 4 );

/**
 * REMOVE AN ANONYMOUS FUNCTION FILTER.
 *
 * @param string $tag      Hook name.
 * @param string $filename The file where the function was declared.
 * @param int $priority    Optional. Hook priority. Defaults to 10.
 * @return bool
 */
if ( ! function_exists( 'vc_ase_remove_anonymous_function_filter' ) ) {

	function vc_ase_remove_anonymous_function_filter( $tag, $filename, $priority = 10 ) {
		$filename = plugin_basename( $filename );

		if ( ! isset( $GLOBALS['wp_filter'][ $tag ][ $priority ] ) ) {
			return false;
		}
		$filters = $GLOBALS['wp_filter'][ $tag ][ $priority ];

		foreach ( $filters as $callback ) {
			if ( ( $callback['function'] instanceof Closure ) || is_string( $callback['function'] ) ) {
				$function = new ReflectionFunction( $callback['function'] );

				$funcFilename = plugin_basename( $function->getFileName() );
				$funcFilename = preg_replace( '@\(\d+\)\s+:\s+runtime-created\s+function$@', '', $funcFilename );

				if ( $filename === $funcFilename ) {
					return remove_filter( $tag, $callback['function'], $priority );
				}
			}
		}

		return false;
	}
}
/**
 *  ECHO FILTER TO OVERRIDE PLUGIN STRINGS
 *
 *  @param [in] 10 priority
 *  @param [in] 1 number of accepted arguments
 *  @return echo
 *
 */
add_filter( 'vc_ase_contact_name', 'vc_ase_echo', 10, 1 );
add_filter( 'vc_ase_contact_email', 'vc_ase_echo', 10, 1 );
add_filter( 'vc_ase_contact_subject', 'vc_ase_echo', 10, 1 );
add_filter( 'vc_ase_contact_message', 'vc_ase_echo', 10, 1 );
// function for filters echo
function vc_ase_echo( $echo ) {
	return $echo;
}
//
//
//
// TO DO:
function elements_custom_css( $block_id, $block_css ) {
	$inline_css_func = function ( $block_id, $block_css ) {
		/*
		wp_enqueue_style(
			'vcase-single-prod-custom-css-'.$block_id,
			VC_ASE_URL . 'assets/css/custom_css_empty.css'
		);

		wp_add_inline_style( 'vcase-single-prod-custom-css-'.$block_id, $block_css );
		*/

	};
	$inline_css = '<style>' . $block_css . '</style>';

	add_action( 'wp_print_scripts', $inline_css );
	//add_action( 'wp_enqueue_scripts', $inline_css_func ,10,2 );
}
