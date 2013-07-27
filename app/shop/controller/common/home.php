<?php  class ControllerCommonHome extends Controller {
	public function index() {
		$cached = $this->cache->get('home_page.' . 
            $this->config->get('config_language_id') . "." . 
            $this->config->get('config_currency') . "." . 
            (int)$this->config->get('config_store_id')
        );
        $this->load->library('user');
   	    if ($cached && !$this->user->isLogged()) {
            $this->response->setOutput($cached, $this->config->get('config_compression'));
   	    } else {
    		$this->document->title = $this->config->get('config_title_'.$this->config->get('config_language_id'));
    		$this->document->description = $this->config->get('config_meta_description_'.$this->config->get('config_language_id'));
    		
    		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/home.tpl')) {
    			$this->template = $this->config->get('config_template') . '/common/home.tpl';
    		} else {
    			$this->template = 'cuyagua/common/home.tpl';
    		}
    		
    		$this->children[] = 'common/column_left';
    		$this->children[] = 'common/column_right';
    		$this->children[] = 'common/nav';
    		$this->children[] = 'common/header';
    		$this->children[] = 'common/footer';
            
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
            
            if ($scripts) $this->scripts = array_merge($this->scripts,$scripts);
            
            if (!$this->user->isLogged()) {
        		$this->cacheId = 'home_page.' . 
                    $this->config->get('config_language_id') . "." . 
                    $this->config->get('config_currency') . "." . 
                    (int)$this->config->get('config_store_id');
            }
             
    		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
        }
	}
    
    
    public function carousel() {
        $json = array();
        $this->load->model("store/product");
        $this->load->library('image');
        $json['results'] = $this->modelProduct->getRandomProducts(40);
        $width = isset($_GET['width']) ? $_GET['width'] : 80;
        $height = isset($_GET['height']) ? $_GET['height'] : 80;
        foreach ($json['results'] as $k => $v) {
            if (!file_exists(DIR_IMAGE . $v['image'])) $json['results'][$k]['image'] = HTTP_IMAGE ."no_image.jpg";
            $json['results'][$k]['thumb'] = NTImage::resize($v['image'], $width, $height);
        }
        if (!count($json['results'])) $json['error'] = 1;
        echo json_encode($json);
    }
    
}
