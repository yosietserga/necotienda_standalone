<?php

class ControllerModuleProductOrderForm extends Module {

    protected function index($widget = null) {
        $this->language->load('module/product_order_form');
        $Url = new Url($this->registry);

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'product_order_form';

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        $this->load->model('store/product');
        $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        $product_info = $this->modelProduct->getProduct($product_id);

        if ($product_info) {

            if ($product_info['minimum']) {
                $this->data['minimum'] = $product_info['minimum'];
            } else {
                $this->data['minimum'] = 1;
            }
            $this->data['text_minimum'] = sprintf($this->language->get('text_minimum'), $this->data['minimum']);

            $this->data['action'] = $Url::createUrl('checkout/cart');
            $this->data['redirect'] = $Url::createUrl('store/product', '&product_id=' . $product_id);
            $this->data['product_id'] = $product_id;
            $this->data['options'] = array();

            $options = $this->modelProduct->getProductOptions($product_id);

            foreach ($options as $option) {
                $option_value_data = array();
                foreach ($option['option_value'] as $option_value) {
                    $option_value_data[] = array(
                        'option_value_id' => $option_value['product_option_value_id'],
                        'name' => $option_value['name'],
                        'price' => (float) $option_value['price'] ? $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))) : false,
                        'prefix' => $option_value['prefix']
                    );
                }

                $this->data['options'][] = array(
                    'option_id' => $option['product_option_id'],
                    'name' => $option['name'],
                    'option_value' => $option_value_data
                );
            }


        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_order_form.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_order_form.tpl';
        } else {
            $this->template = 'cuyagua/module/product_order_form.tpl';
        }

        $this->id = 'product_order_form';
        $this->render();
    }
}
