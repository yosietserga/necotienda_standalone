<?php  
/**
 * ControllerSaleCoupon
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerSaleCoupon extends Controller {
	private $error = array();
     
  	/**
  	 * ControllerSaleCoupon::index()
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
  	 * ControllerSaleCoupon::insert()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see Request
     * @see getForm
  	 * @return void
  	 */
  	public function insert() {
    	$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelCoupon->addCoupon($this->request->post);
			
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
			
			$this->redirect(Url::createAdminUrl('sale/coupon') . $url);
    	}
    
    	$this->getForm();
  	}

  	/**
  	 * ControllerSaleCoupon::update()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see Request
     * @see getForm
  	 * @return void
  	 */
  	public function update() {
    	$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelCoupon->editCoupon($this->request->get['coupon_id'], $this->request->post);
      		
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
			
			$this->redirect(Url::createAdminUrl('sale/coupon') . $url);
		}
    
    	$this->getForm();
  	}

  	/**
  	 * ControllerSaleCoupon::delete()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see Request
     * @see getList
  	 * @return void
  	 */
  	public function delete() {
    	$this->document->title = $this->language->get('heading_title');
		if (isset($this->request->post['selected']) && $this->validateDelete()) { 
			foreach ($this->request->post['selected'] as $coupon_id) {
				$this->modelCoupon->deleteCoupon($coupon_id);
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
			
			$this->redirect(Url::createAdminUrl('sale/coupon') . $url);
    	}
	
    	$this->getList();
  	}

  	/**
  	 * ControllerSaleCoupon::getList()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
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
       		'href'      => Url::createAdminUrl('sale/coupon') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = Url::createAdminUrl('sale/coupon/insert') . $url;
		$this->data['delete'] = Url::createAdminUrl('sale/coupon/delete') . $url;
									
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
        $scripts[] = array('id'=>'couponList','method'=>'function','script'=>
            "function activate(e) {
                $.getJSON('". Url::createAdminUrl("sale/coupon/activate") ."',{
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
                $.post('". Url::createAdminUrl("sale/coupon/delete") ."',$('#formGrid').serialize(),function(){
                    $('#gridWrapper').load('". Url::createAdminUrl("sale/coupon/grid") ."');
                });
            } 
            function eliminar(e) {    
                $('#tr_' + e).hide();
                if (confirm('¿Desea eliminar este objeto?')) {
                	$.getJSON('". Url::createAdminUrl("sale/coupon/eliminar") ."',{
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
            "$('#gridWrapper').load('". Url::createAdminUrl("sale/coupon/grid") ."',function(){
                $('#gridPreloader').hide();
            });
                
            $('#formFilter').ntForm({
                lockButton:false,
                ajax:true,
                type:'get',
                dataType:'html',
                url:'". Url::createAdminUrl("sale/coupon/grid") ."',
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
        
		$this->template = 'sale/coupon_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}

  	/**
  	 * ControllerSaleCoupon::getList()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see Request
  	 * @return void
  	 */
  	public function grid() {
  	 
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
		$filter_product = isset($this->request->get['filter_product']) ? $this->request->get['filter_product'] : null;
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'cd.name';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
		
		$url = '';
			
		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; } 
		if (isset($this->request->get['filter_product'])) { $url .= '&filter_product=' . $this->request->get['filter_product']; } 
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; }

		$this->data['coupons'] = array();

		$data = array(
			'filter_name' => $filter_name, 
			'filter_product' => $filter_product, 
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $limit
		);
		
		$coupon_total = $this->modelCoupon->getTotalCoupons();
	
		$results = $this->modelCoupon->getCoupons($data);
 
    	foreach ($results as $result) {
            $action = array(
                'edit'      => array(
                        'action'  => 'edit',
                        'text'  => $this->language->get('text_edit'),
                        'href'  =>Url::createAdminUrl('sale/coupon/update') . '&coupon_id=' . $result['coupon_id'] . $url,
                        'img'   => 'edit.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );
					
			$this->data['coupons'][] = array(
				'coupon_id'  => $result['coupon_id'],
				'name'       => $result['name'],
				'code'       => $result['code'],
				'discount'   => $result['discount'],
				'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
				'date_end'   => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['coupon_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_code'] = $this->language->get('column_code');
		$this->data['column_discount'] = $this->language->get('column_discount');
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		
		$this->data['sort_name'] = Url::createAdminUrl('sale/coupon/grid') . '&sort=cd.name' . $url;
		$this->data['sort_code'] = Url::createAdminUrl('sale/coupon/grid') . '&sort=c.code' . $url;
		$this->data['sort_discount'] = Url::createAdminUrl('sale/coupon/grid') . '&sort=c.discount' . $url;
		$this->data['sort_date_start'] = Url::createAdminUrl('sale/coupon/grid') . '&sort=c.date_start' . $url;
		$this->data['sort_date_end'] = Url::createAdminUrl('sale/coupon/grid') . '&sort=c.date_end' . $url;
		$this->data['sort_status'] = Url::createAdminUrl('sale/coupon/grid') . '&sort=c.status' . $url;
				
		$url = '';

		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }					
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }

		$pagination = new Pagination();
		$pagination->total = $coupon_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('sale/coupon') . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/coupon_grid.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}

  	/**
  	 * ControllerSaleCoupon::getForm()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see Request
  	 * @return void
  	 */
  	private function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
    	$this->data['text_percent'] = $this->language->get('text_percent');
    	$this->data['text_amount'] = $this->language->get('text_amount');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
    	$this->data['entry_description'] = $this->language->get('entry_description');
    	$this->data['entry_code'] = $this->language->get('entry_code');
		$this->data['entry_discount'] = $this->language->get('entry_discount');
		$this->data['entry_logged'] = $this->language->get('entry_logged');
		$this->data['entry_shipping'] = $this->language->get('entry_shipping');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_product'] = $this->language->get('entry_product');
    	$this->data['entry_date_start'] = $this->language->get('entry_date_start');
    	$this->data['entry_date_end'] = $this->language->get('entry_date_end');
    	$this->data['entry_uses_total'] = $this->language->get('entry_uses_total');
		$this->data['entry_uses_customer'] = $this->language->get('entry_uses_customer');
		$this->data['entry_status'] = $this->language->get('entry_status');
		
		$this->data['help_name'] = $this->language->get('help_name');
    	$this->data['help_description'] = $this->language->get('help_description');
    	$this->data['help_code'] = $this->language->get('help_code');
		$this->data['help_discount'] = $this->language->get('help_discount');
		$this->data['help_logged'] = $this->language->get('help_logged');
		$this->data['help_shipping'] = $this->language->get('help_shipping');
		$this->data['help_type'] = $this->language->get('help_type');
		$this->data['help_total'] = $this->language->get('help_total');
		$this->data['help_product'] = $this->language->get('help_product');
    	$this->data['help_date_start'] = $this->language->get('help_date_start');
    	$this->data['help_date_end'] = $this->language->get('help_date_end');
    	$this->data['help_uses_total'] = $this->language->get('help_uses_total');
		$this->data['help_uses_customer'] = $this->language->get('help_uses_customer');
		$this->data['help_status'] = $this->language->get('help_status');

    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');

    	$this->data['tab_general'] = $this->language->get('tab_general');

		$this->data['token'] = $this->session->get('ukey');
		
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
		
		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}
		
		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}		
		
		if (isset($this->error['date_start'])) {
			$this->data['error_date_start'] = $this->error['date_start'];
		} else {
			$this->data['error_date_start'] = '';
		}	
		
		if (isset($this->error['date_end'])) {
			$this->data['error_date_end'] = $this->error['date_end'];
		} else {
			$this->data['error_date_end'] = '';
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
       		'href'      => Url::createAdminUrl('sale/coupon') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['coupon_id'])) {
			$this->data['action'] = Url::createAdminUrl('sale/coupon/insert') . $url;
		} else {
			$this->data['action'] = Url::createAdminUrl('sale/coupon/update') . '&coupon_id=' . $this->request->get['coupon_id'] . $url;
		}
		
		$this->data['cancel'] = Url::createAdminUrl('sale/coupon') . $url;
  		
		if (isset($this->request->get['coupon_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$coupon_info = $this->modelCoupon->getCoupon($this->request->get['coupon_id']);
    	}
		
    	$this->data['languages'] = $this->modelLanguage->getLanguages();
    
		if (isset($this->request->post['coupon_description'])) {
			$this->data['coupon_description'] = $this->request->post['coupon_description'];
		} elseif (isset($this->request->get['coupon_id'])) {
			$this->data['coupon_description'] = $this->modelCoupon->getCouponDescriptions($this->request->get['coupon_id']);
		} else {
			$this->data['coupon_description'] = array();
		}

    	if (isset($this->request->post['code'])) {
      		$this->data['code'] = $this->request->post['code'];
    	} elseif (isset($coupon_info)) {
			$this->data['code'] = $coupon_info['code'];
		} else {
      		$this->data['code'] = '';
    	}
		
    	if (isset($this->request->post['type'])) {
      		$this->data['type'] = $this->request->post['type'];
    	} elseif (isset($coupon_info)) {
			$this->data['type'] = $coupon_info['type'];
		} else {
      		$this->data['type'] = '';
    	}
		
    	if (isset($this->request->post['discount'])) {
      		$this->data['discount'] = $this->request->post['discount'];
    	} elseif (isset($coupon_info)) {
			$this->data['discount'] = $coupon_info['discount'];
		} else {
      		$this->data['discount'] = '';
    	}

    	if (isset($this->request->post['logged'])) {
      		$this->data['logged'] = $this->request->post['logged'];
    	} elseif (isset($coupon_info)) {
			$this->data['logged'] = $coupon_info['logged'];
		} else {
      		$this->data['logged'] = '';
    	}
		
    	if (isset($this->request->post['shipping'])) {
      		$this->data['shipping'] = $this->request->post['shipping'];
    	} elseif (isset($coupon_info)) {
			$this->data['shipping'] = $coupon_info['shipping'];
		} else {
      		$this->data['shipping'] = '';
    	}

    	if (isset($this->request->post['total'])) {
      		$this->data['total'] = $this->request->post['total'];
    	} elseif (isset($coupon_info)) {
			$this->data['total'] = $coupon_info['total'];
		} else {
      		$this->data['total'] = '';
    	}
		
    	if (isset($this->request->post['product'])) {
      		$this->data['coupon_product'] = $this->request->post['product'];
    	} elseif (isset($coupon_info)) {
      		$this->data['coupon_product'] = $this->modelCoupon->getCouponProducts($this->request->get['coupon_id']);
    	} else {
			$this->data['coupon_product'] = array();
		}
	
		$this->data['categories'] = $this->modelCategory->getCategories(0);
		
		if (isset($this->request->post['date_start'])) {
       		$this->data['date_start'] = $this->request->post['date_start'];
		} elseif (isset($coupon_info)) {
			$this->data['date_start'] = date('Y-m-d', strtotime($coupon_info['date_start']));
		} else {
			$this->data['date_start'] = date('Y-m-d', time());
		}

		if (isset($this->request->post['date_end'])) {
       		$this->data['date_end'] = $this->request->post['date_end'];
		} elseif (isset($coupon_info)) {
			$this->data['date_end'] = date('Y-m-d', strtotime($coupon_info['date_end']));
		} else {
			$this->data['date_end'] = date('Y-m-d', time());
		}

    	if (isset($this->request->post['uses_total'])) {
      		$this->data['uses_total'] = $this->request->post['uses_total'];
		} elseif (isset($coupon_info)) {
			$this->data['uses_total'] = $coupon_info['uses_total'];
    	} else {
      		$this->data['uses_total'] = 1;
    	}
  
    	if (isset($this->request->post['uses_customer'])) {
      		$this->data['uses_customer'] = $this->request->post['uses_customer'];
    	} elseif (isset($coupon_info)) {
			$this->data['uses_customer'] = $coupon_info['uses_customer'];
		} else {
      		$this->data['uses_customer'] = 1;
    	}
 
    	if (isset($this->request->post['status'])) { 
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (isset($coupon_info)) {
			$this->data['status'] = $coupon_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
		
		$this->template = 'sale/coupon_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));		
  	}
	
  	/**
  	 * ControllerSaleCoupon::validateForm()
  	 * 
     * @see User
     * @see Language
     * @see Request
  	 * @return bool
  	 */
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/coupon')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	      
    	foreach ($this->request->post['coupon_description'] as $language_id => $value) {
      		if ((strlen(utf8_decode($value['name'])) < 3) || (strlen(utf8_decode($value['name']))> 64)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}

      		if (strlen(utf8_decode($value['description'])) < 3) {
        		$this->error['description'][$language_id] = $this->language->get('error_description');
      		}
    	}

    	if ((strlen(utf8_decode($this->request->post['code'])) < 3) || (strlen(utf8_decode($this->request->post['code']))> 24)) {
      		$this->error['code'] = $this->language->get('error_code');
    	}
		
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}

	/**
	 * ControllerSaleCoupon::category()
	 * 
     * @see Load
     * @see Request
     * @see Response
  	 * @return void
	 */
	public function category() {
		$this->load->auto('store/product');
		
		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}
		
		$product_data = array();
		
		$results = $this->modelProduct->getProductsByCategoryId($category_id);
		$html_output = '';
		foreach ($results as $result) {
			$product_data[] = array(
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model']
			);
		}
		if ($results) {
		  foreach ($product_data as $product) {
		      $html_output .= "<option value='".$product['product_id']."'>".$product['name']."</option>";
		  }
		} else {
              $html_output .= 1;		  
		}
        echo $html_output;
	}
	
	/**
	 * ControllerSaleCoupon::product()
	 * 
     * @see Load
     * @see Request
     * @see Response
  	 * @return void
	 */
	public function product() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        
		$this->load->auto('store/product');
		
		if (isset($this->request->post['coupon_product'])) {
			$products = $this->request->post['coupon_product'];
		} else {
			$products = array();
		}
	
		$product_data = array();
		
		foreach ($products as $product_id) {
			$product_info = $this->modelProduct->getProduct($product_id);
			
			if ($product_info) {
				$product_data[] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name'],
					'model'      => $product_info['model']
				);
			}
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($product_data));
	}

  	/**
  	 * ControllerSaleCoupon::validateDelete()
  	 * 
     * @see User
     * @see Language
     * @see Request
  	 * @return bool
  	 */
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/coupon')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
	  	
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}		
}
