<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

// custom post-type base class

if ( ! class_exists('soilRegisterPostType') ) {

	class soilRegisterPostType {

		private $post_type;
		private $post_slug;
		private $args;
		private $post_type_object;

		private $defaults = array(
			'show_ui' => true,
			'public' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'capability_type' => 'post',
		);

		public function __construct( $post_type = null, $args = array(), $custom_plural = false ) {
			if ( ! $post_type ) {
				return;
			}

			// meat n potatoes
			$this->post_type = $post_type;
			$this->post_slug = ( $custom_plural ) ? $custom_plural : $post_type . 's';

			// a few extra defaults. Mostly for labels. Overridden if proper $args present.
			$this->set_defaults();
			// sort out those $args
			$this->args = wp_parse_args($args, $this->defaults);

			// magic man
			$this->add_actions();
			$this->add_filters();

		}

		private function set_defaults() {
			$plural = ucwords( $this->post_slug );
			$singular = ucwords( $this->post_type );

			$this->defaults['labels'] = array(
				'name' => $plural,
				'singular_name' => $singular,
				'add_new_item' => 'Add New ' . $singular,
				'edit_item' => 'Edit ' . $singular,
				'new_item' => 'New ' . $singular,
				'view_item' => 'View ' . $singular,
				'search_items' => 'Search ' . $plural,
				'not_found' => 'No ' . $plural . ' found',
				'not_found_in_trash' => 'No ' . $plural . ' found in Trash'
			);
		}

		public function add_actions() {
			add_action( 'init', array($this, 'register_post_type'), 11 ); // register after default so plugins / themes don't have to
			add_action( 'template_redirect', array($this, 'context_fixer') );
		}

		public function add_filters() {
			add_filter( 'generate_rewrite_rules', array($this, 'add_rewrite_rules') );
			add_filter( 'body_class', array($this, 'body_classes') );
			if (is_admin()) add_filter( 'admin_body_class', array($this, 'admin_body_classes') );
		}

		public function context_fixer() {
			if ( get_query_var( 'post_type' ) == $this->post_type ) {
				global $wp_query;
				$wp_query->is_home = false;
			}
		}

		public function add_rewrite_rules( $wp_rewrite ) {
			$new_rules = array();
			$new_rules[$this->post_slug . '/page/?([0-9]{1,})/?$'] = 'index.php?post_type=' . $this->post_type . '&paged=' . $wp_rewrite->preg_index(1);
			$new_rules[$this->post_slug . '/(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?post_type=' . $this->post_type . '&feed=' . $wp_rewrite->preg_index(1);
			$new_rules[$this->post_slug . '/?$'] = 'index.php?post_type=' . $this->post_type;

			$wp_rewrite->rules = array_merge($new_rules, $wp_rewrite->rules);
			return $wp_rewrite;
		}

		public function register_post_type() {
			register_post_type( $this->post_type, $this->args );
		}


		public function body_classes( $c ) {
			if ( get_query_var('post_type') === $this->post_type ) {
				$c[] = $this->post_type;
				$c[] = 'type-' . $this->post_type;
			}
			return $c;
		}

		public function admin_body_classes( $c ) {
			global $wpdb, $post;
			if(@empty($post) || @empty($post->ID)) return '';
		    $post_type = isset($post->ID) ? get_post_type( $post->ID ) : 'unknown';
		    if(!isset($classes)) $classes = '';
	    	if ( is_admin() ) {
	        	$classes .= 'type-' . $post_type;
	    	}
	    	return $classes;
    	}

	} // end soilRegisterPostType class


	/**
	 * A helper function for the soilRegisterPostType class.
	 **/
	if ( ! function_exists( 'soil_register_post_type' ) && class_exists( 'soilRegisterPostType' ) ) {
		function soil_register_post_type( $post_type = null, $args=array(), $custom_plural = false ) {
			$custom_post = new soilRegisterPostType( $post_type, $args, $custom_plural );
		}
	}

} // end if class exists
