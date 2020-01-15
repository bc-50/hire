<?php 
function generic_title_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'title' => null,
  ), $atts ) );
  $r ='
    <div class="g-title-wrapper">
      <h3>' . $title . '</h3>
    </div>
  ';
  return $r;
}
add_shortcode('generic_title', 'generic_title_func');
add_action('vc_before_init', 'generic_title_map');
function generic_title_map()
{
  vc_map(array(
    'name' => __('Generic Title', 'my-text-domain'),
    'base' => 'generic_title',
    'category' => __( 'Brace Elements', 'my-text-domain'),
    'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
    'params' => array(
    array(
      'type' => 'textfield',
      'holder' => 'p',
      'heading' => __( 'Title', 'my-text-domain' ),
      'param_name' => 'title',
    ),
  )));
}