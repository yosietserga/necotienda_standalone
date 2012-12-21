<?php  
class ControllerLayoutTwoColsRightFeatured extends Controller {
	public function index() {
		$this->template = 'layout/twocolsrightfeatured.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
