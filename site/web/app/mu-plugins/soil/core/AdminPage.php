<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

// Administration page base class

abstract class soilAdminPage extends scbAdminPage {
	/** Page args
	 * $page_title string (mandatory)
	 * $parent (string)  (default: options-general.php)
	 * $capability (string)  (default: 'manage_options')
	 * $menu_title (string)  (default: $page_title)
	 * $page_slug (string)  (default: sanitized $page_title)
	 * $toplevel (string)  If not empty, will create a new top level menu (for expected values see http://codex.wordpress.org/Administration_Menus#Using_add_submenu_page)
	 * - $icon_url (string)  URL to an icon for the top level menu
	 * - $position (int)  Position of the toplevel menu (caution!)
	 * $screen_icon (string)  The icon type to use in the screen header
	 * $nonce string  (default: $page_slug)
	 * $action_link (string|bool)  Text of the action link on the Plugins page (default: 'Settings')
	 * $admin_action_priority int  The priority that the admin_menu action should be executed at (default: 10)
	 */	 
	 
	function __construct( $file, $options = null ) {
		if ( is_a( $options, 'soilOptions' ) )
			$this->options = $options;
		
		parent::__construct( $file, $options );

	}

	// Manually generate a standard admin notice ( use Settings API instead )
	function admin_msg( $msg = '', $class = "updated" ) {
		if ( empty( $msg ) )
			$msg = __( 'Settings <strong>saved</strong>.', $this->textdomain );

		echo soil_admin_notice( $msg, $class );
	}

	// Generates a form submit button
	function submit_button( $value = '', $action = 'action', $class = "button" ) {
		if ( is_array( $value ) ) {
			extract( wp_parse_args( $value, array(
				'value' => __( 'Save Changes', $this->textdomain ),
				'action' => 'action',
				'class' => 'button',
				'ajax' => true
			) ) );

			if ( ! $ajax )
				$class .= ' no-ajax';
		}
		else {
			if ( empty( $value ) )
				$value = __( 'Save Changes', $this->textdomain );
		}

		$input_args = array(
			'type' => 'submit',
			'name' => $action,
			'value' => $value,
			'extra' => '',
			'desc' => false,
			'wrap' => html( 'p class="submit"', soilForms::TOKEN )
		);

		if ( ! empty( $class ) )
			$input_args['extra'] = compact( 'class' );

		return soilForms::input( $input_args );
	}

	/*
	Mimics soilForms::form_wrap()

	$this->form_wrap( $content );	// generates a form with a default submit button

	$this->form_wrap( $content, false ); // generates a form with no submit button

	// the second argument is sent to submit_button()
	$this->form_wrap( $content, array( 'text' => 'Save changes',
		'name' => 'action',
		'ajax' => true,
	) );
	*/
	function form_wrap( $content, $submit_button = true ) {
		if ( is_array( $submit_button ) ) {
			$content .= $this->submit_button( $submit_button );
		} elseif ( true === $submit_button ) {
			$content .= $this->submit_button();
		} elseif ( false !== strpos( $submit_button, '<input' ) ) {
			$content .= $submit_button;
		} elseif ( false !== $submit_button ) {
			$button_args = array_slice( func_get_args(), 1 );
			$content .= call_user_func_array( array( $this, 'submit_button' ), $button_args );
		}

		return soilForms::form_wrap( $content, $this->nonce );
	}

	// Mimic scbForms inheritance
	function __call( $method, $args ) {
		if ( in_array( $method, array( 'input', 'form' ) ) ) {
			if ( empty( $args[1] ) && isset( $this->options ) )
				$args[1] = $this->options->get();

			if ( 'form' == $method )
				$args[2] = $this->nonce;
		}

		return call_user_func_array( array( 'soilForms', $method ), $args );
	}

}

