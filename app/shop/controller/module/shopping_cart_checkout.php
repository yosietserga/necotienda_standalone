<?php

class ControllerModuleShoppingCartCheckout extends Module {

    protected function index($widget = null) {
        if ($this->config->get('config_store_mode') == 'store') {
            $this->language->load('module/shopping_cart_checkout');
            $this->language->load('account/register');
            $this->language->load('checkout/cart');
            
            $this->load->model('localisation/country');
            $this->load->library('image');
            $this->load->library('weight');

            $Url = new Url($this->registry);
            
            if (isset($widget)) {
                $settings = (array)unserialize($widget['settings']);
                $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
            }
            
            if (!$settings['module']) $settings['module'] = 'shopping_cart_checkout';
            
            $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

            $data['product_id'] = $this->request->hasPost('product_id') ?
                $this->request->getPost('product_id') :
                $this->request->hasQuery('product_id') ? $this->request->getQuery('product_id') : null;
            
            $data['quantity'] = $this->request->hasPost('quantity') ?
                $this->request->getPost('quantity') :
                $this->request->hasQuery('quantity') ? $this->request->getQuery('quantity') : 1;
            
            $data['option'] = $this->request->hasPost('option') ?
                $this->request->getPost('option') :
                $this->request->hasQuery('option') ? $this->request->getQuery('option') : array();

            $width = isset($settings['width']) ? $settings['width'] : $this->config->get('config_image_cart_width');
            $height = isset($settings['height']) ? $settings['height'] : $this->config->get('config_image_cart_height');
            
            if ($data['product_id']) {
                if (!is_array($data['quantity'])) {
                    $this->cart->add($data['product_id'], $data['quantity'], $data['option']);
                } else {
                    foreach ($data['quantity'] as $key => $value) {
                        $this->cart->update($key, $value);
                    }
                }
                
                $this->session->clear('shipping_methods');
                $this->session->clear('shipping_method');
                $this->session->clear('payment_methods');
                $this->session->clear('payment_method');
            }
            
            if ($this->cart->hasProducts()) {
                if (isset($this->error['warning'])) {
                    $this->data['error_warning'] = $this->error['warning'];
                } elseif (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout')) {
                    $this->data['error_warning'] = $this->language->get('error_stock');
                } else {
                    $this->data['error_warning'] = '';
                }

                $this->data['action'] = $Url::createUrl('checkout/confirm');
                
                $this->data['products'] = array();
                
                foreach ($this->cart->getProducts() as $result) {
                    $option_data = array();

                    foreach ($result['option'] as $option) {
                        $option_data[] = array(
                            'name' => $option['name'],
                            'value' => $option['value']
                        );
                    }
                    
                    if ($result['image']) {
                        $image = $result['image'];
                    } else {
                        $image = 'no_image.jpg';
                    }
                    
                    $this->data['products'][] = array(
                        'key' => $result['key'],
                        'product_id' => $result['key'],
                        'name' => $result['name'],
                        'model' => $result['model'],
                        'thumb' => NTImage::resizeAndSave($image, $width, $height),
                        'image' => HTTP_IMAGE . $image,
                        'option' => $option_data,
                        'attributes' => $result['attributes'],
                        'quantity' => $result['quantity'],
                        'stock' => $result['stock'],
                        'price' => $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))),
                        'total' => $this->currency->format($this->tax->calculate($result['total'], $result['tax_class_id'], $this->config->get('config_tax'))),
                        'href' => $Url::createUrl("store/product", array("product_id" => $result['product_id']))
                    );
                }
                
                $this->data['display_price'] = ($this->config->get('config_store_mode') == 'store' && (!$this->config->get('config_customer_price') || $this->customer->isLogged()));

                if ($this->config->get('config_cart_weight')) {
                    $this->data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class'));
                } else {
                    $this->data['weight'] = false;
                }

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

                if ($this->session->has('message')) {
                    $this->data['message'] = $this->session->get('message');
                    $this->session->clear('message');
                }
                
                $this->data['countries'] = $this->modelCountry->getCountries();
                
