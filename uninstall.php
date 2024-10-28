<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
  exit;
}

// Delete options
$settingOptions = array(
  'accesstype-account-key',
  'accesstype-jwt-secret',
  'accesstype-env',
  'accesstype-subscription-plan-page',
  'accesstype-login-redirect-page',
  'accesstype-post-restriction-selector',
  'accesstype-lead-in-elements',
  'accesstype-primary-color',
  'accesstype-secondary-color'
);

foreach ( $settingOptions as $settingName ) {
  delete_option( $settingName );
}

// Delete accesstype_visibility post meta
$meta_type  = 'post';           // since we are deleting data for CPT
$object_id  = 0;                // no need to put id of object since we are deleting all
$meta_key   = 'accesstype_visibility';    // Your target meta_key added using update_post_meta()
$meta_value = '';               // No need to check for value since we are deleting all
$delete_all = true;             // This is important to have TRUE to delete all post meta

delete_metadata( $meta_type, $object_id, $meta_key, $meta_value, $delete_all );

?>