<?php

if (!class_exists('FlexYourRightsFAQ')) {
	class FlexYourRightsFAQ extends soilCustomRegisterPostType {

		protected $post_type        = 'fyr_faq';
		protected $post_type_name   = 'FAQ';
		protected $post_type_plural = 'FAQs';
		protected $post_type_args   = array(
			'taxonomies'        => array('post_tag', 'fyr_faq_categories'),
			// 'menu_icon'         => get_template_directory_uri() . '/img/cpt-faq.png',
			'rewrite'           => array('slug' => 'faqs'),
			'has_archive'       => 'faqs',
		);

		/* Load Class */
    function __construct() {
      parent::__construct($this->post_type, $this->post_type_args, $this->post_type_plural);
	  	add_action('admin_init', array(&$this, 'meta_boxes'));
    }

		/* Setup metaboxes */
		function meta_boxes() {
			$prefix = '_fyr_';

		}
	}

	new FlexYourRightsFAQ();
}