<?php
  global $post;
  if (is_front_page()) {
    dynamic_sidebar('sidebar-home');
  } elseif (is_page('about-us') || get_top_ancestor($post->ID) == '344') {
    dynamic_sidebar('sidebar-about');
  } elseif (is_page('contact')) {
    dynamic_sidebar('sidebar-contact');
  } else {
    dynamic_sidebar('sidebar-primary');
  }
?>