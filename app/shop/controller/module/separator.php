<?php

class ControllerModuleSeparator extends Module {

    protected function index($widget = null) {
        $this->language->load('module/separator');

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'separator';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/separator.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/separator.tpl';
        } else {
            $this->template = 'cuyagua/module/separator.tpl';
        }

        $this->id = 'separator';
        $this->render();
    }
}
