<?php

namespace TomasVodrazka\Crud\Tables;

/**
 * Description of AngularTable
 *
 * @author tvodr_000
 */
class AngularTable extends \Nette\Application\UI\Control {

	public $columns;
	public $dataSourceLink;
	public $sortingField;
	public $showButtons = true;
	public $tableName;
	public $usePagination = false;
	public $itemsPerPage = 15;
	public $stripped = 1;
	public $rowClass = '';
	
	public $basicFilers = array();
	
	public function render() {
		$template = $this->template;
		$template->setFile(__DIR__ . '/angularTable.latte');

		$template->dataSourceLink = $this->dataSourceLink;
		$template->sortingField = $this->sortingField;
		$template->columns = $this->columns;
		$template->showButtons = $this->showButtons;
		$template->tableName = $this->tableName;
		$template->itemsPerPage = $this->itemsPerPage;
		$template->stripped = $this->stripped;
		$template->rowClass = $this->rowClass;
		$template->basicFilters = $this->basicFilers;
				
		// a vykreslíme ji
		$template->render();
	}
	
	protected function createComponentPagination() {
		
		
	}

}
