<?php 
class ControllerAccountSuccess extends Controller {  
	public function index() {
    	$this->language->load('account/success');
  
    	$this->document->title = $this->language->get('heading_title');

		$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=account/account',
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=account/success',
        	'text'      => $this->language->get('text_success'),
        	'separator' => $this->language->get('text_separator')
      	);

    	$this->data['heading_title'] = $this->language->get('heading_title');

		if (!$this->config->get('config_customer_approval')) {
    		$this->data['text_message'] = sprintf($this->language->get('text_message'), HTTP_HOME . 'index.php?r=information/contact');
		} else {
			$this->data['text_message'] = sprintf($this->language->get('text_approval'), $this->config->get('config_name'), HTTP_HOME . 'index.php?r=information/contact');
		}
		
    	$this->data['button_continue'] = $this->language->get('button_continue');
		
		if ($this->cart->hasProducts()) {
			$this->data['continue'] = HTTP_HOME . 'index.php?r=checkout/cart';
		} else {
			$this->data['continue'] = HTTP_HOME . 'index.php?r=account/account';
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/common/success.tpl';
		} else {
			$this->template = 'default/common/success.tpl';
		}
		
		$this->children = array(
			'common/nav',
			'common/column_left',
			'common/column_right',
			'common/footer',
			'common/header'
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));				
  	}
}
