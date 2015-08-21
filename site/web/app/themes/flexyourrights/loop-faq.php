<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if (!have_posts()) { ?>
  <div class="alert alert-block fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <p><?php _e('Sorry, no results were found.', 'roots'); ?></p>
  </div>
  <?php get_search_form(); ?>
<?php } ?>

<?php
  $description = category_description();
  if (is_home()) {
    $description = category_description(230);
  } elseif (get_post_type() === 'fyr_faq') {
    $page_id = 878;
    $page_data = get_page($page_id);
    $description = apply_filters('the_content', $page_data->post_content);
  } elseif (get_post_type() === 'fyr_success_story') {
    $page_id = 882;
    $page_data = get_page($page_id);
    $description = apply_filters('the_content', $page_data->post_content);
  }
  if (!empty($description)) {
    echo '<div class="category-description">' . $description . '</div>';
  }
?>

<?php echo do_shortcode('[faq_cats]'); ?>