<?php

if (!class_exists('FlexYourRightsFaqCategories')) {

  class FlexYourRightsFaqCategories extends soilCustomRegisterTaxonomy {

    protected $taxonomy = 'fyr_faq_categories';
    protected $post_types = null;
    protected $sing_name = 'FAQ Category';
    protected $plural_name = 'FAQ Categories';
    protected $taxonomy_args = array(
      'rewrite'     => array('slug' => 'faqs/category'),
    );

    /* Load Class */
      function __construct() {
        parent::__construct($this->taxonomy, $this->post_types, $this->sing_name, $this->taxonomy_args, $this->plural_name);
      }

  }

  new FlexYourRightsFaqCategories();

}