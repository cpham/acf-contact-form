# Advanced Custom Fields Contact Form Extension

This is an extension for Advanced Custom Fields 5 for Wordpress, which enables you to create a contact form using an existing Field Group in ACF. It will also add a new post to a Custom Post Type of your choosing.

##Requirements
- Advanced Custom Fields 5
- jQuery

##Future Additions
- Custom Email Templates
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
- Page Link
- Image*
- File*

*BE AWARE: Image and file fields use the wordpress media library if the user is currently signed in as a wordpress user. This may expose other images and files you have in your media library.

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
  - Recipient Email: Enter the email address you would like form submissions to be sent to.
  - Return URL: Select the wordpress page you would like form submissions to redirect to, such as a Thank You page.
  - Don't Send Email: Check this box if you only want to record form submissions in WordPress, without sending an email

##Placing a form in your page

To place a form in your page content, use this shortcode, and use the ID number of the Form Rule you want to use from your ACF Form options page. Example: [acf_contact id="1"] 

To use it within your template, add this before any other HTML (before get_header()):
  <?php acf_form_head(); ?>
  
Then add this where you want the form to appear: <?php do_shortcode('[acf_contact id="1"]'); ?>
