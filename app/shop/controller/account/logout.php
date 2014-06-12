<?php 
class ControllerAccountLogout extends Controller {
	public function index() {
    	if ($this->customer->isLogged()) {
      		$this->customer->logout();
	  		$this->cart->clear();
			
			$this->session->clear('shipping_address_id');
			$this->session->clear('shipping_method');
			$this->session->clear('shipping_methods');
			$this->session->clear('payment_address_id');
			$this->session->clear('payment_method');
			$this->session->clear('payment_methods');
			$this->session->clear('comment');
			$this->session->clear('order_id');
			$this->session->clear('coupon');
			
			$this->tax->setZone($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
			
      		$this->redirect(Url::createUrl("account/logout"));
    	} else {
    	   $this->redirect(HTTP_HOME);
    	}
 
    	$this->language->load('account/logout');
		
		$this->document->title = $this->data['heading_title'] = $this->language->get('heading_title');
      	
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
      	$this->document->breadcrumbs[] = array(
        	'href'      => Url::createUrl("account/logout"),
        	'text'      => $this->language->get('text_logout'),
        	'separator' => $this->language->get('text_separator')
      	);	
		$this->data['breadcrumbs'] = $this->document->breadcrumbs;
        
        $this->loadWidgets();
            
        if ($scripts) $this->scripts = array_merge($this->scripts,$scripts);
            
    	$this->children[] = 'common/column_left';
    	$this->children[] = 'common/column_right';
    	$this->children[] = 'common/nav';
    	$this->children[] = 'common/header';
    	$this->children[] = 'common/footer';
        
        $template = ($this->config->get('default_view_account_logout')) ? $this->config->get('default_view_account_logout') : 'account/logout.tpl';
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
