<?php

namespace TomasVodrazka\Crud;

/**
 * Description of AbsctractCrud
 *
 * @author tomas.vodrazka
 */
abstract class AbstractNonModalCrud extends AbstractAngularCrud {

    protected $templateName = 'nonModalCrud';
    public $renderViewRows = true;

    public function render() {
	$template = $this->template;
	$template->rowsLabel = $this->rowsLabel;
	$template->addLabel = $this->addLabel;
	$template->renderViewRows = $this->renderViewRows;
	$template->setFile(__DIR__ . '/' . $this->templateName . '.latte');
	$template->render();
    }

    protected function addEditButton($buttons) {
	$edit = $buttons->addButton(new Tables\AngularTableButton('Upravit', 'pencil'));
	$edit->setLinkPattern($this->getPresenter()->link('edit', array('id' => '_ID_')));
    }

    public function handleRows() {
	$this->templateName = 'nonModalCrud';
    }

    public function renderEdit() {
	$template = $this->template;
	$template->renderViewRows = false;
	$template->setFile(__DIR__ . '/edit.latte');
	$template->render();
    }

    public function renderAdd() {
	$template = $this->template;
	$template->renderViewRows = $this->renderViewRows;
	$template->setFile(__DIR__ . '/add.latte');
	$template->render();
    }

    public function handleEdit($itemId) {
	$this->checkEditPermissons();
	$this->tryToFindRow($itemId);
	$this->templateName = 'edit';
    }

    public function handleAdd() {
	$this->checkAddPermissons();
	$this->templateName = 'add';
    }

    protected function afterAdd($newId) {
	$this->getPresenter()->redirect('edit', array('id' => $newId));
    }

}
