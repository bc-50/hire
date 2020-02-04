<?php 
function pack_description_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'title' => null,
  ), $atts ) );
  ob_start(); 
  
  $products = new WP_Query(array(
    'post_type' => 'product',
    'p' => '211',
  ));
   var_dump(WC_PB_DB::query_bundled_items( array(
    'return'    => 'all',
    'bundle_id' => array( 211 )
  )));

  ?>
  <?php
  $r = ob_get_clean();
  return $r;
}
add_shortcode('pack_description', 'pack_description_func');
add_action('vc_before_init', 'pack_description_map');
function pack_description_map()
{
  vc_map(array(
    'name' => __('Pack Description', 'my-text-domain'),
    'base' => 'pack_description',
    'category' => __( 'Brace Elements', 'my-text-domain'),
    'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
    'params' => array(
    array(
      'type' => 'textfield',
      'holder' => 'p',
      'heading' => __( 'Title', 'my-text-domain' ),
      'param_name' => 'title',
    ),
    array(
      'type' => 'textarea_html',
      'holder' => 'p',
      'heading' => __( 'Content', 'my-text-domain' ),
      'param_name' => 'content',
    ),
  )));
}