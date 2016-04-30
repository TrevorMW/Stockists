<?php
/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/29/16
 * Time: 6:44 PM
 */

?>

<div class="wrap">
  <h2><?php echo Stockists::getPluginName() ?> Settings</h2>
  <form method="post" class="stk-options" action="options.php">
    <?php wp_nonce_field();?>
    <fieldset class="stk-panel">
      <header class="">
        <h2>Google Maps API Data</h2>
      </header>
      <div class="panel-body">
        <ul>
          <li class="half right">
            <label>Google Maps API Key:</label>
            <input type="text" name="" value="" />
          </li>
        </ul>
      </div>
    </fieldset>

    <fieldset class="stk-panel">
      <header class="">
        <h2>Google Maps API Data</h2>
      </header>
      <div class="panel-body">
        <ul>
          <li class="half right">
            <label>Google Maps API Key:</label>
            <input type="text" name="" value="" />
          </li>
        </ul>
      </div>
    </fieldset>

    <?php submit_button(); ?>
  </form>
 </div>
