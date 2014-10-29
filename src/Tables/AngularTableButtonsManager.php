<?php

namespace TomasVodrazka\Crud\Tables;

/**
 * Description of AngularTableButtonsManager
 *
 * @author tvodr_000
 */
class AngularTableButtonsManager {

	/**
	 *
	 * @var AngularTableButton[]
	 */
	private $buttons = array();

	/**
	 * 
	 * @param type $button
	 * @return AngularTableButton
	 */
	public function addButton($button) {
		$this->buttons[] = $button;
		return $button;
	}
	
	public function getArray($id){
		$buttons = array();
		foreach ($this->buttons as $button) {
			$buttons[] = $button->getArray($id);
		}
		return $buttons;
	}

}
