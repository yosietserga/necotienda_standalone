<?php

class ControllerPaymentBluePayHostedForm extends Controller {

	public function index() {
		$this->load->language('payment/bluepay_hosted');
		$this->load->model('checkout/order');
		$this->load->model('payment/bluepay_hosted');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$data['ORDER_ID'] = $this->session->data['order_id'];
		$data['NAME1'] = $order_info['payment_firstname'];
		$data['NAME2'] = $order_info['payment_lastname'];
		$data['ADDR1'] = $order_info['payment_address_1'];
		$data['ADDR2'] = $order_info['payment_address_2'];
		$data['CITY'] = $order_info['payment_city'];
		$data['STATE'] = $order_info['payment_zone'];
		$data['ZIPCODE'] = $order_info['payment_postcode'];
		$data['COUNTRY'] = $order_info['payment_country'];
		$data['PHONE'] = $order_info['telephone'];
		$data['EMAIL'] = $order_info['email'];

		$data['SHPF_FORM_ID'] = 'opencart01';
		$data['DBA'] = $this->config->get('bluepay_hosted_account_name');
		$data['MERCHANT'] = $this->config->get('bluepay_hosted_account_id');
		$data['SHPF_ACCOUNT_ID'] = $this->config->get('bluepay_hosted_account_id');
		$data["TRANSACTION_TYPE"] = $this->config->get('bluepay_hosted_transaction');
		$data["MODE"] = strtoupper($this->config->get('bluepay_hosted_test'));

		$data['CARD_TYPES'] = 'vi-mc';

		if ($this->config->get('bluepay_hosted_discover') == 1) {
			$data['CARD_TYPES'] .= '-di';
		}

		if ($this->config->get('bluepay_hosted_amex') == 1) {
			$data['CARD_TYPES'] .= '-am';
		}

		$data["AMOUNT"] = $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);
		$data['APPROVED_URL'] = $this->url->link('payment/bluepay_hosted/callback', '', 'SSL');
		$data['DECLINED_URL'] = $this->url->link('payment/bluepay_hosted/callback', '', 'SSL');
		$data['MISSING_URL'] = $this->url->link('payment/bluepay_hosted/callback', '', 'SSL');
		$data['REDIRECT_URL'] = $this->url->link('payment/bluepay_hosted/callback', '', 'SSL');

		$data['TPS_DEF'] = "MERCHANT APPROVED_URL DECLINED_URL MISSING_URL MODE TRANSACTION_TYPE TPS_DEF AMOUNT";
		$data['TAMPER_PROOF_SEAL'] = md5($this->config->get('bluepay_hosted_secret_key') . $data['MERCHANT'] . $data['APPROVED_URL'] . $data['DECLINED_URL'] . $data['MISSING_URL'] . $data['MODE'] . $data['TRANSACTION_TYPE'] . $data['TPS_DEF'] . $data['AMOUNT']);

		$data['SHPF_TPS_DEF'] = "SHPF_FORM_ID SHPF_ACCOUNT_ID DBA TAMPER_PROOF_SEAL CARD_TYPES TPS_DEF SHPF_TPS_DEF AMOUNT";
		$data['SHPF_TPS'] = md5($this->config->get('bluepay_hosted_secret_key') . $data['SHPF_FORM_ID'] . $data['SHPF_ACCOUNT_ID'] . $data['DBA'] . $data['TAMPER_PROOF_SEAL'] . $data['CARD_TYPES'] . $data['TPS_DEF'] . $data['SHPF_TPS_DEF'] . $data['AMOUNT']);

		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['text_loading'] = $this->language->get('text_loading');

		$this->loadAssets();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/bluepay_hosted.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/bluepay_hosted.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/bluepay_hosted.tpl', $data);
		}
	}

	public function callback() {
		$this->load->language('payment/bluepay_hosted');

		$this->load->model('checkout/order');

		$this->load->model('payment/bluepay_hosted');

		$response_data = $this->request->get;

		if (isset($this->session->data['order_id'])) {
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

			if ($response_data['Result'] == 'APPROVED') {
				$bluepay_hosted_order_id = $this->model_payment_bluepay_hosted->addOrder($order_info, $response_data);

				$this->model_payment_bluepay_hosted->addTransaction($bluepay_hosted_order_id, $this->config->get('bluepay_hosted_transaction'), $order_info);

				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('bluepay_hosted_order_status_id'));

				$this->response->redirect($this->url->link('checkout/success', '', 'SSL'));
			} else {
				$this->session->data['error'] = $response_data['Result'] . ' : ' . $response_data['MESSAGE'];

				$this->response->redirect($this->url->link('checkout/checkout', '', 'SSL'));
			}
		} else {
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
	}

	public function adminCallback() {
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($this->request->get));
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