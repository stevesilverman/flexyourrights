<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php roots_post_before(); ?>
    <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <?php roots_post_inside_before(); ?>
      <header class="page-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php roots_entry_meta(); ?>
      </header>
      <div class="entry-content">
        <?php the_content(); ?>

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
        <?php wp_pagenavi(array('type' => 'multipart')); ?>
        <?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags(); ?></p><?php } ?>
      </footer>
      <?php if (get_post_type() === 'fyr_faq') { echo do_shortcode('[faq_cats]'); } ?>
      <?php // comments_template(); ?>
      <?php roots_post_inside_after(); ?>
    </article>
  <?php roots_post_after(); ?>
<?php endwhile; /* End loop */ ?>