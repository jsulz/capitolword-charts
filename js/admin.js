jQuery(document).ready(function($){
    $('.my-color-field').wpColorPicker();
});

jQuery(document).ready(function($) {


	var capitolWordsPhrase;
	var capitolWordsParty;
	var capitolWordsGranularity = 'year';
	var capitolWordsStartDate;
	var capitolWordsEndDate;
	var capitolWordsState;
	var capitolWordsChamber;
	var data;
	var dateChart;

	var capitolWordsAPIKey =  capitolWordsInfo.api_key;
	var capitolWordsDateEndpoint =  capitolWordsInfo.date_endpoint;

	var phraseInput = $( "input[name=phrase]" );
	var partyInput = $( "select[name=party]" );
	var granularityInput = $( "select[name=granularity]" );
	var startDateInput = $( "input[name=start_date]" );
	var endDateInput = $( "input[name=end_date]" );
	var stateInput = $( "input[name=state]" );
	var chamberInput = $( "select[name=chamber]" );

    $( partyInput ).change( function() {
		$("select[name='party'] option:selected").each( function () {
			capitolWordsParty = $(this).val();
		});
    });

    $( granularityInput ).change( function() {
		$("select[name='granularity'] option:selected").each( function () {
			capitolWordsGranularity = $(this).val();
		});
    });

    $( chamberInput ).change( function() {
		$("select[name=chamber] option:selected").each( function () {
			capitolWordsChamber = $(this).val();
		});
    });
    $( '#preview' ).on( 'click', function( event ) {

		event.preventDefault();
		capitolWordsPhrase = $( phraseInput ).val();
		capitolWordsStartDate = $( startDateInput ).val();
		capitolWordsEndDate = $( endDateInput ).val();
		capitolWordsState = $( stateInput ).val();

		//check to see if the phrase input has a value - if it doesn't, give some feedback
		if ( !capitolWordsPhrase ) {
			$( phraseInput ).addClass('failed');
			return;
		} else if ( capitolWordsPhrase && phraseInput.hasClass( 'failed' ) ) {
			$( phraseInput ).removeClass('failed');
		}

		$('#shortcode').show();
		$('#summary').show();

		var uncleanedParams = {
			phrase: capitolWordsPhrase,
			percentages: false,
			granularity: capitolWordsGranularity,
			state: capitolWordsState.toUpperCase(),
			party: capitolWordsParty,
			chamber: capitolWordsChamber,
			start_date: capitolWordsStartDate,
			end_date: capitolWordsEndDate,
			apikey: capitolWordsAPIKey,
		};

		var cleanedParams = doesExistValidation( uncleanedParams );

		var dateParams = $.param( cleanedParams );
		var dateRequest = capitolWordsDateEndpoint +  dateParams;
		var dateLabels = [];
		var datePoints = [];

		$.ajax({
			dataType: 'json',
			url: dateRequest,
		})

		.done(function(response){
			//console.log(response);
			$.each( response, function(results, object){
				$.each(object, function(key, object){
					dateLabels.push(object[capitolWordsGranularity]);
					datePoints.push(object.count);
				});
			});
			
			data = {
				labels: dateLabels,
				datasets: [
				{

					label: "Capitol Words",
					responsive: true,
					fillColor: "rgba(220,220,220,0.2)",
					strokeColor: "rgba(220,220,220,1)",
					pointColor: "rgba(220,220,220,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(220,220,220,1)",
					data: datePoints

				}]
			};

			respondCanvas( );

		})

		.fail(function(){

		})

		.always(function(){

		});

		$('#shortcode').on('click', function(event){
			event.preventDefault();
			var shortcode = '';
			shortcode = '[capitolwords ';
			for ( var prop in cleanedParams ) {
				if ( prop == 'apikey') continue;
				shortcode += prop + '="' + cleanedParams[prop] + '" ';
			}
			shortcode += ' ]';
			$('#date-panel').append('<p id="clearthis">' + shortcode + '</p>');
		});

    });

	function respondCanvas() {
		if (dateChart) {
			dateChart.destroy();
		}
		var c = $('#summary');
		var cParent = c.parent();
		var ctx = c.get(0).getContext("2d");
		var container = $('#date-panel');
		var $container = $(container);

		c.attr('width', cParent.width()/2 ); //max width

		c.attr('height', cParent.height()/2 ); //max height

		//Call a function to redraw other content (texts, images etc)
		dateChart = new Chart(ctx).Line(data);
	}

	//a function to see if the parameters exist - if they don't, then remove them from the object
	function doesExistValidation( object ) {

		for ( var prop in object ) {

			if ( !object[prop] ) {
				delete object[prop];
			} else if ( prop == 'start_date' || prop == 'end_date' ) {
				var checkDate = dateValidation( object[prop] );
				if ( !checkDate ) {
					delete object[prop];
				}
			}

		}

		return object;

	}

	//a function to clean up the dates - if they're not valid, then stop the presses!
	function dateValidation( date ) {

		var pass = /^\d{4}-\d{2}-\d{2}/.test( date );
		return pass;

	}

});