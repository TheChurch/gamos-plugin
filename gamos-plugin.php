<?php
/**
 * Plugin Name:        Gamos Plugin
 * Plugin URI:         http://gamos.in
 * Description:        Custom functionality for the Gamos Search site.
 * Version:            1.0.1
 * Author:             Joel James
 * Author URI:         https://duckdev.com
 * GitHub Plugin URI:  https://github.com/thechurch/gamos-plugin
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Plugin directory.
if ( ! defined( 'GAMOS_DIR' ) ) {
	define( 'GAMOS_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin url.
if ( ! defined( 'GAMOS_URL' ) ) {
	define( 'GAMOS_URL', plugin_dir_url( __FILE__ ) );
}

// Admin menu permission.
if ( ! defined( 'GAMOS_ACCESS' ) ) {
	define( 'GAMOS_ACCESS', 'manage_options' );
}

// Auto load classes.
require_once GAMOS_DIR . '/core/utils/autoloader.php';

/**
 * When everything is ready, start the plugin.
 *
 * @since 1.0.0
 */
add_action( 'plugins_loaded', function () {
	// Create new instance of the plugin.
	\Gamos\Core\Gamos::instance();
} );