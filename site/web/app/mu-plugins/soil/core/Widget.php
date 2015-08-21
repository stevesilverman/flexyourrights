<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


// Adds compatibility methods between WP_Widget and scbForms

abstract class soilWidget extends scbWidget {

	private static $soil_widgets = array();

	static function init( $class, $file = '', $base = '' ) {
		self::$soil_widgets[] = $class;

		add_action( 'widgets_init', array( __CLASS__, '_soil_register' ) );

		// for auto-uninstall
		if ( $file && $base && class_exists( 'soilOptions' ) )
			new soilOptions( "widget_$base", $file );
	}

	static function _soil_register() {
		foreach ( self::$soil_widgets as $widget )
			register_widget( $widget );
	}


	// See soilForms::input()
	// Allows extra parameter $args['title']
	protected function input( $args, $formdata = array() ) {
		$prefix = array( 'widget-' . $this->id_base, $this->number );

		$form = new soilForm( $formdata, $prefix );

		// Add default class
		if ( !isset( $args['extra'] ) && 'text' == $args['type'] )
			$args['extra'] = array( 'class' => 'widefat' );

		// Add default label position
		if ( !in_array( $args['type'], array( 'checkbox', 'radio' ) ) && empty( $args['desc_pos'] ) )
			$args['desc_pos'] = 'before';

		$name = $args['name'];

		if ( !is_array( $name ) && '[]' == substr( $name, -2 ) )
			$name = array( substr( $name, 0, -2 ), '' );

		$args['name'] = $name;

		return $form->input( $args );
	}


	// setup some defaults so we don't have to worry about widget title if that's all it has
    function form( $instance ) {
        if ( empty( $instance ) )
            $instance = $this->defaults;
           
        $field_defaults = array('type'  => 'text','extra' => array( 'class' => 'widefat' ));

        $fields = array(
            array( 'name' => 'title', 'desc' => __('Title:', 'roots') ),
        );
       
        foreach ( $fields as $field ) {
            $field = wp_parse_args($field, $field_defaults);
            echo html( 'p', $this->input( $field, $instance ) );
        }
    }


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

	    $instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}



}

