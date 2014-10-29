<?php

namespace TomasVodrazka\Crud;

/**
 * Description of AbsctractCrud
 *
 * @author tomas.vodrazka
 */
abstract class AbstractPermissionCheckCrud extends \Nette\Application\UI\Control {

    protected function redirectToDefault() {
	$this->getPresenter()->redirect('default');
    }

    protected function canUserEdit() {
	return $this->getPresenter()->getUser()->isAllowed($this->getResourceName(), 'edit');
    }

    protected function checkEditPermissons() {
	if (!$this->canUserEdit()) {
	    $this->flashMessage('Na editaci položky nemáte oprávnění', 'alert-danger');
	    $this->redirectToDefault();
	}
    }

    protected function canUserDelete() {
	return $this->getPresenter()->getUser()->isAllowed($this->getResourceName(), 'delete');
    }

    protected function checkDeletePermissons() {
	if (!$this->canUserDelete()) {
	    $this->flashMessage('Na smazání položky nemáte oprávnění', 'alert-danger');
	    $this->redirectToDefault();
	}
    }

    protected function canUserAdd() {
	return $this->getPresenter()->getUser()->isAllowed($this->getResourceName(), 'add');
    }

    protected function checkAddPermissons() {
	if (!$this->canUserAdd()) {
	    $this->flashMessage('Na přidání položky nemáte oprávnění', 'alert-danger');
	    $this->redirectToDefault();
	}
    }

    protected function getResourceName() {
	
    }

}
