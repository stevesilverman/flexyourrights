<?php

$options = [
	'label' => __( 'Floating Cart', 'blocksy' ),
	'type' => 'ct-panel',
	'switch' => true,
	'value' => 'yes',
	'setting' => [ 'transport' => 'postMessage' ],
	'inner-options' => [

		'floatingBarFontColor' => [
			'label' => __( 'Font Color', 'blocksy' ),
			'type'  => 'ct-color-picker',
			'design' => 'inline',
			'setting' => [ 'transport' => 'postMessage' ],
			'value' => [
				'default' => [
					'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
				],
			],

			'pickers' => [
				[
					'title' => __( 'Initial', 'blocksy' ),
					'id' => 'default',
					'inherit' => 'var(--color)'
				],
			],
		],

		'floatingBarBackground' => [
			'label' => __( 'Background Color', 'blocksy' ),
			'type'  => 'ct-color-picker',
			'design' => 'inline',
			'setting' => [ 'transport' => 'postMessage' ],
			'value' => [
				'default' => [
					'color' => '#ffffff',
				],
			],

			'pickers' => [
				[
					'title' => __( 'Initial', 'blocksy' ),
					'id' => 'default',
				],
			],
		],

		'floatingBarShadow' => [
			'label' => __( 'Shadow', 'blocksy' ),
			'type' => 'ct-box-shadow',
			'responsive' => true,
			'divider' => 'top',
			'value' => blocksy_box_shadow_value([
				'enable' => true,
				'h_offset' => 0,
				'v_offset' => 10,
				'blur' => 20,
				'spread' => 0,
				'inset' => false,
				'color' => [
					'color' => 'rgba(44,62,80,0.15)',
				],
			]),
			'setting' => [ 'transport' => 'postMessage' ],
		],

	],
];

