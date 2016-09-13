<?php

/**
 * ControllerModuleMercadoLibreInstall
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
class ControllerModuleMercadoLibreInstall extends Controller {

    private $error = array();

    /**
     * ControllerModuleMercadoLibreInstall::index()
     * 
     * @return
     */
    public function index() {
        if (!$this->user->hasPermission('modify', 'module/mercadolibre/install')) {
            $this->session->set('error', $this->language->get('error_permission'));
            $this->redirect(Url::createAdminUrl('extension/module'));
        } else {
            $this->load->auto('setting/extension');
            $this->load->auto('user/usergroup');
            $this->modelExtension->install('module', 'mercadolibre');
            $this->load->moduleModel('mercadolibre', dirname(__FILE__));

            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/mercadolibre/install');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/mercadolibre/install');
            
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/mercadolibre/uninstall');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/mercadolibre/uninstall');
            /*
              $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/mercadolibre/widget');
              $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/mercadolibre/widget');
              $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/mercadolibre/widget');
              $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/mercadolibre/widget');
             */
            $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/mercadolibre/plugin');
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/mercadolibre/plugin');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/mercadolibre/plugin');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/mercadolibre/plugin');

            $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/mercadolibre/opportunity');
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/mercadolibre/opportunity');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/mercadolibre/opportunity');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/mercadolibre/opportunity');

            $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/mercadolibre/step/otracosa');
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/mercadolibre/step');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/mercadolibre/step');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/mercadolibre/step');

            $this->modelUsergroup->addPermission($this->user->getId(), 'create', 'module/mercadolibre/status');
            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/mercadolibre/status');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/mercadolibre/status');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/mercadolibre/status');

            //TODO: add menu links to the admin menu
            /*
             * $this->modelSetting->set('admin-menu', 'parent-mercadolibre', 'CRM Ventas');
             */
            
            $this->db->

            $this->redirect(Url::createAdminUrl('extension/module'));
        }
    }

    /**
     * ControllerModuleMercadoLibreInstall::validate()
     * 
     * @return
     */
    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/mercadolibre/install')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
