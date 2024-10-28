<?php
function get_accesstype_post_attributes( $data ) {
  $post_id = $data['story-id'];
  $post = get_post( absint($post_id) );

  if ( empty( $post ) ) {
    return new WP_REST_Response(null, 404);
  }

  $accesstype_visibility = get_post_meta( $post_id, 'accesstype_visibility', true ) ?: 'public';
  $accesstype_published_at = get_the_time( 'U', true, $post_id );
  $published_at_type = gettype($accesstype_published_at);

  $accesstype_post_attributes = array(
    'visibility' => $accesstype_visibility
  );

  if ($published_at_type == 'integer') {
    $accesstype_post_attributes = $accesstype_post_attributes + array('published-at' => $accesstype_published_at);
  }

  return new WP_REST_Response($accesstype_post_attributes, 200);
}

function set_accesstype_meter_cookie() {
  if(!isset($_COOKIE['at-meter'])) {
    setcookie('at-meter', bin2hex(openssl_random_pseudo_bytes(8)),
     accesstype_cookie_options()
    );
  }
  return new WP_REST_Response('{}', 200);
}

add_action( 'rest_api_init', function () {
  // Sample route: /wp-json/accesstype/v1/post/attributes?story-id=25
  register_rest_route( 'accesstype', '/v1/post/attributes', array(
    'methods' => 'GET',
    'callback' => 'get_accesstype_post_attributes',
  ));

  // Sample route: POST /wp-json/accesstype/v1/set-at-meter-cookie
  register_rest_route( 'accesstype', '/v1/set-at-meter-cookie', array(
    'methods' => 'POST',
    'callback' => 'set_accesstype_meter_cookie',
  ));
});

function accesstype_cookie_options() {
  if(get_option('accesstype-env') == 'local') {
     return ([
              'expires' => mktime(07,28,00,10,21,2075),
              'path' => '/',
              'domain' => $_SERVER['SERVER_NAME'],
              'httponly' => false
            ]);
  }
  else {
     return ([
              'expires' => mktime(07,28,00,10,21,2075),
              'path' => '/',
              'domain' => $_SERVER['SERVER_NAME'],
              'secure' => true,
              'httponly' => false,
              'SameSite' => 'None'
            ]);
  }
}
?>