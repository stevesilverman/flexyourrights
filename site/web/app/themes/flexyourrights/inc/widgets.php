<?php

/**
 * Donate Widget
 */
class FYR_Donate_Widget extends soilWidget {
  function __construct() {
    $this->defaults = array(
      'title' => __('Donate', 'roots'),
      'content' => __('<h4>Help us get Flex Your Rights materials into every high school and library in The United States!</h4><p>Flex Your Rights Foundation is a 501(c)(3) tax-exempt charitable foundation (EIN: 32-0022088). Your support helps us continue providing the most accurate and up-to-date know-your-rights information for teachers, professors, police academies, youth groups, town hall meetings and beyond!</p>', 'roots')
    );

    parent::__construct('donate', __('Donate', 'roots'), array(
      'description' => __('Use this widget to add a call-to-action for donations.', 'roots')
    ));
  }

  function form($instance) {
    if (empty($instance)) {
      $instance = $this->defaults;
    }

    $fields = array(
      array(
        'name' => 'title',
        'type'  => 'text',
        'desc' => __('Title:', 'roots')
      ),
      array(
        'name' => 'content',
        'type'  => 'textarea',
        'desc' => __('Content:', 'roots'),
        'extra' => array('class' => 'widefat')
      ),

    );

    foreach ($fields as $field) {
      echo html('p', $this->input($field, $instance));
    }

  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;

    $instance['title']   = strip_tags($new_instance['title']);
    $instance['content'] = wp_kses_post($new_instance['content']);

    return $instance;
  }

  function content($instance) {
    if (empty($instance))
      $instance = $this->defaults;

    extract($instance); ?>
    <div class="well alert-success">
      <?php if (is_front_page()) { ?><h2><a href="/donate/">Donate</a></h2><?php } ?>
      <?php echo $content; ?>
      <p><a href="/donate/" class="btn btn-large btn-success"><i class="icon-heart icon-white"></i>  Donate to Flex Your Rights</a></p>
    </div>
<?php
  }
}

/**
 * Follow Widget
 */
class FYR_Follow_Widget extends soilWidget {
  function __construct() {
    $this->defaults = array(
      'title' => __('Follow Flex Your Rights', 'roots')
    );

    parent::__construct('follow', __('Follow', 'roots'), array(
      'description' => __('Use this widget to show Facebook, Twitter, and YouTube links.', 'roots')
    ));
  }

  function content($instance) {
    if (empty($instance))
      $instance = $this->defaults;

    extract($instance); ?>
    <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FFlexYourRights&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:35px;" allowTransparency="true"></iframe>
    <?php if (is_front_page()) { ?>
      <p><a href="https://twitter.com/FlexYourRights" class="twitter-follow-button" data-show-count="true" data-size="large">Follow @FlexYourRights</a></p>
      <iframe src="http://www.youtube.com/subscribe_widget?p=flexyourrights" style="overflow: hidden; height: 105px; width: 300px; border: 0;" scrolling="no" frameborder="0"></iframe>
    <?php } else { ?>
      <p><a href="https://twitter.com/FlexYourRights" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @FlexYourRights</a></p>
      <iframe src="http://www.youtube.com/subscribe_widget?p=flexyourrights" style="overflow: hidden; height: 105px; width: 100%; border: 0;" scrolling="no" frameborder="0"></iframe>
    <?php } ?>
<?php
  }
}

/**
 * Subpages Widget
 */
class Roots_Subpages_Widget extends soilWidget {
  function __construct() {
    $this->defaults = array(
      'title' => __('Navigation', 'roots')
    );

    parent::__construct('subpages', __('Subpages', 'roots'), array(
      'description' => __('Use this widget to list the current subpages.', 'roots')
    ));
  }

  function content($instance) {
    if (empty($instance))
      $instance = $this->defaults;

    extract($instance);

    echo '<div class="widget-content">';
    global $post;
    if (!$post->post_parent) {
      // will display the subpages of this top level page
      $children = wp_list_pages('title_li=&child_of=' . $post->ID . '&echo=0');
    } else {
      if ($post->ancestors) {
        $ancestors = end($post->ancestors);
        $children = wp_list_pages('title_li=&child_of=' . $ancestors . '&echo=0');
      }
    }
    if ($children) { ?>
      <ul class="subpages">
        <?php echo $children; ?>
      </ul>
    <?php }
    echo '</div>';
  }

}

function roots_widgets_init() {
  // Register widgetized areas
  register_sidebar(array(
    'name' => __('Home Sidebar', 'roots'),
    'id' => 'sidebar-home',
    'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
  register_sidebar(array(
    'name' => __('Primary Sidebar', 'roots'),
    'id' => 'sidebar-primary',
    'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
  register_sidebar(array(
    'name' => __('About Sidebar', 'roots'),
    'id' => 'sidebar-about',
    'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
  register_sidebar(array(
    'name' => __('Contact Sidebar', 'roots'),
    'id' => 'sidebar-contact',
    'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
  register_sidebar(array(
    'name' => __('Footer', 'roots'),
    'id' => 'sidebar-footer',
    'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  // Register widgets
  register_widget('FYR_Follow_Widget');
  register_widget('FYR_Donate_Widget');
  register_widget('Roots_Subpages_Widget');
}
add_action('widgets_init', 'roots_widgets_init');