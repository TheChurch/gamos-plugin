<?php

namespace Gamos\Core;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The core plugin class.
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <joel@incsub.com>
 */
final class Gamos extends Base {

	/**
	 * Initialize functionality of the plugin.
	 *
	 * This is where we kick-start the plugin by defining
	 * everything required and register all hooks.
	 *
	 * @since  1.0.0
	 * @access protected
	 *
	 * @return void
	 */
	protected function __construct() {
		$this->run();
	}

	/**
	 * Run the plugin by registering all the hooks.
	 *
	 * Initialize all the child class where we will register the
	 * hooks and filters for the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function run() {
		// Initialize cpts.
		Profile\CPT::instance()->init();
		// Setup shortcodes.
		Profile\Shortcode::instance()->init();
		// Setup slider.
		Profile\Slider::instance()->init();
		// Handle registration.
		Profile\Registration::instance()->init();

		// Login form customization.
		Account\Login_Form::instance()->init();
		// Setup shortcodes.
		Account\WPUM::instance()->init();
	}
}