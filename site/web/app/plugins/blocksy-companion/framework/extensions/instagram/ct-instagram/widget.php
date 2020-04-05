<?php

class Blocksy_Widget_Ct_Instagram extends BlocksyWidgetFactory {
	protected function get_config() {
		return [
			'name' => 'Instagram',
			'description' => 'Popular/Recent/Most Commented Posts.',
			'customize_selective_refresh' => true
		];
	}

	public function get_path() {
		return dirname(__FILE__);
	}
}



