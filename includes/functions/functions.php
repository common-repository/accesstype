<?php

  use Firebase\JWT\JWT;

  /**
   * create jwt token if user is logged in or return null
   *
   * @since 1.0
   */
  function get_accesstype_jwt_token() {
    if ( is_user_logged_in() ) {
      $current_user = wp_get_current_user();
      $jwt_secret = get_option('accesstype-jwt-secret');
      $payload = array(
        'email' => $current_user->user_email,
        'id' => $current_user->ID,
        'name' => $current_user->display_name,
        'provider' => 'wordpress'
      );

      $jwt = JWT::encode($payload, $jwt_secret, 'HS256');

      return $jwt;
    }
    else
      return null;
  }


  /**
   * create custom login url
   *
   * @since 1.0.5
   */
  function custom_login_url() {
    $login_page_id = get_option('accesstype-login-redirect-page');
    if ( empty( $login_page_id ) ) {
      $login_page_url = get_site_url() . '/login';
    }
    else {
      $login_page_url = get_permalink( get_post( $login_page_id ) ) ;
    }

    $redirect_url = get_permalink();
    $custom_login_url = add_query_arg( 'redirect_to', urlencode( $redirect_url ), $login_page_url);
    $login_page_url = esc_url( $custom_login_url );

    return $login_page_url;
  }

  if(!is_admin()) {
    /**
     * add async or defer while loading script
     *
     * @since 1.0
     */
    // Async load @author Mike Kormendy
    // source: https://stackoverflow.com/a/40553706
    function accesstype_add_asyncdefer_attribute($tag, $handle) {
      // if the unique handle/name of the registered script has 'async' in it
      if (strpos($handle, 'async') !== false)
        return str_replace( '<script ', '<script async ', $tag );
      // if the unique handle/name of the registered script has 'defer' in it
      else if (strpos($handle, 'defer') !== false)
        return str_replace( '<script ', '<script defer ', $tag );
      // otherwise skip
      else
        return $tag;
    }

    add_filter('script_loader_tag', 'accesstype_add_asyncdefer_attribute', 10, 2);
  }

  // set default accesstype-env to prod. Can be changed to local for development and stg for testing.
  add_option('accesstype-env', 'prod');
  add_option('accesstype-primary-color', '#e84646');
  add_option('accesstype-secondary-color', '#3c87e2');
  add_option('accesstype-post-restriction-selector', 'article .entry-content');
  add_option('accesstype-lead-in-elements', 1);
  add_option('accesstype-plan-heading', 'Choose Plan');
  add_option('accesstype-plan-sub-heading', 'To enjoy extensive digital access to our journalism, subscribe to one of our plans below.');


  // load assets on frontend
  add_action('wp_enqueue_scripts', 'accesstype_load_skywalker' );

  /**
   * Load script for skywalker which we use for render components
   *
   * @since 1.0.0
   */
  function accesstype_load_skywalker() {
    $account_key = get_option('accesstype-account-key');

    switch (get_option('accesstype-env')) {
      case "stg":
        $skywalker_host = 'https://staging.accesstype.com';
        break;
      case "local":
        $skywalker_host = 'http://localhost:8001';
        break;
      default:
        $skywalker_host = 'https://www.accesstype.com';
    }

    // add async or defer in the name of script, function is available in functions.php
    wp_enqueue_script('accesstype_skywalker_async', $skywalker_host . '/frontend/v2/ui/accesstype?key='. $account_key);
    wp_enqueue_script('accesstype_js_ui', ACCESSTYPE_URL . 'public/scripts/accesstype_ui.js', array('accesstype_skywalker_async'));
  }

