<?php

namespace TomasVodrazka\Crud;

/**
 * Description of Crud
 *
 * @author tomas.vodrazka
 */
abstract class AbstractAngularCrud extends AbstractFormCrud {

    protected $columnsProvider;
	public $renderAddButton = true;

    public function handleSendJson() {
	$this->sendJsonResponse($this->getRowsArrayWithLinks());
    }

    public function sendJsonResponse($data) {
	$this->getPresenter()->sendResponse(new JsonArrayResponse($this->formatArrayToJson($data)));
    }

    public function formatArrayToJson($data) {
	$objects = array_map(function($row) {
	    return \Nette\Utils\Json::encode($row);
	}, $data);
	return '[' . implode(',', $objects) . ']';
    }

    protected function getRowsArrayWithLinks() {
	$buttons = $this->getButtons();
	$pres = $this;
	return array_map(function ($row) use ($buttons, $pres) {
	    $data = is_array($row) ? $row : $row->toArray();
	    $pres->prepareData($data);
	    $data['_buttons'] = $buttons->getArray($data['id']);
	    return $data;
	}, $this->getModel());
    }

    protected function prepareData(&$data) {
	
    }

    protected function getButtons() {
	$buttons = new Tables\AngularTableButtonsManager();
	if ($this->canUserEdit()) {
	    $this->addEditButton($buttons);
	}
	if ($this->canUserDelete()) {
	    $this->addDeleteButton($buttons);
	}

	$this->addButtons($buttons);

	return $buttons;
    }

    /**
     * 
     * @param Tables\AngularTableButtonsManager $buttons
     */
    protected function addButtons($buttons) {
	
    }

    protected function addEditButton($buttons) {
	$edit = $buttons->addButton(new Tables\AngularTableButton('Upravit', 'pencil', 'ajax'));
	$edit->setLinkPattern($this->link('edit!', array('itemId' => '_ID_')));
    }



    protected function addDeleteButton($buttons) {
	$buttons->addButton(new Tables\AngularTableButton('Smazat', 'trash-o', 'delete-confirm', 'btn-danger'))
		->setLinkPattern($this->link('delete!', array('itemId' => '_ID_')));
    }

    public function createComponentRows() {
	$table = new Tables\AngularTable();
	$table->dataSourceLink = $this->link('sendJson!');
	$table->columns = $this->columnsProvider->columns;
	$table->tableName = $this->manager->getTableName();
	$this->setupRowsTable($table);

	return $table;
    }

    /**
     * 
     * @param Model\AngularTable $table
     */
    protected function setupRowsTable($table) {
	$table->sortingField = $this->manager->getDefaultSortingField();
    }

}
