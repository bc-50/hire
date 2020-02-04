<?php 
function left_img_bg_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'img' => null,
  ), $atts ) );
  $imgsrc = wp_get_attachment_image_url($img, 'full');
  $r='
    <div class="container-fluid">
      <div class="row">
        <div class="col-3 img-col left" style="background-image: url('. $imgsrc .')"></div>
        <div class="col-9 img-col right">'. do_shortcode($content) .'</div>
      </div>
    </div>
  ';
  return $r;
}
add_shortcode('left_img_bg', 'left_img_bg_func');
add_action('vc_before_init', 'left_img_bg_map');
function left_img_bg_map()
{
  vc_map(array(
    'name' => __('Image to Left Container', 'my-text-domain'),
    'base' => 'left_img_bg',
    "content_element" => true,
    "show_settings_on_create" => true,
    "is_container" => true,
    "js_view"                 => 'VcColumnView',
    'category' => __( 'Brace Elements', 'my-text-domain'),
    'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
    'params' => array(
    array(
      'type' => 'attach_image',
      'holder' => 'img',
      'heading' => __( 'Left Image', 'my-text-domain' ),
      'param_name' => 'img',
    ),
  )));


  if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_left_img_bg extends WPBakeryShortCodesContainer {
    }
  }

}