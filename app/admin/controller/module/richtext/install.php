<?php
/**
 * ControllerModuleRichTextInstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleRichTextInstall extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleRichTextInstall::index()
	 * 
	 * @return
	 */
	public function index() {
		if (!$this->user->hasPermission('modify', 'module/richtext/install')) {
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
			$this->modelExtension->install('module', 'richtext');
		
			$this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/richtext/install');
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/richtext/install');
            
			$this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/richtext/uninstall');
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/richtext/uninstall');

			$this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/richtext/widget');
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/richtext/widget');
			$this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/richtext/widget');

			$this->redirect(Url::createAdminUrl('extension/module'));
		}
	}
	
	/**
	 * ControllerModuleRichTextInstall::validate()
	 * 
	 * @return
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/richtext/install')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
