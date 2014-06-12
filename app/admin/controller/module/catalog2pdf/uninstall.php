<?php
/**
 * ControllerModuleCatalog2pdfUninstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleCatalog2pdfUninstall extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleCatalog2pdfUninstall::index()
	 * 
	 * @return
	 */
	public function index() {   
		if (!$this->user->hasPermission('modify', 'module/catalog2pdf/uninstall')) {
			$this->session->set('error',$this->language->get('error_permission')); ; 
			$this->redirect(Url::createAdminUrl('extension/module'));
		} else {
            $this->load->auto('setting/extension');
            $this->load->auto('setting/setting');
            $this->load->auto('style/widget');
			$this->modelExtension->uninstall('module', 'catalog2pdf');
			$this->modelSetting->delete('catalog2pdf');
            $this->modelWidget->deleteAll('catalog2pdf');
			$this->redirect(Url::createAdminUrl('extension/module'));	
		}
	}
}
