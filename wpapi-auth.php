<?php
/**
 * Plugin Name: node-WPAPI wp Global Handle for the WP REST-API 
 * Description: Installs the node-wpapi.js CLIENT | Serves as a Cookie and Basic Authentication handler for the WP REST API, using the node-wpapi client | Access the WP REST API in any javascript file using the 'wp' global object directly.
 * Author: Oluwasegun Somefun
 * Author URI: http://github.com/somefunagba
 * Version: 1.0
 * License: GPL2+
 **/

require_once(dirname(__FILE__) . '/options.php');


add_action('admin_enqueue_scripts', function () {

	wp_register_style( 'option-css', plugins_url( 'options.css', __FILE__) );
	wp_enqueue_style('option-css');

});

function plugin_add_settings_link( $links ) {
	$settings_link = '<a href="options-general.php?page=nwpapi_auth">' . __( 'Settings' ) . '</a>';
	//array_push( $links, $settings_link );
	array_unshift($links, $settings_link);
	return $links;
}

$plugin = plugin_basename( __FILE__ );

/**
 * This plugin includes code from the JSON Basic Authentication Plugin.
 * So JSON Basic Authentication plugin must not be installed else WP throws a conflict.
**/

add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );
function json_basic_auth_handler( $user ) {
	global $wp_json_basic_auth_error;

	$wp_json_basic_auth_error = null;

	// Don't authenticate twice
	if ( ! empty( $user ) ) {
		return $user;
	}

	// Check that we're trying to authenticate
	if ( !isset( $_SERVER['PHP_AUTH_USER'] ) ) {
		return $user;
	}

	$username = $_SERVER['PHP_AUTH_USER'];
	$password = $_SERVER['PHP_AUTH_PW'];

	/**
	 * In multi-site, wp_authenticate_spam_check filter is run on authentication. This filter calls
	 * get_currentuserinfo which in turn calls the determine_current_user filter. This leads to infinite
	 * recursion and a stack overflow unless the current function is removed from the determine_current_user
	 * filter during authentication.
	 */
	remove_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

	$user = wp_authenticate( $username, $password );

	add_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

	if ( is_wp_error( $user ) ) {
		$wp_json_basic_auth_error = $user;
		return null;
	}

	$wp_json_basic_auth_error = true;

	return $user->ID;
}
add_filter( 'determine_current_user', 'json_basic_auth_handler', 20 );

function json_basic_auth_error( $error ) {
	// Passthrough other errors
	if ( ! empty( $error ) ) {
		return $error;
	}

	global $wp_json_basic_auth_error;

	return $wp_json_basic_auth_error;
}
add_filter( 'rest_authentication_errors', 'json_basic_auth_error' );

/*
 * -----------------------------------------------------------------------
 */

/**
 * Register and Enqueue NODE-WPAPI script;
 * Register, Localize and Enqueue the first-party script
**/

add_action('wp_enqueue_scripts', function () {

	// Tell WP about the location of the wpapi script
	// Identify it as "wpapi"

	wp_register_script('wpapi',
		plugin_dir_url(__FILE__) . 'wpapi.min.js',
			array(), false, true
	);

	wp_enqueue_script('wpapi');

	// Register our own 'wpapi-auth.js' first-party script which depends on 'wpapi'
	wp_register_script('wpapi-auth', plugin_dir_url(__FILE__) . 'wpapi-auth.js',
		array('wpapi', 'jquery'), false, true);

	wp_localize_script( 'wpapi-auth', 'WP_API_Settings',
		array(
			'root'     => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce('wp_rest'),
			'ajaxurl'     => admin_url('admin-ajax.php'),
			'username' => get_option('admin_username'),
			'password' => get_option('admin_password')
		)
	);

	// Enqueue our wpapi-auth.js script
	wp_enqueue_script('wpapi-auth');

});


// Check if user is logged in by using Ajax to pass the result of
// PHP WP Conditional Tags, 'is_user_logged_in()' to javascript.

add_action('wp_ajax_is_user_logged_in', function () {
	// this function checks if a user is logged in
	// using ajax and php
	echo is_user_logged_in() ? 'true' : 'false';
	die();

});

add_action('wp_ajax_nopriv_is_user_logged_in', function () {
	// this function checks if a user is logged in
	// using ajax and php
	echo is_user_logged_in() ? 'true' : 'false';
	die();
});
