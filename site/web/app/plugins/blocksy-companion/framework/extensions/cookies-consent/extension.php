<?php

require_once dirname( __FILE__ ) . '/helpers.php';

class BlocksyExtensionCookiesConsent {
	public static function onActivation() {
		do_action('wpsc_add_cookie', 'blocksy_cookies_consent_accepted');

		if (function_exists('flush_rocket_htaccess')) {
			add_filter('rocket_cache_dynamic_cookies', function ($cookies) {
				$cookies[] = 'blocksy_cookies_consent_accepted';
				return $cookies;
			});

			// Update the WP Rocket rules on the .htaccess file.
			flush_rocket_htaccess();
			// Regenerate the config file.
			rocket_generate_config_file();
			// Clear WP Rocket cache.
			rocket_clean_domain();
		}
	}

	public static function onDeactivation() {
		do_action('wpsc_delete_cookie', 'blocksy_cookies_consent_accepted');

		if (function_exists('flush_rocket_htaccess')) {
			add_filter('rocket_cache_dynamic_cookies', function ($cookies) {
				return array_diff(
					$cookies,
					[ 'blocksy_cookies_consent_accepted' ]
				);
			}, 200);

			// Update the WP Rocket rules on the .htaccess file.
			flush_rocket_htaccess();
			// Regenerate the config file.
			rocket_generate_config_file();
			// Clear WP Rocket cache.
			rocket_clean_domain();
		}
	}

	public static function should_display_notification() {
		return !isset($_COOKIE['blocksy_cookies_consent_accepted']);
	}

	public function __construct() {
		add_filter('rocket_cache_dynamic_cookies', function ($cookies) {
			$cookies[] = 'blocksy_cookies_consent_accepted';
			return $cookies;
		});

		add_filter('blocksy-async-scripts-handles', function ($d) {
			$d[] = 'blocksy-ext-cookies-consent-scripts';
			return $d;
		});

		add_filter(
			'blocksy_extensions_customizer_options',
			[$this, 'add_options_panel']
		);

		add_action(
			'customize_preview_init',
			function () {
				if (! function_exists('get_plugin_data')){
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-cookies-consent-customizer-sync',
					BLOCKSY_URL . 'framework/extensions/cookies-consent/static/bundle/sync.js',
					[ 'ct-events', 'customize-preview' ],
					$data['Version'],
					true
				);
			}
		);

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) {
				return;
			}

			if (! BlocksyExtensionCookiesConsent::should_display_notification()) {
				if (! is_customize_preview()) {
					return;
				}
			}

			wp_enqueue_style(
				'blocksy-ext-cookies-consent-styles',
				BLOCKSY_URL . 'framework/extensions/cookies-consent/static/bundle/main.css',
				['ct-main-styles'],
				$data['Version']
			);

			wp_enqueue_script(
				'blocksy-ext-cookies-consent-scripts',
				BLOCKSY_URL . 'framework/extensions/cookies-consent/static/bundle/main.js',
				['ct-events'],
				$data['Version'],
				true
			);
		});

		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {

			blocksy_theme_get_dynamic_styles(array_merge([
				'path' => dirname( __FILE__ ) . '/global.php',
				'chunk' => 'global'
			], $args));

		}, 10, 3);
	}

	public function add_options_panel($options) {
		$options['cookie_consent_ext'] = blocksy_get_options(
			dirname( __FILE__ ) . '/customizer.php',
			[], false
		);

		return $options;
	}
}

