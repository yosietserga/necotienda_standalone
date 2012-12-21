<?php  
class ControllerModuleTwitter extends Controller {
	protected function index() {
		$this->language->load('module/twitter');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['twitter_search'] = html_entity_decode($this->config->get('twitter_search'));
        $this->data['twitter_search_limit'] = html_entity_decode($this->config->get('twitter_search_limit'));
        $this->data['twitter_search_rate'] = html_entity_decode($this->config->get('twitter_search_rate'));
        
        $this->data['twitter_time'] = html_entity_decode($this->config->get('twitter_time'));
        $this->data['twitter_time_limit'] = html_entity_decode($this->config->get('twitter_time_limit'));
		$this->data['twitter_time_refresh'] = html_entity_decode($this->config->get('twitter_time_refresh'));
		$this->data['twitter_time_mode'] = html_entity_decode($this->config->get('twitter_time_mode'));

		$this->id = 'twitter';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/twitter_home.tpl')) {
			$this->template = $this->config->get('config_template') . '/module/twitter_home.tpl';
		} else {
			$this->template = 'default/module/twitter_home.tpl';
		}
		$this->render();
	}
}
