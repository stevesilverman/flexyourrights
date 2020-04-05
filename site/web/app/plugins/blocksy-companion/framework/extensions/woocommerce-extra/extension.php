<?php

require_once dirname( __FILE__ ) . '/helpers.php';

class BlocksyExtensionWoocommerceExtra {
    public function __construct() {
		add_action('blocksy:global-dynamic-css:enqueue', function ($args) {

			blocksy_theme_get_dynamic_styles(array_merge([
				'path' => dirname( __FILE__ ) . '/global.php',
				'chunk' => 'woocommerce'
			], $args));

		}, 10, 3);

		add_filter('blocksy-async-scripts-handles', function ($d) {
			$d[] = 'blocksy-ext-woocommerce-extra-scripts';
			return $d;
		});

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) return;

			wp_enqueue_style(
				'blocksy-ext-woocommerce-extra-styles',
				BLOCKSY_URL . 'framework/extensions/woocommerce-extra/static/bundle/main.css',
				['ct-main-styles'],
				$data['Version']
			);

			wp_enqueue_script(
				'blocksy-ext-woocommerce-extra-scripts',
				BLOCKSY_URL . 'framework/extensions/woocommerce-extra/static/bundle/main.js',
				[
					'wc-single-product',
					'wc-add-to-cart-variation',
					'flexslider',
					'ct-events',
					// 'photoswipe-ui-default',
					// 'photoswipe-default-skin',
					// 'wc-single-product',
					// 'wc-product-gallery-lightbox'
				],
				$data['Version'],
				true
			);
		});

		add_action(
			'customize_preview_init',
			function () {
				if (! function_exists('get_plugin_data')){
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-woocommerce-extra-customizer-sync',
					BLOCKSY_URL . 'framework/extensions/woocommerce-extra/static/bundle/sync.js',
					[ 'customize-preview', 'ct-scripts', 'ct-events' ],
					$data['Version'],
					true
				);
			}
		);

		add_filter(
			'blocksy_woo_card_options_elements',
			function ($opts) {
				$opts['woocommerce_quickview_enabled'] = blocksy_get_options(
					dirname( __FILE__ ) . '/customizer.php',
					[], false
				);

				return $opts;
			}
		);

		add_filter(
			'blocksy_single_product_elements_end_customizer_options',
			function ($opts) {
				$opts['has_floating_bar'] = blocksy_get_options(
					dirname( __FILE__ ) . '/floating-cart.php',
					[], false
				);

				return $opts;
			}
		);
	}
}
