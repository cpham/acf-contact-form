<?php


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

				$email_html = site_url() . '?acf-cf-email=' . $post_id;
				if(!empty($form['template'])) {
					$email_html = $email_html . '&template=' . $form['template'];
				}
				$message = file_get_contents($email_html);
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