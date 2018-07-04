<?php

class ControllerModuleManufacturerList extends Module {

    protected function index($widget = null) {
        $this->language->load('module/manufacturer_list');
        $this->load->auto('store/manufacturer');
        $this->load->auto('image');
        $Url = new Url($this->registry);

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'manufacturer_list';

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        if ($this->request->hasQuery('manufacturer_id') || $this->request->hasPost('manufacturer_id')) {
            $data['manufacturer_id'] = $this->request->hasPost('manufacturer_id') ? $this->request->getPost('manufacturer_id') : $this->request->getQuery('manufacturer_id');
        } else {
            $data['manufacturer_id'] = (!empty($settings['categories'])) ? $settings['categories'] : null;
        }

        $this->data['thumb_width'] = isset($settings['width']) ? $settings['width'] : $this->config->get('config_image_category_width');
        $this->data['thumb_height'] = isset($settings['height']) ? $settings['height'] : $this->config->get('config_image_category_height');

        $this->data['manufacturers'] = $this->modelManufacturer->getAll($data);

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/manufacturer_list.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/manufacturer_list.tpl';
        } else {
            $this->template = 'cuyagua/module/manufacturer_list.tpl';
        }

        $this->id = 'manufacturer_list';
        $this->render();
    }
}
