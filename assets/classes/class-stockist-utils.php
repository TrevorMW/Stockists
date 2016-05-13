<?php

/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/29/16
 * Time: 9:08 PM
 */

class Stockist_Utils
{
  public static function loadPluginView( $name, $params = null )
  {
    $file = STOCKIST_PLUGIN_DIR . 'assets/views/' . $name ;

    extract( $params, EXTR_SKIP );

    if( file_exists( $file ) )
    {
      ob_start();

      include( $file );

      return ob_get_clean();
    }
  }

  function get_template_part_with_data($slug = null, $name = null, array $params = array())
  {
    global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

    do_action( "get_template_part_{$slug}", $slug, $name );

    $templates = array();

    if (isset($name))
      $templates[] = "/views/{$slug}-{$name}.php";

    $templates[] = "/views/{$slug}.php";

    $_template_file = locate_template($templates, false, false);

    if (is_array($wp_query->query_vars))
    {
      extract($wp_query->query_vars, EXTR_SKIP);
    }
    extract($params, EXTR_SKIP);

    require($_template_file);
  }
}