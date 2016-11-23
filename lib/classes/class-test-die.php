<?php
/**
 * This is used as an example file
 *
 * @since 1.0.0
 */
namespace WSP;

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

class Test_Die {

	public function __construct( $text = 'Default Die Text' ) {

		wp_die( $text );

		exit;

	}

}
