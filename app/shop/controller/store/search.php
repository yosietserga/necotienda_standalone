<?php 
class ControllerStoreSearch extends Controller { 	
	public function index() { 
    	$this->language->load('store/search');
    	$this->load->library('url');
	  	  
    	$this->document->title = $this->language->get('heading_title');

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array( 
       		'href'      => Url::createUrl("common/home"),
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
        
		$data['filter_keyword']       = $this->request->hasQuery('q') ? $this->request->getQuery('q') : null;
		$data['filter_price_start']   = $this->request->hasQuery('ps') ? $this->request->getQuery('ps') : null;
		$data['filter_price_end']     = $this->request->hasQuery('pe') ? $this->request->getQuery('pe') : null;
		$data['filter_color']         = $this->request->hasQuery('co') ? $this->request->getQuery('co') : null;
		$data['filter_category']      = $this->request->hasQuery('c') ? $this->request->getQuery('c') : null;
		$data['filter_manufacturer']  = $this->request->hasQuery('m') ? $this->request->getQuery('m') : null;
        
		$data['page']   = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
		$data['sort']   = $this->request->hasQuery('sort') ? $this->request->getQuery('sort') : 'pd.name';
		$data['order']  = $this->request->hasQuery('order') ? $this->request->getQuery('order') : 'ASC';
		$data['limit']  = $this->request->hasQuery('limit') ? $this->request->getQuery('limit') : $this->config->get('config_catalog_limit');
        
        $params = explode(" ",$this->request->getQuery('q'));
        $data['keyword'] = $params[0];
        if (count($params)) {
            foreach ($params as $value) {        
                if (strrpos($value,'c_') !== false) {
                    $data['category'] = str_replace('c_','',$value);
                }
                      
                if (strrpos($value,'m_') !== false) {
                    $data['manufacturer'] = str_replace('m_','',$value);
                }
                
                if (strrpos($value,'ps_') !== false) {
                    $data['price_start'] = str_replace('ps_','',$value);
                }
                
                if (strrpos($value,'pe_') !== false) {
                    $data['price_end'] = str_replace('pe_','',$value);
                }
                
                if (strrpos($value,'co_') !== false) {
                    $data['color'] = str_replace('co_','',$value);
                }
            }
        }
        
        
		
        $this->data['sorts'] = array();
        
		$url = '';
		if ($this->request->hasQuery('q'))    { $url .= '&q=' . $this->request->getQuery('q'); }
		if ($this->request->hasQuery('ps'))   { $url .= '&ps=' . $this->request->getQuery('ps'); }
		if ($this->request->hasQuery('pe'))   { $url .= '&pe=' . $this->request->getQuery('pe'); }
		if ($this->request->hasQuery('co'))   { $url .= '&co=' . $this->request->getQuery('co'); }
		if ($this->request->hasQuery('c'))    { $url .= '&c=' . $this->request->getQuery('c'); }
		if ($this->request->hasQuery('m'))    { $url .= '&m=' . $this->request->getQuery('m'); }
		if ($this->request->hasQuery('page')) { $url .= '&page=' . $this->request->getQuery('page'); }
		if ($this->request->hasQuery('limit')){ $url .= '&limit=' . $this->request->getQuery('limit'); }
		if ($this->request->hasQuery('v'))    { $url .= '&v=' . $this->request->getQuery('v'); }
        
        $this->data['sorts'][] = array(
            'text'  => $this->language->get('text_default'),
            'value' => 'p.sort_order-ASC',
			'href'  => Url::createUrl("store/search",'&sort=p.sort_order&order=ASC'. $url)
        );
        
		$this->data['sorts'][] = array(
            'text'  => $this->language->get('text_name_asc'),
			'value' => 'pd.name-ASC',
			'href'  => Url::createUrl("store/search",'&sort=pd.name&order=ASC'. $url)
			);
 
		$this->data['sorts'][] = array(
            'text'  => $this->language->get('text_name_desc'),
			'value' => 'pd.name-DESC',
			'href'  => Url::createUrl("store/search",'&sort=pd.name&order=DESC'. $url)
		);  

		$this->data['sorts'][] = array(
            'text'  => $this->language->get('text_price_asc'),
            'value' => 'p.price-ASC',
			'href'  => Url::createUrl("store/search",'&sort=p.price&order=ASC'. $url)
		); 

		$this->data['sorts'][] = array(
            'text'  => $this->language->get('text_price_desc'),
            'value' => 'p.price-DESC',
			'href'  => Url::createUrl("store/search",'&sort=p.price&order=DESC'. $url)
		); 
        
		$this->data['sorts'][] = array(
            'text'  => $this->language->get('text_rating_asc'),
            'value' => 'p.rating-ASC',
			'href'  => Url::createUrl("store/search",'&sort=p.rating&order=ASC'. $url)
		); 

		$this->data['sorts'][] = array(
            'text'  => $this->language->get('text_rating_desc'),
            'value' => 'p.rating-DESC',
			'href'  => Url::createUrl("store/search",'&sort=p.rating&order=DESC'. $url)
		);
        
		$this->load->model('store/product');
		$product_total = $this->modelProduct->getTotalByKeyword($data);
		if ($product_total) {
        
		    $this->data['filterCategories'] = $this->modelProduct->getCategoriesByProduct($data);
    		
    		$url = '';
    		if ($this->request->hasQuery('q'))    { $url .= '&q=' . $this->request->getQuery('q'); }
    		if ($this->request->hasQuery('ps'))   { $url .= '&ps=' . $this->request->getQuery('ps'); }
    		if ($this->request->hasQuery('pe'))   { $url .= '&pe=' . $this->request->getQuery('pe'); }
    		if ($this->request->hasQuery('co'))   { $url .= '&co=' . $this->request->getQuery('co'); }
    		if ($this->request->hasQuery('c'))    { $url .= '&c=' . $this->request->getQuery('c'); }
    		if ($this->request->hasQuery('m'))    { $url .= '&m=' . $this->request->getQuery('m'); }
    		if ($this->request->hasQuery('order')){ $url .= '&order=' . $this->request->getQuery('order'); }
    		if ($this->request->hasQuery('sort')) { $url .= '&sort=' . $this->request->getQuery('sort'); }
    		if ($this->request->hasQuery('limit')){ $url .= '&limit=' . $this->request->getQuery('limit'); }
    		if ($this->request->hasQuery('v'))    { $url .= '&v=' . $this->request->getQuery('v'); }
            
            $this->prefetch($data);
            
            $topPrice       = $this->data['topPrice']['value'];
            $bottomPrice    = $this->data['bottomPrice']['value'];
            $diff           = ($topPrice - $bottomPrice) * 0.20;
            if ($diff > 0) {
                while (true) {
                    $topPrice    = $bottomPrice + $diff -  + 0.01;                    
                    if ($topPrice >= $this->data['topPrice']['value']) {
                        $topPrice = $this->data['topPrice']['value'];
                        $break = true;
                    }
                    
                    $this->data['filterPrices'][] = array(
                        'bottomValue'   => round($bottomPrice,2),
                        'bottomText'    => $this->currency->format($this->tax->calculate($bottomPrice, $this->data['topPrice']['tax_class_id'], $this->config->get('config_tax'))),
                        'topValue'      => round($topPrice,2),
                        'topText'       => $this->currency->format($this->tax->calculate($topPrice, $this->data['topPrice']['tax_class_id'], $this->config->get('config_tax')))
                    );
                    
                    if ($break) break;
                    $bottomPrice = $topPrice + 0.01;
                }
            }
            
            foreach ($this->data['products'] as $key => $value) {
                if (empty($value['manufacturer'])) continue;
                $this->data['filterManufacturers'][$value['manufacturer_id']] = $value['manufacturer'];
            }
            
            $this->load->library('pagination');
        	$pagination = new Pagination(true);
        	$pagination->total = $product_total;
        	$pagination->page  = $data['page'];
        	$pagination->limit = $data['limit'];
        	$pagination->text  = $this->language->get('text_pagination');
        	$pagination->url   = Url::createUrl("store/search",$url . '&page={page}');
        			
       		$this->data['pagination'] = $pagination->render();					
      	
        
            $this->data['filters'] = array();
            $url = $urlCategories = $urlManufacturers = $urlColors = $urlPrices = '';
            if ($this->request->hasQuery('q'))    { 
                $urlCategories .= '&q=' . $this->request->getQuery('q'); 
                $urlManufacturers .= '&q=' . $this->request->getQuery('q'); 
                $urlColors .= '&q=' . $this->request->getQuery('q'); 
                $urlPrices .= '&q=' . $this->request->getQuery('q');
                $url .= '&q=' . $this->request->getQuery('q');
            }
        	if ($this->request->hasQuery('ps'))   { 
                $urlCategories .= '&ps=' . $this->request->getQuery('ps'); 
                $urlManufacturers .= '&ps=' . $this->request->getQuery('ps'); 
                $urlColors .= '&ps=' . $this->request->getQuery('ps');
                $url .= '&ps=' . $this->request->getQuery('ps');
            }
        	if ($this->request->hasQuery('pe'))   { 
                $urlCategories .= '&pe=' . $this->request->getQuery('pe'); 
                $urlManufacturers .= '&pe=' . $this->request->getQuery('pe'); 
                $urlColors .= '&pe=' . $this->request->getQuery('pe');
                $url .= '&pe=' . $this->request->getQuery('pe');
            }
        	if ($this->request->hasQuery('co'))   { 
                $urlCategories .= '&co=' . $this->request->getQuery('co');
                $urlManufacturers .= '&co=' . $this->request->getQuery('co');
                $urlPrices .= '&co=' . $this->request->getQuery('co');
                $url .= '&co=' . $this->request->getQuery('co');
                $this->data['filters'][] = array(
                    'param'=>'urlColors',
                    'text' => $this->request->getQuery('co')
                );
            }
        	if ($this->request->hasQuery('c'))    { 
                $urlManufacturers .= '&c=' . $this->request->getQuery('c');
                $urlColors .= '&c=' . $this->request->getQuery('c');
                $urlPrices .= '&c=' . $this->request->getQuery('c');
                $url .= '&c=' . $this->request->getQuery('c');
                $this->data['filters'][] = array(
                    'param'=>'urlCategories',
                    'text' => $this->request->getQuery('c')
                );
            }
        	if ($this->request->hasQuery('m'))    { 
                $urlCategories .= '&m=' . $this->request->getQuery('m');
                $urlColors .= '&m=' . $this->request->getQuery('m');
                $urlPrices .= '&m=' . $this->request->getQuery('m');
                $url .= '&m=' . $this->request->getQuery('m');
                $this->data['filters'][] = array(
                    'param'=>'urlManufacturers',
                    'text' => $this->request->getQuery('m')
                );
            }
        	if ($this->request->hasQuery('page')){ 
                $urlCategories .= '&page=' . $this->request->getQuery('page');
                $urlManufacturers .= '&page=' . $this->request->getQuery('page');
                $urlColors .= '&page=' . $this->request->getQuery('page');
                $urlPrices .= '&page=' . $this->request->getQuery('page');
                $url .= '&page=' . $this->request->getQuery('page');
            }
        	if ($this->request->hasQuery('order')){ 
                $urlCategories .= '&order=' . $this->request->getQuery('order');
                $urlManufacturers .= '&order=' . $this->request->getQuery('order');
                $urlColors .= '&order=' . $this->request->getQuery('order');
                $urlPrices .= '&order=' . $this->request->getQuery('order');
                $url .= '&order=' . $this->request->getQuery('order');
            }
        	if ($this->request->hasQuery('sort')) { 
                $urlCategories .= '&sort=' . $this->request->getQuery('sort');
                $urlManufacturers .= '&sort=' . $this->request->getQuery('sort');
                $urlColors .= '&sort=' . $this->request->getQuery('sort');
                $urlPrices .= '&sort=' . $this->request->getQuery('sort');
                $url .= '&sort=' . $this->request->getQuery('sort');
            }
        	if ($this->request->hasQuery('limit')){ 
                $urlCategories .= '&limit=' . $this->request->getQuery('limit');
                $urlManufacturers .= '&limit=' . $this->request->getQuery('limit');
                $urlColors .= '&limit=' . $this->request->getQuery('limit');
                $urlPrices .= '&limit=' . $this->request->getQuery('limit');
                $url .= '&limit=' . $this->request->getQuery('limit');
            }
        	if ($this->request->hasQuery('v'))    { 
                $urlCategories .= '&v=' . $this->request->getQuery('v');
                $urlManufacturers .= '&v=' . $this->request->getQuery('v');
                $urlColors .= '&v=' . $this->request->getQuery('v');
                $urlPrices .= '&v=' . $this->request->getQuery('v');
            }
        	if ($this->request->hasQuery('ps') && $this->request->hasQuery('pe'))   { 
                $this->data['filters'][] = array(
                    'param'=>'urlPrices',
                    'text' => $this->currency->format($this->tax->calculate($this->request->getQuery('ps'), $this->data['topPrice']['tax_class_id'], $this->config->get('config_tax'))) ." - ". $this->currency->format($this->tax->calculate($this->request->getQuery('pe'), $this->data['topPrice']['tax_class_id'], $this->config->get('config_tax')))
                );
            }
                
            $this->data['gridView'] = Url::createUrl("store/search", $url . '&v=grid');
            $this->data['listView'] = Url::createUrl("store/search", $url . '&v=list');
            
        	if ($this->request->hasQuery('v')){ $url .= '&v=' . $this->request->getQuery('v'); }
            
            $this->data['urlCategories']    = $urlCategories;
            $this->data['urlManufacturers'] = $urlManufacturers;
            $this->data['urlColors']        = $urlColors;
            $this->data['urlPrices']        = $urlPrices;
            $this->data['url']              = $url;
            
            $this->load->model("store/search");
            $this->modelSearch->add();
        } else {
            $this->prefetch($data,true);
            $this->data['noResults'] = true;
        }
        
        $this->data['breadcrumbs'] = $this->document->breadcrumbs;
        // style files
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
            
        // SCRIPTS
        $scripts[] = array('id'=>'search-1','method'=>'ready','script'=>
            "$('#content_search input').keydown(function(e) {
               	if (e.keyCode == 13 && $(this).val().length > 0) {
              		contentSearch();
               	}
            });
            if (window.location.hash.length > 0) {
                $('#products').load('". Url::createUrl("store/search") ."&q='+ window.location.hash.replace('#', ''));
            }");
        $scripts[] = array('id'=>'search-2','method'=>'window','script'=>
            "$('.filter').mCustomScrollbar({
                scrollButtons:{
                    enable:true
                },
                theme:'dark'
            });");
        
