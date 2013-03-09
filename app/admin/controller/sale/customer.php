<?php    
/**
 * ControllerSaleCustomer
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerSaleCustomer extends Controller { 
	private $error = array();
  
  	/**
  	 * ControllerSaleCustomer::index()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see getList
  	 * @return void 
  	 */
  	public function index() {
		$this->document->title = $this->language->get('heading_title');
		$this->getList();
  	}
  
  	/**
  	 * ControllerSaleCustomer::insert()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see getForm
  	 * @return void 
  	 */
  	public function insert() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      	  	$this->modelCustomer->addCustomer($this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));
		  
			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
		
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			
			//TODO: agregar los redirect condicionales
			$this->redirect(Url::createAdminUrl('sale/customer') . $url);
		}
    	
    	$this->getForm();
  	} 
   
  	/**
  	 * ControllerSaleCustomer::update()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see getForm
  	 * @return void 
  	 */
  	public function update() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelCustomer->editCustomer($this->request->get['customer_id'], $this->request->post);
	  		
			$this->session->set('success',$this->language->get('text_success'));
	  
			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
		
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			
			$this->redirect(Url::createAdminUrl('sale/customer') . $url);
		}
    
    	$this->getForm();
  	}   

  	/**
  	 * ControllerSaleCustomer::delete()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see getList
  	 * @return void 
  	 */
  	public function delete() {
		$this->document->title = $this->language->get('heading_title');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $customer_id) {
				$this->modelCustomer->deleteCustomer($customer_id);
			}
			
			$this->session->set('success',$this->language->get('text_success'));

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}		
		
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			
			$this->redirect(Url::createAdminUrl('sale/customer') . $url);
    	}
    
    	$this->getList();
  	}  
    
  	/**
  	 * ControllerSaleCustomer::getList()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Response
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
       		'href'      => Url::createAdminUrl('sale/customer') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['approve'] = Url::createAdminUrl('sale/customer/approve') . $url;
		$this->data['insert'] = Url::createAdminUrl('sale/customer/insert') . $url;
		$this->data['delete'] = Url::createAdminUrl('sale/customer/delete') . $url;
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_approve'] = $this->language->get('button_approve');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		if ($this->session->has('error')) {
			$this->data['error_warning'] = $this->session->get('error');
			
			$this->session->clear('error');
		} elseif (isset($this->error['warning'])) {
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
        $scripts[] = array('id'=>'customerList','method'=>'function','script'=>
            "function activate(e) {
                $.getJSON('". Url::createAdminUrl("sale/customer/activate") ."',{
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
                $.post('". Url::createAdminUrl("sale/customer/delete") ."',$('#formGrid').serialize(),function(){
                    $('#gridWrapper').load('". Url::createAdminUrl("sale/customer/grid") ."');
                });
            } 
            function eliminar(e) {
                if (confirm('¿Desea eliminar este objeto?')) {
                $('#tr_' + e).hide();
                	$.getJSON('". Url::createAdminUrl("sale/customer/eliminar") ."',{
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
            "$('#gridWrapper').load('". Url::createAdminUrl("sale/customer/grid") ."',function(e){
                $('#gridPreloader').hide();
                $('#list tbody').sortable({
                    opacity: 0.6, 
                    cursor: 'move',
                    handle: '.move',
                    update: function() {
                        $.ajax({
                            'type':'post',
                            'dateType':'json',
                            'url':'". Url::createAdminUrl("sale/customer/sortable") ."',
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
                url:'". Url::createAdminUrl("sale/customer/grid") ."',
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
        
		$this->template = 'sale/customer_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
  	/**
  	 * ControllerSaleCustomer::grid()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Response
     * @see Request     
  	 * @return void 
  	 */
  	public function grid() {
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
		$filter_email = isset($this->request->get['filter_email']) ? $this->request->get['filter_email'] : null;
		$filter_customer_group_id = isset($this->request->get['filter_customer_group_id']) ? $this->request->get['filter_customer_group_id'] : null;
		$filter_status = isset($this->request->get['filter_status']) ? $this->request->get['filter_status'] : null;
		$filter_approved = isset($this->request->get['filter_approved']) ? $this->request->get['filter_approved'] : null;
		$filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
		$filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'name';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
		
		$url = '';
			
		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; } 
		if (isset($this->request->get['filter_email'])) { $url .= '&filter_email=' . $this->request->get['filter_email']; } 
		if (isset($this->request->get['filter_customer_group_id'])) {$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];} 
		if (isset($this->request->get['filter_status'])) { $url .= '&filter_status=' . $this->request->get['filter_status']; }
		if (isset($this->request->get['filter_approved'])) { $url .= '&filter_approved=' . $this->request->get['filter_approved']; }
		if (isset($this->request->get['filter_date_start'])) { $url .= '&filter_date_start=' . $this->request->get['filter_date_start']; }
		if (isset($this->request->get['filter_date_end'])) { $url .= '&filter_date_end=' . $this->request->get['filter_date_end']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; }

		$this->data['customers'] = array();

		$data = array(
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email, 
			'filter_customer_group_id' => $filter_customer_group_id, 
			'filter_status'            => $filter_status, 
			'filter_approved'          => $filter_approved, 
			'filter_date_start'        => $filter_date_start,
			'filter_date_end'          => $filter_date_end,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $limit,
			'limit'                    => $limit
		);
		
		$customer_total = $this->modelCustomer->getTotalCustomers($data);
		$results = $this->modelCustomer->getCustomers($data);
 
    	foreach ($results as $result) {
			
			$action = array(
                'activate'  => array(
                        'action'  => 'activate',
                        'text'  => $this->language->get('text_activate'),
                        'href'  =>'',
                        'img'   => ($result['status']==1) ? 'good.png' :  'minus.png'
                ),
                'approve' => array(
                        'action'  => 'approve',
                        'text'  => $this->language->get('button_approve'),
                        'href'  =>'',
                        'img'   => ($result['approved']==1) ? 'customer_unlocked.png' :  'customer_locked.png'
                ),
                'edit'      => array(
                        'action'  => 'edit',
                        'text'  => $this->language->get('text_edit'),
                        'href'  =>Url::createAdminUrl('sale/customer/update') . '&customer_id=' . $result['cid'] . $url,
                        'img'   => 'edit.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );
			$this->data['customers'][] = array(
				'customer_id'    => $result['cid'],
				'name'           => $result['name'],
				'email'          => $result['email'],   
				'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				'telephone'      => $result['telephone'],
				'fax'            => $result['fax'],
				'newsletter'     => ($result['newsletter'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'address'        => $result['address_1'].", ".$result['city'].". ".$result['zone']." - ".$result['country'],
				'fdate_added'    => $result['date_added'],
				'rif'            => $result['rif'],
				'company'        => $result['company'],
				'codigo'         => $result['codigo'],
				'nacimiento'     => $result['nacimiento'],
				'blog'           => $result['blog'],
				'website'        => $result['website'],
				'profesion'      => $result['profesion'],
				'titulo'         => $result['titulo'],
				'msn'            => $result['msn'],                
				'gmail'          => $result['gmail'],
				'yahoo'          => $result['yahoo'],
				'skype'          => $result['skype'],
				'facebook'       => $result['facebook'],
				'twitter'        => $result['twitter'],
				'complete'       => ($result['complete'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'sexo'           => $result['sexo'],                
				'customer_group' => $result['customer_group'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'approved'       => ($result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action
			);
		}
        
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$url = '';

		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; }
		if (isset($this->request->get['filter_email'])) { $url .= '&filter_email=' . $this->request->get['filter_email']; }
		if (isset($this->request->get['filter_customer_group_id'])) { $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id']; }
		if (isset($this->request->get['filter_status'])) { $url .= '&filter_status=' . $this->request->get['filter_status']; }
		if (isset($this->request->get['filter_approved'])) { $url .= '&filter_approved=' . $this->request->get['filter_approved']; }
		if (isset($this->request->get['filter_date_added'])) { $url .= '&filter_date_added=' . $this->request->get['filter_date_added']; }
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		
		$this->data['sort_name'] = Url::createAdminUrl('sale/customer/grid') . '&sort=name' . $url;
		$this->data['sort_email'] = Url::createAdminUrl('sale/customer/grid') . '&sort=c.email' . $url;
		$this->data['sort_customer_group'] = Url::createAdminUrl('sale/customer/grid') . '&sort=customer_group' . $url;
		$this->data['sort_status'] = Url::createAdminUrl('sale/customer/grid') . '&sort=c.status' . $url;
		$this->data['sort_approved'] = Url::createAdminUrl('sale/customer/grid') . '&sort=c.approved' . $url;
		$this->data['sort_date_added'] = Url::createAdminUrl('sale/customer/grid') . '&sort=c.date_added' . $url;
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {$url .= '&filter_name=' . $this->request->get['filter_name'];}
		if (isset($this->request->get['filter_email'])) {$url .= '&filter_email=' . $this->request->get['filter_email'];}
		if (isset($this->request->get['filter_customer_group_id'])) {$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];}
		if (isset($this->request->get['filter_status'])) { $url .= '&filter_status=' . $this->request->get['filter_status']; }
		if (isset($this->request->get['filter_approved'])) { $url .= '&filter_approved=' . $this->request->get['filter_approved']; }
		if (isset($this->request->get['filter_date_added'])) { $url .= '&filter_date_added=' . $this->request->get['filter_date_added']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }

		$pagination = new Pagination();
		$pagination->ajax = true;
		$pagination->ajaxTarget = "gridWrapper";
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('sale/customer/grid') . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_approved'] = $filter_approved;
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		
    	$this->data['customer_groups'] = $this->modelCustomergroup->getCustomerGroups();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/customer_grid.tpl';
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
  	/**
  	 * ControllerSaleCustomer::getForm()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Response
     * @see Request     
  	 * @return void 
  	 */
  	private function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled']    = $this->language->get('text_enabled');
    	$this->data['text_disabled']   = $this->language->get('text_disabled');
		$this->data['text_select']     = $this->language->get('text_select');
    	$this->data['text_man']        = $this->language->get('text_man');
		$this->data['text_woman']      = $this->language->get('text_woman');
		$this->data['text_sexo']       = $this->language->get('text_sexo');
    	
    	$this->data['entry_rif']       = $this->language->get('entry_rif');
    	$this->data['entry_facebook']  = $this->language->get('entry_facebook');
    	$this->data['entry_twitter']   = $this->language->get('entry_twitter');
    	$this->data['entry_msn']       = $this->language->get('entry_msn');
    	$this->data['entry_yahoo']     = $this->language->get('entry_yahoo');
    	$this->data['entry_gmail']     = $this->language->get('entry_gmail');
    	$this->data['entry_skype']     = $this->language->get('entry_skype');
    	$this->data['entry_profesion'] = $this->language->get('entry_profesion');
		$this->data['entry_titulo']    = $this->language->get('entry_titulo');
    	$this->data['entry_blog']      = $this->language->get('entry_blog');
		$this->data['entry_website']   = $this->language->get('entry_website');
		$this->data['entry_foto']      = $this->language->get('entry_foto');
    	$this->data['entry_firstname'] = $this->language->get('entry_firstname');
    	$this->data['entry_lastname']  = $this->language->get('entry_lastname');
    	$this->data['entry_email']     = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
    	$this->data['entry_fax']       = $this->language->get('entry_fax');
    	$this->data['entry_password']  = $this->language->get('entry_password');
    	$this->data['entry_confirm']   = $this->language->get('entry_confirm');
		$this->data['entry_newsletter']= $this->language->get('entry_newsletter');
    	$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_status']    = $this->language->get('entry_status');
		$this->data['entry_company']   = $this->language->get('entry_company');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_city']      = $this->language->get('entry_city');
		$this->data['entry_postcode']  = $this->language->get('entry_postcode');
		$this->data['entry_zone']      = $this->language->get('entry_zone');
		$this->data['entry_country']   = $this->language->get('entry_country');
		$this->data['entry_default']   = $this->language->get('entry_default');
		$this->data['entry_name']      = $this->language->get('entry_name');
		$this->data['entry_address']   = $this->language->get('entry_address');
		$this->data['entry_sexo']      = $this->language->get('entry_sexo');
		$this->data['entry_city_postcode'] = $this->language->get('entry_city_postcode');
		$this->data['entry_country_zone']  = $this->language->get('entry_country_zone');
    	
    	$this->data['help_rif']        = $this->language->get('help_rif');
    	$this->data['help_facebook']   = $this->language->get('help_facebook');
    	$this->data['help_twitter']    = $this->language->get('help_twitter');
    	$this->data['help_msn']        = $this->language->get('help_msn');
    	$this->data['help_yahoo']      = $this->language->get('help_yahoo');
    	$this->data['help_gmail']      = $this->language->get('help_gmail');
    	$this->data['help_skype']      = $this->language->get('help_skype');
    	$this->data['help_profesion']  = $this->language->get('help_profesion');
		$this->data['help_titulo']     = $this->language->get('help_titulo');
    	$this->data['help_blog']       = $this->language->get('help_blog');
		$this->data['help_website']    = $this->language->get('help_website');
		$this->data['help_foto']       = $this->language->get('help_foto');
    	$this->data['help_firstname']  = $this->language->get('help_firstname');
    	$this->data['help_lastname']   = $this->language->get('help_lastname');
    	$this->data['help_email']      = $this->language->get('help_email');
    	$this->data['help_telephone']  = $this->language->get('help_telephone');
    	$this->data['help_fax']        = $this->language->get('help_fax');
    	$this->data['help_password']   = $this->language->get('help_password');
    	$this->data['help_confirm']    = $this->language->get('help_confirm');
		$this->data['help_newsletter'] = $this->language->get('help_newsletter');
    	$this->data['help_customer_group'] = $this->language->get('help_customer_group');
		$this->data['help_status']     = $this->language->get('help_status');
		$this->data['help_company']    = $this->language->get('help_company');
		$this->data['help_address_1']  = $this->language->get('help_address_1');
		$this->data['help_address_2']  = $this->language->get('help_address_2');
		$this->data['help_city']       = $this->language->get('help_city');
		$this->data['help_postcode']   = $this->language->get('help_postcode');
		$this->data['help_zone']       = $this->language->get('help_zone');
		$this->data['help_country']    = $this->language->get('help_country');
		$this->data['help_default']    = $this->language->get('help_default');
		$this->data['help_name']       = $this->language->get('help_name');
		$this->data['help_address']    = $this->language->get('help_address');
		$this->data['help_sexo']       = $this->language->get('help_sexo');
		$this->data['help_city_postcode'] = $this->language->get('help_city_postcode');
		$this->data['help_country_zone']  = $this->language->get('help_country_zone');
 
		$this->data['button_save']     = $this->language->get('button_save');
    	$this->data['button_cancel']   = $this->language->get('button_cancel');
    	$this->data['button_add']      = $this->language->get('button_add');
    	$this->data['button_remove']   = $this->language->get('button_remove');
		$this->data['button_save_and_new'] = $this->language->get('button_save_and_new');
		$this->data['button_save_and_exit']= $this->language->get('button_save_and_exit');
		$this->data['button_save_and_keep']= $this->language->get('button_save_and_keep');
	
		$this->data['tab_general']     = $this->language->get('tab_general');
		$this->data['tab_address']     = $this->language->get('tab_address');

 		$this->data['error_warning']     = ($this->error['warning']) ? $this->error['warning'] : '';
 		$this->data['error_firstname']   = ($this->error['firstname']) ? $this->error['firstname'] : '';
 		$this->data['error_lastname']    = ($this->error['lastname']) ? $this->error['lastname'] : '';
 		$this->data['error_email']       = ($this->error['email']) ? $this->error['email'] : '';
 		$this->data['error_sexo']        = ($this->error['sexo']) ? $this->error['sexo'] : '';
 		$this->data['error_telephone']   = ($this->error['telephone']) ? $this->error['telephone'] : '';
 		$this->data['error_password']    = ($this->error['password']) ? $this->error['password'] : '';
 		$this->data['error_confirm']     = ($this->error['confirm']) ? $this->error['confirm'] : '';
 		$this->data['error_address_1']   = ($this->error['address_1']) ? $this->error['address_1'] : '';
 		$this->data['error_city']        = ($this->error['city']) ? $this->error['city'] : '';
 		$this->data['error_postcode']    = ($this->error['postcode']) ? $this->error['postcode'] : '';
 		$this->data['error_address_zone']= ($this->error['address_zone']) ? $this->error['address_zone'] : '';
 		$this->data['error_rif']         = ($this->error['rif']) ? $this->error['rif'] : '';
 		$this->data['error_company']     = ($this->error['company']) ? $this->error['company'] : '';
 		$this->data['error_address_country'] = ($this->error['address_country']) ? $this->error['address_country'] : '';

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('sale/customer') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

		if (!isset($this->request->get['customer_id'])) {
			$this->data['action'] = Url::createAdminUrl('sale/customer/insert') . $url;
		} else {
			$this->data['action'] = Url::createAdminUrl('sale/customer/update') . '&customer_id=' . $this->request->get['customer_id'] . $url;
		}
		  
    	$this->data['cancel'] = Url::createAdminUrl('sale/customer') . $url;

    	if (isset($this->request->get['customer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$customer_info = $this->modelCustomer->getCustomer($this->request->get['customer_id']);
    	}
        
        $this->setvar('profesion',$customer_info,'');
        $this->setvar('titulo',$customer_info,'');
        $this->setvar('blog',$customer_info,'');
        $this->setvar('website',$customer_info,'');
        $this->setvar('foto',$customer_info,'');
        $this->setvar('facebook',$customer_info,'');
        $this->setvar('twitter',$customer_info,'');
        $this->setvar('yahoo',$customer_info,'');
        $this->setvar('gmail',$customer_info,'');
        $this->setvar('msn',$customer_info,'');
        $this->setvar('skype',$customer_info,'');
        $this->setvar('firstname',$customer_info,'');
        $this->setvar('lastname',$customer_info,'');
        $this->setvar('email',$customer_info,'');
        $this->setvar('telephone',$customer_info,'');
        $this->setvar('fax',$customer_info,'');
        $this->setvar('rif',$customer_info,'');
        $this->setvar('company',$customer_info,'');
        $this->setvar('newsletter',$customer_info,'');
        $this->setvar('sexo',$customer_info,'');
        $this->setvar('status',$customer_info,1);
        $this->setvar('customer_group_id',$customer_info,$this->config->get('config_customer_group_id'));
        
        $this->data['password'] = ($this->request->post['password']) ? $this->request->post['password'] : '';
        $this->data['confirm'] = ($this->request->post['confirm']) ? $this->request->post['confirm'] : '';
		
		$this->data['customer_groups'] = $this->modelCustomergroup->getCustomerGroups();		
		$this->data['countries'] = $this->modelCountry->getCountries();
		foreach ($this->data['countries'] as $country) { 
            $countries .= "<option value=\"". $country["country_id"] ."\">". addslashes($country["name"]) ."</option>";
        }
        
		if (isset($this->request->post['addresses'])) { 
      		$this->data['addresses'] = $this->request->post['addresses'];
		} elseif (isset($this->request->get['customer_id'])) {
			$this->data['addresses'] = $this->modelCustomer->getAddressesByCustomerId($this->request->get['customer_id']);
		} else {
			$this->data['addresses'] = array();
    	}
        
        $this->data['Url'] = new Url;
		
        $scripts[] = array('id'=>'customerScripts','method'=>'ready','script'=>
            " $('#form').ntForm({
                submitButton:false,
                cancelButton:false,
                lockButton:false
            });
            $('textarea').ntTextArea();
            
            var form_clean = $('#form').serialize();  
            
            window.onbeforeunload = function (e) {
                var form_dirty = $('#form').serialize();
                if(form_clean != form_dirty) {
                    return 'There is unsaved form data.';
                }
            };
            
            $('.vtabs_page').hide();
            $('#tab_general').show();");
            
        $scripts[] = array('id'=>'customerFunctions','method'=>'function','script'=>
            "function saveAndExit() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndExit'>\").submit(); 
            }
            
            function saveAndKeep() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndKeep'>\").submit(); 
            }
            
            function saveAndNew() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndNew'>\").submit(); 
            }
            
            function showTab(a) {
                $('.vtabs_page').hide();
                $($(a).attr('data-target')).show();
                console.log(a);
            }
            
            function addAddress() {
                var address_row = $('.vtabs_page:last-child').index() + 1 * 1;
                var input = {};
                var label = {};
                
                var div = $(document.createElement('div')).addClass('vtabs_page').attr({'id':'tab_address_'+ address_row});
                var h2 = $(document.createElement('h2')).text('Direcci\u00F3n '+ address_row).appendTo(div);
                var table = $(document.createElement('table')).addClass('form').appendTo(div);
                
                tr = $(document.createElement('tr')).appendTo(table);
                td1 = $(document.createElement('td')).appendTo(tr);
                td2 = $(document.createElement('td')).appendTo(tr);
                
                label.country_id = $(document.createElement('label')).text('". str_replace('&iacute;','\u00ED',$this->data['entry_country']) ."').appendTo(td1);
                input.country_id = $(document.createElement('select')).attr({
                    'type':'text',
                    'name':'addresses[' + address_row + '][country_id]'
                }).on('change',function(e){
                    $('select[name=\"addresses['+ address_row +'][zone_id]\"]').load('". Url::createAdminUrl('sale/customer/zone') ."&country_id=' + this.value + '&zone_id=0');
                }).appendTo(td2);
                countries = '<option value=\"false\">". $this->data['text_select'] ."</option>';
                countries += '". $countries ."';
                input.country_id.append(countries);
                
                tr = $(document.createElement('tr')).appendTo(table);
                td1 = $(document.createElement('td')).appendTo(tr);
                td2 = $(document.createElement('td')).appendTo(tr);
                
                label.zone_id = $(document.createElement('label')).text('". $this->data['entry_zone'] ."').appendTo(td1);
                input.zone_id = $(document.createElement('select')).attr({
                    'type':'text',
                    'name':'addresses['+ address_row +'][zone_id]'
                }).appendTo(td2);
                
                tr = $(document.createElement('tr')).appendTo(table);
                td1 = $(document.createElement('td')).appendTo(tr);
                td2 = $(document.createElement('td')).appendTo(tr);
                
                label.city = $(document.createElement('label')).text('". $this->data['entry_city'] ."').appendTo(td1);
                input.city = $(document.createElement('input')).attr({
                    'type':'text',
                    'name':'addresses['+ address_row +'][city]'
                }).appendTo(td2);
                
                tr = $(document.createElement('tr')).appendTo(table);
                td1 = $(document.createElement('td')).appendTo(tr);
                td2 = $(document.createElement('td')).appendTo(tr);
                
                label.postcode = $(document.createElement('label')).text('". str_replace('&oacute;','\u00F3',$this->data['entry_postcode']) ."').appendTo(td1);
                input.postcode = $(document.createElement('input')).attr({
                    'type':'text',
                    'name':'addresses['+ address_row +'][postcode]'
                }).appendTo(td2);
                
                tr = $(document.createElement('tr')).appendTo(table);
                td1 = $(document.createElement('td')).appendTo(tr);
                td2 = $(document.createElement('td')).appendTo(tr);
                
                label.address = $(document.createElement('label')).text('". str_replace('&oacute;','\u00F3',$this->data['entry_address_1']) ."').appendTo(td1);
                input.address = $(document.createElement('input')).attr({
                    'type':'text',
                    'name':'addresses['+ address_row +'][address_1]'
                }).appendTo(td2);
                
            	$('#form').append(div);
                
                var li = $(document.createElement('li')).attr('id','address_'+ address_row);
                
                var a = $(document.createElement('a')).attr({
                    'data-target':'#tab_address_'+ address_row,
                    'onclick':'showTab(this)'
                })
                .text('". str_replace('&oacute;','\u00F3',$this->data['tab_address']) ." '+ address_row)
                .appendTo(li);
                
                var span = $(document.createElement('span')).attr({
                    'title':'Eliminar Direcci&oacute;n'
                })
                .text('\u00A0')
                .addClass('remove')
                .on('click',function(e){
                    $('#vtabs a:first').trigger('click'); 
                    $('#address_'+ address_row).remove(); 
                    $('#tab_address_'+ address_row).remove();
                })
                .appendTo(a);
                
            	$('#address_add').before(li);
            	$('#address_'+ address_row).trigger('click');
            }");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'sale/customer_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
	
	/**
	 * ControllerSaleCustomer::zone()
	 * 
	 * @return
	 */
	public function zone() {
		$output = '';
		
		$this->load->auto('localisation/zone');
		
		$results = $this->modelZone->getZonesByCountryId($this->request->get['country_id']);
		
		foreach ($results as $result) {
			$output .= '<option value="' . $result['zone_id'] . '"';

			if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
				$output .= ' selected="selected"';
			}

			$output .= '>' . $result['name'] . '</option>';
		}

		if (!$results) {
			$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
		}

		$this->response->setOutput($output, $this->config->get('config_compression'));
	}
		 
	/**
	 * ControllerSaleCustomer::approve()
	 * 
	 * @return
	 */
	public function approve() {
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->session->set('error',$this->language->get('error_permission')); ;
		} else {
			if (isset($this->request->post['selected'])) {
				foreach ($this->request->post['selected'] as $customer_id) {
					$customer_info = $this->modelCustomer->getCustomer($customer_id);
			
					if ($customer_info && !$customer_info['approved']) {
						$this->modelCustomer->approve($customer_id);
						
							$store_name = $this->config->get('config_name');
							$store_url = $this->config->get('config_url') . 'index.php?r=account/login';
						
						$message  = sprintf($this->language->get('text_welcome'), $store_name) . "\n\n";;
						$message .= $this->language->get('text_login') . "\n";
						$message .= $store_url . "\n\n";
						$message .= $this->language->get('text_services') . "\n\n";
						$message .= $this->language->get('text_thanks') . "\n";
						$message .= $store_name;
				
						$mail = new Mail();
						$mail->protocol = $this->config->get('config_mail_protocol');
						$mail->hostname = $this->config->get('config_smtp_host');
						$mail->username = $this->config->get('config_smtp_username');
						$mail->password = $this->config->get('config_smtp_password');
						$mail->port = $this->config->get('config_smtp_port');
						$mail->timeout = $this->config->get('config_smtp_timeout');							
						$mail->setTo($customer_info['email']);
						$mail->setFrom($this->config->get('config_email'));
						$mail->setSender($store_name);
						$mail->setSubject(sprintf($this->language->get('text_subject'), $store_name));
						$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
						$mail->send();
					
						$this->session->set('success',sprintf($this->language->get('text_approved'), $customer_info['firstname'] . ' ' . $customer_info['lastname']));
					}
				}
			}			
		}
		
		$url = '';
	
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
	
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
	
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

		$this->redirect(Url::createAdminUrl('sale/customer') . $url);
	} 
	 
  	/**
  	 * ControllerSaleCustomer::validateForm()
  	 * 
  	 * @return
  	 */
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/customer')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if ((strlen(utf8_decode($this->request->post['rif'])) < 1) || (strlen(utf8_decode($this->request->post['rif']))> 32)) {
      		$this->error['rif'] = $this->language->get('error_rif');
    	}

    	if ($this->request->post['rif'] == 'false') {
      		$this->error['sexo'] = $this->language->get('error_sexo');
    	}
        
        if ((strlen(utf8_decode($this->request->post['company'])) < 1) || (strlen(utf8_decode($this->request->post['company']))> 32)) {
      		$this->error['company'] = $this->language->get('error_company');
    	}
        
        if ((strlen(utf8_decode($this->request->post['firstname'])) < 1) || (strlen(utf8_decode($this->request->post['firstname']))> 32)) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	}

    	if ((strlen(utf8_decode($this->request->post['lastname'])) < 1) || (strlen(utf8_decode($this->request->post['lastname']))> 32)) {
      		$this->error['lastname'] = $this->language->get('error_lastname');
    	}

		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';
    	
		if ((strlen(utf8_decode($this->request->post['email']))> 96) || (!preg_match($pattern, $this->request->post['email']))) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ((strlen(utf8_decode($this->request->post['telephone'])) < 3) || (strlen(utf8_decode($this->request->post['telephone']))> 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	}

    	if (($this->request->post['password']) || (!isset($this->request->get['customer_id']))) {
      		if ((strlen(utf8_decode($this->request->post['password'])) < 4) || (strlen(utf8_decode($this->request->post['password']))> 20)) {
        		$this->error['password'] = $this->language->get('error_password');
      		}
	
	  		if ($this->request->post['password'] != $this->request->post['confirm']) {
	    		$this->error['confirm'] = $this->language->get('error_confirm');
	  		}
    	}

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    

  	/**
  	 * ControllerSaleCustomer::validateDelete()
  	 * 
  	 * @return
  	 */
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/customer')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}	
	  	 
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  
  	} 	
    
    public function callback() {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header('Cache-Control: no-cache, must-revalidate');
		header("Pragma: no-cache");
		header("Content-type: application/json");

		$this->load->model('sale/customer');
        $name = $this->request->get['term'];
        
        $results = $this->modelCustomer->getCustomers();
        if (!$results) {
    		 $data['error'] = 1; 
		} else {
		  foreach ($results as $key => $value) {
		      $data[] = array(
                'id' => $value['cid'],
                'label' => $value['email'],
                'value' => $value['name'],
              );
		  }
		      
		}
		$this->load->library('json');
		$this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
    }
    
    /**
     * ControllerSaleCategory::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('sale/customer');
        $status = $this->modelCustomer->getCustomer($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelCustomer->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelCustomer->desactivate($_GET['id']);
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
     public function aprobar() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('sale/customer');
        $status = $this->modelCustomer->getCustomer($_GET['id']);
        if ($status) {
            if ($status['approved'] == 0) {
                $this->modelCustomer->approve($_GET['id']);
                echo 1;
            } else {
                $this->modelCustomer->desapprove($_GET['id']);
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
        $this->load->auto('sale/customer');
        $result = $this->modelCustomer->getCustomer($_GET['id']);
        if ($result) {
            $this->modelCustomer->deleteCustomer($_GET['id']);
            echo 1;
        } else {
            echo 0;
        }
     }
    
	
}
