<?php
namespace Sleek\Modules;

class VueComponent extends Module {
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
				'name' => 'component',
				'type' => 'select',
				'choices' => $this->getVueComponents(),
				'ui' => true,
				'allow_null' => true,
				'multiple' => false
			]
		];
	}

	protected function getVueComponents () {
		$components = [];

		foreach (glob(get_stylesheet_directory() . '/src/js/*.vue') as $file) {
			$pathinfo = pathinfo($file);
			$components[$pathinfo['filename']] = \Sleek\Utils\convert_case($pathinfo['filename'], 'title');
		}

		return $components;
	}
}