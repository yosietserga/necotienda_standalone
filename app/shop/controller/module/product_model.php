<?php

class ControllerModuleProductModel extends Module {

    protected function index($widget = null) {
        $this->language->load('module/product_model');

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'product_model';

        $this->load->model('store/product');
        $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        $product_info = $this->modelProduct->getProduct($product_id);

        if ($product_info) {
            $this->data['heading_title'] = isset($settings['heading_title']) ? $settings['heading_title'] : $this->language->get('heading_title');
            $this->data['model'] = $product_info['model'];
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_model.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_model.tpl';
        } else {
            $this->template = 'cuyagua/module/product_model.tpl';
        }

        $this->id = 'product_model';
        $this->render();
    }
}
