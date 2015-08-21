<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


/**
 * Helper class for defining full-page controllers.
 *
 * Supported methods:
 *  - parse_query() - for correcting query flags
 *  - the_posts(), posts_clauses(), posts_request() for various other manipulations
 *  - template_redirect() - for enqueuing scripts etc.
 *  - template_include( $path ) - for loading a different template file
 *  - title_parts( $parts ) - for changing the title
 */
abstract class SoilAppPageController {

	/**
	 * Test if this controller should handle the current page.
	 *
	 * Use is_*() conditional tags and get_query_var()
	 *
	 * @return bool
	 */
	abstract function test();


	function __construct() {
		foreach ( array( 'parse_query' ) as $method ) {		
			if ( method_exists( $this, $method ) )
				add_action( $method, array( $this, '_action' ) );
		}

		foreach ( array( 'the_posts', 'posts_clauses', 'posts_request' ) as $method ) {
			if ( method_exists( $this, $method ) )
				add_filter( $method, array( $this, '_filter' ), 10, 2 );
		}

		add_filter( 'template_redirect', array( $this, '_template_redirect' ) );
	}

	final function _action( $wp_query ) {
		if ( !$wp_query->is_main_query() || !$this->test() )
			return;

		$method = current_filter();

		$this->$method( $wp_query );
	}

	final function _filter( $value, $wp_query ) {
		if ( !$wp_query->is_main_query() || !$this->test() )
			return $value;

		$method = current_filter();

		return $this->$method( $value, $wp_query );
	}

	final function _template_redirect() {
		if ( !$this->test() )
			return;

		if ( method_exists( $this, 'template_redirect' ) )
			$this->template_redirect();

		if ( method_exists( $this, 'template_include' ) )
			add_filter( 'template_include', array( $this, 'template_include' ) );

		if ( method_exists( $this, 'title_parts' ) )
			add_filter( 'soil_title_parts', array( $this, 'title_parts' ) );
	}
}


/**
 * Class for handling special pages that have a specific template file.
 */
class SoilAppPageTemplate extends SoilAppPageController {

	private $template;
	private $default_title;

	private static $instances = array();
	private static $page_ids = array();

	static function get_id( $template ) {
		if ( isset( self::$page_ids[$template] ) )
			return self::$page_ids[$template];

		// don't use 'fields' => 'ids' because it skips caching
		$pages = get_posts( array(
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => $template,
			'posts_per_page' => 1
		) );

		if ( empty( $pages ) )
			$page_id = 0;
		else
			$page_id = $pages[0]->ID;

		self::$page_ids[$template] = $page_id;

		return $page_id;
	}

	static function install() {
		foreach ( self::$instances as $template => $instance ) {
			if ( self::get_id( $template ) )
				continue;

			$page_id = wp_insert_post( array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_title' => $instance->default_title
			) );

			add_post_meta( $page_id, '_wp_page_template', $template );
		}
	}

	function __construct( $template, $default_title ) {
		$this->template = $template;
		$this->default_title = $default_title;

		self::$instances[$template] = $this;

		parent::__construct();
	}

	function test() {

		global $wp_query;
		$page = $wp_query->get_queried_object();
				
		if (!isset($page->post_type) || !$page  || in_array($page->post_type, array('attachment', 'revision', 'nav_menu_item')) )
			return false;

		$custom_fields = get_post_custom_values('_wp_'.$page->post_type.'_template',$page->ID) ? 
			get_post_custom_values('_wp_'.$page->post_type.'_template',$page->ID) : 
			get_post_custom_values('_wp_page_template',$page->ID);
		
		$page_template = $custom_fields[0];
					
		// We have no argument passed so just see if a page_template has been specified
		if ( empty( $this->template ) ) {		
			if ( !empty( $page_template ) and ( 'default' != $page_template ) ) {
				return true;
			}
		} elseif ( $this->template == $page_template ) {
			return true;
		} elseif ( in_array($this->template, array( $page->post_type.'/interface.php', $page->post_type.'-interface.php', 'interface.php' ))) {
			return true;
		}
	
		return false;

	}
}

add_action( 'soil_first_run', array( 'SoilAppPageTemplate', 'install' ) );

