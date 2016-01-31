<?php

//responsible for parsing attributes and outputting baseline html

if( ! defined( 'ABSPATH' ) ) exit;

class CAPITOLWORDS_SHORTCODES {

	public function setup_shortcode() {

		$atts = shortcode_atts( array(

				'phrase' 		=> '',
				'party' 		=> '',
				'start_year'	=> '',
				'end_year'		=> '',
				'label'			=> 'Click to see the chart!'

			), $atts );	

		//set up years so that they include month and date format as expected by Capitol Words API
		//dates will always start and end January first of the given year
		$atts['start_year'] .= '01-01';
		$atts['end_year'] .= '01-01';

		CAPITOLWORDS_CLIENT::parse_shortcode_atts($atts);

		$baseline_html = '';

		$baseline_html .= '<a href="#" id="capitolwordsshort">';
		$baseline_html .= '<div class="see-chart-button">' . $atts['label'] . '</div>';
		$baseline_html .= '</a>'

		return $baseline_html; 

	}

}

function capitol_words_shortcodes() {
	return CAPITOLWORDS_SHORTCODES::setup_shortcode();
}

add_shortcode( 'capitalwords', 'capitol_words_shortcodes' );

?>