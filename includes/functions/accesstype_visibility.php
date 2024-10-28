<?php
 	// Use nonce for verification
  wp_nonce_field( 'accesstype_update_post_meta_nonce', 'accesstype_post_class_nonce' );
  $post = get_post();
  $options = array('subscription', 'public', 'login');
  $current_value = esc_attr( get_post_meta( $post->ID, 'accesstype_visibility', true )  ?: 'public' );
?>
<div class="accesstype-visibility-wrapper">
  <select name="accesstype_visibility" id="accesstype_visibility" class="accesstype-visibility accesstype-mt-10">
    <?php foreach($options as $key => $value) { ?>
      <option value="<?php echo $value;?>" <?php selected($value, $current_value); ?>><?php echo $value; ?></option>
    <?php } ?>
  </select>
  <p class="accesstype-notice accesstype-mt-10">
    <span>Go to accesstype plugin page to know more about visibility</span>
  </p>
</div>
