<?php

//responsible for parsing attributes and outputting baseline html

if( ! defined( 'ABSPATH' ) ) exit;

class CAPITOLWORDS_SHORTCODES {

	public function __construct() {

		add_shortcode( 'capitalwords', array( $this, 'setup_shortcode' ) );

	}

	public function setup_shortcode( $atts ) {

		$client = new CAPITOLWORDS_CLIENT();

		$atts = shortcode_atts( array(

				'phrase' 		=> '',
				'party' 		=> '',
				'start_year'	=> '',
				'end_year'		=> '',
				'label'			=> 'Click to see the chart!'

			), $atts );	

		//set up years so that they include month and date format as expected by Capitol Words API
		//dates will always start and end January first of the given year
		//format is in YYYY-MM-DD
		$atts['start_year'] .= '-01-01';
		$atts['end_year'] .= '-01-01';


		$client->parse_shortcode_atts( $atts );

		$handoff_url = $client->get_final_url();

		wp_localize_script( 'capitolwords-js', 'postdata', array(

				'json_url' => $handoff_url

			) );

		$baseline_html = '';

		$baseline_html .= '<div class="see-chart-button">'; 
		$baseline_html .= '<a href="#" class="capitolwordsshort">' . $atts['label'] . '</a>';
		$baseline_html .= '</div>';

		return $baseline_html; 

	}

}

$capitol_shortcodes = new CAPITOLWORDS_SHORTCODES();

?>