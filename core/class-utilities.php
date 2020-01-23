<?php

namespace Gamos\Core;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The utilities plugin class.
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <me@joelsays.com>
 */
class Utilities extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function init() {
		// Add GA script.
		add_action( 'wp_head', [ $this, 'google_analytics' ] );
	}

	/**
	 * Print Google Analytics script.
	 *
	 * @since 1.2.0
	 */
	public function google_analytics() {
		?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135690140-2"></script>
        <script>
			window.dataLayer = window.dataLayer || [];
			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', 'UA-135690140-2');
        </script>
		<?php
	}
}