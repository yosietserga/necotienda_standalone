<?php

class ControllerModuleProductAttributes extends Module {

    protected function index($widget = null) {
        $this->language->load('module/product_attributes');

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }
        
        if (!$this->data['settings']['module']) $this->data['settings']['module'] = 'product_attributes';

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        $this->load->library('product');
        $Product = new Product($this->registry);
        $this->data['attributes'] = $Product->getAttributes($product_id);

        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_attributes.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_attributes.tpl';
        } else {
            $this->template = 'cuyagua/module/product_attributes.tpl';
        }

        $this->id = 'product_attributes';
        $this->render();
    }
}
