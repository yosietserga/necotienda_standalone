<?php

class ControllerModulePluginTemplate extends Module {

    protected function index($widget = null) {
        $this->language->load('module/plugin_template');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'plugin_template';

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/plugin_template.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/plugin_template.tpl';
        } else {
            $this->template = 'cuyagua/module/plugin_template.tpl';
        }

        $this->id = 'plugin_template';
        $this->render();
    }
}
