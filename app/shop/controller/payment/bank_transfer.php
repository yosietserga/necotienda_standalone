<?php
class ControllerPaymentBankTransfer extends Controller {
	protected function index() {
		$this->language->load('payment/bank_transfer');
		$this->data['instructions'] = nl2br($this->config->get('bank_transfer_bank_' . $this->config->get('config_language_id')));

		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/bank_transfer.tpl')) {
			$this->template = $this->config->get('config_template') . '/payment/bank_transfer.tpl';
		} else {
			$this->template = 'cuyagua/payment/bank_transfer.tpl';
		}	
		
		$this->render(); 
	}
	
	public function confirm() {
		$this->language->load('payment/bank_transfer');
		
		$this->load->model('checkout/order');
		
		$comment  = $this->language->get('text_instruction') . "\n\n";
		$comment .= $this->config->get('bank_transfer_bank_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->language->get('text_payment');
		
		$this->modelOrder->confirm($this->session->get('order_id'), $this->config->get('bank_transfer_order_status_id'), $comment);
	}
}
