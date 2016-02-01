<?php

//responsible for taking parsed shortcode attributes and building a url
//will hand this URL off to the load_all_scripts function - specifically to the main.js file - in capitolwords-charts.php 
//using the wp_localize_script call

if( ! defined( 'ABSPATH' ) ) exit;

class CAPITOLWORDS_CLIENT {

	private $final_url;

	public function __construct() {
		//nothing to see here
	}

	public function parse_shortcode_atts( $shortcode_atts ) {

		$api_query_args = array(
				'phrase' 		=> $shortcode_atts['phrase'],
				'percentages' 	=> false,
				'granularity' 	=> 'year',
				'party' 		=> $shortcode_atts['party'],
				'start_date' 	=> $shortcode_atts['start_year'],
				'end_date' 		=> $shortcode_atts['end_year'],
				'apikey' 		=> '5896af2471bb41d3aa615b083a85a1b0'

			);

		$this->building_url( $api_query_args );


	}

	public function building_url( $query_args ) {

		$url = add_query_arg( $query_args, 'http://capitolwords.org/api/1/dates.json');

		$this->final_url = $url;

	}

	public function get_final_url( ) {
		return $this->final_url;
	}

}



?>