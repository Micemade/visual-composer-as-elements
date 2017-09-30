<?php
/**
 * Add to wishlist button template
 *
 * @author Aligator Studio / Your Inspiration Themes
 * @package VC ASE  / YITH WooCommerce Wishlist
 * @version 1.0.0 - VC ASE
 * @version 2.0.8 - YITH WooCommerce Wishlist
 */

global $product ;
$icon 		= '<span class="fa fa-heart-o"></span>';
$classes	= 'vc_ase_add_to_wishlist tip-top';
$title_add	= __('Add to wishlist','vc_ase');
$product_id	= apply_filters( 'vc_ase_wc_version', '3.0.0'  ) ? $product->get_id() : $product->id;
?>

<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) ); ?>" data-product-id="<?php esc_attr_e($product_id); ?>" data-product-type="<?php esc_attr_e( $product_type ); ?>" class="<?php esc_attr_e($classes); ?>" title="<?php echo esc_attr($title_add); ?>">
    <?php echo wp_kses_post($icon); ?> 
</a>
<img src="<?php echo esc_url( VC_ASE_URL . 'assets/images/ajax-loader.gif' ); ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />