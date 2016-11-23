<?php
/**
 * Handle the API request to openweathermap.org
 *
 * @since 1.0.0
 */
namespace WSP;

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

class API {

	// API URL Base
	private $base_url;

	// Weather Station Plus options
	private $options;

	// Zip code to retreive weather for
	private $zip;

	public function __construct( $zip ) {

		if ( is_admin() ) {

			return;

		}

		$this->options  = wsp_get_options();
		$this->base_url = 'http://api.openweathermap.org/data/2.5/weather?zip=%1s,us&units=imperial&appid=%2s';
		$this->zip      = $zip;

	}

	/**
	 * Buid the API URL
	 *
	 * @return string API URL to retreive data from
	 */
	public function build_api_url() {

		return sprintf( $this->base_url, $this->zip, $this->options['api_key'] );

	}

	/**
	 * Feth the API results
	 *
	 * @param  string $base_url
	 *
	 * @return json           json array API results
	 *
	 * @since 1.0.0
	 */
	public function fetch_api_results() {

		$api_request = wp_remote_get( $this->build_api_url() );

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
