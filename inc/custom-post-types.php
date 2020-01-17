<?php

function pack_post_type_func() {
  // Pack Post Type
  register_post_type('pack', array(
    //Most of the visual stuff in labels array
      'labels' => array(
        'name' => 'Packs',
        'add_new_item' => 'Add New Pack',
        'edit_item' => 'Edit Packs',
        'all_items' => 'All Packs',
        'singular_name' => 'Pack'
      ),
      'supports' => array('title', 'editor', 'excerpt'),
      'public' => true,
      'menu_icon' => 'dashicons-format-quote',
      'has_archive' => false,
      'map_meta_cap' => true        //wordpress applies role permission when needed
    ));
  }
  
  add_action( 'init', 'pack_post_type_func' );