<?php

class ControllerModuleRegisterForm extends Module {

    protected function index($widget = null) {
        $this->language->load('module/register_form');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'register_form';

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/register_form.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/register_form.tpl';
        } else {
            $this->template = 'cuyagua/module/register_form.tpl';
        }

        $this->id = 'register_form';
        $this->render();
    }
}
