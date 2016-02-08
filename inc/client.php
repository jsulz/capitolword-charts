<?php

//responsible for taking parsed shortcode attributes and building a url
//will hand this URL off to the load_all_scripts function - specifically to the main.js file - in capitolwords-charts.php 
//using the wp_localize_script call

if( ! defined( 'ABSPATH' ) ) exit;

define( 'API_URL', 'http://capitolwords.org/api/1/dates.json?' );

class CAPITOLWORDS_CLIENT {

	private $final_url;

	public function __construct() {
		//nothing to see here
	}

	public function manage_client( $shortcode_atts ) {

		$args = $this->parse_shortcode_atts( $shortcode_atts );
		$transient = $this->check_transient( $args);
		//check transient
		if ( $transient ) {
			return $transient;
		} else {
			$url = $this->build_url( $args );
			$body = $this->build_response( $url );
			set_transient( 'capitolwords_' . $shortcode_atts[ 'phrase' ] . time(), $body, DAY_IN_SECONDS );
			return $body;
		}

	}

	public function parse_shortcode_atts( $shortcode_atts ) {

		$api_query_args = array(
			'phrase' 		=> $shortcode_atts[ 'phrase' ],
			'percentages' 	=> false,
			'granularity' 	=> ( ! empty($shortcode_atts[ 'granularity' ] ) ) ? $shortcode_atts['granularity'] : '',
			'party' 		=> ( ! empty($shortcode_atts[ 'party' ] ) ) ? $shortcode_atts['party'] : '',
			'start_date' 	=> ( ! empty($shortcode_atts[ 'start_date' ] ) ) ? $shortcode_atts[ 'start_date' ] : '',
			'end_date' 		=> ( ! empty($shortcode_atts[ 'end_date' ] ) ) ? $shortcode_atts[ 'end_date' ] : '',
			'chamber' 		=> ( ! empty($shortcode_atts[ 'chamber' ] ) ) ? $shortcode_atts[ 'chamber' ] : '',
			'state' 		=> ( ! empty($shortcode_atts[ 'state' ] ) ) ? $shortcode_atts[ 'state' ] : '',

		);

		foreach ( $api_query_args as $key => $value ) {
			if ( $api_query_args[$key] == '' ) {
				unset($api_query_args[$key]);
			}
		}

		return $api_query_args;

	}

	public function check_transient() {
		return false;
	}

	public function build_url( $query_args ) {

		$url = add_query_arg( $query_args, 'http://capitolwords.org/api/1/dates.json');
		$capitol_words_settings = get_option( 'capitol_words_settings' );
		$api_key = $capitol_words_settings[ 'api_key' ];
		$url .= '&apikey=' . $api_key;
		return $url;

	}

	public function build_response( $url ) {

		$response = wp_remote_get( $url );
		$body = wp_remote_retrieve_body( $response );
		//$body = json_decode( $response );
		return $body;

	}

}



?>