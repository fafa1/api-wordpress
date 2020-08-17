<?php 

$template_diretorio = get_template_directory();

require_once($template_diretorio . "/custom-post-type/produto.php");
require_once($template_diretorio . "/custom-post-type/transacao.php");

require_once($template_diretorio . "/endpoints/usuario-posts.php");
require_once($template_diretorio . "/endpoints/usuario-put.php");
require_once($template_diretorio . "/endpoints/usuario-get.php");
require_once($template_diretorio . "/endpoints/produto-posts.php");
require_once($template_diretorio . "/endpoints/produto-get.php");

function get_produto_id_by_slug($slug) {
  $query = new WP_Query(array(
    'name' => $slug,
    'post_type' => 'produto',
    'numberposts' => 1,
    'fields' => 'ids'
  ));

  $posts = $query->get_posts();

  return $posts[0];
}

function expire_token() {
  return time() + (60 * 60 * 24);
}
add_action('jwt_auth_expire', 'expire_token');

?>