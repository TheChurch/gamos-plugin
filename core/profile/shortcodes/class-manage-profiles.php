<?php

namespace Gamos\Core\Profile\Shortcodes;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The profile management shortcode for the plugin.
 *
 * @link   http://gamos.in
 * @since  1.0.2
 *
 * @author Joel James <me@joelsays.com>
 */
class Manage_Profiles extends Base {

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
		// Register shortcode.
		add_shortcode( 'gamos_manage_list', [ $this, 'profile_list' ] );
	}

	/**
	 * Outputs the content of the shortcode.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function profile_list() {
		// Get query vars from request.
		$profiles = $this->get_profiles();

		ob_start();
		?>

        <div class="gamos-profile-list">

            <table>
                <tr>
                    <th><p><?php esc_html_e( 'Name', 'gamos-plugin' ); ?></p></th>
                    <th><p><?php esc_html_e( 'Status', 'gamos-plugin' ); ?></p></th>
                    <th><p><?php esc_html_e( 'Actions', 'gamos-plugin' ); ?></p></th>
                </tr>

				<?php foreach ( $profiles as $profile ) : ?>
                    <tr>
                        <td>
                            <p><?php echo $profile->post_title; ?></p>
                        </td>
                        <td><p><?php echo 'publish' === $profile->post_status ? __('Active') : __('Inactive'); ?></p></td>
                        <td>
                            <a href="#"><?php esc_html_e( 'View', 'gamos-plugin' ); ?></a>
                            <a href="#"><?php esc_html_e( 'Edit', 'gamos-plugin' ); ?></a>
                            <a href="#"><?php esc_html_e( 'Delete', 'gamos-plugin' ); ?></a>
                        </td>
                    </tr>
				<?php endforeach; ?>

            </table>

        </div>

		<?php
		$content = ob_get_contents();

		ob_end_clean();

		return $content;
	}

	/**
	 * Get all profiles added by current user.
	 *
	 * @since 1.0.2
	 *
	 * @return array
	 */
	public function get_profiles() {
		// Query arguments.
		$args = array(
			'post_type'   => 'profile',
			'author'      => get_current_user_id(),
			'post_status' => [ 'publish', 'pending', 'draft' ],
		);

		return get_posts( $args );
	}
}