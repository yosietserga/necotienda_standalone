<?php 
class ControllerStoreManufacturer extends Controller {  
	public function index() { 
		$this->language->load('store/manufacturer');

		$this->load->model('catalog/manufacturer');
		$this->load->model('tool/seo_url'); 
		$this->document->breadcrumbs = array();
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=store/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	);

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = $this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}
		
        $this->data['manufacturer_id'] = $manufacturer_id;
        
		$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
	
		if ($manufacturer_info) {
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer&manufacturer_id=' . $this->request->get['manufacturer_id']),
        		'text'      => $manufacturer_info['name'],
        		'separator' => $this->language->get('text_separator')
      		);
					  		
			$this->document->title = $manufacturer_info['name'];
									
			$this->data['heading_title'] = $manufacturer_info['name'];

			$this->data['text_sort'] = $this->language->get('text_sort');
			
            
            if ($this->customer->isLogged()) {
    		     $customer_id = $this->session->get('customer_id');
    		} else {
    		     $customer_id = 0;
    		}
            $this->model_catalog_manufacturer->updateViewed($this->request->get['manufacturer_id'],$customer_id);
				
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/manufacturer.tpl')) {
				$this->template = $this->config->get('config_template') . '/store/manufacturer.tpl';
			} else {
				$this->template = 'default/store/manufacturer.tpl';
			}	
				
			$this->children = array(
        			'common/nav',
        			'common/column_left',
        			'common/column_right',
        			'common/footer',
        			'common/header'
		     );	
				
			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));										
      		
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
        		'href'      => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer&manufacturer_id=' . $manufacturer_id . $url),
        		'text'      => $this->language->get('text_error'),
        		'separator' => $this->language->get('text_separator')
      		);
					
			$this->document->title = $this->language->get('text_error');

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = HTTP_HOME . 'index.php?r=store/home';
	  			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/error/not_found.tpl';
			} else {
				$this->template = 'default/error/not_found.tpl';
			}
			
			$this->children = array(
			'common/nav',
			'common/column_left',
			'common/column_right',
			'common/footer',
			'common/header'
		);		
			
			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
		}
  	}
    
    public function home() { 
            $this->load->language("store/manufacturer");
			$this->load->model("tool/seo_url");
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
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC&page='.$page.'&v='.$view).'")'
            );
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC&page='.$page.'&v='.$view).'")'
			);
 
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC&page='.$page.'&v='.$view).'")'
			);  

			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC&page='.$page.'&v='.$view).'")'
			); 

			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC&page='.$page.'&v='.$view).'")'
			); 
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC&page='.$page.'&v='.$view).'")'
			); 
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href' => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC&page='.$page.'&v='.$view).'")'
			); 	
            
			$this->load->model('catalog/product');  
			 
			$product_total = $this->model_catalog_product->getTotalProductsByManufacturerId($this->request->get["manufacturer_id"]);
			
			if ($product_total) {
        		$this->prefetch($sort,$order,$page);									
      		} 
    	
			$pagination = new Pagination(true);
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->ajax = true;
			$pagination->limit = $this->config->get('config_catalog_limit');
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&page={page}');
			
			$this->data['pagination'] = $pagination->render();

            $this->data['sort'] = $sort;
            $this->data['order'] = $order;
                
            $this->data['gridView'] = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&v=grid');
            $this->data['listView'] = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/manufacturer/home&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&v=list');
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products.tpl')) {
                $this->template = $this->config->get('config_template') . '/store/products.tpl';
            } else {
                $this->template = 'default/store/products.tpl';
            }	
				
            $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    
    
    protected function prefetch($sort,$order,$page) {
        $this->language->load('store/product');
        
        $this->data['heading_title'] = "";
		
		$this->load->model('catalog/product');
		
		$results = $this->model_catalog_product->getProductsByManufacturerId($this->request->get["manufacturer_id"], $sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));
        
        require_once(DIR_CONTROLLER . "store/product_array.php");
        
    }
}
