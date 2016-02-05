<?php

function capitol_words_post_meta_box() {

	//check to make sure the API Key has been set, if it hasn't bail
	//and check to make sure that the user wants to see the post meta box, if not, bail
	$settings = get_option( 'capitol_words_settings' );

	if ( !$settings['api_key'] ) { return false; }
	if ( !$settings['post_meta_box'] ) { return false; }

	return new Capitol_Words_Post_Meta_Box();

}

add_action( 'admin_init', 'capitol_words_post_meta_box' );

class Capitol_Words_Post_Meta_Box {

	public function __construct() {

		add_action( 'add_meta_boxes', array( $this, 'register_capitol_words_meta_box' ) );

	}

	public function register_capitol_words_meta_box() {

		add_meta_box( 'capitol-words-meta', 'Capitol Words Chart Previewer/Builder' , array( $this, 'capitol_words_post_box_callback' ), 'post', 'normal' );

	}

	public function capitol_words_post_box_callback() {

		?>

		<p>To make good use of this feature, please <a href="/wp-admin/options-general.php?page=capitol-words-settings">review the FAQ section on the plugin settings page</a>.</p>

		<?php

		echo $this->capitol_words_date_panel();


	}

	public function capitol_words_date_panel() {

		?>
			<div id="date-panel">
					<p>
						<label for="capitol-words-phrase">Phrase</label>
						<input type="text" class="widefat" name="capitol-words-phrase" placeholder="Enter Phrase" />
					</p>

					<p>
						<label for="capitol-words-granularity">Time to Search (defaults to "daily" if nothing selected)</label>
						<br />
						<select name="capitol-words-granularity">
							<option value="day" selected="selected">By Day</option>
							<option value="month">By Month</option>
							<option value="year">By Year</option>
						</select>			
					</p>

					<p>
						<label for="capitol-words-start-date">Start Date</label>
						<input type="text" class="widefat" name="capitol-words-start-date" placeholder="Enter Start Date in a YYYY-MM-DD Format" />
					</p>

					<p>
						<label for="capitol-words-end-date">End Date</label>
						<input type="text" class="widefat" name="capitol-words-end-date" placeholder="Enter Start Date in a YYYY-MM-DD Format" />
					</p>

					<p>
						<label for="capitol-words-state">State (Optional)</label>
						<input type="text" class="widefat" name="capitol-words-state" placeholder="Enter a state you wish to search for as its two letter abbreviation" />
					</p>

					<p>
						<label for="capitol-words-party">Party (Optional)</label>
						<br/>
						<select name="capitol-words-party">
							<option value="default" selected="selected">Select an Option</option>
							<option value="D">Democratic Party</option>
							<option value="R">Republican Party</option>
							<option value="I">Independent</option>
						</select>
					</p>

					<p>
						<label for="capitol-words-chamber">Chamber (Optional)</label>
						<br/>
						<select name="capitol-words-chamber">
							<option value="default" selected="selected">Select an Option</option>
							<option value="house">United States House of Representatives</option>
							<option value="senate">United States Senate</option>
							<option value="extensions">Independent</option>
						</select>
					</p>
					<a id="preview" href="#">Preview Your Chart</a>
		</div>


		<?php


	}
}

?>