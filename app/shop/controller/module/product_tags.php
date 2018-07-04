<?php

class ControllerModuleProductTags extends Module {

    protected function index($widget = null) {
        $this->language->load('module/product_tags');
        $Url = new Url($this->registry);

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'product_tags';

        $this->load->model('store/product');
        $this->load->model('store/category');
        $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        $product_info = $this->modelProduct->getProduct($product_id);

        if ($product_info) {
            $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

            $this->data['manufacturer_name'] = $product_info['manufacturer'];
            $this->data['manufacturer_link'] = $Url::createUrl('store/manufacturer', array('manufacturer_id' => $product_info['manufacturer_id']));
            $this->data['categories'] = $this->modelCategory->getAll(array('product_id' => $product_id));
            $this->data['tags'] = array();

            $results = $this->modelProduct->getProductTags($product_id);

            foreach ($results as $result) {
                if ($result['tag']) {
                    $this->data['tags'][] = array(
                        'tag' => $result['tag'],
                        'href' => $Url::createUrl('store/search', array('q' => $result['tag']))
                    );
                }
            }
        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_tags.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_tags.tpl';
        } else {
            $this->template = 'cuyagua/module/product_tags.tpl';
        }

        $this->id = 'product_tags';
        $this->render();
    }
}
