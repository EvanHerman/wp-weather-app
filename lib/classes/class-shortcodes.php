<?php
/**
 * Handle the processing of our shortcodes
 *
 * @since 1.0.0
 */
namespace WSP;

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

class Shortcodes {

	public function __construct() {

		if ( is_admin() ) {

			return;

		}

		add_shortcode( 'weather_app', [ $this, 'render_weather_app' ] );

	}

	/**
	 * Render the weather app [weather_app]
	 *
	 * @return mixed HTML markup for the [weather_app] shortcode
	 */
	public function render_weather_app( $atts ) {

		return include( WSP_PATH . 'partials/shortcodes/weather-app.php' );

	}

}
