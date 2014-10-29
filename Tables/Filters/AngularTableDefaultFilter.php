<?php

namespace TomasVodrazka\Crud\Tables\Filters;

/**
 * Description of AngularTableDefaultFilter
 *
 * @author Tomáš
 */
class AngularTableDefaultFilter {
	public $text;
	
	public $isStrict = false;
	
	function __construct($text) {
		$this->text = $text;
	}

	public function getBlockName(){
		return 'defaultFilter';
	}
	
}
