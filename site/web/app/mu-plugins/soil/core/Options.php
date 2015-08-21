<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

// Container for an array of options

class soilOptions extends scbOptions {

	/**
	 * Create a new set of options
	 *
	 * @param string $key Option name
	 * @param string $file Reference to main plugin file
	 * @param array $defaults An associative array of default values (optional)
	 */
	public function __construct( $key, $file, $defaults = array() ) {		
		//parent::__construct( $key, $file, $defaults );
		$this->key = $key;
		$this->defaults = $defaults;

		if ( $file ) {
			soilUtil::add_activation_hook( $file, array( $this, '_activation' ) );
			soilUtil::add_uninstall_hook( $file, array( $this, 'delete' ) );
		}

	}


}

