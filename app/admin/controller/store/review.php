<?php
class ControllerStoreReview extends Controller {
	private $error = array();
 
	public function index() {
		$this->document->title = $this->language->get('heading_title');
		$this->getList();
	} 

	public function insert() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelReview->addReview($this->request->post);
			
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
						
			$this->redirect(Url::createAdminUrl('store/review') . $url);
		}

		$this->getForm();
	}

	public function update() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelReview->editReview($this->request->get['review_id'], $this->request->post);
			
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
						
			$this->redirect(Url::createAdminUrl('store/review') . $url);
		}

		$this->getForm();
	}

	public function delete() { 
		$this->document->title = $this->language->get('heading_title');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $review_id) {
				$this->modelReview->deleteReview($review_id);
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
						
			$this->redirect(Url::createAdminUrl('store/review') . $url);
		}

		$this->getList();
	}

	private function getList() {
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('store/review') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = Url::createAdminUrl('store/review/insert') . $url;
		$this->data['delete'] = Url::createAdminUrl('store/review/delete') . $url;	

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
        $scripts[] = array('id'=>'reviewList','method'=>'function','script'=>
            "function activate(e) {
                $.getJSON('". Url::createAdminUrl("store/review/activate") ."',{
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
                $.post('". Url::createAdminUrl("store/review/delete") ."',$('#formGrid').serialize(),function(){
                    $('#gridWrapper').load('". Url::createAdminUrl("store/review/grid") ."');
                });
            } 
            function eliminar(e) {    
                $('#tr_' + e).hide();
                if (confirm('¿Desea eliminar este objeto?')) {
                	$.getJSON('". Url::createAdminUrl("store/review/eliminar") ."',{
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
            "$('#gridWrapper').load('". Url::createAdminUrl("store/review/grid") ."',function(e){
                $('#gridPreloader').hide();
                $('#list tbody').sortable({
                    opacity: 0.6, 
                    cursor: 'move',
                    handle: '.move',
                    update: function() {
                        $.ajax({
                            'type':'post',
                            'dateType':'json',
                            'url':'". Url::createAdminUrl("store/review/sortable") ."',
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
                url:'". Url::createAdminUrl("store/review/grid") ."',
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
        
		$this->template = 'store/review_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	public function grid() {
	   
		$filter_author = isset($this->request->get['filter_author']) ? $this->request->get['filter_author'] : null;
		$filter_product = isset($this->request->get['filter_product']) ? $this->request->get['filter_product'] : null;
		$filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
		$filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'r.date_added';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
		
		$url = '';
			
		if (isset($this->request->get['filter_author'])) { $url .= '&filter_author=' . $this->request->get['filter_author']; } 
		if (isset($this->request->get['filter_product'])) { $url .= '&filter_product=' . $this->request->get['filter_product']; } 
		if (isset($this->request->get['filter_date_start'])) { $url .= '&filter_date_start=' . $this->request->get['filter_date_start']; }
		if (isset($this->request->get['filter_date_end'])) { $url .= '&filter_date_end=' . $this->request->get['filter_date_end']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; }
		
		$this->data['reviews'] = array();

		$data = array(
			'filter_author'    => $filter_author,
			'filter_product'   => $filter_product,
			'filter_date_start'=> $filter_date_start, 
			'filter_date_end'  => $filter_date_end, 
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $limit
		);
		
		$review_total = $this->modelReview->getTotalReviews();
	
		$results = $this->modelReview->getReviews($data);
 
    	foreach ($results as $result) {
				$action = array(
                'activate'  => array(
                        'action'  => 'activate',
                        'text'  => $this->language->get('text_activate'),
                        'href'  =>'',
                        'img'   => 'good.png'
                ),
                'edit'      => array(
                        'action'  => 'edit',
                        'text'  => $this->language->get('text_edit'),
                        'href'  =>Url::createAdminUrl('store/review/update') . '&review_id=' . $result['review_id'] . $url,
                        'img'   => 'edit.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );	
			$this->data['reviews'][] = array(
				'review_id'  => $result['review_id'],
				'product_url'=> Url::createAdminUrl('store/product/see') . '&amp;product_id=' . $result['product_id'],
				'name'       => $result['name'],
				'author'     => $result['author'],
				'rating'     => $result['rating'],       
				'text'       => $result['text'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added' => date('d-m-Y h:i', strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['review_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}	
        
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_author'] = $this->language->get('column_author');
		$this->data['column_rating'] = $this->language->get('column_rating');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['filter_author'])) { $url .= '&filter_author=' . $this->request->get['filter_author']; } 
		if (isset($this->request->get['filter_product'])) { $url .= '&filter_product=' . $this->request->get['filter_product']; } 
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; }
        
		$this->data['sort_product'] = Url::createAdminUrl('store/review/grid') . '&sort=pd.name' . $url;
		$this->data['sort_author'] = Url::createAdminUrl('store/review/grid') . '&sort=r.author' . $url;
		$this->data['sort_rating'] = Url::createAdminUrl('store/review/grid') . '&sort=r.rating' . $url;
		$this->data['sort_status'] = Url::createAdminUrl('store/review/grid') . '&sort=r.status' . $url;
		$this->data['sort_date_added'] = Url::createAdminUrl('store/review/grid') . '&sort=r.date_added' . $url;
		
		$url = '';

		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }

		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page  = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text  = $this->language->get('text_pagination');
		$pagination->url   = Url::createAdminUrl('store/review/grid') . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort']  = $sort;
		$this->data['order'] = $order;

		$this->template = 'store/review_grid.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_select'] = $this->language->get('text_select');

		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_author'] = $this->language->get('entry_author');
		$this->data['entry_rating'] = $this->language->get('entry_rating');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_text'] = $this->language->get('entry_text');
		$this->data['entry_good'] = $this->language->get('entry_good');
		$this->data['entry_bad'] = $this->language->get('entry_bad');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
 		
		if (isset($this->error['product'])) {
			$this->data['error_product'] = $this->error['product'];
		} else {
			$this->data['error_product'] = '';
		}
		
 		if (isset($this->error['author'])) {
			$this->data['error_author'] = $this->error['author'];
		} else {
			$this->data['error_author'] = '';
		}
		
 		if (isset($this->error['text'])) {
			$this->data['error_text'] = $this->error['text'];
		} else {
			$this->data['error_text'] = '';
		}
		
 		if (isset($this->error['rating'])) {
			$this->data['error_rating'] = $this->error['rating'];
		} else {
			$this->data['error_rating'] = '';
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
       		'href'      => Url::createAdminUrl('store/review') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['review_id'])) { 
			$this->data['action'] = Url::createAdminUrl('store/review/insert') . $url;
		} else {
			$this->data['action'] = Url::createAdminUrl('store/review/update') . '&review_id=' . $this->request->get['review_id'] . $url;
		}
		
		$this->data['cancel'] = Url::createAdminUrl('store/review') . $url;

		$this->data['token'] = $this->session->get('ukey');

		if (isset($this->request->get['review_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$review_info = $this->modelReview->getReview($this->request->get['review_id']);
		}
		
		$this->data['categories'] = $this->modelCategory->getCategories(0);
		
		if (isset($this->request->post['product_id'])) {
			$this->data['product_id'] = $this->request->post['product_id'];
			
			$product_info = $this->modelProduct->getProduct($this->request->post['product_id']);
			
			if ($product_info) {
				$this->data['product'] = $product_info['name'];
			} else {
				$this->data['product'] = '';
			}
		} elseif (isset($review_info)) {
			$this->data['product_id'] = $review_info['product_id'];
			
			$product_info = $this->modelProduct->getProduct($review_info['product_id']);
			
			if ($product_info) {
				$this->data['product'] = $product_info['name'];
			} else {
				$this->data['product'] = '';
			}
		} else {
			$this->data['product_id'] = '';
		}
		
		if (isset($this->request->post['author'])) {
			$this->data['author'] = $this->request->post['author'];
		} elseif (isset($review_info)) {
			$this->data['author'] = $review_info['author'];
		} else {
			$this->data['author'] = '';
		}

		if (isset($this->request->post['text'])) {
			$this->data['text'] = $this->request->post['text'];
		} elseif (isset($review_info)) {
			$this->data['text'] = $review_info['text'];
		} else {
			$this->data['text'] = '';
		}

		if (isset($this->request->post['rating'])) {
			$this->data['rating'] = $this->request->post['rating'];
		} elseif (isset($review_info)) {
			$this->data['rating'] = $review_info['rating'];
		} else {
			$this->data['rating'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($review_info)) {
			$this->data['status'] = $review_info['status'];
		} else {
			$this->data['status'] = '';
		}
		
		$this->template = 'store/review_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
	
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
		if ($results) {
			foreach ($results as $result) {
              $html_output .= "<option value='".$result['product_id']."'>".$result['name']."</option>";
			}
		} else {		
              $html_output .= 1;
        }
        echo $html_output;
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'store/review')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['product_id']) {
			$this->error['product'] = $this->language->get('error_product');
		}
		
		if ((strlen(utf8_decode($this->request->post['author'])) < 3) || (strlen(utf8_decode($this->request->post['author']))> 64)) {
			$this->error['author'] = $this->language->get('error_author');
		}

		if ((strlen(utf8_decode($this->request->post['text'])) < 25) || (strlen(utf8_decode($this->request->post['text']))> 1000)) {
			$this->error['text'] = $this->language->get('error_text');
		}
		
		if ((strlen(utf8_decode($this->request->post['text'])) < 25) || (strlen(utf8_decode($this->request->post['text']))> 1000)) {
			$this->error['text'] = $this->language->get('error_text');
		}
		
		if (!isset($this->request->post['rating'])) {
			$this->error['rating'] = $this->language->get('error_rating');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'store/review')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
    
    /**
     * ControllerStoreReview::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('store/review');
        $status = $this->modelReview->getReview($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelReview->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelReview->desactivate($_GET['id']);
                echo -1;
            }
            
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerStoreReview::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function eliminar() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('store/review');
        $result = $this->modelReview->getReview($_GET['id']);
        if ($result) {
            $this->modelReview->deleteReview($_GET['id']);
            echo 1;
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerStoreReview::sortable()
     * ordenar el listado actualizando la posición de cada objeto
     * @return boolean
     * */
     public function sortable() {
        if (!isset($_POST['tr'])) return false;
        $this->load->auto('store/review');
        $result = $this->modelReview->sortReview($_POST['tr']);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
     }
     
	
}