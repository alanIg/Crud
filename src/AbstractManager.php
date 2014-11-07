<?php

namespace TomasVodrazka\Crud;

class AbstractManager extends \Nette\Object {

    /** @var \Nette\Database\Context */
    protected $database;

    /**
     *
     * @var \Nette\Caching\Cache
     */
    protected $cache;

    function __construct(\Nette\Database\Context $database, \Nette\Caching\Cache $cache) {
	$this->database = $database;
	$this->cache = $cache;
    }

    public function getTableName() {
	
    }

    public function getViewName() {
	
    }

    public function getDefaultSortingField() {
	
    }

    public function cleanCache() {
	$this->cache->clean(array(
	    \Nette\Caching\Cache::TAGS => array($this->getTableName()),
	));
    }

    public function add($values) {
	$row = $this->database->table($this->getTableName())->insert($values);
	$this->cleanCache();
	return $row->id;
    }

    public function udpate($values) {
	$id = $values['id'];
	unset($values['id']);
	$this->database->table($this->getTableName())->get($id)->update($values);
	$this->cleanCache();
	return $id;
    }

    public function delete($id) {
	$this->database->table($this->getTableName())->get($id)->delete();
	$this->cleanCache();
    }

    public function getById($id) {
	return $this->database->table($this->getTableName())->get($id);
    }

    public function getByIdFromView($id) {
	return $this->database->table($this->getViewName())->where(array('id' => $id))->fetch();
    }

    /**
     * 
     * @return \Nette\Database\Table\Selection
     */
    public function getModel() {
	return $this->database->table($this->getTableName());
    }

    /**
     * 
     * @return \Nette\Database\Table\Selection
     */
    public function getViewModel() {
	return $this->database->table($this->getViewName());
    }

    /**
     * 
     * @param \Nette\Database\Table\Selection $model
     */
    public function modelToArray($model) {
	return array_map(function ($row) {
	    return $row->toArray();
	}, $model->fetchPairs('id'));
    }

    public function getModelInArray() {
	return $this->modelToArray($this->getModel());
    }

    public function getArrayForForm() {
	$cacheName = $this->getTableName() . 'ArrayForForm';
	$arr = $this->cache->load($cacheName);
	if ($arr == null) {
	    $arr = $this->constructArrayForForm();
	    $this->cacheTableContent($cacheName, $arr);
	}
	return $arr;
    }

    protected function cacheTableContent($cacheName, $value) {
	$this->cache->save($cacheName, $value, array(
	    \Nette\Caching\Cache::TAGS => array($this->getTableName())
		)
	);
    }

    protected function constructArrayForForm() {
	return array();
    }

}
