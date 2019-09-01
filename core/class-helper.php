<?php

namespace Gamos\Core;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

/**
 * The helper functionlity of the plugin.
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <me@joelsays.com>
 */
class Helper {

	/**
	 * Render a template for the view page.
	 *
	 * @param string $view   File name.
	 * @param array  $args   Arguments.
	 * @param bool   $return Should return instead of include.
	 *
	 * @since 3.2.0
	 *
	 * @return void|string
	 */
	public static function view( $view, $args = [], $return = false ) {
		// Default views.
		$file_name = GAMOS_DIR . 'app/templates/' . $view . '.php';

		// If file exist, set all arguments are variables.
		if ( file_exists( $file_name ) && is_readable( $file_name ) ) {
			if ( ! empty( $args ) ) {
				$args = (array) $args;
				extract( $args );
			}

			ob_start();

			/* @noinspection PhpIncludeInspection */
			include $file_name;

			$content = ob_get_contents();

			ob_end_clean();

			if ( $return ) {
				return $content;
			} else {
				echo $content;
			}
		}
	}

	/**
	 * Calculate age based on the DOB value.
	 *
	 * @param string $dob Date of birth.
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	public static function get_dob( $dob ) {
		// Calculate the date difference.
		$diff = date_diff(
			date_create( $dob ),
			date_create( 'today' )
		);

		return $diff->y;
	}

	/**
	 * Get a configuration item value.
	 *
	 * These items should be defined in wp-config.php or somewhere.
	 *
	 * @param string $name    Config name.
	 * @param mixed  $default Default value.
	 *
	 * @since 1.2.0
	 *
	 * @return mixed
	 */
	public static function get_config( $name, $default = false ) {
		// Get value if defined.
		if ( defined( $name ) ) {
			return constant( $name );
		}

		return $default;
	}
}