//-----------------------Admin related changes start--------------------------

  /**
   * display accesstype settings in admin panel
   *
   * @since 1.0.0
   */
  function render_accesstype_admin() {
    require_once ACCESSTYPE_PATH . 'includes/functions/accesstype_admin.php';
  }


  /**
   * Register accesstype configuration to database
   *
   * @since 1.0.0
   */
  function update_acccesstype_settings() { // whitelist options
    register_setting( 'accesstype-settings', 'accesstype-account-key' );
    register_setting( 'accesstype-settings', 'accesstype-jwt-secret' );
    register_setting( 'accesstype-configure', 'accesstype-subscription-plan-page' );
    register_setting( 'accesstype-configure', 'accesstype-login-redirect-page' );
    register_setting( 'accesstype-configure', 'accesstype-primary-color' );
    register_setting( 'accesstype-configure', 'accesstype-secondary-color' );
    register_setting( 'accesstype-configure', 'accesstype-post-restriction-selector' );
    register_setting( 'accesstype-configure', 'accesstype-lead-in-elements' );
    register_setting( 'accesstype-configure', 'accesstype-plan-heading' );
    register_setting( 'accesstype-configure', 'accesstype-plan-sub-heading' );
  }
  add_action( 'admin_init', 'update_acccesstype_settings' );


  /**
   * accesstype menu in admin panel sidebar
   *
   * @since 1.0.0
   */
  function accesstype_admin_menu() {
    if ( !current_user_can( 'manage_options' ) )  {
      return;
    }

    $accesstype_logo = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNyIgaGVpZ2h0PSIxNyIgdmlld0JveD0iMCAwIDE3IDE3Ij4KICAgIDxnIGZpbGw9Im5vbmUiPgogICAgICAgIDxwYXRoIGZpbGw9IiNFMUUxRTEiIGQ9Ik00LjIwNSAwTDE1Ljk1IDAgMTUuOTUgMTIuMjEyeiIgb3BhY2l0eT0iLjgiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC4wMjUgLjAyNSkiLz4KICAgICAgICA8cGF0aCBmaWxsPSIjRkZGIiBkPSJNMi4zMzYgMS44NjlMMTQuMDgxIDEuODY5IDE0LjA4MSAxNC4wODF6IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSguMDI1IC4wMjUpIi8+CiAgICAgICAgPHBhdGggZmlsbD0iI0I1QjVCNSIgZD0iTTAgMy43MzhMMTEuNzQ1IDMuNzM4IDExLjc0NSAxNS45NXoiIG9wYWNpdHk9Ii41NzciIHRyYW5zZm9ybT0idHJhbnNsYXRlKC4wMjUgLjAyNSkiLz4KICAgIDwvZz4KPC9zdmc+Cg==';

    add_menu_page(
      'Accesstype',
      'Accesstype',
      'manage_options',
      'accesstype-settings',
      'render_accesstype_admin',
      $accesstype_logo
    );
  }
  add_action( 'admin_menu', 'accesstype_admin_menu' );


  /**
   * load assets for admin
   *
   * @since 1.0.0
   */
  function accesstype_load_admin_assets() {
    wp_enqueue_style('accesstype-admin-css', ACCESSTYPE_URL . 'admin/styles/accesstype_admin.css');
    wp_enqueue_style('accesstype-google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

    wp_enqueue_script('accesstype-admin-js', ACCESSTYPE_URL . 'admin/scripts/accesstype_admin.js','', '', false );
    wp_enqueue_script('accesstype-quick-edit-script', ACCESSTYPE_URL . 'admin/scripts/accesstype_populate.js', array('jquery'));

    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', ACCESSTYPE_URL . 'admin/scripts/accesstype_populate.js', array( 'wp-color-picker' ), false, true );
  }
  add_action( 'admin_enqueue_scripts', 'accesstype_load_admin_assets' );


  /**
   * bulk update of posts for accesstype visibility
   *
   * @since 1.0
   */
  function accesstype_save_bulk_edit_post() {
    /* Verify the nonce before proceeding. */
    if ( ! wp_verify_nonce( $_POST['accesstype_post_class_nonce'], 'accesstype_update_post_meta_nonce' ) )
      die();

    $post_ids = ( ! empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : array();
    $post_ids = array_map( 'absint', $post_ids );

    $accesstype_visibility  = sanitize_key(( ! empty( $_POST[ 'accesstype_visibility' ] ) ) ? $_POST[ 'accesstype_visibility' ] : null);

    // if everything is in order
    if ( ! empty( $post_ids ) && is_array( $post_ids ) ) {
      foreach( $post_ids as $post_id ) {
        $post = get_post($post_id);
        $post_type = get_post_type_object( $post->post_type );
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
          continue;
        update_post_meta( $post_id, 'accesstype_visibility', $accesstype_visibility );
      }
    }
  }
  add_action( 'wp_ajax_accesstype_save_bulk', 'accesstype_save_bulk_edit_post' );

  /**
   * add custom column accesstype visibility for quick and bulk update of post
   *
   * @since 1.0
   */
  function accesstype_add_custom_admin_column($columns) {
    $new_columns = array();

    $new_columns['accesstype_visibility'] = 'Accesstype Visibility';

    return array_merge($columns, $new_columns);
  }
  add_filter('manage_posts_columns', 'accesstype_add_custom_admin_column', 10, 2);


  /**
   * customise the data for our custom column, it's here we pull in metadata info for each post. These will be referred to in our JavaScript file for pre-populating our quick-edit screen
   *
   * @since 1.0
   */
  function accesstype_manage_custom_admin_columns($column_name, $post_id) {
    $html = '';
    if($column_name == 'accesstype_visibility'){
      $accesstype_visibility = esc_attr(get_post_meta($post_id, 'accesstype_visibility', true));
      $html .= '<div class="accesstype-visibility" id="accesstype_visibility_' . $post_id . '">';
      $html .= $accesstype_visibility;
      $html .= '</div>';
    }
    echo $html;
  }
  add_action( 'manage_posts_custom_column' , 'accesstype_manage_custom_admin_columns', 10, 2 );

  /**
   * HTML of the accesstype visibility select box in quick and bulk edit of post
   *
   * @since 1.0
   */
  function accesstype_display_quick_edit_custom($column_name) {
    // Use nonce for verification
    wp_nonce_field( 'accesstype_update_post_meta_nonce', 'accesstype_post_class_nonce' );
    //output of accesstype visibility select field in quick and bulk edit
    if($column_name == 'accesstype_visibility') {
      global $post;
      $options = array('public', 'login', 'subscription'); ?>
      <!--
        please note: the <fieldset> classes could be:
        inline-edit-col-left, inline-edit-col-center, inline-edit-col-right
        each class for each column, all columns are float:left,
        so, if you want a left column, use clear:both element before
        the best way to use classes here is to look in browser "inspect element" at the other fields
      -->
      <fieldset class="inline-edit-col-center ">
        <div class="inline-edit-group wp-clearfix">
          <label class="alignleft" for="accesstype_visibility">Accesstype Visibility</label>
          <select name="accesstype_visibility" id="accesstype_visibility" class="accesstype-visibility accesstype-mt-10">
            <?php foreach($options as $key => $value) { ?>
              <option value="<?php echo $value;?>"><?php echo $value; ?></option>
            <?php } ?>
          </select>
        </div>
      </fieldset>
      <?php
    }
  }
  add_action('quick_edit_custom_box', 'accesstype_display_quick_edit_custom', 10, 1);
  add_action('bulk_edit_custom_box',  'accesstype_display_quick_edit_custom', 10, 1);

  /**
   * Call skywalker function to decide whether story is accessible to user or not
   *
   * @since 1.0
   */
  function accesstype_is_story_accessible($content) {
    global $post;
    if(!( is_single($post) && 'post' == get_post_type() ))
      return $content;

    $accesstype_visibility = get_post_meta( $post->ID, 'accesstype_visibility', true ) ?: 'public';
    if( $accesstype_visibility == 'public' )
      return $content;

    $jwt_token = get_accesstype_jwt_token() ?: null;
    $plan_page_id = get_option('accesstype-subscription-plan-page');
    $plans_page_url = esc_url( get_permalink( get_post( $plan_page_id ) ) );
    $reader_id_url = get_site_url(null, '/wp-json/accesstype/v1/set-at-meter-cookie');
    $login_page_url = custom_login_url();
    $selector = get_option('accesstype-post-restriction-selector');
    $no_of_elements = get_option('accesstype-lead-in-elements');
    $primary_color = get_option('accesstype-primary-color');
    $secondary_color = get_option('accesstype-secondary-color');
    wp_enqueue_script('accesstype_metering', ACCESSTYPE_URL . 'public/scripts/accesstype_metering.js','','1.0',true);
    wp_localize_script( 'accesstype_metering', 'accesstype_metering',
        array(
            'jwt' => $jwt_token,
            'subscriptionPlansPageUrl' => $plans_page_url,
            'loginPageUrl' => $login_page_url,
            'readerIdUrl' => $reader_id_url,
            'postId' => $post->ID,
            'selector' => $selector,
            'noOfElements' => $no_of_elements,
            'primaryColor' => $primary_color,
            'secondaryColor' => $secondary_color
        )
      );
    return $content;
  }
  add_filter( 'the_content', 'accesstype_is_story_accessible' );
  
//-----------------------Admin related changes end--------------------------
?>