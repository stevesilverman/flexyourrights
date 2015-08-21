<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


// Data-aware form generator

class soilForms extends scbForms {

	static function input( $args, $formdata = false ) {
		if ( false !== $formdata ) {
			$form = new soilForm( $formdata );
			return $form->input( $args );
		}

		if ( empty( $args['name'] ) ) {
			return trigger_error( 'Empty name', E_USER_WARNING );
		}

		$args = wp_parse_args( $args, array(
			'desc' => '',
			'desc_pos' => 'after',
			'wrap' => self::TOKEN,
			'wrap_each' => self::TOKEN,
		) );

		if ( isset( $args['value'] ) && is_array( $args['value'] ) ) {
			$args['values'] = $args['value'];
			unset( $args['value'] );
		}

		if ( isset( $args['extra'] ) && !is_array( $args['extra'] ) )
			$args['extra'] = shortcode_parse_atts( $args['extra'] );

		self::$cur_name = self::get_name( $args['name'] );

		switch ( $args['type'] ) {
			case 'select':
			case 'radio':
				$input = self::_single_choice( $args );
				break;
			case 'checkbox':
				if ( isset( $args['values'] ) )
					$input = self::_multiple_choice( $args );
				else
					$input = self::_checkbox( $args );
				break;
			default:
				$input = self::_input( $args );
		}

		return str_replace( self::TOKEN, $input, $args['wrap'] );
	}

	
	#static function form_table( $rows, $formdata = NULL ) {} // Generates a table wrapped in a form
	#static function form( $inputs, $formdata = NULL, $nonce ) {} // Generates a form
	#static function table( $rows, $formdata = NULL ) {} // Generates a table
	#static function table_row( $args, $formdata = NULL ) {} // Generates a table row
	#static function form_table_wrap( $content, $nonce = 'update_options' ) {} // Wraps the given content in a <form><table>
	#static function form_wrap( $content, $nonce = 'update_options' ) {} // Wraps the given content in a <form> tag
	#static function table_wrap( $content ) {} // Wraps the given content in a <table>
	#static function row_wrap( $title, $content ) {} // Wraps the given content in a <tr><td>	
	
	// ____________WRAPPERS____________

	#private static function _single_choice( $args ) {} // 
	#private static function _multiple_choice( $args ) {} // 
	#private static function _expand_values( &$args ) {} // 
	#private static function _radio( $args ) {} // 
	#private static function _select( $args ) {} // 
	#private static function _checkbox( $args ) {} // Handle args for a single checkbox or radio input
	#private static function _input( $args ) {} // Handle args for text inputs
	#private static function _input_gen( $args ) {} // Generate html with the final args
	#private static function add_label( $input, $desc, $desc_pos ) {} // Generate the html for the label
	#static function get_name( $name ) {} // Generates the proper string for a name attribute.
	#static function get_value( $name, $value ) {} // Traverses the formdata and retrieves the correct value.



	/**
	 * Given a list of fields, extract the appropriate POST data and return it.
	 *
	 * @param array $fields List of args that would be sent to soilForms::input()
	 * @param array $to_update Existing data to update
	 *
	 * @return array
	 */
	static function validate_post_data( $fields, $to_update = array() ) {
		foreach ( $fields as $field ) {
			$value = soilForms::get_value( $field['name'], $_POST );

			$value = stripslashes_deep( $value );

			switch ( $field['type'] ) {
			case 'checkbox':
				if ( isset( $field['values'] ) && is_array( $field['values'] ) )
					$value = array_intersect( $field['values'], (array) $value );
				else
					$value = (bool) $value;

				break;
			case 'radio':
			case 'select':
				self::_expand_values( $field );

				if ( !isset( $field['values'][ $value ] ) )
					continue 2;
			}

			self::set_value( $to_update, $field['name'], $value );
		}

		return $to_update;
	}



}

/**
 * A wrapper for scbForms, containing the formdata
 */
class soilForm extends scbForm {

	function __construct( $data, $prefix = false ) {
		parent::__construct( $data, $prefix );

	}

	function traverse_to( $path ) {
		$data = soilForms::get_value( $path, $this->data );

		$prefix = array_merge( $this->prefix, (array) $path );

		return new soilForm( $data, $prefix );
	}

	function input( $args ) {
		$value = soilForms::get_value( $args['name'], $this->data );

		if ( !empty( $this->prefix ) ) {
			$args['name'] = array_merge( $this->prefix, (array) $args['name'] );
		}

		return soilForms::input_with_value( $args, $value );
	}

}

