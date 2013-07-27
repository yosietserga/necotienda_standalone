<?php 
class ControllerStoreManufacturer extends Controller {  
	public function index() {
		$this->language->load('store/manufacturer');
		$this->load->model('store/manufacturer');
		$this->document->breadcrumbs = array();
      	$this->document->breadcrumbs[] = array(
        	'href'      => Url::createUrl("store/home"),
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	);

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = $this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}
		
        $this->data['manufacturer_id'] = $manufacturer_id;
        
		$manufacturer_info = $this->modelManufacturer->getManufacturer($manufacturer_id);
	
		if ($manufacturer_info) {
            $cached = $this->cache->get('manufacturer.' . 
                    $manufacturer_id .
                    $this->config->get('config_language_id') . "." . 
                    $this->config->get('config_currency') . "." . 
                    (int)$this->config->get('config_store_id')
            );
            $this->load->library('user');
           	if ($cached && !$this->user->isLogged()) {
                $this->response->setOutput($cached, $this->config->get('config_compression'));
       	    } else {
          		$this->document->breadcrumbs[] = array(
            		'href'      => Url::createUrl("store/manufacturer",array("manufacturer_id"=>$this->request->get['manufacturer_id'])),
            		'text'      => $manufacturer_info['name'],
            		'separator' => $this->language->get('text_separator')
          		);
    					  		
    			$this->document->title = $manufacturer_info['name'];
    									
    			$this->data['heading_title'] = $manufacturer_info['name'];
    
    			$this->data['text_sort'] = $this->language->get('text_sort');
    			
    			$this->modelManufacturer->updateStats($this->request->getQuery('manufacturer_id'),(int)$this->customer->getId());
    				
          		$this->data['breadcrumbs'] = $this->document->breadcrumbs;
    	  			
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
            
    			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/manufacturer.tpl')) {
    				$this->template = $this->config->get('config_template') . '/store/manufacturer.tpl';
    			} else {
    				$this->template = 'cuyagua/store/manufacturer.tpl';
    			}	
    				
        		$this->children[] = 'common/column_left';
        		$this->children[] = 'common/column_right';
        		$this->children[] = 'common/nav';
        		$this->children[] = 'common/header';
        		$this->children[] = 'common/footer';
                if (!$this->user->isLogged()) {
            		$this->cacheId = 'manufacturer.' . 
                        $manufacturer_id .
                        $this->config->get('config_language_id') . "." . 
                        $this->config->get('config_currency') . "." . 
                        (int)$this->config->get('config_store_id');
                }        
    			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));										
     		}
    	} else {
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}	
			
      		$this->document->breadcrumbs[] = array(
        		'href'      => Url::createUrl("store/manufacturer",array("manufacturer_id"=>$manufacturer_id . $url)),
        		'text'      => $this->language->get('text_error'),
        		'separator' => $this->language->get('text_separator')
      		);
			$this->data['breadcrumbs'] = $this->document->breadcrumbs;		
			$this->document->title = $this->language->get('text_error');

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = Url::createUrl("store/home");
            
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
            
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/error/not_found.tpl';
			} else {
				$this->template = 'cuyagua/error/not_found.tpl';
			}
			
    		$this->children[] = 'common/column_left';
    		$this->children[] = 'common/column_right';
    		$this->children[] = 'common/nav';
    		$this->children[] = 'common/header';
    		$this->children[] = 'common/footer';
            
			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
		}
  	}
    
    public function home() { 
            $this->load->language("store/manufacturer");
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else { 
				$page = 1;
			}	
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'p.sort_order';
			}
            
			
			if (isset($this->request->get['v'])) {
				$view = $this->request->get['v'];
			} else {
				$view = 'grid';
			}
            
			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'ASC';
			}

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['v'])) {
				$url .= '&v=' . $this->request->get['v'];
			}
			
            
			if (isset($this->request->get['page'])) {
			 $url .= '&page=' . $this->request->get['page'];
			}			
		
            $this->data['sorts'] = array();
				
            $this->data['sorts'][] = array(
					'text'  => $this->language->get('text_default'),
					'value' => 'p.sort_order-ASC',
					'href'  => Url::createUrl("store/manufacturer/home") .'&manufacturer_id='. $this->request->get['manufacturer_id'] .'&sort=p.sort_order&order=ASC&page='.$page.'&v='.$view,
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC&page='.$page.'&v='.$view.'")'
            );
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href'  => Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC&page='.$page.'&v='.$view,
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'. Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC&page='.$page.'&v='.$view.'")'
			);
 
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href'  => Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC&page='.$page.'&v='.$view,
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC&page='.$page.'&v='.$view.'")'
			);  

			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href'  => Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC&page='.$page.'&v='.$view,
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'. Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC&page='.$page.'&v='.$view.'")'
			); 

			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href'  => Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC&page='.$page.'&v='.$view,
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC&page='.$page.'&v='.$view.'")'
			); 
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC&page='.$page.'&v='.$view,
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC&page='.$page.'&v='.$view.'")'
			); 
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href' => Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC&page='.$page.'&v='.$view,
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC&page='.$page.'&v='.$view.'")'
			); 	
            
			$this->load->model('store/product');  
			 
			$product_total = $this->modelProduct->getTotalProductsByManufacturerId($this->request->get["manufacturer_id"]);
			
			if ($product_total) {
        		$this->prefetch($sort,$order,$page);									
      		} 
    	
			$pagination = new Pagination(true);
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->ajax = true;
			$pagination->limit = $this->config->get('config_catalog_limit');
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&page={page}';
			
			$this->data['pagination'] = $pagination->render();

            $this->data['sort'] = $sort;
            $this->data['order'] = $order;
                
            $this->data['gridView'] = Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&v=grid';
            $this->data['listView'] = Url::createUrl("store/manufacturer/home") .'&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&v=list';
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products.tpl')) {
                $this->template = $this->config->get('config_template') . '/store/products.tpl';
            } else {
                $this->template = 'cuyagua/store/products.tpl';
            }	
				
            $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    
    
    protected function prefetch($sort,$order,$page) {
        $this->language->load('store/product');
        
        $this->data['heading_title'] = "";
		
		$this->load->model('store/product');
		
		$results = $this->modelProduct->getProductsByManufacturerId($this->request->get["manufacturer_id"], $sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));
        
        require_once(DIR_CONTROLLER . "store/product_array.php");
        
    }
}
