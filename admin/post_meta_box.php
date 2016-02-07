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
						<label for="phrase">Phrase</label>
						<input type="text" class="widefat" name="phrase" placeholder="Enter Phrase" />
					</p>

					<p>
						<label for="granularity">Time to Search (defaults to "by year" if nothing selected)</label>
						<br />
						<select name="granularity">
							<option value="">Select an Option</option>
							<option value="day">By Day</option>
							<option value="month">By Month</option>
							<option value="year">By Year</option>
						</select>			
					</p>

					<p>
						<label for="start_date">Start Date (can be no earlier than 1996-01-01)</label>
						<input type="text" class="widefat" name="start_date" placeholder="Enter Start Date in a YYYY-MM-DD Format" />
					</p>

					<p>
						<label for="end_date">End Date (can be no later than the current date of <?php echo date('Y-m-d')?>)</label>
						<input type="text" class="widefat" name="end_date" placeholder="Enter Start Date in a YYYY-MM-DD Format" />
					</p>

					<p>
						<label for="state">State (Optional)</label>
						<input type="text" class="widefat" name="state" placeholder="Enter a state you wish to search for as its two letter abbreviation" />
					</p>

					<p>
						<label for="party">Party (Optional)</label>
						<br/>
						<select name="party">
							<option value="" >All Parties</option>
							<option value="D">Democratic Party</option>
							<option value="R">Republican Party</option>
							<option value="I">Independent</option>
						</select>
					</p>

					<p>
						<label for="chamber">Chamber (Optional)</label>
						<br/>
						<select name="chamber">
							<option value="">All Chambers</option>
							<option value="house">United States House of Representatives</option>
							<option value="senate">United States Senate</option>
							<option value="extensions">Independent</option>
						</select>
					</p>
					<a id="preview" href="#">Preview Your Chart</a>
					<canvas id="summary"></canvas>
		</div>


		<?php


	}
}

?>