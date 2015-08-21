<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


// custom taxonomy base class
if ( ! class_exists('soilRegisterTaxonomy') ) {

	class soilRegisterTaxonomy {
	  	private $taxonomy;
		private $post_types;
		private $args;
		private $sing_name;
		private $plural_name;

		private $defaults = array(
			'hierarchical' => true, 	// behave like a category
		);


		public function __construct( $taxonomy = null,  $post_types = null, $sing_name = null, $args = array(), $plural_name = null ) {

			if ( ! $taxonomy ) {
				return;
			}

			// meat n potatoes
			$this->taxonomy = $taxonomy;
			$this->sing_name = ( $sing_name ) ? $sing_name : $taxonomy;
			$this->plural_name = ( $plural_name ) ? $plural_name : $this->sing_name . 's';
			$this->post_types = ( is_string($post_types) ) ? array($post_types) : $post_types;

			// a few extra defaults. Mostly for labels. Overridden if proper $args present.
			$this->set_defaults();
			// sort out those $args
			$this->args = wp_parse_args($args, $this->defaults);
			// magic man
			$this->add_actions();

		}

		public function set_defaults() {
			$singular = ucwords($this->sing_name);
			$plural = ucwords($this->plural_name);
			$this->defaults['labels'] = array(
				'name' => __( $plural ),
				'singular_name' => __( $singular ),
				'search_items' => __( $plural ),
				'popular_items' => __( 'Most used ' . $plural ),
				'all_items' => __( 'All ' . $plural ),
				'parent_item' => __( 'Parent' ),
				'parent_item_colon' => __( 'Parent:' ),
				'edit_item' => __( 'Edit ' . $singular ),
				'update_item' => __( 'Update ' . $singular ),
				'add_new_item' => __( 'Add New ' . $singular  ),
				'new_item_name' => __( 'New ' . $singular . ' Name' ),
				'separate_items_with_commas' =>  __( 'Separate '.$plural.' with commas' ),
				'choose_from_most_used' => __( 'Choose from the most used '.$plural ),
				'add_or_remove_items' => __( 'Add or remove '.$plural ),
				'menu_name' => __( $plural ),
			);
		}

		public function add_actions() {
			add_action( 'init', array($this, 'register_taxonomies'), 11 ); // register after default so plugins / themes don't have to
		}

		public function register_taxonomies() {		
	  		register_taxonomy( $this->taxonomy, $this->post_types, $this->args);
		}


  } // end soilRegisterTaxonomy class

  /**
	* A helper function for the soilRegisterTaxonomy class.
	**/
	if ( ! function_exists( 'soil_register_taxonomy' ) && class_exists( 'soilRegisterTaxonomy' ) ) {
		function soil_register_taxonomy( $taxonomy = null,  $post_types = null, $sing_name = null, $args = array(), $plural_name = null ) {
			$custom_taxonomy = new soilRegisterTaxonomy( $taxonomy, $post_types, $sing_name, $args, $plural_name );
		}
	}

} // end if class exists
