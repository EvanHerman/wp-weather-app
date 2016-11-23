<?php

namespace WSP;

final class Settings
{
	/**
	* Holds the values to be used in the fields callbacks
	*/
	private $options;

	/**
	* Register and add settings
	*/
	public function settings_init() {

		$this->options = wsp_get_options();

		register_setting(
			'wsp_option_group',
			'weather_station_plus',
			array( $this, 'sanitize' )
		);

		$this->register_general_settings();

		$this->register_api_settings();

	}

	/**
	 * Register the general settings section & settings
	 *
	 * @since 1.0.0
	 */

	public function register_general_settings() {

		add_settings_section(
			'wsp_general_settings',
			__( 'General Settings', 'weather-station-plus' ),
			[ $this, 'print_general_settings_description' ],
			'wsp-general-settings'
		);

		add_settings_field(
			'title',
			'Title',
			[ $this, 'text_field' ],
			'wsp-general-settings',
			'wsp_general_settings',
			[
				'id' => 'title',
			]
		);

	}

	/**
	 * Register the API settings section & settings
	 *
	 * @since 1.0.0
	 */
	public function register_api_settings() {

		add_settings_section(
			'wsp_api_settings',
			__( 'API Settings', 'weather-station-plus' ),
			[ $this, 'print_api_settings_description' ],
			'wsp-api-settings'
		);

		add_settings_field(
			'api_key',
			__( 'API Key', 'weather-station-plus' ),
			[ $this, 'number_field' ],
			'wsp-api-settings',
			'wsp_api_settings',
			[
				'id'   => 'api_key',
				'type' => 'password'
			]
		);

	}

	/**
	* Sanitize each setting field as needed
	*
	* @param array $input Contains all settings fields as array keys
	*/
	public function sanitize( $input ) {

		$new_input = array();

		$new_input['api_key'] = isset( $input['api_key'] ) ? sanitize_text_field( trim( $input['api_key'] ) ) : $this->options['api_key'];
		$new_input['title']   = isset( $input['title'] ) ? sanitize_text_field( $input['title'] ) : $this->options['title'];

		return $new_input;

	}

	/**
	* Print the Section text
	*/
	public function print_general_settings_description() {

		esc_attr_e( 'Edit the general settings below:' );

	}

	/**
	* Print the Section text
	*/
	public function print_api_settings_description() {

		esc_attr_e( 'Edit the API key settings below:' );

	}

	/**
	* Get the settings option array and print one of its values
	*/
	public function number_field( $args ) {

		$type = 'text';

		if ( isset( $args['type'] ) && 'password' === $args['type'] ) {

			if ( ! empty( $this->options[ $args['id'] ] ) ) {

				$type = 'password';

			}

		}

		printf(
			'<input type="%s" id="api_key" name="weather_station_plus[' . $args['id'] . ']" value="%s" />',
			esc_attr( $type ),
			isset( $this->options[ $args['id'] ] ) ? esc_attr( $this->options[ $args['id'] ] ) : ''
		);

	}

	/**
	* Get the settings option array and print one of its values
	*/
	public function text_field( $args ) {

		printf(
			'<input type="text" id="title" name="weather_station_plus[' .  $args['id']  . ']" value="%s" />',
			isset( $this->options[ $args['id'] ] ) ? esc_attr( $this->options[ $args['id'] ] ) : ''
		);

	}

}
