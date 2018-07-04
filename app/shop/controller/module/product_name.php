<?php

class ControllerModuleProductName extends Module {

    protected function index($widget = null) {
        $this->language->load('module/product_name');

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'product_name';

        $this->load->model('store/product');
        $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        $product_info = $this->modelProduct->getProduct($product_id);

        if ($product_info) {
            $this->data['heading_title'] = isset($product_info['name']) ? $product_info['name'] : $this->language->get('heading_title');
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_name.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_name.tpl';
        } else {
            $this->template = 'cuyagua/module/product_name.tpl';
        }

        $this->id = 'product_name';
        $this->render();
    }
}
