<?php

if (!class_exists('FlexYourRightsSuccessStory')) {
	class FlexYourRightsSuccessStory extends soilCustomRegisterPostType {

		protected $post_type        = 'fyr_success_story';
		protected $post_type_name   = 'Success Story';
		protected $post_type_plural = 'Success Stories';
		protected $post_type_args   = array(
			'taxonomies'        => array('post_tag'),
			// 'menu_icon'         => get_template_directory_uri() . '/img/cpt-success-story.png',
			'rewrite'           => array('slug' => 'success-stories'),
			'has_archive'       => 'success-stories',
		);

		/* Load Class */
	    function __construct() {
	      parent::__construct($this->post_type, $this->post_type_args, $this->post_type_plural);
		  	add_action('admin_init', array(&$this, 'meta_boxes'));
	    }

		/* Setup metaboxes */
		function meta_boxes() {
			$prefix = '_fyr_';

			// Details metabox
			soil_register_custom_meta_box(array(
		    'id'         => $this->post_type . '_details', // Metabox ID
		    'title'      => __($this->post_type_name . ' Details', 'roots'), // Metabox title
		    'pages'      => array($this->post_type), // Post types to display on
				'show_names' => true, // Show field names on the left
			  'fields'     => array(

				  // Name
					array(
		        'name' => __('Name', 'roots'),
		        'id'   => $prefix . 'name',
		        'type' => 'text',
		        'args' => array(
		        	'class' => 'cmb_text_lrg',
		        	'style' => 'width:97%;',
		        ),
				  ),

				  // Location
					array(
		        'name' => __('Location', 'roots'),
		        'id'   => $prefix . 'location',
		        'type' => 'text',
		        'args' => array(
		        	'class' => 'cmb_text_lrg',
		        	'style' => 'width:60%;',
		        ),
				  ),

			  )
			));
		}
	}

	new FlexYourRightsSuccessStory();
}