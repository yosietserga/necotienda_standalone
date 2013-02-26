<?php 
/**
 * ControllerContentSlider
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerContentSlider extends Controller {
	private $error = array(); 
     
  	/**
  	 * ControllerContentSlider::index()
     * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see getList
  	 * @return void
  	 */
  	public function index() {
		$this->load->language('content/slider');
		$this->document->title = $this->language->get('heading_title'); 
		$this->getList();
  	}
  
  	/**
  	 * ControllerContentSlider::insert()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see getForm
  	 * @return void
  	 */
  	public function insert() {
    	$this->load->language('content/slider');

    	$this->document->title = $this->language->get('heading_title'); 
		
		$this->load->model('content/slider');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$slider_id = $this->modelSlider->add($this->request->post);
            if ($slider_id) {            
    			$this->session->data['success'] = $this->language->get('text_success');
    	  
                if ($_POST['to'] == "saveAndKeep") {
                    $this->redirect(Url::createAdminUrl('content/slider/update',array('id'=>$slider_id))); 
                } elseif ($_POST['to'] == "saveAndNew") {
                    $this->redirect(Url::createAdminUrl('content/slider/insert')); 
                } else {
                    $this->redirect(Url::createAdminUrl('content/slider')); 
                }
            }
	  		
    	}
	
    	$this->getForm();
  	}

  	/**
  	 * ControllerContentSlider::update()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see getForm
  	 * @return void
  	 */
  	public function update() {
    	$this->load->language('content/slider');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('content/slider');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelSlider->edit($this->request->get['id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
                if ($_POST['to'] == "saveAndKeep") {
                    $this->redirect(Url::createAdminUrl('content/slider/update',array('id'=>$this->request->get['id']))); 
                } elseif ($_POST['to'] == "saveAndNew") {
                    $this->redirect(Url::createAdminUrl('content/slider/insert')); 
                } else {
                    $this->redirect(Url::createAdminUrl('content/slider')); 
                }
		}

    	$this->getForm();
  	}

  	/**
  	 * ControllerContentSlider::delete()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see getList
  	 * @return void
  	 */
  	public function delete() {
    	$this->load->language('content/slider');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('content/slider');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->modelSlider->delete($id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . $this->request->get['filter_title'];
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
			
			$this->redirect(Url::createAdminUrl("content/slider") . $url);
		}

    	$this->getList();
  	}

  	/**
  	 * ControllerContentSlider::getList()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see Session
  	 * @see Response
  	 * @return void
  	 */
  	private function getList() {
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl("common/home"),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl("content/slider") . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = Url::createAdminUrl("content/slider/insert") . $url;
    	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_insert'] = $this->language->get('button_insert');
 
 		$this->data['Url'] = new Url;
		
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

        // SCRIPTS
        $scripts[] = array('id'=>'sliderList','method'=>'function','script'=>
            "function activate(e) {
                $.getJSON('". Url::createAdminUrl("content/slider/activate") ."',{
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
                $.post('". Url::createAdminUrl("content/slider/delete") ."',$('#formGrid').serialize(),function(){
                    $('#gridWrapper').load('". Url::createAdminUrl("content/slider/grid") ."');
                });
            } 
            function eliminar(e) {
                if (confirm('¿Desea eliminar este objeto?')) {
                $('#tr_' + e).hide();
                	$.getJSON('". Url::createAdminUrl("content/slider/eliminar") ."',{
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
            "$('#gridWrapper').load('". Url::createAdminUrl("content/slider/grid") ."',function(e){
                $('#gridPreloader').hide();
                $('#list tbody').sortable({
                    opacity: 0.6, 
                    cursor: 'move',
                    handle: '.move',
                    update: function() {
                        $.ajax({
                            'type':'post',
                            'dateType':'json',
                            'url':'". Url::createAdminUrl("content/slider/sortable") ."',
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
                url:'". Url::createAdminUrl("content/slider/grid") ."',
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
        
		$this->template = 'content/slider_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
  	public function grid() {	
		$filter_title = isset($this->request->get['filter_title']) ? $this->request->get['filter_title'] : null;
		$filter_parent = isset($this->request->get['filter_parent']) ? $this->request->get['filter_parent'] : null;
		$filter_status = isset($this->request->get['filter_status']) ? $this->request->get['filter_status'] : null;
		$filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
		$filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'title';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
		
		$url = '';
			
		if (isset($this->request->get['filter_title'])) { $url .= '&filter_title=' . $this->request->get['filter_title']; } 
		if (isset($this->request->get['filter_parent'])) { $url .= '&filter_parent=' . $this->request->get['filter_parent']; } 
		if (isset($this->request->get['filter_status'])) { $url .= '&filter_status=' . $this->request->get['filter_status']; } 
		if (isset($this->request->get['filter_date_start'])) { $url .= '&filter_date_start=' . $this->request->get['filter_date_start']; }
		if (isset($this->request->get['filter_date_end'])) { $url .= '&filter_date_end=' . $this->request->get['filter_date_end']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; } 
			
		$this->data['sliders'] = array();

		$data = array(
			'filter_title'	  => $filter_title, 
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $limit
		);
		
		$slider_total = $this->modelSlider->getTotal($data);
		$results = $this->modelSlider->getAll($data);
				    	
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
                        'href'  => Url::createAdminUrl("content/slider/update") . '&id=' . $result['slider_id'] . $url,
                        'img'   => 'edit.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = NTImage::resizeAndSave($result['image'], 100, 100);
			} else {
				$image = NTImage::resizeAndSave('no_image.jpg', 100, 100);
			}
			
      		$this->data['sliders'][] = array(
				'slider_id' => $result['slider_id'],
				'title'       => $result['title'],
				'description'      => $result['description'],                
				'image' => $image,
				'link'       => $result['meta_description'],
				'date_added'      => $result['date_added'],         
				'sort_order'  => $result['sort_order'],  
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
        
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}
				
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_title'] = Url::createAdminUrl("content/slider/grid") . '&sort=title' . $url;
		$this->data['sort_quantity'] = Url::createAdminUrl("content/slider/grid") . '&sort=p.quantity' . $url;
		$this->data['sort_order'] = Url::createAdminUrl("content/slider/grid") . '&sort=p.sort_order' . $url;
		
		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $slider_total;
		$pagination->ajax = true;
		$pagination->ajaxTarget = "gridWrapper";
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl("content/slider/grid") . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_title'] = $filter_title;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'content/slider_grid.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}

  	/**
  	 * ControllerContentSlider::getForm()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see Session
  	 * @see Response
  	 * @return void
  	 */
  	private function getForm() {
    	$this->data['heading_title']   = $this->language->get('heading_title');
 
    	$this->data['text_enabled']    = $this->language->get('text_enabled');
    	$this->data['text_disabled']   = $this->language->get('text_disabled');
    	$this->data['text_none']       = $this->language->get('text_none');
    	$this->data['text_yes']        = $this->language->get('text_yes');
    	$this->data['text_no']         = $this->language->get('text_no');
		$this->data['text_default']    = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		
		$this->data['entry_title']     = $this->language->get('entry_title');
		$this->data['entry_link']      = $this->language->get('entry_link');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
    	$this->data['entry_status']    = $this->language->get('entry_status');
    	$this->data['entry_image']     = $this->language->get('entry_image');
    	$this->data['entry_date_publish']= $this->language->get('entry_date_publish');
		
		$this->data['help_title']      = $this->language->get('help_title');
		$this->data['help_description']= $this->language->get('help_description');
    	$this->data['help_status']     = $this->language->get('help_status');
    	$this->data['help_image']      = $this->language->get('help_image');
		$this->data['help_store'] = $this->language->get('help_store');
    	$this->data['help_date_publish']= $this->language->get('help_date_publish');
		$this->data['help_sort_order'] = $this->language->get('help_sort_order');
		$this->data['button_save_and_new']= $this->language->get('button_save_and_new');
		$this->data['button_save_and_exit']= $this->language->get('button_save_and_exit');
		$this->data['button_save_and_keep']= $this->language->get('button_save_and_keep');
    	$this->data['button_cancel']   = $this->language->get('button_cancel');
		
    	$this->data['tab_general']     = $this->language->get('tab_general');
        
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
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
       		'href'      => Url::createAdminUrl("common/home"),
       		'text'      => $this->language->get('text_home'),
			'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl("content/slider") . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['id'])) {
			$this->data['action'] = Url::createAdminUrl("content/slider/insert") . $url;
		} else {
			$this->data['action'] = Url::createAdminUrl("content/slider/update") . '&id=' . $this->request->get['id'] . $url;
		}
		
		$this->data['cancel'] = Url::createAdminUrl("content/slider") . $url;

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$slider_info = $this->modelSlider->getById($this->request->get['id']);
    	}

		if (isset($this->request->post['slider_description'])) {
			$this->data['slider_description'] = $this->request->post['slider_description'];
		} elseif (isset($slider_info)) {
			$this->data['slider_description'] = $this->modelSlider->getDescriptions($this->request->get['id']);
		} else {
			$this->data['slider_description'] = array();
		}
		
		$this->data['stores'] = $this->modelStore->getStores();
		
		if (isset($this->request->post['slider_store'])) {
			$this->data['slider_store'] = $this->request->post['slider_store'];
		} elseif (isset($slider_info)) {
			$this->data['slider_store'] = $this->modelSlider->getStores($this->request->get['id']);
		} else {
			$this->data['slider_store'] = array(0);
		}	
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($slider_info)) {
			$this->data['image'] = $slider_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		if (isset($this->request->post['link'])) {
			$this->data['link'] = $this->request->post['link'];
		} elseif (isset($slider_info)) {
			$this->data['link'] = $slider_info['link'];
		} else {
			$this->data['link'] = '';
		}
		
		if (isset($this->request->post['date_publish_start'])) {
			$this->data['date_publish_start'] = $this->request->post['date_publish_start'];
		} elseif (isset($slider_info['date_publish_start'])) {
			$this->data['date_publish_start'] = date('d/m/Y',strtotime($slider_info['date_publish_start']));
		} else {
			$this->data['date_publish_start'] = date('d/m/Y');
		}
		
		if (isset($this->request->post['date_publish_end'])) {
			$this->data['date_publish_end'] = $this->request->post['date_publish_end'];
		} elseif (isset($slider_info['date_publish_end'])) {
			$this->data['date_publish_end'] = date('d/m/Y',strtotime($slider_info['date_publish_end']));
		} else {
			$this->data['date_publish_end'] = date('d/m') . "/" . (date('Y')+1);
		}
		
		if (isset($slider_info) && $slider_info['image'] && file_exists(DIR_IMAGE . $slider_info['image'])) {
			$this->data['preview'] = NTImage::resizeAndSave($slider_info['image'], 100, 100);
		} else {
			$this->data['preview'] = NTImage::resizeAndSave('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (isset($slider_info)) {
      		$this->data['sort_order'] = $slider_info['sort_order'];
    	} else {
			$this->data['sort_order'] = 1;
		}

    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} else if (isset($slider_info)) {
			$this->data['status'] = $slider_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
        
        $products = $this->cache->get("banner.products");
        if (!$products) {
            foreach ($this->modelProduct->getProducts() as $product) {
                
    			if ($product['image'] && file_exists(DIR_IMAGE . $product['image'])) {
    				$image = NTImage::resizeAndSave($product['image'], 40, 40);
    			} else {
    				$image = NTImage::resizeAndSave('no_image.jpg', 40, 40);
    			}
    			
                
                $this->data['products'][] = array(
                    'product_id'=>$product['product_id'],
                    'href' =>$this->model_tool_seo_url->rewrite(HTTP_CATALOG.'index.php?r=store/product&product_id='.$product['product_id']),
                    'image'=>$image,
                    'name' =>$product['name']
                );
                $this->cache->set("banner.products",serialize($this->data['products']));
            }
        } else {
            $this->data['products'] = unserialize($products);
        }
        
        $categories = $this->cache->get("banner.categories");
        if (!$categories) {
            foreach ($this->modelCategory->getCategories(0) as $category) {
                $this->data['categories'][] = array(
                    'category_id'=>$category['category_id'],
                    'href' =>$this->model_tool_seo_url->rewrite(HTTP_CATALOG.'index.php?r=store/category&path='.$category['category_id']),
                    'name' =>$category['name']
                );
                $this->cache->set("banner.categories",serialize($this->data['categories']));
            }
        } else {
            $this->data['categories'] = unserialize($categories);
        }
        
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

        $scripts[] = array('id'=>'sliderForm','method'=>'ready','script'=>
            "$('#form').ntForm({
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
            
            $('#products tr,#categories tr').css({'cursor':'pointer'});
            $('#products tr,#categories tr').hover(function() {
                $(this).css({'fontWeight':'bold'});
            },
            function() {
                $(this).css({'fontWeight':'normal'});
            });
            
            $('.tabs li').on('click',function() {
                $('.tabs li').each(function(){
                   $('#' + this.id + '_content').hide();
                   $(this).removeClass('active'); 
                });
                $(this).addClass('active');
                $('#' + this.id + '_content').show(); 
           }); 
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
            
        $scripts[] = array('id'=>'sliderFunctions','method'=>'function','script'=>
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
            function setLink(link) {
                $('input[name=link]').val(link);
                $('#products').dialog('close');
                $('#categories').dialog('close');
            }
            function showProducts() {
                $('#products').dialog({
            		width: 700,
            		height: 350
                });
            }
            function showCategories() {
                $('#categories').dialog({
            		width: 700,
            		height: 350
                });
            }
            
            function image_delete(field, preview) {
                $('#' + field).val('');
                $('#' + preview).attr('src','". HTTP_IMAGE ."cache/no_image-100x100.jpg');
            }
            
            function image_upload(field, preview) {
                var height = $(window).height() * 0.8;
                var width = $(window).width() * 0.8;
                
            	$('#dialog').remove();
            	$('.box').prepend('<div id=\"dialog\" style=\"padding: 3px 0px 0px 0px;\"><iframe src=\"". Url::createAdminUrl("common/filemanager") ."&field=' + encodeURIComponent(field) + '\" style=\"padding:0; margin: 0; display: block; width: 100%; height: 100%;\" frameborder=\"no\" scrolling=\"auto\"></iframe></div>');
                
                $('#dialog').dialog({
            		title: '".$this->data['text_image_manager']."',
            		close: function (event, ui) {
            			if ($('#' + field).attr('value')) {
            				$.ajax({
            					url: '". Url::createAdminUrl("common/filemanager/image") ."',
            					type: 'POST',
            					data: 'image=' + encodeURIComponent($('#' + field).val()),
            					dataType: 'text',
            					success: function(data) {
            						$('#' + preview).replaceWith('<img src=\"' + data + '\" id=\"' + preview + '\" class=\"image\" onclick=\"image_upload(\'' + field + '\', \'' + preview + '\');\">');
            					}
            				});
            			}
            		},	
            		bgiframe: false,
            		width: width,
            		height: height,
            		resizable: false,
            		modal: false
            	});}");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'content/slider_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	} 
	
  	/**
  	 * ControllerContentSlider::validateForm()
  	 * 
     * @see User
     * @see Language
     * @see Request
  	 * @return bool
  	 */
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'content/slider')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
        
    	if (!$this->error) {
			return true;
    	} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
      		return false;
    	}
  	}
	
  	/**
  	 * ControllerContentSlider::validateDelete()
  	 * 
     * @see User
     * @see Language
     * @see Request
  	 * @return bool
  	 */
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'content/slider')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
        //TODO: colocar validaciones propias
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
    
    /**
     * ControllerContentCategory::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->model('content/slider');
        $status = $this->modelSlider->getById($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelSlider->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelSlider->desactivate($_GET['id']);
                echo -1;
            }
            
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerContentCategory::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function eliminar() {
        if (!isset($_GET['id'])) return 0;
        $this->load->model('content/slider');
        $result = $this->modelSlider->getById($_GET['id']);
        if ($result) {
            $this->modelSlider->delete($_GET['id']);
            echo 1;
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerContentCategory::sortable()
     * ordenar el listado actualizando la posición de cada objeto
     * @return boolean
     * */
     public function sortable() {
        if (!isset($_POST['tr'])) return false;
        $this->load->model('content/slider');
        $result = $this->modelSlider->sortSlider($_POST['tr']);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
     }
}
?>