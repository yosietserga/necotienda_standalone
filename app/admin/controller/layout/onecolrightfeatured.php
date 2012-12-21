<?php  
class ControllerLayoutOneColRightFeatured extends Controller {
	public function index() {
		$this->template = 'layout/onecolrightfeatured.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
