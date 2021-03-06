<?php
/**
 * @package Stockists
 */
/*
Plugin Name: Stockists
Plugin URI:
Description: Store Locator
Version: 1.0.0
Author: Trevor Wagner
License: GPLv2 or later

*/

// Make sure we don't expose any info if called directly
if( !function_exists( 'add_action' ) )
  exit;

define( 'STOCKISTS_VERSION', '1.0.0' );
define( 'STOCKISTS_MINIMUM_WP_VERSION', '4.0' );
define( 'STOCKIST_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'STOCKIST_PLUGIN_FILE', __FILE__ );
define( 'STOCKIST_PLUGIN_ASSETS', STOCKIST_PLUGIN_DIR . 'assets/' );
define( 'STOCKIST_PLUGIN_JS_PATH', plugin_dir_url( __FILE__ ). 'assets/js' );
define( 'STOCKIST_PLUGIN_CSS_PATH',  plugin_dir_url( __FILE__ ) . 'assets/css' );
define( 'STOCKIST_PLUGIN_MEDIA_PATH',  plugin_dir_url( __FILE__ ) . 'assets/media' );
define( 'STOCKIST_PLUGIN_VIEWS_PATH',  STOCKIST_PLUGIN_ASSETS . 'views' );

// LOAD CLASSES JIT
spl_autoload_register( function( $className )
{
  $classDir  = realpath( STOCKIST_PLUGIN_DIR .'/assets/classes/' );
  $classFile = '/class-' . str_replace( '_', '-', strtolower( $className ) ) . '.php';

  if( file_exists( $classDir . $classFile ) )
    require_once $classDir . $classFile;
});

// INITIALIZE PLUGIN
$stockists = new Stockists();
$stockists->init( __FILE__, $stockists );

