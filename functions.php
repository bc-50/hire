<?php
require_once('inc/custom-post-types.php');
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

function theme_files()
{
  wp_enqueue_script('Main-Scripts', get_theme_file_uri('js/scripts.min.js'), NULL, microtime(), true);
  wp_enqueue_style('MyStyles', get_stylesheet_uri());
  wp_enqueue_style('Hamburger', get_theme_file_uri('lib/hamburgers.min.css'));
  wp_enqueue_script('BootstrapJS', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js', array('jquery'));
  wp_enqueue_style('Bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
  wp_enqueue_script('Jquerysc', 'https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js');
  wp_enqueue_style('FontAwes', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css');
  wp_localize_script( 'Main-Scripts', 'ajax_posts', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'noposts' => __('No older posts found', 'event'),
  ));
  /* fonts */
  wp_enqueue_style('Bebas', 'https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap');
  wp_enqueue_style('Work Sans', 'https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&display=swap');
  
}
function all_packs(){
  $packs = new WP_Query(array(
    'post_type' => 'product',
  ));
  $args = array();
  
  foreach ($packs->posts as $single) {
    $the_product = wc_get_product( $single->ID );
    if ($the_product->is_type( 'bundle' )) {
      $name = ucwords(str_replace('-', ' ',$single->post_name));
      $args[$name] = $single->ID;
    }
  }
  wp_reset_postdata();
  return $args;
}
add_action('wp_enqueue_scripts', 'theme_files');

/* Extra theme support */
function extra_theme_support()
{
  register_nav_menus(array(
    'primary' => __('Primary Menu')
  ));
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
}

add_action('after_setup_theme', 'extra_theme_support');


add_action('init', 'brace_autoload_shortcodes', 1);
function brace_autoload_shortcodes(){
    $dir = get_stylesheet_directory() . '/shortcodes/visual-composer';
    $pattern = $dir . '/*.php';
    
    $files = glob($pattern);
    foreach($files as $file){
        $parts = pathinfo($file);
        $name = $parts['filename'];
        
        require_once($file);        
    }
  }

  function get_the_pack($id){
    $bundle_items = WC_PB_DB::query_bundled_items( array(
      'return'    => 'all',
      'bundle_id' => array( $id )
    ));
  
    foreach ($bundle_items as $item) {
      $terms = wp_get_post_terms( $item['product_id'], 'product_cat' );
      foreach ( $terms as $term ) $categories[] = $term->slug;
      if (in_array( 'pack', $categories  )) {
        $pack = wc_get_product( $item['product_id'] );
      }
      $categories = array();
    }

    return $pack;
  }

  function change_pack_ajax(){
    
    $bundle_id = (isset($_POST["pid"])) ? $_POST["pid"] : 0;

    header("Content-Type: text/html");

    $id = get_the_pack($bundle_id)->get_id();

    $pack = wc_get_product( $id );
    $bg_left = get_field('left', $id);
    $bg_right = get_field('right', $id);
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
    $out = '
    
  
      <div id="info" class="pack-info">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 pack-column" style="background-image: linear-gradient( '. $color_l .','. $color_l .'), url('. $bg_left['left_image'] .')"></div>
            <div class="col-lg-7 pack-column" style="background-image: linear-gradient( '. $color_r .','. $color_r .'), url('. $bg_right['right_image'] .')">
              <div class="product-info">
                <div class="title-wrapper">
                  <h2>'. get_the_title($bundle_id) .'</h2>
                  '. wpautop($pack->get_description()) .'
                </div>
                <div class="hire-rates">
                  <div class="top">
                    <h3>Hire Rates</h3>
                  </div>
                  <div class="rates">';
                    for ($i=count($time)-1; $i > -1; $i--) { 
                      $out .= '<div class="h-row">
                        <p>'. $time[$i] .'</p>
                        <p>£'. $price[$i] .'</p>
                      </div>';
                    }
                      $out .= '
                    <p class="discount">Discount rates for longer term hires</p>
                  </div>
                  <div class="g-button-wrapper">
                    '. woocommerce_template_loop_add_to_cart_button(array(), $bundle_id) .'
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
    ';

    die($out);
  }

  add_action('wp_ajax_nopriv_change_pack_ajax', 'change_pack_ajax');
  add_action('wp_ajax_change_pack_ajax', 'change_pack_ajax');


  function hex2rgb( $colour ) {
    if ( $colour[0] == '#' ) {
            $colour = substr( $colour, 1 );
    }
    if ( strlen( $colour ) == 6 ) {
            list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
    } elseif ( strlen( $colour ) == 3 ) {
            list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
    } else {
            return false;
    }
    $r = hexdec( $r );
    $g = hexdec( $g );
    $b = hexdec( $b );
    return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

function woocommerce_template_loop_add_to_cart_button( $args = array(), $id ) {
  $product = wc_get_product( $id );

  if ( $product ) {
    $defaults = array(
      'quantity'   => 1,
      'class'      => implode(
        ' ',
        array_filter(
          array(
            'button',
            'product_type_' . $product->get_type(),
            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
            $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
          )
        )
      ),
      'attributes' => array(
        'data-product_id'  => $product->get_id(),
        'data-product_sku' => $product->get_sku(),
        'aria-label'       => $product->add_to_cart_description(),
        'rel'              => 'nofollow',
      ),
    );

    $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

    if ( isset( $args['attributes']['aria-label'] ) ) {
      $args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
    }

    return apply_filters( 'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
    sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>Hire Now</a>',
      esc_url( $product->add_to_cart_url() ),
      esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
      esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
      isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
      esc_html( $product->add_to_cart_text() )
    ),
    $product, $args );
  }
}

