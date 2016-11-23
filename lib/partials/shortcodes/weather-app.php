<?php
/**
 * Handle the [weather_app] shortcode
 *
 * @author Code Parrots <codeparrots@gmail.com>
 *
 * @since 1.0.0
 */

ob_start();

$atts = shortcode_atts( [
	'zip' => false,
], $atts, 'weather_app' );

if ( ! $atts['zip'] ) {

	return __( 'Whoops, you forgot the zip code!', 'weather-app' );

}

if ( WP_DEBUG || false === ( $weather_response = get_transient( 'weather_app_api_results_' . $atts['zip'] ) ) ) {

	$api = new \WSP\API( $atts['zip'] );

	$weather_response = $api->fetch_api_results();

	set_transient( 'weather_app_api_results_' . $atts['zip'], $weather_response, 5 * MINUTE_IN_SECONDS );

}

if ( empty( $weather_response ) ) {

	return;

}

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

$contents = ob_get_contents();

ob_get_clean();

return $contents;
