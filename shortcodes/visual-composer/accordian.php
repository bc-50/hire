<?php

  function accordian_func($atts, $content = null){
    $r = '';
    extract( shortcode_atts( array(
      'qs' => null,
    ), $atts ) );
    $questions = vc_param_group_parse_atts( $atts['qs'] ); 
    $first = true;
    ob_start(); ?>

    <div class="accordian">
      <?php foreach ($questions as $question) { ?>
        <div class="question">
          <div class="cam-icon">
            <img src="<?php echo get_theme_file_uri('imgs/cam-icon.png') ?>" alt="Camera Icon">
          </div>
          <h4><?php echo $question['ques'] ?></h4>
         <div class="down-arrow">
            <img src="<?php echo get_theme_file_uri('imgs/down-arrow.png') ?>" alt="Down Arrow">
         </div>
        </div>
        <div class="answer<?php echo $first ? ' show' : '' ?>">
          <p><?php echo $question['ans'] ?></p>
        </div>
      <?php $first = false; } ?>
    </div>

    <?php
    $r = ob_get_clean();
    return $r;
  }
  add_shortcode('accordian', 'accordian_func');
  add_action('vc_before_init', 'accordian_map');
  function accordian_map()
  {
    vc_map(array(
      'name' => __('Accordian', 'my-text-domain'),
      'base' => 'accordian',
      'category' => __( 'Brace Elements', 'my-text-domain'),
      'icon' => get_template_directory_uri().'/shortcodes/visual-composer/vc-brace-icon.png',
      'params' => array(
      array(
        'type' => 'param_group',
        'heading' => __( 'Questions', 'my-text-domain' ),
        'param_name' => 'qs',
        'params' => array(
          array(
            'type' => 'textfield',
            'holder' => 'h2',
            'heading' => __( 'Question', 'my-text-domain' ),
            'param_name' => 'ques',
          ),
          array(
            'type' => 'textarea',
            'holder' => 'p',
            'heading' => __( 'Answer', 'my-text-domain' ),
            'param_name' => 'ans',
          ),
        ),
      ),
    )));
  }