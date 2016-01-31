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

			define( 'CAPITOLWORDS_CHARTS', plugin_dir_path( __FILE__ ) );
			define( 'CAPITOLWORDS_INC', trailingslashit( CAPITOLWORDS_CHARTS . 'inc' ) );
			define( 'CAPITOLWORDS_CSS', trailingslashit( CAPITOLWORDS_CHARTS . 'css' ) );
			define( 'CAPITOLWORDS_JS', trailingslashit( CAPITOLWORDS_CHARTS . 'js' ) );
			define( 'CAPITOLWORDS_SHORTCODES', CAPITOLWORDS_INC . 'shortcodes.php');
			define( 'CAPITOLWORDS_WIDGET', CAPITOLWORDS_INC . 'widget.php' );
			define( 'CAPITOLWORDS_API_CLIENT', CAPITOLWORDS_INC . 'client.php' );
			define( 'CAPITOLWORDS_SCRIPTS', CAPITOLWORDS_INC . 'scripts.php' );

		}

		//the files
		public function plugin_requires() {

			require( CAPITOLWORDS_SHORTCODES );
			require( CAPITOLWORDS_SCRIPTS ) ;
			require( CAPITOLWORDS_WIDGET );
			require( CAPITOLWORDS_API_CLIENT );

		}
		//in case someone wants to translate stuff 
		//Need to refactor as I might need to load this differently similar to load_all_scripts()
		public function capitol_words_charts_load_plugin_textdomain() {

	    	load_plugin_textdomain( 'text-domain', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

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