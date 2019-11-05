<?php
namespace Sleek\Modules;

class Instagram extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek'),
				'type' => 'wysiwyg'
			],
			[
				'name' => 'username',
				'label' => __('Instagram Username', 'sleek'),
				'instructions' => __('Enter the Instagram username here. Please note that this module requires the WP Instagram Widget plug-in: https://github.com/scottsweb/wp-instagram-widget', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'limit',
				'label' => __('Number of Images', 'sleek'),
				'type' => 'number',
				'default_value' => 4
			]
		];
	}
}
