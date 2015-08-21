<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


// Admin screen with metaboxes base class

abstract class soilBoxesPage extends scbBoxesPage {
	/*
		A box definition looks like this:
		array( $slug, $title, $column );

		Available columns: normal, side, column3, column4
	*/
	protected $boxes = array();


	function __construct( $file = false, $options = null ) {
		parent::__construct( $file, $options );

		soilUtil::add_uninstall_hook( $this->file, array( $this, 'uninstall' ) );
	}
	
}



