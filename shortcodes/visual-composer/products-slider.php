<?php
function products_sliders_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'title' => null,
    'css' => null,
  ), $atts ) );
  $first = true;
  ob_start(); 
  $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'products_sliders', $atts );
  
  $products = new WP_Query(array(
    'post_type' => 'product',
    'product_cat' => 'uncategorized',
  ));
  ?>

  <div id="product-slider" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <?php if ($products->have_posts()) {
        while ($products->have_posts()) {
          $products->the_post();
          $the_product = wc_get_product( get_the_ID() );
          if ( $the_product->is_type( 'variable' ) ) {
            $variations = $the_product->get_available_variations();
            $mini_images = $the_product->get_gallery_image_ids();
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
          <div class="carousel-item<?php echo $first ? ' active' : '' ?>">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-5">
                  <div class="image-half">
                    <div class="title-wrapper">
                      <h2><?php echo get_the_title() ?></h2>
                    </div>
                    <div class="row main-image">
                      <div class="col p-0">
                        <div class="image-wrapper">
                          <?php echo get_the_post_thumbnail() ?>
                        </div>
                      </div>                   
                    </div>
                    <div class="row">
                      <?php foreach ($mini_images as $image) { ?>
                        <div class="col-4 ">
                          <div class="mini-images">
                            <?php echo wp_get_attachment_image($image) ?>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-7 mt-auto">
                  <div class="product-info<?php echo esc_attr( $css_class )  ?>">
                    <div class="title-wrapper">
                      <?php echo wpautop($the_product->get_description()); ?>
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
                        <?php echo woocommerce_template_loop_add_to_cart_button(array(), $the_product->get_id()); ?>
                      </div>
                    </div>
                  </div>        
                </div>
              </div>
            </div>
          </div>
      <?php
        $first = false;
        }
      }
      } 
      ?>
    </div>
    <a class="carousel-control-prev" href="#product-slider" role="button" data-slide="prev">
      <img src="<?php echo get_theme_file_uri('imgs/prev.png') ?>" alt="">
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#product-slider" role="button" data-slide="next">
      <img src="<?php echo get_theme_file_uri('imgs/next.png') ?>" alt="">
      <span class="sr-only">Next</span>
    </a>
  </div>

  <?php
  $r = ob_get_clean();
  return $r;
}
add_shortcode('products_sliders', 'products_sliders_func');
add_action('vc_before_init', 'products_sliders_map');
function products_sliders_map()
{
  vc_map(array(
    'name' => __('Product Sliders', 'my-text-domain'),
    'base' => 'products_sliders',
    'category' => __( 'Brace Elements', 'my-text-domain'),
    'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
    'params' => array(
      array(
        'type' => 'css_editor',
        'heading' => __( 'Hire Rate', 'my-text-domain' ),
        'param_name' => 'css',
        'group' => __( 'Hire Rate options', 'my-text-domain' ),
        ),
  )));

  if ( class_exists( 'WPBakeryShortCodes' ) ) {
    class WPBakeryShortCode_products_sliders extends WPBakeryShortCodes {
    }
  }
}