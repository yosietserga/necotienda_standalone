<?php

class ControllerModuleCategoryImage extends Module {

    protected function index($widget = null) {
        $this->language->load('module/category_image');
        $this->load->auto('store/category');
        $this->load->auto('image');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'category_image';

        $width = isset($settings['width']) ? $settings['width'] : $this->config->get('config_image_category_width');
        $height = isset($settings['height']) ? $settings['height'] : $this->config->get('config_image_category_height');

        if ($this->request->hasQuery('category_id') || $this->request->hasPost('category_id')) {
            $data['category_id'] = $this->request->hasPost('category_id') ? $this->request->getPost('category_id') : $this->request->getQuery('category_id');
        }

        $results = $this->modelCategory->getAll($data);

        if ($category_info = $results[0]) {

            if ($category_info['image']) {
                $image = $category_info['image'];
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

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/category_image.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/category_image.tpl';
        } else {
            $this->template = 'cuyagua/module/category_image.tpl';
        }

        $this->id = 'category_image';
        $this->render();
    }
}
