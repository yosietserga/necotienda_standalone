<?php  
class ControllerModuleFBLike extends Controller {
	protected function index() {
		$this->language->load('module/fblike');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['pageid'] = html_entity_decode($this->config->get('fblike_pageid'));
        $this->data['totalconnection'] = html_entity_decode($this->config->get('fblike_totalconnection'));
        $this->data['width'] = html_entity_decode($this->config->get('fblike_width'));
        $this->data['height'] = html_entity_decode($this->config->get('fblike_height'));
        $this->data['stream'] = html_entity_decode($this->config->get('fblike_stream'));
		$this->data['header'] = html_entity_decode($this->config->get('fblike_header'));

		$this->id = 'fblike';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/fblike.tpl')) {
			$this->template = $this->config->get('config_template') . '/module/fblike.tpl';
		} else {
			$this->template = 'default/module/fblike.tpl';
		}
		
		$this->render();
	}
}
