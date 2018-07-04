<?php

class ControllerModuleProductList extends Module {

    protected function index($widget = null) {
        $Url = new Url($this->registry);
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        $url = $Url::createUrl("store/product/all");

        if ($this->request->hasQuery('manufacturer_id') || $this->request->hasPost('manufacturer_id')) {
            $data['manufacturer_id'] = $this->request->hasPost('manufacturer_id') ? $this->request->getPost('manufacturer_id') : $this->request->getQuery('manufacturer_id');
            $url = $Url::createUrl("store/manufacturer", array('manufacturer_id' => $data['manufacturer_id']));
        } else {
            $data['manufacturer_id'] = (!empty($settings['manufacturers'])) ? $settings['manufacturers'] : null;
        }

        if ($this->request->hasQuery('category_id') || $this->request->hasPost('category_id')) {
            $data['category_id'] = $this->request->hasPost('category_id') ? $this->request->getPost('category_id') : $this->request->getQuery('category_id');
            $url = $Url::createUrl("store/category", array('category_id' => $data['category_id']));
        } else {
            $data['category_id'] = (!empty($settings['categories'])) ? $settings['categories'] : null;
        }

        $data['limit'] = $this->request->hasQuery('limit') ?
            $this->request->getQuery('limit') :
            ((int)$settings['limit']) ? (int)$settings['limit']
                : ((int)$this->config->get('config_catalog_limit')) ? (int)$this->config->get('config_catalog_limit') : 24;

        $data['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
        $data['start'] = ($data['page'] - 1) * $data['limit'];
        $data['product_id'] = $this->request->hasPost('product_id') ?
            $this->request->getPost('product_id') :
            $this->request->hasQuery('product_id') ? $this->request->getQuery('product_id') : null;

        $this->data['products'] = array();

        $func = $this->request->hasQuery('func') ? $this->request->getQuery('func') :
            ($this->data['settings']['module']) ? $this->data['settings']['module'] : 'random';

        $this->prefetch($data, $func);

        $this->data['settings']['view'] = $this->request->hasQuery('view') ?
            $this->request->getQuery('view') :
            ($this->data['settings']['view']) ? $this->data['settings']['view'] : 'grid';

        if ($this->data['settings']['show_pagination'] && $this->data['total_products']) {
            $this->load->library('pagination');
            $pagination = new Pagination(true);
            $pagination->total = $this->data['total_products'];
            $pagination->page = $data['page'];
            $pagination->limit = $data['limit'];
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $url . '&page={page}';
            if ($this->data['settings']['endless_scroll']) {
                $pagination->ajax = true;
                $pagination->ajaxTarget = isset($this->data['settings']['endless_scroll_target']) ? $this->data['settings']['endless_scroll_target'] : "#{$widget['name']}_results";
            }
            $this->data['pagination'] = $pagination->render();
        }

        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $this->data['settings']['view'];
        $route = 'module/'. str_replace('controllermodule', '', strtolower(__CLASS__)) .'/'. $this->data['settings']['view'];
        $this->loadDeps($route);
        $this->loadWidgetAssets($filename);

        $this->id = 'product_list';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_list.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/product_list.tpl';
        } else {
            $this->template = 'cuyagua/module/product_list.tpl';
        }

        if ($this->request->getQuery('resp') == 'async') {
            $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
        } elseif ($this->request->getQuery('resp') == 'json') {
            $data['payload'] = array(
                'results' => $this->data['products'],
                'pagination' => $this->data['pagination'],
                'display_price' => $this->data['display_price'],
            );

            $this->load->library('json');
            $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
        } else {
            if (!empty($settings['custom_css'])) $this->data['css'] .= $settings['custom_css'];

            $this->render();
        }
    }

    protected function prefetch($data, $func = 'random') {
        $this->load->model('store/product');

        switch ($func) {
            case 'random':
            default:
                $results = $this->modelProduct->getRandomProducts($data);
                if (isset($this->data['settings']['show_pagination']) && $this->data['settings']['show_pagination'])
                    $this->data['total_products'] = $this->modelProduct->getAllTotal($data);
                break;
            case 'latest':
                $results = $this->modelProduct->getLatestProducts($data);
                if (isset($this->data['settings']['show_pagination']) && $this->data['settings']['show_pagination'])
                    $this->data['total_products'] = $this->modelProduct->getAllTotal($data);
                break;
            case 'featured':
                $results = $this->modelProduct->getFeaturedProducts($data);
                if (isset($this->data['settings']['show_pagination']) && $this->data['settings']['show_pagination'])
                    $this->data['total_products'] = $this->modelProduct->getTotalFeaturedProducts($data);
                break;
            case 'bestseller':
                $results = $this->modelProduct->getBestSellerProducts($data);
                if (isset($this->data['settings']['show_pagination']) && $this->data['settings']['show_pagination'])
                    $this->data['total_products'] = $this->modelProduct->getTotalBestSellerProducts($data);
                break;
            case 'recommended':
                $results = $this->modelProduct->getRecommendedProducts($data);
                if (isset($this->data['settings']['show_pagination']) && $this->data['settings']['show_pagination'])
                    $this->data['total_products'] = $this->modelProduct->getTotalRecommendedProducts($data);
                break;
            case 'related':
                $results = $this->modelProduct->getProductRelated($this->request->getQuery('product_id'), $data);
                if (isset($this->data['settings']['show_pagination']) && $this->data['settings']['show_pagination'])
                    $this->data['total_products'] = $this->modelProduct->getTotalProductRelated($this->request->getQuery('product_id'), $data);
                break;
            case 'popular':
                $results = $this->modelProduct->getPopularProducts($data);
                if (isset($this->data['settings']['show_pagination']) && $this->data['settings']['show_pagination'])
                    $this->data['total_products'] = $this->modelProduct->getAllTotal($data);
                break;
            case 'special':
                $data['sort'] = 'pd.name';
                $data['order'] = 'ASC';
                $results = $this->modelProduct->getProductSpecials($data);
                if (isset($this->data['settings']['show_pagination']) && $this->data['settings']['show_pagination'])
                    $this->data['total_products'] = $this->modelProduct->getAllTotal($data);
                break;
        }

        $this->load->library('product');
        $Product = new Product($this->registry);
        $this->data['products'] = $Product->getProductsArray($results, true, md5($data));

        if (!$this->config->get('config_customer_price') || $this->customer->isLogged()) {
            $this->data['display_price'] = true;
        } else {
            $this->data['display_price'] = false;
        }
    }
}