<?php

/**
 * Single profile view template.
 *
 * @var WP_Query $query Query instance.
 *
 * @since 1.1.0
 */

defined( 'WPINC' ) || die();

use Gamos\Core\Helper;
use Gamos\Core\Profile\Slider;

?>

<!-- Personal details -->
<div class="gamos-profile-content">
    <h3 class="group-title"><?php esc_html_e( 'Personal Details', 'beyond2016-gamos' ); ?></h3>
    <table class="profile-content-table">
        <tr>
            <th><?php esc_html_e( 'Gender', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'gender' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Age', 'beyond2016-gamos' ); ?></th>
            <td>
				<?php echo Helper::get_dob( get_field( 'date_of_birth' ) ); ?>
				<?php esc_html_e( 'Years', 'beyond2016-gamos' ) ?>
            </td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Height', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'height' ); ?><?php esc_html_e( 'cm' ) ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Weight', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'weight' ); ?><?php esc_html_e( 'kg' ) ?></td>
        </tr>
    </table>
</div>
<!-- Personal details end -->

<!-- Profile images -->
<div class="gamos-profile-content gamos-profile-content-images">
    <?php echo Slider::instance()->profile_gallery( get_field( 'pictures' ) ); ?>
</div>
<!-- Profile images end -->

<!-- Professional details -->
<div class="gamos-profile-content">
    <h3 class="group-title"><?php esc_html_e( 'Professional Details', 'beyond2016-gamos' ); ?></h3>
    <table class="profile-content-table">
        <tr>
            <th><?php esc_html_e( 'Education', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'education' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Education Details', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'education_details' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Job', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'job' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Job Details', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'job_details' ); ?></td>
        </tr>
    </table>
</div>
<!-- Professional details end -->

<!-- Church details -->
<div class="gamos-profile-content">
    <h3 class="group-title"><?php esc_html_e( 'Church Details', 'beyond2016-gamos' ); ?></h3>
    <table class="profile-content-table">
        <tr>
            <th><?php esc_html_e( 'Church', 'beyond2016-gamos' ); ?></th>
            <td><?php echo get_field( 'church' )->name; ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Elder Name', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'elders_name' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Elder Contact', 'beyond2016-gamos' ); ?></th>
            <td>
                <a href="tel:<?php the_field( 'elder_contact_number' ); ?>"><?php the_field( 'elder_contact_number' ); ?></a>
            </td>
        </tr>
    </table>
</div>
<!-- Church details end -->

<!-- Family details -->
<div class="gamos-profile-content">
    <h3 class="group-title"><?php esc_html_e( 'Family Details', 'beyond2016-gamos' ); ?></h3>
    <table class="profile-content-table">
        <tr>
            <th><?php esc_html_e( 'Father\'s Name', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'fathers_name' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Father\'s Occupation', 'beyond2016-gamos' ); ?></th>
            <td><?php the_field( 'fathers_occupation' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Parent\'s Contact', 'beyond2016-gamos' ); ?></th>
            <td>
                <a href="tel:<?php the_field( 'elder_contact_number' ); ?>"><?php the_field( 'parents_contact_number' ); ?></a>
            </td>
        </tr>
    </table>
</div>
<!-- Family details end -->