        $this->scripts = array_merge($this->scripts,$scripts);
        
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
            
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/store/search.tpl';
		} else {
			$this->template = 'cuyagua/store/search.tpl';
		}
		
		$this->children[] = 'common/footer';
		$this->children[] = 'common/column_left';
		$this->children[] = 'common/nav';
		$this->children[] = 'common/header';
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
	
    protected function prefetch($data,$featured=null) {
        $this->language->load('store/product');
		$this->load->model('store/product');
        $data['start'] = ($data['page'] - 1) * $data['limit'];
        if (!$featured) {
            $results = $this->modelProduct->getByKeyword($data);
        } else {
            $results = $this->modelProduct->getRandomProducts($data['limit']);
        }
		
		$this->load->auto('store/review');
      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_see_product'] = $this->language->get('button_see_product');
		$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
		$this->data['products'] = array();
		$topPrice = 0;
		$bottomPrice = 1000000000;
		foreach ($results as $result) {
		    $image = !empty($result['image']) ? $result['image'] : 'no_image.jpg';

			if ($this->config->get('config_review')) {
				$rating = $this->modelReview->getAverageRating($result['product_id']);	
			} else {
				$rating = false;
			}
            
            if ($result['price'] > $topPrice) {
                $this->data['topPrice'] = array(
                    'value' => $result['price'],
                    'tax_class_id' => $result['tax_class_id']
                );
                $topPrice = $result['price'];
            }
            
            if ($result['price'] < $bottomPrice) {
                $this->data['bottomPrice'] = array(
                    'value' => $result['price'],
                    'tax_class_id' => $result['tax_class_id']
                );
                $bottomPrice = $result['price'];
            }
            
			$special = false;
			$discount = $this->modelProduct->getProductDiscount($result['product_id']);
			
			if ($discount) {
				$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				$special = $this->modelProduct->getProductSpecial($result['product_id']);
				if ($special) {
					$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
				}						
			}
						
			$options = $this->modelProduct->getProductOptions($result['product_id']);
			
			if ($options) {
				$add = Url::createUrl('store/product',array('product_id'=>$result['product_id']));
			} else {
				$add = Url::createUrl('checkout/cart',array('product_id'=>$result['product_id']));
			}
			$this->load->auto('image');
			$this->data['products'][] = array(
				'product_id'    => $result['product_id'],
				'name'    		=> $result['name'],
				'model'   		=> $result['model'],
				'overview'   	=> $result['meta_description'],
				'rating'  		=> $rating,
				'stars'   		=> sprintf($this->language->get('text_stars'), $rating),
				'price'   		=> $price,
				'options'   	=> $options,
				'special' 		=> $special,
				'image'   		=> NTImage::resizeAndSave($image, 38, 38),
				'lazyImage'   		=> NTImage::resizeAndSave('no_image.jpg', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
				'thumb'   		=> NTImage::resizeAndSave($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
				'href'    		=> Url::createUrl('store/product',array('product_id'=>$result['product_id'])),
				'add'    		=> $add
			);
		}

		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = true;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = true;
		} else {
			$this->data['display_price'] = false;
		}
        
    }
}
