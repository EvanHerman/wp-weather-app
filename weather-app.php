<?php
/**
 * @package Weather App
 */
/*
Plugin Name: Weather App
Plugin URI: https://weather.com/
Description: Weather App!
Version: 1.0.0
Author: Evan Herman
Author URI: http://www.derp.com
License: GPLv2 or later
Text Domain: weather-app
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2016 The People
*/

class Weather_App {

	// The API Key Instance
	private $api_key;

	private $base_url;

	public function __construct() {

		/**
		 * API Keys can be retrieved from http://openweathermap.org/appid
		 *
		 * @var string
		 */
		$this->api_key = 'your-api-key';

		$this->base_url = 'http://api.openweathermap.org/data/2.5/weather?zip=%s,us&units=imperial&appid=' . $this->api_key;

		require_once( plugin_dir_path( __FILE__ ) . '/widgets/basic-weather.php' );

		add_shortcode( 'weather_app', [ $this, 'render_weather_app' ] );

	}

	public function render_weather_app( $atts ) {

		if ( is_admin() ) {

			return;

		}

		ob_start();

		$atts = shortcode_atts( [
			'zip' => false,
		], $atts, 'weather_app' );

		if ( ! $atts['zip'] ) {

			return __( 'Whoops, you forgot the zip code!', 'weather-app' );

		}

		$base_url = $this->build_api_url( $atts['zip'] );

		if ( false === ( $weather_response = get_transient( 'weather_app_api_results_' . $atts['zip'] ) ) ) {

			$weather_response = $this->fetch_api_results( $base_url, $atts['zip'] );

			set_transient( 'weather_app_api_results_' . $atts['zip'], $weather_response, 5 * MINUTE_IN_SECONDS );

		}

		wp_enqueue_style( 'weather-icons', plugin_dir_url( __FILE__ ) . 'css/weather-icons.min.css' );

		if ( ! empty( $weather_response ) ) {

			$weather   = $weather_response['weather'];
			$temp_data = $weather_response['main'];
			$wind_data = $weather_response['wind'];
			$sys_data  = $weather_response['sys'];

			?>

			<section class="weather-data">

				<h2><?php echo esc_html( $weather_response['name'] ); ?></h2>
				<small><i class="icon wi-sunrise weather-icon"></i> <?php _e( 'Sunrise:', 'weather-app' ); ?> <?php echo date( 'h:iA', $sys_data['sunrise'] ); ?></small>
				|
				<small><i class="icon wi-sunset weather-icon"></i> <?php _e( 'Sunset:', 'weather-app' ); echo date( 'h:iA', $sys_data['sunset'] ); ?></small>

				<ul class="returned-data">

					<li>
						<strong><?php esc_html_e( 'Current Temperature:', 'weather-app' ); ?></strong>
						<?php printf( __( '%s%s', 'weather-app' ), $temp_data['temp'], '<i class="icon wi-fahrenheit weather-icon"></i>' ); ?>
					</li>

					<li>
						<strong><?php esc_html_e( 'Temperature Range:', 'weather-app' ); ?></strong>
						<?php printf( __( 'Min: %s Max: %s', 'weather-app' ), $temp_data['temp_min'] . '<i class="icon wi-fahrenheit weather-icon"></i>', $temp_data['temp_max'] . '<i class="icon wi-fahrenheit weather-icon"></i>' ); ?>
					</li>

					<li>
						<strong><?php esc_html_e( 'Current Humidity:', 'weather-app' ); ?></strong>
						<?php printf( __( '%s%s', 'weather-app' ), '%', $temp_data['humidity'] ); ?>
					</li>

					<li>
						<strong><?php esc_html_e( 'Pressure:', 'weather-app' ); ?></strong>
						<?php printf( __( '%s hPa', 'weather-app' ), $temp_data['pressure'] ); ?>
					</li>

				</ul>

			</section>
			<?php

		}

		$contents = ob_get_contents();

		ob_get_clean();

		return $contents;

	}

	public function build_api_url( $zip ) {

		return sprintf( $this->base_url, $zip );

	}

	public function fetch_api_results( $base_url, $zip ) {

		$api_request = wp_remote_get( $base_url );

		if ( is_wp_error( $api_request ) ) {

			return __( 'We encountered an an error in sendnig your request!', 'weather-app' );

		}

		$api_body = wp_remote_retrieve_body( $api_request );

		if ( is_wp_error( $api_body ) ) {

			return __( 'We encountered an error retrieving the body of the API request.', 'weather-app' );

		}

		return json_decode( $api_body, true );

	}

}
$weather_app = new Weather_app();
