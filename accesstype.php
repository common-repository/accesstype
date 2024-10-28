<?php
/*
 * Plugin Name: Accesstype
 * Text Domain: Accesstype
 * Plugin URI: https://www.accesstype.com
 * Description: A subscriptions and access manangement platform.
 * Version: 1.0.5
*/


// Exit if accessed directly
defined( 'ABSPATH' ) || die( "Can't access directly" );

//Define global variables...
define( 'ACCESSTYPE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACCESSTYPE_URL',  plugin_dir_url(__FILE__)  );

/**
 * Instantiate setup class, require helper files
 *
 * @since 1.0.0
 */

function load_accesstype_plugin() {
  require_once( 'lib/firebase/php-jwt/src/JWT.php' );
  require_once( 'includes/functions/functions.php' );
  require_once( 'includes/functions/metaboxes.php' );
  require_once( 'includes/shortcodes.php' );
  require_once( 'includes/apis.php' );
}

add_action('plugins_loaded', 'load_accesstype_plugin');
?>