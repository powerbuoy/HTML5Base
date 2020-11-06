<?php
# Description: Create a page anchor that authors can link to using `<a href="#page-anchor-anchor-name"></a>`.

namespace Sleek\Modules;

class PageAnchor extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek'),
				'type' => 'text'
			]
		];
	}

	public function data () {
		return [
			'anchor_id' => 'page-anchor-' . \Sleek\Utils\convert_case($this->get_field('title'), 'html')
		];
	}

	public static function get_anchors ($where, $id) {
		$modules = get_field($where, $id);
		$anchors = [];

		if ($modules) {
			foreach ($modules as $module) {
				if ($module['acf_fc_layout'] === 'page_anchor') {
					$anchors[] = [
						'title' => $module['title'],
						'id' => 'page-anchor-' . \Sleek\Utils\convert_case($module['title'], 'html')
					];
				}
			}
		}

		return count($anchors) ? $anchors : null;
	}
}
