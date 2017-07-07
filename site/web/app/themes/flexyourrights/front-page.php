<?php get_header(); ?>
  <?php roots_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
      <?php roots_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
        <section id="faqs" class="group">
          <h2><a href="/faqs/">Questions About Your Rights?</a></h2>
          <?php echo do_shortcode('[faq_cats]'); ?>
        </section>

        <section id="loop" class="group">
          <?php
            $loop_query_args = array(
              'post_type' => array('post', 'fyr_faq', 'fyr_success_story'),
              'paged' => get_query_var('page'),
            );
            $loop_query = new WP_Query($loop_query_args);
            while ($loop_query->have_posts()) : $loop_query->the_post();
          ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class('group'); ?>>
            <?php if (has_post_thumbnail()) { ?>
            <div class="entry-thumbnail">
              <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('homepage-thumb'); ?></a>
            </div>
            <?php } else { ?>
            <?php } ?>
            <?php
              $archive_url = '';
              $archive_title = '';
              $post_type = get_post_type();
              $object = get_post_type_object($post_type)->labels;
              if (get_post_type() === 'post') {
                $archive_url = get_permalink(get_option('page_for_posts', true));
                $archive_title = get_the_title(get_option('page_for_posts', true));
              } else {
                $archive_url = get_post_type_archive_link(get_post_type());
                $archive_title = $object->name;
              }
            ?>
            <header>
              <h4><a href="<?php echo $archive_url; ?>"><?php echo $archive_title; ?></a></h4>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            </header>
            <div class="entry-content">
              <?php the_excerpt(); ?>
            </div>
          </article>
          <?php endwhile; ?>
        </section>

        <?php wp_pagenavi(array('query' => $loop_query)); ?>
        <?php wp_reset_postdata(); ?>

        <section id="donate" class="group">
          <?php the_widget('FYR_Donate_Widget', 'title='); ?>
        </section>

      </div><!-- /#main -->
      <?php roots_main_after(); ?>
      <?php roots_sidebar_before(); ?>
      <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?>" role="complementary">
      <?php roots_sidebar_inside_before(); ?>
        <?php get_sidebar(); ?>
      <?php roots_sidebar_inside_after(); ?>
      </aside><!-- /#sidebar -->
      <?php roots_sidebar_after(); ?>
    </div><!-- /#content -->
  <?php roots_content_after(); ?>
<?php get_footer(); ?>
