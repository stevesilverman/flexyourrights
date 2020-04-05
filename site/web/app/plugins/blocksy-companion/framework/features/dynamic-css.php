<?php

namespace Blocksy;

class DynamicCss {
	public function __construct() {
		add_filter(
			'blocksy:dynamic-css:has_files_cache',
			function ($r) {
				if (is_customize_preview()) {
					if (! wp_doing_ajax()) {
						return false;
					}
				}

				if (! $this->should_use_files()) {
					return false;
				}

				$theme_paths = $this->maybe_prepare_theme_uploads_path();

				if (! $theme_paths) {
					return false;
				}

				foreach ($this->get_chunks() as $chunk) {
					if (! $chunk['enabled']) {
						continue;
					}

					$file = $theme_paths['css_path'] . '/' . $chunk['filename'];

					if (! $this->wp_filesystem->exists($file)) {
						return false;
					}
				}

				return true;
			}
		);

		add_filter(
			'blocksy_performance_end_customizer_options',
			function ($opts) {
				$opts['dynamic_css_file'] = [
					'label' => __( 'Dynamic CSS Output', 'blc' ),
					'type' => 'ct-radio',
					'value' => 'file',
					'view' => 'text',
					'desc' => __( 'The strategy of outputing the dynamic CSS. File - all the CSS code will be placed in a static file, otherwise it will be placed inline in head.', 'blc' ),
					'choices' => [
						'file' => __( 'File', 'blc' ),
						'inline' => __( 'Inline', 'blc' ),
					],
				];

				$opts[blocksy_rand_md5()] = [
					'type' => 'ct-divider',
				];

				return $opts;
			}
		);

		add_action('updated_option', function($option_name, $old_value, $value) {
			if ('active_plugins' === $option_name) {
				$this->generate_css_files();
			}
		}, 10, 3);

		add_action('customize_save_after', function () {
			$this->generate_css_files();
		});

		add_action('blocksy:dynamic-css:regenere_css_files', function () {
			$this->generate_css_files();
		});

		if (function_exists('blocksy_has_css_in_files') && blocksy_has_css_in_files()) {
			$this->enqueue_dynamic_css();
		}
	}

	public function should_use_files() {
		return get_theme_mod('dynamic_css_file', 'file') === 'file';
	}

	public function get_chunks() {
		return [
			[
				'filename' => 'global.css',
				'context' => 'files:global',
				'enabled' => true
			],
		];
	}

	public function enqueue_dynamic_css() {
		if (is_admin()) {
			return;
		}

		$theme_paths = $this->maybe_prepare_theme_uploads_path();

		if (! $theme_paths) {
			return;
		}

		foreach ($this->get_chunks() as $chunk) {
			if (! $chunk['enabled']) {
				continue;
			}

			$file = $theme_paths['css_path'] . '/' . $chunk['filename'];
			$url = $theme_paths['css_url'] . '/' . $chunk['filename'];

			wp_enqueue_style(
				'blocksy-dynamic-' . pathinfo($chunk['filename'], PATHINFO_FILENAME),
				set_url_scheme($url),
				[],
				substr((string) filemtime($file), -5, 5)
			);
		}
	}

	public function generate_css_files() {
		if (! $this->should_use_files()) {
			return false;
		}

		$theme_paths = $this->maybe_prepare_theme_uploads_path();

		if (! $theme_paths) {
			return false;
		}

		$chunks = $this->get_chunks();

		foreach ($chunks as $chunk) {
			if (! $chunk['enabled']) {
				continue;
			}

			$file = $theme_paths['css_path'] . '/' . $chunk['filename'];
			$url = $theme_paths['css_url'] . '/' . $chunk['filename'];

			$this->wp_filesystem->put_contents(
				$file,
				blocksy_get_dynamic_css_file_content(['context' => $chunk['context']])
			);
		}
	}

	public function maybe_prepare_theme_uploads_path() {
		require_once (ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();

		global $wp_filesystem;

		$this->wp_filesystem = $wp_filesystem;
		$uploads = wp_upload_dir();

		// Theme folders in `uploads` directory.
		$folders_in_uploads = array(
			'base'  => 'blocksy',
			'css'   => 'blocksy/css'
		);

		foreach($folders_in_uploads as $folder => $path) {
			// Server path.
			$theme_paths[
				$folder . '_path'
			] = $uploads['basedir'] . '/' . $path;

			// URL.
			$theme_paths[
				$folder . '_url'
			] = $uploads['baseurl'] . '/' . $path;
		}

		// Custom css file.

		if (! $this->has_direct_access()) {
			return false;
		}

		if (null === $this->wp_filesystem) {
			return false;
		}

		foreach(array_keys($folders_in_uploads) as $folder) {
			$path = $theme_paths[$folder . '_path'];
			$parent = dirname($path);

			if ($this->wp_filesystem->is_writable($parent)) {
				if (! $this->wp_filesystem->is_dir($path)) {
					$this->wp_filesystem->mkdir($path);
				}
			}
		}

		return $theme_paths;
	}

	public function has_direct_access( $context = null ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();

		/** @var WP_Filesystem_Base $wp_filesystem */
		global $wp_filesystem;

		if ( $wp_filesystem ) {
			if ( is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
				return false;
			} else {
				return $wp_filesystem->method === 'direct';
			}
		}

		if ( get_filesystem_method( [], $context ) === 'direct' ) {
			ob_start();

			{
				$creds = request_filesystem_credentials( admin_url(), '', false, $context, null );
			}

			ob_end_clean();

			if ( WP_Filesystem( $creds ) ) {
				return true;
			}
		}

		return false;
	}
}

