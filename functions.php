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
    'product_cat' => 'pack',
  ));
  $args = array();
  
  foreach ($packs->posts as $single) {
    $name = ucwords(str_replace('-', ' ',$single->post_name));
    $args[$name] = $single->ID;
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
}

add_action('after_setup_theme', 'extra_theme_support');

add_theme_support( 'post-thumbnails' );

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


  function change_pack_ajax(){
    
    $id = (isset($_POST["pid"])) ? $_POST["pid"] : 0;

    header("Content-Type: text/html");

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

    foreach ($pack->get_available_variations() as $var) {
      array_push($time, $var['attributes']['attribute_hire-rates']);
      array_push($price, $var['display_regular_price']);
    }
    $out = '
    
  
    <div id="info" class="pack-info">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5 pack-column" style="background-image: linear-gradient( '. $color_l .','. $color_l .'), url('. $bg_left['left_image'] .')"></div>
          <div class="col-lg-7 pack-column" style="background-image: linear-gradient( '. $color_r .','. $color_r .'), url('. $bg_right['right_image'] .')">
            <div class="product-info">
              <div class="title-wrapper">
                <h2>'. get_the_title($id) .'</h2>
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
                      <p>'. $price[$i] .'</p>
                    </div>';
                  }
                    $out .= '</div>
                <p>Discount rates for longer term hires</p>
                <div class="g-button-wrapper">
                  <a href="#">Hire Now</a>
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