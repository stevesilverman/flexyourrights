<?php

namespace Blocksy;

class Plugin {
	/**
	 * Blocksy instance.
	 *
	 * Holds the blocksy plugin instance.
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * Blocksy extensions manager.
	 *
	 * @var ExtensionsManager
	 */
	public $extensions = null;
	public $extensions_api = null;

	public $dashboard = null;
	public $theme_integration = null;

	public $cli = null;
	public $cache_manager = null;

	// Features
	public $feat_google_analytics = null;
	public $demo = null;
	public $dynamic_css = null;

	private $is_blocksy = '__NOT_SET__';
	private $desired_blocksy_version = '1.7.0';

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @static
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function init() {
		if (! $this->check_if_blocksy_is_activated()) {
			return;
		}

		add_action('widgets_init', [
			'BlocksyWidgetFactory',
			'register_all_widgets',
		]);

		add_action('admin_enqueue_scripts', function () {
			$locale_data_ct = blocksy_get_jed_locale_data('blc');

			wp_add_inline_script(
				'wp-i18n',
				'wp.i18n.setLocaleData( ' . wp_json_encode($locale_data_ct) . ', "blc" );'
			);
		});

		$this->cache_manager = new CacheResetManager();

		$this->extensions_api = new ExtensionsManagerApi();
		$this->theme_integration = new ThemeIntegration();
		$this->demo = new DemoInstall();
		$this->dynamic_css = new DynamicCss();
	}

	/**
	 * Init components that need early access to the system.
	 *
	 * @access private
	 */
	public function early_init() {
		if (! $this->check_if_blocksy_is_activated()) {
			return;
		}

		$this->init_freemius();

		$this->extensions = new ExtensionsManager();

		$this->dashboard = new Dashboard();

		$this->feat_google_analytics = new GoogleAnalytics();
		new OpenGraphMetaData();

		if (defined('WP_CLI') && WP_CLI) {
			$this->cli = new Cli();
		}

		add_action('admin_init', [$this, 'plugin_update']);
	}

	/**
	 * Register autoloader.
	 *
	 * Blocksy autoloader loads all the classes needed to run the plugin.
	 *
	 * @access private
	 */
	private function register_autoloader() {
		require BLOCKSY_PATH . '/framework/autoload.php';

		Autoloader::run();
	}

	/**
	 * Plugin constructor.
	 *
	 * Initializing Blocksy plugin.
	 *
	 * @access private
	 */
	private function __construct() {
		$this->register_autoloader();
		$this->early_init();

		add_action( 'init', [ $this, 'init' ], 0 );
	}

	private function check_if_blocksy_is_activated() {
		if ($this->is_blocksy === '__NOT_SET__') {
			$theme = wp_get_theme(get_template());

			$is_correct_theme = strpos(
				$theme->get('Name'), 'Blocksy'
			) !== false;

			$is_correct_version = version_compare(
				$theme->get('Version'),
				$this->desired_blocksy_version
			) > -1;

			$another_theme_in_preview = false;

			if (
				isset($_REQUEST['theme'])
				&&
				strpos($_SERVER['REQUEST_URI'], 'customize') !== false
			) {
				$another_theme_in_preview = true;
			}

			$this->is_blocksy = $is_correct_theme && $is_correct_version && !$another_theme_in_preview;
		}

		return !!$this->is_blocksy;
	}

	public function plugin_update() {
		if (! function_exists('\Blocksy\blc_fs')) {
			return;
		}

		if (blc_fs()->is__premium_only()) {
			return;
		}

		$data = get_plugin_data(BLOCKSY__FILE__);

		new \EDD_SL_Plugin_Updater(
			'https://creativethemes.com/',
			BLOCKSY__FILE__,
			[
				'version' => $data['Version'],
				'license' => '123',
				'item_id' => 515,
				'author' => 'CreativeThemes',
				'beta' => false,
			]
		);
	}

	public function init_freemius() {
		if ( ! function_exists( 'blc_fs' ) ) {
			// Create a helper function for easy SDK access.
			function blc_fs() {
				global $blc_fs;

				if (! isset($blc_fs)) {
					// Include Freemius SDK.
					require_once dirname(__FILE__) . '/freemius/start.php';

					$blc_fs = fs_dynamic_init(array(
						'id' => '5115',
						'slug' => 'blocksy-companion',
						'type' => 'plugin',
						'public_key' => 'pk_b00a5cbae90b2e948015a7d0710f5',
						'is_premium' => false,
						// If your plugin is a serviceware, set this option to false.
						'has_premium_version' => false,
						'has_addons' => false,
						'has_paid_plans' => false,
						'is_org_compliant' => false,
						'menu' => array(
							'slug' => 'ct-dashboard',
							'support' => false,
							'contact' => false,
							'pricing' => false,
							'account' => false
						),
					));
				}

				return $blc_fs;
			}

			// Init Freemius.
			blc_fs();
			// Signal that SDK was initiated.
			do_action( 'blc_fs_loaded' );
		}
	}
}

Plugin::instance();

