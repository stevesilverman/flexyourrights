<?php
  $video_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 10,
    'tax_query'      => array(
      array(
        'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => array('post-format-video')
      )
    )
  );
  query_posts($video_args);
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if (!have_posts()) { ?>
  <div class="alert alert-block fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <p><?php _e('Sorry, no results were found.', 'roots'); ?></p>
  </div>
  <?php get_search_form(); ?>
<?php } ?>

<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php roots_post_before(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php roots_post_inside_before(); ?>
      <header>
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
<?php endwhile; /* End loop */ ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ($wp_query->max_num_pages > 1) { ?>
<?php wp_pagenavi(); ?>
<?php } ?>

<?php wp_reset_query(); ?>