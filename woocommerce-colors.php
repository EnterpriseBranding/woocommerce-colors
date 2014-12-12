<?php
/**
 * Plugin Name: WooCommerce Colors
 * Plugin URI: http://wordpress.org/plugins/woocommerce-colors/
 * Description: WooCommerce Colors.
 * Author: WooThemes
 * Author URI: http://woothemes.com
 * Version: 1.0.0
 * License: GPLv2 or later
 * Text Domain: woocommerce-colors
 * Domain Path: languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Colors' ) ) :

/**
 * WooCommerce Colors main class.
 */
class WC_Colors {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Checks with WooCommerce is installed.
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
			$this->includes();
		} else {
			add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Get assets url.
	 *
	 * @return string
	 */
	public static function get_assets_url() {
		return plugins_url( 'assets/', __FILE__ );
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-colors' );

		load_textdomain( 'woocommerce-colors', trailingslashit( WP_LANG_DIR ) . 'woocommerce-colors/woocommerce-colors-' . $locale . '.mo' );
		load_plugin_textdomain( 'woocommerce-colors', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Includes.
	 */
	private function includes() {
		include_once 'includes/class-wc-colors-customizer.php';
	}

	/**
	 * WooCommerce fallback notice.
	 *
	 * @return string
	 */
	public function woocommerce_missing_notice() {
		echo '<div class="error"><p>' . sprintf( __( 'WooCommerce Colors depends on the last version of %s or later to work!', 'woocommerce-colors' ), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">' . __( 'WooCommerce 2.3', 'woocommerce-colors' ) . '</a>' ) . '</p></div>';
	}
}

add_action( 'plugins_loaded', array( 'WC_Colors', 'get_instance' ), 0 );

endif;