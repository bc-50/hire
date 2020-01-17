<footer>
  <div class="red-grad">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <?php 
            wp_nav_menu(array(
            'menu' => 'Footer Menu',
            'menu_class' => 'footer-nav',
            'container_class' => 'footer-nav-container'
          )); ?>
        </div>
        <div class="col-lg-3">
          <div class="image-wrapper">
            <img src="<?php echo get_theme_file_uri('imgs/logo-2.png') ?>" alt="Secondary Logo">
          </div>
        </div>
        <div class="col-lg-3">
          <div class="contact-info">
            <ul>
              <li><a href="tel:01234567890">01234 567 890</a></li>
              <li><a href="mailto:info@hirepro2go.co.uk">info@hirepro2go.co.uk</a></li>
              <li>123 GroPro Lane,</li>
              <li>Gloucester, GL2 0FY</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  <section class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="copy-right">
              <p>Copyright©2019hirepro2go.All Rights Reserved</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="brace">
              <p>Website design by <a href="#">Brace Creative Agency</a></p>
          </div>
      </div>
     </div>
  </section>
</footer>


<?php wp_footer() ?>

</body>

</html> 