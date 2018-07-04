<?php

class ControllerModulePostImage extends Module {

    protected function index($widget = null) {
        $this->language->load('module/post_image');
        $this->load->auto('content/post');
        $this->load->auto('image');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'post_image';

        $width = isset($settings['width']) ? $settings['width'] : $this->config->get('config_image_category_width');
        $height = isset($settings['height']) ? $settings['height'] : $this->config->get('config_image_category_height');

        if ($this->request->hasQuery('post_id') || $this->request->hasPost('post_id')) {
            $data['post_id'] = $this->request->hasPost('post_id') ? $this->request->getPost('post_id') : $this->request->getQuery('post_id');
        }

        $results = $this->modelPost->getAll($data);

        if ($post_info = $results[0]) {

            if ($post_info['image']) {
                $image = $post_info['image'];
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

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/post_image.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/post_image.tpl';
        } else {
            $this->template = 'cuyagua/module/post_image.tpl';
        }

        $this->id = 'post_image';
        $this->render();
    }
}
