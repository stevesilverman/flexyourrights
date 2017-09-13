<div id="banner-wrap">
  <header id="banner" role="banner">
    <?php roots_header_inside(); ?>
    <div class="<?php echo WRAP_CLASSES; ?>">
      <div class="row">
        <div class="span2">
          <a class="brand" href="<?php echo home_url(); ?>/">
            <?php bloginfo('name'); ?>
          </a>
        </div>
        <div class="span10">
          <nav id="nav-utility">
            <?php // wp_nav_menu(array('theme_location' => 'utility_navigation')); ?>
            <ul class="menu">
              <li class="menu-search"><?php get_search_form(); ?></li>
            </ul>
          </nav>
          <nav id="nav-main" role="navigation">
            <?php wp_nav_menu(array('theme_location' => 'primary_navigation')); ?>
          </nav>
        </div>
      </div>
    </div>
  </header>
</div>

<?php if (is_front_page()) { ?>
<div id="content-slider-wrap">
  <div id="content-slider" class="flexslider">
    <ul class="slides group">
      <?php
        $first_slide_image = get_post_meta(345, '_fyr_first_slide_image', true);
        $first_slide_link = get_post_meta(345, '_fyr_first_slide_link', true);
        $first_slide_title = get_post_meta(345, '_fyr_first_slide_title', true);
        $first_slide_description = get_post_meta(345, '_fyr_first_slide_description', true);
      ?>
      <li>
        <a href="<?php echo $first_slide_link; ?>"><img src="<?php echo $first_slide_image; ?>"></a>
        <div class="caption">
          <h2><a href="<?php echo $first_slide_link; ?>"><?php echo $first_slide_title; ?></a></h2>
          <p><a href="<?php echo $first_slide_link; ?>"><?php echo $first_slide_description; ?></a></p>
        </div>
      </li>
      <?php
        $second_slide_image = get_post_meta(345, '_fyr_second_slide_image', true);
        $second_slide_link = get_post_meta(345, '_fyr_second_slide_link', true);
        $second_slide_title = get_post_meta(345, '_fyr_second_slide_title', true);
        $second_slide_description = get_post_meta(345, '_fyr_second_slide_description', true);
      ?>
      <li>
        <a href="<?php echo $second_slide_link; ?>"><img src="<?php echo $second_slide_image; ?>"></a>
        <div class="caption">
          <h2><a href="<?php echo $second_slide_link; ?>"><?php echo $second_slide_title; ?></a></h2>
          <p><a href="<?php echo $second_slide_link; ?>"><?php echo $second_slide_description; ?></a></p>
        </div>
      </li>
      <?php
        $third_slide_image = get_post_meta(345, '_fyr_third_slide_image', true);
        $third_slide_link = get_post_meta(345, '_fyr_third_slide_link', true);
        $third_slide_title = get_post_meta(345, '_fyr_third_slide_title', true);
        $third_slide_description = get_post_meta(345, '_fyr_third_slide_description', true);
      ?>
      <li>
        <a href="<?php echo $third_slide_link; ?>"><img src="<?php echo $third_slide_image; ?>"></a>
        <div class="caption">
          <h2><a href="<?php echo $third_slide_link; ?>"><?php echo $third_slide_title; ?></a></h2>
          <p><a href="<?php echo $third_slide_link; ?>"><?php echo $third_slide_description; ?></a></p>
        </div>
      </li>
      <?php
        $fourth_slide_image = get_post_meta(345, '_fyr_fourth_slide_image', true);
        $fourth_slide_link = get_post_meta(345, '_fyr_fourth_slide_link', true);
        $fourth_slide_title = get_post_meta(345, '_fyr_fourth_slide_title', true);
        $fourth_slide_description = get_post_meta(345, '_fyr_fourth_slide_description', true);
      ?>
      <li>
        <a href="<?php echo $fourth_slide_link; ?>"><img src="<?php echo $fourth_slide_image; ?>"></a>
        <div class="caption">
          <h2><a href="<?php echo $fourth_slide_link; ?>"><?php echo $fourth_slide_title; ?></a></h2>
          <p><a href="<?php echo $fourth_slide_link; ?>"><?php echo $fourth_slide_description; ?></a></p>
        </div>
      </li>
    </ul>
  </div>
</div>
<?php } ?>
