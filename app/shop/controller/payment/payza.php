<?php

class ControllerPaymentPayza extends Controller {

	public function index() {
		$data['button_confirm'] = $this->language->get('button_confirm');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$data['action'] = 'https://secure.payza.com/checkout';

		$data['ap_merchant'] = $this->config->get('payza_merchant');
		$data['ap_amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
		$data['ap_currency'] = $order_info['currency_code'];
		$data['ap_purchasetype'] = 'Item';
		$data['ap_itemname'] = $this->config->get('config_name') . ' - #' . $this->session->data['order_id'];
		$data['ap_itemcode'] = $this->session->data['order_id'];
		$data['ap_returnurl'] = $this->url->link('checkout/success');
		$data['ap_cancelurl'] = $this->url->link('checkout/checkout', '', 'SSL');

		$this->loadAssets();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/payza.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/payza.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/payza.tpl', $data);
		}
	}

	public function callback() {
		if (isset($this->request->post['ap_securitycode']) && ($this->request->post['ap_securitycode'] == $this->config->get('payza_security'))) {
			$this->load->model('checkout/order');

			$this->model_checkout_order->addOrderHistory($this->request->post['ap_itemcode'], $this->config->get('payza_order_status_id'));
		}
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