<?php

	//add acf_form_head() before header if form shortcode is in post content.
	function acf_contact_display_form_head(  ) {

		global $post;

		if(has_shortcode( $post->post_content, 'acf_contact')) {
			acf_form_head();


		}
	}

	add_action( 'get_header', 'acf_contact_display_form_head' );


	//[acf_contact] shortcode
	function acf_contact_shortcode( $atts ) {


		$a = shortcode_atts( array(
				'id' =>  1
			), $atts );

		$form_id = $a['id'] - 1;


		$forms = get_field('forms','option');

		$f = $forms[$form_id];

		$title = 'New Form Submission'; //This is a temporary page title, which will change when fields are saved.

		$post = array(
			'post_type' => $f['post_type'],
			'post_status' => 'publish',
			'post_title' => $title
		);
		$form = '<div id="acf_contact'.$f["group"].'">';



		$form .= "</div>";

		//Move form down to content
		$form .=  "<script>jQuery(function($) {
					$('#acf_contactform" . $f["group"] . "').appendTo('#acf_contact" . $f["group"] . "');
	 			  });</script>";
		echo '<div id="acf_contactform'.$f["group"] . '">';

		acf_form(array('submit_value'=> 'Submit', 'return' => $f["return_url"],'post_id' => 'new_post','new_post' => $post, 'field_groups' => array($f["group"])) );

		echo '</div>';
		return $form;
	}
	add_shortcode( 'acf_contact', 'acf_contact_shortcode' );


?>
