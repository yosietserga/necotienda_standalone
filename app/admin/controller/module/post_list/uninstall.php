<?php

/**
 * ControllerModulePostListUninstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModulePostListUninstall extends Controller {

    private $error = array();

    /**
     * ControllerModulePostListUninstall::index()
     * 
     * @return
     */
    public function index() {
        if (!$this->user->hasPermission('modify', 'module/post_list/uninstall')) {
            $this->session->set('error', $this->language->get('error_permission'));
            ;
            $this->redirect(Url::createAdminUrl('extension/module'));
        } else {
            $this->load->auto('setting/extension');
            $this->load->auto('setting/setting');
            $this->load->auto('style/widget');
            $this->modelExtension->uninstall('module', 'post_list');
            $this->modelSetting->delete('post_list');
            $this->modelWidget->deleteAll('post_list');
            $this->redirect(Url::createAdminUrl('extension/module'));
        }
    }

}
