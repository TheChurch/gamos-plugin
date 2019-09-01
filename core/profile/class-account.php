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

		// Add post class.
		add_filter( 'post_class', [ $this, 'post_class' ], 10, 3 );

		// Disable profile thumbnail for theme.
		add_filter( 'has_post_thumbnail', [ $this, 'has_thumbnail' ] );
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
			'groups' => Helper::get_config( 'PROFILE_FIELD_GROUPS', [] ),
		] );
	}

	/**
	 * Add page class to profile view page.
	 *
	 * We need full width template.
	 *
	 * @param array $classes Array of post class names.
	 * @param array $class   Array of additional class names added to the post.
	 * @param int   $post_id The post ID.
	 *
	 * @since 1.2.0
	 *
	 * @return array
	 */
	public function post_class( $classes, $class, $post_id ) {
		// Make sure we are in the dashboard.
		if ( is_admin() || ! is_single() ) {
			return $classes;
		}

		// Add page class.
		if ( 'profile' === get_post_type( $post_id ) ) {
			$classes[] = 'type-page';
		}

		return $classes;
	}

	/**
	 * Disable post thumbnail in front end.
	 *
	 * @param bool $has_thumbnail true if the post has a post thumbnail, otherwise false.
	 *
	 * @since 1.2.0
	 *
	 * @return bool
	 */
	public function has_thumbnail( $has_thumbnail ) {
		// We don't need thumb for profile.
		if ( is_singular( 'profile' ) ) {
			$has_thumbnail = false;
		}

		return $has_thumbnail;
	}
}