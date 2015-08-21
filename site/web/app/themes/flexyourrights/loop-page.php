<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php roots_post_before(); ?>
    <?php roots_post_inside_before(); ?>
      <div class="page-header">
      	<h1><?php the_title(); ?></h1>
      </div>
      <?php the_content(); ?>
      <?php wp_pagenavi(array('type' => 'multipart')); ?>
    <?php roots_post_inside_after(); ?>
  <?php roots_post_after(); ?>
<?php endwhile; /* End loop */ ?>