<?php
/*
Plugin Name: WPB Micemade Elements
Plugin URI: https://micemade.com
Description: Extension plugin for WPBakery Page Builder (ex. Visual Composer) plugin - additional elements for page builder. Elements are best used with Micemade Larix theme, but can be used with any theme (with activated WPBakery Page Builder plugin), with caution.
Version: 1.3.0
Author: Micemade
Author URI: https://micemade.com
Text Domain: vc_ase
Domain Path: /languages

Copyright: © 2018 Micemade
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

class AS_VC_ELEMENTS {
	
	public function __construct() {
		
		if( $this->VC_plugin_activation_check() ) {
			
			define('VC_ASE_DIR', plugin_dir_path( __FILE__ ) );
			define('VC_ASE_URL', plugin_dir_url( __FILE__ ) );
			
			add_action('init', array( $this, 'as_vce_translations'));  
			
			register_activation_hook(__CLASS__, 'as_vce_on_activation');
			register_deactivation_hook( __CLASS__, 'as_vce_on_deactivation' );
			
			// Main files for VC elements:
			$this->include_vc_init();
			
			$this->activation_checks();	
			
			// Enqueue script and styles for ADMIN
			add_action( 'admin_enqueue_scripts', array( $this, 'vc_ase_admin_js_css' ) );
			
			// Enqueue scripts and styles for frontend
			add_action( 'wp_enqueue_scripts', array( $this,'vc_ase_styles') );
			add_action( 'wp_enqueue_scripts', array( $this,'vc_ase_scripts') );
			
			define('VC_ASE_PLACEHOLDER_IMAGE', VC_ASE_URL .'assets/images/as_vc_no-image.jpg');
			
		}else{

			add_action( 'admin_notices', array( $this,'as_vce_admin_notice') ); 
			
		}		
		
	}
	
	private function VC_plugin_activation_check() {
		
		$vc_ase_is_active = false;
		
		if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  {
			
			$vc_ase_is_active = true; 
			define('VC_IS_ACTIVE', true );
		}else{
			define('VC_IS_ACTIVE', false );
		}
		
		return $vc_ase_is_active;
		
	}
		
	private function activation_checks() {
		// VARIOUS PLUGINS ACTIVATION CHECKS:
		require_once VC_ASE_DIR . 'inc/plugins.php';
	}

	public function as_vce_admin_notice() {
		
		echo sprintf( 
			__( '%s%s"WPB Micemade Elements" (ex. Visual Composer AS elements)%s is not effective without "WPBakery Page Builder" (ex. Visual Composer) plugin activated. %sPlease, either install and activate "WPBakery Page Builder" plugin or deactivate "WPB Micemade Elements" plugin.%s' ,'vc_ase' ),
			'<div class="error updated settings-error notice is-dismissible"><p>',
			'<strong>',
			'</strong>',
			'<br>',
			'</p></div>'
		 );

	}
	
	/**
	 * LOAD TRANSLATIONS
	 */
	public function as_vce_translations() {
		
		$wp_lang_dir_file = WP_LANG_DIR . '/plugins/visual-composer-as-elements-' . get_locale() .'.mo';
		
		if ( file_exists( $wp_lang_dir_file ) ) {
			load_textdomain( 'vc_ase', $wp_lang_dir_file );
		}else{
			load_plugin_textdomain('vc_ase', false, dirname(plugin_basename(__FILE__)) . '/languages');
		}
		
	} 

	// START VISUAL COMPOSER ELEMENTS:
	public function include_vc_init () {
		
		include VC_ASE_DIR. "/as_vc_init.php";
		
	}
	
	public function vc_ase_admin_js_css() {
		
		wp_register_style( 'vc-ase-admin-css', VC_ASE_URL . 'assets/css/admin.css', 'style' );
		wp_enqueue_style( 'vc-ase-admin-css');
		
	}
	
	// ENQUEUE STYLES
	public function vc_ase_styles () {
		
		// CSS styles:
		wp_register_style( 'vc-ase-base', VC_ASE_URL . 'assets/css/vc_ase_base.css' );
		wp_enqueue_style( 'vc-ase-base' );
		
		wp_register_style( 'vc-ase-foundation', VC_ASE_URL . 'assets/css/foundation.min.css' );
		wp_enqueue_style( 'vc-ase-foundation' );
		
		
		wp_register_style( 'vc-ase-font-awesome', VC_ASE_URL . 'assets/css/font-awesome.min.css' );
		wp_enqueue_style( 'vc-ase-font-awesome' );
		
		wp_register_style( 'vc-ase-styles', VC_ASE_URL . 'assets/css/vc_ase_styles.css' );
		wp_enqueue_style( 'vc-ase-styles' );
		
		if ( ! LARIX_THEME_ACTIVE ) {
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
			wp_register_style( 'vc-ase-woo-styles', VC_ASE_URL . 'assets/css/woocommerce.min.css' );
			wp_enqueue_style( 'vc-ase-woo-styles' );
		}
		
	}
	
	// ENQUEUE SCRIPTS
	public function vc_ase_scripts () {
		
		// JS scripts:
		wp_register_script('vc-ase-ajax-js', VC_ASE_URL .'assets/js/vc_ase_ajax.js');
		wp_enqueue_script('vc-ase-ajax-js', VC_ASE_URL .'assets/js/vc_ase_ajax.js', array('jQuery','wc-single-product'), '1.0', true);
		
		wp_register_script('vc-ase-scripts', VC_ASE_URL .'assets/js/vc_ase_scripts.min.js');
		wp_enqueue_script('vc-ase-scripts', VC_ASE_URL .'assets/js/vc_ase_scripts.min.js', array('jQuery'), '1.0', true);
		
		// Localize the script with our data.
		$translation_array = array( 
			'vc_ase_loading_qv' => __( 'Loading quick view','vc_ase' ),
			'vc_ase_ajax_url' => admin_url("admin-ajax.php")
		);
		wp_localize_script( 'vc-ase-ajax-js', 'vc_ase_jsvars', $translation_array );
	}
	
	function updater() {
			
		require_once( plugin_dir_path( __FILE__ ) . 'github_updater.php' );
		if ( is_admin() ) {
			new Micemade_GitHub_Plugin_Updater( __FILE__, 'Micemade', "visual-composer-as-elements" );
		}
	}

	// ON PLUGIN ACTIVATION :
	public function as_vce_on_activation() {}
	
	// ON PLUGIN DEACTIVATION :
	public function as_vce_on_deactivation() {}


}

$as_vc_elements_object = new AS_VC_ELEMENTS();