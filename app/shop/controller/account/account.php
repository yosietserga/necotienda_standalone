<?php 
class ControllerAccountAccount extends Controller { 
	public function index() {
	   if (!$this->customer->isLogged()) {  
      		$this->session->set('redirect',Url::createUrl("account/account"));
	  		$this->redirect(Url::createUrl("account/login"));
    	}
	
		$this->language->load('account/account');

      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => Url::createUrl("common/home"),
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => Url::createUrl("account/account"),
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);

		$this->document->title = $this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
    	$this->data['text_information'] = $this->language->get('text_information');
    	$this->data['text_password'] = $this->language->get('text_password');
    	$this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_history'] = $this->language->get('text_history');
    	$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_cancel_account'] = $this->language->get('text_cancel_account');
		$this->data['text_balance'] = $this->language->get('text_balance');
		$this->data['text_social_networks'] = $this->language->get('text_social_networks');
		$this->data['text_hobbies'] = $this->language->get('text_hobbies');
		$this->data['text_my_activities'] = $this->language->get('text_my_activities');
		$this->data['text_messages'] = $this->language->get('text_messages');
		$this->data['text_profile'] = $this->language->get('text_profile');
		$this->data['text_payments'] = $this->language->get('text_payments');

		if ($this->session->has('success')) {
    		$this->data['success'] = $this->session->get('success');
			$this->session->clear('success');
		} else {
			$this->data['success'] = '';
		}

        $this->data['Url'] = new Url($this->registry);
		
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/account.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/account.tpl';
		} else {
			$this->template = 'cuyagua/account/account.tpl';
		}
		
		$this->children = array(
			'common/nav',
			'account/column_left',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));		
  	}
}
