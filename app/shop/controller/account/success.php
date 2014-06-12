<?php 
class ControllerAccountSuccess extends Controller {  
	public function index() {
    	$this->language->load('account/success');
  
    	$this->document->title = $this->language->get('heading_title');

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
        	'href'      => Url::createUrl("account/success"),
        	'text'      => $this->language->get('text_success'),
        	'separator' => $this->language->get('text_separator')
      	);

    	$this->data['heading_title'] = $this->language->get('heading_title');

        if ($this->config->get('marketing_page_new_customer')) {
            $this->load->model("marketing/newsletter");
            
      		if ($this->config->get('config_customer_approval')) {
                $result = $this->modelNewsletter->getById($this->config->get('marketing_page_new_customer'));
      		} else {
                $result = $this->modelNewsletter->getById($this->config->get('marketing_page_activate_customer'));
      		}
            $this->data['text_message'] = $result['htmlbody'];
        } else {
    		if (!$this->config->get('config_customer_approval')) {
        		$this->data['text_message'] = sprintf($this->language->get('text_message'), Url::createUrl("page/contact"));
    		} else {
    			$this->data['text_message'] = sprintf($this->language->get('text_approval'), $this->config->get('config_name'), Url::createUrl("page/contact"));
    		}
        }
		
    	$this->data['button_continue'] = $this->language->get('button_continue');
		
		if ($this->cart->hasProducts()) {
			$this->data['continue'] = Url::createUrl("checkout/cart");
		} else {
			$this->data['continue'] = Url::createUrl("account/account");
		}
		
        $this->loadWidgets();
        
        if ($scripts) $this->scripts = array_merge($this->scripts,$scripts);
            
    	$this->children[] = 'account/column_left';
    	$this->children[] = 'common/nav';
    	$this->children[] = 'common/header';
    	$this->children[] = 'common/footer';
            
        $template = ($this->config->get('default_view_account_success')) ? $this->config->get('default_view_account_success') : 'common/success.tpl';
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
