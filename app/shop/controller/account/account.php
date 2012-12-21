<?php 
class ControllerAccountAccount extends Controller { 
	public function index() {
	   if ($this->customer->isLogged() && !$this->customer->getComplete()) {  
      		$this->redirect(HTTP_HOME . 'index.php?r=account/complete_activation');
    	} elseif (!$this->customer->isLogged()) {  
      		$this->session->set('redirect',HTTP_HOME . 'index.php?r=account/account');
	  
	  		$this->redirect(HTTP_HOME . 'index.php?r=account/login');
    	}
	
		$this->language->load('account/account');

      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=account/account',
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);

		$this->document->title = $this->language->get('heading_title');

    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
    	$this->data['text_information'] = $this->language->get('text_information');
    	$this->data['text_password'] = $this->language->get('text_password');
    	$this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_history'] = $this->language->get('text_history');
    	$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');

		if ($this->session->has('success')) {
    		$this->data['success'] = $this->session->get('success');
			$this->session->clear('success');
		} else {
			$this->data['success'] = '';
		}

    	$this->data['information'] = HTTP_HOME . 'index.php?r=account/edit';
    	$this->data['password'] = HTTP_HOME . 'index.php?r=account/password';
		$this->data['address'] = HTTP_HOME . 'index.php?r=account/address';
    	$this->data['history'] = HTTP_HOME . 'index.php?r=account/history';
    	$this->data['download'] = HTTP_HOME . 'index.php?r=account/download';
		$this->data['newsletter'] = HTTP_HOME . 'index.php?r=account/newsletter';
		
        $this->data['text_latest'] = $this->language->get('text_latest');
		
		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/seo_url');
		$this->load->model('tool/image');
		
		$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
		
		$this->data['products'] = array();

		foreach ($this->model_catalog_product->getRandomProducts(8) as $result) {			
			if ($result['image']) {
				$image = $result['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			if ($this->config->get('config_review')) {
				$rating = $this->model_catalog_review->getAverageRating($result['product_id']);	
			} else {
				$rating = false;
			}
			
			$special = false;
			
			$discount = $this->model_catalog_product->getProductDiscount($result['product_id']);
			
			if ($discount) {
				$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			 
				$special = $this->model_catalog_product->getProductSpecial($result['product_id']);
			
				if ($special) {
					$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
				}						
			}
			
			$options = $this->model_catalog_product->getProductOptions($result['product_id']);
					
			if ($options) {
				$add = $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/product&product_id=' . $result['product_id']);
			} else {
				$add = HTTP_HOME . 'index.php?r=checkout/cart&product_id=' . $result['product_id'];
			}
			
          	$this->data['products'][] = array(
                'id'      => $result['product_id'], 
            	'name'    => $result['name'],
				'model'   => $result['model'],
            	'rating'  => $rating,
				'stars'   => sprintf($this->language->get('text_stars'), $rating),
				'thumb'   => $this->model_tool_image->resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                'popup'   => $this->model_tool_image->resize($image, $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
            	'price'   => $price,
            	'options' => $options,
				'special' => $special,
				'href'    => $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/product&product_id=' . $result['product_id']),
				'add'	  => $add
          	);
		}

		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = true;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = true;
		} else {
			$this->data['display_price'] = false;
		}
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/account.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/account.tpl';
		} else {
			$this->template = 'default/account/account.tpl';
		}
		
		$this->children = array(
			'common/nav',
			'common/column_left',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));		
  	}
}
