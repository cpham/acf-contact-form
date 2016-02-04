<?php


	function acf_cf_format_subfields($value, $key, $subfields, $parent,$post_id) {


		$rows = count($value);


		$message = '';
		for ($x = 0; $x < $rows; $x++) {
			$row = $x+1;
			$message .= '<strong>' .  $parent . ' #'  .  $row . '</strong><ul>';
				foreach($subfields as $field) {


					$subfield_value = $value[$x][$field['name']];

					if(!empty($subfield_value)) {
						$message .= '<li>';

							$message .= '<strong>' . $field['label'] . ': </strong> ';

							if($field['type'] == 'repeater') {
								$message .= '<ul>';
							}

								$message .= acf_cf_format_message($subfield_value, $field['type'], $field, $post_id);

							if($field['type'] == 'repeater') {
								$message .= '</ul>';
							}

						$message .= '</li>';

					}
				}

			$message .= '</ul>';

		}

		return $message;
	}
		

	function acf_cf_format_message($value, $type, $field, $post_id) {
		$default = '<a href="'.get_edit_post_link($post_id) .'">Click here to view in admin.</a>';
		$message = '';
		switch($type) {
			case "repeater":

				$message .= acf_cf_format_subfields($value, $field['key'], $field['sub_fields'], $field['label'], $post_id);

				break;
			case "post_object":

				if($field['return_format'] == 'id') {

					$post_types = $field['post_type'];

					$value = get_posts(array('post_type' => array('post','page'), 'post__in' => $value));




				}
				if($field['multiple'] == 0) {
					$value = array($value); //if single value, put it in an array.
				}
				foreach( $value as $post) {
					$message .= '<div>';
					$message .= $post->post_title;

					$message .= '</div>';
				}


				break;

			case "taxonomy":

				$objecttype = gettype($value);
				if($objecttype == 'string' || $objecttype == 'integer') {
						$value = array($value);
				}

				foreach($value as $term) {

					$term = get_term_by('term_id', $term, $field['taxonomy'] );
					$message .= '<div>';
					$message .= $term->name;
					$message .= '</div>';
				}


				break;
			case "oembed":
				$message .= $default;
				break;
			case "textarea":

				$message .= strip_tags($value, '<br><br/><p></p><br />');

				break;

			case "file":
			case "image":


				if( $field['return_format'] == 'id'){
					$message .= wp_get_attachment_url($value);
				}

				elseif( $field['return_format'] == 'array') {
					$message .= $value['url'];
				}
				elseif ( $field['return_format' == 'url']) {
					$message .= $value;
				}


				break;

			case "select":
				if($field['multiple'] == 1) {
					foreach($value as $choice) {
						$message .= '<div>';

					$message .= $field['choices'][$choice];

						$message .= '</div>';

					}
				}
				else {

					$message .= $value;
				}

				break;
			case "checkbox":


				foreach($value as $choice) {
					$message .= '<div>';

					$message .= $field['choices'][$choice];

					$message .= '</div>';

				}
			case "user";

				if($field['multiple'] == 0) {
					$message .= $value['display_name'];
				}

				else {
					foreach($value as $user) {
						$message .= $user['display_name'];
					}
				}

				break;
			case "password":

				$message .= str_repeat("*",6);

				break;
			default:
				$message .= $value;
		}
		
		

		return $message;

	}


	if(!empty($_GET['acf-cf-email'])) {

				add_action('template_redirect', 'acf_cf_email_template');

	}
	
	
	if(!empty($_GET['acf-cf-customeremail'])) {

				add_action('template_redirect', 'acf_cf_customeremail_template');

	}
	
	// ADMIN EMAIL TEMPLATE

	function acf_cf_email_template() {
		global $post;	

		$post_id = $_GET['acf-cf-email'];

		$key = get_post_meta($post_id, 'acfcf-key', true);
		$post = get_post($post_id);
		if($_GET['key'] == $key) { // CHECK FOR  KEY

			setup_postdata($post);
	
			if(empty($_GET['template'])) {
				echo '<h3 style="text-align: center;">' . get_the_title($post->ID) . '</h3>';
				$fields = get_field_objects($post_id);
	
				
				$message = '<table class="table table-striped" style="width: 100%; font-family: helvetica,arial;">';
				foreach($fields as $field) {
					if(!empty($field['value'])) {
						$message .= '<tr>';
						$message .= '<td style="padding: 5px; width: 20%; text-align: right;" align="right" valign="top"><strong>' . $field['label'] . ': </strong></td>';
	
						$value = $field['value'];
	
	
	
						$message .= '<td  style="padding: 5px;" align="left" valign="top">';
	
						$message .= acf_cf_format_message($field['value'], $field['type'], $field, $post_id);
						
						$message .= '</td>';
						$message .= '</tr>';
	
					}
				}
				
				$message .= '<tr><td  style="padding: 5px;" align="right" valign="top"><strong>IP:</strong></td><td>'. $_SERVER['REMOTE_ADDR'] . '</td></tr>';
	
				$message .= '</table>';
				
				echo $message;
	
	
	
			} else {
				$template = $_GET['template'];
				$template = get_template_directory() . '/acf-cf-templates/acf-cf-' . $template . '.php';
				require_once($template);
	
			}
		}
		die();

	}
	
	// CUSTOMER EMAIL TEMPLATE
	
	function acf_cf_customeremail_template() {
		global $post;
		$post_id = $_GET['acf-cf-customeremail'];
		$key = get_post_meta($post_id, 'acfcf-key', true);
		$post = get_post($post_id);		
		
		if($_GET['key'] == $key) { // CHECK FOR  KEY
	
			setup_postdata($post);
			$forms = get_field('forms','option');

			$post_type = get_post_field('post_type', $post_id);

			$title = get_the_title($post_id);
			if(!empty($forms)) {
				foreach($forms as $form) {
					if($post_type == $form['post_type']) {
						$title = $form['customertitle'];
					}
				}
			}
		

			if(empty($_GET['customertemplate'])) {
				echo '<h3 style="text-align: center;">' . $title . '</h3>';
				$fields = get_field_objects($post_id);
	
				$message = '<table class="table table-striped" style="width: 100%; font-family: helvetica,arial;">';
				foreach($fields as $field) {
					if(!empty($field['value'])) {
						$message .= '<tr>';
						$message .= '<td style="padding: 5px; width: 20%; text-align: right;" align="right" valign="top"><strong>' . $field['label'] . ': </strong></td>';
	
						$value = $field['value'];
	
	
	
						$message .= '<td  style="padding: 5px;" align="left" valign="top">';
	
						$message .= acf_cf_format_message($field['value'], $field['type'], $field, $post_id);
						
						$message .= '</td>';
						$message .= '</tr>';
	
					}
				}
				
				$message .= '<tr><td  style="padding: 5px;" align="right" valign="top"><strong>IP:</strong></td><td>'. $_SERVER['REMOTE_ADDR'] . '</td></tr>';
	
				$message .= '</table>';
				
				echo $message;
	
	
	
			} else {
				$template = $_GET['customertemplate'];
				$template = get_template_directory() . '/acf-cf-templates/acf-cf-' . $template . '.php';
				require_once($template);
	
			}
		}
		die();

	}
?>