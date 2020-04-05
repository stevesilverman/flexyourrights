<?php

namespace Blocksy;

class DemoInstallFinalActions {
	public function import() {
		Plugin::instance()->demo->start_streaming();

		if (! current_user_can('edit_theme_options')) {
			Plugin::instance()->demo->emit_sse_message([
				'action' => 'complete',
				'error' => false,
			]);
			exit;
		}

		do_action('blocksy:dynamic-css:regenere_css_files');
		Plugin::instance()->cache_manager->run_cache_purge();

		if (class_exists('WC_REST_System_Status_Tools_V2_Controller')) {
			define('WP_CLI', true);

			$s = new \WC_REST_System_Status_Tools_V2_Controller();

			$s->execute_tool('clear_transients');
			if (function_exists('wc_update_product_lookup_tables')) {
				wc_update_product_lookup_tables();
			}
			$s->execute_tool('clear_transients');
		}

		Plugin::instance()->demo->emit_sse_message([
			'action' => 'complete',
			'error' => false,
		]);
		exit;
	}
}

