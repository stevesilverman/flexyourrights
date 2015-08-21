<?php

function get_top_ancestor($page_id) {
  $current = get_post($page_id);
  if (!$current->post_parent) {
    return $current->ID;
  } else {
    return get_top_ancestor($current->post_parent);
  }
}

function get_grandparent($page_id) {
  $current_page = get_page($page_id);
  if ($current_page->post_parent > 0) {
    $parent_page = get_page($current_page->post_parent);
    if ($parent_page->post_parent > 0) {
      return $parent_page->post_parent;
    } else {
      return false;
    }
  }
  return false;
}

function grandparent_id_class($classes) {
  global $post;
  if (is_page() && $post->post_parent && !is_front_page() && get_grandparent($post->ID)) {
    $grandparent = get_grandparent($post->ID);
    $classes[] = 'grandparent-pageid-'. $grandparent .'';
  }
  return $classes;
}

add_filter('body_class', 'grandparent_id_class');

// Add Zemanta metabox to additional post types
function fyr_zemanta_support() {
  add_meta_box('zemanta-wordpress', __('Content Recommendations'), array('Zemanta', 'shim'), 'fyr_faq', 'side', 'high');
  add_meta_box('zemanta-wordpress', __('Content Recommendations'), array('Zemanta', 'shim'), 'fyr_success_story', 'side', 'high');
}
if (class_exists('Zemanta')) {
  add_action('admin_menu', 'fyr_zemanta_support');
}

// Add custom metaboxes
function fyr_initialize_cmb_meta_boxes() {
  soil_register_custom_meta_box(array(
    'id'         => '_fyr_featured', // Metabox ID
    'title'      => __('Featured Post', 'roots'), // Metabox title
    'pages'      => array('post', 'fyr_faq', 'fyr_success_story'), // Post types to display on
    'context'    => 'side',
    'show_names' => false, // Show field names on the left
    'fields'     => array(

      array(
        'name' => 'Feature this post',
        'desc' => 'Feature this post on the homepage',
        'id'   => '_fyr_featured_post',
        'type' => 'checkbox',
      ),

    )
  ));

  // Add management for the content slider on the Home page (ID: 4)
  soil_register_custom_meta_box(array(
    'id'         => '_fyr_content_slider',
    'title'      => __('Content Slider', 'roots'),
    'pages'      => array('page'),
    'show_on'    => array('key' => 'id', 'value' => '345'),
    'context'    => 'normal',
    'show_names' => true,
    'fields'     => array(

      array(
        'name' => '1st Slide Image',
        'desc' => '',
        'id'   => '_fyr_first_slide_image',
        'type' => 'file',
      ),
      array(
        'name' => '1st Slide Link',
        'desc' => '',
        'id'   => '_fyr_first_slide_link',
        'type' => 'text',
        'args' => array(
          'class' => 'cmb_text_medium',
          'style' => 'width:210px;'
        ),
      ),
      array(
        'name' => '1st Slide Title',
        'desc' => '',
        'id'   => '_fyr_first_slide_title',
        'type' => 'text',
        'args' => array(
          'class' => 'cmb_text_medium',
          'style' => 'width:210px;'
        ),
      ),
      array(
        'name' => '1st Slide Description',
        'desc' => '',
        'id'   => '_fyr_first_slide_description',
        'type' => 'textarea',
        'args' => array(
          'class' => 'cmb_textarea_small',
          'style' => 'height:90px;'
        ),
      ),

      array(
        'name' => '2nd Slide Image',
        'desc' => '',
        'id'   => '_fyr_second_slide_image',
        'type' => 'file',
      ),
      array(
        'name' => '2nd Slide Link',
        'desc' => '',
        'id'   => '_fyr_second_slide_link',
        'type' => 'text',
        'args' => array(
          'class' => 'cmb_text_medium',
          'style' => 'width:210px;'
        ),
      ),
      array(
        'name' => '2nd Slide Title',
        'desc' => '',
        'id'   => '_fyr_second_slide_title',
        'type' => 'text',
        'args' => array(
          'class' => 'cmb_text_medium',
          'style' => 'width:210px;'
        ),
      ),
      array(
        'name' => '2nd Slide Description',
        'desc' => '',
        'id'   => '_fyr_second_slide_description',
        'type' => 'textarea',
        'args' => array(
          'class' => 'cmb_textarea_small',
          'style' => 'height:90px;'
        ),
      ),

      array(
        'name' => '3rd Slide Image',
        'desc' => '',
        'id'   => '_fyr_third_slide_image',
        'type' => 'file',
      ),
      array(
        'name' => '3rd Slide Link',
        'desc' => '',
        'id'   => '_fyr_third_slide_link',
        'type' => 'text',
        'args' => array(
          'class' => 'cmb_text_medium',
          'style' => 'width:210px;'
        ),
      ),
      array(
        'name' => '3rd Slide Title',
        'desc' => '',
        'id'   => '_fyr_third_slide_title',
        'type' => 'text',
        'args' => array(
          'class' => 'cmb_text_medium',
          'style' => 'width:210px;'
        ),
      ),
      array(
        'name' => '3rd Slide Description',
        'desc' => '',
        'id'   => '_fyr_third_slide_description',
        'type' => 'textarea',
        'args' => array(
          'class' => 'cmb_textarea_small',
          'style' => 'height:90px;'
        ),
      ),

      array(
        'name' => '4th Slide Image',
        'desc' => '',
        'id'   => '_fyr_fourth_slide_image',
        'type' => 'file',
      ),
      array(
        'name' => '4th Slide Link',
        'desc' => '',
        'id'   => '_fyr_fourth_slide_link',
        'type' => 'text',
        'args' => array(
          'class' => 'cmb_text_medium',
          'style' => 'width:210px;'
        ),
      ),
      array(
        'name' => '4th Slide Title',
        'desc' => '',
        'id'   => '_fyr_fourth_slide_title',
        'type' => 'text',
        'args' => array(
          'class' => 'cmb_text_medium',
          'style' => 'width:210px;'
        ),
      ),
      array(
        'name' => '4th Slide Description',
        'desc' => '',
        'id'   => '_fyr_fourth_slide_description',
        'type' => 'textarea',
        'args' => array(
          'class' => 'cmb_textarea_small',
          'style' => 'height:90px;'
        ),
      ),
    )
  ));
}
add_action('init', 'fyr_initialize_cmb_meta_boxes', 9999);

