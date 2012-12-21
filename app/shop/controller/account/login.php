<?php 
class ControllerAccountLogin extends Controller {
	private $error = array();
	
	public function index() {
	   if ($this->customer->isLogged() && !$this->customer->getComplete()) {  
      		$this->redirect(HTTP_HOME . 'index.php?r=account/complete_activation');
    	} elseif ($this->customer->isLogged()) {  
      		$this->redirect(HTTP_HOME . 'index.php?r=account/account');
    	}
        
        $this->activarUser();
        
        
    	$this->language->load('account/login');

    	$this->document->title = $this->language->get('heading_title');
        
        
        // evitando ataques xsrf y xss
        $fid = ($this->session->has('fid')) ? $this->session->get('fid') : strtotime(date('d-m-Y h:i:s'));$this->session->set('fid',$fid);
        $fkey = $this->fkey . "." . $this->session->get('fid') . "_" . str_replace('/','-',$_GET['r']);
        $this->data['fkey'] = "<input type='hidden' name='formkey' value='$fkey' />";
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            if (isset($this->request->post['account'])) {
                $this->session->set('account',$this->request->post['account']);
    				
    			if ($this->request->post['account'] == 'guest') {
    				$this->redirect(HTTP_HOME . 'index.php?r=checkout/guest_step_1');
    			}
  			}
            if (isset($this->request->post['email']) && isset($this->request->post['password']) && $this->validate()) {
            $route = str_replace("-","/",substr($_POST['formkey'],strrpos($_POST['formkey'],"_")+1)); // verificamos que la ruta pertenece a este formulario
            $fid = substr($_POST['formkey'],strpos($_POST['formkey'],".")+1,10); // verificamos que id del formulario es correcto
            $date = substr($this->fkey,strpos($this->fkey,"_")+1,10); // verificamos que la fecha es de hoy
            
            if (($this->session->get('fkey')==$this->fkey) && ($route==$_GET['r']) && ($fid==$this->session->get('fid')) && ($date==strtotime(date('d-m-Y')))) { // validamos el id de sesi?n para evitar ataques csrf
                $this->session->clear('fid');
                $this->session->clear('guest');
                
    				if (isset($this->request->post['redirect'])) {
    					$this->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
    				} else {
    					$this->redirect(HTTP_HOME . 'index.php?r=common/home');
    				} 
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
        	'href'      => HTTP_HOME . 'index.php?r=account/login',
        	'text'      => $this->language->get('text_login'),
        	'separator' => $this->language->get('text_separator')
      	);
				
    	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_new_customer'] = $this->language->get('text_new_customer');
    	$this->data['text_i_am_new_customer'] = $this->language->get('text_i_am_new_customer');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
    	$this->data['text_account'] = $this->language->get('text_account');
    	$this->data['text_guest'] = $this->language->get('text_guest');   	
    	$this->data['text_create_account'] = $this->language->get('text_create_account');
		$this->data['text_returning_customer'] = $this->language->get('text_returning_customer');
		$this->data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
    	$this->data['text_forgotten_password'] = $this->language->get('text_forgotten_password');

    	$this->data['entry_email'] = $this->language->get('entry_email_address');
    	$this->data['entry_password'] = $this->language->get('entry_password');

    	$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_guest'] = $this->language->get('button_guest');
		$this->data['button_login'] = $this->language->get('button_login');

		$this->data['error'] = isset($this->error['message']) ? $this->error['message'] : '';
		$this->data['action'] = HTTP_HOME . 'index.php?r=account/login';
		$this->data['register'] = HTTP_HOME . 'index.php?r=account/register';

    	if (isset($this->request->post['redirect'])) {
			$this->data['redirect'] = $this->request->post['redirect'];
		} elseif ($this->session->has('redirect')) {
      		$this->data['redirect'] = $this->session->get('redirect');
	  		$this->session->clear('redirect');		  	
    	} else {
			$this->data['redirect'] = '';
		}

		if ($this->session->has('success')) {
    		$this->data['success'] = $this->session->get('success');
	  		$this->session->clear('success');	
		} else {
			$this->data['success'] = '';
		}
		
		if ($this->session->has('account')) {
			$this->data['account'] = $this->session->get('account');
		} else {
			$this->data['account'] = 'register';
		}
		
    	$this->data['forgotten'] = HTTP_HOME . 'index.php?r=account/forgotten';
		$this->data['guest_checkout'] = ($this->config->get('config_guest_checkout') && $this->cart->hasProducts() && !$this->cart->hasDownload());

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/login.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/login.tpl';
		} else {
			$this->template = 'default/account/login.tpl';
		}
		
		$this->children = array(
			'common/header',
			'common/nav',
			'common/column_left',
			'common/column_right',
			'common/footer'
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    private function activarUser() {
        $arrValor = array();
        $codigo = $_SERVER['QUERY_STRING'];
        $arrCodigo = explode('&amp;',$codigo);
        foreach($arrCodigo as $key => $value) {
            $arrValor[] = explode('=',$value);
        }
        foreach ($arrValor as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == '1') $arrFinal[] = $value2;
            }
        }
        if (!empty($arrFinal[3])) {
        $email = $arrFinal[1];
        $password = $arrFinal[2];
        $codigo = $arrFinal[3];
        if ($this->customer->activateUser($codigo)) {
        echo "<center><div style='background:#fff88d top center;display:block;width:1000px;height:15px;font:bold 11px verdana;color:#e47202;'>Su cuenta ha sido activada, Ya puede acceder y disfrutar de nuestros servicios.</div></center>";
        }}
    }
  
  	private function validate() {
    	$this->language->load('account/login');
    	if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
      		$this->error['message'] = $this->language->get('error_login');
    	}     	
	
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}  	
  	}
}
