<?php
/**
 * metaboxes for accesstype plugin
 *
 * @since 1.0.0
 */

// Fire our meta box setup function on the post editor screen
add_action( 'load-post.php', 'accesstype_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'accesstype_post_meta_boxes_setup' );

/**
 * Register metabox visibility in post
 *
 * @since 1.0.0
 */
function accesstype_post_meta_boxes_setup() {
  add_action( 'add_meta_boxes', 'accesstype_add_post_meta_boxes' );
}

/**
 * Render accesstype visibility in edit post
 *
 * @since 1.0.0
 */
function render_accesstype_visibility() {
  require_once ACCESSTYPE_PATH . 'includes/functions/accesstype_visibility.php';
}

/**
 * add metabox accesstype visibility
 *
 * @since 1.0.0
 */
function accesstype_add_post_meta_boxes() {
  add_meta_box(
    'accesstype-visibility',      // Unique ID
    'Accesstype Visibility',    // Title
    'render_accesstype_visibility',   // Callback function
    'post',         // Admin page (or post type)
    'advanced',         // Context
    'high'         // Priority
  );
}

/**
 * save post hook for accesstype custom meta
 *
 * @since 1.0.0
 */
function accesstype_save_post_meta($post_ID, $post) {
  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['accesstype_post_class_nonce'] ) || ! wp_verify_nonce( $_POST['accesstype_post_class_nonce'], 'accesstype_update_post_meta_nonce' ))
    return $post_ID;

  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_ID ) )
    return $post_ID;

  // /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['accesstype_visibility'] ) ? sanitize_html_class( $_POST['accesstype_visibility'] ) : null );

  $meta_key = 'accesstype_visibility';

  /* update the meta value */
  update_post_meta( $post_ID, $meta_key, $new_meta_value );
}

// add hook for saving accesstype data for post
add_action( 'save_post', 'accesstype_save_post_meta', 10, 2);
?>