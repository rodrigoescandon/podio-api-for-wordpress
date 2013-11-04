<?php
/*
 * Wordpress Podio API
 * Options page
 *
 */
add_action('admin_menu', 'wppo_add_option');

function wppo_add_option() {
	//add_plugins_page( $page_title, $menu_title, $capability, $menu_slug, $function);
	add_plugins_page('Wordpress Podio API', 'Wordpress Podio API', 'manage_options', 'wppo_options_page', 'wppo_options_page_display');
}

//Content of the option page
function wppo_options_page_display() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2>Wordpress Podio API</h2>

		<form action="options.php" method="post">
			<?php
			//Output Error
			settings_errors();

			//Output nonce, action, and option_page
			settings_fields('wppo_options_group');

			//Prints out all settings sections added to a particular settings page
			do_settings_sections('wppo_options_page');

			submit_button();
			?>
		</form>

	</div>
	<?php
}

//Define options
add_action('admin_init', 'wppo_admin_init');

function wppo_admin_init() {
	//register_setting( $option_group, $option_name, $sanitize_callback );
	register_setting('wppo_options_group', 'wppo_podio_pass_var', 'wppo_podio_pass_var_validate');

	//On créer une section dans nos options
	//add_settings_section( $id, $title, $callback, $page );
	add_settings_section('wppo_podio_pass_section', __('Podio connection', 'ab-wppo-locales'), 'wppo_podio_pass_section_text', 'wppo_options_page');

	//Register a settings field to a settings page and section.
	//add_settings_field( $id, $title, $callback, $page, $section, $args );
	add_settings_field('wppo_podio_client_id', 'Podio client ID', 'wppo_podio_client_id_display', 'wppo_options_page', 'wppo_podio_pass_section');
	add_settings_field('wppo_podio_client_secret', 'Podio client secret', 'wppo_podio_client_secret_display', 'wppo_options_page', 'wppo_podio_pass_section');
	add_settings_field('wppo_podio_access_token', 'Podio username', 'wppo_podio_username_display', 'wppo_options_page', 'wppo_podio_pass_section');
	add_settings_field('wppo_podio_access_token_secret', 'Podio password', 'wppo_podio_access_password_display', 'wppo_options_page', 'wppo_podio_pass_section');
}

//Le text au dessus des options
function wppo_podio_pass_section_text() {
	?>
	<p>
		Enter your client ID, client secret, username and password to make the <a href="https://developers.podio.com/" target="_blank">Podio API</a> available to Wordpress.
	</p>
	<?php
}

function wppo_podio_client_id_display() {

	$podio_pass_var = get_option('wppo_podio_pass_var');
	$client_id = $podio_pass_var['client_id'];
	//Attention le "name" du input doit correspondre au nom de l'option
	?>
	<input id='wppo_podio_pass_var[client_id]' name='wppo_podio_pass_var[client_id]' type='text' value='<?php echo $client_id; ?>' class="widefat"/>
	<?php
}
function wppo_podio_client_secret_display() {

	$podio_pass_var = get_option('wppo_podio_pass_var');
	$client_secret = $podio_pass_var['client_secret'];
	//Attention le "name" du input doit correspondre au nom de l'option
	?>
	<input id='wppo_podio_pass_var[client_secret]' name='wppo_podio_pass_var[client_secret]' type='text' value='<?php echo $client_secret; ?>' class="widefat"/>
	<?php
}
function wppo_podio_username_display() {

	$podio_pass_var = get_option('wppo_podio_pass_var');
	$user = $podio_pass_var['user'];
	//Attention le "name" du input doit correspondre au nom de l'option
	?>
	<input id='wppo_podio_pass_var[user]' name='wppo_podio_pass_var[user]' type='text' value='<?php echo $user; ?>' class="widefat"/>
	<?php
}
function wppo_podio_access_password_display() {

	$podio_pass_var = get_option('wppo_podio_pass_var');
	$password = $podio_pass_var['password'];
	//Attention le "name" du input doit correspondre au nom de l'option
	?>
	<input id='wppo_podio_pass_var[password]' name='wppo_podio_pass_var[password]' type='text' value='<?php echo $password; ?>' class="widefat"/>
	<?php
}

function wppo_podio_pass_var_validate($podio_variable) {

	$valid_option = array();

	foreach ($podio_variable as $option => $value) {
		if( !empty( $value ) ){
			$valid_option[$option] = $value;
		}
	}

	return $valid_option;
}