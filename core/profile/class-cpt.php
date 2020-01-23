<?php

namespace Gamos\Core\Profile;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Helper;
use Gamos\Core\Utils\Abstracts\Base;

/**
 * The custom post type class of the plugin.
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <me@joelsays.com>
 */
class CPT extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 3.2.0
	 *
	 * @return void
	 */
	public function init() {
		// Register profiles cpt.
		add_action( 'init', [ $this, 'profile' ] );

		// Register church taxonomy.
		add_action( 'init', [ $this, 'churches' ] );

		// Change title place holder.
		add_filter( 'enter_title_here', [ $this, 'profile_title' ], 20, 2 );

		// Override profile single view content.
		add_filter( 'the_content', [ $this, 'profile_view' ] );

		// Show default image for thumbnail if no images found.
		add_filter( 'post_thumbnail_html', [ $this, 'default_thumbnail' ], 10, 5 );

		add_action( 'init', [ $this, 'add_thumb_size' ] );

		// Register custom status.
		add_action( 'init', [ $this, 'profile_statuses' ] );

		// Show custom statuses.
		add_action( 'admin_footer-post.php', [ $this, 'show_post_status' ] );
		add_action( 'admin_footer-edit.php', [ $this, 'show_edit_status' ] );
	}

	/**
	 * Show married status in profile edit form status section.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	public function show_post_status() {
		global $post;

		if ( 'profile' === $post->post_type ) {
			$label    = 'married' === $post->post_status ? ' selected="selected"' : '';
			$selected = 'married' === $post->post_status ? __( 'Married', 'gamos-plugin' ) : '';
			?>
            <script>
				jQuery(document).ready(function () {
					jQuery('#post-status-display').append('<?php echo $label; ?>');
					jQuery('#post_status').append('<option value="married" <?php echo $selected; ?>><?php esc_html_e( 'Married', 'gamos-plugin' ); ?></option>');
				});
            </script>
			<?php
		}

	}

	/**
	 * Show married status in quick edit form status section.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	public function show_edit_status() {
		global $post;

		if ( 'profile' === $post->post_type ) {
			?>
            <script>
				jQuery(document).ready(function () {
					jQuery('select[name="_status"]').append('<option value="married"><?php esc_html_e( 'Married', 'gamos-plugin' ); ?></option>');
				});
            </script>
			<?php
		}

	}

	/**
	 * Register a custom post type called "profile".
	 *
	 * @since 1.0
	 *
	 * @see   get_post_type_labels() for label keys.
	 *
	 * @return void
	 */
	public function profile() {
		$labels = [
			'name'                  => __( 'Profiles', 'gamos-plugin' ),
			'singular_name'         => __( 'Profile', 'gamos-plugin' ),
			'menu_name'             => __( 'Profiles', 'gamos-plugin' ),
			'name_admin_bar'        => __( 'Profile', 'gamos-plugin' ),
			'add_new'               => __( 'Add New', 'gamos-plugin' ),
			'add_new_item'          => __( 'Add New Profile', 'gamos-plugin' ),
			'new_item'              => __( 'New Profile', 'gamos-plugin' ),
			'edit_item'             => __( 'Edit Profile', 'gamos-plugin' ),
			'view_item'             => __( 'View Profile', 'gamos-plugin' ),
			'all_items'             => __( 'All Profiles', 'gamos-plugin' ),
			'search_items'          => __( 'Search Profiles', 'gamos-plugin' ),
			'parent_item_colon'     => __( 'Parent Profiles:', 'gamos-plugin' ),
			'not_found'             => __( 'No profles found.', 'gamos-plugin' ),
			'not_found_in_trash'    => __( 'No profles found in Trash.', 'gamos-plugin' ),
			'featured_image'        => __( 'Profile Image', 'gamos-plugin' ),
			'set_featured_image'    => __( 'Set profile image', 'gamos-plugin' ),
			'remove_featured_image' => __( 'Remove profile image', 'gamos-plugin' ),
			'use_featured_image'    => __( 'Use as profile image', 'gamos-plugin' ),
			'archives'              => __( 'Profile archives', 'gamos-plugin' ),
			'insert_into_item'      => __( 'Add into profile', 'gamos-plugin' ),
			'uploaded_to_this_item' => __( 'Uploaded to this profile', 'gamos-plugin' ),
			'filter_items_list'     => __( 'Filter profiles list', 'gamos-plugin' ),
			'items_list_navigation' => __( 'Profiles list navigation', 'gamos-plugin' ),
			'items_list'            => __( 'Profiles list', 'gamos-plugin' ),
		];

		$args = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => false,
			'rewrite'            => [ 'slug' => 'profiles' ],
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => [ 'title', 'author', 'thumbnail' ],
			'menu_icon'          => 'dashicons-groups',
		];

		// Register post type.
		register_post_type( 'profile', $args );
	}

	/**
	 * Register churches taxonomy for the profile cpt.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function churches() {
		$labels = [
			'name'          => __( 'Church', 'gamos-plugin' ),
			'singular_name' => __( 'Church', 'gamos-plugin' ),
			'search_items'  => __( 'Search Churches', 'gamos-plugin' ),
			'all_items'     => __( 'All Churches', 'gamos-plugin' ),
			'edit_item'     => __( 'Edit Church', 'gamos-plugin' ),
			'update_item'   => __( 'Update Church', 'gamos-plugin' ),
			'add_new_item'  => __( 'Add New Church', 'gamos-plugin' ),
			'new_item_name' => __( 'New Church Name', 'gamos-plugin' ),
			'menu_name'     => __( 'Churches', 'gamos-plugin' ),
		];

		$args = [
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'show_in_nav_menus' => false,
			'meta_box_cb'       => false,
			'rewrite'           => [ 'slug' => 'church' ],
		];

		// Register taxonomy.
		register_taxonomy( 'churches', 'profile', $args );
	}

	/**
	 * Add new custom status for profile post type.
	 *
	 * We need a married status for the profile.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	public function profile_statuses() {
		register_post_status( 'married', [
			'label'                     => __( 'Married', 'gamos-plugin' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Married <span class="count">(%s)</span>', 'Married <span class="count">(%s)</span>' ),
			'post_type'                 => [ 'profile' ],
		] );
	}

	/**
	 * Change profile post edit title placeholder text.
	 *
	 * @param string   $title Title text.
	 * @param \WP_Post $post  Post object.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function profile_title( $title, $post ) {
		// Change placeholder only for our cpt.
		if ( 'profile' === $post->post_type ) {
			$title = __( 'Full name', 'gamos-plugin' );
		}

		return $title;
	}

	/**
	 * Change profile view template content.
	 *
	 * @param string $content Profile content.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function profile_view( $content ) {
		// Only for profile.
		if ( get_post_type() !== 'profile' ) {
			return $content;
		}

		// Render template.
		$content = Helper::view( 'front/profile/single-profile', [
			'query' => [],
		], true );

		return $content;
	}

	/**
	 * Give default image if profile image is not set.
	 *
	 * @param string $html              Image html.
	 * @param int    $post_id           Post ID.
	 * @param int    $post_thumbnail_id Thumb id.
	 * @param string $size              Size name.
	 * @param array  $attr              Other attributes.
	 *
	 * @since 1.2.0
	 *
	 * @return string
	 */
	public function default_thumbnail( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		// Only if empty.
		if ( empty( $html ) && get_post_type( $post_id ) === 'profile' ) {
			// Get default thumbnail.
			$post_thumbnail_id = Helper::get_config( 'PROFILE_DEFAULT_THUMB' );

			// We are helpless if it is not defined.
			if ( empty( $post_thumbnail_id ) ) {
				return $html;
			}

			/**
			 * @see wp-includes/post-thumbnail-template.php
			 */
			do_action( 'begin_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );

			if ( in_the_loop() ) {
				update_post_thumbnail_cache();
			}

			// Get attachment image.
			$html = wp_get_attachment_image( $post_thumbnail_id, $size, false, $attr );

			/**
			 * @see wp-includes/post-thumbnail-template.php
			 */
			do_action( 'end_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );
		}

		return $html;
	}

	/**
	 * Add a custom thumbnail size for our slider.
	 *
	 * @since 1.0.1
	 */
	public function add_thumb_size() {
		add_image_size( 'gamos-profile', 260, 185, true );
	}
}