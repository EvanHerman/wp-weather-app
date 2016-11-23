<?php
/**
 * Settings Page
 *
 * @since 1.0.0
 */

wsp_load_assets();
?>

<div class="wrap">

	<h1><?php printf( esc_html__( '%s Weather Station Plus', 'weather-station-plus' ), wsp_generate_icon( 'day' ) ); ?></h1>

	<p class="description"> <?php esc_html_e( 'Edit the settings for weather station plus using the fields below:', 'weather-station-plus' ); ?> </p>

	<?php wsp_admin_tabs( filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING ) ); ?>

	<form method="post" action="options.php">

	<?php

		// This prints out all hidden setting fields
		settings_fields( 'wsp_option_group' );

		wsp_render_settings_section( filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING ) );

		submit_button();

	?>


	</form>

</div>

<?php
/**
 * Tab functions
 *
 * @param  string $current Current tab
 *
 * @return [type]          [description]
 */
function wsp_admin_tabs( $current = 'general-settings' ) {

	$current = empty( $current ) ? 'general-settings' : $current;

	$tabs = [
		'general-settings' => __( 'General Settings', 'weather-station-plus' ),
		'api-settings'     => __( 'API Settings', 'weather-station-plus' ),
	];

	echo '<div id="icon-themes" class="icon32"><br></div>';

	echo '<h2 class="nav-tab-wrapper">';

	foreach( $tabs as $tab => $name ) {

		$class = ( $tab == $current ) ? ' nav-tab-active' : '';

		echo "<a class='nav-tab{$class}' href='?page=weather-station-plus&tab={$tab}'>{$name}</a>";

	}

	echo '</h2>';

}

/**
 * Render the wsp settings section
 *
 * @param  string $section The section to render based on the $_GET['tab']
 *
 * @since 1.0.0
 */
function wsp_render_settings_section( $section = 'general-settings' ) {

	if ( empty( $section ) ) {

		do_settings_sections( 'wsp-general-settings' );

		return;

	}

	switch ( $section ) {

		default:
		case 'general-settings':

			$section = 'wsp-general-settings';

			break;

		case 'api-settings':

			$section = 'wsp-api-settings';

			break;

	}

	do_settings_sections( $section );

}
