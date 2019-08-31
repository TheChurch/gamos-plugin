<?php

/**
 * Profile filter template.
 *
 * @var string $job       Selected job.
 * @var string $church    Selected church.
 * @var int    $min_age   Minimum age.
 * @var int    $max_age   Maximum age.
 * @var string $education Education
 * @var array  $churches  Available churches.
 *
 * @since 1.1.0
 */

defined( 'WPINC' ) || die();

?>

<?php if ( isset( $churches ) ) : ?>

    <div class="gamos-profile-filter">

        <form id="gamos-profile-filter-form" method="post">

            <table>
                <tr>
                    <th>
                        <label for="profile_min_age" class="filter-item-label"><?php esc_html_e( 'Min Age', 'gamos-plugin' ); ?></label>
                    </th>
                    <td>
                        <select name="profile_min_age" id="profile_min_age" class="gamos-select2">
                            <option value=""><?php esc_html_e( 'All', 'beyond2016-gamos' ); ?></option>
							<?php foreach ( range( 18, 60 ) as $number ) : ?>
                                <option value="<?php echo $number; ?>" <?php selected( $min_age, $number ); ?>><?php echo $number; ?></option>
							<?php endforeach; ?>
                        </select>
                    </td>
                    <th>
                        <label for="profile_max_age" class="filter-item-label"><?php esc_html_e( 'Max Age', 'gamos-plugin' ); ?></label>
                    </th>
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
                    <th>
                        <label for="profile_education" class="filter-item-label"><?php esc_html_e( 'Education', 'gamos-plugin' ); ?></label>
                    </th>
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
                    <th>
                        <label for="profile_job" class="filter-item-label"><?php esc_html_e( 'Job', 'gamos-plugin' ); ?></label>
                    </th>
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
                    <th>
                        <label for="profile_church" class="filter-item-label"><?php esc_html_e( 'Church', 'gamos-plugin' ); ?></label>
                    </th>
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

<?php endif; ?>
