<?php 
class ControllerInformationContact extends Controller {
	private $error = array(); 
	    
  	public function index() {
		$this->language->load('information/contact');

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
    			$mail = new Mail();
    			$mail->protocol = $this->config->get('config_mail_protocol');
    			$mail->parameter = $this->config->get('config_mail_parameter');
    			$mail->hostname = $this->config->get('config_smtp_host');
    			$mail->username = $this->config->get('config_smtp_username');
    			$mail->password = $this->config->get('config_smtp_password');
    			$mail->port = $this->config->get('config_smtp_port');
    			$mail->timeout = $this->config->get('config_smtp_timeout');				
    			$mail->setTo($this->config->get('config_email'));
    	  		$mail->setFrom($this->request->post['email']);
    	  		$mail->setSender($this->request->post['name']);
    	  		$mail->setSubject(sprintf($this->language->get('email_subject'), $this->request->post['name']));
    	  		$mail->setText(strip_tags(html_entity_decode($this->request->post['enquiry'], ENT_QUOTES, 'UTF-8')));
          		$mail->send();
    
    	  		$this->redirect(HTTP_HOME . 'index.php?r=information/contact/success');
    	   }
        }

      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	);

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=information/contact',
        	'text'      => $this->language->get('heading_title'),
        	'separator' => $this->language->get('text_separator')
      	);	
			
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_telephone'] = $this->language->get('text_telephone');
    	$this->data['text_fax'] = $this->language->get('text_fax');

    	$this->data['entry_name'] = $this->language->get('entry_name');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');

		if (isset($this->error['name'])) {
    		$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}		
		
		if (isset($this->error['enquiry'])) {
			$this->data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$this->data['error_enquiry'] = '';
		}		
		
 		if (isset($this->error['captcha'])) {
			$this->data['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['error_captcha'] = '';
		}	

    	$this->data['button_continue'] = $this->language->get('button_continue');
    
		$this->data['action'] = HTTP_HOME . 'index.php?r=information/contact';
		$this->data['store'] = $this->config->get('config_name');
    	$this->data['address'] = nl2br($this->config->get('config_address'));
    	$this->data['telephone'] = $this->config->get('config_telephone');
    	$this->data['fax'] = $this->config->get('config_fax');
    	
		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['enquiry'])) {
			$this->data['enquiry'] = $this->request->post['enquiry'];
		} else {
			$this->data['enquiry'] = '';
		}
		
		if (isset($this->request->post['captcha'])) {
			$this->data['captcha'] = $this->request->post['captcha'];
		} else {
			$this->data['captcha'] = '';
		}		
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/information/contact.tpl')) {
			$this->template = $this->config->get('config_template') . '/information/contact.tpl';
		} else {
			$this->template = 'default/information/contact.tpl';
		}
		
		$this->children = array(
			'common/nav',
			'common/column_left',
			'common/footer',
			'common/header'
		);
		
 		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));		
  	}

  	public function success() {
		$this->language->load('information/contact');

		$this->document->title = $this->language->get('heading_title'); 

      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	);

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=information/contact',
        	'text'      => $this->language->get('heading_title'),
        	'separator' => $this->language->get('text_separator')
      	);	
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_message'] = $this->language->get('text_message');

    	$this->data['button_continue'] = $this->language->get('button_continue');

    	$this->data['continue'] = HTTP_HOME . 'index.php?r=common/home';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/common/success.tpl';
		} else {
			$this->template = 'default/common/success.tpl';
		}
		
		$this->children = array(
			'common/nav',
			'common/column_left',
			'common/footer',
			'common/header'
		);
		
 		$this->response->setOutput($this->render(true), $this->config->get('config_compression')); 
	}

	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->set('captcha',$captcha->getCode());
		
		$captcha->showImage();
	}
	
  	private function validate() {
    	if (!$this->validar->longitudMinMax($this->request->post['name'],3,32,$this->language->get('entry_name')) || (!$this->validar->esSoloTexto($this->request->post['name'],$this->language->get('entry_name')) && !$this->validar->esSinCharEspeciales($this->request->post['name'],$this->language->get('entry_name')))) {
      		$this->error['name'] = $this->language->get('error_name');
            $error = true;
    	}

		if (!$this->validar->validEmail($this->request->post['email'])) {
		      $this->error['email'] = $this->language->get('error_email');
              $error = true;
		}

    	if (!$this->validar->longitudMinMax($this->request->post['enquiry'],25,255,$this->language->get('entry_enquiry')) && !$this->validar->esSinCharEspeciales($this->request->post['enquiry'],$this->language->get('entry_enquiry'))) {
      		$this->error['enquiry'] = $this->language->get('error_enquiry');
            $error = true;
    	}
        
    	if (!$this->session->has('captcha') || $this->session->get('captcha') != $this->request->post['captcha']) {
      		$this->error['captcha'] = $this->language->get('error_captcha');
            $this->validar->custom("<li>El resultado de la ecuaci&oacute;n es incorrecto</li>");
            $error = true;
    	}
        
        $this->data['mostrarError'] = $this->validar->mostrarError();
		
		if (!$error) {
	  		return true;
		} else {
	  		return false;
		}  	  
  	}
}
