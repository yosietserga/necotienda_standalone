<?php 
class ControllerStoreSearch extends Controller { 	
	public function index() { 
    	$this->language->load('store/search');
	  	  
    	$this->document->title = $this->language->get('heading_title');

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array( 
       		'href'      => HTTP_HOME . 'index.php?r=store/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);
        
    	$this->data['heading_title'] = $this->language->get('heading_title');
   
    	$this->data['text_critea'] = $this->language->get('text_critea');
    	$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_sort'] = $this->language->get('text_sort');
			 
		$this->data['entry_search'] = $this->language->get('entry_search');
    	$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_model'] = $this->language->get('entry_model');
		  
    	$this->data['button_search'] = $this->language->get('button_search');
        
		$url = '';
		
        $this->setvar('keyword');
        $this->setvar('category_id');
        $this->setvar('description');
        $this->setvar('model');
        $this->setvar('sort');
        $this->setvar('order');
        $this->setvar('page');
        $this->setvar('v');
        
		$this->data['url'] = '';
		$this->data['url'] .= !empty($this->data['keyword']) ? '&keyword=' . $this->data['keyword'] : "";
		$this->data['url'] .= !empty($this->data['category_id']) ? '&category_id=' . $this->data['category_id'] : "";
		$this->data['url'] .= !empty($this->data['description']) ? '&description=' . $this->data['description'] : "";
		$this->data['url'] .= !empty($this->data['model']) ? '&model=' . $this->data['model'] : "";
		$this->data['url'] .= !empty($this->data['sort']) ? '&sort=' . $this->data['sort'] : "";
		$this->data['url'] .= !empty($this->data['order']) ? '&order=' . $this->data['order'] : "";
		$this->data['url'] .= !empty($this->data['page']) ? '&page=' . $this->data['page'] : "";
		$this->data['url'] .= !empty($this->data['v']) ? '&v=' . $this->data['v'] : "";
        
        // SCRIPTS
        $scripts = array(
            array('id'=>'search-1',
                  'method'=>'ready',
                  'script'=>"
                        jQuery('#content_search input').keydown(function(e) {
                        	if (e.keyCode == 13) {
                        		contentSearch();
                        	}
                        });
                    "), 
            array('id'=>'search-2','method'=>'function','script'=>"
                        function contentSearch() {
                        	url = 'index.php?r=store/search/home';
                        	
                        	var keyword = jQuery('#keyword').attr('value');
                        	
                        	if (keyword) {
                        		url += '&keyword=' + encodeURIComponent(keyword);
                        	}
                        
                        	var category_id = jQuery('#category_id').attr('value');
                        	
                        	if (category_id) {
                        		url += '&category_id=' + encodeURIComponent(category_id);
                        	}
                        	
                        	if (jQuery('#description').attr('checked')) {
                        		url += '&description=1';
                        	}
                        	
                        	if (jQuery('#model').attr('checked')) {
                        		url += '&model=1';
                        	}
                        
                        	jQuery('#products').load(url);
                        }
                "
                ),
        );
        
        $this->scripts = array_merge($this->scripts,$scripts);
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/store/search.tpl';
		} else {
			$this->template = 'default/store/search.tpl';
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
	
	private function getCategories($parent_id, $level = 0) {
	   $this->load->model("catalog/category");
       
		$level++;
		
		$data = array();
		
		$results = $this->model_catalog_category->getCategories($parent_id);
		
		foreach ($results as $result) {
			$data[] = array(
				'category_id' => $result['category_id'],
				'name'        => str_repeat('&nbsp;&nbsp;&nbsp;', $level) . $result['name']
			);
			
			$children = $this->getCategories($result['category_id'], $level);
			
			if ($children) {
			  $data = array_merge($data, $children);
			}
		}
		
		return $data;
	}	
    
    
    public function home() { 
        
        $this->setvar('keyword');
        $this->setvar('category_id');
        $this->setvar('description');
        $this->setvar('model');
        $this->setvar('sort');
        $this->setvar('order');
        $this->setvar('page');
        $this->setvar('v');
        
		$url = '';
		$url .= !empty($this->data['keyword']) ? '&keyword=' . $this->data['keyword'] : "";
		$url .= !empty($this->data['category_id']) ? '&category_id=' . $this->data['category_id'] : "";
		$url .= !empty($this->data['description']) ? '&description=' . $this->data['description'] : "";
		$url .= !empty($this->data['model']) ? '&model=' . $this->data['model'] : "";
		$url .= !empty($this->data['sort']) ? '&sort=' . $this->data['sort'] : "";
		$url .= !empty($this->data['order']) ? '&order=' . $this->data['order'] : "";
		$url .= !empty($this->data['page']) ? '&page=' . $this->data['page'] : "";
		$url .= !empty($this->data['v']) ? '&v=' . $this->data['v'] : "";
        
		$page = !empty($this->data['page']) ? $this->data['page'] : 1;
		$sort = !empty($this->data['sort']) ? $this->data['sort'] : 'p.sort_order';
		$order = !empty($this->data['order']) ? $this->data['order'] : 'ASC';
		$view = !empty($this->data['v']) ? $this->data['v'] : 'grid';
        
		$this->data['categories'] = $this->getCategories(0);
		
        $this->load->language("store/search");
        $this->load->model("tool/seo_url");
		
        $this->data['sorts'] = array();
				
        $this->data['sorts'][] = array(
					'text'  => $this->language->get('text_default'),
					'value' => 'p.sort_order-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=p.sort_order&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=p.sort_order&order=ASC&page='.$page.'&v='.$view).'")'
        );
				
		$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=pd.name&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=pd.name&order=ASC&page='.$page.'&v='.$view).'")'
			);
 
		$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=pd.name&order=DESC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=pd.name&order=DESC&page='.$page.'&v='.$view).'")'
		);  

		$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=p.price&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=p.price&order=ASC&page='.$page.'&v='.$view).'")'
		); 

		$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=p.price&order=DESC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=p.price&order=DESC&page='.$page.'&v='.$view).'")'
		); 
				
			$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=rating&order=DESC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=rating&order=DESC&page='.$page.'&v='.$view).'")'
		); 
				
		$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href' => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=rating&order=ASC&page='.$page.'&v='.$view),
					'ajax' => true,
					'ajaxFunction'  => 'sort(this,"'.$this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&sort=rating&order=ASC&page='.$page.'&v='.$view).'")'
		); 	
            
		$this->load->model('catalog/product');
        
		$product_total = $this->model_catalog_product->getTotalProductsByKeyword($this->data['keyword'], $this->data['category_id'], $this->data['description'], $this->data['model']);
				
		if ($product_total) {
        		$this->prefetch($sort,$order,$page);									
      	} 
    	
		$pagination = new Pagination(true);
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->ajax = true;
		$pagination->limit = $this->config->get('config_catalog_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;
                
        $this->data['url'] = $url;
        $this->data['gridView'] = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&v=grid');
        $this->data['listView'] = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&v=list');
            
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
        
		$results = $this->model_catalog_product->getProductsByKeyword($this->request->get['keyword'], isset($this->request->get['category_id']) ? $this->request->get['category_id'] : '', isset($this->request->get['description']) ? $this->request->get['description'] : '', isset($this->request->get['model']) ? $this->request->get['model'] : '', $sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));
        		
        require_once(DIR_CONTROLLER . "store/product_array.php");
        
    }
}
