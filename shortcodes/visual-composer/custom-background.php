<?php
function background_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'color1' => null,
    'color2' => null,
    'img' => null,
    'css' => null,
  ), $atts ) );
  $img_src = wp_get_attachment_image_url($img, 'full');
  $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'background', $atts );
  $r='
  <div class="custom-background '. esc_attr( $css_class ) .'" style="background: linear-gradient('. $color1 .', '. $color2 .'), url('. $img_src .')">
    '. do_shortcode($content) .'
  </div>
  ';
  return $r;
}
add_shortcode('background', 'background_func');
add_action('vc_before_init', 'background_map');
function background_map()
{
  vc_map(array(
    'name' => __('Background', 'my-text-domain'),
    'base' => 'background',
    /* "as_parent" => array('only' => 'plain_content'), */
    "content_element" => true,
    "show_settings_on_create" => true,
    "is_container" => true,
    "js_view"                 => 'VcColumnView',
    'category' => __( 'Brace Elements', 'my-text-domain'),
    'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
    'params' => array(
      array(
        'type' => 'attach_image',
        'heading' => __( 'Background Image', 'my-text-domain' ),
        'param_name' => 'img',
      ),
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
    class WPBakeryShortCode_background extends WPBakeryShortCodesContainer {
    }
  }

}