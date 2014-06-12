<?php
class ControllerErrorNotFound extends Controller {
	public function index() {		
		$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
		$this->language->load('error/not_found');
		$this->document->title = $this->data['heading_title'] = $this->language->get('heading_title');
        
		$this->document->breadcrumbs = array();
      	$this->document->breadcrumbs[] = array(
        	'href'      => Url::createUrl("common/home"),
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	);
		if (isset($this->request->get['r'])) {
       		$this->document->breadcrumbs[] = array(
        		'href'      => Url::createUrl($this->request->get['r']),
        		'text'      => $this->language->get('text_error'),
        		'separator' => $this->language->get('text_separator')
      		);	   	
		}
		$this->data['breadcrumbs'] = $this->document->breadcrumbs;
        
        $this->loadWidgets();
                    
        if ($scripts) $this->scripts = array_merge($this->scripts,$scripts);
            
        $template = ($this->config->get('default_view_not_found')) ? $this->config->get('default_view_not_found') : 'error/not_found.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') .'/'. $template)) {
            $this->template = $this->config->get('config_template') .'/'. $template;
       	} else {
            $this->template = 'choroni/'. $template;
       	}
                    
    	$this->children[] = 'common/column_left';
    	$this->children[] = 'common/column_right';
    	$this->children[] = 'common/nav';
    	$this->children[] = 'common/header';
    	$this->children[] = 'common/footer';
            
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));		
  	}

    protected function loadWidgets() {
        $csspath = defined("CDN") ? CDN_CSS : HTTP_THEME_CSS;
        $jspath = defined("CDN") ? CDN_JS : HTTP_THEME_JS;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
            $csspath = str_replace("%theme%",$this->config->get('config_template'),$csspath);
            $cssFolder = str_replace("%theme%",$this->config->get('config_template'),DIR_THEME_CSS);
            
            $jspath = str_replace("%theme%",$this->config->get('config_template'),$jspath);
            $jsFolder = str_replace("%theme%",$this->config->get('config_template'),DIR_THEME_JS);
        } else {
            $csspath = str_replace("%theme%","default",$csspath);
            $cssFolder = str_replace("%theme%","default",DIR_THEME_CSS);
            
            $jspath = str_replace("%theme%","default",$jspath);
            $jsFolder = str_replace("%theme%","default",DIR_THEME_JS);
        }
        
        if (file_exists($cssFolder.str_replace('controller','',strtolower(__CLASS__) . '.css'))) {
            $styles[] = array('media'=>'all','href'=>$csspath.str_replace('controller','',strtolower(__CLASS__) . '.css'));
        }
        
        if (count($styles)) {
            $this->data['styles'] = $this->styles = array_merge($this->styles,$styles);
        }
        
        if (file_exists($jsFolder.str_replace('controller','',strtolower(__CLASS__) . '.js'))) {
            $javascripts[] = $jspath.str_replace('controller','',strtolower(__CLASS__) . '.js');
        }
        
        if (count($javascripts)) {
            $this->javascripts = array_merge($this->javascripts,$javascripts);
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