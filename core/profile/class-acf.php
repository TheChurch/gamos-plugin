<?php

namespace Gamos\Core\Profile;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The ACF functionality of the plugin.
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <me@joelsays.com>
 */
class ACF extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function init() {
		// Handle ACF form submit.
		add_action( 'acf/save_post', [ $this, 'set_thumbnail' ], 15 );

		// Validate phone numbers.
		add_filter( 'acf/validate_value/name=elder_contact_number', [ $this, 'phone_validation' ], 10, 2 );
		add_filter( 'acf/validate_value/name=parents_contact_number', [ $this, 'phone_validation' ], 10, 2 );

		// Change title label.
		add_filter( 'acf/prepare_field/name=_post_title', [ $this, 'change_title' ] );
	}

	/**
	 * Handle post submit and set post thumbnail.
	 *
	 * @param int $post_id Profile post id.
	 *
	 * @since 1.0.1
	 */
	public function set_thumbnail( $post_id ) {
		// Images.
		$images = get_field( 'pictures', $post_id );

		// Set post thumbnail.
		if ( isset( $images[0]['images']['ID'] ) ) {
			// Set thumbnail.
			set_post_thumbnail( $post_id, $images[0]['images']['ID'] );
		} else {
			// Remove post thumbnail.
			delete_post_thumbnail( $post_id );
		}
	}

	/**
	 * Validate phone number for 10 diigits.
	 *
	 * @param bool|string $valid Is valid.
	 * @param mixed       $value Field value.
	 *
	 * @since 1.1.0
	 *
	 * @return string|bool
	 */
	public function phone_validation( $valid, $value ) {
		if ( $valid && ! preg_match( '/^[0-9]{10}+$/', $value ) ) {
			$valid = __( 'Should be a valid 10 digit phone number', 'gamos-plugin' );
		}

		return $valid;
	}

	/**
	 * Enter title label to name.
	 *
	 * @param array $field Field data.
	 *
	 * @since 1.2.0
	 *
	 * @return array
	 */
	public function change_title( $field ) {
		$field['label']        = __( 'Name' );
		$field['instructions'] = __( 'Enter you full name.' );

		return $field;
	}
}
