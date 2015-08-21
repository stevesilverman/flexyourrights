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

<?php /* Start loop */ ?>
<?php $count = 0; while (have_posts()) : the_post(); $count++; ?>
  <?php roots_post_before(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php roots_post_inside_before(); ?>
      <header>
        <?php
          if (get_post_type() === 'fyr_faq') {
            $terms = wp_get_post_terms($post->ID, 'fyr_faq_categories');
        ?>
        <h4><a href="<?php echo get_term_link($terms[0]->slug, 'fyr_faq_categories'); ?>"><?php echo $terms[0]->name; ?></a></h4>
        <?php } ?>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php roots_entry_meta(); ?>
      </header>
      <div class="entry-content">
        <?php if (is_home() || is_archive() || is_search()) { ?>
          <?php the_excerpt(); ?>
        <?php } else { ?>
          <?php the_content(); ?>
        <?php } ?>
        <?php
          if (get_post_format() === 'video') {
            $video_details = get_post_meta($post->ID, '_format_video_embed', true);
            if (isset($video_details)) {
              echo '<div class="video-wrap">' . $video_details . '</div>';
            }
          }
        ?>
      </div>
      <footer>
        <?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags(); ?></p><?php } ?>
      </footer>
    <?php roots_post_inside_after(); ?>
    </article>
  <?php roots_post_after(); ?>

  <?php if ($count%5 == 0) { ?>
  <div class="loop-5">
    <script><!--
    google_ad_client = "ca-pub-3586725585448161";
    google_ad_slot = "6938186142";
    google_ad_width = 468;
    google_ad_height = 60;
    //-->
    </script>
    <script src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
  </div>
  <?php } ?>

<?php endwhile; /* End loop */ ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ($wp_query->max_num_pages > 1) { ?>
<?php wp_pagenavi(); ?>
<?php } ?>

<?php if (get_post_type() === 'fyr_faq') { echo do_shortcode('[faq_cats]'); } ?>