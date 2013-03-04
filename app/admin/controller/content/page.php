<?php
/**
 * ControllerContentPage
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerContentPage extends Controller { 
	private $error = array();

	/**
	 * ControllerContentPage::index()
     * 
	 * @see Load
	 * @see Document
	 * @see Model
	 * @see getList
	 * @return void
	 */
	public function index() {
		$this->document->title = $this->language->get('heading_title');
		$this->getList();
	}

	/**
	 * ControllerContentPage::insert()
	 * 
	 * @see Load
	 * @see Document
	 * @see Model
	 * @see Request
	 * @see Session
	 * @see Redirect
	 * @see getForm
	 * @return void
	 */
	public function insert() {
		$this->document->title = $this->language->get('heading_title');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            //TODO: colocar validaciones
            foreach ($this->request->post['page_description'] as $language_id => $description) {
                $dom = new DOMDocument;
                $dom->preserveWhiteSpace = false;
                $dom->loadHTML(html_entity_decode($description['description']));
                $images = $dom->getElementsByTagName('img');
                foreach ($images as $image) {
                    $src = $image->getAttribute('src');
                    
                    if (preg_match('/data:([^;]*);base64,(.*)/',$src)) {
                        list($type,$img) = explode(",",$src);
                        $type = trim(substr($type,strpos($type,"/")+1,3));
                        
                        //TODO: validar imagenes
                        
                        $str = $this->config->get('config_name');
                        if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
                        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
                        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
                        $str = strtolower( trim($str, '-') );
                                
                        $filename = uniqid($str."-") . "_" . time() . "." . $type;
                        $fp = fopen( DIR_IMAGE . "data/" . $filename, 'wb' );
                        fwrite( $fp, base64_decode($img));
                        fclose( $fp );
                        $image->setAttribute('src', HTTP_IMAGE . "data/" . $filename);
                    }
                }
                $description['description'] = htmlentities($dom->saveHTML());
                $this->request->post['page_description'][$language_id] = $description;
            }
            
            if (empty($this->request->post['date_publish_end'])) {
                $this->request->post['date_publish_end'] = '0000-00-00 00:00:00';
            } else {
                $dpe = explode("/",$this->request->post['date_publish_end']);
                $this->request->post['date_publish_end'] = date('Y-m-d h:i:s',strtotime($dpe[2] ."-". $dpe[1] ."-". $dpe[0]));
            }
            
            $dps = explode("/",$this->request->post['date_publish_start']);
            $this->request->post['date_publish_start'] = date('Y-m-d h:i:s',strtotime($dps[2] ."-". $dps[1] ."-". $dps[0]));
            
			$post_id = $this->modelPage->addPage($this->request->post);
        
			
			$this->session->set('success',$this->language->get('text_success'));

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('content/page/update',array('post_id'=>$post_id))); 
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('content/page/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('content/page')); 
            }
		}

		$this->getForm();
	}

	/**
	 * ControllerContentPage::update()
	 * 
	 * @see Load
	 * @see Document
	 * @see Model
	 * @see Request
	 * @see Session
	 * @see Redirect
	 * @see getForm
	 * @return void
	 */
	public function update() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
            
            foreach ($this->request->post['page_description'] as $language_id => $description) {
                $dom = new DOMDocument;
                $dom->preserveWhiteSpace = false;
                $dom->loadHTML(html_entity_decode($description['description']));
                $images = $dom->getElementsByTagName('img');
                foreach ($images as $image) {
                    $src = $image->getAttribute('src');
                    
                    if (preg_match('/data:([^;]*);base64,(.*)/',$src)) {
                        list($type,$img) = explode(",",$src);
                        $type = trim(substr($type,strpos($type,"/")+1,3));
                        
                        //TODO: validar imagenes
                        
                        $str = $this->config->get('config_name');
                        if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
                        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
                        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
                        $str = strtolower( trim($str, '-') );
                                
                        $filename = uniqid($str."-") . "_" . time() . "." . $type;
                        $fp = fopen( DIR_IMAGE . "data/" . $filename, 'wb' );
                        fwrite( $fp, base64_decode($img));
                        fclose( $fp );
                        $image->setAttribute('src', HTTP_IMAGE . "data/" . $filename);
                    }
                }
                $description['description'] = htmlentities($dom->saveHTML());
                $this->request->post['page_description'][$language_id] = $description;
            }
              
            if (empty($this->request->post['date_publish_end'])) {
                $this->request->post['date_publish_end'] = '0000-00-00 00:00:00';
            } else {
                $dpe = explode("/",$this->request->post['date_publish_end']);
                $this->request->post['date_publish_end'] = date('Y-m-d h:i:s',strtotime($dpe[2] ."-". $dpe[1] ."-". $dpe[0]));
            }
            
            $dps = explode("/",$this->request->post['date_publish_start']);
            $this->request->post['date_publish_start'] = date('Y-m-d h:i:s',strtotime($dps[2] ."-". $dps[1] ."-". $dps[0]));
            
			$post_id = $this->modelPage->editPage($this->request->get['page_id'], $this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('content/page/update',array('post_id'=>$post_id))); 
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('content/page/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('content/page')); 
            }
		}

		$this->getForm();
	}
 
	/**
	 * ControllerContentPage::delete()
	 * 
	 * @see Load
	 * @see Document
	 * @see Model
	 * @see Request
	 * @see Session
	 * @see Redirect
	 * @see getList
	 * @return void
	 */
	public function delete() {
		$this->document->title = $this->language->get('heading_title');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $page_id) {
				$this->modelPage->deletePage($page_id);
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
			
			$this->redirect(Url::createAdminUrl('content/page') . $url);
		}

		$this->getList();
	}

	/**
	 * ControllerContentPage::getList()
	 * 
	 * @see Load
	 * @see Document
	 * @see Model
	 * @see Request
	 * @see Session
	 * @see Redirect
	 * @see Language
	 * @see Response
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
       		'href'      => Url::createAdminUrl('content/page') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = Url::createAdminUrl('content/page/insert') . $url;
		$this->data['delete'] = Url::createAdminUrl('content/page/delete') . $url;	

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
        $scripts[] = array('id'=>'pageList','method'=>'function','script'=>
            "function activate(e) {
                $.getJSON('". Url::createAdminUrl("content/page/activate") ."',{
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
                $.post('". Url::createAdminUrl("content/page/delete") ."',$('#formGrid').serialize(),function(){
                    $('#gridWrapper').load('". Url::createAdminUrl("content/page/grid") ."');
                });
            } 
            function eliminar(e) {
                if (confirm('¿Desea eliminar este objeto?')) {
                $('#tr_' + e).hide();
                	$.getJSON('". Url::createAdminUrl("content/page/eliminar") ."',{
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
            "$('#gridWrapper').load('". Url::createAdminUrl("content/page/grid") ."',function(e){
                $('#gridPreloader').hide();
                $('#list tbody').sortable({
                    opacity: 0.6, 
                    cursor: 'move',
                    handle: '.move',
                    update: function() {
                        $.ajax({
                            'type':'post',
                            'dateType':'json',
                            'url':'". Url::createAdminUrl("content/page/sortable") ."',
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
                url:'". Url::createAdminUrl("content/page/grid") ."',
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
        
		$this->template = 'content/page_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	/**
	 * ControllerContentPage::grid()
	 * 
	 * @see Load
	 * @see Document
	 * @see Model
	 * @see Request
	 * @see Session
	 * @see Redirect
	 * @see Language
	 * @see Response
	 * @return void
	 */
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

		$this->data['pages'] = array();

		$data = array(
			'filter_title'  => $filter_title,
			'filter_product'  => $filter_product,
			'filter_status'   => $filter_status,
			'filter_date_start'=> $filter_date_start,
			'filter_date_end' => $filter_date_end,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);
		
		$page_total = $this->modelPage->getTotalPages($data);
	
		$results = $this->modelPage->getPages($data);
 
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
                        'href'  =>Url::createAdminUrl('content/page/update') . '&page_id=' . $result['post_id'] . $url,
                        'img'   => 'edit.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );
				
			$this->data['pages'][] = array(
				'page_id'    => $result['post_id'],
				'title'      => $result['title'],
				'status'    => $result['status'],
				'date_publish_start'=> date('d-m-Y h:i',strtotime($result['date_publish_start'])),
				'date_publish_end'=> date('d-m-Y h:i',strtotime($result['date_publish_end'])),
				'sort_order' => $result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['page_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}	
	
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_publish'] = $this->language->get('column_publish');
		$this->data['column_date_publish_start'] = $this->language->get('column_date_publish_start');
		$this->data['column_date_publish_end'] = $this->language->get('column_date_publish_end');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_title'] = Url::createAdminUrl('content/page/grid') . '&sort=title' . $url;
		$this->data['sort_publish'] = Url::createAdminUrl('content/page/grid') . '&sort=publish' . $url;
		$this->data['sort_date_publish_start'] = Url::createAdminUrl('content/page/grid') . '&sort=date_publish_start' . $url;
		$this->data['sort_date_publish_end'] = Url::createAdminUrl('content/page/grid') . '&sort=date_publish_end' . $url;
		$this->data['sort_sort_order'] = Url::createAdminUrl('content/page/grid') . '&sort=pa.sort_order' . $url;
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->ajax = true;
		$pagination->ajaxTarget = "gridWrapper";
		$pagination->total = $page_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('content/page/grid') . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'content/page_grid.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	/**
	 * ControllerContentPage::getForm()
	 * 
	 * @see Load
	 * @see Document
	 * @see Model
	 * @see Request
	 * @see Session
	 * @see Redirect
	 * @see Language
	 * @see Response
	 * @see Pagination
	 * @return void
	 */
	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_seo_title'] = $this->language->get('entry_seo_title');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		
		$this->data['help_title'] = $this->language->get('help_title');
		$this->data['help_description'] = $this->language->get('help_description');
		$this->data['help_keyword'] = $this->language->get('help_keyword');
		$this->data['help_sort_order'] = $this->language->get('help_sort_order');
		$this->data['help_status'] = $this->language->get('help_status');
		
		$this->data['button_save_and_new']= $this->language->get('button_save_and_new');
		$this->data['button_save_and_exit']= $this->language->get('button_save_and_exit');
		$this->data['button_save_and_keep']= $this->language->get('button_save_and_keep');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_title'] = isset($this->error['title']) ? $this->error['title'] : '';
        $this->data['error_description'] = isset($this->error['description']) ? $this->error['description'] : '';

		$url = '';
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		
  		$this->document->breadcrumbs = array();
   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);
   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('content/page') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['page_id'])) {
			$this->data['action'] = Url::createAdminUrl('content/page/insert') . $url;
		} else {
			$this->data['action'] = Url::createAdminUrl('content/page/update') . '&page_id=' . $this->request->get['page_id'] . $url;
		}
		
		$this->data['cancel'] = Url::createAdminUrl('content/page') . $url;

		if (isset($this->request->get['page_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$page_info = $this->modelPage->getPage($this->request->get['page_id']);
		}
        
		$this->data['languages'] = $this->modelLanguage->getLanguages();
		$this->data['pages'] = $this->modelPage->getAll();
        
        $this->setvar('keyword',$page_info,'');
        
		if (isset($this->request->post['page_description'])) {
			$this->data['page_description'] = $this->request->post['page_description'];
		} elseif (isset($this->request->get['page_id'])) {
			$this->data['page_description'] = $this->modelPage->getPageDescriptions($this->request->get['page_id']);
		} else {
			$this->data['page_description'] = array();
		}

		if (isset($this->request->post['date_publish_start'])) {
			$this->data['date_publish_start'] = date('d-m-Y',strtotime($this->request->post['date_publish_start']));
		} elseif ($page_info) {
			$this->data['date_publish_start'] = date('d-m-Y',strtotime($page_info['date_publish_start']));
		} else {
			$this->data['date_publish_start'] = date('d-m-Y');
		}

		if (isset($this->request->post['date_publish_end'])) {
			$this->data['date_publish_end'] = date('d-m-Y',strtotime($this->request->post['date_publish_end']));
		} elseif ($page_info) {
			$this->data['date_publish_end'] = date('d-m-Y',strtotime($page_info['date_publish_end']));
		} else {
			$this->data['date_publish_end'] = '';
		}

        $scripts[] = array('id'=>'pageForm','method'=>'ready','script'=>
            "$('#page_description_1_title').blur(function(e){
                $.getJSON('". Url::createAdminUrl('common/home/slug') ."',{ slug : $(this).val() },function(data){
                        $('#slug').val(data.slug);
                });
            });
            
            $('.trends').fancybox({
        		maxWidth	: 640,
        		maxHeight	: 600,
        		fitToView	: false,
        		width		: '70%',
        		height		: '70%',
        		autoSize	: false,
        		closeClick	: false,
        		openEffect	: 'none',
        		closeEffect	: 'none'
        	});
            
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
            
        foreach ($this->data['languages'] as $language) {
            $scripts[] = array('id'=>'pageLanguage'.$language["language_id"],'method'=>'ready','script'=>
                "var editor". $language["language_id"] ." = CKEDITOR.replace('description". $language["language_id"] ."', {
                	filebrowserBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserImageBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserFlashBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserUploadUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserImageUploadUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserFlashUploadUrl: '". Url::createAdminUrl("common/filemanager") ."',
                    height:600
                });
                
                editor.products = '". $json['products'] ."';");
        }
        
        $scripts[] = array('id'=>'pageFunctions','method'=>'function','script'=>
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
        
        // javascript files
        $jspath = defined("CDN_JS") ? CDN_JS : HTTP_JS;
        
        $javascripts[] = "js/vendor/ckeditor/ckeditor.js";
        
        $this->javascripts = array_merge($javascripts,$this->javascripts);
        
		$this->template = 'content/page_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	/**
	 * ControllerContentPage::validateForm()
	 * 
	 * @see User
	 * @see Request
	 * @see Language
	 * @return bool
	 */
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'content/page')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['page_description'] as $language_id => $value) {
			if ($value['title']) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		  /*
			if (strlen(utf8_decode($value['description']))) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
            */
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
	 * ControllerContentPage::validateDelete()
	 * 
	 * @see User
	 * @see Request
	 * @see Language
	 * @return bool
	 */
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'content/page')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		
		foreach ($this->request->post['selected'] as $page_id) {
			if ($this->config->get('config_account_id') == $page_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}
			
			if ($this->config->get('config_checkout_id') == $page_id) {
				$this->error['warning'] = $this->language->get('error_checkout');
			}
			
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
    
    /**
     * ControllerContentPage::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('content/page');
        $status = $this->modelPage->getPage($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelPage->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelPage->desactivate($_GET['id']);
                echo -1;
            }
            
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerContentPage::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function eliminar() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('content/page');
        $result = $this->modelPage->getPage($_GET['id']);
        if ($result) {
            $this->modelPage->deletePage($_GET['id']);
            echo 1;
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerContentPage::sortable()
     * ordenar el listado actualizando la posición de cada objeto
     * @return boolean
     * */
     public function sortable() {
        if (!isset($_POST['tr'])) return false;
        $this->load->auto('content/page');
        $result = $this->modelPage->sortPage($_POST['tr']);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
     }
}