jQuery(document).ready(function($){
    $('.my-color-field').wpColorPicker();
});

jQuery(document).ready(function($) {


	var capitolWordsPhrase;
	var capitolWordsParty;
	var capitolWordsGranularity;
	var capitolWordsStartDate;
	var capitolWordsEndDate;
	var capitolWordsState;
	var capitolWordsChamber;

	var capitolWordsAPIKey =  capitolWordsInfo.api_key;
	var capitolWordsDateEndpoint =  capitolWordsInfo.date_endpoint;

    $("select[name='party']" ).change(function(){
		$("select[name='party'] option:selected").each(function(){
			capitolWordsParty = $(this).val();
		});
    });

    $("select[name='granularity']" ).change(function(){
		$("select[name='granularity'] option:selected").each(function(){
			capitolWordsGranularity = $(this).val();
		});
    });

    $("select[name='chamber']" ).change(function(){
		$("select[name='chamber'] option:selected").each(function(){
			capitolWordsChamber = $(this).val();
		});
    });
    $('#preview').on('click', function(event) {

		event.preventDefault();
		capitolWordsPhrase = $("input[name=phrase]").val();
		capitolWordsStartDate = $("input[name=start_date]").val();
		capitolWordsEndDate = $("input[name=end_date]").val();
		capitolWordsState = $("input[name=state]").val();

		var dateParamObj = {
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

		var dateParams = $.param( dateParamObj );
		var dateRequest = capitolWordsDateEndpoint +  dateParams;

		$.ajax({
			dataType: 'json',
			url: dateRequest
		})

		.done(function(response){
			//console.log(response);
			var dateLabels = [];
			var datePoints = [];
			$.each( response, function(results, object){
				$.each(object, function(key, object){
					dateLabels.push(object.year);
					datePoints.push(object.count);
				});
			});
			var data = {
				labels: dateLabels,
				datasets: [
				{
					label: "My First dataset",
					fillColor: "rgba(220,220,220,0.2)",
					strokeColor: "rgba(220,220,220,1)",
					pointColor: "rgba(220,220,220,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(220,220,220,1)",
					data: datePoints
				}]
			};

			var ctx;

			if ( $('#postChart' ) ) {
				$('#date-panel').next().remove();
				$('#date-panel').append('<canvas id="postChartredraw" width="400" height="400"></canvas>');
				ctx = $("#postChartredraw").get(0).getContext("2d");
			} else {
				$('#date-panel').append('<canvas id="postChart" width="400" height="400"></canvas>');
				ctx = $("#postChart").get(0).getContext("2d");
			}
			// This will get the first returned node in the jQuery collection.
			var myNewChart = new Chart(ctx).Line(data);
		})

		.fail(function(){

		})

		.always(function(){

		});

    });


});