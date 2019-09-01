<?php

namespace Gamos\Core\Profile;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use Gamos\Core\Utils\Abstracts\Base;

/**
 * The image gallery functionality of the plugin.
 *
 * @link   http://gamos.in
 * @since  1.0.0
 *
 * @author Joel James <me@joelsays.com>
 */
class Slider extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function init() {
		// Register lightbox plugin.
		add_action( 'wp_enqueue_scripts', [ $this, 'register_lightslider' ] );

		add_action( 'init', [ $this, 'add_thumb_size' ] );
	}

	/**
	 * Add a custom thumbnail size for our slider.
	 *
	 * @since 1.0.1
	 */
	public function add_thumb_size() {
		add_image_size( 'gamos-profile', 300, 300, true );
	}

	/**
	 * Register jQuery lightslider plugin.
	 *
	 * @link  http://sachinchoolur.github.io/lightslider/
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function register_lightslider() {
		// Lightslider base url.
		$lib_path = GAMOS_URL . 'app/assets/vendor/magnific-popup';

		wp_register_style( 'gamos_slider', $lib_path . '/css/magnific-popup.min.css' );

		wp_register_script( 'gamos_slider', $lib_path . '/js/jquery.magnific-popup.min.js', [ 'jquery' ] );
	}

	/**
	 * Get gallery using lightbox plugin.
	 *
	 * @param array $images Images.
	 *
	 * @since 1.0.1
	 *
	 * @return string
	 */
	public function profile_gallery( array $images ) {
		// Basic requirement check.
		if ( empty( $images[0]['images'] ) ) {
			return '';
		} else {
			$image_urls = [];

			// Get image url.
			foreach ( $images as $image ) {
				$image_urls[] = $image['images']['url'];
			}
		}

		// Render gallery.
		return $this->render_slider( $image_urls );
	}

	/**
	 * Render lightslider image slider for profile.
	 *
	 * @param array  $image_urls Image links.
	 * @param string $name       Profile name for alt.
	 *
	 * @since 1.0.1
	 */
	private function render_slider( $image_urls, $name = 'Profile Image' ) {
		$this->render_scripts();

		// Images count.
		$count = count( $image_urls );

		?>

        <div class="gamos-profile-image-slider">
			<?php foreach ( $image_urls as $url ) : ?>
                <a href="<?php echo $url; ?>" title="<?php echo esc_attr( $name ); ?>">
                    <img alt="<?php echo esc_attr( $name ); ?>" src="<?php echo $url; ?>" height="300">
                </a>
			<?php endforeach; ?>
        </div>
		<?php
	}

	/**
	 * Render gallery scripts and styles.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	private function render_scripts() {
		// Slider assets.
		wp_enqueue_style( 'gamos_slider' );
		wp_enqueue_script( 'gamos_slider' );

		// Custom styles and scripts.
		wp_add_inline_script( 'gamos_slider', 'jQuery(document).ready(function(){jQuery(".gamos-profile-image-slider").magnificPopup({delegate:"a",type:"image",mainClass:"mfp-img-mobile",gallery:{enabled:!0,navigateByImgClick:!0,preload:[0,1]},image:{tError:\'<a href="%url%">The image #%curr%</a> could not be loaded.\'}})});' );
	}
}