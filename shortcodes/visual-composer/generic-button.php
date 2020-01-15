<?php
function generic_button_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'title' => null,
    'link' => null,
  ), $atts ) );
  $link = ($link=='||') ? '' : $link;
  $link = vc_build_link( $link );
  $a_link = $link['url'];
  $a_title = ($link['title'] == '') ? '' : $link['title'];
  $a_target = ($link['target'] == '') ? '' : 'target="'.$link['target'].'"';

  $r ='
      <div class="g-button-wrapper">
        <a href="'. $a_link .'" class="">'. $a_title .'</a>
      </div>
  ';
  return $r;
}
add_shortcode('generic_button', 'generic_button_func');
add_action('vc_before_init', 'generic_button_map');
function generic_button_map()
{
  vc_map(array(
    'name' => __('Generic Button', 'my-text-domain'),
    'base' => 'generic_button',
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
      'type' => 'vc_link',
      'holder' => 'p',
      'heading' => __( 'Link', 'my-text-domain' ),
      'param_name' => 'link',
    ),
  )));
}