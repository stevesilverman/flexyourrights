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

  // Share Buttons
  if (!is_front_page()) {
    echo '<div class="share-container">';
    global $post;
    $url = urlencode(get_permalink( $post->ID ));
    $title = the_title('', '', false);
    echo '<div class="share share-facebook"><iframe src="http://www.facebook.com/plugins/like.php?href='. $url .'&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=20" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:20px;" allowTransparency="true"></iframe></div>';
    echo '<div class="share share-twitter"><iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/tweet_button.html?url='. $url .'&text='. $title .'&count=horizontal&via=flexyourrights&related=flexyourrights" style="width:110px; height:20px;"></iframe></div>';
    echo '<div class="share share-stumpleupon"><su:badge layout="2" location="'. $url .'"></su:badge></div>';
    echo '<div class="share share-reddit"><script src="http://www.reddit.com/buttonlite.js?i=2&url='. $url .'"></script></div>';
    echo '</div>';
  }

}
