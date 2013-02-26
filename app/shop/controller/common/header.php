<?php   class ControllerCommonHeader extends Controller {
	protected function index() {
        $this->data['Url'] = new Url;
        
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['language_code'])) {
			$this->session->set('language',$this->request->post['language_code']);
		
			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect']);
			} else {
				$this->redirect(Url::createUrl('common/home'));
			}
    	}		
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['currency_code'])) {
      		$this->currency->set($this->request->post['currency_code']);
			$this->session->clear('shipping_methods');
			$this->session->clear('shipping_method');
			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect']);
			} else {
				$this->redirect(Url::createUrl('common/home'));
			}
   		}
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_HOME;
		} else {
			$this->data['base'] = HTTP_HOME;
		}
		
		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = HTTP_IMAGE . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}
		
		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = HTTP_IMAGE . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}
        
		$this->data['title']      = $this->document->title;
		$this->data['keywords']   = $this->document->keywords;
		$this->data['description']= $this->document->description;
		$this->data['template']   = $this->config->get('config_template');
		$this->data['charset']    = $this->language->get('charset');
		$this->data['lang']       = $this->language->get('code');
		$this->data['direction']  = $this->language->get('direction');
		$this->data['links']      = $this->document->links;	
		$this->data['styles']     = $this->document->styles;
		$this->data['scripts']    = $this->document->scripts;		
		$this->data['breadcrumbs']= $this->document->breadcrumbs;
        
        // style files
        $csspath = defined("CDN_CSS") ? CDN_CSS : HTTP_CSS;
        //TODO: detectar browser y cargar el estilo adecuado
        $styles[] = array('media'=>'all','href'=>$csspath.'screen.css'); 
        //$styles[] = array('media'=>'print','href'=>$csspath.'print.css');
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
			$styles[] = array('media'=>'all','href'=> str_replace('%theme%',$this->config->get('config_template'),HTTP_THEME_CSS) . 'theme.css');
		} else {
			$styles[] = array('media'=>'all','href'=> str_replace('%theme%','default',HTTP_THEME_CSS) . 'theme.css');
		}
        
        $this->load->library('user');
        if ($this->user->getId()) {
            $this->data['is_admin'] = true;
            $styles[] = array('media'=>'screen','href'=>$csspath.'jquery-ui/jquery-ui.min.css');
            $styles[] = array('media'=>'screen','href'=>$csspath.'neco.colorpicker.css');
            $styles[] = array('media'=>'screen','href'=>$csspath.'admin.css');
            
            
            $this->data['create_product']= Url::createAdminUrl('store/product/insert',array(),'NONSSL',HTTP_ADMIN);
            $this->data['create_page']= Url::createAdminUrl('content/page/insert',array(),'NONSSL',HTTP_ADMIN);
            $this->data['create_post']= Url::createAdminUrl('content/post/insert',array(),'NONSSL',HTTP_ADMIN);
            $this->data['create_manufacturer']= Url::createAdminUrl('store/manufacturer/insert',array(),'NONSSL',HTTP_ADMIN);
            $this->data['create_product_category']= Url::createAdminUrl('store/category/insert',array(),'NONSSL',HTTP_ADMIN);
            $this->data['create_post_category']= Url::createAdminUrl('content/post_category/insert',array(),'NONSSL',HTTP_ADMIN);
        }
        $this->data['styles'] = $this->styles = array_merge($styles,$this->styles);

        if (is_file($csspath."custom.css")) {
            $styles[] = array('media'=>'all','href'=>$csspath.'custom.css');
            $this->data['styles'] = $this->styles = array_merge($this->styles,$styles);
        }
        
		$this->data['store'] = $this->config->get('config_name');
		
		$this->data['text_store']     = $this->config->get('config_name');
		$this->data['text_home']      = $this->language->get('text_home');
		$this->data['text_special']   = $this->language->get('text_special');
		$this->data['text_contact']   = $this->language->get('text_contact');
		$this->data['text_sitemap']   = $this->language->get('text_sitemap');
		$this->data['text_bookmark']  = $this->language->get('text_bookmark');
    	$this->data['text_account']   = $this->language->get('text_account');
    	$this->data['text_login']     = $this->language->get('text_login');
    	$this->data['text_logout']    = $this->language->get('text_logout');
    	$this->data['text_cart']      = $this->language->get('text_cart'); 
    	$this->data['text_checkout']  = $this->language->get('text_checkout');
		$this->data['text_keyword']   = $this->language->get('text_keyword');
		$this->data['text_category']  = $this->language->get('text_category');
		$this->data['text_advanced']  = $this->language->get('text_advanced');
		$this->data['text_my_actitivties']= $this->language->get('text_my_actitivties');
		$this->data['text_my_reviews']    = $this->language->get('text_my_reviews');
		$this->data['text_my_orders']     = $this->language->get('text_my_orders');
		$this->data['text_my_addresses']  = $this->language->get('text_my_addresses');
		$this->data['text_my_account']    = $this->language->get('text_my_account');
		$this->data['text_credits']       = $this->language->get('text_credits');
		$this->data['text_payments']      = $this->language->get('text_payments');
		$this->data['text_messages']      = $this->language->get('text_messages');
		$this->data['text_compare']       = $this->language->get('text_compare');
		$this->data['text_my_lists']      = $this->language->get('text_my_lists');
		$this->data['text_forgotten']     = $this->language->get('text_forgotten');
        
		$this->data['entry_search']   = $this->language->get('entry_search');
		$this->data['button_go']      = $this->language->get('button_go');

		$this->data['isLogged']  = $this->customer->isLogged();
		
        if ($this->customer->isLogged()) {
			$this->data['greetings'] = 'Bienvenido(a), '. ucwords($this->customer->getFirstName() .' '. $this->customer->getLastName());
		}
        
		if (isset($this->request->get['q'])) {
			$this->data['q'] = $this->request->get['q'];
		} else {
			$this->data['q'] = '';
		}
		
		if (isset($this->request->get['category_id'])) {
			$this->data['category_id'] = $this->request->get['category_id'];
		} elseif (isset($this->request->get['path'])) {
			$path = explode('_', $this->request->get['path']);
			$this->data['category_id'] = end($path);
		} else {
			$this->data['category_id'] = 0;
		}
        
		if (isset($this->request->get['product_id'])) {
			$this->data['product_id'] = $this->request->get['product_id'];
		} else {
			$this->data['product_id'] = 0;
		}
        
		if (isset($this->request->get['manufacturer_id'])) {
			$this->data['manufacturer_id'] = $this->request->get['manufacturer_id'];
		} else {
			$this->data['manufacturer_id'] = 0;
		}
        
        /*
        // Auto suggest through email and while is online
        $this->track->autoSuggest(array(
            'category_id'       =>$this->data['category_id'],
            'product_id'        =>$this->data['product_id'],
            'manufacturer_id'   =>$this->data['manufacturer_id'],
            'q'                 =>$this->data['q']
        ));
		*/
        
		$this->data['action'] = Url::createUrl('common/home');

		if (!isset($this->request->get['r'])) {
			$this->data['redirect'] = Url::createUrl('common/home');
		} else {			
			$data = $this->request->get;
			unset($data['_route_']);
			$route = $data['r'];
			unset($data['r']);
			$url = '';
			
			if ($data) {
				$url = '&' . urldecode(http_build_query($data));
			}			
			
			$this->data['redirect'] = $this->modelSeo_url->rewrite(Url::createUrl($route,$url));
		}
		
		$this->data['language_code'] = $this->session->get('language');
		$this->data['languages'] = array();
		$results = $this->modelLanguage->getLanguages();
		
		foreach ($results as $result) {
			if ($result['status']) {
				$this->data['languages'][] = array(
					'name'  => $result['name'],
					'code'  => $result['code'],
					'image' => HTTP_IMAGE . "flags/" . $result['image']
				);	
			}
		}
		
		$this->data['currency_code'] = $this->currency->getCode();
	    $this->data['currencies'] = array();
		$results = $this->model_localisation_currency->getCurrencies();	
		
		foreach ($results as $result) {
			if ($result['status']) {
   				$this->data['currencies'][] = array(
					'title' => $result['title'],
					'code'  => $result['code']
				);
			}
		}
        
		$this->id = 'header';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
			$this->template = $this->config->get('config_template') . '/common/header.tpl';
		} else {
			$this->template = 'default/common/header.tpl';
		}
		
    	$this->render();
	}
}
