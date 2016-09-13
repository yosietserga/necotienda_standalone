<?php

/**
 * ControllerModuleCrmDashboard
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleCrmDashboard extends Controller {

    private $error = array();

    /**
     * ControllerModuleCrmDashboard::index()
     * 
     * @return
     */
    public function index() {
        $this->load->language('module/crm');

        $this->document->title = $this->data['heading_title'] = $this->language->get('heading_title');

        $this->load->auto('setting/setting');

        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('extension/module'),
            'text' => $this->language->get('text_module'),
            'separator' => ' :: '
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('module/crm'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->templatePath = dirname(__FILE__);
        $this->template = '/view/plugin/dashboard.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    /**
     * ControllerModuleCrmDashboard::validate()
     * 
     * @return
     */
    private function validate() {
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function create() {}
    public function update() {}
    public function read() {}
    public function delete() {}
    
}
