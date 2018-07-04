<?php

class ControllerModuleForms extends Module {

    protected function index($widget = null) {
        $this->language->load('module/forms');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'forms';

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/forms.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/forms.tpl';
        } else {
            $this->template = 'cuyagua/module/forms.tpl';
        }

        $this->id = 'forms';
        $this->render();
    }
}
