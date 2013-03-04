<?php
/**
 * ControllerReportViewedByCustomer
 *  
 * @package NecoTienda powered by opencart 
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerReportViewedByCustomer extends Controller {
	/**
	 * ControllerReportViewedByCustomer::index()
	 * 
     * @see Load
     * @see Language
     * @see Document
     * @see Request
     * @see Session
     * @see Response
	 * @return void
	 */
	public function index() {     
		$this->load->language('report/viewedbycustomer');

		$this->document->title = $this->language->get('heading_title');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
        
        if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'views';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
        
        if (isset($this->request->get['dsort'])) {
			$dsort = $this->request->get['dsort'];
		} else {
			$dsort = 'name';
		}
		
		if (isset($this->request->get['dorder'])) {
			$dorder = $this->request->get['dorder'];
		} else {
			$dorder = 'ASC';
		}
        
        if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = NULL;
		}
        
        if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = NULL;
		}

		if (isset($this->request->get['filter_sdate'])) {
			$filter_sdate = $this->request->get['filter_sdate'];
		} else {
			$filter_sdate = NULL;
		}

		if (isset($this->request->get['filter_fdate'])) {
			$filter_fdate = $this->request->get['filter_fdate'];
		} else {
			$filter_fdate = NULL;
		}

		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
        
        if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
        if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['filter_sdate'])) {
			$url .= '&filter_sdate=' . $this->request->get['filter_sdate'];
		}
		
		if (isset($this->request->get['filter_fdate'])) {
			$url .= '&filter_fdate=' . $this->request->get['filter_fdate'];
		}	
        
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
        
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
        
		if (isset($this->request->get['dsort'])) {
			$url .= '&dsort=' . $this->request->get['dsort'];
		}
        
		if (isset($this->request->get['dorder'])) {
			$url .= '&dorder=' . $this->request->get['dorder'];
		}
						
		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('report/viewedbycustomer') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);		
        
		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_email'	  => $filter_email, 
			'filter_sdate'	  => $filter_sdate,
			'filter_fdate'    => $filter_fdate,
			'sort'            => $sort,
			'order'           => $order,
			'dsort'            => $dsort,
			'dorder'           => $dorder,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
		
		$this->load->auto('report/viewedbycustomer');
		
		$product_total = $this->modelViewedbycustomer->getTotalProductsByCustomerViewed($this->request->get['product_id']); 
        
		$this->data['products'] = $this->modelViewedbycustomer->getProductViewedByCustomerReport($this->request->get['product_id'],$data);
		 
        $this->data['content_excel'] = "Producto ID\tNombre del Producto\tNombre del Cliente\tEmail\tTottal Veces Visto\tPorcentaje\n";
        $this->data['content_csv'] = "Producto ID,Nombre del Producto,Nombre del Cliente,Email,Tottal Veces Visto,Porcentaje\n";
        foreach ($this->data['products'] as $product) { 
            $this->data['content_excel'] .= $product['product_id']."\t".$product['product']."\t".$product['name']."\t".$product['email']."\t".$product['tviewed']."\t".$product['percent']."\n";
            $this->data['content_csv'] .= $product['product_id'].",".$product['product'].",".$product['name'].",".$product['email'].",".$product['tviewed'].",".$product['percent']."\n";
        }
 		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
        
		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_back'] = $this->language->get('button_back');
		
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_viewed'] = $this->language->get('column_viewed');
		$this->data['column_tviewed'] = $this->language->get('column_tviewed');
		$this->data['column_percent'] = $this->language->get('column_percent');
        
		$this->data['column_cname'] = $this->language->get('column_cname');
		$this->data['column_store_name'] = $this->language->get('column_store_name');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_added'] = $this->language->get('column_added');
		
		if ($this->session->has('success')) {
			$this->data['success'] = $this->session->get('success');
		
			$this->session->clear('success');
		} else {
			$this->data['success'] = '';
		}
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_sdate'])) {
			$url .= '&filter_sdate=' . $this->request->get['filter_sdate'];
		}

		if (isset($this->request->get['filter_fdate'])) {
			$url .= '&filter_fdate=' . $this->request->get['filter_fdate'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['back'] = Url::createAdminUrl('report/viewed') . '&sort=name';
		$this->data['sort_name'] = Url::createAdminUrl('report/viewedbycustomer&product_id='.$this->request->get['product_id'].'') . '&sort=name' . $url;
		$this->data['sort_email'] = Url::createAdminUrl('report/viewedbycustomer&product_id='.$this->request->get['product_id'].'') . '&sort=email' . $url;
		$this->data['sort_viewed'] = Url::createAdminUrl('report/viewedbycustomer&product_id='.$this->request->get['product_id'].'') . '&sort=viewed' . $url;
		$this->data['sort_store_name'] = Url::createAdminUrl('report/viewedbycustomer&product_id='.$this->request->get['product_id'].'') . '&sort=store_name' . $url;
		$this->data['sort_ip'] = Url::createAdminUrl('report/viewedbycustomer&product_id='.$this->request->get['product_id'].'') . '&sort=ip' . $url;
		
		$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_sdate'])) {
			$url .= '&filter_sdate=' . $this->request->get['filter_sdate'];
		}

		if (isset($this->request->get['filter_fdate'])) {
			$url .= '&filter_fdate=' . $this->request->get['filter_fdate'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['dsort'])) {
			$url .= '&dsort=' . $this->request->get['dsort'];
		}
												
		if (isset($this->request->get['dorder'])) {
			$url .= '&dorder=' . $this->request->get['dorder'];
		}
		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('report/viewedbycustomer&product_id='.$this->request->get['product_id'].'') . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();
		 
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_sdate'] = $filter_sdate;
		$this->data['filter_fdate'] = $filter_fdate;
				
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['dsort'] = $dsort;
		$this->data['dorder'] = $dorder;
        
		$this->template = 'report/viewedbycustomer.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
}
