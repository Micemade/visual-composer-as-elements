<?php
// PLUGINS:

// if WOOCOMMERCE activated:
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	define( 'VC_ASE_WOO_ACTIVE', true );
} else {
	define( 'VC_ASE_WOO_ACTIVE', false );
}
// if YITH WC WISHLIST activated:
if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	define( 'VC_ASE_WISHLIST_ACTIVE', true );
} else {
	define( 'VC_ASE_WISHLIST_ACTIVE', false );
}

// if WPML activated:
if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	define( 'VC_ASE_WPML_ON', true );
} else {
	define( 'VC_ASE_WPML_ON', false );
}

// THEMES:
// if MICEMADE THEME is activated :
if ( 'larix' == get_option( 'template' ) ) {
	define( 'LARIX_THEME_ACTIVE', true );
} else {
	define( 'LARIX_THEME_ACTIVE', false );
}
