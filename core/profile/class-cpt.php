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
}