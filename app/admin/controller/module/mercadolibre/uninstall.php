<?php

/**
 * ControllerModuleMercadoLibreUninstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleMercadoLibreUninstall extends Controller {

    private $error = array();

    /**
     * ControllerModuleMercadoLibreUninstall::index()
     * 
     * @return
     */
    public function index() {
        if (!$this->user->hasPermission('modify', 'module/mercadolibre/uninstall')) {
            $this->session->set('error', $this->language->get('error_permission'));
            
            $this->redirect(Url::createAdminUrl('extension/module'));
        } else {
            $this->load->auto('setting/extension');
            $this->load->auto('setting/setting');
            $this->load->auto('style/widget');
            
            //TODO: delete all tables from db
            
            $this->modelExtension->uninstall('module', 'mercadolibre');
            $this->modelSetting->delete('mercadolibre');
            $this->modelWidget->deleteAll('mercadolibre');
            
            $this->redirect(Url::createAdminUrl('extension/module'));
        }
    }

}
