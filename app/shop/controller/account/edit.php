<?php
class ControllerAccountEdit extends Controller {
	private $error = array();

	public function index() {
	   if ($this->customer->isLogged() && !$this->customer->getComplete()) {  
      		$this->redirect(HTTP_HOME . 'index.php?r=account/complete_activation');
    	} elseif (!$this->customer->isLogged()) {  
      		$this->session->set('redirect',HTTP_HOME . 'index.php?r=account/edit');

			$this->redirect(HTTP_HOME . 'index.php?r=account/login');
    	}

		$this->language->load('account/edit');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('account/customer');
			  
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
                    
    			$this->model_account_customer->editCustomer($this->request->post);
    			
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
        	'href'      => HTTP_HOME . 'index.php?r=account/edit',
        	'text'      => $this->language->get('text_edit'),
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_your_details'] = $this->language->get('text_your_details');
        $this->data['text_datos_fiscales'] = $this->language->get('text_datos_fiscales');
        
        $this->data['tab_fiscales'] = $this->language->get('tab_fiscales');
		$this->data['tab_personales'] = $this->language->get('tab_personales');
        $this->data['tab_foto'] = $this->language->get('tab_foto');
    	$this->data['tab_social_media'] = $this->language->get('tab_social_media');
    	$this->data['tab_profesionales'] = $this->language->get('tab_profesionales');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
        $this->data['entry_captcha'] = $this->language->get('entry_captcha');
    	$this->data['entry_rif'] = $this->language->get('entry_rif');
    	$this->data['entry_company'] = $this->language->get('entry_company');
        $this->data['entry_nacimiento'] = $this->language->get('entry_nacimiento');
        $this->data['entry_sexo'] = $this->language->get('entry_sexo');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}
		
		if (isset($this->error['sexo'])) {
			$this->data['error_sexo'] = $this->error['sexo'];
		} else {
			$this->data['error_sexo'] = '';
		}
        
