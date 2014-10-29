<?php

namespace TomasVodrazka\Crud;

/**
 * Description of AbsctractCrud
 *
 * @author tomas.vodrazka
 */
abstract class AbstractFormCrud extends AbstractPermissionCheckCrud {

    /**
     *
     * @var Model\AbstractManager 
     */
    protected $manager;
    protected $formFactory;
    protected $editRow;
    public $rowsLabel = 'Přehled';
    public $addLabel = 'Nový';
    public $addButtonLabel = 'Vložit';
    public $editButtonLabel = 'Upravit';
    public $addMessage = 'Vloženo';
    public $editMessage = 'Upraveno';

    public function tryToFindRow($id) {
	$this->editRow = $this->manager->getById($id);
	if ($this->editRow == null) {
	    $this->flashMessage('Položka nebyla nalezena', 'alert-danger');
	    $this->redirectToDefault();
	}
    }

    protected function getModel() {
	return $this->manager->getViewModel()->fetchPairs('id');
    }

    public function handleDelete($itemId) {
	$this->checkDeletePermissons();
	$this->tryToFindRow($itemId);
	$this->manager->delete($itemId);
	$this->flashMessage('Smazáno', 'alert-success');
	$this->afterDelete($this->editRow);
    }

    protected function afterDelete($oldItem) {
	$this->redirectToDefault();
    }

    /**
     * 
     * @return \Nette\Application\UI\Form
     */
    protected function createEditForm() {
	return $this->formFactory->createEditForm($this->editRow);
    }

    protected function createComponentEditForm() {
	$this->checkEditPermissons();
	$form = $this->createEditForm();
	$form->addSubmit('edit', $this->editButtonLabel)->onClick[] = array($this, 'editFormSubmitted');
	\App\Model\AbstractFormFactory::setupFormRenderingBootstrap($form);
	$this->template->renderEdit = true;
	return $form;
    }

    public function editFormSubmitted(\Nette\Forms\Controls\Button $button) {
	$values = $this->formFactory->prepareValues($button->getForm()->getValues());
	$itemId = $this->manager->udpate($values);
	if ($this->editMessage != null) {
	    $this->flashMessage($this->editMessage, 'alert-success');
	}
	$this->afterEdit($itemId);
    }

    protected function afterEdit($itemId) {
	$this->redirect('this');
    }

    /**
     * 
     * @return \Nette\Application\UI\Form
     */
    protected function createAddForm() {
	return $this->formFactory->createAddForm();
    }

    protected function createComponentAddForm() {
	$this->checkAddPermissons();
	$form = $this->createAddForm();
	$form->addSubmit('add', $this->addButtonLabel)->onClick[] = array($this, 'addFormSubmitted');
	\App\Model\AbstractFormFactory::setupFormRenderingBootstrap($form);
	$this->template->renderAdd = true;
	return $form;
    }

    public function addFormSubmitted(\Nette\Forms\Controls\Button $button) {
	$values = $this->formFactory->prepareValues($button->getForm()->getValues());
	$newId = $this->manager->add($values);
	if ($this->addMessage != null) {
	    $this->flashMessage($this->addMessage, 'alert-success');
	}
	$this->afterAdd($newId);
    }

    protected function afterAdd($newId) {
	$this->redirect('this');
    }

    function getEditRow() {
	return $this->editRow;
    }

    function setEditRow($editRow) {
	$this->editRow = $editRow;
    }

}
