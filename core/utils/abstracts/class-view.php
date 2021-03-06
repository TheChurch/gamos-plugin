<?php

namespace Beehive\Core\Utils\Abstracts;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

/**
 * The view base class of the plugin.
 *
 * @link   http://premium.wpmudev.org
 * @since  3.2.0
 *
 * @author Joel James <joel@incsub.com>
 */
class View extends Base {

	/**
	 * Render an admin view template.
	 *
	 * @param string $view File name.
	 * @param array  $args Arguments.
	 *
	 * @since 3.2.0
	 *
	 * @return void
	 */
	public function view( $view, $args = array() ) {
		// Default views.
		$file_name = BEEHIVE_DIR . 'app/templates/' . $view . '.php';

		// If file exist, set all arguments are variables.
		if ( file_exists( $file_name ) && is_readable( $file_name ) ) {
			if ( ! empty( $args ) ) {
				$args = (array) $args;
				extract( $args );
			}

			/* @noinspection PhpIncludeInspection */
			include $file_name;
		}
	}

	/**
	 * Render notification template.
	 *
	 * @param string $content Notice content.
	 * @param string $type    Notice type.
	 * @param bool   $top     Is this a top notice?.
	 *
	 * @since 3.2.0
	 *
	 * @return void
	 */
	public function notice( $content, $type = 'success', $top = true ) {
		// Available notice types.
		$types = [ 'success', 'warning', 'error', 'info', 'purple', 'orange', 'loading' ];

		// Render notice.
		$this->view( 'common/notice', [
			'content' => $content,
			'type'    => in_array( $type, $types ) ? $type : '',
			'top'     => $top,
		] );
	}
}