<?php

class ControllerModuleProductOverview extends Module {

    protected function index($widget = null) {
        $this->language->load('module/product_overview');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'product_overview';

        $this->load->model('store/product');
        $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        $product_info = $this->modelProduct->getProduct($product_id);

        if ($product_info) {
            $this->data['heading_title'] = isset($settings['heading_title']) ? $settings['heading_title'] : $this->language->get('heading_title');
            $this->data['overview'] = $product_info['meta_description'];
        }

        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_overview.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_overview.tpl';
        } else {
            $this->template = 'cuyagua/module/product_overview.tpl';
        }

        $this->id = 'product_overview';
        $this->render();
    }
}
