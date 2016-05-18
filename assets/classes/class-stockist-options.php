<?php

/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/30/16
 * Time: 5:42 PM
 */
class Stockist_Options
{
  public $optionNames;
  public $loadedOptions;

  public function __construct()
  {
    $this->optionNames = [
      'stk_google_maps_js_api_key',
      'stk_google_maps_theme_json',
      'stk_allow_digital',
      'stk_allow_website',
      'stk_layout'
    ];

    $this->loadOptions();
  }

  public function initActions()
  {
    $stockist = new Stockist();
    $stockist->initActions();

    add_action( 'wp_ajax_save_api_options', array( $this, 'stkSaveApiOptions' ) );
  }

  public function loadOptions()
  {
    global $post;

    $options = array();

    if( is_array( $this->optionNames ) )
    {
      foreach( $this->optionNames as $optionName )
      {
        $optionVal = get_option( $optionName );

        if( $optionVal == false )
        {
          $optionVal = get_post_meta( $post->ID, $optionName );
        }

        if( $optionVal != false )
        {
          $options[ $optionName ] = $optionVal;
        }
      }
    }

    $this->loadedOptions = $options;
  }

  public function stkBuildOptions()
  {
    add_options_page( 'stockist-settings', 'Stockist Settings', 'manage_options', 'stockists', array( $this,
      'stkBuildOptionsPage' ) );
  }

  public function stkBuildOptionsPage()
  {
    echo Stockist_Utils::loadPluginView('form-plugin-options.php');
  }

  public function stkSaveApiOptions()
  {
    $data = $_POST;
    $resp = new Ajax_Response( $data['action_id'], true );

    if( is_array( $data['stk_settings'] ) && isset( $data['stk_settings'] ) )
    {
      foreach( $data['stk_settings'] as $optionKey => $optionData )
      {
        $dataType = json_decode( stripslashes( $optionData ) );

        if( is_array( $dataType ) )
        {
          $data = json_decode( stripslashes( $optionData ) );
        }
        else
        {
          $data = $optionData;
        }

        update_option( $optionKey, $data );
      }
    }

    echo $resp->encode_response();
    die();
  }
}