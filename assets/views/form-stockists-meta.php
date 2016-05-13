<?php
/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/28/16
 * Time: 7:44 PM
 */

$options = new Stockist_Options(); ?>

<div class="wrapper form-element">
  <select name="stockist_meta_type" data-ajax-select data-action="loadStockistMetaForm" data-target="stk-form-placeholder">
    <?php //echo $options->getStockistMetaTypes(); ?>
    <option value="" selected="selected">Choose a Stockist Type</option>
    <option value="1" >Digital Stockist</option>
    <option value="2">Brick &amp; Mortar Stockist</option>
  </select>
</div>
<div data-stk-form-placeholder></div>

