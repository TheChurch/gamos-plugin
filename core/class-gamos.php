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
 * @author Joel James <me@joelsays.com>
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
		// Initialize cpts.
		$this->cpts();

		$this->assets();

		// Setup profile functionality.
		$this->profile();

		// Setup shortcodes.
		$this->shortcodes();
	}

	/**
	 * Initialize custom post types.
	 *
	 * @since 1.1.0
	 */
	private function cpts() {
		Profile\CPT::instance()->init();
	}

	/**
	 * Initialize custom shortcodes.
	 *
	 * @since 1.1.0
	 */
	private function shortcodes() {
		Profile\Shortcodes\Registration::instance()->init();
		Profile\Shortcodes\Filter::instance()->init();
		Profile\Shortcodes\Manage_Profiles::instance()->init();
		Profile\Shortcodes\List_Profiles::instance()->init();
	}

	/**
	 * Setup profile functionality.
	 *
	 * @since 1.1.0
	 */
	private function profile() {
		Profile\Slider::instance()->init();
		Profile\ACF::instance()->init();
		Profile\Account::instance()->init();
	}

	/**
	 * Register all assets.
	 *
	 * @since 1.1.0
	 */
	private function assets() {
		Assets::instance()->init();
	}
}