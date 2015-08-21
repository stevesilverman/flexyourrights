<?php
/**
 * WP Soil - A WordPress plugin / theme development framework.
 *
 * WP Soil is a framework for developing WordPress themes and plugins.  The framework allows plugin
 * and theme developers to quickly build themes and plugins without having to handle all of the "logic"
 * behind them or having to code complex functionality for features that are often needed.
 * The framework was built to make it easy for developers to include (or not include) specific, pre-coded
 * features. You handle all the markup, style, and scripts while the framework handles the logic.
 *
 * WP Soil is a modular system, which means that developers can pick and choose the features they
 * want to include within their themes.  Most files are only loaded if the theme registers support for the
 * feature using the add_theme_support( $feature ) function within their theme.
 *
 * WP Soil was inspired by some amazing WordPress developers and their work. Without them, this would have
 * have not been possible. Please check out their work, and contributions. To name a few:
 *
 * scbFramework, Posts-2-Posts, AppThemes - Quality Control
 * @author Cristi Burcă <scribu@gmail.com>
 * @site http://scribu.net/
 * @link http://scribu.net/wordpress/scb-framework/
 * @link http://scribu.net/wordpress/posts-to-posts/
 * @link http://www.appthemes.com/themes/quality-control/
 *
 * HybridCore
 * @author Justin Tadlock <justin@justintadlock.com>
 * @site http://themehybrid.com/
 * @link http://themehybrid.com/hybrid-core/
 *
 * WP Framework
 * @author Ptah Dunbar <http://ptahdunbar.com/contact>
 * @site http://ptahdunbar.com/
 * @link http://wordpress.org/extend/themes/wp-framework/
 *
 * Roots Theme - HTML5 Boilerplate
 * @author Ben Word <ben@benword.com>
 * @site http://benword.com/
 * @link http://www.rootstheme.com/
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package WPSoil
 * @version 0.3
 * @author Nathan Smith <nsmith@blueriotlabs.com>
 * @copyright Copyright (c) 2012, Blue Riot Labs
 * @link http://www.blueriotlabs.com/wp-soil
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * The WP_Soil class launches the framework. It's the organizational structure behind the entire framework.
 * This class should be loaded and initialized before anything else within the theme is called to properly use
 * the framework.
 */

