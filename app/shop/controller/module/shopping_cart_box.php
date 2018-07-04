<?php

class ControllerModuleShoppingCartBox extends Module {

    protected function index($widget = null) {
        if ($this->config->get('config_store_mode') == 'store') {
            $this->language->load('module/shopping_cart_box');
            $this->load->auto('currency');
            $this->load->auto('tax');

            $Url = new Url($this->registry);

            if (isset($widget)) {
                $settings = (array)unserialize($widget['settings']);
                $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
            }

            if (!$settings['module']) $settings['module'] = 'shopping_cart_box';

            $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

            $this->session->clear('shipping_methods');
            $this->session->clear('payment_methods');

            $this->session->clear('shipping_method');
            $this->session->clear('payment_method');

            if ($this->request->server['REQUEST_METHOD'] == 'POST') {

                if (isset($this->request->post['remove'])) {
                    $result = explode('_', $this->request->post['remove']);
                    $this->cart->remove(trim($result[1]));
                } else {
                    if (isset($this->request->post['option'])) {
                        $option = $this->request->post['option'];
                    } else {
                        $option = array();
                    }

                    $this->cart->add($this->request->post['product_id'], $this->request->post['quantity'], $option);
                }
            }

            $data['limit'] = $this->request->hasQuery('limit') ?
                $this->request->getQuery('limit') :
                ((int)$settings['limit']) ? (int)$settings['limit'] : 12;

            $data['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
            $data['start'] = ($data['page'] - 1) * $data['limit'];

            $this->data['products'] = $this->cart->getProducts($data);

            $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();

            $this->load->model('checkout/extension');

            $sort_order = array();

            $results = $this->modelExtension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                $this->load->model('total/' . $result['key']);

                $this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
            }

            $sort_order = array();

            foreach ($total_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $total_data);

            $this->data['totals'] = $total_data;

            if ($this->data['settings']['show_pagination'] && $this->data['total_products']) {
                $this->load->library('pagination');
                $pagination = new Pagination(true);
                $pagination->total = $this->cart->getProducts();
                $pagination->page = $data['page'];
                $pagination->limit = $data['limit'];
                $pagination->text = $this->language->get('text_pagination');
                $pagination->url = $Url::createUrl("module/shopping_cart_box") . '&page={page}&resp=json';
                $pagination->ajax = true;
                $pagination->ajaxTarget = "#{$widget['name']}_results";
                $this->data['pagination'] = $pagination->render();
            }

            $this->data['settings'] = $settings;

            if ($this->request->getQuery('resp') == 'json') {
                $data['payload'] = array(
                    'results' => $this->data['products'],
                    'pagination' => $this->data['pagination']
                );

                $this->load->library('json');
                $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
            } else {
                $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
                $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
                $this->loadWidgetAssets($filename);

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/shopping_cart_box.tpl')) {
                    $this->template = $this->config->get('config_template') . '/module/shopping_cart_box.tpl';
                } else {
                    $this->template = 'cuyagua/module/shopping_cart_box.tpl';
                }

                $this->id = 'shopping_cart_box';
                $this->render();
            }
        }
    }
}
