<?php 
class ControllerStoreSpecial extends Controller { 	
	public function index() { 
    	$this->language->load('store/special');
	  	  
    	$this->document->title = $this->language->get('heading_title');

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTP_HOME . 'index.php?r=store/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
   
		$this->data['text_sort'] = $this->language->get('text_sort');
			 
		$this->load->model('catalog/product');
			
		$product_total = $this->model_catalog_product->getTotalProductSpecials();
						
		if ($product_total) {
		  
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
            
            $this->data['url'] = $url;
            
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/special.tpl')) {
				$this->template = $this->config->get('config_template') . '/store/special.tpl';
			} else {
				$this->template = 'default/store/special.tpl';
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
      		$this->data['text_error'] = $this->language->get('text_empty');

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
            $this->load->language("store/special");
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
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=p.sort_order&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=p.sort_order&order=ASC&page='.$page.'&v='.$view).'")'
            );
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=pd.name&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=pd.name&order=ASC&page='.$page.'&v='.$view).'")'
			);
 
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=pd.name&order=DESC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=pd.name&order=DESC&page='.$page.'&v='.$view).'")'
			);  

			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=p.price&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=p.price&order=ASC&page='.$page.'&v='.$view).'")'
			); 

			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=p.price&order=DESC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=p.price&order=DESC&page='.$page.'&v='.$view).'")'
			); 
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=rating&order=DESC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=rating&order=DESC&page='.$page.'&v='.$view).'")'
			); 
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href' => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=rating&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&sort=rating&order=ASC&page='.$page.'&v='.$view).'")'
			); 	
            
    		$this->load->model('catalog/product');
    			
    		$product_total = $this->model_catalog_product->getTotalProductSpecials();
    						
    		if ($product_total) {
        		$this->prefetch($sort,$order,$page);									
      		} 
    	
			$pagination = new Pagination(true);
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->ajax = true;
			$pagination->limit = $this->config->get('config_catalog_limit');
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&page={page}');
			
			$this->data['pagination'] = $pagination->render();

            $this->data['sort'] = $sort;
            $this->data['order'] = $order;
                
            $this->data['url'] = $url;
            $this->data['gridView'] = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&v=grid');
            $this->data['listView'] = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/special/home' . $url . '&v=list');
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products.tpl')) {
                $this->template = $this->config->get('config_template') . '/store/products.tpl';
            } else {
                $this->template = 'default/store/products.tpl';
            }	
				
            $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    
    
    protected function prefetch($sort,$order,$page) {
        $this->language->load('store/product');
        
		$this->load->model('catalog/product');
        
		$results = $this->model_catalog_product->getProductSpecials($sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));
        	
        require_once(DIR_CONTROLLER . "store/product_array.php");
        
    }
}