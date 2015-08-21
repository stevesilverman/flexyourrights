<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


/**
 * Remove CSS from the Recent Comments widget
 */
function soil_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

/**
 * Remove default CSS from galleries
 */
function soil_remove_default_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/**
 * wp_head Cleanup (source: http://www.rootstheme.com/)
 */
add_action('init', 'soil_wp_head_cleanup');

function soil_wp_head_cleanup() {
  remove_action('wp_head', 'rsd_link');                             // RSD service endpoint, EditURI link
  remove_action('wp_head', 'wlwmanifest_link');                     // Windows Live Writer manifest file
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);          // Remove shortlink
  add_action('wp_head', 'soil_remove_recent_comments_style', 1);     // Remove CSS from the Recent Comments widget
  add_filter('gallery_style', 'soil_remove_default_gallery_style');  // Remove default CSS from galleries
}

/**
 * Remove WordPress version from wp_head and RSS feeds
 */
add_filter('the_generator', 'soil_remove_rss_generator');

function soil_remove_rss_generator() { return; }


/**
 * Cleanup the default output of the stylesheet <link> markup
 */
add_filter('style_loader_tag', 'soil_clean_style_tag');

function soil_clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  /** Only display media if it's print */
  $media = $matches[3][0] === 'print' ? ' media="print"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

/**
 * Allow more tags in TinyMCE including <iframe> and <script>
 */
add_filter('tiny_mce_before_init', 'roots_change_mce_options');

function roots_change_mce_options($options) {
  $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';
  if (isset($initArray['extended_valid_elements'])) {
    $options['extended_valid_elements'] .= ',' . $ext;
  } else {
    $options['extended_valid_elements'] = $ext;
  }
  return $options;
}
