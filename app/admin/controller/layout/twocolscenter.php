<?php  
class ControllerLayoutTwoColsCenter extends Controller {
	public function index() {
		$this->template = 'layout/twocolscenter.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
