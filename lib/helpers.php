<?php
/**
 * Weather Station Plus Helper Functions
 *
 * @since 1.0.0
 */

/**
 * Load the plugin assets
 *
 * @since 1.0.0
 */
function wsp_load_assets() {

	if ( WP_DEBUG ) {

		wp_enqueue_style( 'weather-icons',      WSP_PATH . "assets/css/weather-icons.css" );
		wp_enqueue_style( 'weather-icons-wind', WSP_PATH . "assets/css/weather-icons-wind.css" );

	}

	wp_enqueue_style( 'weather-icons', WSP_URL . 'assets/css/weather-icons-combined.min.css' );

}

/**
 * Generate an SVG icon
 *
 * @param  string $icon_type Icon to generate.
 *
 * @return mixed             HTML markup for the icon
 */
function wsp_generate_icon( $icon_type, $class = [ 'wsp-icon' ] ) {

	if ( ! $icon_type ) {

		return;

	}

	$icon_path = WSP_PATH . "assets/svg/weather-icons/{$icon_type}.svg";

	if ( ! file_exists( $icon_path ) ) {

		return;

	}

	$background = 'background: url(' . WSP_URL . "assets/svg/weather-icons/{$icon_type}.svg" . ') no-repeat; background: none, url(' . WSP_URL . "assets/svg/weather-icons/{$icon_type}.svg" . ') no-repeat; background-size: contain;';

	return '<i class="' . implode( ' ', $class ) . '" style="' . $background . '"></i>';

}

/**
 * Get the Weather Station Plus options
 *
 * @param  string $option  The option to return.
 *
 * @return string/array    The specified option, or the full array of options
 *
 * @since 1.0.0
 */
function wsp_get_options( $option = '' ) {

	$options = get_option( 'weather_station_plus', [
		'title'   => '',
		'api_key' => false,
	] );

	if ( ! empty( $option ) ) {

		return isset( $options[ $option ] ) ? $options[ $option ] : '';

	}

	return $options;

}
