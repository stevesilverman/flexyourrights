<?php

$options = [
	'title' => [
		'type' => 'text',
		'value' => 'Instagram',
		'design' => 'inline',
	],

	'username' => [
		'type' => 'text',
		'value' => '',
		'design' => 'inline',
	],

	'photos_number' => [
		'type' => 'ct-number',
		'label' => __( 'Number of Images', 'blc' ),
		'min' => 1,
		'max' => 12,
		'value' => 6,
		'design' => 'inline',
	],

	'instagram_images_per_row' => [
		'type' => 'ct-number',
		'label' => __( 'Images per Row', 'blc' ),
		'min' => 1,
		'max' => 5,
		'value' => 3,
		'design' => 'inline',
	],
];
