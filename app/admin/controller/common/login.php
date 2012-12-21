<?php  
class ControllerCommonLogin extends Controller { 
	private $error = array();
	          
	public function index() { 
    	$this->load->language('common/login');

		$this->document->title = $this->language->get('heading_title');

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->get('ukey'))) {
			$this->redirect(Url::createAdminUrl('common/home'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            //$this->session->set('token',$this->session->get('ukey')); // esta linea esta en la lib user.php
			if (isset($this->request->post['redirect'])) {
				$this->redirect(Url::createUrl($this->request->post['redirect'],array('token'=>$this->session->get('ukey'))));
			} else {
				$this->redirect(Url::createUrl('common/home',array('token'=>$this->session->get('ukey'))));
			}
		}
		
    	$this->data['heading_title']   = $this->language->get('heading_title');
		$this->data['text_login']      = $this->language->get('text_login');
		$this->data['entry_username']  = $this->language->get('entry_username');
    	$this->data['entry_password']  = $this->language->get('entry_password');
    	$this->data['button_login']    = $this->language->get('button_login');
		
		if (!$this->session->has('ukey') || !isset($this->request->get['token']) || ($this->request->get['token'] != $this->session->get('ukey'))) {
			$this->error['warning'] = $this->language->get('error_token');
		}
		
		$this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

    	$this->data['action'] = Url::createAdminUrl('common/login');
        
        $this->setvar('username');
        $this->setvar('password');
        
		if (isset($this->request->get['r'])) {
			$route = $this->request->get['r'];
			
			unset($this->request->get['r']);
			
			if (isset($this->request->get['token'])) {
				unset($this->request->get['token']);
			}
			
			$url = '';
			
			if ($this->request->get) {
				$url = '&' . http_build_query($this->request->get);
			}
			
			$this->data['redirect'] = $route;
		} else {
			$this->data['redirect'] = '';	
		}
		
        $scripts[] = array('id'=>'login','method'=>'ready','script'=>
            "$('#form input').keydown(function(e) {
        		if (e.keyCode == 13) {
        			$('#form').submit();
        		}
        	});");
        
        $this->scripts = array_merge($scripts,$this->scripts);
		$this->template = 'common/login.tpl';
		$this->children = array(
			'common/header',
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
		
	private function validate() {
		if (!$this->user->login($this->request->post['username'], $this->request->post['password'])) {
			$this->error['warning'] = $this->language->get('error_login');
		}
        
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}  
