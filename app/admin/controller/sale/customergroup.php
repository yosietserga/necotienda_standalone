<?php
/**
 * ControllerSaleCustomerGroup
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerSaleCustomerGroup extends Controller {
	private $error = array();
 
	/**
	 * ControllerSaleCustomerGroup::index()
	 * 
	 * @see Load
	 * @see Language
	 * @see getList
	 * @return void
	 */
	public function index() {
		$this->document->title = $this->language->get('heading_title');
 		$this->getList();
	}

	/**
	 * ControllerSaleCustomerGroup::insert()
	 * 
	 * @see Load
	 * @see Language
	 * @see Redirect
	 * @see Session
	 * @see getForm
	 * @return void
	 */
	public function insert() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelCustomergroup->addCustomerGroup($this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(Url::createAdminUrl('sale/customergroup') . $url);
		}

		$this->getForm();
	}

	/**
	 * ControllerSaleCustomerGroup::update()
	 * 
	 * @see Load
	 * @see Language
	 * @see Redirect
	 * @see Session
	 * @see getForm
	 * @return void
	 */
	public function update() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelCustomergroup->editCustomerGroup($this->request->get['customer_group_id'], $this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(Url::createAdminUrl('sale/customergroup') . $url);
		}

		$this->getForm();
	}

	/**
	 * ControllerSaleCustomerGroup::delete()
	 * 
	 * @see Load
	 * @see Language
	 * @see Redirect
	 * @see Session
	 * @see getList
	 * @return void
	 */
	public function delete() { 
		$this->document->title = $this->language->get('heading_title');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
      		foreach ($this->request->post['selected'] as $customer_group_id) {
				$this->modelCustomergroup->deleteCustomerGroup($customer_group_id);	
			}
						
			$this->session->set('success',$this->language->get('text_success'));
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(Url::createAdminUrl('sale/customergroup') . $url);
		}

		$this->getList();
	}

	/**
	 * ControllerSaleCustomerGroup::getList()
	 * 
	 * @see Load
	 * @see Language
	 * @see Response
	 * @see Session
	 * @see Request
	 * @return void
	 */
	private function getList() {
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('sale/customergroup') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = Url::createAdminUrl('sale/customergroup/insert') . $url;
		$this->data['delete'] = Url::createAdminUrl('sale/customergroup/delete') . $url;	
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if ($this->session->has('success')) {
			$this->data['success'] = $this->session->get('success');
		
			$this->session->clear('success');
		} else {
			$this->data['success'] = '';
		}
		
        // SCRIPTS
        $scripts[] = array('id'=>'customergroupList','method'=>'function','script'=>
            "function activate(e) {
                $.getJSON('". Url::createAdminUrl("sale/customergroup/activate") ."',{
                    id:e
                },function(data){
                    if (data > 0) {
                        $('#img_' + e).attr('src','image/good.png');
                    } else {
                        $('#img_' + e).attr('src','image/minus.png');
                    }
                });
            }
            function borrar() {
                $('#gridWrapper').html('<img src=\"image/nt_loader.gif\" alt=\"Cargando...\" />');
                $.post('". Url::createAdminUrl("sale/customergroup/delete") ."',$('#formGrid').serialize(),function(){
                    $('#gridWrapper').load('". Url::createAdminUrl("sale/customergroup/grid") ."');
                });
            } 
            function eliminar(e) {    
                $('#tr_' + e).hide();
                if (confirm('¿Desea eliminar este objeto?')) {
                	$.getJSON('". Url::createAdminUrl("sale/customergroup/eliminar") ."',{
                            id:e
                        },
                        function(data) {
                            if (data > 0) {
                                $('#tr_' + e).remove();
                            } else {
                                alert('No se pudo eliminar el objeto, posiblemente tenga otros objetos relacionados');
                                $('#tr_' + e).show().effect('shake', { times:3 }, 300);;
                            }
                	});
                }
             }");
        $scripts[] = array('id'=>'sortable','method'=>'ready','script'=>
            "$('#gridWrapper').load('". Url::createAdminUrl("sale/customergroup/grid") ."',function(e){
                $('#gridPreloader').hide();
                $('#list tbody').sortable({
                    opacity: 0.6, 
                    cursor: 'move',
                    handle: '.move',
                    update: function() {
                        $.ajax({
                            'type':'post',
                            'dateType':'json',
                            'url':'". Url::createAdminUrl("sale/customergroup/sortable") ."',
                            'data': $(this).sortable('serialize'),
                            'success': function(data) {
                                if (data > 0) {
                                    var msj = '<div class=\"messagesuccess\">Se han ordenado los objetos correctamente</div>';
                                } else {
                                    var msj = '<div class=\"messagewarning\">Hubo un error al intentar ordenar los objetos, por favor intente m&aacute;s tarde</div>';
                                }
                                $('#msg').fadeIn().append(msj).delay(3600).fadeOut();
                            }
                        });
                    }
                }).disableSelection();
                $('.move').css('cursor','move');
            });
                
            $('#formFilter').ntForm({
                lockButton:false,
                ajax:true,
                type:'get',
                dataType:'html',
                url:'". Url::createAdminUrl("sale/customergroup/grid") ."',
                beforeSend:function(){
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                },
                success:function(data){
                    $('#gridPreloader').hide();
                    $('#gridWrapper').html(data).show();
                }
            });");
             
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'sale/customer_group_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
 	}

	/**
	 * ControllerSaleCustomerGroup::grid()
	 * 
	 * @see Load
	 * @see Language
	 * @see Response
	 * @see Session
	 * @see Request
	 * @return void
	 */
	public function grid() {
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
		$filter_customer = isset($this->request->get['filter_customer']) ? $this->request->get['filter_customer'] : null;
		$filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
		$filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'name';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
		
		$url = '';
			
		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; } 
		if (isset($this->request->get['filter_customer'])) { $url .= '&filter_customer=' . $this->request->get['filter_customer']; } 
		if (isset($this->request->get['filter_date_start'])) { $url .= '&filter_date_start=' . $this->request->get['filter_date_start']; }
		if (isset($this->request->get['filter_date_end'])) { $url .= '&filter_date_end=' . $this->request->get['filter_date_end']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; }

		$this->data['customer_groups'] = array();

		$data = array(
			'filter_name'     => $filter_name, 
			'filter_customer' => $filter_customer, 
			'filter_date_start'=> $filter_date_start, 
			'filter_date_end' => $filter_date_end, 
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $limit
		);
		
		$customer_group_total = $this->modelCustomergroup->getTotalCustomerGroups();
		
		$results = $this->modelCustomergroup->getCustomerGroups($data);

		foreach ($results as $result) {
			
			$action = array(
                'activate'  => array(
                        'action'  => 'activate',
                        'text'  => $this->language->get('text_activate'),
                        'href'  =>'',
                        'img'   => ($result['status']==1) ? 'good.png' :  'minus.png'
                ),
                'edit'      => array(
                        'action'  => 'edit',
                        'text'  => $this->language->get('text_edit'),
                        'href'  =>Url::createAdminUrl('sale/customergroup/update') . '&customer_group_id=' . $result['customer_group_id'] . $url,
                        'img'   => 'edit.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );	
		      
            $customers = $this->modelCustomergroup->getTotalCustomersByGroup($result['customer_group_id']);
			$this->data['customer_groups'][] = array(
				'customer_group_id' => $result['customer_group_id'],
				'cant_orders'      => (int)$result['cant_orders'],
				'cant_invoices'        => (int)$result['cant_invoices'],
				'cant_references'   => (int)$result['cant_references'],
				'cant_reviews'      => (int)$result['cant_reviews'],
				'total_orders'      => (int)$result['total_orders'],
				'total_invoices'        => (int)$result['total_invoices'],
				'total_references'   => (int)$result['total_references'],
				'total_reviews'      => (int)$result['total_reviews'],
				'cant_customers'      => (int)$customers,
				'name'              => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_customer_group_id')) ? $this->language->get('text_default') : NULL),
				'selected'          => isset($this->request->post['selected']) && in_array($result['customer_group_id'], $this->request->post['selected']),
				'action'            => $action
			);
		}	
	
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_action'] = $this->language->get('column_action');

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		$this->data['sort_name'] = Url::createAdminUrl('sale/customergroup/grid') . '&sort=name' . $url;
		
		$url = '';

		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
				
		$pagination = new Pagination();
		$pagination->total = $customer_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('sale/customergroup') . $url . '&page={page}';
		
		$this->data['pagination'] = $pagination->render();				

		$this->data['sort'] = $sort; 
		$this->data['order'] = $order;
		
		$this->template = 'sale/customer_group_grid.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
 	}

	/**
	 * ControllerSaleCustomerGroup::getForm()
	 * 
	 * @see Load
	 * @see Language
	 * @see Response
	 * @see Session
	 * @see Request
	 * @return void
	 */
	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
        
		$this->data['help_name'] = $this->language->get('help_name');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		$url = '';
			
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
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('sale/customergroup') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
			
		if (!isset($this->request->get['customer_group_id'])) {
			$this->data['action'] = Url::createAdminUrl('sale/customergroup/insert') . $url;
		} else {
			$this->data['action'] = Url::createAdminUrl('sale/customergroup/update') . '&customer_group_id=' . $this->request->get['customer_group_id'] . $url;
		}
		  
    	$this->data['cancel'] = Url::createAdminUrl('sale/customergroup') . $url;

		if (isset($this->request->get['customer_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$customer_group_info = $this->modelCustomergroup->getCustomerGroup($this->request->get['customer_group_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (isset($customer_group_info)) {
			$this->data['name'] = $customer_group_info['name'];
		} else {
			$this->data['name'] = '';
		}
			
		if (isset($this->request->post['cant_orders'])) {
			$this->data['cant_orders'] = $this->request->post['cant_orders'];
		} elseif (isset($customer_group_info)) {
			$this->data['cant_orders'] = $customer_group_info['cant_orders'];
		} else {
			$this->data['cant_orders'] = '';
		}
        	
		if (isset($this->request->post['cant_invoices'])) {
			$this->data['cant_invoices'] = $this->request->post['cant_invoices'];
		} elseif (isset($customer_group_info)) {
			$this->data['cant_invoices'] = $customer_group_info['cant_invoices'];
		} else {
			$this->data['cant_invoices'] = '';
		}
			
		if (isset($this->request->post['cant_reviews'])) {
			$this->data['cant_reviews'] = $this->request->post['cant_reviews'];
		} elseif (isset($customer_group_info)) {
			$this->data['cant_reviews'] = $customer_group_info['cant_reviews'];
		} else {
			$this->data['cant_reviews'] = '';
		}
			
		if (isset($this->request->post['cant_references'])) {
			$this->data['cant_references'] = $this->request->post['cant_references'];
		} elseif (isset($customer_group_info)) {
			$this->data['cant_references'] = $customer_group_info['cant_references'];
		} else {
			$this->data['cant_references'] = '';
		}
			
		if (isset($this->request->post['total_orders'])) {
			$this->data['total_orders'] = $this->request->post['total_orders'];
		} elseif (isset($customer_group_info)) {
			$this->data['total_orders'] = $customer_group_info['total_orders'];
		} else {
			$this->data['total_orders'] = '';
		}
			
			
		if (isset($this->request->post['total_invoices'])) {
			$this->data['total_invoices'] = $this->request->post['total_invoices'];
		} elseif (isset($customer_group_info)) {
			$this->data['total_invoices'] = $customer_group_info['total_invoices'];
		} else {
			$this->data['total_invoices'] = '';
		}
			
			
		if (isset($this->request->post['total_reviews'])) {
			$this->data['total_reviews'] = $this->request->post['total_reviews'];
		} elseif (isset($customer_group_info)) {
			$this->data['total_reviews'] = $customer_group_info['total_reviews'];
		} else {
			$this->data['total_reviews'] = '';
		}
			
			
		if (isset($this->request->post['total_references'])) {
			$this->data['total_references'] = $this->request->post['total_references'];
		} elseif (isset($customer_group_info)) {
			$this->data['total_references'] = $customer_group_info['total_references'];
		} else {
			$this->data['total_references'] = '';
		}
			
		$this->template = 'sale/customer_group_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression')); 
	}

	/**
	 * ControllerSaleCustomerGroup::validateForm()
	 * 
	 * @see User
	 * @see Language
	 * @see Request
	 * @return bool
	 */
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/customer_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name']))> 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * ControllerSaleCustomerGroup::validateDelete()
	 * 
	 * @see User
	 * @see Language
	 * @see Request
	 * @return bool
	 */
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/customer_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->auto('sale/customer');
      	
		foreach ($this->request->post['selected'] as $customer_group_id) {
    		if ($this->config->get('config_customer_group_id') == $customer_group_id) {
	  			$this->error['warning'] = $this->language->get('error_default');	
			}  
			
			$customer_total = $this->modelCustomer->getTotalCustomersByCustomerGroupId($customer_group_id);

			if ($customer_total) {
				$this->error['warning'] = sprintf($this->language->get('error_customer'), $customer_total);
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
    /**
     * ControllerSaleCategory::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('sale/customergroup');
        $status = $this->modelCustomergroup->getCustomerGroup($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelCustomergroup->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelCustomergroup->desactivate($_GET['id']);
                echo -1;
            }
            
        } else {
            echo 0;
        }
     }
     
    /**
     * ControllerSaleCategory::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function eliminar() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('sale/customergroup');
        $result = $this->modelCustomergroup->getCustomerGroup($_GET['id']);
        if ($result) {
            $this->modelCustomergroup->deleteCustomerGroup($_GET['id']);
            echo 1;
        } else {
            echo 0;
        }
     }
    
}
