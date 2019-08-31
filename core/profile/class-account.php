<?php

namespace Gamos\Core\Profile;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Helper;
use Gamos\Core\Utils\Abstracts\Base;

/**
 * The account functionality.
 *
 * Mainly handles the integration with WP User Manager (https://wordpress.org/plugins/wp-user-manager/).
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <me@joelsays.com>
 */
class Account extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function init() {
		// Add custom tab to account page.
		add_filter( 'wpum_get_account_page_tabs', [ $this, 'profile_tab' ] );

		// Show profile form within profile tab.
		add_action( 'wpum_account_page_content_profile', [ $this, 'profile_form' ] );
	}

	/**
	 * Add new tab to account page of WPUM.
	 *
	 * @param array $tabs Tabs array.
	 *
	 * @since 1.2.0
	 *
	 * @return array
	 */
	public function profile_tab( $tabs ) {
		// Add profile form tab.
		$tabs['profile'] = [
			'name'     => esc_html__( 'Profile', 'gamos-plugin' ),
			'priority' => - 1,
		];

		// Remove default view.
		unset( $tabs['view'] );

		return $tabs;
	}

	/**
	 * Add new tab to account page of WPUM.
	 *
	 * @since 1.2.0
	 *
	 * @todo  Do not forget to change the field group ids.
	 *
	 * @return void
	 */
	public function profile_form() {
		// Render template.
		Helper::view( 'front/profile/profile-form', [
			'groups' => [ 7, 26, 31, 34, 140 ],
		] );
	}
}