<?php
class ControllerAccountPassword extends Controller {
	private $error = array();
	     
  	public function index() {	
    	if ($this->customer->isLogged() && !$this->customer->getComplete()) {  
      		$this->redirect(HTTP_HOME . 'index.php?r=account/complete_activation');
    	} elseif (!$this->customer->isLogged()) {
      		$this->session->set('redirect',HTTP_HOME . 'index.php?r=account/password');

      		$this->redirect(HTTP_HOME . 'index.php?r=account/login');
    	}

		$this->language->load('account/password');

    	$this->document->title = $this->language->get('heading_title');
			  
        // evitando ataques xsrf y xss
        $fid = ($this->session->has('fid')) ? $this->session->get('fid') : strtotime(date('d-m-Y h:i:s'));$this->session->set('fid',$fid);
        $fkey = $this->fkey . "." . $this->session->get('fid') . "_" . str_replace('/','-',$_GET['r']);
        $this->data['fkey'] = "<input type='hidden' name='fkey' id='fkey' value='$fkey' />";
            
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
    	   $route = str_replace("-","/",substr($_POST['fkey'],strrpos($_POST['fkey'],"_")+1)); // verificamos que la ruta pertenece a este formulario
            $fid = substr($_POST['fkey'],strpos($_POST['fkey'],".")+1,10); // verificamos que id del formulario es correcto
            $date = substr($this->fkey,strpos($this->fkey,"_")+1,10); // verificamos que la fecha es de hoy
            if (($this->session->get('fkey')==$this->fkey) && ($route==$_GET['r']) && ($fid==$this->session->get('fid')) && ($date==strtotime(date('d-m-Y')))) { // validamos el id de sesión para evitar ataques csrf
                $this->session->clear('fid');
                    
    			$this->load->model('account/customer');
    			
    			$this->model_account_customer->editPassword($this->customer->getEmail(), $this->request->post['password']);
     
          		$this->session->set('success',$this->language->get('text_success'));
    	  
    	  		$this->redirect(HTTP_HOME . 'index.php?r=account/account');
    	   }
        }

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
        	'href'      => HTTP_HOME . 'index.php?r=account/password',
        	'text'      => $this->language->get('heading_title'),
        	'separator' => $this->language->get('text_separator')
      	);
			
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_password'] = $this->language->get('text_password');

    	$this->data['entry_password'] = $this->language->get('entry_password');
    	$this->data['entry_confirm'] = $this->language->get('entry_confirm');
        $this->data['entry_captcha'] = $this->language->get('entry_captcha');

    	$this->data['button_continue'] = $this->language->get('button_continue');
    	$this->data['button_back'] = $this->language->get('button_back');
    	
		if (isset($this->error['password'])) { 
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) { 
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}
        
        if (isset($this->error['captcha'])) {
			$this->data['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['error_captcha'] = '';
		}
	
    	$this->data['action'] = HTTP_HOME . 'index.php?r=account/password';
		
		if (isset($this->request->post['password'])) {
    		$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
    		$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}
        
        if (isset($this->request->post['captcha'])) {
			$this->data['captcha'] = $this->request->post['captcha'];
		} else {
			$this->data['captcha'] = '';
		}
        
    	$this->data['back'] = HTTP_HOME . 'index.php?r=account/account';

		// configuración de seguridad de javascript         
        $this->data['config_password_security'] = $this->config->get('config_js_security');
       
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/password.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/password.tpl';
		} else {
			$this->template = 'default/account/password.tpl';
		}
		
		$this->children = array(
			'common/nav',
			'common/column_left',
			'common/footer',
			'common/header'
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));				
  	}
  
  	private function validate() {
        // configuración de requerimientos de la contraseña
        if ($this->config->get('config_password_security')) {
            if (!$this->validar->esPassword($this->request->post['password'])) {
          		$this->error['password'] = $this->language->get('error_password');
        	}
        }    	
        
        if (!$this->validar->longitudMin($this->request->post['password'],6,$this->language->get('entry_password'))) {
      		$this->error['password'] = $this->language->get('error_password');
       	}

    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = $this->language->get('error_confirm');
    	}  
        
        if ($this->session->get('skey') != $this->customer->skey) {
      		$this->error['skey'] = true;
            $this->validar->custom("<li>Se ha detectado un ataque a la seguridad del sistema. Se han deshabilitado algunas funciones y se est&aacute; rastreando su direcci&oacute;n IP</li>");
    	}
        
        if (!$this->session->has('captcha') || $this->session->get('captcha') != $this->request->post['captcha']) {
      		$this->error['captcha'] = $this->language->get('error_captcha');
            $this->validar->custom("<li>El resultado de la ecuaci&oacute;n es incorrecto</li>");
    	}
        
        $this->data['mostrarError'] = $this->validar->mostrarError();
	
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
}
