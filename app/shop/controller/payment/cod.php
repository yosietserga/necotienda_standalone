<?php
class ControllerPaymentCod extends Controller {
	protected function index() {
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['continue'] = HTTP_HOME . 'index.php?route=checkout/success';

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['back'] = HTTP_HOME . 'index.php?route=checkout/payment';
		} else {
			$this->data['back'] = HTTP_HOME . 'index.php?route=checkout/guest_step_2';
		}
		
		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/cod.tpl')) {
			$this->template = $this->config->get('config_template') . '/payment/cod.tpl';
		} else {
			$this->template = 'cuyagua/payment/cod.tpl';
		}	
		
		$this->render();
	}
	
	public function confirm() {
		$this->load->model('checkout/order');
		
		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
	}
}
?>