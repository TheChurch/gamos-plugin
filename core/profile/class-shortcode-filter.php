<?php

namespace Gamos\Core\Profile;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The profile filter shortcode for the plugin.
 *
 * @link   http://gamos.in
 * @since  1.0.2
 *
 * @author Joel James <me@joelsays.com>
 */
class Shortcode_Filter extends Base {

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
		// Register styles and scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );

		// Filter profile query.
		add_action( 'pre_get_posts', [ $this, 'filter_profiles' ] );

		// Register custom query vars for profile.
		add_filter( 'query_vars', [ $this, 'profile_query_vars' ] );

		// Register shortcode.
		add_shortcode( 'gamos_profile_filter', [ $this, 'filter' ] );
	}

	/**
	 * Outputs the content of the shortcode.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function filter() {
		// Enqueue scripts and styles.
		wp_enqueue_style( 'select2' );
		wp_enqueue_script( 'select2' );

		// Get churches.
		$churches = get_terms( [
			'taxonomy'   => 'churches',
			'hide_empty' => false,
			'fields'     => 'id=>name',
		] );

		// Get query vars from request.
		$job       = get_query_var( 'profile_job', false );
		$church    = get_query_var( 'profile_church', false );
		$min_age   = get_query_var( 'profile_min_age', false );
		$max_age   = get_query_var( 'profile_max_age', false );
		$education = get_query_var( 'profile_education', false );

		ob_start();
		?>

        <div class="gamos-profile-filter">

            <form id="gamos-profile-filter-form" method="post" action="<?php echo site_url( 'profiles' ); ?>">

                <table>
                    <tr>
                        <th><label for="profile_min_age" class="filter-item-label"><?php esc_html_e( 'Min Age', 'gamos-plugin' ); ?></label></th>
                        <td>
                            <select name="profile_min_age" id="profile_min_age" class="gamos-select2">
                                <option value=""><?php esc_html_e( 'All', 'beyond2016-gamos' ); ?></option>
						        <?php foreach ( range( 18, 60 ) as $number ) : ?>
                                    <option value="<?php echo $number; ?>" <?php selected( $min_age, $number ); ?>><?php echo $number; ?></option>
						        <?php endforeach; ?>
                            </select>
                        </td>
                        <th><label for="profile_max_age" class="filter-item-label"><?php esc_html_e( 'Max Age', 'gamos-plugin' ); ?></label></th>
                        <td>
                            <select name="profile_max_age" id="profile_max_age" class="gamos-select2">
                                <option value=""><?php esc_html_e( 'All', 'beyond2016-gamos' ); ?></option>
						        <?php foreach ( range( 18, 60 ) as $number ) : ?>
                                    <option value="<?php echo $number; ?>" <?php selected( $max_age, $number ); ?>><?php echo $number; ?></option>
						        <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th><label for="profile_education" class="filter-item-label"><?php esc_html_e( 'Education', 'gamos-plugin' ); ?></label></th>
                        <td>
                            <select name="profile_education" id="profile_education" class="gamos-select2">
                                <option value=""><?php esc_html_e( 'All', 'beyond2016-gamos' ); ?></option>
                                <option value="none" <?php selected( $education, 'none' ); ?>><?php esc_html_e( 'None', 'gamos-plugin' ); ?></option>
                                <option value="hs" <?php selected( $education, 'hs' ); ?>><?php esc_html_e( 'High School', 'gamos-plugin' ); ?></option>
                                <option value="hsc" <?php selected( $education, 'hsc' ); ?>><?php esc_html_e( 'Higher Secondary', 'gamos-plugin' ); ?></option>
                                <option value="ug" <?php selected( $education, 'ug' ); ?>><?php esc_html_e( 'Graduate', 'gamos-plugin' ); ?></option>
                                <option value="pg" <?php selected( $education, 'pg' ); ?>><?php esc_html_e( 'Post Graduate', 'gamos-plugin' ); ?></option>
                                <option value="phd" <?php selected( $education, 'phd' ); ?>><?php esc_html_e( 'PhD', 'gamos-plugin' ); ?></option>
                            </select>
                        </td>
                        <th><label for="profile_job" class="filter-item-label"><?php esc_html_e( 'Job', 'gamos-plugin' ); ?></label></th>
                        <td>
                            <select name="profile_job" id="profile_job" class="gamos-select2">
                                <option value=""><?php esc_html_e( 'All', 'beyond2016-gamos' ); ?></option>
                                <option value="none" <?php selected( $job, 'none' ); ?>><?php esc_html_e( 'None', 'gamos-plugin' ); ?></option>
                                <option value="private" <?php selected( $job, 'private' ); ?>><?php esc_html_e( 'Private', 'gamos-plugin' ); ?></option>
                                <option value="govt" <?php selected( $job, 'govt' ); ?>><?php esc_html_e( 'Government', 'gamos-plugin' ); ?></option>
                                <option value="business" <?php selected( $job, 'business' ); ?>><?php esc_html_e( 'Business', 'gamos-plugin' ); ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th><label for="profile_church" class="filter-item-label"><?php esc_html_e( 'Church', 'gamos-plugin' ); ?></label></th>
                        <td>
                            <select name="profile_church" id="profile_church" class="gamos-select2">
                                <option value=""><?php esc_html_e( 'All', 'beyond2016-gamos' ); ?></option>
			                    <?php foreach ( $churches as $id => $name ) : ?>
                                    <option value="<?php echo $id; ?>" <?php selected( $church, $id ); ?>><?php echo $name; ?></option>
			                    <?php endforeach; ?>
                            </select>
                        </td>
                        <th colspan="2">
                            <button type="submit" value="submit"><?php esc_html_e( 'Search', 'gamos-plugin' ); ?></button>
                        </th>
                    </tr>
                </table>

            </form>

        </div>

		<?php
		$content = ob_get_contents();

		ob_end_clean();

		return $content;
	}

	/**
	 * Register select2 library styles and scripts.
	 *
	 * @since 1.0.2
	 *
	 * @return void
	 */
	public function register_assets() {
		// Only if not registered.
		if ( ! wp_script_is( 'select2', 'registered' ) ) {
			// Select2 base url.
			$lib_path = GAMOS_URL . 'app/assets/vendor/select2';

			wp_register_style( 'select2', $lib_path . '/css/select2.min.css' );

			wp_register_script( 'select2', $lib_path . '/js/select2.min.js', [ 'jquery' ] );

			// Add init script as inline.
			wp_add_inline_script( 'select2', 'jQuery(document).ready(function(){jQuery(".gamos-select2").select2({width:"100%"})});' );

			// Add init script as inline.
			wp_add_inline_style( 'select2', '#gamos-profile-filter-form button{width:100%;}' );
		}
	}

	/**
	 * Filter profile query based on the request.
	 *
	 * We need to check if the current $_POST request has the
	 * custom query vars set. If so, we need to add them to the
	 * WP_Query and filter the result.
	 *
	 * @param \WP_Query $query Query params.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function filter_profiles( $query ) {
		// Bail early if is in admin or not main query.
		if ( is_admin() && ! $query->is_main_query() ) {
			return;
		}

		// Get meta query.
		$meta_query = (array) $query->get( 'meta_query' );

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
			$meta_query[] = [
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
			$meta_query[] = [
				'key'     => 'date_of_birth',
				'value'   => $age_to,
				'compare' => '>=',
			];
		}

		// Church query.
		if ( $church ) {
			// Setup meta query.
			$meta_query[] = [
				'key'   => 'church',
				'value' => $church,
			];
		}

		// Job query.
		if ( $job ) {
			// Setup meta query.
			$meta_query[] = [
				'key'   => 'job',
				'value' => $job,
			];
		}

		// Education query.
		if ( $education ) {
			// Setup meta query.
			$meta_query[] = [
				'key'   => 'education',
				'value' => $education,
			];
		}

		// update meta query
		$query->set( 'meta_query', $meta_query );
	}

	/**
	 * Add our custom query vars for the profile filter.
	 *
	 * @param array $vars Custom vars.
	 *
	 * @since 1.0.2
	 *
	 * @return array
	 */
	public function profile_query_vars( $vars ) {
		$vars[] = 'profile_church';
		$vars[] = 'profile_min_age';
		$vars[] = 'profile_max_age';
		$vars[] = 'profile_education';
		$vars[] = 'profile_job';

		return $vars;
	}
}