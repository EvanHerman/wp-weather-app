<?php
/**
 * Constants
 */

 if ( ! defined( 'WSP_VERSION' ) ) {

 	define ( 'WSP_VERSION', '1.0.0' );

 }

 if ( ! defined( 'WSP_URL' ) ) {

 	define ( 'WSP_URL', plugin_dir_url( __FILE__ ) );

 }

 if ( ! defined( 'WSP_PATH' ) ) {

 	define ( 'WSP_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

 }

if ( ! defined( 'WSP_ASSETS_URL' ) ) {

	define ( 'WSP_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/' );

}

if ( ! defined( 'WSP_ASSETS_PATH' ) ) {

	define ( 'WSP_ASSETS_PATH', plugin_dir_path( __FILE__ ) . 'assets/' );

}
