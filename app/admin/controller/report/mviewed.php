<?php
/**
 * ControllerReportMViewed
 *  
 * @package NecoTienda powered by opencart 
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerReportMViewed extends Controller {
	/**
	 * ControllerReportMViewed::index()
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
		$this->load->language('report/mviewed');

		$this->document->title = $this->language->get('heading_title');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
        
        if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'viewed';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
        
        if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = NULL;
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
        
		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('report/mviewed') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);		
        
		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_sdate'	  => $filter_sdate,
			'filter_fdate'    => $filter_fdate,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
        
		$this->load->auto('store/manufacturer');
		
		$manufacturer_total = $this->modelManufacturer->getTotalManufacturers(); 
		
		$this->load->auto('report/mviewed');
		
		$this->data['manufacturers'] = $this->modelMviewed->getManufacturerViewedReport($data);
		 
        $this->data['content_excel'] = "Fabricante ID\tNombre\tTottal Veces Visto\tFiltrado Veces Visto\tPorcentaje\n";
        $this->data['content_csv'] = "Fabricante ID,Nombre,Tottal Veces Visto,Filtrado Veces Visto,Porcentaje\n";
        foreach ($this->data['manufacturers'] as $manufacturer) { 
            $this->data['content_excel'] .= $manufacturer['manufacturer_id']."\t".$manufacturer['name']."\t".$manufacturer['tviewed']."\t".$manufacturer['viewed']."\t".$manufacturer['percent']."\n";
            $this->data['content_csv'] .= $manufacturer['manufacturer_id'].",".$manufacturer['name'].",".$manufacturer['tviewed'].",".$manufacturer['viewed'].",".$manufacturer['percent']."\n";
        }
 		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
        
		$this->data['button_filter'] = $this->language->get('button_filter');
		
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_viewed'] = $this->language->get('column_viewed');
		$this->data['column_tviewed'] = $this->language->get('column_tviewed');
		$this->data['column_percent'] = $this->language->get('column_percent');
        		
		$this->data['button_reset'] = $this->language->get('button_reset');
		
		$this->data['reset'] = Url::createAdminUrl('report/mviewed/reset') . $url;

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
		
		$this->data['sort_name'] = Url::createAdminUrl('report/mviewed') . '&sort=name' . $url;
		$this->data['sort_viewed'] = Url::createAdminUrl('report/mviewed') . '&sort=viewed' . $url;
		
		$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
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
		
		$pagination = new Pagination();
		$pagination->total = $manufacturer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('report/mviewed') . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();
		 
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_sdate'] = $filter_sdate;
		$this->data['filter_fdate'] = $filter_fdate;
				
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
        
		$this->template = 'report/mviewed.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
	
	/**
	 * ControllerReportViewed::reset()
	 * 
	 * @return void
	 */
	public function reset() {
		$this->load->language('report/mviewed');
		
		$this->load->auto('report/mviewed');
		
		$this->modelViewed->reset();
		
		$this->session->set('success',$this->language->get('text_success'));
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->redirect(Url::createAdminUrl('report/mviewed') . $url);
	}
}
