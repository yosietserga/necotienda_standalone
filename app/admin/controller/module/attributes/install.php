<?php

/**
 * ControllerModuleAttributesInstall
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleAttributesInstall extends Controller {

    private $error = array();

    /**
     * ControllerModuleAttributesInstall::index()
     * 
     * @return
     */
    public function index() {
        if (!$this->user->hasPermission('modify', 'module/attributes/install')) {
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
            $this->modelExtension->install('module', 'attributes');

            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/attributes/install');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/attributes/install');

            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/attributes/uninstall');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/attributes/uninstall');

            $this->modelUsergroup->addPermission($this->user->getId(), 'access', 'module/attributes/widget');
            $this->modelUsergroup->addPermission($this->user->getId(), 'modify', 'module/attributes/widget');
            $this->modelUsergroup->addPermission($this->user->getId(), 'delete', 'module/attributes/widget');

            $this->redirect(Url::createAdminUrl('extension/module'));
        }
    }

    /**
     * ControllerModuleAttributesInstall::validate()
     * 
     * @return
     */
    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/attributes/install')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
