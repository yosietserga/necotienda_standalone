<?php  
class ControllerCommonNav extends Controller {
	protected function index() {
	   $this->data['home']     = HTTP_HOME . "index.php?r=common/home";
	   $this->data['about_us']     = HTTP_HOME . "index.php?r=information/information&information_id=1";
	   $this->data['special']     = HTTP_HOME . "index.php?r=store/special";
       if ($this->customer->isLogged()) {
	       $this->data['account']     = HTTP_HOME . "index.php?r=account/account";
       } else {
	       $this->data['account']     = HTTP_HOME . "index.php?r=account/login";
       }
	   $this->data['contact']     = HTTP_HOME . "index.php?r=information/contact";
       
		$this->id = 'navigation';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/nav.tpl')) {
			$this->template = $this->config->get('config_template') . '/common/nav.tpl';
		} else {
			$this->template = 'default/common/nav.tpl';
		}
		
		$this->render();
	}
}
