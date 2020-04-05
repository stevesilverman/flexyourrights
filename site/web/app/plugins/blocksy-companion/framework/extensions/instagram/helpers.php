<?php

add_action( 'wp_ajax_blocksy_widget_instagram', 'blocksy_widget_instagram_generate_html' );
add_action( 'wp_ajax_nopriv_blocksy_widget_instagram', 'blocksy_widget_instagram_generate_html' );

function blocksy_widget_instagram_generate_html() {
	$instagram_photos = blocksy_get_instagram_photos(
		sanitize_text_field( $_GET['username'] ),
		intval( sanitize_text_field( $_GET['limit'] ) )
	);

	?>
		<?php foreach ( $instagram_photos as $photo ) { ?>
			<li
			<?php
			if ( $photo['is_video'] ) {
				echo ' class="ct-is-video"';}
			?>
			>
				<?php

				echo blocksy_simple_image(
					$photo['img'],
					[
						'tag_name' => 'a',
						'html_atts' => [
							'target' => '_blank',
							'href' => 'https://instagram.com/p/' . $photo['code'],
						],
						'img_atts' => [
							'alt' => esc_attr( $photo['description'] ),
							'title' => esc_attr( $photo['description'] ),
						],
					]
				)
				?>
			</li>
		<?php } ?>

	<?php

	wp_die();
}

function blocksy_get_instagram_photos( $username, $items = 10 ) {
	$username = trim($username);

	if (! $username) {
		return [];
	}

	$transient_name = 'blocksy_instagram_ext_' . md5(
		json_encode(
			[
				$username,
				// $items
			]
		)
	);

	$remote_images = [];

	if ( $maybe_transient_data = get_transient( $transient_name ) ) {
		$remote_images = $maybe_transient_data;
	} else {
		$source = wp_remote_get('http://instagram.com/' . $username);

		$remote_response = true;

		if ( is_wp_error( $source ) ) {
			$remote_response = null;
		}

		if ( 200 !== wp_remote_retrieve_response_code( $source ) ) {
			$remote_response = null;
		}

		if ( ! $remote_response ) {
			return [];
		}

		// Get json info about the user.
		preg_match( '|window._sharedData = {(.+?)};</script>|', $source['body'], $matches );

		if ( ! isset( $matches[1] ) ) {
			return [];
		}

		$json_data = "{{$matches[1]}}";
		$json_data = json_decode( $json_data, true );

		if ( ! $json_data ) {
			return [];
		}

		if (isset( $json_data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] )) {
			$remote_images = $json_data['entry_data'][
				'ProfilePage'
			][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
		} else {
			return $instagram_photos;
		}
	}

	if (! $remote_images) {
		return [];
	}

	$instagram_photos = [];

	foreach ( $remote_images as $image ) {
		if ( count( $instagram_photos ) >= $items ) {
			break;
		}

		$image = $image['node'];

		if ( ! isset( $image['edge_media_to_caption'] ) ) {
			$image['edge_media_to_caption'] = [
				'edges' => [
					['node' => ['text' => '']]
				]
			];
		}

		if ( empty( $iamge['edge_media_to_caption']['edges'] ) ) {
			$image['edge_media_to_caption'] = [
				'edges' => [
					[
						'node' => ['text' => '']
					]
				]
			];
		}

		$instagram_photos[] = [
			'code' => $image['shortcode'],
			'img' => $image['thumbnail_src'],
			'likes' => $image['edge_liked_by']['count'],
			'description' => $image['edge_media_to_caption']['edges'][0]['node']['text'],
			'is_video' => $image['is_video'],
		];
	}

    $cache_timeout = explode(':', get_option('blocksy_ext_instagram_interval', '1:days'));

	$number = intval($cache_timeout[0]);
	$interval = $cache_timeout[1];

	if ($interval === 'days') {
		$interval = 24 * HOUR_IN_SECONDS;
	}

	if ($interval === 'hours') {
		$interval = HOUR_IN_SECONDS;
	}

	if ($interval === 'minutes') {
		$interval = 60;
	}

	set_transient(
		$transient_name,
		$remote_images,
		$number * $interval
	);

	return $instagram_photos;
}

function blc_output_instagram_section_cache() {
	if (! is_customize_preview()) return;

	blocksy_add_customizer_preview_cache(
		blocksy_html_tag(
			'div',
			[ 'data-id' => 'blocksy-instagram-section' ],
			blc_output_instagram_section(true)
		)
	);
}

function blc_output_instagram_section($forced = false) {
	if (! $forced) {
		blc_output_instagram_section_cache();
	}

	if (get_theme_mod('insta_block_enabled', 'no') !== 'yes') {
		if (! $forced) {
			return '';
		}
	}

	$username = get_theme_mod('insta_block_username', '');

	if (empty($username)) {
		if (! $forced) {
			return '';
		}
	}

	$photos_number = intval(get_theme_mod('insta_block_count', '6'));

	if ($forced) {
		$photos_number = 18;
	}

	$widget_data = json_encode(
		[
			'limit' => $photos_number,
			'username' => get_theme_mod( 'insta_block_username', ''),
		]
	);

	$class = 'ct-instagram-block';

	$class .= ' ' . blocksy_visibility_classes(
		get_theme_mod('insta_block_visibility', [
			'desktop' => true,
			'tablet' => true,
			'mobile' => false,
		])
	);

	ob_start();

	?>

	<div class="<?php echo esc_attr($class) ?>">
		<ul
			class="ct-loading"
			data-widget='<?php echo $widget_data; ?>'>

			<?php

				echo str_repeat(
					'<li>' . blocksy_simple_image(
						'#',
						[
							'lazyload' => true,
							'tag_name' => 'a',
							'has_image' => false,
							'html_atts' => [
								'target' => '_blank',
								'href' => '#',
							],
						]
					) . '</li>',
					$photos_number
				);

			?>
		</ul>

		<a href="https://instagram.com/<?php echo esc_attr($username) ?>" target="_blank" class="ct-instagram-follow ct-button">
			@<?php echo esc_html($username) ?>
		</a>
	</div>


	<?php

	return ob_get_clean();
}

