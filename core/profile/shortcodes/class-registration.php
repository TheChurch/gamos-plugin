<?php

namespace Gamos\Core\Profile\Shortcodes;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The shortcode class for the profile registration.
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <me@joelsays.com>
 */
class Registration extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 3.2.0
	 *
	 * @return void
	 */
	public function init() {
		// Register shortcode.
		add_shortcode( 'gamos_profile_registration', [ $this, 'registration' ] );
	}

	/**
	 * Return the content for the profile registration page.
	 *
	 * If the user already has a profile added, we will show an
	 * update form. Otherwise a registration form.
	 *
	 * @param array $attr Shortcode attributes.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function registration( $attr ) {
		// We need ACF instance.
		if ( ! function_exists( 'acf' ) ) {
			return sprintf( '<div class="gamos-notice error"><p>%s</p></div>', __( 'Advanced Custom Fields plugin should be active.', 'gamos-plugin' ) );
		}

		// Allow only logged in users.
		if ( ! is_user_logged_in() ) {
			return sprintf(
				__( '<div class="gamos-notice error"><p>Please <a href="%s">login</a> or <a href="%s">register</a> before adding your profile.</p></div>', 'gamos-plugin' ),
				wp_login_url( get_the_permalink() ),
				wp_registration_url()
			);
		}

		// Parse shortcode attributes.
		$attr = shortcode_atts( [
			'field_groups' => [],
		], $attr );

		// Explod by comma.
		$field_groups = explode( ',', $attr['field_groups'] );

		// We need field groups.
		if ( empty( $field_groups ) ) {
			return sprintf( '<div class="gamos-notice error"><p>%s</p></div>', __( 'Please specify the ACF field group IDs in shortcode.', 'gamos-plugin' ) );
		}

		// Enqueue the required scripts and styles.
		acf()->form_front->enqueue_form();

		// Get currently logged in user's profile.
		$profile = $this->get_profile();

		ob_start();

		// Show create or update form.
		if ( empty( $profile ) ) {
			$this->create_form( $field_groups );
		} else {
			// Show a pending message.
			if ( ! isset( $_GET['updated'] ) && get_post_status( $profile ) !== 'publish' ) {
				echo '<div class="wpum-message warning"><p>' . __( 'Your profile is pending approval.', 'gamos-plugin' ) . '</p></div>';
			}

			$this->edit_form( $profile, $field_groups );
		}

		$content = ob_get_contents();

		ob_end_clean();

		return $content;
	}

	/**
	 * Get available profile of the current user.
	 *
	 * We take only 1 profile. User's can register only
	 * one profile.
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	private function get_profile() {
		// Query arguments.
		$args = array(
			'numberposts' => 1,
			'fields'      => 'ids',
			'post_type'   => 'profile',
			'author'      => get_current_user_id(),
			'post_status' => [ 'publish', 'pending', 'draft' ],
		);

		$profiles = get_posts( $args );

		return empty( $profiles[0] ) ? 0 : $profiles[0];
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
	private function create_form( $field_groups = [] ) {
		return acf_form( [
			'post_id'               => 'new_post',
			'post_title'            => true,
			'field_groups'          => $field_groups,
			'return'                => false,
			'instruction_placement' => 'field',
			'submit_value'          => __( 'Submit', 'gamos-plugin' ),
			'html_updated_message'  => sprintf( '<div class="wpum-message success"><p>%s</p></div>', $this->updated_message() ),
			'new_post'              => [
				'post_type' => 'profile',
			],
			'form_attributes'       => [
				'action' => add_query_arg( 'updated', 'create' ),
			],
		] );
	}

	/**
	 * Render the profile edit form.
	 *
	 * @param int   $id           Profile ID.
	 * @param array $field_groups ACF field groups.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function edit_form( $id, $field_groups = [] ) {
		return acf_form( [
			'post_id'               => $id,
			'post_title'            => true,
			'return'                => false,
			'instruction_placement' => 'field',
			'field_groups'          => $field_groups,
			'submit_value'          => __( 'Update', 'gamos-plugin' ),
			'html_updated_message'  => sprintf( '<div class="wpum-message success"><p>%s</p></div>', $this->updated_message() ),
			'form_attributes'       => [
				'action' => add_query_arg( 'updated', 'update' ),
			],
		] );
	}

	/**
	 * Get the proper success message based on the form.
	 *
	 * @since 1.2.0
	 *
	 * @return string|void
	 */
	private function updated_message() {
		if ( isset( $_GET['updated'] ) && 'create' === $_GET['updated'] ) {
			return __( 'Profile created successfully. It will be published after approval.', 'gamos-plugin' );
		} else {
			return __( 'Profile updated successfully.', 'gamos-plugin' );
		}
	}
}