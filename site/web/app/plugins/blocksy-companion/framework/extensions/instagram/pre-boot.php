<?php

class BlocksyExtensionInstagramPreBoot {

	public function __construct() {
		add_action('admin_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (! function_exists('blocksy_is_dashboard_page')) return;
			if (! blocksy_is_dashboard_page()) return;

			wp_enqueue_script(
				'blocksy-ext-instagram-admin-dashboard-scripts',
				BLOCKSY_URL . 'framework/extensions/instagram/dashboard-static/bundle/main.js',
				['ct-options-scripts'],
				$data['Version']
			);
		});
	}

}

