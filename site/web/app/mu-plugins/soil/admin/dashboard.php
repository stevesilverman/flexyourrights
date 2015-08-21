<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


class APP_Dashboard extends scbBoxesPage {

	const NEWS_FEED = 'http://feeds2.feedburner.com/appthemes';
	const TWITTER_FEED = 'http://twitter.com/statuses/user_timeline/appthemes.rss';
	const FORUM_FEED = 'http://forums.appthemes.com/external.php?type=RSS2';

	function setup() {
		$this->args = array(
			'page_slug' => 'app-dashboard',
			'toplevel' => 'menu',
			'position' => 3,
			'screen_icon' => 'themes',
		);

		$this->boxes = array(
			array( 'news', $this->box_icon( 'framework/images/newspaper.png' ) . __( 'Latest News', SOIL_TD ), 'normal' ),
			array( 'twitter', $this->box_icon( 'framework/images/twitter-bird.png' ) . __( 'Latest Tweets', SOIL_TD ), 'side' ),
			array( 'forum', $this->box_icon( 'framework/images/comments.png' ) . __( 'Support Forum', SOIL_TD ), 'side' ),
		);
	}

	function news_box() {
		echo '<div class="rss-widget">';
		wp_widget_rss_output( self::NEWS_FEED, array( 'items' => 10, 'show_author' => 0, 'show_date' => 1, 'show_summary' => 1 ) );
		echo '</div>';
	}

	function twitter_box() {
		echo '<div class="rss-widget">';
		wp_widget_rss_output( self::TWITTER_FEED, array( 'items' => 5, 'show_author' => 0, 'show_date' => 1, 'show_summary' => 1 ) );
		echo '</div>';
	}

	function forum_box() {
		echo '<div class="rss-widget">';
		wp_widget_rss_output( self::FORUM_FEED, array( 'items' => 5, 'show_author' => 0, 'show_date' => 1, 'show_summary' => 1 ) );
		echo '</div>';
	}

	function page_init() {
		parent::page_init();

		extract( $this->args );

		// Make the first submenu read 'Dashboard', not the top-level title
		$this->pagehook = add_submenu_page( $page_slug, $page_title, __( 'Dashboard', SOIL_TD ), $capability, $page_slug, array( $this, '_page_content_hook' ) );
	}

	protected function box_icon( $path ) {
		return html( 'img', array( 'class' => 'box-icon', 'src' => get_template_directory_uri() . '/' . $path ) );
	}

	function page_head() {
		wp_enqueue_style( 'dashboard' );

?>
<style type="text/css">
.postbox {
	position: relative;
}

.postbox .hndle span {
	padding-left: 21px;
}

.box-icon {
	position: absolute;
	top: 7px;
	left: 10px;
}
</style>
<?php
	}
}

