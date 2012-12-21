<?php  
class ControllerLayoutTwoColsRight extends Controller {
	public function index() {
		$this->template = 'layout/twocolsright.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
