<?php

/**
 * Soil Add Video JS
 *
 * @return HTML
 * @todo  Attach conditionally, if needed
 */
function soil_add_videojs_header() {
	$dir = SOIL_URI . 'extensions/videojs/video-js'; ?>

	<link rel="stylesheet" href="<?php echo $dir ?>/video-js.css" type="text/css" media="screen" title="Video JS" charset="utf-8">
	<script src="<?php echo $dir ?>/video.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8">
		VideoJS.setupAllWhenReady();
	</script>

<?php

}

add_action('wp_head', 'soil_add_videojs_header');



/**
 * Soil Video Shortcode
 *
 * @param  Array - MP4, WebM, OGG
 * @param  Source Files - mp4, webm, ogg, poster
 * @param  Settings - width, height, preload, autoplay
 * @return Video HTML
 */
function soil_video_shortcode($atts) {

	$data=array();
	$defaults = array( // Define the array of defaults
		'mp4' => '',
		'webm' => '',
		'ogg' => '',
		'poster' => '',
		'width' => '',
		'height' => '',
		'preload' => false,
		'autoplay' => false,
	);

	$data = wp_parse_args( $atts, $defaults ); // Parse incomming $atts into an array and merge it with $defaults
	extract( $data, EXTR_SKIP ); // Declare each item in $args as its own variable


	// MP4 Source Supplied
	if ($mp4) {
		$data['mp4_source'] = '<source src="'.$mp4.'" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />';
	}

	// WebM Source Supplied
	if ($webm) {
		$data['webm_source'] = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\' />';
	}

	// Ogg source supplied
	if ($ogg) {
		$data['ogg_source'] = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\' />';
	}

	if ($poster) {
		$data['poster_attribute'] = 'poster="'.$poster.'"';
		$data['flow_player_poster'] = '"'.$poster.'", ';
		$data['image_fallback'] = html( 'img', array('src'=>$poster, 'width'=>$width, 'height'=>$height, 'alt'=>'Poster Image', 'title'=>'No video playback capabilities.') );
	}

	if ($preload) {
		$data['preload_attribute'] = 'preload="auto"';
		$data['flow_player_preload'] = ',"autoBuffering":true';
	} else {
		$data['preload_attribute'] = 'preload="none"';
		$data['flow_player_preload'] = ',"autoBuffering":false';
	}

	if ($autoplay) {
		$data['autoplay_attribute'] = "autoplay";
		$data['flow_player_autoplay'] = ',"autoPlay":true';
	} else {
		$data['autoplay_attribute'] = "";
		$data['flow_player_autoplay'] = ',"autoPlay":false';
	}

	return soil_mustache_render( 'video.html', $data, 'videojs' );

}

add_shortcode('video', 'soil_video_shortcode');

?>