<?php
/**
 * @package     ${MAGENTO_MODULE_NAMESPACE}\\${MAGENTO_MODULE}
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2016 Blue Acorn, Inc.
 */

var_dump( $stockist_meta_type );

if( $stockist_meta_type == 2 ){ ?>

  <div class="stk-form-fields">
    <input type="text"
           name="stockist_url"
           value=""
           data-stk-map-address=""
           placeholder="Enter Stockist Website Url" />

  </div>

<?php } else { ?>

  <div class="stk-form-fields">
    <input type="text"
           name=""
           value=""
           data-stk-map-address=""
           placeholder="Enter your address to place a point" />

    <div data-google-map style="border:1px solid #eee; border-left:0; border-right:0; height:300px;"></div>
    <fieldset>
      <div>
        <input type="text"
               name=""
               value=""
               data-stk-post-lat
               placeholder="Latitude" />
      </div>
      <div>
        <input type="text"
               name=""
               value=""
               data-stk-post-lng
               placeholder="Longitude" />
      </div>
      <div>
        <input type="text"
               name=""
               value=""
               data-stk-post-placeID
               placeholder="Place ID" />
      </div>
    </fieldset>
  </div>

<?php } ?>