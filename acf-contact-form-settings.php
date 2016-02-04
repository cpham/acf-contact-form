<?php if( function_exists('register_field_group') ):

		register_field_group(array (
				'key' => 'group_551c5c6182d6e',
				'title' => 'ACF Forms',
				'fields' => array (
					array (
						'key' => 'field_551c5c6852278',
						'label' => 'Form Rules',
						'name' => 'forms',
						'prefix' => '',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'min' => '',
						'max' => '',
						'layout' => 'block',
						'button_label' => 'Add Form Rule',
						'sub_fields' =>
						array (
							array (
								'key' => 'field_56b3746edd903',
								'label' => 'Basic Settings',
								'name' => 'basic_settings',
								'type' => 'tab',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'placement' => 'top',
								'endpoint' => 0,
							),
							//POST TYPE 
							
							array (
								'key' => 'field_551c587df4125',
								'label' => 'Post Type',
								'name' => 'post_type',
								'prefix' => '',
								'type' => 'select',
								'instructions' => '**YOU CAN ONLY HAVE ONE SET OF FORM RULES PER POST TYPE**',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'choices' => array (
									'' => '',
								),
								'default_value' => array (
									'' => '',
								),
								'allow_null' => 0,
								'multiple' => 0,
								'ui' => 0,
								'ajax' => 0,
								'placeholder' => '',
								'disabled' => 0,
								'readonly' => 0,
							),
							
							//FIELD GROUP
							
							array (
								'key' => 'field_551c5885f4126',
								'label' => 'Field Group',
								'name' => 'group',
								'prefix' => '',
								'type' => 'select',
								'instructions' => '**Make sure that this field group contains your selected Post Type as a Location Rule**',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'choices' => array (
									'' => '',
								),
								'default_value' => array (
									'' => '',
								),
								'allow_null' => 0,
								'multiple' => 0,
								'ui' => 0,
								'ajax' => 0,
								'placeholder' => '',
								'disabled' => 0,
								'readonly' => 0,
							),
							
							//POST TITLE / SUBJECT LINE
							
							array (
								'key' => 'field_551c589cf4127',
								'label' => 'Title',
								'name' => 'title',
								'prefix' => '',
								'type' => 'text',
								'instructions' => 'Use this field to format the post title of each new post created by the form. <br />
									<strong>To use a custom field value, use the ACF shortcode, and use "newpost" for the post_id attribute.</strong> <br />

										This will also be used as the subject line of the email.<br />

											Example: <em>New Inquiry by [acf field="first_name" post_id="newpost"] [acf field="last_name" post_id="newpost"]</em>',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => 'New Form Submission',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
								'readonly' => 0,
								'disabled' => 0,
							),
							
							array (
								'key' => 'field_56b374efdd906',
								'label' => 'Admin Email Settings',
								'name' => 'admin_email_settings',
								'type' => 'tab',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'placement' => 'top',
								'endpoint' => 0,
							),

							
							//ADMIN EMAIL ADDRESS
							
							array (
								'key' => 'field_551c5e84069f1',
								'label' => 'Admin Email',
								'name' => 'email',
								'prefix' => '',
								'type' => 'text',
								'instructions' => 'Comma separate email addresses where form submissions should be sent',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => get_option( 'admin_email' ),
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
							),
							
							// DONT SEND ADMIN EMAIL
							
							array (
								'key' => 'field_551c7142bb822',
								'label' => 'Don\'t Send Admin Email',
								'name' => 'no_email',
								'prefix' => '',
								'type' => 'true_false',
								'instructions' => 'Check this box if you only want to record form submissions in WordPress, without sending an email',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'message' => '',
								'default_value' => 0,
							),
							
							// ADMIN EMAIL TEMPLATE
							
							array (
								'key' => 'field_552ecdbabf9a7',
								'label' => 'Admin Email Template',
								'name' => 'template',
								'prefix' => '',
								'type' => 'select',
								'instructions' => '- Templates can be placed within a directory in your current theme directory named "acf-cf-templates" <br />
					- Name your template according to the following convention: "acf-cf-[TITLE].php"
					',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'choices' => array (
									'' => '',
								),
								'default_value' => array (
									'' => '',
								),
								'allow_null' => 1,
								'multiple' => 0,
								'ui' => 0,
								'ajax' => 0,
								'placeholder' => '',
								'disabled' => 0,
								'readonly' => 0,
							),
							
							array (
								'key' => 'field_56b37507dd908',
								'label' => 'Customer Email Settings',
								'name' => '',
								'type' => 'tab',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'placement' => 'top',
								'endpoint' => 0,
							),
							
							//CUSTOMER EMAIL ADDRESS
							
							array (
								'key' => 'field_551csdsd9sd39',
								'label' => 'Customer Email',
								'name' => 'customeremail',
								'prefix' => '',
								'type' => 'text',
								'instructions' => 'Name of field where customer email is inputted',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => 'email',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
							),
							
							//CUSTOMER EMAIL SUBJECT TITLE
							
							array (
								'key' => 'field_551c5f932je34',
								'label' => 'Customer Email Title',
								'name' => 'customertitle',
								'prefix' => '',
								'type' => 'text',
								'instructions' => '	This will  be used as the subject line of the customer email.<br />
									<strong>To use a custom field value, use the ACF shortcode, and use "newpost" for the post_id attribute.</strong> <br />
									
											Example: <em>Thank you for your inquiry, [acf field="first_name" post_id="newpost"] [acf field="last_name" post_id="newpost"]</em>',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => 'Thank you for your inquiry,',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
								'readonly' => 0,
								'disabled' => 0,
							),
							
							
							//DON'T SEND CUSTOMER EMAIL
							
							array (
								'key' => 'field_551c714abw32',
								'label' => 'Don\'t Send Customer Email',
								'name' => 'no_customeremail',
								'prefix' => '',
								'type' => 'true_false',
								'instructions' => 'Check this box if you only want to record form submissions in WordPress, without sending an email to the customer',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'message' => '',
								'default_value' => 1,
							),
							
							
							
							
							//CUSTOMER EMAIL TEMPLATE
							
							array (
								'key' => 'field_552easr32ea7',
								'label' => 'Customer Email Template',
								'name' => 'customertemplate',
								'prefix' => '',
								'type' => 'select',
								'instructions' => '- Templates can be placed within a directory in your current theme directory named "acf-cf-templates" <br />
					- Name your template according to the following convention: "acf-cf-[TITLE].php"
					',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'choices' => array (
									'' => '',
								),
								'default_value' => array (
									'' => '',
								),
								'allow_null' => 1,
								'multiple' => 0,
								'ui' => 0,
								'ajax' => 0,
								'placeholder' => '',
								'disabled' => 0,
								'readonly' => 0,
							),

							
						),
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-acf-forms',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
			));



			function acf_load_templates( $field ) {
				if(file_exists(get_template_directory() . '/acf-cf-templates')) {
				// reset choices
				$files = scandir(get_template_directory() . '/acf-cf-templates');

				if(!empty($files)) {
					foreach($files as $file) {
						if(substr($file, 0, 7) === 'acf-cf-') {

							$value = str_replace(array('acf-cf-', '.php'), '', $file);
							$field['choices'][ $value ] = $value;

						}
					}

				}


				}
				
				// return the field
				return $field;
				

			}

			add_filter('acf/load_field/key=field_552ecdbabf9a7', 'acf_load_templates');
			add_filter('acf/load_field/key=field_552easr32ea7', 'acf_load_templates');





			function acf_load_post_types( $field ) {

				// reset choices
				$post_types = get_post_types();
				$exclude = array('post','page','acf-field-group', 'acf-field', 'revision', 'attachment', 'nav_menu_item');

				foreach($exclude as $name) {
					$key = array_search($name, $post_types);

					unset($post_types[$key]);
				}

				$post_types = array_values($post_types);
				foreach($post_types as $type) {
					$value = $type;
					$label = $type;

					$field['choices'][ $value ] = $label;
				}


				// return the field
				return $field;

			}

			add_filter('acf/load_field/key=field_551c587df4125', 'acf_load_post_types');





			function acf_load_field_groups( $field ) {

				// reset choices
				$groups = get_posts(array("post_type" => "acf-field-group", 'posts_per_page'=>-1, 'numberposts'=>-1));

				foreach($groups as $group)  {

					$value = $group->ID;
					$label = $group->post_title;

					$field['choices'][ $value ] = $label;

				}


				// return the field
				return $field;

			}

			add_filter('acf/load_field/key=field_551c5885f4126', 'acf_load_field_groups');

	endif;

?>