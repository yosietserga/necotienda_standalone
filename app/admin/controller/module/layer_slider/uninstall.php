<?php
/**
 * ControllerModuleLayerSliderUninstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleLayerSliderUninstall extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleLayerSliderUninstall::index()
	 * 
	 * @return
	 */
	public function index() {   
		if (!$this->user->hasPermission('modify', 'module/layer_slider/uninstall')) {
			$this->session->set('error',$this->language->get('error_permission')); ; 
			$this->redirect(Url::createAdminUrl('extension/module'));
		} else {
            $this->load->auto('setting/extension');
            $this->load->auto('setting/setting');
            $this->load->auto('style/widget');
			$this->modelExtension->uninstall('module', 'layer_slider');
			$this->modelSetting->delete('layer_slider');
            $this->modelWidget->deleteAll('layer_slider');
			$this->redirect(Url::createAdminUrl('extension/module'));	
		}
	}
}
