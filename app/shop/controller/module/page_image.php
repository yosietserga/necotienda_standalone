<?php

class ControllerModulePageImage extends Module {

    protected function index($widget = null) {
        $this->language->load('module/page_image');
        $this->load->auto('content/page');
        $this->load->auto('image');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'page_image';

        $width = isset($settings['width']) ? $settings['width'] : $this->config->get('config_image_category_width');
        $height = isset($settings['height']) ? $settings['height'] : $this->config->get('config_image_category_height');

        if ($this->request->hasQuery('page_id') || $this->request->hasPost('page_id')) {
            $data['page_id'] = $this->request->hasPost('page_id') ? $this->request->getPost('page_id') : $this->request->getQuery('page_id');
        }

        $results = $this->modelPage->getAll($data);

        if ($page_info = $results[0]) {

            if ($page_info['image']) {
                $image = $page_info['image'];
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

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/page_image.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/page_image.tpl';
        } else {
            $this->template = 'cuyagua/module/page_image.tpl';
        }

        $this->id = 'page_image';
        $this->render();
    }
}
