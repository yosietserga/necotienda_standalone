<?php  
class ControllerLayoutTwoColsCenterFeatured extends Controller {
	public function index() {
		$this->template = 'layout/twocolscenterfeatured.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
