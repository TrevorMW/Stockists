<?php

/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/30/16
 * Time: 5:47 PM
 */
class Stockist
{

  public function initActions()
  {
    add_action( 'wp_ajax_load_stockist_meta_form', array( $inst, 'loadStockistMetaForm' ) );
    add_action( 'wp_ajax_nopriv_load_stockist_meta_form', array( $inst, 'loadStockistMetaForm' ) );
  }


  public function stkMetaBoxGenerator( $post, $meta_box )
  {
    $fileName = STOCKIST_PLUGIN_VIEWS_PATH . '/form-' . sanitize_title_with_dashes(str_replace('_', '-', $meta_box[ 'id' ])) . '.php';

    if( file_exists($fileName) )
    {
      require_once( $fileName );
    }
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
}
