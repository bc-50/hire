<?php
function info_box_func($atts, $content = null){
  $r = '';
  extract( shortcode_atts( array(
    'title' => null,
    'stitle' => null,
    'img' => null,
    'link' => null,
    'check' => 'yes',
    'link_box' => 'no',
    'link_bx' => null
  ), $atts ) );

  $image_src = wp_get_attachment_image_src($img, 'full');
  $link = ($link=='||') ? '' : $link;
  $link = vc_build_link( $link );
  $a_link = $link['url'];
  $a_title = ($link['title'] == '') ? '' : 'title="'.$link['title'].'"';
  $a_target = ($link['target'] == '') ? '' : 'target="'.$link['target'].'"';


  $link_bx = ($link_bx=='||') ? '' : $link_bx;
  $link_bx = vc_build_link( $link_bx );
  $b_link = $link_bx['url'];
  $b_title = ($link_bx['title'] == '') ? '' : 'title="'.$link_bx['title'].'"';
  $b_target = ($link_bx['target'] == '') ? '' : 'target="'.$link_bx['target'].'"';

  ob_start()
  ?>
    <?php echo $link_box == "yes" ? '<a href="'. $b_link .'" style="text-decoration: none">' : '' ?>
   <div  <?php echo $check == "yes" ? 'class="toggle-content"' : '' ?> style="background-image: linear-gradient( rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(<?php echo $image_src[0] ?>)">
      <section class="light-box">
          <?php if (isset($title)) { ?>
            <div class="title">
              <h2><?php echo $title ?></h3>
              <h3><?php echo $stitle ?></h3>
            </div>
          <?php } ?>
      </section>
      <?php if ($check == 'yes') { ?>
        <section class="reveal-box">
          <div class="inner-wrapper">
            <div class="title-wrapper">
                <h2><?php echo $title ?></h2>
            </div>
            <div class="content-wrapper">
              <?php echo wpautop($content); ?>
            </div>
            <?php if ($a_link != "") { ?>
              <div class="button-wrapper">
                <a href="<?php echo $a_link ?>"><?php echo $link['title'] ?></a>
              </div>
            <?php } ?>
          </div>
        </section>
      </div>
    <?php } ?>
    <?php echo $link_box == "yes"? '</a>' : '' ?>
  
  <?php
  $r = ob_get_clean();
  return $r;
}
add_shortcode('info_box', 'info_box_func');
add_action('vc_before_init', 'info_box_map');
function info_box_map()
{
  vc_map(array(
    'name' => __('Information Box', 'my-text-domain'),
    'base' => 'info_box',
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
      'type' => 'textfield',
      "holder" => "h3",
      'heading' => __( 'Sub Title', 'my-text-domain' ),
      'param_name' => 'stitle',
    ),
    array(
      'type' => 'attach_image',
      "holder" => "img",
      'heading' => __( 'Background Image', 'my-text-domain' ),
      'param_name' => 'img',
    ),
    array(
      'type' => 'dropdown',
      'heading' => __( 'Add Content?', 'my-text-domain' ),
      "value" => array(
        'Yes'   => 'yes',
        'No'   => 'no',
      ),
      'param_name' => 'check',
    ),
    array(
      'type' => 'textarea_html',
      "holder" => "p",
      'heading' => __( 'Content', 'my-text-domain' ),
      'param_name' => 'content',
    ),
    array(
      'type' => 'vc_link',
      'heading' => __( 'Content Button', 'my-text-domain' ),
      'param_name' => 'link',
    ),
    array(
      'type' => 'dropdown',
      'heading' => __( 'Full Box Link', 'my-text-domain' ),
      'description' => __( 'Should entire box link to a page', 'my-text-domain' ),
      "value" => array(
        'No'   => 'no',
        'Yes'   => 'yes',
      ),
      'param_name' => 'link_box',
    ),
    array(
      'type' => 'vc_link',
      'heading' => __( 'Entire Box Link', 'my-text-domain' ),
      'param_name' => 'link_bx',
    ),
  )));
}