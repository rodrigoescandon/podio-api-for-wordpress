<?php

/*
Plugin Name: Podio API for Wordpress
Description: Makes the Podio API (https://developers.podio.com/) available to Wordpress. (Themes, plugins…)
Author: Tienda de Comercios
Version: 1.0
Author URI: http://tiendadecomercios.com
*/

function header_wppo () {

  $podio_pass_var = get_option('wppo_podio_pass_var');

  // Load Podio lib
  require_once(dirname(__FILE__) . '/_/Podio/PodioAPI.php');
  // Setup client
  $client_id = $podio_pass_var['client_id'];
  $client_secret = $podio_pass_var['client_secret'];
  Podio::setup($client_id, $client_secret);
  
  // Obtain access token using authorization code from the first step of the authentication flow
  // Podio::authenticate('authorization_code', array('code' => $_GET['code'], 'redirect_uri' => $redirect_uri));
  
  // Alternatively you can supply a username and password directly. E.g.:
  
  // It wasn't there, so regenerate the data and save the transient
  $username = $podio_pass_var['user'];
  $password = $podio_pass_var['password'];
  
  try {
    Podio::authenticate('password', array('username' => $username, 'password' => $password));  
    // Authentication was a success, now you can start making API calls.
  }
  catch (PodioError $e) {
    // Something went wrong. Examine $e->body['error_description'] for a description of the error.
  }
  
}

add_action('send_headers', 'header_wppo');

// Option page
require_once 'wppo-options.php';


?>