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
    <h3 class="group-title"><?php esc_html_e( 'Personal Details', 'gamos-plugin' ); ?></h3>
    <table class="profile-content-table">
        <tr>
            <th><?php esc_html_e( 'Gender', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'gender' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Age', 'gamos-plugin' ); ?></th>
            <td>
				<?php echo Helper::get_dob( get_field( 'date_of_birth' ) ); ?>
				<?php esc_html_e( 'Years', 'gamos-plugin' ) ?>
            </td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Height', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'height' ); ?><?php esc_html_e( 'cm' ) ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Weight', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'weight' ); ?><?php esc_html_e( 'kg' ) ?></td>
        </tr>
    </table>
</div>
<!-- Personal details end -->

<?php $images = get_field( 'pictures' ); ?>

<!-- Profile images -->
<?php if ( ! empty( $images[0]['images'] ) ) : ?>

    <div class="gamos-profile-content gamos-profile-content-images">

		<?php if ( is_user_logged_in() ) : // Only logged in users can view images. ?>
			<?php echo Slider::instance()->profile_gallery( $images, get_the_title() ); ?>
		<?php else : ?>
            <div class="gamos-notice error">
                <p><?php printf( __( 'Please <a href="%s">login</a> to see the profile images.', 'gamos-plugin' ), site_url( 'login' ) ); ?></p>
            </div>
		<?php endif; ?>

    </div>

<?php endif; ?>
<!-- Profile images end -->

<!-- Professional details -->
<div class="gamos-profile-content">
    <h3 class="group-title"><?php esc_html_e( 'Professional Details', 'gamos-plugin' ); ?></h3>
    <table class="profile-content-table">
        <tr>
            <th><?php esc_html_e( 'Education', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'education' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Education Details', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'education_details' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Job', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'job' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Job Details', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'job_details' ); ?></td>
        </tr>
    </table>
</div>
<!-- Professional details end -->

<!-- Church details -->
<div class="gamos-profile-content">
    <h3 class="group-title"><?php esc_html_e( 'Church Details', 'gamos-plugin' ); ?></h3>
    <table class="profile-content-table">
        <tr>
            <th><?php esc_html_e( 'Church', 'gamos-plugin' ); ?></th>
            <td><?php echo get_field( 'church' )->name; ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Elder Name', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'elders_name' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Elder Contact', 'gamos-plugin' ); ?></th>
            <td>
                <a href="tel:<?php the_field( 'elder_contact_number' ); ?>"><?php the_field( 'elder_contact_number' ); ?></a>
            </td>
        </tr>
    </table>
</div>
<!-- Church details end -->

<!-- Family details -->
<div class="gamos-profile-content">
    <h3 class="group-title"><?php esc_html_e( 'Family Details', 'gamos-plugin' ); ?></h3>
    <table class="profile-content-table">
        <tr>
            <th><?php esc_html_e( 'Father\'s Name', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'fathers_name' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Father\'s Occupation', 'gamos-plugin' ); ?></th>
            <td><?php the_field( 'fathers_occupation' ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Parent\'s Contact', 'gamos-plugin' ); ?></th>
            <td>
                <a href="tel:<?php the_field( 'elder_contact_number' ); ?>"><?php the_field( 'parents_contact_number' ); ?></a>
            </td>
        </tr>
    </table>
</div>
<!-- Family details end -->
