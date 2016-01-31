<?php

add_action( 'widgets_init', 'register_unique_widget_name' );

//register widget
function register_unique_widget_name() {
	register_widget( 'unique_widget_name' );
}

//Unique Widget Name Class
class Unique_Widget_Name extends WP_Widget {

	//Set up widget class name and description
	function __construct() {
		
		parent::__construct(
			__CLASS__,
			__('Unique Widget Title' , 'text_domain'),
			array ('description' 	=> __('This is a bit of text about my unique widget' , 'text_domain'), )
		);
	}

	//build the form
	function form( $instance ) {

		//first set up the default values in case $instance doesn't have all of them
		$defaults = array();
		$instance = wp_parse_args( ( array ) $instance, $defaults );

		//next set the values from the instance object to be unique variables so that they can be used in the form
		//here's an example of how to do this for the title

		//first set up a blank value for the variables that our defaults don't catch
		$title = '';
		//next, check to see if those values are actually set in $instance
		if ( isset( $instance['title'] ) ) {
			//if $instance has a value for that key, then set the blank variable to equal that value!
			$title = $instance['title'];
		}

		//then use that variable in the form
		?>

			<p>Title: 
				<input class='widefat' name="<?php echo $this->get_field_name( 'title' ); ?>" type='text' value="<?php echo esc_attr( $title ); ?>" />
			</p>

		<?php
	}

	//save the widget settings
	function update( $new_instance, $old_instance ) {

		//set the $instance object equal to an array
		$instance = array();
		//set up the $instance by checking the value of the new_instance to make sure the values passed in the form 
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;

	}

	//output the widget
	function widget( $args, $instance ) {

		//this gives us access to some default arguments that we can use to display standard WordPress information like $before_widget 
		extract($args);

		echo $before_widget;
		//output all of the information
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_title . $title . $after_title;



	}

}

?>