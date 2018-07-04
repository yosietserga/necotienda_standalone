<?php

class ControllerModuleLoginForm extends Module {

    protected function index($widget = null) {
        $this->language->load('module/login_form');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'login_form';

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        $this->data['tokenLogin'] = $this->getToken();

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/login_form.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/login_form.tpl';
        } else {
            $this->template = 'cuyagua/module/login_form.tpl';
        }

        $this->id = 'login_form';
        $this->render();
    }

    public function login() {
        $json = array();
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $json['success'] = 1;
        } else {
            $json['error'] = 1;
            $json['msg'] = $this->language->get('error_email');
            $this->session->clear('tokenLogin');
            $json['tokenLogin'] = $this->getToken(true);
        }

        $this->load->library('json');
        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
    }

    protected function getToken($reset=false) {
        if ($reset) {
            $this->session->clear('tokenLogin');
        }

        if (!$this->session->has('tokenLogin')) {
            $token = md5(rand() . time());
            $this->session->set('tokenLogin', $token);
        } else {
            $token = $this->session->get('tokenLogin');
        }

        return $token;
    }

    protected function validate() {
        $this->load->library('validar');
        $validate = new Validar;
        if (empty($this->request->post['email']) || !$validate->validEmail($this->request->post['email'])) {
            return false;
        }
        if (empty($this->request->post['password'])) {
            return false;
        }
        if ($this->request->post['token'] != $this->session->get('tokenLogin')) {
            return false;
        }
        if (!$this->customer->login($this->request->post['email'], $this->request->post['password'], false)) {
            return false;
        }
        return true;
    }
}
