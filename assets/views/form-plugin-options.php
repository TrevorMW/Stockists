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

  <div class="container table">
    <div class="table-cell half">
      <fieldset class="stk-panel">
        <form method="post" class="stk-options" data-ajax-form data-action="save_api_options">
          <?php wp_nonce_field(); ?>
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
    </div>
    <div class="table-cell half">
      <fieldset class="stk-panel">
        <form method="post" class="stk-options" data-ajax-form data-action="save_api_options">
          <?php wp_nonce_field(); ?>
          <header>
            <h2>Stockist Data Types</h2>
          </header>
          <div class="panel-body">
            <div data-ajax-overlay><div><i class="fa fa-spin fa-spinner"></i></div></div>
            <ul>
              <li class="full clear">
                <div class="new-checkbox">
                  <label for="type1" class="checkbox">
                    <input type="hidden" name="stk_settings[stk_allow_digital]" value="0">
                    <input type="checkbox"
                           class="input-checkbox"
                           name="stk_settings[stk_allow_digital]"
                           value="1"
                           <?php $options->loadedOptions['stk_allow_digital'] == 1 ? print 'checked' : '' ; ?>
                           id="type1" data-stockist-type />
                    <div class="checkbox-overwrite-parent"><div class="checkbox-overwrite"></div></div>
                    <small>Allow Digital Stockists?</small>
                  </label>
                </div>
              </li>

              <li class="full clear">
                <div class="new-checkbox">
                  <label for="type2" class="checkbox">
                    <input type="hidden" name="stk_settings[stk_allow_website]" value="0">
                    <input type="checkbox"
                           class="input-checkbox"
                           name="stk_settings[stk_allow_website]"
                           value="1"
                           <?php $options->loadedOptions['stk_allow_website'] == 1 ? print 'checked' : '' ; ?>
                           id="type2" data-stockist-type />
                    <div class="checkbox-overwrite-parent"><div class="checkbox-overwrite"></div></div>
                    <small>Allow website URL for all stockists?</small>
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
  </div>

  <fieldset class="stk-panel">
    <form method="post" class="stk-options" data-ajax-form data-action="save_api_options">
      <?php wp_nonce_field(); ?>
      <header class="">
        <h2>Stockist Layout Options</h2>
      </header>
      <div class="panel-body">
        <div data-ajax-overlay><div><i class="fa fa-spin fa-spinner"></i></div></div>
        <ul>
          <li class="auto">
            <div class="style-checkbox">
              <label for="layout1" class="checkbox">
                <input type="radio"
                       class="input-checkbox"
                       name="stk_settings[stk_layout]"
                       value="1"
                       <?php $options->loadedOptions['stk_layout'] == 1 ? print 'checked' : '' ; ?>
                       id="layout1" data-stockist-type />
                <div class="checkbox-overwrite-parent">
                  <div class="checkbox-overwrite"><img src="<?php echo STOCKIST_PLUGIN_MEDIA_PATH . '/basic-grid.png' ?>" alt="" /></div>
                  <span>State & Country List</span>
                </div>

              </label>
            </div>
          </li>

          <li class="auto ">
            <div class="style-checkbox">
              <label for="layout2" class="checkbox">
                <input type="radio"
                       class="input-checkbox"
                       name="stk_settings[stk_layout]"
                       value="2"
                       <?php $options->loadedOptions['stk_layout'] == 2 ? print 'checked' : '' ; ?>
                       id="layout2" data-stockist-type />
                <div class="checkbox-overwrite-parent">
                    <div class="checkbox-overwrite">
                      <img src="<?php echo STOCKIST_PLUGIN_MEDIA_PATH . '/map-w-list-horizontal.png' ?>" alt="" />
                    </div>
                    <span>State & Country List</span>
                </div>
              </label>
            </div>
          </li>

          <li class="auto">
            <div class="new-checkbox">
              <label for="layout3" class="checkbox">
                <input type="radio"
                       class="input-checkbox"
                       name="stk_settings[stk_layout]"
                       value="3"
                       <?php $options->loadedOptions['stk_layout'] == 3 ? print 'checked' : '' ; ?>
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
                       name="stk_settings[stk_layout]"
                       value="4"
                       <?php $options->loadedOptions['stk_layout'] == 4 ? print 'checked' : '' ; ?>
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

