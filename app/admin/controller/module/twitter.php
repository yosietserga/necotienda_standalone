<?php
/**
 * ControllerModuleTwitter
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleTwitter extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleTwitter::index()
	 * 
	 * @return
	 */
	public function index() {   
		$this->load->language('module/twitter');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->auto('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->modelSetting->editSetting('twitter', $this->request->post);		
					
			$this->session->set('success',$this->language->get('text_success'));
						
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('module/twitter')); 
            } else {
                $this->redirect(Url::createAdminUrl('extension/module')); 
            }
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
		$this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_true'] = $this->language->get('text_true');
		$this->data['text_false'] = $this->language->get('text_false');
        
		$this->data['entry_twitter_search'] = $this->language->get('entry_twitter_search');
        $this->data['entry_twitter_search_limit'] = $this->language->get('entry_twitter_search_limit');
		$this->data['entry_twitter_search_rate'] = $this->language->get('entry_twitter_search_rate');
		$this->data['entry_twitter_time'] = $this->language->get('entry_twitter_time');
		$this->data['entry_twitter_time_limit'] = $this->language->get('entry_twitter_time_limit');
		$this->data['entry_twitter_time_refresh'] = $this->language->get('entry_twitter_time_refresh');
		$this->data['entry_twitter_time_mode'] = $this->language->get('entry_twitter_time_mode');
		$this->data['entry_width'] = $this->language->get('entry_width');
        $this->data['entry_height'] = $this->language->get('entry_height');
        $this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        
		$this->data['help_twitter_search'] = $this->language->get('help_twitter_search');
        $this->data['help_twitter_search_limit'] = $this->language->get('help_twitter_search_limit');
		$this->data['help_twitter_search_rate'] = $this->language->get('help_twitter_search_rate');
		$this->data['help_twitter_time'] = $this->language->get('help_twitter_time');
		$this->data['help_twitter_time_limit'] = $this->language->get('help_twitter_time_limit');
		$this->data['help_twitter_time_refresh'] = $this->language->get('help_twitter_time_refresh');
		$this->data['help_twitter_time_mode'] = $this->language->get('help_twitter_time_mode');
		$this->data['help_width'] = $this->language->get('help_width');
        $this->data['help_height'] = $this->language->get('help_height');
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
        
        if (isset($this->error['error_twitter_search'])) {
			$this->data['error_twitter_search'] = $this->error['error_twitter_search'];
		} else {
			$this->data['error_twitter_search'] = '';
		}
        
        if (isset($this->error['error_twitter_time'])) {
			$this->data['error_twitter_time'] = $this->error['error_twitter_time'];
		} else {
			$this->data['error_twitter_time'] = '';
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
       		'href'      => Url::createAdminUrl('module/twitter'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = Url::createAdminUrl('module/twitter');
		
		$this->data['cancel'] = Url::createAdminUrl('extension/module');

		$this->data['twitter_search_limit'] = 5;
		$this->data['twitter_search_rate'] = 5000;
		$this->data['twitter_time_refresh'] = false;
		$this->data['twitter_time_limit'] = 5;
		$this->data['twitter_time_mode'] = 'user_timeline';
        
        $this->setvar('twitter_position');
        
        if (isset($this->request->post['twitter_search'])) {
			$this->data['twitter_search'] = $this->request->post['twitter_search'];
		} else {
			$this->data['twitter_search'] = $this->config->get('twitter_search');
		}			
		
        if (isset($this->request->post['twitter_time'])) {
			$this->data['twitter_time'] = $this->request->post['twitter_time'];
		} else {
			$this->data['twitter_time'] = $this->config->get('twitter_time');
		}
        
        if (isset($this->request->post['twitter_status'])) {
			$this->data['twitter_status'] = $this->request->post['twitter_status'];
		} else {
			$this->data['twitter_status'] = $this->config->get('twitter_status');
		}
        
        if (isset($this->request->post['twitter_sort_order'])) {
			$this->data['twitter_sort_order'] = $this->request->post['twitter_sort_order'];
		} else {
			$this->data['twitter_sort_order'] = $this->config->get('twitter_sort_order');
		}
        
		$this->data['positions'] = array();
		
		$this->data['positions'][] = array(
			'position' => 'left',
			'title'    => $this->language->get('text_left'),
		);
		
		$this->data['positions'][] = array(
			'position' => 'right',
			'title'    => $this->language->get('text_right'),
		);
		
		$this->data['positions'][] = array(
			'position' => 'home',
			'title'    => $this->language->get('text_home'),
		);
		
        $this->data['Url'] = new Url;
        
        $scripts[] = array('id'=>'jsForm','method'=>'ready','script'=>
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
            
        $scripts[] = array('id'=>'jsFunctions','method'=>'function','script'=>
            "function saveAndExit() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndExit'>\").submit(); 
            }
            
            function saveAndKeep() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndKeep'>\").submit(); 
            }");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'module/twitter.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
	
	/**
	 * ControllerModuleTwitter::validate()
	 * 
	 * @return
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/twitter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		        
       	if (!$this->request->post['twitter_time']) {
			$this->error['error_twitter_time'] = $this->language->get('error_twitter_time');
		}
		
        if (!$this->request->post['twitter_search']) {
			$this->error['error_twitter_search'] = $this->language->get('error_twitter_search');
		}
       

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
