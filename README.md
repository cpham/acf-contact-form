# Advanced Custom Fields Contact Form Extension (Beta)

This is an extension for Advanced Custom Fields 5 for Wordpress, which enables you to create a contact form using an existing Field Group in ACF. It will also add a new post to a Custom Post Type of your choosing.

##Requirements
- Advanced Custom Fields 5
- jQuery

##Future Additions
- More field support
 
##Supported Fields
Currently, this plugin supports the following fields:

- Text Field
- Email Field
- Select Field
- Checkbox Field
- Radio Field
- Post Object Field
- Tabs
- Text Area
- Number
- URL
- Repeater
- User
- Taxonomy
- oEmbed (links to edit post screen in wp-admin)
- Password 
- Page Link
- Image*
- File*


I will add support for all other fields in the future.

##Installation
- Download this plugin and upload it to your wp-content/plugins folder
- Activate the "Advanced Custom Fields Contact Forms" plugin in your WordPress admin
 
##Creating a form
- Create a Custom Post Type (You may want to make your post type NON-public)
- Create a Field Group
- Add fields to your Field Group. These will be your form fields. (See Supported Fields).
- Add your Custom Post Type to the Location Rules under your Field Group
- Go to the ACF Forms options page (/wp-admin/admin.php?page=acf-options-acf-forms)
- Add a Form Rule
  - Post Type: Select your Custom Post Type
  - Field Group: Select your Field Group
  - Title: Enter the text you would like to appear in your email Subject and Post Title. You can use the form field values by using the acf shortcode and using "newpost" for the post_id.Example: New Inquiry by [acf field="first_name" post_id="newpost"] [acf field="last_name" post_id="newpost"]
  - Admin Email: Enter the email address you would like form submissions to be sent to.
  - Don't Send Email: Check this box if you only want to record form submissions in WordPress, without sending an email
  - Admin Email Template: Select the custom templace you want to be used for the Admin email, or leave blank to use the default template provided by the plugin
  - Customer Email: The name of the field within the Field Group where the customer will be inputting their email address. Whatever the customer inputs in this form field will be used as the recipient of the Customer Confirmation Email
  - Customer Email Title: This will be used as the subject line of the customer email.
  - Don't Send Customer Email: Check this box if you DO NOT want to send a confirmation email to the customer. (This is checked by default)
  - Customer Email Template: Select the custom templace you want to be used for the Customer Confirmation email, or leave blank to use the default template provided by the plugin

##Custom Email Templates
To send emails using a custom HTML template, simply create a template using `the_field()` and `get_field()` functions provided by ACF to display the custom field values from the form submission. This feature is helpful if you need to parse the form data before it gets emailed to you.

Example: 

    <p><?php the_field('first_name'); ?> <?php the_field('last_name'); ?> has submitted an inquiry.</p>

- Templates must be placed within a directory in your current theme named "acf-cf-templates" 
- Name your template according to the following convention: "acf-cf-[TITLE].php" ([TITLE] can be anything you want)
- Templates will appear under the Admin Email Template and Customer Email Template dropdowns in the ACF Forms options page. Select the template you want to use for each form.

##Akismet Spam Filtering 
To enable Akismet validation in your form, add the following classes to the corresponding form fields you would like to validate, under "Wrapper Attributes." You must have Akismet enabled.

  - akismet-name
  - akismet-email
  - akismet-url
  - akismet-message

##Placing a form in your page

To place a form in your page content, use this shortcode, and use the ID number of the Form Rule you want to use from your ACF Form options page. Example: [acf_contact id="1"]. Other parameters for the acf_contact shortcode include:
 - form_attributes
 - html_before_fields
 - html_after_fields
 - submit_value
 - updated_message
 - label_placement
 - instruction_placement
 - field_el, uploader
 - return 

These parameters are taken from the acf_form() function parameters - please refer to this page for usage: http://www.advancedcustomfields.com/resources/acf_form/

###Placing a form in your theme 

To use it within your template, add this before any other HTML (before get_header()):
  <?php acf_form_head(); ?>
  
Then add this where you want the form to appear: <?php do_shortcode('[acf_contact id="1"]'); ?>
