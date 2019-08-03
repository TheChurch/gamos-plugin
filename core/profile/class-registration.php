<?php

namespace Gamos\Core\Profile;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The registration functionality of the plugin.
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
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function init() {
		// Handle ACF form submit.
		add_action( 'acf/save_post', [ $this, 'set_thumbnail' ], 15 );
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
}