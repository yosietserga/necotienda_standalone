<?php

class ControllerModuleManufacturerImage extends Module {

    protected function index($widget = null) {
        $this->language->load('module/manufacturer_image');
        $this->load->auto('store/manufacturer');
        $this->load->auto('image');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'manufacturer_image';

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        $width = isset($settings['width']) ? $settings['width'] : $this->config->get('config_image_category_width');
        $height = isset($settings['height']) ? $settings['height'] : $this->config->get('config_image_category_height');

        if ($this->request->hasQuery('manufacturer_id') || $this->request->hasPost('manufacturer_id')) {
            $data['manufacturer_id'] = $this->request->hasPost('manufacturer_id') ? $this->request->getPost('manufacturer_id') : $this->request->getQuery('manufacturer_id');
        }

        $results = $this->modelManufacturer->getAll($data);

        if ($manufacturer_info = $results[0]) {
            if ($manufacturer_info['image']) {
                $image = $manufacturer_info['image'];
            } else {
                $image = 'no_image.jpg';
            }

            $this->data['thumb'] = NTImage::resizeAndSave($image, $width, $height);
            $this->data['image'] = $image;
        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/manufacturer_image.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/manufacturer_image.tpl';
        } else {
            $this->template = 'cuyagua/module/manufacturer_image.tpl';
        }

        $this->id = 'manufacturer_image';
        $this->render();
    }
}
