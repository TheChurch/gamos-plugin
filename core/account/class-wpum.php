<?php

namespace Gamos\Core\Account;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The shortcode class for the profile feature.
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <me@joelsays.com>
 */
class WPUM extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 3.2.0
	 *
	 * @return void
	 */
	public function init() {
		// Change title place holder.
		//add_filter( 'wpum_get_account_page_tabs', [ $this, 'account_tabs' ] );
	}

	/**
	 * Render profile registration form.
	 *
	 * @param array $field_groups ACF field groups.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function account_tabs( $tabs ) {
		$tabs['profile'] = [
			'name'     => esc_html__( 'Profile', 'gamos-plugin' ),
			'priority' => 10,
		];

		return $tabs;
	}
}