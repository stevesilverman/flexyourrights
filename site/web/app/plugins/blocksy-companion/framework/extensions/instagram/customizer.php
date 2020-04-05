<?php

$options = [
	'title' => __('Instagram', 'blc'),
	'container' => [ 'priority' => 8 ],
	'options' => [

		'instagram_section_options' => [
			'type' => 'ct-options',
			'setting' => [ 'transport' => 'postMessage' ],
			'inner-options' => [
				'insta_block_enabled' => [
					'label' => __( 'Instagram section', 'blc' ),
					'type' => 'ct-switch',
					'value' => 'no',
					'setting' => [ 'transport' => 'postMessage' ],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [ 'insta_block_enabled' => 'yes' ],
					'options' => [

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
							'attr' => [ 'data-type' => 'small' ],
						],

						'insta_block_username' => [
							'label' => __( 'Username', 'blc' ),
							'type' => 'text',
							'design' => 'inline',
							'value' => '',
							'setting' => [ 'transport' => 'postMessage' ],
						],

						'insta_block_count' => [
							'type' => 'ct-number',
							'label' => __( 'Images Count', 'blc' ),
							'min' => 1,
							'max' => 18,
							'value' => 6,
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
							'attr' => [ 'data-type' => 'small' ],
						],

						'insta_block_visibility' => [
							'label' => __( 'Visibility', 'blc' ),
							'type' => 'ct-visibility',
							'design' => 'block',
							'setting' => [ 'transport' => 'postMessage' ],
							'value' => [
								'desktop' => true,
								'tablet' => true,
								'mobile' => false,
							],

							'choices' => blocksy_ordered_keys([
								'desktop' => __( 'Desktop', 'blc' ),
								'tablet' => __( 'Tablet', 'blc' ),
								'mobile' => __( 'Mobile', 'blc' ),
							]),
						],

					],
				],
			],
		],
	],
];

