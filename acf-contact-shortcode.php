<?php

	//add acf_form_head() before header if form shortcode is in post content.
	function acf_contact_display_form_head() {

		global $post;

		if(has_shortcode( $post->post_content, 'acf_contact')) {
			acf_form_head();


		}
	}

	add_action( 'get_header', 'acf_contact_display_form_head' );
	

	//[acf_contact] shortcode
	function acf_contact_shortcode( $atts ) {
		//This code uses acf_form() function which immediately outputs form html
		//messing up the admin view of the page containing the shortcode
		//For this reason I check if the current page "is_admin" page and return 
		//immediately to avoid shortcode rendering.
		if ( is_admin() )
                        return false;
                        
		$url = acf_get_current_url();
		
		// default shortcode attribute values 
		// refer to ACF documentation for acf_form() parameters http://www.advancedcustomfields.com/resources/acf_form/ 
		
		$a = shortcode_atts( array(
				'id' =>  "1",
				'form_attributes'		=> array(),
				'html_before_fields'	=> '',
				'html_after_fields'		=> '',
				'submit_value'			=> __("Submit", 'acf'),
				'updated_message'		=> __("Thank you", 'acf'),
				'label_placement'		=> 'top',
				'instruction_placement'	=> 'label',
				'field_el'			=> 'div',
				'uploader'			=> 'basic',
				'return'				=> add_query_arg( 'updated', 'true', $url ),
				
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

		acf_form(
			array(
				'post_id'				=> 'new_post',
				'field_groups' 		=> array($f["group"]), 
				'new_post' 			=> $post, 
				'form_attributes'		=> $a['form_attributes'],
				'html_before_fields'	=> $a['html_before_fields'],
				'html_after_fields'		=> $a['html_after_fields'],
				'submit_value'			=> $a['submit_value'],
				'updated_message'		=> $a['updated_message'],
				'label_placement'		=> $a['label_placement'],
				'instruction_placement'	=> $a['instruction_placement'],
				'field_el'			=> $a['field_el'],
				'uploader'			=> $a['uploader'],
				'return'				=> $a['return']
			
			
		));

		echo '</div>';
		return $form;
	}
	add_shortcode( 'acf_contact', 'acf_contact_shortcode' );


?>
