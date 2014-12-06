<?php
/**
 * ControllerModulePluginTemplateUninstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModulePluginTemplateUninstall extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModulePluginTemplateUninstall::index()
	 * 
	 * @return
	 */
	public function index() {   
		if (!$this->user->hasPermission('modify', 'module/plugin_template/uninstall')) {
			$this->session->set('error',$this->language->get('error_permission')); ; 
			$this->redirect(Url::createAdminUrl('extension/module'));
		} else {
            $this->load->auto('setting/extension');
            $this->load->auto('setting/setting');
            $this->load->auto('style/widget');
			$this->modelExtension->uninstall('module', 'plugin_template');
			$this->modelSetting->delete('plugin_template');
            $this->modelWidget->deleteAll('plugin_template');
			$this->redirect(Url::createAdminUrl('extension/module'));	
		}
	}
}
