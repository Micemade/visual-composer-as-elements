<?php
/**
 * Add to wishlist template for VC ASE
 *
 * @author Aligator Studio / Your Inspiration Themes
 * @package VC ASE  / YITH WooCommerce Wishlist
 * @version 1.0.0 - VC ASE
 * @version 2.0.8 - YITH WooCommerce Wishlist
 */

global $product, $yith_wcwl, $atts;

$icon_added        = '<span class="fa fa-heart"></span>';
$title_added       = __( 'Product added! Browse Wishlist', 'vc_ase' );
$title_in_wishlist = __( 'The product is already in the wishlist! Browse Wishlist', 'vc_ase' );

// 3.0.0 < Fallback conditional :
$product_id = apply_filters( 'vc_ase_wc_version', '3.0.0' ) ? $product->get_id() : $product->id;
?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php esc_attr_e( $product_id ); ?>">
	
	<div class="yith-wcwl-add-button <?php echo ( $exists && ! $available_multi_wishlist ) ? 'hide' : 'show'; ?>" style="display:<?php echo ( $exists && ! $available_multi_wishlist ) ? 'none' : 'block'; ?>">

		<?php vc_ase_wishlist_get_template( 'add-to-wishlist-button.php', $atts ); ?>

	</div>

	<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
				
		<a href="<?php echo esc_url( $wishlist_url ); ?>" class="tip-top" title="<?php echo esc_attr( $title_added ); ?>"><?php echo wp_kses_post( $icon_added ); ?></a>

	</div>

	<div class="yith-wcwl-wishlistexistsbrowse <?php echo ( $exists && ! $available_multi_wishlist ) ? 'show' : 'hide'; ?>" style="display:<?php echo ( $exists && ! $available_multi_wishlist ) ? 'block' : 'none'; ?>">
		
		<a href="<?php echo esc_url( $wishlist_url ); ?>" class="tip-top" title="'<?php echo esc_attr( $title_in_wishlist ); ?> "><?php echo wp_kses_post( $icon_added ); ?></a>

	</div>

	<div style="clear:both"></div>
	<div class="yith-wcwl-wishlistaddresponse"></div>

</div>

<div class="clear"></div>

<script type="text/javascript">
	if( jQuery( '#yith-wcwl-popup-message' ).length == 0 ) {
		var message_div = jQuery( '<div>' )
				.attr( 'id', 'yith-wcwl-message' ),
			popup_div = jQuery( '<div>' )
				.attr( 'id', 'yith-wcwl-popup-message' )
				.html( message_div )
				.hide();

		jQuery( 'body' ).prepend( popup_div );
	}
</script>
