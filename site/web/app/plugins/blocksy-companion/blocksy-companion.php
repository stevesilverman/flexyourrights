<?php

/*
Plugin Name: Blocksy Companion
Description: This plugin is the companion for the Blocksy theme, it runs and adds its enhacements only if the Blocksy theme is installed and active.
Version: 1.7.2
Author: CreativeThemes
Author URI: https://creativethemes.com
Text Domain: blc
Domain Path: /languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
define('BLOCKSY__FILE__', __FILE__);
define('BLOCKSY_PLUGIN_BASE', plugin_basename(BLOCKSY__FILE__));
define('BLOCKSY_PATH', plugin_dir_path(BLOCKSY__FILE__));
define('BLOCKSY_URL', plugin_dir_url(BLOCKSY__FILE__));

add_action('init', function () {
	/**
	 * Load Blocksy textdomain.
	 *
	 * Load gettext translate for Blocksy text domain.
	 */
	load_plugin_textdomain(
		'blc',
		false,
		dirname(BLOCKSY_PLUGIN_BASE) . '/languages'
	);
});

if (! version_compare(PHP_VERSION, '7.0', '>=')) {
	add_action('admin_notices', 'blc_fail_php_version');
} elseif (! version_compare(get_bloginfo('version'), '5.0', '>=')) {
	add_action('admin_notices', 'blc_fail_wp_version');
} else {
	require(BLOCKSY_PATH . 'plugin.php');
}

/**
 * Blocksy admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 */
function blc_fail_php_version() {
	/* translators: %s: PHP version */
	$message = sprintf(esc_html__('Blocksy requires PHP version %s+, plugin is currently NOT RUNNING.', 'blc'), '7.0');
	$html_message = sprintf('<div class="error">%s</div>', wpautop($message));
	echo wp_kses_post($html_message);
}

/**
 * Blocksy admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 */
function blc_fail_wp_version() {
	/* translators: %s: WordPress version */
	$message = sprintf(esc_html__('Blocksy requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'blc' ), '5.0');
	$html_message = sprintf('<div class="error">%s</div>', wpautop($message));
	echo wp_kses_post($html_message);
}

