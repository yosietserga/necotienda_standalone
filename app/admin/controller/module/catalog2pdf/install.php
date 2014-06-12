<?php
/**
 * ControllerModuleCatalog2pdfInstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleCatalog2pdfInstall extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleCatalog2pdfInstall::index()
	 * 
	 * @return
	 */
	public function index() {
		if (!$this->user->hasPermission('modify', 'module/catalog2pdf/install')) {
			$this->session->set('error',$this->language->get('error_permission'));
			$this->redirect(Url::createAdminUrl('extension/module'));
		} else {
		  /*
            if (file_exists('config.php')) {
                require();
            }
          */
            $this->load->auto('setting/extension');
			$this->load->auto('user/usergroup');
			$this->modelExtension->install('module', 'catalog2pdf');
		
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/catalog2pdf/install');
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/catalog2pdf/uninstall');

			$this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/catalog2pdf/widget');
			$this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/catalog2pdf/widget');
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/catalog2pdf/widget');
			$this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/catalog2pdf/widget');

			$this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/catalog2pdf/plugin');
			$this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/catalog2pdf/plugin');
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/catalog2pdf/plugin');
			$this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/catalog2pdf/plugin');

			$this->redirect(Url::createAdminUrl('extension/module'));
		}
	}
	
	/**
	 * ControllerModuleCatalog2pdfInstall::validate()
	 * 
	 * @return
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/catalog2pdf/install')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
