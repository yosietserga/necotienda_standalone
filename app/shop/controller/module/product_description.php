<?php

class ControllerModuleProductDescription extends Module {

    protected function index($widget = null) {
        $this->language->load('module/product_description');

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'product_description';

        $this->load->model('store/product');
        $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        $product_info = $this->modelProduct->getProduct($product_id);

        if ($product_info) {
            $this->data['heading_title'] = isset($settings['heading_title']) ? $settings['heading_title'] : $this->language->get('heading_title');
            $this->data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_description.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_description.tpl';
        } else {
            $this->template = 'cuyagua/module/product_description.tpl';
        }

        $this->id = 'product_description';
        $this->render();
    }
}
