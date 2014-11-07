<?php

namespace TomasVodrazka\Crud;

use Nette\Application\UI\Form;

abstract class AbstractFormFactory {

	/**
	 * 
	 * @param \Nette\Database\Table\IRow $row
	 * @return \Nette\Application\UI\Form
	 */
	public function createEditForm($row) {
		$form = new Form();
		$this->setupFormFields($form);
		$this->setupDefaults($form, $row);
		$form->addHidden('id', $row['id']);
		self::setupFormRenderingBootstrap($form);
		return $form;
	}

	public function createAddForm() {
		$form = new Form();
		$this->setupFormFields($form);
		self::setupFormRenderingBootstrap($form);
		return $form;
	}

	/**
	 * 
	 * @param \Nette\Application\UI\Form $form
	 */
	protected function setupFormFields($form) {
		
	}

	protected function getFieldName($label) {
		return preg_replace("@-@", "_", \Nette\Utils\Strings::webalize($label));
	}

	protected function addTextField($form, $label, $required = false, $name = null) {
		if ($name == null) {
			$name = $this->getFieldName($label);
		}
		$field = $form->addText($name, $label);
		if ($required) {
			$field->setRequired();
		}
		return $field;
	}

	protected function addEditorField($form, $label, $name = null) {
		if ($name == null) {
			$name = $this->getFieldName($label);
		}
		$form->addTextArea($name, $label)
				->getControlPrototype()->class('editor');
	}

	/**
	 * 
	 * @param Form $form
	 */
	public static function setupFormRenderingBootstrap($form) {
// setup form rendering
		$renderer = $form->getRenderer();
		$renderer->wrappers['controls']['container'] = NULL;
		$renderer->wrappers['pair']['container'] = 'div class=form-group';
		$renderer->wrappers['pair']['.error'] = 'has-error';
		$renderer->wrappers['control']['container'] = NULL;
		$renderer->wrappers['label']['container'] = NULL;
		$renderer->wrappers['control']['description'] = 'p class=help-block';
		$renderer->wrappers['control']['errorcontainer'] = 'p class=help-block';

		$renderer->wrappers['label']['requiredsuffix'] = "*";
		// make form and controls compatible with Twitter Bootstrap
//		$form->getElementPrototype()->class('form-horizontal');
		foreach ($form->getControls() as $control) {

			if ($control instanceof \Nette\Forms\Controls\Button) {
				$control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
				$usedPrimary = TRUE;
			} elseif ($control instanceof \Nette\Forms\Controls\TextBase || $control instanceof \Nette\Forms\Controls\SelectBox || $control instanceof \Nette\Forms\Controls\MultiSelectBox) {
				$control->getControlPrototype()->addClass('form-control');
			} elseif ($control instanceof \Nette\Forms\Controls\Checkbox || $control instanceof \Nette\Forms\Controls\CheckboxList || $control instanceof \Nette\Forms\Controls\RadioList) {
				$control->getSeparatorPrototype()->setName('div')->addClass($control->getControlPrototype()->type);
			}
//			\Tracy\Debugger::dump($control);
		}
	}

	/**
	 * 
	 * @param Form $form
	 * @param \Nette\Database\Table\IRow $row
	 */
	protected function setupDefaults($form, $row, $omit = array()) {
		foreach ($form->getControls() as $value) {
			if (!in_array($value->getName(), $omit)) {
				if (isset($row[$value->getName()])) {
					$value->setDefaultValue($row[$value->getName()]);
				}
			}
		}
	}

}