                if ($this->customer->isLogged()) {
                    $this->data['email'] = $this->customer->getEmail();
                    $this->data['firstname'] = $this->customer->getFirstName();
                    $this->data['lastname'] = $this->customer->getLastName();
                    $this->data['company'] = $this->customer->getCompany();
                    $this->data['telephone'] = $this->customer->getTelephone();
                    $this->data['rif_type'] = substr($this->customer->getRif(), 0, 1);
                    $this->data['rif'] = substr($this->customer->getRif(), 1);
                    $this->data['riff'] = $this->customer->getRif();
                    $this->data['isLogged'] = $this->customer->isLogged();
                    
                    $this->load->auto('account/address');
                    $address = $this->modelAddress->getAddress($this->customer->getAddressId());
                    if ($address) {
                        $this->data['payment_country_id'] = $address['country_id'];
                        $this->data['payment_zone_id'] = $address['zone_id'];
                        $this->data['payment_city'] = $address['city'];
                        $this->data['payment_street'] = $address['street'];
                        $this->data['payment_address_1'] = $address['address_1'];
                        $this->data['payment_postcode'] = $address['postcode'];
                        $this->data['payment_address'] = $address['address_1'] . " " . $address['street'] . ", " . $address['city'] . ". " . $address['zone'] . " - " . $address['country'];
                        $this->session->set('payment_address_id', $this->customer->getAddressId());
                        

                        $this->data['shipping_country_id'] = $address['country_id'];
                        $this->data['shipping_zone_id'] = $address['zone_id'];
                        $this->data['shipping_city'] = $address['city'];
                        $this->data['shipping_street'] = $address['street'];
                        $this->data['shipping_address_1'] = $address['address_1'];
                        $this->data['shipping_postcode'] = $address['postcode'];
                        $this->data['shipping_address'] = $address['address_1'] . " " . $address['street'] . ", " . $address['city'] . ". " . $address['zone'] . " - " . $address['country'];
                        $this->session->set('shipping_address_id', $this->customer->getAddressId());
                    } else {
                        $this->data['no_address'] = true;
                    }
                    
                    $this->tax->setZone($address['country_id'], $address['zone_id']);
                } else {
                    $this->tax->setZone($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
                }
                
                /* ****************** shipping methods ********************** */
                $quote_data = array();
                $results = $this->modelExtension->getExtensions('shipping');
                foreach ($results as $result) {
                    $this->load->model('shipping/' . $result['key']);

                    $quote = $this->{'model_shipping_' . $result['key']}->getQuote($address);

                    if ($quote) {
                        $quote_data[$result['key']] = array(
                            'title' => $quote['title'],
                            'quote' => $quote['quote'],
                            'sort_order' => $quote['sort_order'],
                            'error' => $quote['error']
                        );
                    }
                }
                
                $sort_order = array();

                foreach ($quote_data as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $quote_data);
                
                $this->session->set('shipping_methods', $quote_data);
                $this->data['shipping_methods'] = $quote_data;

                // javascript files
                $jspath = defined("CDN_JS") ? CDN_JS : HTTP_JS;
                $javascripts["neco.form.js"] = $jspath . "necojs/neco.form.js";
                $javascripts["neco.wizard.js"] = $jspath . "necojs/neco.wizard.js";
                $javascripts["jquery-ui.min.js"] = $jspath . "vendor/jquery-ui.min.js";
                $this->javascripts = array_merge($this->javascripts, $javascripts);
                
                // style files
                $csspath = defined("CDN") ? CDN . CSS : HTTP_CSS;
                $styles['jquery-ui/jquery-ui.min.css'] = array('media' => 'all', 'href' => $csspath . 'jquery-ui/jquery-ui.min.css');
                $styles['neco.form.css'] = array('media' => 'all', 'href' => $csspath . 'neco.form.css');
                $styles['neco.wizard.css'] = array('media' => 'all', 'href' => $csspath . 'neco.wizard.css');
                $this->styles = array_merge($this->styles, $styles);
            }

            $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
            $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
            $this->loadWidgetAssets($filename);
            
            $this->data['settings'] = $settings;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/shopping_cart_checkout.tpl')) {
                $this->template = $this->config->get('config_template') . '/module/shopping_cart_checkout.tpl';
            } else {
                $this->template = 'cuyagua/module/shopping_cart_checkout.tpl';
            }
            
            $this->id = 'shopping_cart_checkout';
            $this->render();
        }
    }
}
