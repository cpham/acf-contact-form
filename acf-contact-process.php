<?php

// UPDATE POST AND SEND EMAILS

function save_inquiry( $post_id ) {
	if(!wp_is_post_revision( $post_id )) {
	$forms = get_field('forms','option');

	$post_type = get_post_field('post_type', $post_id);


		if(!empty($forms)) {
			foreach($forms as $form) {
				if($post_type == $form['post_type']) {

					$title = $form['title'];
					$customertitle = $form['customertitle'];

					$title = str_replace('newpost', $post_id, $title);
					$title = do_shortcode($title);

					$slug = str_replace(' ', '-',  strtolower($title));
					$post = array("post_title" => $title, 'ID' => $post_id, 'post_name' => $slug);
					wp_update_post($post);


					//CREATE RANDOM KEY TO PREVENT UNAUTHORIZED VIEWING OF EMAIL CONTENTS

					$rand = rand(12300,90300); //generate random number
					$key = dechex($rand); //convert random number to hex

					//STORE KEY IN META
					update_post_meta($post_id, 'acfcf-key', $key);



					$headers = array('Content-Type: text/html; charset=UTF-8', 'From: '.get_bloginfo('name').' <noreply@'.$_SERVER['HTTP_HOST'].'>');

					$subject = $title . ' (' . $post_id . ')';

					$customersubject = $title . ' (' . $post_id . ')';



					//CHECK FOR ADMIN EMAIL TEMPLATE

					$email_html = site_url() . '?acf-cf-email=' . $post_id . '&key=' . $key;

					if(!empty($form['template'])) {
						$email_html = $email_html . '&template=' . $form['template'];
					}


					//CHECK FOR CUSTOMER EMAIL TEMPLATE

					$customeremail_html = site_url() . '?acf-cf-customeremail=' . $post_id . '&key=' . $key;

					if(!empty($form['customertemplate'])) {
						$customeremail_html = $customeremail_html . '&customertemplate=' . $form['customertemplate'];
					}


					//SEND CUSTOMER EMAIL

					if($form['no_customeremail'] == false) {

						// FETCH CUSTOMER EMAIL USING CURL

						$customerEmailProc = curl_init($customeremail_html);
						curl_setopt($customerEmailProc, CURLOPT_HEADER, 0);
						curl_setopt($customerEmailProc, CURLOPT_RETURNTRANSFER,1);
						curl_setopt($customerEmailProc,CURLOPT_CONNECTTIMEOUT,1);
						$customermessage = curl_exec($customerEmailProc);

						$recipient = get_field($form['customeremail'], $post_id);

						$cmail = wp_mail($recipient, $customertitle, $customermessage, $headers );

						update_post_meta($post_id, 'customer_email_sent', $cmail); //log whether or not the customer email was sent (1 = success, 0 = failure)

					}


					//SEND ADMIN EMAIL

					if($form['no_email'] == false) {

						// FETCH ADMIN EMAIL USING CURL

						$messageProc = curl_init($email_html);
						curl_setopt($messageProc, CURLOPT_HEADER, 0);
						curl_setopt($messageProc, CURLOPT_RETURNTRANSFER,1);
						curl_setopt($messageProc,CURLOPT_CONNECTTIMEOUT,1);
						$message = curl_exec($messageProc);


						$recipient = $form['email'];

						$mail = wp_mail($recipient, $subject, $message, $headers );

						update_post_meta($post_id, 'admin_email_sent', $mail); //log whether or not the admin email was sent (1 = success, 0 = failure)


					}


				}
			}
			return $post_id;
		}
	}
}

add_action('acf/save_post', 'save_inquiry', 20);


//ADD PREVIEW LINKS TO EDIT SCREEN

add_action('edit_form_after_title', function ( $post )
{


	$forms = get_field('forms','option');
	if(is_array($forms)){
		foreach($forms as $form) {
			if($form['post_type'] == $post->post_type) {
				$key = get_post_meta($post->ID, 'acfcf-key', true);
				$email_html = site_url() . '?acf-cf-email=' . $post->ID . '&key=' . $key;

				if(!empty($form['template'])) {
					$email_html = $email_html . '&template=' . $form['template'];
				}

				if($form['no_email'] == false) {
					echo '<p><a href="' . $email_html . '" target="_blank">Preview Admin Email</a></p>';
				}



				$customeremail_html = site_url() . '?acf-cf-customeremail=' . $post->ID . '&key=' . $key;
				if(!empty($form['customertemplate'])) {
					$customeremail_html = $customeremail_html . '&customertemplate=' . $form['customertemplate'];
				}

				if($form['no_customeremail'] == false) {
					echo '<p><a href="' . $customeremail_html . '" target="_blank">Preview Customer Email</a></p>';
				}


			}

		}
	}
});



//AKISMET VALIDATION

function acf_cf_akismet ($content) {

	// innocent until proven guilty
	$isSpam = FALSE;

	$content = (array) $content;

	if (function_exists('akismet_init')) {

		$wpcom_api_key = get_option('wordpress_api_key');

		if (!empty($wpcom_api_key)) {

			global $akismet_api_host, $akismet_api_port;

			// set remaining required values for akismet api
			$content['user_ip'] = preg_replace( '/[^0-9., ]/', '', $_SERVER['REMOTE_ADDR'] );
			$content['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$content['referrer'] = $_SERVER['HTTP_REFERER'];
			$content['blog'] = get_option('home');

			if (empty($content['referrer'])) {
				$content['referrer'] = get_permalink();
			}

			$queryString = '';

			foreach ($content as $key => $data) {
				if (!empty($data)) {
					$queryString .= $key . '=' . urlencode(stripslashes($data)) . '&';
				}
			}

			$response = akismet_http_post($queryString, $akismet_api_host, '/1.1/comment-check', $akismet_api_port);

			if ($response[1] == 'true') {
				update_option('akismet_spam_count', get_option('akismet_spam_count') + 1);
				$isSpam = TRUE;
			}

		}

	}

	return $isSpam;

}



function acf_cf_validate_spam( $valid, $value, $field, $input ) {


	//check if it's an akismet field

	$class = $field['wrapper']['class'];

	if(strpos($class, 'akismet') !== false) {
		// bail early if value is already invalid
		if( !$valid ) {

			return $valid;

		}

		if(!empty($value)) {

			$content = array();
			if($class == 'akismet-message') {
				$content['comment_content'] = $value;
			}

			else if ($class == 'akismet-email') {
				$content['comment_author_email'] = $value;
			}

			else if ($class == 'akismet-name') {
				$content['comment_author'] = $value;
			}

			else if ($class = 'akismet-url') {
				$content['comment_author_url'] = $value;
			}

			$isSpam = acf_cf_akismet($content);

			if($isSpam === TRUE || strpos($value, '<script') !== false ) {
				$valid = 'Spam detected!';
			}


		}



	}


	return $valid;

}


add_filter('acf/validate_value', 'acf_cf_validate_spam', 10, 4);
