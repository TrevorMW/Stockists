<?php
/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/28/16
 * Time: 7:44 PM
 */

global $post;

$options  = new Stockist_Options();
$stockist = new Stockist( $post->ID ); ?>

<div class="wrapper form-element">
  <select name="stockist_meta_type"
          data-ajax-select data-action="loadStockistMetaForm"
          data-target="stk-form-placeholder"
          data-postId="<?php echo $post->ID ?>">
    <option <?php !isset( $stockist->postmeta['stockist_type'][0] ) ? print 'selected="selected"' : '' ; ?>>
      Choose a Stockist Type
    </option>
    <option value="1"
            <?php selected( '1', $stockist->postmeta['stockist_type'][0], true )?>>
      Brick &amp; Mortar Stockist
    </option>
    <option value="2" <?php selected( '2', $stockist->postmeta['stockist_type'][0], true )?>>Digital Stockist</option>
  </select>
</div>
<div data-stk-form-placeholder>
  <?php if( isset( $stockist->postmeta['stockist_type'] ) )
  {
    $data = array( 'stockist_meta_type' => $stockist->postmeta['stockist_type'][0], 'stockist_data' => $stockist );
    $fields = Stockist_Utils::loadPluginView( 'form-stockist-meta-fields.php', $data );

    var_dump( $fields );
  }?>
</div>

