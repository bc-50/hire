<?php

function pack_block_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'title' => null,
    'img' => null,
    'cl1' => null,
    'packs' => array_shift(array_values(all_packs())),
  ), $atts ) );
  $image_src = wp_get_attachment_image_src($img, 'full');
  ob_start()
  ?>
   <div data-id="<?php echo $packs ?>" class="toggle pack-choice <?php echo $check == "yes" ? 'toggle-content' : 'no-toggle' ?>" style="background-image: linear-gradient( <?php echo $cl1 ?>,<?php echo $cl1 ?>), url(<?php echo $image_src[0] ?>)">
      <section class="light-box">
          <?php if (isset($title)) { ?>
            <div class="title">
              <?php echo $title ? '<h2>'. $title .'</h2>' : ''?>
            </div>
          <?php } ?>
      </section>
    </div>
  
  <?php
  $r = ob_get_clean();
  return $r;
}
add_shortcode('pack_block', 'pack_block_func');
add_action('vc_before_init', 'pack_block_map');
function pack_block_map()
{
 
  vc_map(array(
    'name' => __('Pack Option Block', 'my-text-domain'),
    'base' => 'pack_block',
    "content_element" => true,
    'category' => __( 'Brace Elements', 'my-text-domain'),
    'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
    'params' => array(
    array(
      'type' => 'textfield',
      "holder" => "h2",
      'heading' => __( 'Title', 'my-text-domain' ),
      'param_name' => 'title',
    ),
    array(
      'type' => 'attach_image',
      "holder" => "img",
      'heading' => __( 'Background Image', 'my-text-domain' ),
      'param_name' => 'img',
    ),
    array(
      'type' => 'colorpicker',
      'heading' => __( 'Back Ground Overlay Color', 'my-text-domain' ),
      'param_name' => 'cl1',
    ),
    array(
      'type' => 'dropdown',
      'heading' => __( 'Choose Pack', 'my-text-domain' ),
      "value" => all_packs(),
      'param_name' => 'packs',
    ),
  )));
}