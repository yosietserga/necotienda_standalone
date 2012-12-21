<?php  
class ControllerModuleSkypeMe extends Controller {
	protected function index() {
		$this->language->load('module/twitter');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['skype_me'] = html_entity_decode($this->config->get('skype_me_code'));

		$this->id = 'skype_me';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/skype_me.tpl')) {
			$this->template = $this->config->get('config_template') . '/module/skype_me.tpl';
		} else {
			$this->template = 'default/module/skype_me.tpl';
		}
		$this->render();
	}
}
