<?php

function capitol_words_settings_page() {

	return new CAPITOL_WORDS_SETTINGS();

}

add_action('init', 'capitol_words_settings_page' );

class CAPITOL_WORDS_SETTINGS {

	public function __construct() {

		add_action( 'admin_init', array( $this, 'capitol_words_settings_init') );
		add_action( 'admin_menu', array( $this, 'capitol_words_settings_menu') );

	}
	public function capitol_words_settings_menu() {
		add_options_page( 
			'Capitol Words Chart\'s Settings', 
			__( 'Capitol Words', 'capitol-words' ), 
			'edit_posts', 
			'capitol-words-settings', 
			array( $this, 'capitol_words_settings_page_callback')
			);
	}
	public function capitol_words_settings_init() {
		//register the settings group and the settings themselves
		register_setting( 'capitol-words-settings', 'capitol_words_settings' );

		//create a settings section - there can be multiple settings sections, just make sure you attribute
		//the settings fields to the sections you want
		add_settings_section( 
			'capitol-words-api-settings', 
			__( 'Capitol Words API Settings', 'capitol-words'  ), 
			array( $this, 'capitol_words_api_settings_section_callback' ), 
			'capitol-words-settings' );

		add_settings_section( 
			'capitol-words-chart-settings', 
			__( 'Capitol Words Chart Settings', 'capitol-words'  ), 
			array( $this, 'capitol_words_chart_settings_section_callback' ), 
			'capitol-words-settings' );

		//create the settings fields, associate them with the required settings sections
		add_settings_field( 
			'settings-fields-id', 
			__('Chart Settings', 'capitol-words' ), 
			array( $this, 'capitol_words_chart_settings_fields_callback' ), 
			'capitol-words-settings', 
			'capitol-words-chart-settings' );

		add_settings_field( 
			'settings-fields-id', 
			__('API Settings', 'capitol-words' ), 
			array( $this, 'capitol_words_api_settings_fields_callback' ), 
			'capitol-words-settings', 
			'capitol-words-api-settings' );
		
	}

	public function capitol_words_api_settings_section_callback() {

			echo __('<p>Please enter your API key from the <a href="https://sunlightfoundation.com/api/accounts/register/">Sunlight Foundation</a> website.</p>', 'capitol-words');
	
	}

	public function capitol_words_chart_settings_section_callback() {

			echo __('<p>Some language will eventually go here</p>', 'capitol-words');

	}

	public function capitol_words_api_settings_fields_callback() {


		$settings = (array) get_option('capitol_words_settings');

		if ( isset( $settings[ 'api_key' ] ) ) {
			$api_key = $settings[ 'api_key' ];
		} else {
			$api_key ='';
		}

		?>

			<p>
				<input type="text" name="capitol_words_settings[api_key]" value="<?php echo $api_key; ?>" />
			</p>

		<?php

	}

	public function capitol_words_chart_settings_fields_callback() {

		$settings = (array) get_option('capitol_words_settings');

		if ( isset( $settings[ 'color'] ) ) {
			$color = $settings[ 'color'];
		} else {
			$color ='';
		}

		if ( isset( $settings[ 'post_meta_box'] ) ) {
			$post_meta_box = $settings[ 'post_meta_box' ];
		} else {
			$post_meta_box ='';
		}

		?>

			<p>
				<input type="text" name='capitol_words_settings[color]' value="<?php echo $color; ?>" class="my-color-field" />
			</p>

			<p>
				<p><?php echo __('Show the Post Meta Box so that you can preview and automatically create a chart?', 'capitol-words' )?></p>
				<input type="checkbox" name="capitol_words_settings[post_meta_box]" value="1" <?php checked( $post_meta_box, 1 ); ?> />
			</p>

		<?php


	}

	public function capitol_words_settings_page_callback() {

		//just to make sure
		if ( !current_user_can( 'edit_posts' ) ) {

			$message = __( 'Sorry, you do not have sufficient permissions to edit this page', 'capitol-words' );
			wp_die( $message );

		}

		?>
		<div class='wrap'>

			<h2>Capitol Words Settings Page</h2>

			<form action='options.php' method='POST'>
				<?php 
					//output the settings fields using the settings group registered in register_settings
					settings_fields( 'capitol-words-settings' );
				?>
				<?php 
					//output the settings sections using the options page slug to grab everything
					//can optionally include individual sections here if needed
					do_settings_sections( 'capitol-words-settings' );
				?>
				<?php 
					//output the submit button for the <form> element
					submit_button( );
				?>
			</form>

		</div>
		<?php

	}
}

?>