<?php

namespace Gamos\Core\Profile\Shortcodes;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Helper;
use Gamos\Core\Utils\Abstracts\Base;

/**
 * The profile filter shortcode for the plugin.
 *
 * @link   http://gamos.in
 * @since  1.0.2
 *
 * @author Joel James <me@joelsays.com>
 */
class Filter extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	/**
	 * Sets up the widgets name etc
	 */
	public function init() {
		// Register styles and scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );

		// Register custom query vars for profile.
		add_filter( 'query_vars', array( $this, 'profile_query_vars' ) );

		// Register shortcode.
		add_shortcode( 'gamos_profile_filter', array( $this, 'filter' ) );
	}

	/**
	 * Outputs the content of the shortcode.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function filter() {
		// Enqueue scripts and styles.
		wp_enqueue_style( 'select2' );
		wp_enqueue_script( 'select2' );

		// Render template.
		$content = Helper::view(
			'front/profile/shortcodes/profile-filter',
			array(
				'job'        => get_query_var( 'profile_job', false ),
				'gender'     => get_query_var( 'profile_gender', false ),
				'church'     => get_query_var( 'profile_church', false ),
				'min_age'    => get_query_var( 'profile_min_age', false ),
				'max_age'    => get_query_var( 'profile_max_age', false ),
				'education'  => get_query_var( 'profile_education', false ),
				'churches'   => get_terms(
					array(
						'taxonomy'   => 'churches',
						'hide_empty' => false,
						'fields'     => 'id=>name',
					)
				),
			),
			true
		);

		return $content;
	}

	/**
	 * Register select2 library styles and scripts.
	 *
	 * @since 1.0.2
	 *
	 * @return void
	 */
	public function register_assets() {
		// Only if not registered.
		if ( ! wp_script_is( 'select2', 'registered' ) ) {
			// Select2 base url.
			$lib_path = GAMOS_URL . 'app/assets/vendor/select2';

			wp_register_style( 'select2', $lib_path . '/css/select2.min.css' );

			wp_register_script( 'select2', $lib_path . '/js/select2.min.js', array( 'jquery' ) );
		}
	}

	/**
	 * Add our custom query vars for the profile filter.
	 *
	 * @param array $vars Custom vars.
	 *
	 * @since 1.0.2
	 *
	 * @return array
	 */
	public function profile_query_vars( $vars ) {
		$vars[] = 'profile_church';
		$vars[] = 'profile_min_age';
		$vars[] = 'profile_max_age';
		$vars[] = 'profile_education';
		$vars[] = 'profile_job';
		$vars[] = 'profile_gender';

		return $vars;
	}
}
