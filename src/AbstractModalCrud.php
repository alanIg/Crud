<?php

namespace TomasVodrazka\Crud;

/**
 * Description of AbsctractCrud
 *
 * @author tomas.vodrazka
 */
abstract class AbstractModalCrud extends \TomasVodrazka\Crud\AbstractAngularCrud {

    
    
    protected function getModalBase() {
	return __DIR__ . '/modalBase.latte';
    }
    
    protected function setupLabels($template){
	$template->rowsLabel = $this->rowsLabel;
	$template->addLabel = $this->addLabel;
	$template->renderAddButton = $this->renderAddButton;
    }

    public function render() {
	$template = $this->template;
	$this->setupLabels($template);
	$template->setFile(__DIR__ . '/crud.latte');
	$template->render();
    }

    public function handleEdit($itemId) {
	$this->checkEditPermissons();
	$this->tryToFindRow($itemId);
	$this->template->renderEdit = true;
	$this->redrawControl('rowForms');
    }

    public function handleAdd() {
	$this->checkAddPermissons();
	$this->template->renderAdd = true;
	$this->redrawControl('rowForms');
    }

    protected function afterDelete($oldItem) {
	$this->redirect('this');
    }

}
