<?php

//responsible for taking parsed shortcode attributes and building a url
//will hand this URL off to the load_all_scripts function - specifically to the main.js file - in capitolwords-charts.php 
//using the wp_localize_script call

if( ! defined( 'ABSPATH' ) ) exit;

class CAPITOLWORDS_CLIENT {

	public function parse_shortcode_atts( $shortcode_atts ) {

	}
}

?>