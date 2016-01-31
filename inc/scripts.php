<?php 

	define('MAIN_CSS_VER', '0.1');

	function load_all_scripts() {

		wp_enqueue_style( 'handle', plugin_dir_url( __FILE__ ) . '../css/styles.css', array(), MAIN_CSS_VER, 'all' );
	}

?>