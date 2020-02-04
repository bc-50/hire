<?php
function pack_info_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'default' => array_shift(array_values(all_packs())),
  ), $atts ) );
  ob_start(); 
 
  $pack = get_the_pack($default);

  $bg_left = get_field('left', $pack->get_id());
  $bg_right = get_field('right', $pack->get_id());

  $cl= hex2rgb($bg_left['overlay']);
  $cr= hex2rgb($bg_right['overlay']);
  $color_l = $cl ? 'rgba('. $cl['red'] .','. $cl['green'] .','. $cl['blue'] .','. $bg_left['overlay_op'] .')' : 'transparent';
  $color_r = $cr ? 'rgba('. $cr['red'] .','. $cr['green'] .','. $cr['blue'] .','. $bg_right['overlay_op'] .')' : 'transparent';

  $variations =$pack->get_available_variations();
  $time = array();
  $price = array();

  foreach ($variations as $var) {
    array_push($time, $var['attributes']['attribute_hire-rates']);
    $val = $var['display_regular_price'];
    if (is_numeric( $val ) && floor( $val ) != $val) {
      array_push($price, $val);
    }else{
      $val = $val . ".00";
      array_push($price, $val);
    }
  }
  ?>

  <div id="package-info">
    <div id="info" class="pack-info">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5 pack-column" style="background-image: linear-gradient( <?php echo $color_l ?>,<?php echo $color_l ?>), url(<?php echo $bg_left['left_image'] ?>)"></div>
          <div class="col-lg-7 pack-column" style="background-image: linear-gradient( <?php echo $color_r ?>,<?php echo $color_r ?>), url(<?php echo $bg_right['right_image'] ?>)">
            <div class="product-info">
              <div class="title-wrapper">
                <h2><?php echo get_the_title($default) ?></h2>
                <?php echo wpautop($pack->get_description()); ?>
              </div>
              <div class="hire-rates">
                <div class="top">
                  <h3>Hire Rates</h3>
                </div>
                <div class="rates">
                  <?php for ($i=count($time)-1; $i > -1; $i--) { ?>
                    <div class="h-row">
                      <p><?php echo $time[$i] ?></p>
                      <p>£<?php echo $price[$i] ?></p>
                    </div>
                  <?php } ?>
                  <p class="discount">Discount rates for longer term hires</p>
                </div>
                <div class="g-button-wrapper">
                    <?php echo woocommerce_template_loop_add_to_cart_button(array(), $default); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>    
  </div>
<?php
  $r = ob_get_clean();
  return $r;
}
add_shortcode('pack_info', 'pack_info_func');
add_action('vc_before_init', 'pack_info_map');
function pack_info_map()
{

  $packs = new WP_Query(array(
    'post_type' => 'pack',  
  ));
  $args = array();

  foreach ($packs->posts as $single) {
    $name = ucwords(str_replace('-', ' ',$single->post_name));
    $args[$name] = $single->ID;
  }
  vc_map(array(
    'name' => __('Pack Information', 'my-text-domain'),
    'base' => 'pack_info',
    'category' => __( 'Brace Elements', 'my-text-domain'),
    'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
    'params' => array(
      array(
        'type' => 'dropdown',
        'heading' => __( 'Set Default Pack', 'my-text-domain' ),
        'description' => __( 'Set default pack to be displayed', 'my-text-domain' ),
        "value" => all_packs(),
        'param_name' => 'default',
      ),
  )));
}