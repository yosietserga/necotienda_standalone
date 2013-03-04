<?php
/**
 * ControllerModuleFBLike
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleFBLike extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleFBLike::index()
	 * 
	 * @return
	 */
	public function index() {   
		$this->load->language('module/fblike');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->auto('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->modelSetting->editSetting('fblike', $this->request->post);		
					
			$this->session->set('success',$this->language->get('text_success'));
								
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('module/fblike')); 
            } else {
                $this->redirect(Url::createAdminUrl('extension/module')); 
            }
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
        $this->data['text_true'] = $this->language->get('text_true');
		$this->data['text_false'] = $this->language->get('text_false');
        
		$this->data['entry_pageid'] = $this->language->get('entry_pageid');
        $this->data['entry_totalconnection'] = $this->language->get('entry_totalconnection');
		$this->data['entry_width'] = $this->language->get('entry_width');
        $this->data['entry_height'] = $this->language->get('entry_height');
        $this->data['entry_stream'] = $this->language->get('entry_stream');
        $this->data['entry_header'] = $this->language->get('entry_header');
        $this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        
		$this->data['help_pageid'] = $this->language->get('help_pageid');
        $this->data['help_totalconnection'] = $this->language->get('help_totalconnection');
		$this->data['help_width'] = $this->language->get('help_width');
        $this->data['help_height'] = $this->language->get('help_height');
        $this->data['help_stream'] = $this->language->get('help_stream');
        $this->data['help_header'] = $this->language->get('help_header');
        $this->data['help_position'] = $this->language->get('help_position');
		$this->data['help_status'] = $this->language->get('help_status');
		$this->data['help_sort_order'] = $this->language->get('help_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_save_and_new']= $this->language->get('button_save_and_new');
		$this->data['button_save_and_exit']= $this->language->get('button_save_and_exit');
		$this->data['button_save_and_keep']= $this->language->get('button_save_and_keep');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['pageid'])) {
			$this->data['error_pageid'] = $this->error['pageid'];
		} else {
			$this->data['error_pageid'] = '';
		}
		
      	if (isset($this->error['totalconnection'])) {
			$this->data['error_totalconnection'] = $this->error['totalconnection'];
		} else {
			$this->data['error_totalconnection'] = '';
		}
        
        if (isset($this->error['width'])) {
			$this->data['error_width'] = $this->error['width'];
		} else {
			$this->data['error_width'] = '';
		}
        
        if (isset($this->error['height'])) {
			$this->data['error_height'] = $this->error['height'];
		} else {
			$this->data['error_height'] = '';
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
       		'href'      => Url::createAdminUrl('module/fblike'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = Url::createAdminUrl('module/fblike');
		
		$this->data['cancel'] = Url::createAdminUrl('extension/module');

		if (isset($this->request->post['fblike_pageid'])) {
			$this->data['fblike_pageid'] = $this->request->post['fblike_pageid'];
		} else {
			$this->data['fblike_pageid'] = $this->config->get('fblike_pageid');
		}
        
        
		if (isset($this->request->post['fblike_totalconnection'])) {
			$this->data['fblike_totalconnection'] = $this->request->post['fblike_totalconnection'];
		} else {
			$this->data['fblike_totalconnection'] = $this->config->get('fblike_totalconnection');
		}
        
        if (isset($this->request->post['fblike_width'])) {
			$this->data['fblike_width'] = $this->request->post['fblike_width'];
		} else {
			$this->data['fblike_width'] = $this->config->get('fblike_width');
		}
        
        if (isset($this->request->post['fblike_height'])) {
			$this->data['fblike_height'] = $this->request->post['fblike_height'];
		} else {
			$this->data['fblike_height'] = $this->config->get('fblike_height');
		}
        
       if (isset($this->request->post['fblike_stream'])) {
			$this->data['fblike_stream'] = $this->request->post['fblike_stream'];
		} else {
			$this->data['fblike_stream'] = $this->config->get('fblike_stream');
		}
        
        if (isset($this->request->post['fblike_header'])) {
			$this->data['fblike_header'] = $this->request->post['fblike_header'];
		} else {
			$this->data['fblike_header'] = $this->config->get('fblike_header');
		}
		
		
		if (isset($this->request->post['fblike_position'])) {
			$this->data['fblike_position'] = $this->request->post['fblike_position'];
		} else {
			$this->data['fblike_position'] = $this->config->get('fblike_position');
		}
		
		if (isset($this->request->post['fblike_status'])) {
			$this->data['fblike_status'] = $this->request->post['fblike_status'];
		} else {
			$this->data['fblike_status'] = $this->config->get('fblike_status');
		}
		
		if (isset($this->request->post['fblike_sort_order'])) {
			$this->data['fblike_sort_order'] = $this->request->post['fblike_sort_order'];
		} else {
			$this->data['fblike_sort_order'] = $this->config->get('fblike_sort_order');
		}				
		
        $this->data['Url'] = new Url;
        
        $scripts[] = array('id'=>'featuredForm','method'=>'ready','script'=>
            "$('#form').ntForm({
                submitButton:false,
                cancelButton:false,
                lockButton:false
            });
            $('textarea').ntTextArea();
            
            var form_clean = $('#form').serialize();  
            
            window.onbeforeunload = function (e) {
                var form_dirty = $('#form').serialize();
                if(form_clean != form_dirty) {
                    return 'There is unsaved form data.';
                }
            };
            
            $('.sidebar .tab').on('click',function(){
                $(this).closest('.sidebar').addClass('show').removeClass('hide').animate({'right':'0px'});
            });
            $('.sidebar').mouseenter(function(){
                clearTimeout($(this).data('timeoutId'));
            }).mouseleave(function(){
                var e = this;
                var timeoutId = setTimeout(function(){
                    if ($(e).hasClass('show')) {
                        $(e).removeClass('show').addClass('hide').animate({'right':'-400px'});
                    }
                }, 600);
                $(this).data('timeoutId', timeoutId); 
            });");
            
        $scripts[] = array('id'=>'featuredFunctions','method'=>'function','script'=>
            "function saveAndExit() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndExit'>\").submit(); 
            }
            
            function saveAndKeep() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndKeep'>\").submit(); 
            }");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'module/fblike.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
	
	/**
	 * ControllerModuleFBLike::validate()
	 * 
	 * @return
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/fblike')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['fblike_pageid']) {
			$this->error['pageid'] = $this->language->get('error_pageid');
		}
       	
        if (!$this->request->post['fblike_totalconnection']) {
			$this->error['totalconnection'] = $this->language->get('error_totalconnection');
		}
        
       	if (!$this->request->post['fblike_width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		
        if (!$this->request->post['fblike_height']) {
			$this->error['height'] = $this->language->get('error_height');
		}
       

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
