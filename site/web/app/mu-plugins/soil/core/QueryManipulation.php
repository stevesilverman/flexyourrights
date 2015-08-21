<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


class soilQueryManipulation extends scbQueryManipulation {

	private $bits = array();
	private $wp_query;

	private static $filters = array(
		'posts_where',
		'posts_join',
		'posts_groupby',
		'posts_orderby',
		'posts_distinct',
		'post_limits',
		'posts_fields'
	);

	public function __construct( $callback, $once = true ) {
		_deprecated_function( 'soilQueryManipulation', '3.1', "'posts_clauses' filter" );
		parent::__construct( $callback, $once );
		
	}

}

