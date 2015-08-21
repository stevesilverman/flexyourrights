<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


// Takes care of creating, updating and deleting database tables

class soilTable extends scbTable {

	function __construct( $name, $file, $columns, $upgrade_method = 'dbDelta' ) {
		//parent::__construct( $name, $file, $columns, $upgrade_method );
		$this->name = $name;
		$this->columns = $columns;
		$this->upgrade_method = $upgrade_method;

		soil_register_table( $name );

		if ( $file ) {
			soilUtil::add_activation_hook( $file, array( $this, 'install' ) );
			soilUtil::add_uninstall_hook( $file, array( $this, 'uninstall' ) );
		}
	}

	function install() {
		soil_install_table( $this->name, $this->columns, $this->upgrade_method );
	}

	function uninstall() {
		soil_uninstall_table( $this->name );
	}

}


/**
 * Register a table with $wpdb
 *
 * @param string $key The key to be used on the $wpdb object
 * @param string $name The actual name of the table, without $wpdb->prefix
 */
function soil_register_table( $key, $name = false ) {
	scb_register_table( $key, $name );
}

function soil_install_table( $key, $columns, $upgrade_method = 'dbDelta' ) {
	scb_install_table( $key, $columns, $upgrade_method );
}

function soil_uninstall_table( $key ) {
	scb_uninstall_table( $key );
}
