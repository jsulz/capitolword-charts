(function($){
    $('.see-chart-button').on( 'click', function(event) {
        event.preventDefault();
        $('a.capitolwordsshort').remove();
        // Get REST URL and post ID from WordPress
        var json_url = postdata.json_url;
        var labels = [];
        var points = [];


		$.ajax({
			dataType: 'json',
			url: json_url
		})

		.done(function(response) {
			$('.see-chart-button').append('<h2>Capitol Words</h2>');
			//console.log(response);
			$.each( response, function(results, object){
				$.each(object, function(key, object){
					labels.push(object.year);
					points.push(object.count);
				});
			});
			var data = {
				labels: labels,
				datasets: [
				{
					label: "My First dataset",
					fillColor: "rgba(220,220,220,0.2)",
					strokeColor: "rgba(220,220,220,1)",
					pointColor: "rgba(220,220,220,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(220,220,220,1)",
					data: points
				}]
			};
			$('.see-chart-button').append('<canvas id="postChart" width="400" height="400"></canvas>');
			var ctx = $("#postChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var myNewChart = new Chart(ctx).Line(data);

		})

		.fail(function(){

		})

		.always(function(){

		});

    });
})(jQuery);