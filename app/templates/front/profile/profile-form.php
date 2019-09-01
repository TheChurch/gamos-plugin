<?php

/**
 * Profile form template.
 *
 * @var array $groups Field group IDs.
 *
 * @since 1.2.0
 */

defined( 'WPINC' ) || die();

$fields = empty( $groups ) ? '' : implode( ',', $groups );

?>

<?php if ( current_user_can( 'manage_options' ) ) : // Admin can manage in backend. ?>

    <p><?php printf( __( 'As an admin user, you can manage all profiles including your profile. <a href="%s">Click here</a> to manage profiles.', 'gamos-plugin' ), admin_url( 'edit.php?post_type=profile' ) ); ?></p>

<?php else : // Non admin user's can manage their profile. ?>

    <h2><?php esc_html_e( 'Your Profile', 'gamos-plugin' ); ?></h2>

    <p><?php esc_html_e( 'This will be your public profile for the matrimonial site.', 'gamos-plugin' ); ?></p>


	<?php echo do_shortcode( '[gamos_profile_registration field_groups="' . $fields . '"]' ); ?>

<?php endif; ?>
