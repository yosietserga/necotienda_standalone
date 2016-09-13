<?php

class ControllerTotalCoupon extends Controller
{
    public function index()
    {
        if ($this->config->get('coupon_status')) {
            $this->load->language('total/coupon');

            if ($this->session->has('coupon')) {
                $data['coupon'] = $this->session->get('coupon');
            } else {
                $data['coupon'] = '';
            }

            $this->loadAssets();

            if ($scripts)
                $this->scripts = array_merge($this->scripts, $scripts);

            return $this->load->view('total/coupon', $data);
        }
    }

    public function coupon()
    {
        $Url = new Url($this->registry);
        $json = array();
        $this->load->auto('total/coupon');
        $this->load->auto('json');

        $coupon_info = $this->modelCoupon->getCoupon($this->request->getPost('coupon'));

        if ($coupon_info) {
            $this->session->set('coupon', $this->request->getPost('coupon'));
            $this->session->set('coupon_token', md5($this->request->getPost('coupon') . CRYPT_KEY));
            $json['redirect'] = $Url->createUrl('checkout/cart');
        } else {
            $this->session->clear('coupon');
            $json['error'] = $this->language->get('error_coupon');
        }

        $this->response->setOutput(Json::encode($json));
    }

    protected function loadAssets() {
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

        if (file_exists($cssFolder . strtolower(__CLASS__) . '.css')) {
            if ($this->config->get('config_render_css_in_file')) {
                $this->data['css'] .= file_get_contents($cssFolder . strtolower(__CLASS__) .'.css');
            } else {
                $styles[strtolower(__CLASS__) .'.css'] = array('media' => 'all', 'href' => $csspath . strtolower(__CLASS__) .'.css');
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
