<?php

/**
 * ControllerModuleProductListUninstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleProductListUninstall extends Controller {

    private $error = array();

    /**
     * ControllerModuleProductListUninstall::index()
     * 
     * @return
     */
    public function index() {
        if (!$this->user->hasPermission('modify', 'module/product_list/uninstall')) {
            $this->session->set('error', $this->language->get('error_permission'));
            ;
            $this->redirect(Url::createAdminUrl('extension/module'));
        } else {
            $this->load->auto('setting/extension');
            $this->load->auto('setting/setting');
            $this->load->auto('style/widget');
            $this->modelExtension->uninstall('module', 'product_list');
            $this->modelSetting->delete('product_list');
            $this->modelWidget->deleteAll('product_list');
            $this->redirect(Url::createAdminUrl('extension/module'));
        }
    }

}
