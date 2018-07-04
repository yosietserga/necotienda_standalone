<?php

class ControllerModuleProductStock extends Module {

    protected function index($widget = null) {
        $this->language->load('module/product_stock');

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'product_stock';

        $this->load->model('store/product');
        $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        $product_info = $this->modelProduct->getProduct($product_id);

        if ($product_info) {
            $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

            if ($product_info['quantity'] <= 0) {
                $this->data['stock'] = $product_info['stock'];
            } else {
                if ($this->config->get('config_stock_display')) {
                    $this->data['stock'] = $product_info['quantity'];
                } else {
                    $this->data['stock'] = $this->language->get('text_instock');
                }
            }

        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_stock.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_stock.tpl';
        } else {
            $this->template = 'cuyagua/module/product_stock.tpl';
        }

        $this->id = 'product_stock';
        $this->render();
    }
}
