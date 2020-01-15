<?php 
function nested_container_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'color1' => null,
    'color2' => null,
    'css' => null,
  ), $atts ) );
  $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'nested_container', $atts );
  $r='
  <div class="angled-background '. esc_attr( $css_class ) .'" style="background: linear-gradient(-12deg, '. $color1 .' 49.8%, '. $color2 .' 50%)">
    '. do_shortcode($content) .'
  </div>
  ';
  return $r;
}
add_shortcode('nested_container', 'nested_container_func');
add_action('vc_before_init', 'nested_container_map');
function nested_container_map()
{
  vc_map(array(
    'name' => __('Container', 'my-text-domain'),
    'base' => 'nested_container',
    /* "as_parent" => array('only' => 'plain_content'), */
    "content_element" => true,
    "show_settings_on_create" => true,
    "is_container" => true,
    "js_view"                 => 'VcColumnView',
    'category' => __( 'Brace Elements', 'my-text-domain'),
    'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
    'params' => array(
    array(
      'type' => 'colorpicker',
      'heading' => __( 'Color 1', 'my-text-domain' ),
      'param_name' => 'color1',
    ),
    array(
      'type' => 'colorpicker',
      'heading' => __( 'Color 2', 'my-text-domain' ),
      'param_name' => 'color2',
    ),
    array(
      'type' => 'css_editor',
      'heading' => __( 'Css', 'my-text-domain' ),
      'param_name' => 'css',
      'group' => __( 'Design options', 'my-text-domain' ),
      ),
  )));


  if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nested_container extends WPBakeryShortCodesContainer {
    }
  }

}