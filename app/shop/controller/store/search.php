<?php 
class ControllerStoreSearch extends Controller { 	
	public function index() {
    	$this->document->title = $this->language->get('heading_title');
		$this->document->breadcrumbs = array();
   		$this->document->breadcrumbs[] = array( 
       		'href'      => HTTP_HOME . 'index.php?r=store/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);
        
    	$this->data['heading_title']  = $this->language->get('heading_title');
    	$this->data['text_critea']    = $this->language->get('text_critea');
    	$this->data['text_search']    = $this->language->get('text_search');
		$this->data['text_keyword']   = $this->language->get('text_keyword');
		$this->data['text_category']  = $this->language->get('text_category');
		$this->data['text_empty']     = $this->language->get('text_empty');
		$this->data['text_sort']      = $this->language->get('text_sort');
		$this->data['entry_search']   = $this->language->get('entry_search');
    	$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_model']    = $this->language->get('entry_model');
    	$this->data['button_search']  = $this->language->get('button_search');

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
                  'script'=>"jQuery('#content_search input').keydown(function(e) {
                        	if (e.keyCode == 13) {
                        		contentSearch();
                        	}
                        });
                        $('#products').load('index.php?r=store/search/home" . $this->data['url'] . "');"), 
            array(
                'id'=>'search-2',
                'method'=>'function',
                'script'=>"function contentSearch() {
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
                        }"),
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
		$order= !empty($this->data['order']) ? $this->data['order'] : 'ASC';
		$view = !empty($this->data['v']) ? $this->data['v'] : 'grid';
        
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
            
		$product_total = $this->modelProduct->getTotalProductsByKeyword(
            rawurlencode($this->data['keyword']), 
            (int)$this->data['category_id'], 
            rawurlencode($this->data['description']), 
            rawurlencode($this->data['model'])
        );
				
		if ($product_total) {
            $products = $this->prefetch($sort,$order,$page);
                
            $sql = "SELECT * FROM " . DB_PREFIX . "product_to_category p2c 
                LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = p2c.category_id)
                LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
            WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
                AND p2c.product_id IN (";
                $criteria = "";
            foreach ($products as $product) {
                $criteria .= (int)$product['product_id'] . ",";
            }
            $sql .= $criteria;
            $sql = substr($sql,0,strrpos($sql,',')) . ") GROUP BY c.category_id";
        	$categories = $this->db->query($sql);
                
            foreach ($categories->rows as $category) {
                $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_category p2c 
                WHERE p2c.category_id = " . (int)$category['category_id'];
                $total = $this->db->query($sql);
                $productsByCategory[] = array(
                    'category_id'=>$category['category_id'],
                    'name'=>$category['name'],
                    'total'=>(int)$total->row['total']
                );
            }
            
            $sql = "SELECT * FROM " . DB_PREFIX . "manufacturer m
                LEFT JOIN " . DB_PREFIX . "product p ON (m.manufacturer_id = p.manufacturer_id)
            WHERE p.product_id IN (";
            $sql .= $criteria;
            $sql = substr($sql,0,strrpos($sql,',')) . ") GROUP BY m.manufacturer_id";
        	$brands = $this->db->query($sql);
                
            foreach ($brands->rows as $brand) {
                $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p
                WHERE p.manufacturer_id = " . (int)$brand['manufacturer_id'];
                $total = $this->db->query($sql);
                $productsByBrand[] = array(
                    'manufacturer_id'=>$brand['manufacturer_id'],
                    'name'=>$brand['name'],
                    'total'=>(int)$total->row['total']
                );
            }
            
            $sql = "SELECT * FROM " . DB_PREFIX . "product_tags p
            WHERE  p.language_id = '" . (int)$this->config->get('config_language_id') . "'
                AND p.product_id IN (";
            $sql .= $criteria;
            $sql = substr($sql,0,strrpos($sql,',')) . ") GROUP BY tag";
        	$tags = $this->db->query($sql);
                
            foreach ($tags->rows as $tag) {
                $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_tags p
                WHERE tag = '" . $this->db->escape($tag['tag']) . "'";
                $total = $this->db->query($sql);
                $productsByTag[] = array(
                    'tag'=>$tag['tag'],
                    'total'=>(int)$total->row['total']
                );
            }
            
            $sql = "SELECT * FROM " . DB_PREFIX . "product p
            WHERE p.product_id IN (";
            $sql .= $criteria;
            $sql = substr($sql,0,strrpos($sql,',')) . ") GROUP BY location";
        	$locations = $this->db->query($sql);
                
            foreach ($locations->rows as $location) {
                $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p
                WHERE location = '" . $this->db->escape($location['location']) . "'";
                $total = $this->db->query($sql);
                $productsByLocation[] = array(
                    'location'=>$location['location'],
                    //'url'=>$location['location'],
                    'total'=>(int)$total->row['total']
                );
            }
      	}
        $this->data['productsByCategory'] = $productsByCategory;
        $this->data['productsByBrand']    = $productsByBrand;
        $this->data['productsByTag']      = $productsByTag;
        $this->data['productsByLocation'] = $productsByLocation;
        
        $this->load->auto('pagination');
		$pagination = new Pagination(true);
		$pagination->total = $product_total;
		$pagination->page  = $page;
		$pagination->ajax  = true;
		$pagination->limit = $this->config->get('config_catalog_limit');
		$pagination->text  = $this->language->get('text_pagination');
		$pagination->url   = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();

        $this->data['sort']     = $sort;
        $this->data['order']    = $order;
                
        $this->data['url']      = $url;
        $this->data['gridView'] = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&v=grid');
        $this->data['listView'] = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/search/home' . $url . '&v=list');
            
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products_list.tpl')) {
                $this->template = $this->config->get('config_template') . '/store/products_list.tpl';
        } else {
                $this->template = 'default/store/products_list.tpl';
        }	
				
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    
    
    protected function prefetch($sort,$order,$page) {
		$results = $this->model_catalog_product->getProductsByKeyword(
            $this->request->get['keyword'], 
            isset($this->request->get['category_id']) ? $this->request->get['category_id'] : '', 
            isset($this->request->get['description']) ? $this->request->get['description'] : '', 
            isset($this->request->get['model']) ? $this->request->get['model'] : '', 
            $sort, 
            $order, 
            ($page - 1) * $this->config->get('config_catalog_limit'), 
            $this->config->get('config_catalog_limit')
        );
        		
        require_once(DIR_CONTROLLER . "store/product_array.php");
        return $results;
    }
}
