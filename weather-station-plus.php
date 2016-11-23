<?php
/**
#_________________________________________________ PLUGIN
Plugin Name: Weather Station Plus
Plugin URI: https://www.wp-timelineexpress.com
Description: Weather station plus is a sweet plugin that does amazing things!
Version: 1.0.0
Author: Code Parrots
Author URI: http://www.codeparrots.com
License: GPL2
Text Domain: weather-station-plus
#_________________________________________________ LICENSE
Copyright 2012-16 Code Parrots (email : codeparrots@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

#_________________________________________________ CONSTANTS
*/

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

if ( ! class_exists( 'Weather_Station_Plus' ) ) {

	final class Weather_Station_Plus {

		/**
		 * Minimum PHP version
		 *
		 * @var string
		 */
		private $php_min_version = '5.4.0';

		/**
		 * Plguin Data
		 *
		 * @var array
		 */
		public static $plugin_data;

		public function __construct( $cur_php_version = PHP_VERSION ) {

			static::$plugin_data = $this->get_plugin_data();

			require_once __DIR__ . '/lib/classes/autoload.php';

			require_once __DIR__ . '/lib/constants.php';

			add_action( 'plugins_loaded', [ $this, 'i18n' ] );

			add_action( 'admin_menu', [ new WSP\Admin_Menus, 'settings_page' ] );

			if ( version_compare( $cur_php_version, $this->php_min_version, '<' ) ) {

				new WSP\Notice( 'error', sprintf(
					__( 'WP Weather Station requires PHP version %s or higher. Please contact your system administrator to upgrade your version of PHP.', 'weather-station-plus' ),
					esc_html( $this->php_min_version )
				), true );

			}

			// WSP\Test_Die( 'Testing' );

		}

		/**
		 * Load languages
		 *
		 * @action plugins_loaded
		 */
		public function i18n() {

			load_plugin_textdomain( 'weather-station-plus', false, dirname( plugin_basename( __FILE__ ) ) . '/lib/languages' );

		}

		/**
		 * Get the plugin data from the plugin header in this file
		 *
		 * @return array Data from the plugin header.
		 *
		 * @since 1.0.0
		 */
		public function get_plugin_data() {

			if ( ! function_exists( 'get_plugins' ) ) {

				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			}

			$plugin_data = get_plugin_data( __FILE__ );

			$plugin_data['base'] = plugin_basename( __FILE__ );

			return $plugin_data;

		}

	}

	new Weather_Station_Plus;

}
