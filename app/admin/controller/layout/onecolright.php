<?php  
class ControllerLayoutOneColRight extends Controller {
	public function index() {
		$this->template = 'layout/onecolright.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
