<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


// Various utilities

class soilUtil extends scbUtil {

	// Force script enqueue
	#static function do_scripts( $handles ) 

	// Force style enqueue
	#static function do_styles( $handles ) 

	// Enable delayed activation; to be used with soil_init()
	static function add_activation_hook( $plugin, $callback ) {
		if ( defined( 'SOIL_LOAD_MU' ) )
			register_activation_hook( $plugin, $callback );
		else
			add_action( 'soil_activation_' . plugin_basename( $plugin ), $callback );
	}

	// For debugging
	static function do_activation( $plugin ) {
		do_action( 'scb_activation_' . plugin_basename( $plugin ) );
	}

	// Have more than one uninstall hooks; also prevents an UPDATE query on each page load
	#static function add_uninstall_hook( $plugin, $callback ) 

	// Get the current, full URL
	#static function get_current_url() 

	// Apply a function to each element of a ( nested ) array recursively
	#static function array_map_recursive( $callback, $array ) 

	// Prepare an array for an IN statement
	#static function array_to_sql( $values ) 

	// Example: split_at( '</', '<a></a>' ) => array( '<a>', '</a>' )
	#static function split_at( $delim, $str ) 
	
}


//_____Minimalist HTML framework_____

/*
 * Examples:
 *
 * html( 'p', 'Hello world!' );												<p>Hello world!</p>
 * html( 'a', array( 'href' => 'http://example.com' ), 'A link' );			<a href="http://example.com">A link</a>
 * html( 'img', array( 'src' => 'http://example.com/f.jpg' ) );				<img src="http://example.com/f.jpg" />
 * html( 'ul', html( 'li', 'a' ), html( 'li', 'b' ) );						<ul><li>a</li><li>b</li></ul>
 */


/** Load helper functions for mustache, if it exist */
if ( class_exists( 'Mustache' ) ) {

	/** Soil Render Template */
	if ( ! function_exists( 'soil_mustache_render' ) ):
	function soil_mustache_render( $file, $data, $ext = false, $partials = array() ) {
		$partial_data = array();
		foreach ( $partials as $partial ) {
			$partial_data[$partial] = soil_load_mustache_template( $partial . '.html' );
		}
	
		$m = new Mustache;
	
		return $m->render( soil_load_mustache_template( $file, $ext ), $data, $partial_data );
	}
	endif;
	
	
	/** Load Soil Templates */
	if ( ! function_exists( 'soil_load_template' ) ):
	function soil_load_mustache_template( $file, $ext = false ) {
		
		if( $ext == false )
			return file_get_contents( SOIL_TEMPLATES . '/' . $file );
			
		if($ext && is_string($ext)) {
			if( file_exists( SOIL_EXTENSIONS . '/' . $ext . '/templates/' . $file ) )
				return file_get_contents( SOIL_EXTENSIONS . '/' . $ext . '/templates/' . $file );
		}
			
	}
	endif;	

}


//_____Add actions only on certain URLs_____

/*
 * Examples:
 * 
 * soil_route_action('new-research', 'init', 'my_func_name');
 * soil_route_action('^/category/new-research$', 'init', 'my_func_name');
 *
 * soil_route_action('?.*my_get_var=my_val', 'init', 'my_func_name');
 * soil_route_action('??.*my_post_var=my_val', 'init', 'my_func_name');
 *
 * Note: Do not use this function for auth purposes; it is trivial to defeat with a URL.
 *       Instead, use for display logic, feedback messages, etc.
 */

function soil_route_action($route, $tag, $function_to_add, $priority = 10, $accepted_args = 1) {
	# TODO: Support passing array of route conditions in addition to a regex snippet string
	if(is_array($route)) {
		return;
	}

	else {
		$url = $_SERVER['REQUEST_URI'];
		if(!@empty($_POST))
			$url .= '??'.http_build_query($_POST);
		else if(!@empty($_SERVER['QUERY_STRING']))
			$url .= '?'.$_SERVER['QUERY_STRING'];
			
		# TODO: revisit this scheme, using a non-regex character (not "?")
		if(!preg_match("/.*".$route.".*/", $url, $matches))
			return;
	}
	
	# TODO: Set # of accepted args based on capturing parens, and somehow pass through to do_action when fired

	# If we're still here, the function succeeded, and the action should be added
	add_action($tag, $function_to_add, $priority, $accepted_args);
}

// Return a standard admin notice
function soil_admin_notice( $msg, $class = 'updated' ) {
	return "<div class='$class fade'><p>$msg</p></div>\n";
}

// Transform a list of objects into an associative array
function soil_list_fold( $list, $key, $value ) {
	$r = array();

	if ( is_array( reset( $list ) ) ) {
		foreach ( $list as $item )
			$r[ $item[ $key ] ] = $item[ $value ];
	} else {
		foreach ( $list as $item )
			$r[ $item->$key ] = $item->$value;
	}

	return $r;
}

function soil_is_assoc($arr) {
	// Simple way to determine if array is ordered or associative: is the first key numeric?
	$first_key = current(array_keys($arr));
	return !is_numeric($first_key);
}
