<?php

namespace Gamos\Core\Profile\Shortcodes;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use WP_Query;
use Gamos\Core\Helper;
use Gamos\Core\Utils\Abstracts\Base;

/**
 * The profile list shortcode for the plugin.
 *
 * @link   http://gamos.in
 * @since  1.0.2
 *
 * @author Joel James <me@joelsays.com>
 */
class List_Profiles extends Base {

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
		add_shortcode( 'gamos_profile_list', [ $this, 'list_profiles' ] );
	}

	/**
	 * Get all profiles added by current user.
	 *
	 * @since 1.0.2
	 *
	 * @return string
	 */
	public function list_profiles() {
		wp_enqueue_style( 'gamos-front' );
		wp_enqueue_script( 'gamos-front' );

		// Render template.
		$content = Helper::view( 'front/profile/shortcodes/list-profiles', [
			'query' => $this->get_query(),
		], true );

		return $content;
	}

	/**
	 * Filter profile query based on the request.
	 *
	 * We need to check if the current $_POST request has the
	 * custom query vars set. If so, we need to add them to the
	 * WP_Query and filter the result.
	 *
	 * @since 1.0.1
	 *
	 * @return WP_Query
	 */
	public function get_query() {
		// Create new query instance.
		$args = [
			'post_type'   => 'profile',
			'post_status' => [ 'publish' ],
		];

		// Get the query var values from request.
		$job       = get_query_var( 'profile_job', false );
		$church    = get_query_var( 'profile_church', false );
		$min_age   = get_query_var( 'profile_min_age', false );
		$max_age   = get_query_var( 'profile_max_age', false );
		$education = get_query_var( 'profile_education', false );

		// Min age query.
		if ( $min_age ) {
			// Create relative date from min age.
			$age_from = strtotime( '-' . (int) $min_age . ' year', time() );
			$age_from = date( 'Ymd', $age_from );
			// Setup meta query.
			$args['meta_query'][] = [
				'key'     => 'date_of_birth',
				'value'   => $age_from,
				'compare' => '<=',
			];
		}

		// Max age query.
		if ( $max_age ) {
			// Create relative date from min age.
			$age_to = strtotime( '-' . (int) $max_age . ' year', time() );
			$age_to = date( 'Ymd', $age_to );
			// Setup meta query.
			$args['meta_query'][] = [
				'key'     => 'date_of_birth',
				'value'   => $age_to,
				'compare' => '>=',
			];
		}

		// Church query.
		if ( $church ) {
			// Setup meta query.
			$args['meta_query'][] = [
				'key'   => 'church',
				'value' => $church,
			];
		}

		// Job query.
		if ( $job ) {
			// Setup meta query.
			$args['meta_query'][] = [
				'key'   => 'job',
				'value' => $job,
			];
		}

		// Education query.
		if ( $education ) {
			// Setup meta query.
			$args['meta_query'][] = [
				'key'   => 'education',
				'value' => $education,
			];
		}

		return new WP_Query( $args );
	}
}