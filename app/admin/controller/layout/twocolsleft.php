<?php  
class ControllerLayoutTwoColsLeft extends Controller {
	public function index() {
		$this->template = 'layout/twocolsleft.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
