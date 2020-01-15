<?php
function cta_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'title' => null,
  ), $atts ) );
  $r ='
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-11">
          <div class="cta">
            '. wpautop($content) .'
          </div>
        </div>
      </div>
    </div>
  ';
  return $r;
}
add_shortcode('cta', 'cta_func');
add_action('vc_before_init', 'cta_map');
function cta_map()
{
  vc_map(array(
    'name' => __('CTA', 'my-text-domain'),
    'base' => 'cta',
    'category' => __( 'Brace Elements', 'my-text-domain'),
    'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
    'params' => array(
    array(
      'type' => 'textarea_html',
      'holder' => 'p',
      'heading' => __( 'Content', 'my-text-domain' ),
      'param_name' => 'content',
    ),
  )));
}