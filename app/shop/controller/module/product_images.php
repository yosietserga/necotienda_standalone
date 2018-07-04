<?php

class ControllerModuleProductImages extends Module {

    protected function index($widget = null) {
        $this->load->model('store/product');

        $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        $product_info = $this->modelProduct->getProduct($product_id);

        if ($product_info) {
            $this->load->library('image');
            $this->language->load('module/product_images');

            if (isset($widget)) {
                $settings = (array)unserialize($widget['settings']);
                $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
            }

            if (!$settings['module'])
                $settings['module'] = 'product_images';

            $settings['popup_width'] = isset($settings['popup_width']) ? $settings['popup_width'] : $this->config->get('config_image_popup_width');
            $settings['popup_height'] = isset($settings['popup_height']) ? $settings['popup_height'] : $this->config->get('config_image_popup_height');

            $settings['preview_width'] = isset($settings['preview_width']) ? $settings['preview_width'] : $this->config->get('config_image_thumb_width');
            $settings['preview_height'] = isset($settings['preview_height']) ? $settings['preview_height'] : $this->config->get('config_image_thumb_height');

            $settings['thumb_width'] = isset($settings['thumb_width']) ? $settings['thumb_width'] : $this->config->get('config_image_additional_width');
            $settings['thumb_height'] = isset($settings['thumb_height']) ? $settings['thumb_height'] : $this->config->get('config_image_additional_height');

            if (isset($settings['show_watermark'])) {
                $watermark = !empty($settings['watermark_file']) ? $settings['watermark_file'] : $this->config->get('config_logo');
                NTImage::setWatermark($watermark);
            }


            $image = isset($product_info['image']) && !empty($product_info['image']) ? $product_info['image'] : 'no_image.jpg';
            $imgProduct = array(
                'popup' => NTImage::resizeAndSave($image, $settings['popup_width'], $settings['popup_height']),
                'preview' => NTImage::resizeAndSave($image, $settings['preview_width'], $settings['preview_height']),
                'thumb' => NTImage::resizeAndSave($image, $settings['thumb_width'], $settings['thumb_height'])
            );

            $images = $this->modelProduct->getProductImages($product_id);
            $imgs = array();
            foreach ($images as $j => $image) {
                $imgs[$j] = array(
                'popup' => NTImage::resizeAndSave($image['image'], $settings['popup_width'], $settings['popup_height']),
                'preview' => NTImage::resizeAndSave($image['image'], $settings['preview_width'], $settings['preview_height']),
                'thumb' => NTImage::resizeAndSave($image['image'], $settings['thumb_width'], $settings['thumb_height'])
                );
            }

            array_push($imgs, $imgProduct);
            $this->data['images'] = array_reverse($imgs);

            $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
            $this->loadWidgetAssets($filename);

            $this->data['settings'] = $settings;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_images.tpl')) {
                $this->template = $this->config->get('config_template') . '/module/product_images.tpl';
            } else {
                $this->template = 'cuyagua/module/product_images.tpl';
            }

            $this->id = 'product_images';
            $this->render();
        }
    }
}
