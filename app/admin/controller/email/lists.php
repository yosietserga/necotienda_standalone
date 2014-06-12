<?php 
class ControllerEmailLists extends Controller {
	private $error = array();
   
  	public function index() {
		$this->load->language('email/lists');
	 
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('email/lists');
		
    	$this->getList();	
  	}
  	
    public function insert() {	
		$this->load->language('email/lists');
	
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('email/lists');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$list = $this->model_email_lists->addList($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->request->get['token']);
		}
		    	
    	$this->getForm();
  	}
    
    public function update() {	
		$this->load->language('email/lists');
	
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('email/lists');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_email_lists->editList($this->request->get['list_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			unset($this->request->post);
			$this->redirect(HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->request->get['token']);
		}
		    	
    	$this->getForm();
  	}
    
    private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'list_id';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['filter_list_id'])) {
			$filter_list_id = $this->request->get['filter_list_id'];
		} else {
			$filter_list_id = NULL;
		}		
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = NULL;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = NULL;
		}

		if (isset($this->request->get['filter_subscribe_count'])) {
			$filter_subscribe_count = $this->request->get['filter_subscribe_count'];
		} else {
			$filter_subscribe_count = NULL;
		}		
		
		$url = '';
				
		if (isset($this->request->get['filter_list_id'])) {
			$url .= '&filter_list_id=' . $this->request->get['filter_list_id'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_subscribe_count'])) {
			$url .= '&filter_subscribe_count=' . $this->request->get['filter_subscribe_count'];
		}
								
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->session->data['token'] . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
			
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=email/lists/insert&token=' . $this->session->data['token'] . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=email/lists/delete&token=' . $this->session->data['token'] . $url;	

		$this->data['lists'] = array();

		$data = array(
			'filter_list_id'         => $filter_list_id,
			'filter_name'	         => $filter_name, 
			'filter_date_added'      => $filter_date_added,
			'filter_subscribe_count'   => $filter_subscribe_count,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		$lists_total = $this->model_email_lists->getTotalLists($data);
		$results = $this->model_email_lists->getLists($data);
 
    	foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=email/lists/update&token=' . $this->session->data['token'] . '&list_id=' . $result['list_id'] . $url
			);
			
			$this->data['lists'][] = array(
				'list_id'   => $result['list_id'],
				'name'       => $result['name'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'subscribe_count' => $result['subscribe_count'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['list_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}	
					
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_missing_orders'] = $this->language->get('text_missing_orders');

		$this->data['column_list'] = $this->language->get('column_list');
    	$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_subscribe_count'] = $this->language->get('column_subscribe_count');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_invoices'] = $this->language->get('button_invoices');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');
 		
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_list_id'])) {
			$url .= '&filter_list_id=' . $this->request->get['filter_list_id'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_subscribe_count'])) {
			$url .= '&filter_subscribe_count=' . $this->request->get['filter_subscribe_count'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_list'] = HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->session->data['token'] . '&sort=list_id' . $url;
		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->session->data['token'] . '&sort=name' . $url;
		$this->data['sort_date_added'] = HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->session->data['token'] . '&sort=date_added' . $url;
		$this->data['sort_subscribe_count'] = HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->session->data['token'] . '&sort=subscribe_count' . $url;
		
		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_subscribe_count'])) {
			$url .= '&filter_subscribe_count=' . $this->request->get['filter_subscribe_count'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $lists_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->session->data['token'] . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['filter_list_id'] = $filter_list_id;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_date_added'] = $filter_date_added;
		$this->data['filter_subscribe_count'] = $filter_subscribe_count;
				
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'email/lists_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    
  	public function getForm() {
		$this->load->model('email/lists');
		if (isset($this->request->get['list_id'])) {
             $list_info = $this->model_email_lists->getList($this->request->get['list_id']);
        }
			$this->load->language('email/lists');
		 
			$this->document->title = $this->language->get('heading_title');
			
			$this->data['heading_title'] = $this->language->get('heading_title');
			
			$this->data['text_wait'] = $this->language->get('text_wait');
			$this->data['text_none'] = $this->language->get('text_none');
			$this->data['text_default'] = $this->language->get('text_default');
			$this->data['text_html'] = $this->language->get('text_html');
			$this->data['text_text'] = $this->language->get('text_text');
            
			$this->data['entry_list_id'] = $this->language->get('entry_list_id');
			$this->data['entry_name'] = $this->language->get('entry_name');
			$this->data['entry_notify'] = $this->language->get('entry_notify');	
			$this->data['entry_true'] = $this->language->get('entry_true');	
			$this->data['entry_false'] = $this->language->get('entry_false');
			$this->data['entry_category'] = $this->language->get('entry_category');	
			$this->data['entry_member'] = $this->language->get('entry_member');	
			$this->data['entry_format'] = $this->language->get('entry_format');		
            
            
			$this->data['button_save'] = $this->language->get('button_save');
			$this->data['button_cancel'] = $this->language->get('button_cancel');
            
			$this->data['token'] = $this->session->data['token'];
			
			$this->document->breadcrumbs = array();
	
			$this->document->breadcrumbs[] = array(
				'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
				'text'      => $this->language->get('text_home'),
				'separator' => false
			);
	
			$this->document->breadcrumbs[] = array(
				'href'      => HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->session->data['token'],
				'text'      => $this->language->get('heading_title'),
				'separator' => ' :: '
			);
			
            if (isset($this->error['name'])) {
    			$this->data['error_name'] = $this->error['name'];
    		} else {
    			$this->data['error_name'] = '';
    		}
            
            if (isset($this->error['warning'])) {
    			$this->data['error_warning'] = $this->error['warning'];
    		} else {
    			$this->data['error_warning'] = '';
    		}
            
			if (isset($this->request->get['list_id'])) {
				$this->data['action'] = HTTPS_SERVER . 'index.php?route=email/lists/update&token=' . $this->session->data['token'] . '&list_id=' . $this->request->get['list_id'];
			} else {
				$this->data['action'] = HTTPS_SERVER . 'index.php?route=email/lists/insert&token=' . $this->session->data['token'];
			}
		
			$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=email/lists&token=' . $this->session->data['token'];
			
			$this->data['list_id'] = $this->request->get['list_id'];
            
			if (isset($this->request->get['list_id'])) {
      			$list_info = $this->model_email_lists->getList($this->request->get['list_id']);
    		} else {
    			$list_info = array();
			}

			if (isset($this->request->post['name'])) {
				$this->data['name'] = $this->request->post['name'];
			} elseif (isset($list_info['name'])) {
				$this->data['name'] = $list_info['name'];
			} else {
				$this->data['name'] = '';
			}
            
            if (isset($this->request->post['format'])) {
				$this->data['format'] = $this->request->post['format'];
			} elseif (isset($list_info['format'])) {
				$this->data['format'] = $list_info['format'];
			} else {
				$this->data['format'] = '';
			}
            
            if (isset($this->request->post['notify'])) {
				$this->data['notify'] = $this->request->post['notify'];
			} elseif (isset($list_info['notify'])) {
				$this->data['notify'] = $list_info['notify'];
			} else {
				$this->data['notify'] = '';
			}
			
			if (isset($this->request->post['date_added'])) {
				$this->data['date_added'] = $this->request->post['date_added'];
			} elseif (isset($list_info['date_added'])) {
				$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($list_info['date_added'])); 
			} else {
				$this->data['date_added'] = date($this->language->get('date_format_short'), time()); 
			}
            
            $this->load->model('sale/customer');
    				
    		$this->data['customers'] = $this->model_sale_customer->getCustomerBySubscribe();
    		
    		if (isset($this->request->post['customer_id'])) {
    			$this->data['customer_id'] = $this->request->post['customer_id'];
    		} elseif (isset($list_info)) {
    			$this->data['customer_id'] = $this->model_email_lists->getMembers($this->request->get['list_id']);
    		} else {
    			$this->data['customer_id'] = array();
    		}
            
    		$this->load->model('catalog/category');
    				
    		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
    		
    		if (isset($this->request->post['product_category'])) {
    			$this->data['product_category'] = $this->request->post['product_category'];
    		} elseif (isset($list_info)) {
    			$this->data['product_category'] = $this->model_email_lists->getIntereses($this->request->get['list_id']);
    		} else {
    			$this->data['product_category'] = array();
    		}		
		
			
			$this->data['token'] = $this->session->data['token'];
			
			$this->template = 'email/lists_form.tpl';
			$this->children = array(
				'common/header',	
				'common/footer'
			);
			
			$this->response->setOutput($this->render(true), $this->config->get('config_compression')); 
		
  	}
    
    private function validate() {
    	if (!$this->validate->longitudMinMax($this->request->post['name'],3,32,$this->language->get('entry_name')) || (!$this->validate->esSoloTexto($this->request->post['name'],$this->language->get('entry_name')) && !$this->validate->esSinCharEspeciales($this->request->post['name'],$this->language->get('entry_name')))) {
      		$this->error['name'] = $this->language->get('error_name');
    	}

    	if (!$this->user->hasPermission('modify', 'email/lists')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        $this->data['mostrarError'] = $this->validate->mostrarError();
        
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}    
}
?>