        if (isset($this->error['nacimiento'])) {
			$this->data['error_nacimiento'] = $this->error['nacimiento'];
		} else {
			$this->data['error_nacimiento'] = '';
		}
		
		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}	
        
        if (isset($this->error['captcha'])) {
			$this->data['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['error_captcha'] = '';
		}
        
        if (isset($this->error['company'])) {
			$this->data['error_company'] = $this->error['company'];
		} else {
			$this->data['error_company'] = '';
		}
        
        if (isset($this->error['rif'])) {
			$this->data['error_rif'] = $this->error['rif'];
		} else {
			$this->data['error_rif'] = '';
		}
        
        if (isset($this->error['twitter'])) {
			$this->data['error_twitter'] = $this->error['twitter'];
		} else {
			$this->data['error_twitter'] = '';
		}
        
        if (isset($this->error['facebook'])) {
			$this->data['error_facebook'] = $this->error['facebook'];
		} else {
			$this->data['error_facebook'] = '';
		}
        
        if (isset($this->error['msn'])) {
			$this->data['error_msn'] = $this->error['msn'];
		} else {
			$this->data['error_msn'] = '';
		}
        
        if (isset($this->error['gmail'])) {
			$this->data['error_gmail'] = $this->error['gmail'];
		} else {
			$this->data['error_gmail'] = '';
		}
        
        if (isset($this->error['yahoo'])) {
			$this->data['error_yahoo'] = $this->error['yahoo'];
		} else {
			$this->data['error_yahoo'] = '';
		}
        
        if (isset($this->error['skype'])) {
			$this->data['error_skype'] = $this->error['skype'];
		} else {
			$this->data['error_skype'] = '';
		}
        
        if (isset($this->error['profesion'])) {
			$this->data['error_profesion'] = $this->error['profesion'];
		} else {
			$this->data['error_profesion'] = '';
		}
        
        if (isset($this->error['titulo'])) {
			$this->data['error_titulo'] = $this->error['titulo'];
		} else {
			$this->data['error_titulo'] = '';
		}
        
        if (isset($this->error['blog'])) {
			$this->data['error_blog'] = $this->error['blog'];
		} else {
			$this->data['error_blog'] = '';
		}
        
        if (isset($this->error['website'])) {
			$this->data['error_website'] = $this->error['website'];
		} else {
			$this->data['error_website'] = '';
		}
        
		$this->data['action'] = HTTP_HOME . 'index.php?r=account/edit';
        $this->session->set('rand_k',md5(strtotime(date('Y-m-d H:i:s'))));
        $this->session->set('newfoto',"large_".$this->session->get('rand_k') . "_" . $this->customer->getId());

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}
        
        $this->setvar('firstname',$customer_info);
        $this->setvar('lastname',$customer_info);
        $this->setvar('company',$customer_info);
        $this->setvar('sexo',$customer_info);
        $this->setvar('nacimiento',$customer_info);
        $this->setvar('telephone',$customer_info);
        $this->setvar('rif',$customer_info);
        $this->setvar('twitter',$customer_info);
        $this->setvar('facebook',$customer_info);
        $this->setvar('msn',$customer_info);
        $this->setvar('gmail',$customer_info);
        $this->setvar('yahoo',$customer_info);
        $this->setvar('skype',$customer_info);
        $this->setvar('blog',$customer_info);
        $this->setvar('website',$customer_info);
        $this->setvar('profesion',$customer_info);
        $this->setvar('titulo',$customer_info);
        $this->setvar('captcha');

		$this->data['back'] = HTTP_HOME . 'index.php?r=account/account';
        
		// configuración de seguridad de javascript         
        $this->data['config_js_security'] = $this->config->get('config_js_security');
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/edit.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/edit.tpl';
		} else {
			$this->template = 'default/account/edit.tpl';
		}
        
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTP_HOME;
		} else {
			$this->data['base'] = HTTP_HOME;
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
	   // parámetros de seguridad configurables     
  	     if ($this->config->get('config_server_security')) {
        	
        	if (!$this->validar->esTelefonoGlobal($this->request->post['telephone'])) {
          		$this->error['telephone'] = $this->language->get('error_telephone');
        	}
            
            if (!$this->validar->esSinCharEspeciales($this->request->post['company'],$this->language->get('entry_company')) && !$this->validar->longitudMinMax($this->request->post['company'],3,32,$this->language->get('entry_company'))) {
          		$this->error['company'] = $this->language->get('error_company');
        	}
            
            if (!$this->validar->esRif($this->request->post['rif'])) {
          		$this->error['rif'] = $this->language->get('error_rif');
        	}    
        }
        
		if (!$this->validar->longitudMinMax($this->request->post['firstname'],3,32,$this->language->get('entry_firstname')) || (!$this->validar->esSoloTexto($this->request->post['firstname'],$this->language->get('entry_firstname')) && !$this->validar->esSinCharEspeciales($this->request->post['firstname'],$this->language->get('entry_firstname')))) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	}

    	if (!$this->validar->longitudMinMax($this->request->post['lastname'],3,32,$this->language->get('entry_lastname')) || (!$this->validar->esSoloTexto($this->request->post['lastname'],$this->language->get('entry_lastname')) && !$this->validar->esSinCharEspeciales($this->request->post['lastname'],$this->language->get('entry_lastname')))) {
      		$this->error['lastname'] = $this->language->get('error_lastname');
    	}
        
        if (!$this->validar->longitudMin($this->request->post['sexo'],1,$this->language->get('entry_sexo')))  {
      		$this->error['sexo'] = $this->language->get('error_sexo');
    	}
        
        if (!$this->validar->esMayorDeEdad($this->request->post['nacimiento'],$this->language->get('entry_nacimiento')))  {
       		$this->error['nacimiento'] = $this->language->get('error_nacimiento');
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
    
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->set('captcha',$captcha->getCode());
		
		$captcha->showImage();
	}
	
}
