<?php
class ControllerStoreReview extends Controller {
	private $error = array();
 
	public function index() {
		$this->document->title = $this->language->get('heading_title');
		$this->getList();
	} 

	public function insert() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$review_id = $this->modelReview->addReview($this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));
		
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('store/review/update',array('review_id'=>$review_id))); 
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('store/review/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('store/review')); 
            }
		}

		$this->getForm();
	}

	public function update() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelReview->editReview($this->request->get['review_id'], $this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('store/review/update',array('review_id'=>$this->request->get['review_id']))); 
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('store/review/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('store/review')); 
            }
		}

		$this->getForm();
	}

    /**
     * ControllerStoreCategory::delete()
     * elimina un objeto
     * @return boolean
     * */
     public function delete() {
        $this->load->auto('store/category');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelReview->delete($id);
            }
		} else {
            $this->modelReview->delete($_GET['id']);
		}
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
            function deleteAll() {
                if (confirm('¿Desea eliminar todos los objetos seleccionados?')) {
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                    $.post('". Url::createAdminUrl("store/category/delete") ."',$('#form').serialize(),function(){
                        $('#gridWrapper').load('". Url::createAdminUrl("store/category/grid") ."',function(){
                            $('#gridWrapper').show();
                            $('#gridPreloader').hide();
                        });
                    });
                }
                return false;
            }
            function eliminar(e) {
                if (confirm('¿Desea eliminar este objeto?')) {
                    $('#tr_' + e).hide();
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
				'product_url'=> HTTP_CATALOG . '/index.php?r=store/product&amp;product_id=' . $result['product_id'],
				'name'       => $result['name'],
				'author'     => $result['author'],
				'rating'     => $result['rating'],       
				'text'       => $result['text'],
				'status'     => ($result['rstatus']==1) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added' => date('d-m-Y h:i:s', strtotime($result['created'])),
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

		$this->data['button_save_and_new']= $this->language->get('button_save_and_new');
		$this->data['button_save_and_exit']= $this->language->get('button_save_and_exit');
		$this->data['button_save_and_keep']= $this->language->get('button_save_and_keep');
		$this->data['button_cancel']      = $this->language->get('button_cancel');

 		$this->data['error_warning'] = ($this->error['warning']) ? $this->error['warning'] : '';
 		$this->data['error_product'] = ($this->error['product']) ? $this->error['product'] : '';
 		$this->data['error_author']  = ($this->error['author']) ? $this->error['author'] : '';
 		$this->data['error_text']    = ($this->error['text']) ? $this->error['text'] : '';
 		$this->data['error_rating']  = ($this->error['rating']) ? $this->error['rating'] : '';
 		$this->data['error_warning'] = ($this->error['warning']) ? $this->error['warning'] : '';
        	
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

		if (isset($this->request->get['review_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$review_info = $this->modelReview->getReview($this->request->get['review_id']);
		}
		
        $this->setvar('author',$review_info,'');
        $this->setvar('text',$review_info,'');
        $this->setvar('rating',$review_info,'');
        $this->setvar('status',$review_info,'');
        $this->setvar('product_id',$review_info,'');
        
        $product_info = ($this->data['product_id']) ? $this->modelProduct->getProduct($this->data['product_id']) : '';
		$this->data['product'] = ($product_info) ? $product_info['name'] : '';
		
        $this->data['Url'] = new Url;
        //TODO: mostrar los productos al scrolldown para no colapsar el navegador cuando se listan todos los productos
        //TODO: crear cache del layout de los productos y luego detetar los seleccionados con jquery
        $scripts[] = array('id'=>'reviewScripts','method'=>'ready','script'=>
            "$('#addProductsWrapper').hide();
            
            $('#addProductsPanel').on('click',function(e){
                var products = $('#addProductsWrapper').find('.row');
                
                if (products.length == 0) {
                    $.getJSON('".Url::createAdminUrl("store/review/products")."',
                        {
                            'review_id':'".$this->request->getQuery('review_id')."'
                        }, function(data) {
                            
                            $('#addProductsWrapper').html('<div class=\"row\"><label for=\"q\" style=\"float:left\">Filtrar listado de productos:</label><input type=\"text\" value=\"\" name=\"q\" id=\"q\" /></div><div class=\"clear\"></div><br /><ul id=\"addProducts\"></ul>');
                            
                            $.each(data, function(i,item){
                                $('#addProducts').append('<li><img src=\"' + item.pimage + '\" alt=\"' + item.pname + '\" /><b class=\"' + item.class + '\">' + item.pname + '</b><input type=\"hidden\" name=\"Products[' + item.product_id + ']\" value=\"' + item.product_id + '\" /></li>');
                                
                            });
                            
                            $('#q').on('change',function(e){
                                var that = this;
                                var valor = $(that).val().toLowerCase();
                                if (valor.length <= 0) {
                                    $('#addProducts li').show();
                                } else {
                                    $('#addProducts li b').each(function(){
                                        if ($(this).text().toLowerCase().indexOf( valor ) > 0) {
                                            $(this).closest('li').show();
                                        } else {
                                            $(this).closest('li').hide();
                                        }
                                    });
                                }
                            }); 
                            
                            $('li').on('click',function() {
                                $('li b').removeClass('added');
                                $(this).find('b').addClass('added');
                                $('#product_id').val( $(this).find('input').val() );
                                $('#product_name').text( $(this).find('img').attr('alt') );
                                
                            });
                    });
                }
            });
                
            $('#addProductsPanel').on('click',function(){ $('#addProductsWrapper').slideToggle() });
            
            $('#form').ntForm({
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
            
            $('.sidebar .tab').on('click',function(){
                $(this).closest('.sidebar').addClass('show').removeClass('hide').animate({'right':'0px'});
            });
            $('.sidebar').mouseenter(function(){
                clearTimeout($(this).data('timeoutId'));
            }).mouseleave(function(){
                var e = this;
                var timeoutId = setTimeout(function(){
                    if ($(e).hasClass('show')) {
                        $(e).removeClass('show').addClass('hide').animate({'right':'-400px'});
                    }
                }, 600);
                $(this).data('timeoutId', timeoutId); 
            });");
            
        $scripts[] = array('id'=>'reviewFunctions','method'=>'function','script'=>
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
            }");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'store/review_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

     public function products() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        $this->load->auto("store/product");
        $this->load->auto("image");
        $this->load->auto("url");
        
        $cache = $this->cache->get("products.for.reviews.form");
        if ($cache) {
            $products = unserialize($cache);
        } else {
            $model = $this->modelProduct->getAll();
            $products = $model->obj;
            $this->cache->set("products.for.reviews.form",serialize($products));
        }
        
        $this->data['Image'] = new NTImage();
        $this->data['Url'] = new Url;
        
        $output = array();
        
        foreach ($products as $product) {
            $output[] = array(
                'product_id'=>$product->product_id,
                'pimage'    =>NTImage::resizeAndSave($product->pimage,50,50),
                'pname'     =>$product->pname,
                'class'     =>'add',
                'value'     =>0
            );
        }
        $this->load->auto('json');
        $this->response->setOutput(Json::encode($output), $this->config->get('config_compression'));
            
     }
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'store/review')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['product_id']) {
			$this->error['product'] = $this->language->get('error_product');
		}
		
		if (!$this->request->post['author']) {
			$this->error['author'] = $this->language->get('error_author');
		}

		if (!$this->request->post['text']) {
			$this->error['text'] = $this->language->get('error_text');
		}
		
		if (!$this->request->post['rating']) {
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