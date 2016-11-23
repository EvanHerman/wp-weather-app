<?php
/**
 * Generate the admin menus
 *
 * @since 1.0.0
 */
namespace WSP;

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

final class Admin_Menus {

	public function __construct() {

		if ( ! is_admin() ) {

			return;

		}

	}

	/**
	 * Register the settings page
	 * @return [type] [description]
	 */
	public function settings_page() {

		add_submenu_page(
			'options-general.php',
			__( 'Weather Station Plus', 'weather-station-plus' ),
			__( 'Weather Station Plus', 'weather-station-plus' ),
			'manage_options',
			'weather-station-plus',
			[ $this, 'render_settings_page' ]
		);

	}

	public function render_settings_page() {

		ob_start();

		require_once( WSP_PATH . 'partials/admin/settings.php' );

		return ob_get_contents();

	}

}
