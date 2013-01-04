<?php   class ControllerCommonHeader extends Controller {
	protected function index() {     
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
		
		$this->data['title']      = $this->document->title;
		$this->data['keywords']   = $this->document->keywords;
		$this->data['description']= $this->document->description;
		$this->data['template']   = $this->config->get('config_template');
		
		
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
        $styles[] = array('media'=>'all','href'=>$csspath.'main.css');
        $styles[] = array('media'=>'all','href'=>$csspath.'screen.css'); 
        $styles[] = array('media'=>'print','href'=>$csspath.'print.css');
        
        $this->load->library('user');
        if ($this->user->getId()) {
            $this->data['is_admin'] = true;
            $styles[] = array('media'=>'screen','href'=>$csspath.'jquery-ui/jquery-ui.min.css');
            $styles[] = array('media'=>'screen','href'=>$csspath.'neco.colorpicker.css');
            $styles[] = array('media'=>'screen','href'=>$csspath.'admin.css');
        }
        
        $this->data['styles'] = $this->styles = array_merge($this->styles,$styles);

        // importamos el archivo css generado desde la administración 
        // para personalizar la apariencia de la tienda, este archivo sobreescribe los parámetros iniciales de estilo
        if (is_file($csspath."custom.css")) {
            $styles = array(
                array('media'=>'all','href'=>$csspath.'custom.css')
            );
            $this->data['styles'] = $this->styles = array_merge($this->styles,$styles);
        }
        
		$this->data['store'] = $this->config->get('config_name');
		
		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = HTTP_IMAGE . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}
        
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
		$this->data['entry_search']   = $this->language->get('entry_search');
		$this->data['button_go']      = $this->language->get('button_go');

		$this->data['home']    = Url::createUrl('common/home');
		$this->data['special'] = Url::createUrl('store/special');
		$this->data['contact'] = Url::createUrl('information/contact');
    	$this->data['sitemap'] = Url::createUrl('information/sitemap');
    	$this->data['account'] = Url::createUrl('account/account');
		$this->data['login']   = Url::createUrl('account/login');
		$this->data['logout']  = Url::createUrl('account/logout');
    	$this->data['cart']    = Url::createUrl('checkout/cart');
		$this->data['checkout']= Url::createUrl('checkout/shipping');
        
		$this->data['logged']  = $this->customer->isLogged();
		
        if ($this->customer->isLogged()) {
       	    $customer_info = $this->modelCustomer->getCustomer($this->customer->getId());
			$this->data['saludos'] = 'Bienvenido(a), '. ucwords($customer_info['firstname'] .' '.$customer_info['lastname']);
            $this->data['enlace'] = Url::createUrl('account/account');
		} else {			
		    $this->data['enlace'] = Url::createUrl('account/register');
            $this->data['saludos'] = 'Quiero Registrarme';
		}
        
		if (isset($this->request->get['keyword'])) {
			$this->data['keyword'] = $this->request->get['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		if (isset($this->request->get['category_id'])) {
			$this->data['category_id'] = $this->request->get['category_id'];
		} elseif (isset($this->request->get['path'])) {
			$path = explode('_', $this->request->get['path']);
		
			$this->data['category_id'] = end($path);
		} else {
			$this->data['category_id'] = '';
		}
        
		
		if (isset($this->request->get['product_id'])) {
			$auto_suggest = $this->request->get['product_id'];
		} else {
			$auto_suggest = 0;
		}
        
        if ($auto_suggest) {
            $this->document->auto_suggest = $auto_suggest['name'];
        }
		
		$this->data['advanced'] = Url::createUrl('product/search');
		
		
		$this->data['categories'] = $this->getCategories(0);
		
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
			
			$this->data['redirect'] = $this->model_tool_seo_url->rewrite(Url::createUrl($route,$url));
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
	
	private function getCategories($parent_id, $level = 0) {
		$level++;
		
		$data = array();
		
		$results = $this->model_catalog_category->getCategories($parent_id);
		
		foreach ($results as $result) {
			$data[] = array(
				'category_id' => $result['category_id'],
				'name'        => str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . $result['name']
			);
			
			$children = $this->getCategories($result['category_id'], $level);
			
			if ($children) {
			  $data = array_merge($data, $children);
			}
		}
		
		return $data;
	}
}
