<?php  
class ControllerLayoutFullContentFeatured extends Controller {
	public function index() {
		$this->template = 'layout/fullcontentfeatured.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
