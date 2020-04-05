<?php

require_once dirname( __FILE__ ) . '/helpers.php';

class BlocksyExtensionInstagram {
	public function __construct() {
		add_filter(
			'blocksy_extensions_customizer_options',
			[$this, 'add_options_panel']
		);

		add_filter('blocksy_widgets_paths', function ($all_widgets) {
			$all_widgets[] = dirname(__FILE__) . '/ct-instagram';
			return $all_widgets;
		});

		add_filter('blocksy-async-scripts-handles', function ($d) {
			$d[] = 'blocksy-ext-instagram-scripts';
			return $d;
		});

		add_filter('blocksy-options-without-controls', function ($opt) {
			$d[] = 'blocksy-instagram-reset';
			return $d;
		});


		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) return;

			wp_enqueue_style(
				'blocksy-ext-instagram-styles',
				BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/main.css',
				['ct-main-styles'],
				$data['Version']
			);

			wp_enqueue_script(
				'blocksy-ext-instagram-scripts',
				BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/main.js',
				['ct-scripts', 'ct-events'],
				$data['Version'],
				true
			);

			$data = [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'public_url' => BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/',
			];

			wp_localize_script(
				'blocksy-ext-instagram-scripts',
				'blocksy_ext_instagram_localization',
				$data
			);
		});

		add_action('wp_ajax_blocksy_reset_instagram_transients', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			global $wpdb;

			$transients = $wpdb->get_results(
				"SELECT option_name AS name FROM $wpdb->options
				WHERE option_name LIKE '_transient_blocksy_instagram_ext_%'"
			);

			foreach ($transients as $single_transient){
				delete_transient(ltrim($single_transient->name, '_transient_'));
			}

			wp_send_json_success([
				'transients' => $transients
			]);
		});

		add_action('wp_ajax_blocksy_get_instagram_interval', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			global $wpdb;

			wp_send_json_success([
				'timeout' => get_option(
					'blocksy_ext_instagram_interval',
					'1:days'
				)
			]);
		});

		add_action('wp_ajax_blocksy_update_instagram_interval', function () {
			if (! current_user_can('manage_options')) {
				wp_send_json_error();
			}

			update_option(
				'blocksy_ext_instagram_interval',
				sanitize_text_field($_POST['timeout'])
			);

			wp_send_json_success([]);
		});

		add_action(
			'customize_preview_init',
			function () {
				if (! function_exists('get_plugin_data')){
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-instagram-customizer-sync',
					BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/sync.js',
					[ 'customize-preview' ],
					$data['Version'],
					true
				);
			}
		);
	}

	public function add_options_panel($options) {
		$options['instagram_ext'] = blocksy_get_options(
			dirname( __FILE__ ) . '/customizer.php',
			[], false
		);

		return $options;
	}
}
