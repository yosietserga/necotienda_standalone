<?php
class ControllerReportPurchased extends Controller { 
	public function index() {   
		$this->load->language('report/purchased');

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
       		'href'      => Url::createAdminUrl('report/purchased') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);		
		
		$this->load->auto('report/purchased');
		
		$product_total = $this->modelPurchased->getTotalOrderedProducts();
		
		$this->data['products'] = array();

		$results = $this->modelPurchased->getProductPurchasedReport(($page - 1) * $this->config->get('config_admin_limit'), $this->config->get('config_admin_limit'));
		
		foreach ($results as $result) {
			$this->data['products'][] = array(
				'name'     => $result['name'],
				'model'    => $result['model'],
				'quantity' => $result['quantity'],
				'total'    => $this->currency->format($result['total'], $this->config->get('config_currency'))
			);
		}
		
        $this->data['content_excel'] = "Fabricante ID\tNombre\tTottal Veces Visto\tFiltrado Veces Visto\tPorcentaje\n";
        $this->data['content_csv'] = "Fabricante ID,Nombre,Tottal Veces Visto,Filtrado Veces Visto,Porcentaje\n";
        foreach ($this->data['products'] as $product) { 
            $this->data['content_excel'] .= $product['name']."\t".$product['model']."\t".$product['quantity']."\t".$product['total']."\n";
            $this->data['content_csv'] .= $product['name'].",".$product['model'].",".$product['quantity'].",".$product['total']."\n";
        }
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_total'] = $this->language->get('column_total');

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('report/purchased') . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();		
		
		$this->template = 'report/purchased.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}	
}
