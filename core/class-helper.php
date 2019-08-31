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
	 * Get gallery using lightbox plugin.
	 *
	 * @since 1.0.1
	 *
	 * @return string
	 */
	public static function get_profile_gallery( $images ) {
		// Basic requirement check.
		if ( empty( $images ) || ! class_exists( 'Gamos\Core\Profile\Slider' ) ) {
			return '';
		}

		// Gallery instance.
		$gallery = Gamos\Core\Profile\Slider::instance();

		// Get image url.
		foreach ( $images as $image ) {
			if ( isset( $image['images']['sizes']['gamos'] ) ) {
				$image_urls[] = $image['images']['sizes']['gamos'];
			}
		}

		// Render gallery.
		return $gallery->render_slider( $image_urls );
	}
}