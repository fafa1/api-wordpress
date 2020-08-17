<?php

function api_usuario_put($request) {

  $user = wp_get_current_user();
  $user_id = $user->ID;

  if($user_id > 0) {
    $email = sanitize_email($request['email']);
    $nome = sanitize_text_field($request['nome']);
    $senha = $request['senha'];
    $rua = sanitize_text_field($request['rua']);
    $numero = sanitize_text_field($request['numero']);
    $cidade = sanitize_text_field($request['cidade']);

    $email_exists = email_exists($email);

    // Só é possível atualizar se for o mesmo email ou se o email existir!
    // É preciso ter esses nome certos pois são fixo do wordpress (user_pass, user_email)

    if($email_exists || $email_exists === $user_id) {
      $response = array(
        'ID' => $user_id,
        'user_pass' => $senha,
        'user_email' => $email,
        'display_name' => $nome,
        'first_name' => $nome
      );
      wp_update_user($response);

      update_user_meta($user_id, 'rua', $rua);
      update_user_meta($user_id, 'numero', $numero);
      update_user_meta($user_id, 'cidade', $cidade);
    } else {
      $response = new WP_Error('email', 'Email ja cadastrado', array('status' => 403));
    }
} else {
  $response = new WP_Error('permissão', 'usuário não possui permissão', array('status' => 401));
}
  return rest_ensure_response($response);
}

function registar_api_usuario_put() {
  register_rest_route('api', '/usuario', array(
    array(
      'methods' => WP_REST_Server::EDITABLE,
      'callback' => 'api_usuario_put'
    )
  ));
}

add_action('rest_api_init', 'registar_api_usuario_put');
?>