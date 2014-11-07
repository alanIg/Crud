<?php

namespace TomasVodrazka\Crud;

/**
 * Description of AbstractColumnsProvider
 *
 * @author tvodr_000
 */
abstract class AbstractColumnsProvider {

	public $columns = array();

	public function __construct($columns = array()) {
		foreach ($columns as $value) {
			$this->addColumn($value);
		}
	}

	public function addColumn($column) {
		$this->columns[] = $column;
	}

}
