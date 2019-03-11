<?php
//
/**
 *  META INFO BLOCK - generate all the post meta - date, author, tags, categories
 *
 */
function vc_ase_entry_date_func() {

	$link      = esc_url( get_permalink() );
	$time      = esc_attr( get_the_time() );
	$day       = esc_attr( get_the_date( 'd' ) );
	$month     = esc_attr( get_the_date( 'M' ) );
	$year      = esc_attr( get_the_date( 'Y' ) );
	$full_date = esc_attr( get_the_date( 'c' ) );

	// date/time:
	$output = '<span class="date-meta"><i class="fa fa-calendar"></i><a href="' . $link . '" title="' . $time . '" rel="bookmark" class="date-time"><time class="entry-date" datetime="' . $full_date . '" ><span class="day">' . $day . '</span> <span class="month">' . $month . '</span></time></a></span>';

	echo wp_kses_post( $output );
}
add_action( 'vc_ase_entry_date', 'vc_ase_entry_date_func' );


function vc_ase_entry_author_func() {

	$author_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
	$author      = esc_html( get_the_author() );

	// author:
	$by     = __( 'author: ', 'vc_ase' );
	$output = '<span class="author-meta"><i class="fa fa-user"></i><a class="url fn n author" href="' . $author_link . '" title="' . esc_attr( __( 'View all post by ', 'vc_ase' ) . $author ) . '" rel="author">' . $by . $author . '</a></span>';

	echo  wp_kses_post( $output );
}
add_action( 'vc_ase_entry_author', 'vc_ase_entry_author_func' );

