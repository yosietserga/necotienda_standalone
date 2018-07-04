<?php

class ControllerModuleStorePhone extends Module {

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (isset($settings['title'])) $this->data['heading_title'] = $settings['title'];

        $this->data['telephone'] = $this->config->get('config_telephone');

        

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/store_phone.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/store_phone.tpl';
        } else {
            $this->template = 'cuyagua/module/store_phone.tpl';
        }
        $this->render();
    }
}
