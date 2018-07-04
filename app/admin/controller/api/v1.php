<?php

class ControllerApiV1 extends Controller {

    //localisation
    public function countries() { $this->proxy('countries'); }
    public function languages() { $this->proxy('languages'); }
    public function currencies() { $this->proxy('currencies'); }
    public function zones() { $this->proxy('zones'); }
    public function geo_zones() { $this->proxy('geo_zones'); }
    public function tax_classes() { $this->proxy('tax_classes'); }
    public function weight_classes() { $this->proxy('weight_classes'); }
    public function length_classes() { $this->proxy('length_classes'); }
    public function order_statuses() { $this->proxy('order_statuses'); }
    public function payment_statuses() { $this->proxy('payment_statuses'); }
    public function stock_statuses() { $this->proxy('stock_statuses'); }

    //content
    public function banners() { $this->proxy('banners'); }
    public function files() { $this->proxy('files'); }
    public function menus() { $this->proxy('menus'); }
    public function pages() { $this->proxy('pages'); }
    public function posts() { $this->proxy('posts'); }
    public function post_categories() { $this->proxy('post_categories'); }

    //marketing
    public function bounces() { $this->proxy('bounces'); }
    public function campaigns() { $this->proxy('campaigns'); }
    public function contacts() { $this->proxy('contacts'); }
    public function contact_lists() { $this->proxy('contact_lists'); }
    public function mailservers() { $this->proxy('mailservers'); }
    public function messages() { $this->proxy('messages'); }
    public function newsletters() { $this->proxy('newsletters'); }

    //sale
    public function balances() { $this->proxy('balances'); }
    public function banks() { $this->proxy('banks'); }
    public function bank_accounts() { $this->proxy('bank_accounts'); }
    public function coupons() { $this->proxy('coupons'); }
    public function customers() { $this->proxy('customers'); }
    public function customer_groups() { $this->proxy('customer_groups'); }
    public function orders() { $this->proxy('orders'); }
    public function payments() { $this->proxy('payments'); }

    //store
    public function attributes() { $this->proxy('attributes'); }
    public function categories() { $this->proxy('categories'); }
    public function downloads() { $this->proxy('downloads'); }
    public function manufacturers() { $this->proxy('manufacturers'); }
    public function products() { $this->proxy('products'); }
    public function reviews() { $this->proxy('reviews'); }
    public function stores() { $this->proxy('stores'); }

    //style
    public function templates() { $this->proxy('templates'); }
    public function template_files() { $this->proxy('template_files'); }
    public function themes() { $this->proxy('themes'); }
    public function views() { $this->proxy('views'); }
    public function widgets() { $this->proxy('widgets'); }

    //user
    public function users() { $this->proxy('users'); }
    public function user_groups() { $this->proxy('user_groups'); }


    private function prepareData($object, $data) {
        require("v1.0.0/{$object}_data.php");
        return $return;
    }

    private function proxy($object) {
        if (!$this->validateTokens()) {
            $this->error503();
            return;
        }

        require("v1.0.0/{$object}.php");
        $this->response->setOutput(Json::encode($return), $this->config->get('config_compression'));
    }

    private function validateTokens() {
        //TODO: check public and private API keys, tokens, expiry time, access level, license, premium member, etc.
        return true;
    }

    private function error503() {
        header("HTTP/1.0 503 Prohibited Access", true, 503);
        $this->load->auto('json');
        $return = array();

        $return['status'] = array(
            'code'=>503,
            'message'=>'PROHIBITED ACCESS'
        );

        $return['error'] = array(
            'code'=>503,
            'message'=>'HTTP 503: Prohibited Access'
        );

        $this->response->setOutput(Json::encode($return), $this->config->get('config_compression'));
    }

    private function error404() {
        header("HTTP/1.0 404 Not Found", true, 404);
        $this->load->auto('json');
        $return = array();

        $return['status'] = array(
            'code'=>404,
            'message'=>'PAGE NOT FOUND'
        );

        $return['error'] = array(
            'code'=>404,
            'message'=>'HTTP 404: Page Not Found'
        );

        $this->response->setOutput(Json::encode($return), $this->config->get('config_compression'));
    }
}