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

    <h2><?php esc_html_e( 'Your Profile', 'gamos-plugin' ); ?></h2>

    <p><?php esc_html_e( 'This will be your public profile for the matrimonial site.', 'gamos-plugin' ); ?></p>


<?php echo do_shortcode( '[gamos_profile_registration field_groups="' . $fields . '"]' ); ?>