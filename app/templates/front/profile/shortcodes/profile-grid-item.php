<?php

/**
 * List profiles grid single item template.
 *
 * @var int    $id                Current profile ID.
 * @var string $church            Church name.
 * @var string $education         Education.
 * @var string $education_details Education in detail.
 * @var string $job               Job.
 * @var string $job_details       Job in details.
 * @var string $date_of_birth     DOB.
 * @var string $gender            Gender.
 *
 * @since 1.1.0
 */

defined( 'WPINC' ) || die();

// Setup education details.
$education = empty( $education_details ) ? $education : $education_details;

// Setup job details.
if ( ! empty( $job_details ) ) {
	$job = $job_details . ' (' . $job . ')';
}

?>

<li class="gamos-profile-grid-item">

    <div class="gamos-profile-card">
        <div class="gamos-profile-card-image">
			<?php the_post_thumbnail( 'gamos-profile' ); ?>
        </div>
        <article class="gamos-profile-card-content">
            <h2 class="gamos-profile-card-title"><?php the_title( '', '' ); ?></h2>
            <div class="gamos-profile-card-body">
                <p class="gamos-profile-card-personal">
                    <strong>
						<?php echo $date_of_birth; ?>
						<?php echo $gender; ?>,
						<?php echo $church; ?>
                    </strong>
                </p>
                <p class="gamos-profile-card-profession">
                    <span class="gamos-profile-card-education">
                        <strong><?php esc_html_e( 'Education :', 'gamos-plugin' ); ?></strong> <?php echo $education; ?>
                    </span>
                    <span class="gamos-profile-card-job">
                        <strong><?php esc_html_e( 'Job :', 'gamos-plugin' ); ?></strong> <?php echo $job; ?>
                    </span>
                </p>
            </div>
            <div class="gamos-profile-card-footer">
                <a href="<?php the_permalink(); ?>">
                    <button><?php esc_html_e( 'View Profile', 'gamos-plugin' ); ?></button>
                </a>
            </div>
        </article>
    </div>

</li>
