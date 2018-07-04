<?php

class ControllerModuleStoreDescription extends Module {

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        $this->data['welcome'] = html_entity_decode($this->config->get('config_description_' . $this->config->get('config_language_id')), ENT_QUOTES, 'UTF-8');

        

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/store_description.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/store_description.tpl';
        } else {
            $this->template = 'cuyagua/module/store_description.tpl';
        }
        $this->render();
    }
}
