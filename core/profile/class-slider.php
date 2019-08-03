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
		add_image_size( 'gamos', 300, 300, true );
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
		$lib_path = GAMOS_URL . 'app/assets/vendor/lightslider';

		wp_register_style( 'gamos_lightslider', $lib_path . '/css/lightslider.min.css' );

		wp_register_script( 'gamos_lightslider', $lib_path . '/js/lightslider.min.js', [ 'jquery' ] );
	}

	/**
	 * Render lightslider image slider for profile.
	 *
	 * @param array  $image_urls Image links.
	 * @param string $name       Profile name for alt.
	 *
	 * @since 1.0.1
	 */
	public function render_slider( $image_urls, $name = '' ) {
		$this->render_scripts();
		?>
        <div class="gamos-profile-image-slider">
            <ul id="lightSlider">
				<?php foreach ( $image_urls as $url ) : ?>
                    <li><img alt="<?php echo esc_attr( $name ); ?>" src="<?php echo $url; ?>" width="300" height="300"/>
                    </li>
				<?php endforeach; ?>
            </ul>
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
		wp_enqueue_style( 'gamos_lightslider' );
		wp_enqueue_script( 'gamos_lightslider' );

		// Custom styles and scripts.
		wp_add_inline_style( 'gamos_lightslider', '.gamos-profile-image-slider{width:300px}ul{list-style:none outside none;padding-left:0;margin-bottom:0}li{display:block;float:left;margin-right:6px;cursor:pointer}img{display:block;height:auto;max-width:100%}' );
		wp_add_inline_script( 'gamos_lightslider', 'jQuery("#lightSlider").lightSlider({gallery:!0,item:1,loop:!0,slideMargin:0,pager:0});' );
	}
}