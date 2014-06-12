<?php
/**
 * ControllerModuleRichTextUninstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleRichTextUninstall extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleRichTextUninstall::index()
	 * 
	 * @return
	 */
	public function index() {   
		if (!$this->user->hasPermission('modify', 'module/richtext/uninstall')) {
			$this->session->set('error',$this->language->get('error_permission')); ; 
			$this->redirect(Url::createAdminUrl('extension/module'));
		} else {
            $this->load->auto('setting/extension');
            $this->load->auto('setting/setting');
            $this->load->auto('style/widget');
			$this->modelExtension->uninstall('module', 'richtext');
			$this->modelSetting->delete('richtext');
            $this->modelWidget->deleteAll('richtext');
			$this->redirect(Url::createAdminUrl('extension/module'));	
		}
	}
}
