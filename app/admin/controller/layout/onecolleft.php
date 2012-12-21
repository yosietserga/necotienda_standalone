<?php  
class ControllerLayoutOneColLeft extends Controller {
	public function index() {
		$this->template = 'layout/onecolleft.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