function all_excerpts_get_more_link($post_excerpt) {
  global $post;
  if (!empty($post->post_excerpt)) {
    return $post_excerpt . ' &hellip; <a href="' . get_permalink($post->ID) . '">' . __('Continued', 'roots') . '</a>';
  } else {
    return $post_excerpt;
  }
}
add_filter('wp_trim_excerpt', 'all_excerpts_get_more_link');

// FAQ Category Accordion
add_shortcode('faq_cats', 'fyr_faq_cats');
function fyr_faq_cats($atts) { ?>
  <div class="accordion" id="faq-accordion">
  <?php
    $faq_categories = get_terms('fyr_faq_categories', array('hide_empty' => 0));
    foreach($faq_categories as $faq_category) {
      $faq_id = $faq_category->term_id;
      $faq_link = get_term_link($faq_category->slug, 'fyr_faq_categories');
    ?>
    <div class="accordion-group">
      <div class="accordion-heading">
        <a class="accordion-toggle" href="<?php echo $faq_link; ?>">
          <?php
            $faq_icon = '';
            switch ($faq_category->term_id) {
              case '236':  $faq_icon = 'traffic';      break;
              case '233':  $faq_icon = 'home';         break;
              case '234':  $faq_icon = 'general';      break;
              case '235':  $faq_icon = 'myths';        break;
              case '241':  $faq_icon = 'jury-duty';    break;
            }
          ?>
          <img src="<?= get_template_directory_uri(); ?>/img/icon-faq-<?php echo $faq_icon; ?>.png">
          <b><?php echo $faq_category->name; ?></b>
        </a>
      </div>
      <div id="faq-accordion-<?php echo $faq_category->term_id; ?>" class="accordion-body collapse">
        <div class="accordion-inner">
          <p><a href="<?php echo $faq_link; ?>"><?php echo $faq_category->description; ?></a></p>
        </div>
      </div>
    </div>

  <?php } ?>
  </div>
  <?php
}
