<?php  class ControllerCommonHome extends Controller {
	public function index() {
		
        $cached = $this->cache->get('home_page.' . 
            $this->config->get('config_language_id') . "." . 
            $this->config->get('config_currency') . "." . 
            (int)$this->config->get('config_store_id')
        );
   	    if ($cached) {
            $this->response->setOutput($cached, $this->config->get('config_compression'));
   	    } else {
    		$this->document->title = $this->config->get('config_title');
    		$this->document->description = $this->config->get('config_meta_description');
    		
    		$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
    		
    		$this->data['welcome'] = html_entity_decode($this->config->get('config_description_' . $this->config->get('config_language_id')), ENT_QUOTES, 'UTF-8');
    				
    		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/home.tpl')) {
    			$this->template = $this->config->get('config_template') . '/common/home.tpl';
    		} else {
    			$this->template = 'default/common/home.tpl';
    		}
    		
    		$this->children[] = 'common/header';
    		$this->children[] = 'common/nav';
    		$this->children[] = 'common/column_left';
    		$this->children[] = 'common/column_right';
    		$this->children[] = 'common/footer';
            
            $this->load->helper('widgets');
            $widgets = new NecoWidget($this->registry,$this->Route);
            foreach ($widgets->getWidgets('main') as $widget) {
                $settings = unserialize($widget['settings']);
                if ($settings->asyn) {
                    $url = Url::createUrl("{$settings->route}",$settings->params);
                    $css = isset($settings->style) ? Json::encode($settings->style) : '';
                    $scripts[$widget['code']] = array(
                        'id'=>$widget['name'],
                        'method'=>'ready',
                        'script'=>"$(document.createElement('div')).attr({id:'".$widget['name']."'}).css({".$css."}).html(makeWaiting()).load('". $url . "').appendTo('".$settings->target."');"
                    );
                } else {
                    if (isset($settings->route)) $this->children[$widget['code']] = $settings->route;
                }
            }
            
    		$this->data['modules'] = $this->modelExtension->getExtensionsByPosition('module', 'home');
    		
            foreach ($this->data['modules'] as $key => $module) {
                $scripts[] = array(
                    'id'=>$module['code'],
                    'method'=>'ready',
                    'script'=>"$('#home_{$key}_{$module['code']}').load('". HTTP_HOME . "index.php?r=module/{$module['code']}/home');"
                );
            }
            
            $this->scripts = array_merge($this->scripts,$scripts);
            
    		//$this->cacheId = 'home_page.' . 
                $this->config->get('config_language_id') . "." . 
                $this->config->get('config_currency') . "." . 
                (int)$this->config->get('config_store_id');
                           
    		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
        }
	}
}
