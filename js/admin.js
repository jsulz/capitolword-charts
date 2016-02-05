jQuery(document).ready(function($){
    $('.my-color-field').wpColorPicker();
});

jQuery(document).ready( function($) {

	var capitolWordsPhrase;
	var capitolWordsParty;
	var capitolWordsGranularity;
	var capitolWordsStartDate;
	var capitolWordsEndDate;
	var capitolWordsState;
	var capitolWordsChamber;

    $("select[name='capitol-words-party']" ).change(function(){
		$("select[name='capitol-words-party'] option:selected").each(function(){
			capitolWordsParty = $(this).val();
		});
    });
});