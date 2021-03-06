<?php

class Stockists
{
  const PLUGIN_NAME    = 'Stockists';
  const PLUGIN_VERSION = STOCKISTS_VERSION;

  public static function getPluginName()
  {
    return self::PLUGIN_NAME;
  }

  public function init( $path, $inst )
  {
    $options  = new Stockist_Options();
    $options->initActions();

    register_activation_hook( $path, array( $inst, 'stkActivate' ) );
    register_deactivation_hook( $path, array( $inst, 'stkDeactivate' ) );

    if( is_admin() )
    {
      add_action( 'admin_menu', array( $options, 'stkBuildOptions' ) );
    }

    add_action( 'init', array( $inst, 'stkRegisterPostTypes' ) );
    add_action( 'wp_enqueue_scripts', array( $inst, 'stkFrontendScripts') );
    add_action( 'admin_enqueue_scripts', array( $inst, 'stkAdminScripts') );
  }

  public function stkActivate()
  {
    flush_rewrite_rules();
  }

  public function stkDeactivate()
  {
    self::stkDeactivatePostTypes();
  }

  public function stkRegisterPostTypes()
  {
    $stockist = new Stockist();

    $labels = array(
      'name'               => 'Stockists',
      'singular_name'      => 'Stockist',
      'menu_name'          => 'Stockists',
      'name_admin_bar'     => 'Stockist',
      'add_new'            => 'Add New',
      'add_new_item'       => 'Add New Stockist',
      'new_item'           => 'New Stockist',
      'edit_item'          => 'Edit Stockist',
      'view_item'          => 'View Stockist',
      'all_items'          => 'All Stockists',
      'search_items'       => 'Search Stockists',
      'parent_item_colon'  => 'Parent Stockists:',
      'not_found'          => 'No Stockists found.',
      'not_found_in_trash' => 'No Stockists found in Trash.'
    );
    $args   = array(
      'labels'               => $labels,
      'public'               => true,
      'publicly_queryable'   => true,
      'show_ui'              => true,
      'show_in_menu'         => true,
      'query_var'            => true,
      'rewrite'              => array( 'slug' => 'stockist' ),
      'capability_type'      => 'post',
      'has_archive'          => true,
      'hierarchical'         => false,
      'menu_position'        => '30',
      'supports'             => array( 'title', 'editor', 'author' ),
      'register_meta_box_cb' => array( $stockist, 'addCustomMetaBoxes' )
    );

    register_post_type( 'stockist', $args );
  }

  public function stkDeactivatePostTypes()
  {
    remove_post_type_support( 'stockist' );
  }

  public function stkAdminScripts()
  {
    $option = new Stockist_Options();

    wp_register_script( 'stockistsAdminJS',
                        STOCKIST_PLUGIN_JS_PATH.'/stockists-admin.js',
                        array('jquery'),
                        null,
                        true );
    wp_register_style( 'stockistsAdminCSS',
                        STOCKIST_PLUGIN_CSS_PATH.'/stockists-admin.css' );
    wp_register_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css' );
    wp_register_script( 'stockistsMaps',
      'https://maps.googleapis.com/maps/api/js?key='.$option->loadedOptions['stk_google_maps_js_api_key'],
      array('jquery'),
      null,
      true );

    wp_enqueue_script( 'stockistsAdminJS' );
    wp_enqueue_script( 'stockistsMaps' );
    wp_enqueue_style( 'fontawesome' );
    wp_enqueue_style( 'stockistsAdminCSS' );

  }

  public function stkFrontendScripts()
  {
    $option = new Stockist_Options();

    wp_register_script( 'stockistsMaps',
      'https://maps.googleapis.com/maps/api/js?key='.$option->loadedOptions['stk_google_maps_js_api_key']
      .'&callback=fireLoadMap',
      array('jquery'),
      null,
      true );
    wp_enqueue_script( 'stockistsMaps' );
  }
}