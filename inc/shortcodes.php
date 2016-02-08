<?php

//responsible for parsing attributes and outputting baseline html

if( ! defined( 'ABSPATH' ) ) exit;

class CAPITOLWORDS_SHORTCODES {

	public function __construct() {

		add_shortcode( 'capitolwords', array( $this, 'setup_shortcode' ) );

	}

	public function setup_shortcode( $atts ) {

		$atts = shortcode_atts( array(

				'phrase' 		=> 'default',
				'party' 		=> '',
				'start_date'	=> '',
				'end_date'		=> '',
				'granularity'	=> 'year',
				'chamber' 		=> '',
				'state'			=> '',
				'label'			=> 'Click to see the chart!',

			), $atts );	

		//do some validation of start date and end date - if we don't get what we're expecting
		//then set both to empty strings and reset granularity back to the sensible default of "year"
		if ( $atts['start_date'] ) {
			$atts['start_date'] .= '-01-01';
		}
		if ( $atts['end_date'] ) {
			$atts['end_date'] .= '-02-01';
		}

		$client = new CAPITOLWORDS_CLIENT();
		$response = $client->manage_client( $atts );

		$baseline_html = '';

		$baseline_html .= '<div id="'. $atts['phrase'] . $atts['granularity'] .'">'; 
		$baseline_html .= '<a href="#" class="'. $atts['phrase'] . $atts['granularity'] .'">' . $atts['label'] . $atts['start_date'] . $atts['end_date']. '</a>';
		$baseline_html .= '</div>';
		$baseline_html .= '<script>';
		$baseline_html .= "jQuery(document).ready(function($){

        var chartLabels = '" . $atts['granularity'] . "';
        var buttonID = '#' + '". $atts['phrase'] . $atts['granularity'] ."';
        var canvasID = '" . $atts['phrase'] . $atts['granularity'] . "' + 'canvas';
        var chartJson = ". $response .";

		    $( buttonID ).one( 'click', function(event) {
		        event.preventDefault();
		        if ( chartJson['results'].length == 0  ) {
		        	$('a.". $atts['phrase'] . $atts['granularity'] ."').text('Sorry, this chart has no data');
		        	return;
		        }
		        $('a.". $atts['phrase'] . $atts['granularity'] ."').remove();
		        // Get REST URL and post ID from WordPress
		        var points = [];
		        var labels = [];
		        console.log(chartLabels);
		        $.each(chartJson, function( index, object ){
					$.each(object, function( key, object){
						points.push(object.count);
						labels.push(object[chartLabels]);
					});
		        });

				var data = {
					labels: labels,
					datasets: [
					{
						label: 'My First dataset',
						fillColor: 'rgba(220,220,220,0.2)',
						strokeColor: 'rgba(220,220,220,1)',
						pointColor: 'rgba(220,220,220,1)',
						pointStrokeColor: '#fff',
						pointHighlightFill: '#fff',
						pointHighlightStroke: 'rgba(220,220,220,1)',
						data: points
					}]
				};
				$( buttonID ).append('<canvas id=\"'+ canvasID + '\" width=\"600\" height=\"600\"></canvas>');
				var ctx = $('#' + canvasID ).get(0).getContext('2d');
				// This will get the first returned node in the jQuery collection.
				var myNewChart = new Chart(ctx).Line(data);


		    });
		});";

		$baseline_html .= '</script>';

		return $baseline_html; 

	}

}

$capitol_shortcodes = new CAPITOLWORDS_SHORTCODES();

?>