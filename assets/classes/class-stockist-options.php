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
      'stk_google_maps_js_api_key' => [
        'type'           => 'text',
        'value'          => null,
        'label'          => 'Google Maps API Key (JS):',
        'settings_group' => ''
      ],
      'stk_google_maps_server_api_key' => [
        'type'           => 'text',
        'value'          => null,
        'label'          => 'Google Maps Server API Key (Server):',
        'settings_group' => ''
      ],
      'stk_google_maps_theme_json' => [
        'type'           => 'textarea',
        'value'          => null,
        'label'          => 'Google Maps API Key (JS):',
        'settings_group' => ''
      ]
    ];

    $this->loadOptions();
  }

  public function initActions()
  {
    add_action( 'wp_ajax_save_api_options', array( $this, 'stkSaveApiOptions' ) );
  }

  public function loadOptions()
  {
    $options = array();

    if( is_array( $this->optionNames ) )
    {
      foreach( $this->optionNames as $optionName => $values )
      {
        $optionVal = get_option( $optionName );

        if( $optionVal != false )
        {
          $values['value']        = $optionVal;
          $options[ $optionName ] =  $optionVal;
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
    Stockist_Utils::loadPluginView('form-plugin-options.php');
  }

  public function stkBuildOptionsFields()
  {
    register_setting( 'stockistsOptions', 'stk_settings' );

    add_settings_section(
      'stockistsApiOptions',
      'Section Description',
      'stkRenderOptionsFields',
      'stockistsOptions'
    );

    if( $this->optionNames != null )
    {
      foreach( $this->optionNames as $k => $val )
      {
        add_settings_field(
          $k,
          'Generic somethings..',
          array( $this, 'stkFieldRenderer' ),
          'stockistsOptions',
          'stockistsApiOptions',
          $val
        );
      }
    }
  }

  public function stkRenderOptionsFields()
  {

  }

  public function stkFieldRenderer( $args )
  {

  }

  public function stkSaveApiOptions()
  {
    echo 'asdwgtryghgf';
    die();
  }
}