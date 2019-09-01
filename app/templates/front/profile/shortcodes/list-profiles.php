<?php

/**
 * List profiles template.
 *
 * @var WP_Query $query      Query instance.
 * @var array    $pagination Pagination.
 *
 * @since 1.1.0
 */

defined( 'WPINC' ) || die();

use Gamos\Core\Helper;

?>

<?php if ( isset( $query ) && $query->have_posts() ) : ?>

    <ul class="gamos-profile-grid">

		<?php while ( $query->have_posts() ) : $query->the_post(); ?>

			<?php
			// Render grid item template.
			Helper::view( 'front/profile/shortcodes/profile-grid-item', [
				'id'                => $query->current_post,
				'church'            => isset( get_field( 'church' )->name ) ? get_field( 'church' )->name : '',
				'education'         => get_field( 'education' ),
				'education_details' => get_field( 'education_details' ),
				'job'               => get_field( 'job' ),
				'job_details'       => get_field( 'job_details' ),
				'date_of_birth'     => Helper::get_dob( get_field( 'date_of_birth' ) ),
				'gender'            => get_field( 'gender' ),
			] );
			?>

		<?php endwhile; // End the loop. ?>

		<?php wp_reset_postdata(); // We need to do this. ?>

    </ul>

	<?php echo $pagination; ?>

<?php else : // No profile found. ?>

    <p><?php _e( 'Sorry, but no profiles found.', 'gamos-plugin' ); ?></p>

<?php endif; ?>
