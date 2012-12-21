<?php  
class ControllerLayoutTwoColsLeftFeatured extends Controller {
	public function index() {
		$this->template = 'layout/twocolsleftfeatured.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
