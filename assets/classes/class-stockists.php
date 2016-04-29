<?php

class Stockists
{
  public function init( $path, $inst )
  {
    register_activation_hook( $path, array( $inst, 'activate' ) );
    register_deactivation_hook( $path, array( $inst, 'deactivate' ) );

    add_action( 'init',       array( $inst, 'registerPostTypes' ) );
    //add_action( 'add_meta_boxes', array( $inst, 'addCustomMetaBoxes' ) );

    add_action( 'wp_enqueue_scripts', array( $this, 'stkEnqueueScripts') );
  }

  public function activate()
  {
    self::buildOptions();
    self::buildAdmin();

    flush_rewrite_rules();
  }

  public function deactivate()
  {
    self::deactivatePostTypes();
  }

  public function buildOptions()
  {

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
      'title'     => 'Stockist Location Data',
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
                  array( $this, 'stk_meta_box_generator' ),
                  'stockist',
                  'normal',
                  'low',
                  array( 'meta_box_id' => $meta_box['id'] )
    );
  }

  public function stkEnqueueScripts()
  {
    wp_register_script( 'adminStockistMetaBoxes', STOCKIST_PLUGIN_JS_PATH.'/admin-stockists-single.js', array('jquery'), null, true );

    if( is_admin() )
    {
      wp_enqueue_script('adminStockistMetaBoxes');
    }
    else
    {

    }
  }

  public function stk_meta_box_generator( $post, $meta_box )
  {
    $fileName = STOCKIST_PLUGIN_VIEWS_PATH . '/form-' . sanitize_title_with_dashes( str_replace( '_', '-', $meta_box['id'] ) ) . '.php';

    if( file_exists( $fileName ) )
    {
      require_once( $fileName );
    }
  }
}