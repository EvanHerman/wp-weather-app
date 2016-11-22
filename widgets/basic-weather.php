<?php

// Creating the widget
class weather_app_basic_widget extends WP_Widget {

	function __construct() {

		parent::__construct(
			// Base ID of your widget
			'weather_app_basic_widget',

			// Widget name will appear in UI
			__( 'Basic Weather Widget', 'weather-app' ),

			// Widget description
			array( 'description' => __( 'Display weather for your zip code.', 'weather-app' ), )
		);

	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( ! isset( $instance['zip'] ) ) {

			return;

		}

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];

			if ( ! empty( $title ) ) {

				echo $args['before_title'] . $title . $args['after_title'];

			}

			echo do_shortcode( '[weather_app zip="' . $instance['zip'] . '"]' );

		echo $args['after_widget'];

	}

	// Widget Backend
	public function form( $instance ) {

		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Weather', 'weather-app' );
		$zip   = isset( $instance[ 'zip' ] ) ? $instance[ 'zip' ] : __( '07030', 'weather-app' );

		// Widget admin form
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'zip' ); ?>"><?php _e( 'Zip Code:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'zip' ); ?>" name="<?php echo $this->get_field_name( 'zip' ); ?>" type="text" value="<?php echo esc_attr( $zip ); ?>" />
		</p>

		<?php

	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['zip']   = ( ! empty( $new_instance['zip'] ) ) ? strip_tags( $new_instance['zip'] ) : '';

		return $instance;

	}

} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {

	register_widget( 'weather_app_basic_widget' );

}
add_action( 'widgets_init', 'wpb_load_widget' );
