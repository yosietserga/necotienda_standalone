<?php
/**
 * ControllerModuleSocialPlugin
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleSocialPlugin extends Controller {
	private $error = array(); 
	
	/**
	 * ControllerModuleSocialPlugin::index()
	 * 
	 * @return
	 */
	public function index() {   
		$this->load->language('module/social');

		$this->document->title = $this->data['heading_title']  = $this->language->get('heading_title');
		
		$this->load->auto('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->modelSetting->update('social', $this->request->post);		
					
			$this->session->set('success',$this->language->get('text_success'));
								
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('module/social')); 
            } else {
                $this->redirect(Url::createAdminUrl('extension/module')); 
            }
		}
				
		$this->data['text_enabled']   = $this->language->get('text_enabled');
		$this->data['text_disabled']  = $this->language->get('text_disabled');
		$this->data['text_left']      = $this->language->get('text_left');
		$this->data['text_right']     = $this->language->get('text_right');
        $this->data['text_true']      = $this->language->get('text_true');
		$this->data['text_false']     = $this->language->get('text_false');
        
		$this->data['button_save_and_exit']= $this->language->get('button_save_and_exit');
		$this->data['button_save_and_keep']= $this->language->get('button_save_and_keep');
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
       		'href'      => Url::createAdminUrl('module/social'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = Url::createAdminUrl('module/social');
		$this->data['cancel'] = Url::createAdminUrl('extension/module');
        
        $this->data['social_facebook_app_id'] =  isset($this->request->post['social_facebook_app_id']) ? 
            $this->request->post['social_facebook_app_id'] : 
            $this->config->get('social_facebook_app_id');
            
        $this->data['social_facebook_app_secret'] =  isset($this->request->post['social_facebook_app_secret']) ? 
            $this->request->post['social_facebook_app_secret'] : 
            $this->config->get('social_facebook_app_secret');
        
        
        $this->data['social_twitter_consumer_key'] =  isset($this->request->post['social_twitter_consumer_key']) ? 
            $this->request->post['social_twitter_consumer_key'] : 
            $this->config->get('social_twitter_consumer_key');
        
        $this->data['social_twitter_consumer_secret'] =  isset($this->request->post['social_twitter_consumer_secret']) ? 
            $this->request->post['social_twitter_consumer_secret'] : 
            $this->config->get('social_twitter_consumer_secret');
        
        $this->data['social_twitter_oauth_token'] =  isset($this->request->post['social_twitter_oauth_token']) ? 
            $this->request->post['social_twitter_oauth_token'] : 
            $this->config->get('social_twitter_oauth_token');
        
        $this->data['social_twitter_oauth_token_secret'] =  isset($this->request->post['social_twitter_oauth_token_secret']) ? 
            $this->request->post['social_twitter_oauth_token_secret'] : 
            $this->config->get('social_twitter_oauth_token_secret');
        
        $this->data['social_twitter_consumer_secret'] =  isset($this->request->post['social_twitter_consumer_secret']) ? 
            $this->request->post['social_twitter_consumer_secret'] : 
            $this->config->get('social_twitter_consumer_secret');
        
        $this->data['social_google_client_id'] =  isset($this->request->post['social_google_client_id']) ? 
            $this->request->post['social_google_client_id'] : 
            $this->config->get('social_google_client_id');
        
        $this->data['social_google_client_secret'] =  isset($this->request->post['social_google_client_secret']) ? 
            $this->request->post['social_google_client_secret'] : 
            $this->config->get('social_google_client_secret');
        
        $this->data['social_google_api_key'] =  isset($this->request->post['social_google_api_key']) ? 
            $this->request->post['social_google_api_key'] : 
            $this->config->get('social_google_api_key');
        
        $this->data['social_google_consumer_key'] =  isset($this->request->post['social_google_consumer_key']) ? 
            $this->request->post['social_google_consumer_key'] : 
            $this->config->get('social_google_consumer_key');
        
        $this->data['social_google_consumer_secret'] =  isset($this->request->post['social_google_consumer_secret']) ? 
            $this->request->post['social_google_consumer_secret'] : 
            $this->config->get('social_google_consumer_secret');
        
        $this->data['Url'] = new Url;
        
        $scripts[] = array('id'=>'socialScripts','method'=>'ready','script'=>
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
            });
            $('.vtabs_page').hide();
            $('#tab_facebook').show();");
            
        $scripts[] = array('id'=>'socialFunctions','method'=>'function','script'=>
            "function saveAndExit() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndExit'>\").submit(); 
            }
            
            function saveAndKeep() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndKeep'>\").submit(); 
            }
            function showTab(a) {
                $('.vtabs_page').hide();
                $($(a).data('target')).show();
            }");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'module/social.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
	
	/**
	 * ControllerModuleSocialPlugin::validate()
	 * 
	 * @return
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/social')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
