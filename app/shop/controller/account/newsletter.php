<?php 
class ControllerAccountNewsletter extends Controller {  
	public function index() {
	   if ($this->customer->isLogged() && !$this->customer->getComplete()) {  
      		$this->redirect(HTTP_HOME . 'index.php?r=account/complete_activation');
    	} elseif (!$this->customer->isLogged()) {  
      		$this->session->set('redirect',HTTP_HOME . 'index.php?r=account/newsletter');
	  
	  		$this->redirect(HTTP_HOME . 'index.php?r=account/login');
    	}
		
		$this->language->load('account/newsletter');
    	
		$this->document->title = $this->language->get('heading_title');
		
        // evitando ataques xsrf y xss
        $fid = ($this->session->has('fid')) ? $this->session->get('fid') : strtotime(date('d-m-Y h:i:s'));$this->session->set('fid',$fid);
        $fkey = $this->fkey . "." . $this->session->get('fid') . "_" . str_replace('/','-',$_GET['r']);
        $this->data['fkey'] = "<input type='hidden' name='fkey' id='fkey' value='$fkey' />";
                
        if ($this->session->get('skey') == $this->customer->skey) {      	       
    		if ($this->request->server['REQUEST_METHOD'] == 'POST') {       
                $route = str_replace("-","/",substr($_POST['fkey'],strrpos($_POST['fkey'],"_")+1)); // verificamos que la ruta pertenece a este formulario
                $fid = substr($_POST['fkey'],strpos($_POST['fkey'],".")+1,10); // verificamos que id del formulario es correcto
                $date = substr($this->fkey,strpos($this->fkey,"_")+1,10); // verificamos que la fecha es de hoy
                if (($this->session->get('fkey')==$this->fkey) && ($route==$_GET['r']) && ($fid==$this->session->get('fid')) && ($date==strtotime(date('d-m-Y')))) { // validamos el id de sesión para evitar ataques csrf
                    $this->session->clear('fid');
        			$this->load->model('account/customer');        			
        			$this->model_account_customer->editNewsletter($this->request->post['newsletter']);        			
        			$this->session->set('success',$this->language->get('text_success'));        			
        			$this->redirect(HTTP_HOME . 'index.php?r=account/account');
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
        	'href'      => HTTP_HOME . 'index.php?r=account/newsletter',
        	'text'      => $this->language->get('text_newsletter'),
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
		
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

    	$this->data['action'] = HTTP_HOME . 'index.php?r=account/newsletter';
		
		$this->data['newsletter'] = $this->customer->getNewsletter();
		
		$this->data['back'] = HTTP_HOME . 'index.php?r=account/account';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/newsletter.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/newsletter.tpl';
		} else {
			$this->template = 'default/account/newsletter.tpl';
		}
		
		$this->children = array(
			'common/nav',
			'common/column_left',
			'common/footer',
			'common/header'
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));			
  	}
}
