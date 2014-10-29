<?php

namespace TomasVodrazka\Crud\Tables\Filters;

/**
 * Description of AngularTableSelectFilter
 *
 * @author Tomáš
 */
class AngularTableSelectFilter extends AngularTableDefaultFilter{
	public $items;
	public $prompt;
	
	public $isStrict = true;
	
	function __construct($text, $items, $prompt = '---vše---') {
		$this->items = $items;
		$this->prompt = $prompt;
		parent::__construct($text);
	}

	public function getBlockName() {
			return 'selectFilter';
	}
}
