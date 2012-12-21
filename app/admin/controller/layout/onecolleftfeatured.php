<?php  
class ControllerLayoutOneColLeftFeatured extends Controller {
	public function index() {
		$this->template = 'layout/onecolleftfeatured.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
