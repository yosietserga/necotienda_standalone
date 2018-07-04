<?php

class ControllerModuleProductPrice extends Module {

    protected function index($widget = null) {
        $this->language->load('module/product_price');

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'product_price';

        $this->load->model('store/product');

        if (!$this->config->get('config_customer_price')) {
            $this->data['display_price'] = true;
        } elseif ($this->customer->isLogged()) {
            $this->data['display_price'] = true;
        } else {
            $this->data['display_price'] = false;
        }

        if ($this->data['display_price'] && $this->config->get('config_store_mode') == 'store') {
            $this->load->auto('currency');
            $this->load->auto('tax');

            $product_id = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
            $product_info = $this->modelProduct->getProduct($product_id);

            if ($product_info) {
                $discount = $this->modelProduct->getProductDiscount($product_id);

                if ($discount) {
                    $this->data['price'] = $this->currency->format($this->tax->calculate($discount, $product_info['tax_class_id'], $this->config->get('config_tax')));
                    $this->data['original_price'] = $this->tax->calculate($discount, $product_info['tax_class_id'], $this->config->get('config_tax'));
                    $this->data['special'] = false;
                } else {
                    $this->data['original_price'] = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                    $this->data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                    $special = $this->modelProduct->getProductSpecial($product_id);

                    if ($special) {
                        $this->data['special'] = $this->currency->format($this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax')));
                        $this->data['original_price'] = $this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax'));
                    } else {
                        $this->data['special'] = false;
                    }
                }
                $discounts = $this->modelProduct->getProductDiscounts($product_id);

                $this->data['discounts'] = array();
                foreach ($discounts as $discount) {
                    $this->data['discounts'][] = array(
                        'quantity' => $discount['quantity'],
                        'price' => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
                    );
                }
            }
        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_price.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_price.tpl';
        } else {
            $this->template = 'cuyagua/module/product_price.tpl';
        }

        $this->id = 'product_price';
        $this->render();
    }
}
