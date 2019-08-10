<?php

namespace Gamos\Core\Account;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The login form customization functionality.
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <me@joelsays.com>
 */
class Login_Form extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 3.2.0
	 *
	 * @return void
	 */
	public function init() {
		// Change title place holder.
		add_action( 'login_enqueue_scripts', [ $this, 'login_form_styles' ] );
		add_filter( 'login_headerurl', [ $this, 'login_logo_url' ] );
		add_filter( 'login_headertitle', [ $this, 'login_logo_title' ] );
	}

	/**
	 * Custom style for login form page.
	 *
	 * @since 1.0.2
	 *
	 * @return void
	 */
	public function login_form_styles() {
		?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                display: none;
            }

            #login .button-primary {
                background: #404040;
                border-color: #404040;
                -webkit-box-shadow: 0 1px 0 #000000;
                box-shadow: 0 1px 0 #000000;
                text-shadow: 0 -1px 1px #262626, 1px 0 1px #262626, 0 1px 1px #262626, -1px 0 1px #262626;
            }

            .login #nav a, .login #backtoblog a {
                color: #ddd !important;
            }

            .login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
                color: #e8cf50 !important;
            }

            body {
                background: url(https://gamos.in/wp-content/uploads/2019/08/gamos-login.jpg) no-repeat center center fixed !important;
                -webkit-background-size: cover !important;
                -moz-background-size: cover !important;
                -o-background-size: cover !important;
                background-size: cover !important;
            }

            #login .button-primary {
                color: #fff !important;
            }

            .login #login_error, .login .message {
                border-left: 4px solid #000;
            }

            a {
                color: #000;
            }

            .login #login_error {
                border-left-color: #000;
            }
        </style>
		<?php
	}

	/**
	 * Set login header url to site url.
	 *
	 * @since 1.0.2
	 *
	 * @return string
	 */
	public function login_logo_url() {
		return site_url();
	}

	/**
	 * Set login header title text.
	 *
	 * @since 1.0.2
	 *
	 * @return string
	 */
	public function login_logo_title() {
		return __( 'Gamos Search', 'gamos-plugin' );
	}
}