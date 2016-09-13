<?php

class ControllerApiNts extends Controller {

    protected $handler;
    protected $oauth_url;

    private function initialize() {

    }

    protected function setHeaders() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Access-Control-Allow-Methods: GET');
        header("HTTP/1.0 200 Success", true, 200);
    }

    public function index() {
        $Url = new Url($this->registry);
        $this->setHeaders();
        $this->load->library('xhttp/xhttp');
        $this->handler = new xhttp;

        $ntsactions = array(
            'products',
            'posts',
            'productscategories',
            'postcategories',
            'pages',
            'reviews',
            'banners',
            'menus',
            'manufacturers',
            'downloads',
            'stores',
            'emailtemplates',
        );
        
        if ($this->request->hasQuery('action') && in_array($this->request->hasQuery('action'), $ntsactions)) {
            $_SESSION['ntsaction'] = $this->request->getQuery('action');
        } else {
            //show error messages or http response 404
        }
        
        $redirect_uri = HTTP_HOME . 'api/nts';
        if (strpos($redirect_uri, 'http') === false) {
            if (strpos($redirect_uri, 'www.') === false) {
                $redirect_uri = 'www.' . $redirect_uri;
            }
            $redirect_uri = 'http://' . $redirect_uri;
        } elseif (strpos($redirect_uri, 'www.') === false) {
            $protocol = substr($redirect_uri, 0, 7);
            $url = substr($redirect_uri, 7);
            $redirect_uri = $protocol . 'www.' . $url;
        }
        $redirect_uri = str_replace('/web', '', $redirect_uri);

        
        if(isset($_SESSION['ntsexpire']) && $_SESSION['ntsexpire'] < time()) {
            try {

            } catch (Exception $e) {
                echo "Exception: ".  $e->getMessage() ."\n";
            }
        }
        
        //if (isset($_SESSION['ntstoken'])) {
            if (isset($_SESSION['ntsaction']) && in_array($_SESSION['ntsaction'], $ntsactions)) {
                $this->{$_SESSION['ntsaction']}();
                /*
                $apiClass = ucwords(strtolower($_SESSION['ntsaction'])).'Api';
                if (class_exists($apiClass)) {
                    $api = new $apiClass($this->registry);
                    
                    switch (strtolower($_SERVER['REQUEST_METHOD'])) {
                        case 'get':
                        default:
                            if ($this->request->hasQuery('id')) {
                                $api->get($this->request->getQuery('id'));
                            } else {
                                $api->get();
                            }
                            break;
                        case 'post':
                            //TODO: validate session and tokens
                            if ($this->request->hasQuery('id')) {
                                $api->post($this->request->getQuery('id'), $this->request->post);
                            } else {
                                $api->post(null, $this->request->post);
                            }
                            break;
                        case 'put':
                            //TODO: validate session and tokens
                            if ($this->request->hasQuery('id')) {
                                $api->put($this->request->getQuery('id'), $this->request->post);
                            }
                            break;
                        case 'delete':
                            //TODO: validate session and tokens
                            if ($this->request->hasQuery('id')) {
                                $api->delete($this->request->getQuery('id'));
                            }
                            break;
                    }
                }
                */
            } else {
                unset($_SESSION['ntstoken']);
                unset($_SESSION['ntsexpire']);
                unset($_SESSION['ntsaction']);
            }
        //} else {
            unset($_SESSION['ntstoken']);
        //}

        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['ntstoken']);
        }
    }

    private function products() {
        $product_id = $this->request->getQuery('id');
        $this->load->model('store/product');

        $this->load->auto('json');
        $Url = new Url($this->registry);
        $product_info = $this->modelProduct->getProduct($product_id);
        
        if ($product_id && $product_info) {
            $cacheId = 'product.api.json.get.' .
                $product_id .
                $this->config->get('config_language_id') . "." .
                $this->config->get('config_currency') . "." .
                $this->request->getQuery('hl') . "." .
                $this->request->getQuery('cc') . "." .
                $this->config->get('config_store_id');
            $customerGroups = $this->modelProduct->getProperty($product_id, 'customer_groups', 'customer_groups');
            if (($this->customer->isLogged() && in_array($this->customer->getCustomerGroupId(), $customerGroups)) || in_array(0, $customerGroups)) {
                $cached = $this->cache->get($cacheId);
                
                $this->load->library('user');
                
                if ($cached && !$this->user->isLogged()) {
                    $this->response->setOutput($cached, $this->config->get('config_compression'));
                } else {
                    //Models
                    $this->load->model('store/category');
                    $this->load->model('store/manufacturer');
                    
                    $this->load->model('store/review');
                    //Libs
                    $this->load->auto('currency');
                    $this->load->auto('tax');
                    
                    $data['results'] = $product_info;
                    
                    $this->document->breadcrumbs = array();
                    $this->document->breadcrumbs[] = array(
                        'href' => $Url::createUrl('store/home'),
                        'text' => $this->language->get('text_home'),
                        'separator' => false
                    );

                    if (isset($this->request->get['path'])) {
                        $path = '';
                        foreach (explode('_', $this->request->get['path']) as $path_id) {
                            $category_info = $this->modelCategory->getCategory($path_id);
                            $path .= (!$path) ? $path_id : '_' . $path_id;
                            if ($category_info) {
                                $this->document->breadcrumbs[] = array(
                                    'href' => $Url::createUrl('store/category', array('path' => $path)),
                                    'text' => $category_info['name'],
                                    'separator' => $this->language->get('text_separator')
                                );
                            }
                        }
                    }

                    if (isset($this->request->get['manufacturer_id'])) {
                        $manufacturer_info = $this->modelManufacturer->getManufacturer($this->request->get['manufacturer_id']);
                        if ($manufacturer_info) {
                            $this->document->breadcrumbs[] = array(
                                'href' => $Url::createUrl('store/manufacturer', array('manufacturer_id' => $this->request->get['manufacturer_id'])),
                                'text' => $manufacturer_info['name'],
                                'separator' => $this->language->get('text_separator')
                            );
                        }
                    }
                    
                    if (isset($this->request->get['keyword'])) {
                        $url = '';
                        if (isset($this->request->get['category_id'])) {
                            $url .= '&category_id=' . $this->request->get['category_id'];
                        }
                        if (isset($this->request->get['description'])) {
                            $url .= '&description=' . $this->request->get['description'];
                        }
                        $this->document->breadcrumbs[] = array(
                            'href' => $Url::createUrl('store/search', '&keyword=' . $this->request->get['keyword'] . $url),
                            'text' => $this->language->get('text_search'),
                            'separator' => $this->language->get('text_separator')
                        );
                    }

                    $this->document->breadcrumbs[] = array(
                        'href' => $Url::createUrl('store/product', $url . '&product_id=' . $product_id),
                        'text' => $product_info['name'],
                        'separator' => $this->language->get('text_separator')
                    );

                    $data['breadcrumbs'] = $this->document->breadcrumbs;

                    $average = ($this->config->get('config_review')) ? $this->modelReview->getAverageRating($product_id) : $average = false;

                    $data['redirect'] = $Url::createUrl('store/product', $url . '&product_id=' . $product_id);

                    $image = isset($product_info['image']) ? $product_info['image'] : $image = 'no_image.jpg';
                    $imgProduct = array(
                        'popup' => NTImage::resizeAndSave($image, $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                        'preview' => NTImage::resizeAndSave($image, $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
                        'thumb' => NTImage::resizeAndSave($image, $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
                    );

                    $discount = $this->modelProduct->getProductDiscount($product_id);

                    if ($discount) {
                        $data['results']['price'] = $this->currency->format($this->tax->calculate($discount, $product_info['tax_class_id'], $this->config->get('config_tax')));
                        $data['results']['special'] = false;
                    } else {
                        $data['results']['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                        $special = $this->modelProduct->getProductSpecial($product_id);

                        if ($special) {
                            $data['results']['special'] = $this->currency->format($this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax')));
                        } else {
                            $data['results']['special'] = false;
                        }
                    }

                    $discounts = $this->modelProduct->getProductDiscounts($product_id);

                    $data['results']['discounts'] = array();
                    foreach ($discounts as $discount) {
                        $data['results']['discounts'][] = array(
                            'quantity' => $discount['quantity'],
                            'price' => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
                        );
                    }

                    if ($product_info['quantity'] <= 0) {
                        $data['results']['stock'] = $product_info['stock'];
                    } else {
                        if ($this->config->get('config_stock_display')) {
                            $data['results']['stock'] = $product_info['quantity'];
                        } else {
                            $data['results']['stock'] = $this->language->get('text_instock');
                        }
                    }

                    if ($product_info['minimum']) {
                        $data['results']['minimum'] = $product_info['minimum'];
                    } else {
                        $data['results']['minimum'] = 1;
                    }

                    $data['results']['model'] = $product_info['model'];
                    $data['results']['manufacturer'] = $product_info['manufacturer'];
                    $data['results']['description'] = htmlspecialchars($product_info['description'], ENT_QUOTES, 'UTF-8');
                    $data['results']['product_id'] = $product_id;
                    $data['results']['average'] = $average;
                    $data['results']['options'] = array();
                    $data['results']['attributes'] = array();

                    /* product attributes */
                    foreach ($this->modelProduct->getAllProperties( $product_id, 'attribute' ) as $attribute) {
                        list($name, $attribute_id, $attribute_group_id) = explode(':', $attribute['key']);
                        $attrValues[$attribute_group_id][$attribute_id] = $attribute['value'];
                    }

                    foreach ($attrValues as $k => $attr) {
                        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."product_attribute_group WHERE product_attribute_group_id = ". (int)$k);
                        $attribute_group = $query->row;

                        $data['results']['attributes'][$k]['product_attribute_group_id'] = ($attribute_group['product_attribute_group_id']) ? $attribute_group['product_attribute_group_id'] : null;
                        $data['results']['attributes'][$k]['title'] = ($attribute_group['name']) ? $attribute_group['name'] : null;
                        $data['results']['attributes'][$k]['categoriesAttributes'] = array_unique($this->modelProduct->getCategoriesByAttributeGroupId($k));


                        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."product_attribute WHERE product_attribute_group_id = ". (int)$k);
                        foreach ($query->rows as $key => $item) {
                            $data['results']['attributes'][$k]['items'][$key]['product_attribute_id'] = ($item['product_attribute_id']) ? $item['product_attribute_id'] : null;
                            $data['results']['attributes'][$k]['items'][$key]['type'] = ($item['type']) ? $item['type'] : null;
                            $data['results']['attributes'][$k]['items'][$key]['name'] = ($item['name']) ? $item['name'] : null;
                            $data['results']['attributes'][$k]['items'][$key]['value'] = ($item['value']) ? $item['value'] : null;
                            $data['results']['attributes'][$k]['items'][$key]['label'] = ($item['label']) ? $item['label'] : null;
                            $data['results']['attributes'][$k]['items'][$key]['pattern'] = ($item['pattern']) ? $item['pattern'] : null;
                            $data['results']['attributes'][$k]['items'][$key]['value'] = ($item['default']) ? $item['default'] : $attr[$item['product_attribute_id']];
                            $data['results']['attributes'][$k]['items'][$key]['required'] = ($item['required']) ? $item['required'] : null;
                        }
                    }
                    /* /product attributes */

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

                        $data['results']['options'][] = array(
                            'option_id' => $option['product_option_id'],
                            'name' => $option['name'],
                            'option_value' => $option_value_data
                        );
                    }

                    $data['results']['images'] = array();
                    $results = $this->modelProduct->getProductImages($product_id);

                    foreach ($results as $k => $result) {
                        $data['results']['images'][$k] = array(
                            'popup' => NTImage::resizeAndSave($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                            'preview' => NTImage::resizeAndSave($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
                            'thumb' => NTImage::resizeAndSave($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
                        );
                    }
                    $k = count($data['results']['images']) + 1;
                    $data['results']['images'][$k] = $imgProduct;

                    if (!$this->config->get('config_customer_price')) {
                        $data['results']['display_price'] = true;
                    } elseif ($this->customer->isLogged()) {
                        $data['results']['display_price'] = true;
                    } else {
                        $data['results']['display_price'] = false;
                    }

                    list($dia, $mes, $ano) = explode('-', date('d-m-Y'));
                    list($pdia, $pmes, $pano) = explode('-', date('d-m-Y', strtotime($product_info['created'])));
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

                    $this->modelProduct->updateStats($this->request->getQuery('product_id'), (int) $this->customer->getId());

                    $data['results']['tags'] = array();

                    $results = $this->modelProduct->getProductTags($product_id);

                    foreach ($results as $result) {
                        if ($result['tag']) {
                            $data['results']['tags'][] = array(
                                'tag' => $result['tag'],
                                'href' => $Url::createUrl('store/search', array('q' => $result['tag']))
                            );
                        }
                    }

                    if (!$this->user->isLogged()) {
                        $this->cacheId = $cacheId;
                    }

                    $this->load->library('json');
                    $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
                }
            } else {
                $this->error404();
            }
        } elseif ($product_id && !$product_info) {
            $this->error404();
        } else {
            $cacheId = 'product.api.json.get.all.' .
                $this->config->get('config_language_id') . "." .
                $this->config->get('config_currency') . "." .
                $this->request->getQuery('hl') . "." .
                $this->request->getQuery('cc') . "." .
                $this->config->get('config_store_id');
            
            $data['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
            $data['limit'] = $this->request->hasQuery('limit') ? $this->request->getQuery('limit') : $this->config->get('config_catalog_limit');

            $this->load->model('store/review');
            $data['start'] = ($data['page'] - 1) * $data['limit'];
            $product_total = $this->modelProduct->getTotalByKeyword($data);
            if ($product_total) {
                $results = $this->modelProduct->getByKeyword($data);
                foreach ($results as $result) {
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
                        $add = $Url::createUrl('checkout/cart') . '?product_id=' . $result['product_id'];
                    }
                    
                    $attributes = array();
                    /* product attributes */
                    foreach ($this->modelProduct->getAllProperties( $result['product_id'], 'attribute' ) as $attribute) {
                        list($name, $attribute_id, $attribute_group_id) = explode(':', $attribute['key']);
                        $attrValues[$attribute_group_id][$attribute_id] = $attribute['value'];
                    }
                    
                    foreach ($attrValues as $k => $attr) {
                        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."product_attribute_group WHERE product_attribute_group_id = ". (int)$k);
                        $attribute_group = $query->row;

                        $attributes[$k]['product_attribute_group_id'] = ($attribute_group['product_attribute_group_id']) ? $attribute_group['product_attribute_group_id'] : null;
                        $attributes[$k]['title'] = ($attribute_group['name']) ? $attribute_group['name'] : null;
                        $attributes[$k]['categoriesAttributes'] = array_unique($this->modelProduct->getCategoriesByAttributeGroupId($k));


                        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."product_attribute WHERE product_attribute_group_id = ". (int)$k);
                        foreach ($query->rows as $key => $item) {
                            $attributes[$k]['items'][$key]['product_attribute_id'] = ($item['product_attribute_id']) ? $item['product_attribute_id'] : null;
                            $attributes[$k]['items'][$key]['type'] = ($item['type']) ? $item['type'] : null;
                            $attributes[$k]['items'][$key]['name'] = ($item['name']) ? $item['name'] : null;
                            $attributes[$k]['items'][$key]['value'] = ($item['value']) ? $item['value'] : null;
                            $attributes[$k]['items'][$key]['label'] = ($item['label']) ? $item['label'] : null;
                            $attributes[$k]['items'][$key]['pattern'] = ($item['pattern']) ? $item['pattern'] : null;
                            $attributes[$k]['items'][$key]['value'] = ($item['default']) ? $item['default'] : $attr[$item['product_attribute_id']];
                            $attributes[$k]['items'][$key]['required'] = ($item['required']) ? $item['required'] : null;
                        }
                    }
                    /* /product attributes */
                    
                    $data['results'][] = array(
                        'product_id' => $result['product_id'],
                        'name' => $result['name'],
                        'model' => $result['model'],
                        'overview' => $result['meta_description'],
                        'rating' => $rating,
                        'stars' => sprintf($this->language->get('text_stars'), $rating),
                        'price' => $price,
                        'attributes' => $attributes,
                        'options' => $options,
                        'special' => $special,
                        'image' => NTImage::resizeAndSave($image, 38, 38),
                        'lazyImage' => NTImage::resizeAndSave('no_image.jpg', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                        'thumb' => NTImage::resizeAndSave($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                        'href' => $Url::createUrl('store/product', array('product_id' => $result['product_id'])),
                        'addToCart' => $add
                    );
                }
            }
            
            if (!$this->user->isLogged()) {
                $this->cacheId = $cacheId;
            }

            $this->load->library('json');
            $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
        }
    }

    private function posts() {
        $post_id = $this->request->getQuery('id');

        $this->load->auto('content/post');
        $post_info = $this->modelPost->posts(array('id'=>$post_id));

        $this->load->auto('json');
        $Url = new Url($this->registry);

        if ($post_id && $post_info) {
            $cacheId = 'post.api.json.get.' .
                $post_id .
                $this->config->get('config_language_id') . "." .
                $this->config->get('config_currency') . "." .
                $this->request->getQuery('hl') . "." .
                $this->request->getQuery('cc') . "." .
                $this->config->get('config_store_id');
            $customerGroups = $this->modelProduct->getProperty($post_id, 'customer_groups', 'customer_groups');
            if (($this->customer->isLogged() && in_array($this->customer->getCustomerGroupId(), $customerGroups)) || in_array(0, $customerGroups)) {
                $cached = $this->cache->get($cacheId);

                $this->tracker->track($post_info['post_id'], 'post');
                
                $this->load->library('user');

                if ($cached && !$this->user->isLogged()) {
                    $this->response->setOutput($cached, $this->config->get('config_compression'));
                } else {
                    $data['results'] = $post_info;

                    $this->document->title = $post_info['title'];
                    $this->document->breadcrumbs[] = array(
                        'href' => $Url::createUrl("common/home"),
                        'text' => $this->language->get('text_home'),
                        'separator' => $this->language->get('text_separator')
                    );
                    $this->document->breadcrumbs[] = array(
                        'href' => $Url::createUrl("content/post", array('post_id' => $this->request->get['post_id'])),
                        'text' => $post_info['title'],
                        'separator' => $this->language->get('text_separator')
                    );

                    $this->load->auto('image');
                    if (!empty($post_info['image']))
                        $data['results']['image'] = $post_info['image'];

                    if (!empty($post_info['image']))
                        $data['results']['thumb'] = NTImage::resizeAndSave($post_info['image'], $this->config->get('config_image_post_width'), $this->config->get('config_image_post_height'));

                    !empty($post_info['image']) ?
                        $data['results']['lazyImage'] = NTImage::resizeAndSave($post_info['image'], 38, 38) :
                        $data['results']['lazyImage'] = NTImage::resizeAndSave('no_image.jpg', 38, 38);

                    $data['results']['breadcrumbs'] = $this->document->breadcrumbs;
                    $data['results']['heading_title'] = $post_info['title'];
                    $data['results']['description'] = html_entity_decode($post_info['description']);
                    $data['results']['date_added'] = date('d-m-Y', strtotime($post_info['date_publish_start']));
                    $data['results']['allow_reviews'] = $post_info['allow_reviews'];

                    if (!$this->user->isLogged()) {
                        $this->cacheId = $cacheId;
                    }

                    $this->load->library('json');
                    $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
                }
            }
        } elseif ($post_id && !$post_info) {
            $this->error404();
        } else {

            $cacheId = 'posts.api.json.get.all.' .
                $this->config->get('config_language_id') . "." .
                $this->config->get('config_currency') . "." .
                $this->request->getQuery('hl') . "." .
                $this->request->getQuery('cc') . "." .
                $this->config->get('config_store_id');

            $filters['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
            $filters['limit'] = $this->request->hasQuery('limit') ? $this->request->getQuery('limit') : $this->config->get('config_catalog_limit');

            $this->load->model('store/review');
            $filters['start'] = ($filters['page'] - 1) * $filters['limit'];

            $data['results'] = array();
            $post_total = $this->modelPost->postsTotal($filters);
            if ($post_total) {
                $posts = $this->modelPost->posts($filters);
                foreach ($posts as $result) {
                    if ($result['image']) {
                        $image = $result['image'];
                    } else {
                        $image = 'no_image.jpg';
                    }
                    $data['results']['posts'][] = array(
                        'post_id' => $result['post_id'],
                        'title' => $result['title'],
                        'seo_title' => $result['seo_title'],
                        'tags' => explode(";", $result['meta_keywords']),
                        'description' => html_entity_decode($result['description']),
                        'meta_description' => $result['meta_description'],
                        //'categories'       => $this->modelReview->getByPostId($result['pid']),
                        //'reviews'       => $this->modelReview->getByPostId($result['pid']),
                        //'reviews'       => $this->modelReview->getByPostId($result['pid']),
                        //'reviews'       => $this->modelReview->getByPostId($result['pid']),
                        //'reviews'       => $this->modelReview->getByPostId($result['pid']),
                        //'reviews'       => $this->modelReview->getByPostId($result['pid']),
                        'allowReviews' => $result['allow_reviews'],
                        'thumb' => NTImage::resizeAndSave($image, $this->config->get('config_image_post_width'), $this->config->get('config_image_post_height')),
                        'date_added' => date('d-m-Y', strtotime($result['date_publish_start']))
                    );
                }
            }


            if (!$this->user->isLogged()) {
                $this->cacheId = $cacheId;
            }

            $this->load->library('json');
            $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
        }

    }

    protected function error404() {
        header("HTTP/1.0 404 Not Found", true, 404);
        $data['response'] = '404';
        $data['error'] = 'Content not found';

        $this->load->library('json');
        $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
    }

    protected function error401() {
        header("HTTP/1.0 401 Not Authorized", true, 401);
        $data['response'] = '401';
        $data['error'] = 'Access Not Authorized';

        $this->load->library('json');
        $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
    }

}