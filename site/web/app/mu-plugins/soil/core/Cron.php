<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


// wp-cron job container

class soilCron extends scbCron {

	/**
	 * Create a new cron job
	 *
	 * @param string Reference to main plugin file
	 * @param array List of args:
	 		string $action OR callback $callback
			string $schedule OR number $interval
			array $callback_args (optional)
	 */
	function __construct( $file = false, $args ) {
		extract( $args, EXTR_SKIP );

		// Set time & schedule
		if ( isset( $time ) )
			$this->time = $time;

		if ( isset( $interval ) ) {
			$this->schedule = $interval . 'secs';
			$this->interval = $interval;
		} elseif ( isset( $schedule ) ) {
			$this->schedule = $schedule;
		}

		// Set hook
		if ( isset( $action ) ) {
			$this->hook = $action;
		} elseif ( isset( $callback ) ) {
			$this->hook = self::_callback_to_string( $callback );
			add_action( $this->hook, $callback );
		} elseif ( method_exists( $this, 'callback' ) ) {
			$this->hook = self::_callback_to_string( array( $this, 'callback' ) );
			add_action( $this->hook, $callback );
		} else {
			trigger_error( '$action OR $callback not set', E_USER_WARNING );
		}

		if ( isset( $callback_args ) )
			$this->callback_args = (array) $callback_args;

		if ( $file && $this->schedule ) {
			soilUtil::add_activation_hook( $file, array( $this, 'reset' ) );
			register_deactivation_hook( $file, array( $this, 'unschedule' ) );
		}

		add_filter( 'cron_schedules', array( $this, '_add_timing' ) );
	}

}

