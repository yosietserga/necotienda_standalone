<?php

class ControllerModulePlainText extends Module {

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        

        $this->id = 'plaintext';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/plaintext.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/plaintext.tpl';
        } else {
            $this->template = 'cuyagua/module/plaintext.tpl';
        }

        $this->render();
    }
}
