<?php

function api_usuario_get($request) {

  $user = wp_get_current_user();
  $user_id = $user->ID;

  if($user_id > 0) {
    $user_meta = get_user_meta($user_id);

    $response = array(
      "id" => $user_id,
      "nome" => $user->display_name,
      "email" => $user->user_email,
      "rua" => $user_meta['rua'][0],
      "numero" => $user_meta['numero'][0],
      "cidade" => $user_meta['cidade'][0],
    );
  } else {
    $response = new WP_Error('permissão', 'usuário  não possui permissão', array('status' => 401));
  }

  return rest_ensure_response($response);
}

function registar_api_usuario_get() {
  register_rest_route('api', '/usuario', array(
    array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => 'api_usuario_get'
    )
  ));
}

add_action('rest_api_init', 'registar_api_usuario_get');
?>