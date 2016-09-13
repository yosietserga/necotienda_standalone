<?php
/**
 * ControllerModuleAttributesUninstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleAttributesUninstall extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleAttributesUninstall::index()
	 * 
	 * @return
	 */
	public function index() {   
		if (!$this->user->hasPermission('modify', 'module/attributes/uninstall')) {
			$this->session->set('error',$this->language->get('error_permission')); ; 
			$this->redirect(Url::createAdminUrl('extension/module'));
		} else {
            $this->load->auto('setting/extension');
            $this->load->auto('setting/setting');
            $this->load->auto('style/widget');
			$this->modelExtension->uninstall('module', 'attributes');
			$this->modelSetting->delete('attributes');
            $this->modelWidget->deleteAll('attributes');
			$this->redirect(Url::createAdminUrl('extension/module'));	
		}
	}
}