if ( !class_exists( 'WP_Soil' ) ) {

	class WP_Soil {

		/**
		 * Soil Mode.
		 */
		var $mode;

		/**
		 * Soil Path.
		 */
		var $path;


		/**
		 * PHP4 constructor method. This simply provides backwards compatibility for users with setups
		 * on older versions of PHP. Once WordPress no longer supports PHP4, this method will be removed.
		 */
		function WP_Soil() {
			$this->__construct();
		}


		/**
		 * Constructor method for the WP_Soil class. This method adds other methods of the class to
		 * specific hooks within WordPress. It controls the load order of the required files for running
		 * the framework.
		 *
		 * TODO
		 *   - See if there is a better spot to attach everything to, vs adding new action.
		 *   - It should perform a theme setup function on the 'after_setup_theme' hook with a priority
		 * 	 - of 10.  Child themes should add their theme setup function on the 'after_setup_theme' hook with
		 * 	 - a priority of 11.  This allows the class to load theme-supported features at the appropriate
		 *   - time, which is on the 'after_setup_theme' hook with a priority of 12
		 */
		public function __construct() {

			/* Determine if we are in plugin or theme mode. */
			add_action( 'muplugins_loaded', array( &$this, 'mode' ), 0 );

			/* Define framework, parent theme, and child theme constants. */
			add_action( 'muplugins_loaded', array( &$this, 'constants' ), 1 );

			/* Load the core functions required by the rest of the framework. */
			add_action( 'muplugins_loaded', array( &$this, 'core' ), 2 );

			/* Initialize the framework's default actions and filters. */
			add_action( 'muplugins_loaded', array( &$this, 'filters' ), 3 );

			/* Language functions and translations setup. */
			add_action( 'muplugins_loaded', array( &$this, 'locale' ), 4 );

			/* Load the theme support. */
			add_action( 'muplugins_loaded', array( &$this, 'theme_support' ), 5 );

			/* Load the soil loaded action. */
			add_action( 'muplugins_loaded', array( &$this, 'soil_loaded' ), 6 );

			/* Load the framework functions. */
			add_action( 'after_setup_theme', array( &$this, 'functions' ), 12 );

			/* Load the framework extensions. */
			add_action( 'after_setup_theme', array( &$this, 'extensions' ), 13 );

			/* Load admin files. */
			add_action( 'wp_loaded', array( &$this, 'admin' ) );
		}


		/**
		 * Determine if the framework is installed in the plugin or theme folder so that
		 * we can set proper file paths.
		 *
		 * TODO - Will only work as long as in the plugin or theme folders
		 */
		function mode() {
			/* Figure out where we are running from by the file path. */
			if ( strlen( strstr( dirname( __FILE__ ), 'mu-plugins' ) ) > 0 ) {
				$this->mode = 'mu-plugin';
				$this->path = substr( dirname( __FILE__ ), strpos( dirname( __FILE__ ), 'mu-plugins' ) );
			} elseif ( strlen( strstr( dirname( __FILE__ ), 'plugins' ) ) > 0 ) {
				$this->mode = 'plugin';
				$this->path = substr( dirname( __FILE__ ), strpos( dirname( __FILE__ ), 'plugins' ) );
			} elseif ( strlen( strstr( dirname( __FILE__ ), 'themes' ) ) > 0 ) {
				$this->mode = 'theme';
				$this->path = substr( dirname( __FILE__ ), strpos( dirname( __FILE__ ), 'themes') );
			}
		}

		/**
		 * Defines the constant paths for use within the core framework, parent theme, and
		 * child theme.  Constants prefixed with 'SOIL_' are for use only within the core
		 * framework and don't reference other areas of the parent or child theme.
		 *
		 * @since 0.1
		 */
		function constants() {

			if ( $this->mode == 'theme' ) {
				$soil_dir = trailingslashit( WP_CONTENT_DIR ) . $this->path;
				$soil_uri = trailingslashit( WP_CONTENT_URL ) . $this->path;
			} else {
				$soil_dir = plugin_dir_path( __FILE__ );
				$soil_uri = plugin_dir_url( __FILE__ );
			}

			/* Sets the path to the parent theme directory. */
			define( 'THEME_DIR', get_template_directory() );

			/* Sets the path to the parent theme directory URI. */
			define( 'THEME_URI', get_template_directory_uri() );

			/* Sets the path to the child theme directory. */
			define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

			/* Sets the path to the child theme directory URI. */
			define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

			/* Sets the path to the core framework directory. */
			define( 'SOIL_DIR', trailingslashit( $soil_dir ) );

			/* Sets the path to the core framework directory URI. */
			define( 'SOIL_URI', trailingslashit( $soil_uri ) );

			/* Sets the path to the core framework admin directory. */
			define( 'SOIL_ADMIN', trailingslashit( SOIL_DIR ) . 'admin' );

			/* Sets the path to the core framework classes directory. */
			define( 'SOIL_CORE', trailingslashit( SOIL_DIR ) . 'core' );

			/* Sets the path to the core framework includes directory. */
			define( 'SOIL_INC', trailingslashit( SOIL_DIR ) . 'includes' );

			/* Sets the path to the core framework extensions directory. */
			define( 'SOIL_EXT', trailingslashit( SOIL_DIR ) . 'extensions' );

			/* Sets the path to the core framework images directory URI. */
			define( 'SOIL_IMAGES', trailingslashit( SOIL_URI ) . 'img' );

			/* Sets the path to the core framework CSS directory URI. */
			define( 'SOIL_CSS', trailingslashit( SOIL_URI ) . 'css' );

			/* Sets the path to the core framework JavaScript directory URI. */
			define( 'SOIL_JS', trailingslashit( SOIL_URI ) . 'js' );

			/* Sets the path to the core framework templates directory. */
			define( 'SOIL_TEMPLATES', trailingslashit( SOIL_DIR ) . 'templates' );

		}


		/**
	   * Load the WP-Soil Core.
		 */
		function core() {
			require_once( SOIL_CORE . '/scb.php' );

			// Load Mustache
			if ( !class_exists( 'Mustache' ) ) {
				require SOIL_CORE . '/mustache/Mustache.php';
			}

			foreach ( array(
				'soilUtil', 'soilOptions', 'soilForms', 'soilTable', 'soilWidget', 'soilAdminPage', 'soilBoxesPage',
				'soilCron', 'soilHooks', 'soilTaxonomy', 'soilPostType', 'soilMetaBox', 'SoilAppPage'
			) as $className ) {
				include SOIL_CORE . '/' . substr( $className, 4 ) . '.php';
			}
		}


		/**
		 * Handles the locale functions file and translations.
		 */
		function locale() {

			/* Load theme textdomain. */
			// load_theme_textdomain( hybrid_get_textdomain() );

			/* Get the user's locale. */
			//$ locale = get_locale();

			/* Locate a locale-specific functions file. */
			// $locale_functions = locate_template( array( "languages/{$locale}.php", "{$locale}.php" ) );

			/* If the locale file exists and is readable, load it. */
			// if ( !empty( $locale_functions ) && is_readable( $locale_functions ) )
				// require_once( $locale_functions );
		}


		/**
		 * Loads the framework functions. Many of these functions are needed to properly run the
		 * framework. Some components are only loaded if the theme supports them.
		 */
		function functions() {

			/* Load the utility functions. */
			require_once( trailingslashit( SOIL_INC ) . 'functions.php' );

			/* Load the core hooks. */
			require_if_theme_supports( 'hooks', trailingslashit( SOIL_INC ) . 'hooks.php' );

			/* Load roots cleanup. */
			require_if_theme_supports( 'cleanup', trailingslashit( SOIL_INC ) . 'cleanup.php' );

			/* Load the template hierarchy  functions. */
			require_if_theme_supports( 'template-hierarchy', trailingslashit( SOIL_INC ) . 'template-hierarchy.php' );

			/* Load the default interface page for edit profile. */
			require_if_theme_supports( 'edit-profile', trailingslashit( SOIL_INC ) . 'edit-profile.php' );

			/* Load the theme wrapper if supported. */
			require_if_theme_supports( 'theme-wrapper', trailingslashit( SOIL_INC ) . 'wrapping.php' );

			/* Load the deprecated functions if supported. */
			require_if_theme_supports( 'soil-deprecated', trailingslashit( SOIL_INC ) . 'deprecated.php' );

		}


		/**
		 * Load extensions (external projects). Extensions are projects that are included within the
		 * framework but are not a part of it. They are external projects developed outside of the
		 * framework. Themes must use add_theme_support( $extension ) to use a specific extension
		 * within the theme. This should be declared on 'after_setup_theme' no later than a priority of 11.
		 */
		function extensions() {

			/* Load MediaElement.js. */
			require_if_theme_supports( 'mediaelementjs', trailingslashit( SOIL_EXT ) . 'mediaelementjs/init.php' );

			/* Load Video JS. */
			require_if_theme_supports( 'videojs', trailingslashit( SOIL_EXT ) . 'videojs/init.php' );

			/* Load Query Multiple Taxonomies. */
			require_if_theme_supports( 'query-multi-tax', trailingslashit( SOIL_EXT ) . 'query-multi-tax/init.php' );

			/* Load the WP-Post Formats. */
			require_if_theme_supports( 'wp-post-formats', trailingslashit( SOIL_EXT ) . 'wp-post-formats/cf-post-formats.php' );

		}

		/**
		 * Load admin files for the framework.
		 */
		function admin() {

			/* Check if we're in the WordPress admin. */
			if ( is_admin() || is_super_admin() ) {

				/* Load the main admin functions. */
				require_once( trailingslashit( SOIL_ADMIN ) . 'admin.php' );

				/* Load the main admin dashboard file. */
				require_if_theme_supports( 'admin-dashboard', trailingslashit( SOIL_ADMIN ) . 'dashboard.php' );

				/* Load the main theme updater file. */
				require_if_theme_supports( 'admin-updater', trailingslashit( SOIL_ADMIN ) . 'updater.php' );

				/* Load the theme importer if supported. */
				require_if_theme_supports( 'admin-importer', trailingslashit( SOIL_ADMIN ) . 'importer.php' );

			}
		}


		/**
		 * Adds the default framework actions and filters.
		 */
		function filters() {

			/* Filter the textdomain mofile to allow child themes to load the parent theme translation. */
			// add_filter( 'load_textdomain_mofile', 'hybrid_load_textdomain', 10, 2 );

			/* Make text widgets and term descriptions shortcode aware. */
			add_filter( 'widget_text', 'do_shortcode' );
			add_filter( 'term_description', 'do_shortcode' );
		}


		/**
		 * Adds the default theme support functions.
		 */
		function theme_support() {

			/**
			 * Add theme support so we can kill it later if we have to.
			 */
			add_theme_support( 'hooks' );
			add_theme_support( 'cleanup' );
			add_theme_support( 'template-hierarchy' );

		}


		/**
		 * soilLoaded - Core is loaded, give the ability to attach functions after
		 * framework has initialized and loaded fully.
		 */
		function soil_loaded() {
			do_action( 'soil_loaded' );
		}


	}

	// Commented out for Hearst use
	$WP_Soil = new WP_Soil;

}
