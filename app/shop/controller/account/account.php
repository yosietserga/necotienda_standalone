<?php 
class ControllerAccountAccount extends Controller { 
	public function index() {
	   if (!$this->customer->isLogged()) {  
      		$this->session->set('redirect',Url::createUrl("account/account"));
	  		$this->redirect(Url::createUrl("account/login"));
    	}
	
		$this->language->load('account/account');

      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => Url::createUrl("common/home"),
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	);

      	$this->document->breadcrumbs[] = array(
        	'href'      => Url::createUrl("account/account"),
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);

		$this->document->title = $this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
    	$this->data['text_information'] = $this->language->get('text_information');
    	$this->data['text_password'] = $this->language->get('text_password');
    	$this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_history'] = $this->language->get('text_history');
    	$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_cancel_account'] = $this->language->get('text_cancel_account');
		$this->data['text_balance'] = $this->language->get('text_balance');
		$this->data['text_social_networks'] = $this->language->get('text_social_networks');
		$this->data['text_hobbies'] = $this->language->get('text_hobbies');
		$this->data['text_my_activities'] = $this->language->get('text_my_activities');
		$this->data['text_messages'] = $this->language->get('text_messages');
		$this->data['text_profile'] = $this->language->get('text_profile');
		$this->data['text_payments'] = $this->language->get('text_payments');

		if ($this->session->has('success')) {
    		$this->data['success'] = $this->session->get('success');
			$this->session->clear('success');
		} else {
			$this->data['success'] = '';
		}

        $this->loadWidgets();
        
        if ($scripts) $this->scripts = array_merge($this->scripts,$scripts);
            
    	$this->children[] = 'account/column_left';
    	$this->children[] = 'common/nav';
    	$this->children[] = 'common/header';
    	$this->children[] = 'common/footer';
            
        $template = ($this->config->get('default_view_account_account')) ? $this->config->get('default_view_account_account') : 'account/account.tpl';
   		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') .'/'. $template)) {
            $this->template = $this->config->get('config_template') .'/'. $template;
    	} else {
            $this->template = 'choroni/'. $template;
    	}
        
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));		
  	}
    
    protected function loadWidgets() {
        $csspath = defined("CDN") ? CDN_CSS : HTTP_THEME_CSS;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
            $csspath = str_replace("%theme%",$this->config->get('config_template'),$csspath);
       	} else {
            $csspath = str_replace("%theme%","default",$csspath);
       	}
        if (fopen($csspath.str_replace('controller','',strtolower(__CLASS__) . '.css'),'r')) {
            $styles[] = array('media'=>'all','href'=>$csspath.str_replace('controller','',strtolower(__CLASS__) . '.css'));
        }
        if (count($styles)) {
            $this->data['styles'] = $this->styles = array_merge($this->styles,$styles);
        }
        
        $this->load->helper('widgets');
        $widgets = new NecoWidget($this->registry,$this->Route);
        foreach ($widgets->getWidgets('main') as $widget) {
            $settings = (array)unserialize($widget['settings']);
            if ($settings['asyn']) {
                $url = Url::createUrl("{$settings['route']}",$settings['params']);
                $scripts[$widget['name']] = array(
                    'id'=>$widget['name'],
                    'method'=>'ready',
                    'script'=>
                    "$(document.createElement('div'))
                        .attr({
                            id:'".$widget['name']."'
                        })
                        .html(makeWaiting())
                        .load('". $url . "')
                        .appendTo('".$settings['target']."');"
                );
            } else {
                if (isset($settings['route'])) {
                    if ($settings['autoload']) $this->data['widgets'][] = $widget['name'];
                    $this->children[$widget['name']] = $settings['route'];
                    $this->widget[$widget['name']] = $widget;
                }
            }
        }
            
        foreach ($widgets->getWidgets('featuredContent') as $widget) {
            $settings = (array)unserialize($widget['settings']);
            if ($settings['asyn']) {
                $url = Url::createUrl("{$settings['route']}",$settings['params']);
                $scripts[$widget['name']] = array(
                    'id'=>$widget['name'],
                    'method'=>'ready',
                    'script'=>
                    "$(document.createElement('div'))
                        .attr({
                            id:'".$widget['name']."'
                        })
                        .html(makeWaiting())
                        .load('". $url . "')
                        .appendTo('".$settings['target']."');"
                );
            } else {
                if (isset($settings['route'])) {
                    if ($settings['autoload']) $this->data['featuredWidgets'][] = $widget['name'];
                    $this->children[$widget['name']] = $settings['route'];
                    $this->widget[$widget['name']] = $widget;
                }
            }
        }
    }
}
