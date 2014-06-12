<?php
/**
 * ControllerModuleLayerSliderInstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleLayerSliderInstall extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleLayerSliderInstall::index()
	 * 
	 * @return
	 */
	public function index() {
		if (!$this->user->hasPermission('modify', 'module/layer_slider/install')) {
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
			$this->load->auto('module/layer_slider');
			$this->modelExtension->install('module', 'layer_slider');
			$this->modelLayer_slider->install();
		
			$this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/layer_slider/install');
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/layer_slider/install');
            
			$this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/layer_slider/uninstall');
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/layer_slider/uninstall');

			$this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/layer_slider/widget');
			$this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/layer_slider/widget');
			$this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/layer_slider/widget');
            
			$this->redirect(Url::createAdminUrl('extension/module'));
		}
	}
	
	/**
	 * ControllerModuleLayerSliderInstall::validate()
	 * 
	 * @return
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/layer_slider/install')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
