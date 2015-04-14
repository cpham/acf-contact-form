<?php
	function acf_cf_format_subfield($value, $key, $subfields, $parent,$post_id) {


		$rows = count($value);


		$message = '';
		for ($x = 0; $x < $rows; $x++) {
			$row = $x+1;
			$message .= '<tr><td colspan="2"><table style="width: 100%"><tr><td colspan="2" style="text-align: center; background: #000000; color: #fff;">' .  $parent . ' #'  .  $row . '</td></tr><tr><td colspan="2"><table style="width: 100%;">';
				foreach($subfields as $field) {

					if($field['type'] == 'repeater') {
						$message .= '<tr><td colspan="2" style="padding: 10px 20px;">';
					}
					else {
						$message .= '<tr>';

						$message .= '<td style="padding: 5px ; width: 20% text-align: right;" align="right" valign="top"><strong>' . $field['label'] . '</strong></td>';
						$message .= '<td  style="padding: 5px;" align="left" valign="top">';
					}
					$message .= acf_cf_format_message($value[$x][$field['name']], $field['type'], $field, $post_id);
					$message .= '</td>';
					$message .= '</tr>';

				}

			$message .= '</table></td></tr></table></td></tr>';

		}

		return $message;
	}

	function acf_cf_format_message($value, $type, $field, $post_id) {
		$default = '<a href="'.get_edit_post_link($post_id) .'">Click here to view in admin.</a>';
		$message = '';
		switch($type) {
			case "repeater":

				$message .= '<table class="table table-striped" style="width: 100%;">';
					$message .= acf_cf_format_subfield($value, $field['key'], $field['sub_fields'], $field['label'], $post_id);
				$message .= '</table>';



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

	function save_inquiry( $post_id ) {
		if(!wp_is_post_revision( $post_id )) {
		$forms = get_field('forms','option');

		$post_type = get_post_field('post_type', $post_id);



		foreach($forms as $form) {
			if($post_type == $form['post_type']) {

				$title = $form['title'];

				$title = str_replace('newpost', $post_id, $title);
				$title = do_shortcode($title);

				$slug = str_replace(' ', '-',  strtolower($title));
				$post = array("post_title" => $title, 'ID' => $post_id, 'post_name' => $slug);

				wp_update_post($post);

				$headers = array('Content-Type: text/html; charset=UTF-8');


				$subject = $title . ' (' . $post_id . ')';

				$fields = get_field_objects($post_id);
				$message = '<table class="table table-striped" style="width: 100%;">';
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
				$message .= '</table>';

				if($form['no_email'] == false) {

					$recipient = $form['email'];

					$mail = wp_mail($recipient, $subject, $message, $headers );

				}

			}
		}
		return $post_id;

		}
	}

	add_action('acf/save_post', 'save_inquiry', 20);
?>