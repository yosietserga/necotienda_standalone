<?php

class ControllerModuleProductList extends Controller {

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        $data['limit'] = ((int) $this->data['settings']['limit']) ? (int) $this->data['settings']['limit'] : 24;
        $data['category_id'] = (!empty($settings['categories'])) ? $settings['categories'] : null;
        $this->data['products'] = array();

        $func = $this->data['settings']['module'];
        if (!$func || !in_array($func, array('random', 'latest', 'featured', 'bestseller', 'recommended', 'related', 'popular', 'special'))) $func = 'random';
        $this->prefetch($data, $func);

        $view = $this->data['settings']['view'];
        if (!$view || !in_array($view, array('list', 'grid', 'carousel', 'slider'))) $view = 'list';

        if ($this->data['settings']['show_pagination']) {

        }

        if ($this->data['settings']['endless_scroll']) {

        }

        $this->loadAssets($func, $view);

        if ($scripts)
            $this->scripts = array_merge($this->scripts, $scripts);

        $this->id = 'product_list';

        if ($widget['position'] == 'main' || $widget['position'] == 'featuredContent') {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_list_home_'. $view .'.tpl')) {
                //$this->template = $this->config->get('config_template') . '/module/'. $func .'_home.tpl';
                $this->template = $this->config->get('config_template') . '/module/product_list_home_'. $view .'.tpl';
            } else {
                $this->template = 'cuyagua/module/product_list_home_'. $view .'.tpl';
            }
        } else {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/product_list_'. $view .'.tpl')) {
                //$this->template = $this->config->get('config_template') . '/module/'. $func .'.tpl';
                $this->template = $this->config->get('config_template') . '/module/product_list_'. $view .'.tpl';
            } else {
                $this->template = 'cuyagua/module/product_list_'. $view .'.tpl';
            }
        }
        $this->render();
    }

    public function home() {
        $this->prefetch($this->config->get('config_catalog_limit'), $this->request->getQuery('func'));
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products.tpl')) {
            $this->template = $this->config->get('config_template') . '/store/products.tpl';
        } else {
            $this->template = 'cuyagua/store/products.tpl';
        }
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    protected function prefetch($data, $func = 'random') {
        $Url = new Url($this->registry);
        $this->language->load('module/'. $func);

        if (isset($this->data['settings']['title'])) {
            $this->data['heading_title'] = $this->data['settings']['title'];
        } else {
            $this->data['heading_title'] = $this->language->get('heading_title');
        }

        $this->load->model('store/product');

        switch ($func) {
            case 'random':
            default:
                $results = $this->modelProduct->getRandomProducts($data);
                break;
            case 'latest':
                $results = $this->modelProduct->getLatestProducts($data);
                break;
            case 'featured':
                $results = $this->modelProduct->getFeaturedProducts($data);
                break;
            case 'bestseller':
                $results = $this->modelProduct->getBestSellerProducts($data);
                break;
            case 'recommended':
                $results = $this->modelProduct->getRecommendedProducts($data);
                break;
            case 'related':
                $results = $this->modelProduct->getProductRelated($this->request->getQuery('product_id'), $data);
                break;
            case 'popular':
                $results = $this->modelProduct->getPopularProducts($data);
                break;
            case 'special':
                $data['sort'] = 'pd.name';
                $data['order'] = 'ASC';
                $results = $this->modelProduct->getProductSpecials($data);
                break;
        }

        $this->load->auto('store/review');

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
        foreach ($results as $k => $result) {
            $image = $imageP = !empty($result['image']) ? $result['image'] : 'no_image.jpg';

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
            $this->data['products'][$k] = array(
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

            $this->data['products'][$k]['images'] = array();
            $images = $this->modelProduct->getProductImages($result['product_id']);
            foreach ($images as $j => $image) {
                $this->data['products'][$k]['images'][$j] = array(
                    'popup' => NTImage::resizeAndSave($image['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                    'preview' => NTImage::resizeAndSave($image['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
                    'thumb' => NTImage::resizeAndSave($image['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
                );
            }
            $j = count($this->data['products'][$k]['images']) + 1;
            $this->data['products'][$k]['images'][$j] = array(
                'popup' => NTImage::resizeAndSave($imageP, $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                'preview' => NTImage::resizeAndSave($imageP, $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
                'thumb' => NTImage::resizeAndSave($imageP, $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
            );
            $this->data['products'][$k]['images'] = array_reverse($this->data['products'][$k]['images']);
        }

        if (!$this->config->get('config_customer_price') || $this->customer->isLogged()) {
            $this->data['display_price'] = true;
        } else {
            $this->data['display_price'] = false;
        }
    }

    public function carousel() {
        $func = $this->request->getQuery('func');
        if (!$func || !in_array($func, array('random', 'latest', 'featured', 'bestseller', 'recommended', 'related', 'popular', 'special'))) $func = 'random';

        if ($this->request->hasQuery('limit') && is_numeric($this->request->getQuery('limit'))) {
            $data['limit'] = $this->request->getQuery('limit');
        } else {
            $data['limit'] = 24;
        }

        $json = array();
        $Url = new Url($this->registry);
        $this->load->auto("store/product");
        $this->load->auto('image');
        $this->load->auto('json');

        switch ($func) {
            case 'random':
            default:
                $json['results'] = $this->modelProduct->getRandomProducts($data);
                break;
            case 'latest':
                $json['results'] = $this->modelProduct->getLatestProducts($data);
                break;
            case 'featured':
                $json['results'] = $this->modelProduct->getFeaturedProducts($data);
                break;
            case 'bestseller':
                $json['results'] = $this->modelProduct->getBestSellerProducts($data);
                break;
            case 'recommended':
                $json['results'] = $this->modelProduct->getRecommendedProducts($data);
                break;
            case 'related':
                $json['results'] = $this->modelProduct->getProductRelated($this->request->getQuery('product_id'), $data);
                break;
            case 'popular':
                $json['results'] = $this->modelProduct->getPopularProducts($data);
                break;
            case 'special':
                $data['sort'] = 'pd.name';
                $data['order'] = 'ASC';
                $json['results'] = $this->modelProduct->getProductSpecials($data);
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

            $json['results'][$k]['images'] = array();
            $images = $this->modelProduct->getProductImages($v['product_id']);
            foreach ($images as $j => $image) {
                $json['results'][$k]['images'][$j] = array(
                    'popup' => NTImage::resizeAndSave($image['image'], $width, $height),
                    'preview' => NTImage::resizeAndSave($image['image'], $width, $height),
                    'thumb' => NTImage::resizeAndSave($image['image'], $width, $height)
                );
            }
            $j = count($json['results'][$k]['images']) + 1;
            $json['results'][$k]['images'][$j] = array(
                'popup' => NTImage::resizeAndSave($v['image'], $width, $height),
                'preview' => NTImage::resizeAndSave($v['image'], $width, $height),
                'thumb' => NTImage::resizeAndSave($v['image'], $width, $height)
            );
            $json['results'][$k]['images'] = array_reverse($json['results'][$k]['images']);
        }

        if (!count($json['results']))
            $json['error'] = 1;

        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
    }

    protected function loadAssets($func, $view) {
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

        if (file_exists($cssFolder .str_replace('controller', '', strtolower(__CLASS__) . '.css'))) {
            if ($this->config->get('config_render_css_in_file')) {
                $this->data['css'] .= file_get_contents($cssFolder . str_replace('controller', '', strtolower(__CLASS__) . '.css'));
            } else {
                $styles[str_replace('controller', '', strtolower(__CLASS__) . '.css')] = array('media' => 'all', 'href' => $csspath . str_replace('controller', '', strtolower(__CLASS__) . '.css'));
            }
        }

        if (file_exists($cssFolder .'module'. $func .  $view .'.css')) {
            if ($this->config->get('config_render_css_in_file')) {
                $this->data['css'] .= file_get_contents($cssFolder . 'module'. $func . $view .'.css');
            } else {
                $styles['module'. $func . $view .'.css'] = array('media' => 'all', 'href' => $csspath . 'module'. $func . $view .'.css');
            }
        }

        if (file_exists($jsFolder . 'module'. $func . $view . '.js')) {
            if ($this->config->get('config_render_js_in_file')) {
                $javascripts[] = $jsFolder . 'module'. $func . $view . '.js';
            } else {
                $javascripts[] = $jspath . 'module'. $func . $view . '.js';
            }
        }

        if (file_exists($jsFolder . str_replace('controller', '', strtolower(__CLASS__) . '.js'))) {
            if ($this->config->get('config_render_js_in_file')) {
                $javascripts[] = $jsFolder . str_replace('controller', '', strtolower(__CLASS__) . '.js');
            } else {
                $javascripts[] = $jspath . str_replace('controller', '', strtolower(__CLASS__) . '.js');
            }
        }

        if (count($styles)) {
            $this->data['styles'] = $this->styles = array_merge($this->styles, $styles);
        }

        if (count($javascripts)) {
            $this->javascripts = array_merge($this->javascripts, $javascripts);
        }
    }
}