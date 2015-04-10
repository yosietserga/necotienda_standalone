<?php

/**
 * ControllerModuleProductListInstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleProductListInstall extends Controller {

    private $error = array();

    /**
     * ControllerModuleProductListInstall::index()
     * 
     * @return
     */
    public function index() {
        if (!$this->user->hasPermission('modify', 'module/product_list/install')) {
            $this->session->set('error', $this->language->get('error_permission'));
            $this->redirect(Url::createAdminUrl('extension/module'));
        } else {
            /*
              if (file_exists('config.php')) {
              require();
              }
             */
            $this->load->auto('setting/extension');
            $this->load->auto('user/usergroup');
            $this->modelExtension->install('module', 'product_list');

            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/product_list/install');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/product_list/install');

            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/product_list/uninstall');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/product_list/uninstall');

            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/product_list/widget');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/product_list/widget');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/product_list/widget');

            $this->redirect(Url::createAdminUrl('extension/module'));
        }
    }

    /**
     * ControllerModuleProductListInstall::validate()
     * 
     * @return
     */
    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/product_list/install')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
