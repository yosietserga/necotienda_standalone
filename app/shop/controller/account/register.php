<?php 
class ControllerAccountRegister extends Controller {
	private $error = array();
	      
  	public function index() {
  	 if ($this->customer->isLogged() && !$this->customer->getComplete()) {  
      		$this->redirect(HTTP_HOME . 'index.php?r=account/complete_activation');
    	} elseif ($this->customer->isLogged()) {  
      		$this->redirect(HTTP_HOME . 'index.php?r=account/account');
    	}
        
    	$this->language->load('account/register');
		
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('account/customer');
		
        // evitando ataques xsrf y xss
        $fid = ($this->session->has('fid')) ? $this->session->get('fid') : strtotime(date('d-m-Y h:i:s'));$this->session->set('fid',$fid);
        $fkey = $this->fkey . "." . $this->session->get('fid') . "_" . str_replace('/','-',$_GET['r']);
        $this->data['fkey'] = "<input type='hidden' name='fkey' id='fkey' value='$fkey' />";
        
    	if (($this->request->server['REQUEST_METHOD'] == 'POST' ) && $this->validate()) {
    	   echo "<script>alert('".__LINE__."')</script>";
            $route = str_replace("-","/",substr($_POST['fkey'],strrpos($_POST['fkey'],"_")+1)); // verificamos que la ruta pertenece a este formulario
            $fid = substr($_POST['fkey'],strpos($_POST['fkey'],".")+1,10); // verificamos que id del formulario es correcto
            $date = substr($this->fkey,strpos($this->fkey,"_")+1,10); // verificamos que la fecha es de hoy
            if (($this->session->get('fkey')==$this->fkey) && ($route==$_GET['r']) && ($fid==$this->session->get('fid')) && ($date==strtotime(date('d-m-Y')))) { // validamos el id de sesión para evitar ataques csrf
                $this->session->clear('fid');
                
                $this->request->post['rif'] = $this->request->post['riftype'] . $this->request->post['rif'];
    			$result = $this->model_account_customer->addCustomer($this->request->post);
                if ($result == 1) {
                    $this->session->clear('guest');
                    
        			$this->language->load('mail/account_create');
        			
        			$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
        			
        			$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";
        			
        			if (!$this->config->get('config_customer_approval')) {
        				$message .= $this->language->get('text_login') . "\n";
        			} else {
        				$message .= $this->language->get('text_approval') . "\n";
        			}
        			
        			$message .= HTTP_HOME . 'index.php?r=account/login&user='.$this->request->post['email'] .'&password='.md5($this->request->post['password']).'&codigo='.md5($this->request->post['codigo'])."\n\n";
        			$message .= $this->language->get('text_services') . "\n\n";
        			$message .= $this->language->get('text_thanks') . "\n";
        			$message .= $this->config->get('config_name');
        			
        			$mail = new Mail();
        			$mail->protocol = "mail";
        			$mail->hostname = $this->config->get('config_smtp_host');
        			$mail->username = $this->config->get('config_smtp_username');
        			$mail->password = $this->config->get('config_smtp_password');
        			$mail->port = $this->config->get('config_smtp_port');
        			$mail->timeout = $this->config->get('config_smtp_timeout');				
        			$mail->setTo($this->request->post['email']);
        	  		$mail->setFrom($this->config->get('config_email'));
        	  		$mail->setSender($this->config->get('config_name'));
        	  		$mail->setSubject($subject);
        			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
              		$mail->send();
        	  	  
        	  		$this->redirect(HTTP_HOME . 'index.php?r=account/success');
                } else {
                    $this->validar->custom($result); 
                    $this->data['mostrarError'] = $this->validar->mostrarError();
                }
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
        	'href'      => HTTP_HOME . 'index.php?r=account/register',
        	'text'      => $this->language->get('text_create'),
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select'] = $this->language->get('text_select');
    	$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), HTTP_HOME . 'index.php?r=account/login');
    	$this->data['text_your_details'] = $this->language->get('text_your_details');
    	$this->data['text_your_address'] = $this->language->get('text_your_address');
    	$this->data['text_your_password'] = $this->language->get('text_your_password');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_datos_fiscales'] = $this->language->get('text_datos_fiscales');
				
    	$this->data['entry_firstname'] = $this->language->get('entry_firstname');
    	$this->data['entry_lastname'] = $this->language->get('entry_lastname');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
    	$this->data['entry_fax'] = $this->language->get('entry_fax');
    	$this->data['entry_company'] = $this->language->get('entry_company');
    	$this->data['entry_address_1'] = $this->language->get('entry_address_1');
    	$this->data['entry_address_2'] = $this->language->get('entry_address_2');
    	$this->data['entry_postcode'] = $this->language->get('entry_postcode');
    	$this->data['entry_city'] = $this->language->get('entry_city');
    	$this->data['entry_country'] = $this->language->get('entry_country');
    	$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
    	$this->data['entry_password'] = $this->language->get('entry_password');
    	$this->data['entry_rif'] = $this->language->get('entry_rif');
    	$this->data['entry_razon_social'] = $this->language->get('entry_razon_social');
    	$this->data['entry_confirm'] = $this->language->get('entry_confirm');
        $this->data['entry_captcha'] = $this->language->get('entry_captcha');
        $this->data['entry_nacimiento'] = $this->language->get('entry_nacimiento');
        $this->data['entry_sexo'] = $this->language->get('entry_sexo');

		$this->data['button_continue'] = $this->language->get('button_continue');
        
    	$this->data['action'] = HTTP_HOME . 'index.php?r=account/register';
        
        $this->data['error_warning']    = isset($this->error['warning']) ? $this->error['warning'] : "";
        $this->data['error_email']      = isset($this->error['email']) ? $this->error['email'] : "";
        $this->data['error_company']    = isset($this->error['company']) ? $this->error['company'] : "";
        $this->data['error_rif']        = isset($this->error['rif']) ? $this->error['rif'] : "";
        $this->data['error_password']   = isset($this->error['password']) ? $this->error['password'] : "";
        $this->data['error_confirm']    = isset($this->error['confirm']) ? $this->error['confirm'] : "";
        $this->data['error_captcha']    = isset($this->error['captcha']) ? $this->error['captcha'] : "";
        $this->data['error_recaptcha']    = isset($this->error['recaptcha']) ? $this->error['recaptcha'] : null;

        $this->setvar('company');
        $this->setvar('rif');
        $this->setvar('email');
        $this->setvar('password');
        $this->setvar('confirm');
        $this->setvar('recaptcha_challenge_field');
        $this->setvar('recaptcha_response_field');
        $this->setvar('agree');
        
        $this->data['recaptcha'] = $this->recaptcha->getHtml($this->data['error_recaptcha']);
        
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			
			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), HTTP_HOME . 'index.php?r=information/information&information_id=' . $this->config->get('config_account_id'), $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}
		
        // javascript files
        if ($this->config->get('config_js_security')) {
            $jspath = defined("CDN") ? CDN.JS : CATALOG.JS;
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
    		  $jspath = str_replace("%theme%",$this->config->get('config_template'),$jspath);
    		} else {
    		  $jspath = str_replace("%theme%","default",$jspath);
    		}
            $javascripts = array(
                $jspath."account_create.js",
            );
            $this->data['javascripts'] = $this->javascripts = array_merge($javascripts,$this->javascripts);
        }
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/register.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/register.tpl';
		} else {
			$this->template = 'default/account/register.tpl';
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

  	private function validate() {
  	 // parámetros de seguridad configurables     
  	     if ($this->config->get('config_server_security')) {
        	
            if (!$this->validar->esSinCharEspeciales($this->request->post['company'],$this->language->get('entry_company')) && !$this->validar->longitudMinMax($this->request->post['company'],3,32,$this->language->get('entry_company'))) {
          		$this->error['company'] = $this->language->get('error_company');
        	}
            
            if (!$this->validar->esSoloNumeros($this->request->post['rif'])) {
          		$this->error['rif'] = $this->language->get('error_rif');
        	}    
        }
        
  		if (!$this->validar->validEmail($this->request->post['email'])) {
            $this->error['email'] = $this->language->get('error_email');
  		}            


    	if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
      		$this->error['warning'] = $this->language->get('error_exists');
    	}
		
        
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
            $this->validar->custom("<li>La confirmaci&oacute;n de la contrase&ntilde;a no coincide</li>");
    	}
		
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			
			if ($information_info) {
    			if (!isset($this->request->post['agree'])) {
      				$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
                    $this->validar->custom("<li>Debe leer y aceptar los <b>T&eacute;rminos Legales</b></li>");
    			}
			}
		}
        
        $rc = $this->recaptcha->checkAnswer($this->request->post['recaptcha_challenge_field'],$this->request->post['recaptcha_response_field']);
        
        if (!$rc) {
            $this->error['recaptcha'] = $this->language->get('error_recaptcha');
            $this->validar->custom("<li>Debe ingresar las frases de la imagen</b></li>");
        }

        $this->data['mostrarError'] = $this->validar->mostrarError();
        
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}
    
    public function checkemail() {
        $this->load->model("account/customer");
        if (!isset($this->request->post['email'])) {echo 0;}
        $result = $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email']);
        echo ($result) ? 1 : 0;
    }
    
    public function register() {
        if (!$this->customer->islogged()) {
            $this->load->model("account/customer");
            $this->request->post['rif'] = $this->request->post['riftype'] . $this->request->post['rif'];
            $this->request->post['password'] = substr(md5(rand(11111111,99999999)),0,8);
            
            $result = $this->model_account_customer->addCustomer($this->request->post);
            if ($result == 1) {
                $this->customer->login($this->request->post['email'], $this->request->post['password']);
                $this->session->clear('guest');
                $message = $this->modelInformation->getInformation($this->config->get('config_email_register_customer'));
                //TODO: replace custom meta tags for customer fields
                //TODO: send email
            }
        }
    }
    
  	public function zone() {
		$output = '<option value="false">' . $this->language->get('text_select') . '</option>';
		$this->load->model('localisation/zone');
    	$results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);
      	foreach ($results as $result) {
        	$output .= '<option value="' . $result['zone_id'] . '"';
	    	if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
	      		$output .= ' selected="selected"';
	    	}
	    	$output .= '>' . $result['name'] . '</option>';
    	} 
		
		if (!$results) {
			if (!$this->request->get['zone_id']) {
		  		$output .= '<option value="0" selected="selected">' . $this->language->get('text_none') . '</option>';
			} else {
				$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
			}
		}
	
		$this->response->setOutput($output, $this->config->get('config_compression'));
  	}  
}
