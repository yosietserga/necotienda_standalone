<?php

class ControllerModuleProductList extends Controller {

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'random';

        if (isset($this->data['settings']['title'])) {
            $this->data['heading_title'] = $this->data['settings']['title'];
        } else {
            $this->data['heading_title'] = $this->language->get('heading_title');
        }

        $limit = ((int) $this->data['settings']['limit']) ? (int) $this->data['settings']['limit'] : 24;
        $this->data['products'] = array();
        $this->prefetch($limit, $this->data['settings']['module']);
        if (!$func || !in_array($func, array('random', 'bestseller', 'latest', 'featured', 'recommended', 'special'))) $func = 'random';

        $this->loadAssets($func);

        if ($scripts)
            $this->scripts = array_merge($this->scripts, $scripts);

        $this->id = 'product_list';

        if ($widget['position'] == 'main' || $widget['position'] == 'featuredContent') {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/'. $func .'_home.tpl')) {
                $this->template = $this->config->get('config_template') . '/module/'. $func .'_home.tpl';
            } else {
                $this->template = 'choroni/module/'. $func .'_home.tpl';
            }
        } else {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/'. $func .'.tpl')) {
                $this->template = $this->config->get('config_template') . '/module/'. $func .'.tpl';
            } else {
                $this->template = 'choroni/module/'. $func .'.tpl';
            }
        }
        $this->render();
    }

    public function home() {
        $this->prefetch($this->config->get('config_catalog_limit'), $this->request->getQuery('func'));
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products.tpl')) {
            $this->template = $this->config->get('config_template') . '/store/products.tpl';
        } else {
            $this->template = 'choroni/store/products.tpl';
        }
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    protected function prefetch($limit, $func = 'random') {
        if (!$func || !in_array($func, array('random', 'bestseller', 'latest', 'featured', 'recommended', 'special'))) $func = 'random';
        $Url = new Url($this->registry);
        $this->language->load('module/'. $func);
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->load->model('store/product');

        switch ($func) {
            case 'random':
            default:
                $results = $this->modelProduct->getRandomProducts($limit);
                break;
            case 'latest':
                $results = $this->modelProduct->getLatestProducts($limit);
                break;
            case 'featured':
                $results = $this->modelProduct->getFeaturedProducts($limit);
                break;
            case 'bestseller':
                $results = $this->modelProduct->getBestSellerProducts($limit);
                break;
            case 'recommended':
                $results = $this->modelProduct->getRecommendedProducts($limit);
                break;
            case 'special':
                $results = $this->modelProduct->getProductSpecials('pd.name', 'ASC', 0, $limit);
                break;
        }

        $this->load->auto('store/review');
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['button_see_product'] = $this->language->get('button_see_product');
        $this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
        $this->data['products'] = array();

        list($dia, $mes, $ano) = explode('-', date('d-m-Y'));
        $l = ((int) $this->config->get('config_new_days') > 30) ? 30 : $this->config->get('config_new_days');
        if (($dia = $dia - $l) <= 0) {
            $dia = $dia + 30;
            if ($dia <= 0)
                $dia = 1;
            $mes = $mes - 1;
            if ($mes <= 0) {
                $mes = $mes + 12;
                $ano = $ano - 1;
            }
        }
        foreach ($results as $key => $result) {
            $image = !empty($result['image']) ? $result['image'] : 'no_image.jpg';

            if ($this->config->get('config_review')) {
                $rating = $this->modelReview->getAverageRating($result['product_id']);
            } else {
                $rating = false;
            }

            $special = false;
            $discount = $this->modelProduct->getProductDiscount($result['product_id']);

            if ($discount) {
                $price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                $special = $this->modelProduct->getProductSpecial($result['product_id']);
                if ($special) {
                    $special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
                }
            }

            $options = $this->modelProduct->getProductOptions($result['product_id']);

            if ($options) {
                $add = $Url::createUrl('store/product', array('product_id' => $result['product_id']));
            } else {
                $add = $Url::createUrl('checkout/cart', array('product_id' => $result['product_id']));
            }

            list($pdia, $pmes, $pano) = explode('-', date('d-m-Y', strtotime($result['created'])));

            if ($special) {
                $sticker = '<b class="oferta"></b>';
            } elseif ($discount) {
                $sticker = '<b class="descuento"></b>';
            } elseif (strtotime($dia . "-" . $mes . "-" . $ano) <= strtotime($pdia . "-" . $pmes . "-" . $pano)) {
                $sticker = '<b class="nuevo"></b>';
            } else {
                $sticker = "";
            }

            $this->load->auto('image');
            $this->data['products'][] = array(
                'product_id' => $result['product_id'],
                'name' => $result['name'],
                'model' => $result['model'],
                'overview' => $result['meta_description'],
                'rating' => $rating,
                'stars' => sprintf($this->language->get('text_stars'), $rating),
                'price' => $price,
                'sticker' => $sticker,
                'options' => $options,
                'special' => $special,
                'image' => NTImage::resizeAndSave($image, 38, 38),
                'lazyImage' => NTImage::resizeAndSave('no_image.jpg', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                'thumb' => NTImage::resizeAndSave($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                'href' => $Url::createUrl('store/product', array('product_id' => $result['product_id'])),
                'add' => $add,
                'created' => $result['created']
            );
        }

        if (!$this->config->get('config_customer_price') || $this->customer->isLogged()) {
            $this->data['display_price'] = true;
        } else {
            $this->data['display_price'] = false;
        }
    }

    public function carousel() {
        if ($this->request->hasQuery('func') && in_array($this->request->getQuery('func'), array('random', 'bestseller', 'latest', 'featured', 'recommended', 'special'))) {
            $func = $this->request->getQuery('func');
        } else {
            $func = 'random';
        }
        if ($this->request->hasQuery('limit') && is_numeric($this->request->getQuery('limit'))) {
            $limit = $this->request->getQuery('limit');
        } else {
            $limit = 24;
        }
        
        $json = array();
        $Url = new Url($this->registry);
        $this->load->auto("store/product");
        $this->load->auto('image');
        $this->load->auto('json');

        switch ($func) {
            case 'random':
            default:
                $json['results'] = $this->modelProduct->getRandomProducts($limit);
                break;
            case 'latest':
                $json['results'] = $this->modelProduct->getLatestProducts($limit);
                break;
            case 'featured':
                $json['results'] = $this->modelProduct->getFeaturedProducts($limit);
                break;
            case 'bestseller':
                $json['results'] = $this->modelProduct->getBestSellerProducts($limit);
                break;
            case 'recommended':
                $json['results'] = $this->modelProduct->getRecommendedProducts($limit);
                break;
            case 'special':
                $json['results'] = $this->modelProduct->getProductSpecials('pd.name', 'ASC', 0, $limit);
                break;
        }

        $width = isset($_GET['width']) ? $_GET['width'] : 80;
        $height = isset($_GET['height']) ? $_GET['height'] : 80;
        foreach ($json['results'] as $k => $v) {
            if (!file_exists(DIR_IMAGE . $v['image']))
                $json['results'][$k]['image'] = HTTP_IMAGE . "no_image.jpg";
            $json['results'][$k]['thumb'] = NTImage::resizeAndSave($v['image'], $width, $height);
            if ((!$this->config->get('config_customer_price') || $this->customer->isLogged()) && $this->config->get('config_store_mode') === 'store') {
                $json['results'][$k]['price'] = $this->currency->format($this->tax->calculate($v['price'], $v['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $json['results'][$k]['price'] = null;
            }
            $json['results'][$k]['config_store_mode'] = $this->config->get('config_store_mode');
            $json['results'][$k]['seeProduct_url'] = $Url::createUrl('store/product', array('product_id' => $v['product_id']));
            $json['results'][$k]['addToCart_url'] = $Url::createUrl('checkout/cart') . '?product_id=' . $v['product_id'];
        }

        if (!count($json['results']))
            $json['error'] = 1;

        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
    }

    protected function loadAssets($func) {
        $csspath = defined("CDN") ? CDN_CSS : HTTP_THEME_CSS;
        $jspath = defined("CDN") ? CDN_JS : HTTP_THEME_JS;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
            $csspath = str_replace("%theme%", $this->config->get('config_template'), $csspath);
            $cssFolder = str_replace("%theme%", $this->config->get('config_template'), DIR_THEME_CSS);

            $jspath = str_replace("%theme%", $this->config->get('config_template'), $jspath);
            $jsFolder = str_replace("%theme%", $this->config->get('config_template'), DIR_THEME_JS);
        } else {
            $csspath = str_replace("%theme%", "default", $csspath);
            $cssFolder = str_replace("%theme%", "default", DIR_THEME_CSS);

            $jspath = str_replace("%theme%", "default", $jspath);
            $jsFolder = str_replace("%theme%", "default", DIR_THEME_JS);
        }

        if (file_exists($cssFolder .'module'. $func . '.css')) {
            $styles[] = array('media' => 'all', 'href' => $csspath .'module'. $func .'.css');
        }

        if (count($styles)) {
            $this->data['styles'] = $this->styles = array_merge($this->styles, $styles);
        }

        if (file_exists($jsFolder . str_replace('controller', '', strtolower(__CLASS__) . '.js'))) {
            $javascripts[] = $jspath . str_replace('controller', '', strtolower(__CLASS__) . '.js');
        }

        if (count($javascripts)) {
            $this->javascripts = array_merge($this->javascripts, $javascripts);
        }
    }
}