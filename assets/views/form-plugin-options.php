<?php
/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/29/16
 * Time: 6:44 PM
 */

if ( !current_user_can('manage_options') )
  wp_die('You do not have sufficient permissions to access this page.');

$options = new Stockist_Options(); ?>

<div class="wrap">
  <h2><?php echo Stockists::getPluginName() ?> Settings</h2>
    <?php wp_nonce_field(); ?>
    <fieldset class="stk-panel">
      <form method="post" class="stk-options" data-ajax-form data-action="save_api_options">
        <input type="hidden" name="action" value="save_api_options" />
        <header class="">
          <h2>Stockists API Dependencies</h2>
        </header>
        <div class="panel-body">
          <div data-ajax-overlay><div><i class="fa fa-spin fa-spinner"></i></div></div>
          <ul>
            <li class="full clear">
              <label>Google Maps API Key (JS):</label>
              <input type="text"
                     name="stk_settings[stk_google_maps_js_api_key]"
                     value="<?php echo $options->loadedOptions['stk_google_maps_js_api_key'];?>"
                     data-validate="^\s*([0-9a-zA-Z_-]+)\s*$" />
            </li>
            <!-- <li class="half right">
              <label>Google Maps API Key (Server):</label>
              <input type="text"
                     name="stk_settings[stk_google_maps_server_api_key]"
                     value="<?php echo $options->loadedOptions['stk_google_maps_server_api_key'];?>"
                     data-validate="^\s*([0-9a-zA-Z_-]+)\s*$" />
            </li> -->

            <li class="full clear ">
              <label>Google Maps Theme Json Data:</label>
              <textarea name="stk_settings[stk_google_maps_theme_json]" ><?php echo json_encode (maybe_unserialize(
                  $options->loadedOptions['stk_google_maps_theme_json'] ) )//data-validate="^\s*
                //([0-9a-zA-Z_-]+)
                //\s*$"?></textarea>
            </li>

            <li class="submit">
              <button type="submit" class="button button-primary">Save API Settings</button>
            </li>
          </ul>
        </div>
      </form>
    </fieldset>

    <fieldset class="stk-panel">
    <form method="post" class="stk-options" data-ajax-form data-action="save_stk_data_options">
      <input type="hidden" name="action" value="save_stk_data_options" />
      <header>
        <h2>Stockist Data Types</h2>
      </header>
      <div class="panel-body">
        <div data-ajax-overlay><div><i class="fa fa-spin fa-spinner"></i></div></div>
        <ul>
          <li class="full clear">
            <div class="new-checkbox">
              <label for="type1" class="checkbox">
                <input type="checkbox"
                       class="input-checkbox"
                       name="stk_allow_digital"
                       value="1"
                       id="type1" data-stockist-type />
                <div class="checkbox-overwrite-parent"><div class="checkbox-overwrite"></div></div>
                <small>Allow Digital Stockists?</small>
              </label>
            </div>
          </li>

          <li class="full clear">
            <div class="new-checkbox">
              <label for="type2" class="checkbox">
                <input type="checkbox"
                       class="input-checkbox"
                       name="stk_allow_digital"
                       value="1"
                       id="type2" data-stockist-type />
                <div class="checkbox-overwrite-parent"><div class="checkbox-overwrite"></div></div>
                <small>Add website for all stockists?</small>
              </label>
            </div>
          </li>


          <li class="submit">
            <button type="submit" class="button button-primary">Save API Settings</button>
          </li>
        </ul>
      </div>
    </form>
  </fieldset>

    <fieldset class="stk-panel">
      <form method="post" class="stk-options" data-ajax-form data-action="save_stk_layout_options">
        <input type="hidden" name="action" value="save_stk_layout_options" />
        <header class="">
          <h2>Stockist Layout Options</h2>
        </header>
        <div class="panel-body">
          <div data-ajax-overlay><div><i class="fa fa-spin fa-spinner"></i></div></div>
          <ul>
            <li class="half">
              <div class="new-checkbox">
                <label for="layout1" class="checkbox">
                  <input type="radio"
                         class="input-checkbox"
                         name="stk_layout"
                         value="1"
                         id="layout1" data-stockist-type />
                  <div class="checkbox-overwrite-parent"><div class="checkbox-overwrite"></div></div>
                  <small>Stockists By Country &amp; City</small>
                </label>
              </div>
            </li>

            <li class="half right">
              <div class="new-checkbox">
                <label for="layout2" class="checkbox">
                  <input type="radio"
                         class="input-checkbox"
                         name="stk_layout"
                         value="2"
                         id="layout2" data-stockist-type />
                  <div class="checkbox-overwrite-parent"><div class="checkbox-overwrite"></div></div>
                  <small>Stockists List w. Map (horizontal)</small>
                </label>
              </div>
            </li>

            <li class="half">
              <div class="new-checkbox">
                <label for="layout3" class="checkbox">
                  <input type="radio"
                         class="input-checkbox"
                         name="stk_layout"
                         value="3"
                         id="layout3" data-stockist-type />
                  <div class="checkbox-overwrite-parent"><div class="checkbox-overwrite"></div></div>
                  <small>Stockists List w. Map (vertical)</small>
                </label>
              </div>
            </li>

            <li class="half right">
              <div class="new-checkbox">
                <label for="layout4" class="checkbox">
                  <input type="radio"
                         class="input-checkbox"
                         name="stk_layout"
                         value="4"
                         id="layout4" data-stockist-type />
                  <div class="checkbox-overwrite-parent"><div class="checkbox-overwrite"></div></div>
                  <small>Brick and Mortar Stockist?</small>
                </label>
              </div>
            </li>


            <li class="submit">
              <button type="submit" class="button button-primary">Save API Settings</button>
            </li>
          </ul>
        </div>
      </form>
    </fieldset>
 </div>

