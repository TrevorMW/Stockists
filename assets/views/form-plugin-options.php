<?php
/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/29/16
 * Time: 6:44 PM
 */

if ( !current_user_can('manage_options') )
  wp_die('You do not have sufficient permissions to access this page.');

$options = new Stockist_Options();  ?>

<div class="wrap">
  <h2><?php echo Stockists::getPluginName() ?> Settings</h2>
    <?php wp_nonce_field(); ?>
    <fieldset class="stk-panel">
      <form method="post" class="stk-options" data-ajax-form>
        <header class="">
          <h2>Google Maps API Data</h2>
        </header>
        <div class="panel-body">
          <div data-ajax-overlay><div><i class="fa fa-spin fa-spinner"></i></div></div>
          <ul>
            <li class="half">
              <label>Google Maps API Key (JS):</label>
              <input type="text"
                     name="stk_google_maps_js_api_key"
                     value="<?php echo $options->loadedOptions['stk_google_maps_js_api_key'];?>" />
            </li>
            <li class="half right">
              <label>Google Maps API Key (Server):</label>
              <input type="text"
                     name="stk_google_maps_server_api_key"
                     value="<?php echo $options->loadedOptions['stk_google_maps_server_api_key'];?>" />
            </li>
            <li class="half ">
              <label>Google Maps API Key:</label>
              <input type="text" name="" value="" />
            </li>
            <li class="submit">
              <button type="submit" class="button button-primary">Save API Settings</button>
            </li>
          </ul>
        </div>
      </form>
    </fieldset>



 </div>

