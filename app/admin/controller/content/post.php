<?php
/**
 * ControllerContentPost
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerContentPost extends Controller { 
	private $error = array();

	/**
	 * ControllerContentPost::index()
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
	 * ControllerContentPost::insert()
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
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            
            foreach ($this->request->post['post_description'] as $language_id => $description) {
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
                $this->request->post['post_description'][$language_id] = $description;
            }
              
			$this->modelPost->addPost($this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));

			$url = '';
			
			if (isset($this->request->get['post'])) {
				$url .= '&post=' . $this->request->get['post'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(Url::createAdminUrl('content/post') . $url);
		}

		$this->getForm();
	}

	/**
	 * ControllerContentPost::update()
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
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelPost->editPost($this->request->get['post_id'], $this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));

			$url = '';
			
			if (isset($this->request->get['post'])) {
				$url .= '&post=' . $this->request->get['post'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(Url::createAdminUrl('content/post') . $url);
		}

		$this->getForm();
	}
 
	/**
	 * ControllerContentPost::delete()
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
			foreach ($this->request->post['selected'] as $post_id) {
				$this->modelPost->deletePost($post_id);
			}
			
			$this->session->set('success',$this->language->get('text_success'));

			$url = '';
			
			if (isset($this->request->get['post'])) {
				$url .= '&post=' . $this->request->get['post'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(Url::createAdminUrl('content/post') . $url);
		}

		$this->getList();
	}

	/**
	 * ControllerContentPost::getList()
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
       		'href'      => Url::createAdminUrl('content/post') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = Url::createAdminUrl('content/post/insert') . $url;
		$this->data['delete'] = Url::createAdminUrl('content/post/delete') . $url;	

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
        $scripts[] = array('id'=>'postList','method'=>'function','script'=>
            "function activate(e) {
                $.getJSON('". Url::createAdminUrl("content/post/activate") ."',{
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
                $.post('". Url::createAdminUrl("content/post/delete") ."',$('#formGrid').serialize(),function(){
                    $('#gridWrapper').load('". Url::createAdminUrl("content/post/grid") ."');
                });
            } 
            function eliminar(e) {    
                $('#tr_' + e).hide();
                if (confirm('�Desea eliminar este objeto?')) {
                	$.getJSON('". Url::createAdminUrl("content/post/eliminar") ."',{
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
            "$('#gridWrapper').load('". Url::createAdminUrl("content/post/grid") ."',function(e){
                $('#gridPreloader').hide();
                $('#list tbody').sortable({
                    opacity: 0.6, 
                    cursor: 'move',
                    handle: '.move',
                    update: function() {
                        $.ajax({
                            'type':'post',
                            'dateType':'json',
                            'url':'". Url::createAdminUrl("content/post/sortable") ."',
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
                url:'". Url::createAdminUrl("content/post/grid") ."',
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
        
		$this->template = 'content/post_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	/**
	 * ControllerContentPost::grid()
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
		$filter_product = isset($this->request->get['filter_parent']) ? $this->request->get['filter_parent'] : null;
		$post = isset($this->request->get['post']) ? $this->request->get['post'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'title';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
		
		$url = '';
			
		if (isset($this->request->get['filter_title'])) { $url .= '&filter_title=' . $this->request->get['filter_title']; } 
		if (isset($this->request->get['filter_parent'])) { $url .= '&filter_parent=' . $this->request->get['filter_parent']; } 
		if (isset($this->request->get['post'])) { $url .= '&post=' . $this->request->get['post']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; } 

		$this->data['posts'] = array();

		$data = array(
			'filter_title'  => $filter_title,
			'filter_product'  => $filter_product,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($post - 1) * $this->config->get('config_admin_limit'),
			'limit' => $limit
		);
		
		$post_total = $this->modelPost->getTotalPosts();
	
		$results = $this->modelPost->getPosts($data);
 
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
                        'href'  =>Url::createAdminUrl('content/post/update') . '&post_id=' . $result['post_id'] . $url,
                        'img'   => 'edit.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );
				
			$this->data['posts'][] = array(
				'post_id'    => $result['post_id'],
				'title'      => $result['title'],
				'publish'    => $result['publish'],
				'date_publish_start'=> date('d-m-Y h:i',strtotime($result['date_publish_start'])),
				'date_publish_end'=> date('d-m-Y h:i',strtotime($result['date_publish_end'])),
				'sort_order' => $result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['post_id'], $this->request->post['selected']),
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

		if (isset($this->request->get['post'])) {
			$url .= '&post=' . $this->request->get['post'];
		}
		
		$this->data['sort_title'] = Url::createAdminUrl('content/post/grid') . '&sort=title' . $url;
		$this->data['sort_publish'] = Url::createAdminUrl('content/post/grid') . '&sort=publish' . $url;
		$this->data['sort_date_publish_start'] = Url::createAdminUrl('content/post/grid') . '&sort=date_publish_start' . $url;
		$this->data['sort_date_publish_end'] = Url::createAdminUrl('content/post/grid') . '&sort=date_publish_end' . $url;
		$this->data['sort_sort_order'] = Url::createAdminUrl('content/post/grid') . '&sort=pa.sort_order' . $url;
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $post_total;
		$pagination->post = $post;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('content/post/grid') . $url . '&post={post}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'content/post_grid.tpl';
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	/**
	 * ControllerContentPost::getForm()
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

		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		
		$this->data['help_title'] = $this->language->get('help_title');
		$this->data['help_description'] = $this->language->get('help_description');
		$this->data['help_keyword'] = $this->language->get('help_keyword');
		$this->data['help_sort_order'] = $this->language->get('help_sort_order');
		$this->data['help_status'] = $this->language->get('help_status');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->get('ukey');

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
		
	 	if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}
		
		$url = '';
			
		if (isset($this->request->get['post'])) {
			$url .= '&post=' . $this->request->get['post'];
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
       		'href'      => Url::createAdminUrl('content/post') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['post_id'])) {
			$this->data['action'] = Url::createAdminUrl('content/post/insert') . $url;
		} else {
			$this->data['action'] = Url::createAdminUrl('content/post/update') . '&post_id=' . $this->request->get['post_id'] . $url;
		}
		
		$this->data['cancel'] = Url::createAdminUrl('content/post') . $url;

		if (isset($this->request->get['post_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$post_info = $this->modelPost->getPost($this->request->get['post_id']);
		}
		$this->data['languages'] = $this->modelLanguage->getLanguages();
		
		if (isset($this->request->post['post_description'])) {
			$this->data['post_description'] = $this->request->post['post_description'];
		} elseif (isset($this->request->get['post_id'])) {
			$this->data['post_description'] = $this->modelPost->getPostDescriptions($this->request->get['post_id']);
		} else {
			$this->data['post_description'] = array();
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($post_info)) {
			$this->data['status'] = $post_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($post_info)) {
			$this->data['keyword'] = $post_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($post_info)) {
			$this->data['sort_order'] = $post_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		
		$this->template = 'content/post_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	/**
	 * ControllerContentPost::validateForm()
	 * 
	 * @see User
	 * @see Request
	 * @see Language
	 * @return bool
	 */
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'content/post')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['post_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['title'])) < 3) || (strlen(utf8_decode($value['title']))> 32)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		
			if (strlen(utf8_decode($value['description'])) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
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
	 * ControllerContentPost::validateDelete()
	 * 
	 * @see User
	 * @see Request
	 * @see Language
	 * @return bool
	 */
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'content/post')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		
		foreach ($this->request->post['selected'] as $post_id) {
			if ($this->config->get('config_account_id') == $post_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}
			
			if ($this->config->get('config_checkout_id') == $post_id) {
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
     * ControllerContentPost::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('content/post');
        $status = $this->modelPost->getPost($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelPost->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelPost->desactivate($_GET['id']);
                echo -1;
            }
            
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerContentPost::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function eliminar() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('content/post');
        $result = $this->modelPost->getPost($_GET['id']);
        if ($result) {
            $this->modelPost->deletePost($_GET['id']);
            echo 1;
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerContentPost::sortable()
     * ordenar el listado actualizando la posici�n de cada objeto
     * @return boolean
     * */
     public function sortable() {
        if (!isset($_POST['tr'])) return false;
        $this->load->auto('content/post');
        $result = $this->modelPost->sortPost($_POST['tr']);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
     }
}