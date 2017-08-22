<?php

// step 1: Create a function that contains the menu-building code
function my_plugin_menu() {
	// create an options level sub menu
	add_options_page('Node WPAPI Auth Options', 'Node-WPAPI Authentication',
		'manage_options', 'nwpapi_auth', 'my_plugin_options');
	// call register_settings function
	add_action('admin_init', 'register_my_plugin_options');
}

function register_my_plugin_options() {
	// register plugin settings
	register_setting('my_plugin_options_group', 'admin_username');
	register_setting('my_plugin_options_group', 'admin_password');
}

// step 2: Register the menu function using the admin_menu action hook
add_action('admin_menu', 'my_plugin_menu');

// step 3: Create the HTML Output for the page(screen) displayed when the menu item is clicked
function my_plugin_options() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

		?>

    <div class="wrap" id="opt-wrap">

		<?php
		// Now display the settings editing screen
		// header
echo "<h2 id='nwpapi_auth_title'>" . __( 'Node-WPAPI :<br/> Basic Authentication Options', 'nwpapi_auth' ) . "</h2>";

// settings form
?>


<form name="form1" action='options.php' method='post'>
	<?php settings_fields('my_plugin_options_group'); ?>

	<?php do_settings_sections('my_plugin_options_group'); ?>

	<p id='nwpapi_auth_usr'>
		<?php _e("Admin Username:", 'nwpapi_auth'); ?>
		<input type= "text" name = "admin_username"
               value="<?php echo esc_attr( get_option('admin_username') ) ?>"
		       />
	</p>
	<p id='nwpapi_auth_pw'>
		<?php _e("Admin Password:", 'nwpapi_auth'); ?>
		<input type= "text" name = "admin_password"
		       value="<?php echo esc_attr( get_option('admin_password') ) ?>"
		       />
	</p>
    <div id='nwpapi_auth_submit'>
    <?php submit_button( __('Save'), 'opt_btn', 'save', 'true'); ?>
    </div>
</form>
</div>

<?php

}

