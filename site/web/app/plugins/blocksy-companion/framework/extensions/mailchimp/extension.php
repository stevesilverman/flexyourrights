<?php

require_once dirname( __FILE__ ) . '/helpers.php';
require_once dirname( __FILE__ ) . '/mailchimp-manager.php';

class BlocksyExtensionMailchimp {
	public function __construct() {
		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {

			blocksy_theme_get_dynamic_styles(array_merge([
				'path' => dirname( __FILE__ ) . '/global.php',
				'chunk' => 'global'
			], $args));

		}, 10, 3);

		add_filter('blocksy-options-scripts-dependencies', function ($d) {
			$d[] = 'blocksy-ext-mailchimp-admin-scripts';
			return $d;
		});

		add_action('admin_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			wp_register_script(
				'blocksy-ext-mailchimp-admin-scripts',
				BLOCKSY_URL . 'framework/extensions/mailchimp/admin-static/bundle/main.js',
				[],
				$data['Version'],
				true
			);

			wp_localize_script(
				'blocksy-ext-mailchimp-admin-scripts',
				'blocksy_ext_mailchimp_localization',
				[
					'public_url' => BLOCKSY_URL . 'framework/extensions/mailchimp/admin-static/bundle/',
				]
			);
		});

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) {
				return;
			}

			wp_enqueue_style(
				'blocksy-ext-mailchimp-styles',
				BLOCKSY_URL . 'framework/extensions/mailchimp/static/bundle/main.css',
				['ct-main-styles'],
				$data['Version']
			);

			wp_enqueue_script(
				'blocksy-ext-mailchimp-scripts',
				BLOCKSY_URL . 'framework/extensions/mailchimp/static/bundle/main.js',
				[],
				$data['Version'],
				true
			);
		});

		add_filter('blocksy_widgets_paths', function ($all_widgets) {
			$all_widgets[] = dirname(__FILE__) . '/ct-mailchimp';
			return $all_widgets;
		});

		add_filter(
			'blocksy_single_posts_end_customizer_options',
			function ($opts) {
				$opts['mailchimp_single_post_enabled'] = blocksy_get_options(
					dirname( __FILE__ ) . '/customizer.php',
					[], false
				);

				return $opts;
			}
		);

		add_filter('blocksy_extensions_metabox_post_bottom', function ($opts) {
			$opts['disable_subscribe_form'] = [
					'label' => __( 'Disable Subscribe Form', 'blc' ),
					'type' => 'ct-switch',
					'value' => 'no',
			];

			return $opts;
		}, 5);

		add_action(
			'customize_preview_init',
			function () {
				if (! function_exists('get_plugin_data')) {
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-mailchimp-customizer-sync',
					BLOCKSY_URL . 'framework/extensions/mailchimp/admin-static/bundle/sync.js',
					[ 'customize-preview', 'ct-events' ],
					$data['Version'],
					true
				);
			}
		);

	}
}

