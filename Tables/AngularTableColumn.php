<?php



namespace TomasVodrazka\Crud\Tables;

/**
 * Description of AngularTableColumn
 *
 * @author tvodr_000
 */
class AngularTableColumn {
	
	public $field;
	public $title;
	public $type;
	public $default;
	public $noSort;
	
	function __construct($field, $title, $type = 'text', $default = true, $noSort = false) {
		$this->field = $field;
		$this->title = $title;
		$this->type = $type;
		$this->default = $default;
		$this->noSort = $noSort;
	}

	
}
