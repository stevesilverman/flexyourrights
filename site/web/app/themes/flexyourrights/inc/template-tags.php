<?php

// Return post entry meta information
function roots_entry_meta() {
  if (get_post_type() === 'post') {
    echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('Posted on %s', 'roots'), get_the_date()) .'</time>';
    echo '<p class="byline author vcard">'. __('Written by', 'roots') .' <a href="'. get_author_posts_url(get_the_author_meta('ID')) .'" rel="author" class="fn">'. get_the_author() .'</a></p>';
  }

  if (get_post_type() === 'fyr_success_story') {
     echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('Posted on %s', 'roots'), get_the_date()) .'</time>';
    global $post;
    $story_name     = get_post_meta($post->ID, '_fyr_name', true);
    $story_location = get_post_meta($post->ID, '_fyr_location', true);
    if (empty($story_location)) {
      $story_location = '';
    } else {
      $story_location = ' from ' . $story_location .'';
    }
    if (!empty($story_name)) {
      echo '<p class="byline">Written by ' . $story_name . $story_location . '</p>';
    }
  }
}
