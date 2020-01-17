<!DOCTYPE html>
<html>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body>
<header class=" <?php echo !is_front_page() ? 'small' : '' ?>">
 <div class="container-fluid header-container">
  <div class="row">
    <div class="col-3 head-col" style="background-image: linear-gradient(rgba(70,131,89,.8), rgba(70,131,89,.8)), url(<?php echo get_theme_file_uri('imgs/head-img-left.jpg') ?>)">
      <div class="header-left">
        <div class="logo-wrapper">
        <a href="<?php echo esc_url(site_url()) ?>"><img src="<?php echo get_theme_file_uri('imgs/logo.png') ?>" alt="<?php bloginfo('name') ?> Logo"></a>
        </div>
        <div class="image-wrapper">
          <img src="<?php echo get_theme_file_uri('imgs/cam.png') ?>" alt="Camera">
        </div>
      </div>
    </div>
    <div class="col-9 head-col" style="background-image: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)), url(<?php echo get_theme_file_uri('imgs/head-image.jpg') ?>)">
      <div class="header-right">
        <nav class="navbar navbar-expand-lg navbar-light">
          <button class="hamburger hamburger--spring  navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <?php 
              wp_nav_menu(array(
              'menu' => 'Main Menu',
              'menu_class' => 'main-nav',
              'container_class' => 'main-nav-container'
              )); ?>
            </div>
          </div>
        </nav>
        <div class="contact-info">
          <a href="mailto:info@hirepro2go.co.uk">info@hirepro2go.co.uk</a>
          <a href="tel:01234567890">01234 567 890</a>
        </div>
      </div>
    </div>
  </div>
 </div>

 <?php if (is_front_page()) { ?>
   <div class="home-content">
      <h1><?php echo get_field('main_heading') ?></h1>
      <p><?php echo get_field('sub_heading') ?></p>

      <div class="button-wrapper">
        <a href="<?php echo esc_url(site_url('bundles')) ?>">Hire Now</a>
      </div>
   </div>
 <?php } ?>
</header>

