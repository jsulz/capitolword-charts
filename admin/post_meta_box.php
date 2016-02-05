<?php

function capitol_words_post_meta_box() {

	return new Capitol_Words_Post_Meta_Box();

}

add_action( 'admin_init', 'capitol_words_post_meta_box' );

class Capitol_Words_Post_Meta_Box {

	public function __construct() {

		add_action( 'add_meta_boxes', array( $this, 'register_capitol_words_meta_box' ) );

	}

	public function register_capitol_words_meta_box() {

		add_meta_box( 'capitol-words-meta', 'Capitol Words' , array( $this, 'capitol_words_post_box_callback' ), 'post', 'normal' );

	}

	public function capitol_words_post_box_callback() {
		echo '<p>inputs will go here</p>';
	}
}

?>