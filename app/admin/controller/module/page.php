<?php
/**
 * ControllerModulePage
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModulePage extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModulePage::index()
	 * 
	 * @return
	 */
	public function index() {   
		$this->load->language('module/page');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->auto('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->modelSetting->editSetting('page', $this->request->post);		
					
			$this->session->set('success',$this->language->get('text_success'));
						
			$this->redirect(Url::createAdminUrl('extension/module'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['help_position'] = $this->language->get('help_position');
		$this->data['help_status'] = $this->language->get('help_status');
		$this->data['help_sort_order'] = $this->language->get('help_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('extension/module'),
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('module/page'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = Url::createAdminUrl('module/page');
		
		$this->data['cancel'] = Url::createAdminUrl('extension/module');

		if (isset($this->request->post['page_position'])) {
			$this->data['page_position'] = $this->request->post['page_position'];
		} else {
			$this->data['page_position'] = $this->config->get('page_position');
		}
		
		if (isset($this->request->post['page_status'])) {
			$this->data['page_status'] = $this->request->post['page_status'];
		} else {
			$this->data['page_status'] = $this->config->get('page_status');
		}
		
		if (isset($this->request->post['page_sort_order'])) {
			$this->data['page_sort_order'] = $this->request->post['page_sort_order'];
		} else {
			$this->data['page_sort_order'] = $this->config->get('page_sort_order');
		}				
		
		$this->template = 'module/page.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
	
	/**
	 * ControllerModulePage::validate()
	 * 
	 * @return
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/page')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
