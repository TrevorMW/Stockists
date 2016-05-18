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

    if( $params != null)
    {
      extract( $params, EXTR_SKIP );
    }

    if( file_exists( $file ) )
    {
      ob_start();

      include( $file );

      return ob_get_clean();
    }
  }
}