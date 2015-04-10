<?php

/**
 * ControllerModuleCrmInstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */

if (file_exists('config.php')) {
    include_once('config.php');
}
class ControllerModuleCrmInstall extends Controller {

    private $error = array();

    /**
     * ControllerModuleCrmInstall::index()
     * 
     * @return
     */
    public function index() {
        if (!$this->user->hasPermission('modify', 'module/crm/install')) {
            $this->session->set('error', $this->language->get('error_permission'));
            $this->redirect(Url::createAdminUrl('extension/module'));
        } else {
            $this->load->auto('setting/extension');
            $this->load->auto('user/usergroup');
            $this->modelExtension->install('module', 'crm');

            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/crm/install');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/crm/install');
            
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/crm/uninstall');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/crm/uninstall');
            /*
              $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/crm/widget');
              $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/crm/widget');
              $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/crm/widget');
              $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/crm/widget');
             */
            $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/crm/plugin');
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/crm/plugin');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/crm/plugin');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/crm/plugin');

            $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/crm/opportunity');
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/crm/opportunity');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/crm/opportunity');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/crm/opportunity');

            $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/crm/step/otracosa');
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/crm/step');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/crm/step');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/crm/step');

            $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/crm/status');
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/crm/status');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/crm/status');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/crm/status');

            //TODO: add menu links to the admin menu
            /*
             * $this->modelSetting->set('admin-menu', 'parent-crm', 'CRM Ventas');
             */

            $this->redirect(Url::createAdminUrl('extension/module'));
        }
    }

    /**
     * ControllerModuleCrmInstall::validate()
     * 
     * @return
     */
    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/crm/install')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
