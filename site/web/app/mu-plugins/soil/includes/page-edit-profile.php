<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


class SoilUserProfileTemplate extends SoilAppPageTemplate {

	function __construct() {
		parent::__construct( 'edit-profile.php', __( 'Edit Profile', SOIL_TD ) );
	}

	// Prevent non-logged-in users from accessing the edit-profile.php page
	function template_redirect() {
		appthemes_auth_redirect_login();
	}
}

function soil_get_edit_profile_url() {
	if ( $page_id = SoilAppPageTemplate::get_id( 'edit-profile.php' ) )
		return get_permalink( $page_id );

	return get_edit_profile_url( get_current_user_id() );
}

new SoilUserProfileTemplate;