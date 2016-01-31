<?php
/*
	Plugin Name: Capitol Words Charts
	Plugin URI: https://profiles.wordpress.org/jsulz
	Description: A plugin that allows you to draw charts from the Capitol Words API using the chart.js library - see the README for more information
	Author: Jared Sulzdorf
	Version: 1.0
	Author URI: https://profiles.wordpress.org/jsulz
 */
	
// Peace out if you're trying to access this up front
if( ! defined( 'ABSPATH' ) ) exit;

//If this class don't exist, make it so
if( ! class_exists( 'CAPITOLWORDS_CHARTS' ) ) {

	class CAPITOLWORDS_CHARTS {

		private static $instance;

			//the magic
	        public static function instance() {

	            if( ! self::$instance ) {

	                self::$instance = new CAPITOLWORDS_CHARTS( );
	                self::$instance->plugin_constants( );
	                self::$instance->plugin_requires( );
	                add_action( 'wp_enqueue_scripts', array( self::$instance, 'load_all_scripts' ) );
	                //check when text domain can be queued up and load appropriately

	            }

	            return self::$instance;

	        }

	    //the constants (folders and such)
		public function plugin_constants() {

			//folders and files
			define( 'CAPITOLWORDS_CHARTS', plugin_dir_path( __FILE__ ) );
			define( 'CAPITOLWORDS_CHARTS_LOCAL', plugin_dir_url( __FILE__ ) );
			define( 'CAPITOLWORDS_INC', trailingslashit( CAPITOLWORDS_CHARTS . 'inc' ) );
			define( 'CAPITOLWORDS_CSS', trailingslashit( CAPITOLWORDS_CHARTS_LOCAL . 'css' ) );
			define( 'CAPITOLWORDS_JS', trailingslashit( CAPITOLWORDS_CHARTS_LOCAL . 'js' ) );
			define( 'CHARTJS', trailingslashit( CAPITOLWORDS_CHARTS_LOCAL . 'chartjs' ) );
			define( 'CAPITOLWORDS_SHORTCODES', CAPITOLWORDS_INC . 'shortcodes.php');
			define( 'CAPITOLWORDS_WIDGET', CAPITOLWORDS_INC . 'widget.php' );
			define( 'CAPITOLWORDS_API_CLIENT', CAPITOLWORDS_INC . 'client.php' );

			//Version constants
			define( 'MAIN_CSS_VER', 1.0 );
			define( 'MAIN_JS_VER', 1.0 );
			define( 'CHARTJS_VER', 1.02);

		}

		//the files
		public function plugin_requires() {

			require( CAPITOLWORDS_SHORTCODES );
			require( CAPITOLWORDS_WIDGET );
			require( CAPITOLWORDS_API_CLIENT );

		}
		//in case someone wants to translate stuff 
		//Need to refactor as I might need to load this differently similar to load_all_scripts()
		public function capitol_words_charts_load_plugin_textdomain() {

	    	load_plugin_textdomain( 'text-domain', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		}

		public function load_all_scripts() {

			wp_enqueue_style( 'capitolwords-styles', CAPITOLWORDS_CSS . 'styles.css', array(), MAIN_CSS_VER, 'all' );
			wp_enqueue_script( 'main-js', CAPITOLWORDS_JS . 'main.js', array('jquery'), MAIN_JS_VER, true );
			wp_enqueue_script( 'chartjs', CHARTJS . 'Chart.js', array(), CHARTJS_VER, false );
		
		}
		
	}

}

//get this show on the road
function capitol_words_charts() {

    return CAPITOLWORDS_CHARTS::instance( );
    
}

//Check to see if this can be done differently 
add_action( 'plugins_loaded', 'capitol_words_charts' );

?>