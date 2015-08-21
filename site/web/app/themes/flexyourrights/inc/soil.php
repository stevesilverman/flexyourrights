<?php

/**
 * SoilSetup
 *
 * Use this to load the files and setup soil specific for the project.
 *
 * @author Blue Riot Labs
 * @version 1.0
 */
if ( !class_exists('SoilSetup') ) {

  class SoilSetup {

    /**
     * PHP4 constructor method. This simply provides backwards compatibility for users with setups
     * on older versions of PHP. Once WordPress no longer supports PHP4, this method will be removed.
     */
    function SoilSetup() {
      $this->__construct();
    }

    /**
     * Constructor method for the SoilSetup class. This method adds other methods of the class to
     * specific hooks within WordPress. It controls the load order of the required files for running
     * the framework.
     */
    public function __construct() {

      add_action( 'after_setup_theme', array( &$this, 'constants' ), 1 );
      add_action( 'after_setup_theme', array( &$this, 'core' ), 2 );
      add_action( 'after_setup_theme', array( &$this, 'theme_support' ), 3 );
      add_action( 'after_setup_theme', array( &$this, 'filters' ), 4 );
      add_action( 'after_setup_theme', array( &$this, 'soil_setup_init' ), 5 );

    }

    /**
     * Defines the constant paths for use within the core framework, parent theme, and
     * child theme. Constants prefixed with 'SOIL_CUSTOM_' are for use only within the core
     * framework and don't reference other areas of the parent or child theme.
     */
    function constants() {

      if ( !defined( '__DIR__' ) ) { define( '__DIR__', dirname( __FILE__ ) ); }

      /* Setup MU mode. */
      define( 'SOIL_LOAD_MU', true );

      /* Sets the path to the core framework directory. */
      define( 'SOIL_CUSTOM_DIR', trailingslashit( THEME_DIR . '/inc' ) );

      /* Sets the path to the core framework directory URI. */
      define( 'SOIL_CUSTOM_URI', trailingslashit( THEME_URI . '/inc' ) );

      /* Sets the path to the template directory. */
      define( 'SOIL_CUSTOM_TEMPLATES', trailingslashit( SOIL_CUSTOM_DIR . '/templates' ) );

    }

    /* Load the Core. */
    function core() {

      /* Load Soil Extensions / Mods. */
      include_once( SOIL_CUSTOM_DIR . '/soil-custom.php' );

      /* Load Taxonomies. */
      //$this->taxonomies(); // all on single file
      $this->taxonomies( array( 'faq-categories' ) );  // a post type per page

      /* Load the Custom Post Types. */
      // $this->post_types(); // all on single file
      $this->post_types( array( 'faq', 'success-story' ) );  // a post type per page


      /* Load the Custom Admin Classes / Functions. */
      if ( is_admin() ) {
        // $this->admin(); // - all on single file
        // $this->admin( array( 'theme-settings', 'blah', 'blah2', ) ); // - separate files
      }

    } // end core()


    /* Sets the theme support settings. */
    function theme_support() {

      // remove theme support
      remove_theme_support( 'cleanup' );

      // add theme support
      add_theme_support( 'template-hierarchy' );
      add_theme_support( 'wp-post-formats' );

    }

    /* Add the actions and filters. */
    function filters() {

      // add_filter( 'widget_text', 'do_shortcode' );
      // add_filter( 'term_description', 'do_shortcode' );

    }


    /* Helper - Loads the taxonomy files */
    function taxonomies($files = null) {
      if ($files === null) $this->inc('roots-taxonomies');
      elseif (is_array($files)) $this->inc($files, 'taxonomies');
      else $this->inc($files);
    }

    /* Helper - Loads the post type files */
    function post_types($files = null) {
      if ($files === null) $this->inc('roots-post-types');
      elseif (is_array($files)) $this->inc($files, 'post-types');
      else $this->inc($files);
    }

    /* Helper - Loads the admin files */
    function admin($files = null) {
      if ($files === null) $this->inc('roots-admin');
      elseif (is_array($files)) $this->inc($files, 'admin');
      else $this->inc($files);
    }

    /* Helper - Loads the files based on what is passed in */
    function inc($files, $dir = null) {
      // set file path
      if (is_string($dir)) $file_path = SOIL_CUSTOM_DIR . $dir .'/';
      else $file_path = SOIL_CUSTOM_DIR;

      // include the file(s)
      if(is_array($files))
        foreach ($files as $file) include_once( $file_path . $file . '.php' );
      else
        include_once( $file_path . $files . '.php' );
    }


    /**
     * soil_setup_init - Core is loaded, give the ability to attach functions after
     * custom mods have been made and has initialized and loaded fully.
     */
    function soil_setup_init() {
      do_action( 'soil_setup_init' );
    }

  }

  /* Setup the Soil class */
  new SoilSetup;

}