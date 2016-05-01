<?php

/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/29/16
 * Time: 9:08 PM
 */

class Stockist_Utils
{
  public static function loadPluginView( $name )
  {
    $file = STOCKIST_PLUGIN_DIR . 'assets/views/' . $name ;

    if( file_exists( $file ) )
    {
      require_once( $file );
    }
  }

  public static function mapsKeySet()
  {

  }
}