<?php

/**
 * Instagram Widget
 *
 * @copyright 2017-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

// Widget title
$title = blocksy_akg( 'title', $atts, '' );

if ( empty( $title ) ) {
	$title = 'Instagram';
}

$images_per_row = blocksy_akg( 'instagram_images_per_row', $atts, '2' );

echo $before_widget . $before_title . $title . $after_title;

$photos_number = intval( blocksy_default_akg( 'photos_number', $atts, '6' ) );

$widget_data = json_encode(
	[
		'limit' => $photos_number,
		'username' => blocksy_default_akg( 'username', $atts, 'unknown' ),
	]
);

?>

<ul
	class="ct-loading"
	data-widget='<?php echo $widget_data; ?>'
	data-columns="<?php echo $images_per_row; ?>">

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


<?php echo $after_widget; ?>

