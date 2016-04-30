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
    register_activation_hook( $path, array( $inst, 'stkActivate' ) );
    register_deactivation_hook( $path, array( $inst, 'stkDeactivate' ) );

    add_action( 'init', array( $inst, 'registerPostTypes' ) );
    add_action( 'wp_enqueue_scripts', array( $inst, 'stkFrontendScripts') );
    add_action( 'admin_enqueue_scripts', array( $inst, 'stkAdminScripts') );

    add_action( 'wp_ajax_load_stockist_meta_form', array( $inst, 'loadStockistMetaForm' ) );
    add_action( 'wp_ajax_nopriv_load_stockist_meta_form', array( $inst, 'loadStockistMetaForm' ) );

    if( is_admin() )
    {
      add_action( 'admin_menu', array( $inst, 'stkBuildOptions' ) );
    }
  }

  public function stkActivate()
  {
    self::buildOptions();
    self::buildAdmin();

    flush_rewrite_rules();
  }

  public function stkDeactivate()
  {
    self::deactivatePostTypes();
  }

  public function stkBuildOptions()
  {
    register_setting( 'myoption-group', 'new_option_name' );

    add_menu_page( 'stockist-settings',
                   'Stockist Settings',
                   'administrator',
                    __FILE__,
                   array( $this, 'stkBuildOptionsPage' ) );
  }

  public function stkBuildOptionsPage()
  {
    require_once( STOCKIST_PLUGIN_DIR . 'assets/views/form-plugin-options.php' );
  }

  public function buildAdmin()
  {

  }

  public function registerPostTypes()
  {
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
      'register_meta_box_cb' => array( $this, 'addCustomMetaBoxes' )
    );

    register_post_type( 'stockist', $args );
  }

  public function deactivatePostTypes()
  {
    remove_post_type_support( 'stockist' );
  }

  public function initializeOptions()
  {

  }

  public function addCustomMetaBoxes()
  {
    $meta_box = array(
      'id'        => 'stockists_meta',
      'title'     => 'Stockist Location Data:',
      'post_type' => 'stockist',
      'context'   => 'normal',
      'priority'  => 'low',
      'fields'    => array(
        array(
          'name' => 'Text box',
          'desc' => 'Enter something here',
          'id' => $prefix . 'text',
          'type' => 'text',
          'std' => 'Default value 1'
        ),
        array(
          'name' => 'Textarea',
          'desc' => 'Enter big text here',
          'id' => $prefix . 'textarea',
          'type' => 'textarea',
          'std' => 'Default value 2'
        ),
        array(
          'name' => 'Select box',
          'id' => $prefix . 'select',
          'type' => 'select',
          'options' => array('Option 1', 'Option 2', 'Option 3')
        ),
        array(
          'name' => 'Radio',
          'id' => $prefix . 'radio',
          'type' => 'radio',
          'options' => array(
            array('name' => 'Name 1', 'value' => 'Value 1'),
            array('name' => 'Name 2', 'value' => 'Value 2')
          )
        ),
        array(
          'name' => 'Checkbox',
          'id' => $prefix . 'checkbox',
          'type' => 'checkbox'
        )
      )
    );

    add_meta_box( $meta_box['id'],
                  $meta_box['title'],
                  array( $this, 'stkMetaBoxGenerator' ),
                  'stockist',
                  'normal',
                  'low',
                  array( 'meta_box_id' => $meta_box['id'] )
    );
  }

  public function stkAdminScripts()
  {
    global $post;

    wp_register_script( 'stockistsAdminJS',
                        STOCKIST_PLUGIN_JS_PATH.'/stockists-admin.js',
                        array('jquery'),
                        null,
                        true );

    wp_register_style( 'stockistsAdminCSS',
                        STOCKIST_PLUGIN_CSS_PATH.'/stockists-admin.css' );

    wp_enqueue_script( 'stockistsAdminJS' );
    wp_enqueue_style( 'stockistsAdminCSS' );
  }

  public function stkFrontendScripts()
  {

  }

  public function stkMetaBoxGenerator( $post, $meta_box )
  {
    $fileName = STOCKIST_PLUGIN_VIEWS_PATH . '/form-' . sanitize_title_with_dashes(str_replace('_', '-', $meta_box[ 'id' ])) . '.php';

    if( file_exists($fileName) )
    {
      require_once( $fileName );
    }
  }

  public function loadStockistMetaForm()
  {

  }
}