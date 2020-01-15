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

  /* fonts */
  wp_enqueue_style('Bebas', 'https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap');
  wp_enqueue_style('Work Sans', 'https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&display=swap');
  
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


