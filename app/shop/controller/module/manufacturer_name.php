<?php

class ControllerModuleManufacturerName extends Module {

    protected function index($widget = null) {
        $this->language->load('module/manufacturer_name');
        $this->load->auto('store/manufacturer');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'manufacturer_name';

        if ($this->request->hasQuery('manufacturer_id') || $this->request->hasPost('manufacturer_id')) {
            $data['manufacturer_id'] = $this->request->hasPost('manufacturer_id') ? $this->request->getPost('manufacturer_id') : $this->request->getQuery('manufacturer_id');
        }

        $results = $this->modelManufacturer->getAll($data);

        if ($manufacturer_info = $results[0]) {
            $this->data['name'] = $manufacturer_info['mname'];
            $this->data['heading_title'] = isset($manufacturer_info['mname']) ? $manufacturer_info['mname'] :
                isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');
        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/manufacturer_name.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/manufacturer_name.tpl';
        } else {
            $this->template = 'cuyagua/module/manufacturer_name.tpl';
        }

        $this->id = 'manufacturer_name';
        $this->render();
    }
}
