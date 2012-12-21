<?php  
class ControllerLayoutFullContent extends Controller {
	public function index() {
		$this->template = 'layout/fullcontent.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
