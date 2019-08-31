<?php

namespace Gamos\Core;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The assets class for the plugin.
 *
 * @link   http://gamos.in
 * @since  1.0.2
 *
 * @author Joel James <me@joelsays.com>
 */
class Assets extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function init() {
		// Register styles and scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'register_front' ] );
	}

	/**
	 * Register scripts and styles required for front end.
	 *
	 * @since 1.0.2
	 *
	 * @return void
	 */
	public function register_front() {
		// Select2 base url.
		$path = GAMOS_URL . 'app/assets/';

		wp_register_style( 'gamos-front', $path . '/css/front.min.css' );

		wp_register_script( 'gamos-front', $path . '/js/front.min.js', [ 'jquery' ] );

		wp_enqueue_script( 'gamos-front' );
		wp_enqueue_style( 'gamos-front' );
	}
}