<?php
/**
 * Plugin Name: Advanced Custom Fields Contact Forms
 * Plugin URI: http://vi.ndicate.me
 * Description: Create forms with ACF
 * Version: 1.0.0
 * Author: Christine Pham

 * License:  GPL2
 */

//Make this plugin load after all other plugins

function acfcf_plugin_last() {
	// ensure path to this file is via main wp plugin path
	$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
	$this_plugin = plugin_basename(trim($wp_path_to_this_file));
	$active_plugins = get_option('active_plugins');
	$this_plugin_key = array_search($this_plugin, $active_plugins);
	array_splice($active_plugins, $this_plugin_key, 1);
	array_push($active_plugins, $this_plugin);
	update_option('active_plugins', $active_plugins);
}
add_action("activated_plugin", "acfcf_plugin_last");



//Make sure ACF is installed
if( function_exists('acf_add_options_page') ) {

	//Add settings page
	acf_add_options_page( 'ACF Forms' );

	//Add options to settings page
	require_once('acf-contact-form-settings.php');
	require_once('acf-contact-render-email.php');
	require_once('acf-contact-process.php');

	require_once('acf-contact-shortcode.php');
}


?>