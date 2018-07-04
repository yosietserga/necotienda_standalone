<?php

class ControllerModuleStoreLogo extends Module {

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
            $this->data['logo'] = HTTP_IMAGE . $this->config->get('config_logo');
        } else {
            $this->data['logo'] = '';
        }

        

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/store_logo.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/store_logo.tpl';
        } else {
            $this->template = 'cuyagua/module/store_logo.tpl';
        }
        $this->render();
    }
}
