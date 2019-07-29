<?php

namespace Gamos\Core\Controllers;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

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
			'name'                  => __( 'Profiles', 'gamos' ),
			'singular_name'         => __( 'Profile', 'gamos' ),
			'menu_name'             => __( 'Profiles', 'gamos' ),
			'name_admin_bar'        => __( 'Profile', 'gamos' ),
			'add_new'               => __( 'Add New', 'gamos' ),
			'add_new_item'          => __( 'Add New Profile', 'gamos' ),
			'new_item'              => __( 'New Profile', 'gamos' ),
			'edit_item'             => __( 'Edit Profile', 'gamos' ),
			'view_item'             => __( 'View Profile', 'gamos' ),
			'all_items'             => __( 'All Profiles', 'gamos' ),
			'search_items'          => __( 'Search Profiles', 'gamos' ),
			'parent_item_colon'     => __( 'Parent Profiles:', 'gamos' ),
			'not_found'             => __( 'No profles found.', 'gamos' ),
			'not_found_in_trash'    => __( 'No profles found in Trash.', 'gamos' ),
			'featured_image'        => __( 'Profile Image', 'gamos' ),
			'set_featured_image'    => __( 'Set profile image', 'gamos' ),
			'remove_featured_image' => __( 'Remove profile image', 'gamos' ),
			'use_featured_image'    => __( 'Use as profile image', 'gamos' ),
			'archives'              => __( 'Profile archives', 'gamos' ),
			'insert_into_item'      => __( 'Insert into profile', 'gamos' ),
			'uploaded_to_this_item' => __( 'Uploaded to this profile', 'gamos' ),
			'filter_items_list'     => __( 'Filter profiles list', 'gamos' ),
			'items_list_navigation' => __( 'Profiles list navigation', 'gamos' ),
			'items_list'            => __( 'Profiles list', 'gamos' ),
		];

		$args = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'profile' ],
			'capability_type'    => 'post',
			'has_archive'        => true,
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
			'name'          => __( 'Church', 'gamos' ),
			'singular_name' => __( 'Church', 'gamos' ),
			'search_items'  => __( 'Search Churches', 'gamos' ),
			'all_items'     => __( 'All Churches', 'gamos' ),
			'edit_item'     => __( 'Edit Church', 'gamos' ),
			'update_item'   => __( 'Update Church', 'gamos' ),
			'add_new_item'  => __( 'Add New Church', 'gamos' ),
			'new_item_name' => __( 'New Church Name', 'gamos' ),
			'menu_name'     => __( 'Churches', 'gamos' ),
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
			$title = __( 'Full name', 'gamos' );
		}

		return $title;
	}
}