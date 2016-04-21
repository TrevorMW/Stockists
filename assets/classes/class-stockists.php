<?php

class Stockists
{
  public function init( $path, $inst )
  {
    register_activation_hook( $path, array( $inst, 'activate' ) );
    register_deactivation_hook( $path, array( $inst, 'deactivate' ) );

    add_action( 'init', array( $inst, 'registerPostTypes' ) );
    add_action( 'init', array( $inst, 'addCustomMetaBoxes' ) );
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
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => 'stockist' ),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => '30',
      'supports'           => array( 'title', 'editor', 'author' )
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

  }

}