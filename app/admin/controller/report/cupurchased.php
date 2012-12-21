<?php
class ControllerReportCUPurchased extends Controller { 
	public function index() {   
		$this->load->language('report/cupurchased');

		$this->document->title = $this->language->get('heading_title');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

   		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('report/cupurchased') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);		
		
		$this->load->auto('report/cupurchased');
		
		$product_total = $this->modelCupurchased->getTotalOrderedProducts();
		
		$this->data['products'] = array();

		$results = $this->modelCupurchased->getCustomerPurchasedReport(($page - 1) * $this->config->get('config_admin_limit'), $this->config->get('config_admin_limit'));
		
		foreach ($results as $result) {
			$this->data['products'][] = array(
				'cname'     => $result['cname'],
				'email'     => $result['email'],
				'quantity' => $result['quantity'],
				'total'    => $this->currency->format($result['total'], $this->config->get('config_currency'))
			);
		}
		$this->data['content_excel'] = "Nombre del Cliente\tEmail\tCantidad\tCosto\n";
        $this->data['content_csv'] = "Nombre del Cliente,Email,Cantidad,Costo\n";
        foreach ($this->data['products'] as $product) { 
            $this->data['content_excel'] .= $product['cname']."\t".$product['email']."\t".$product['quantity']."\t".$product['total']."\t\n";
            $this->data['content_csv'] .= $product['cname'].",".$product['email'].",".$product['quantity'].",".$product['total']."\n";
        }
        
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_total'] = $this->language->get('column_total');

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('report/cupurchased') . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();		
		
		$this->template = 'report/cupurchased.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}	
}
