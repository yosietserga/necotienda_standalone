<?php 
/**
 * ControllerContentPostCategory
 * 
 * @package  NecoTienda powered by Opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.1.0
 * @access public
 * @see Controller
 */
class ControllerContentPostCategory extends Controller { 
	private $error = array();
 
	/**
	 * ControllerContentPostCategory::index()
	 * 
	 * @return void
	 */
	public function index() {
		$this->document->title = $this->language->get('heading_title');
        $this->getList();
	}

	/**
	 * ControllerContentPostCategory::insert()
	 * 
     * @see Load
     * @see Model
     * @see Request
     * @see Document
     * @see Session
     * @see Redirect
     * @see getForm
	 * @return void
	 */
	public function insert() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            
            foreach ($this->request->post['category_description'] as $language_id => $description) {
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
                $this->request->post['category_description'][$language_id] = $description;
            }
              
			$category_id = $this->modelPost_category->addCategory($this->request->post);

			$this->session->set('success',$this->language->get('text_success'));
			
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('content/post_category/update',array('category_id'=>$category_id))); 
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('content/post_category/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('content/post_category')); 
            }
		}
		$this->getForm();
	}

	/**
	 * ControllerContentPostCategory::update()
	 * 
     * @see Load
     * @see Model
     * @see Request
     * @see Document
     * @see Session
     * @see Redirect
     * @see getForm
	 * @return void
	 */
	public function update() {
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            
            foreach ($this->request->post['category_description'] as $language_id => $description) {
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
                $this->request->post['category_description'][$language_id] = $description;
            }
              
			$this->modelPost_category->editCategory($this->request->get['category_id'], $this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));
			
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('content/post_category/update',array('category_id'=>$this->request->get['category_id']))); 
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('content/post_category/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('content/post_category')); 
            }
		}
		$this->getForm();
	}

	/**
	 * ControllerContentPostCategory::delete()
	 * 
     * @see Load
     * @see Model
     * @see Request
     * @see Document
     * @see Session
     * @see Redirect
     * @see getList
	 * @return void
	 */
	public function delete() {
		$this->document->title = $this->language->get('heading_title');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $category_id) {
				$this->modelPost_category->deleteCategory($category_id);
			}

			$this->session->set('success',$this->language->get('text_success'));

			$this->redirect(Url::createAdminUrl('content/post_category'));
		}

		$this->getList();
	}

	/**
	 * ControllerContentPostCategory::getList()
	 * 
     * @see Load
     * @see Model
     * @see Document
     * @see Session
     * @see Language
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
       		'href'      => Url::createAdminUrl("content/post_category"),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
           //TODO: crear funci�n para generar urls absolutas a partir de un controller						
		$this->data['insert'] = Url::createAdminUrl("content/post_category/insert");
		$this->data['delete'] = Url::createAdminUrl("content/post_category/delete");
        
		
		$this->data['heading_title']      = $this->language->get('heading_title');
		$this->data['button_insert']      = $this->language->get('button_insert');
		$this->data['button_delete']      = $this->language->get('button_delete');
        
        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_warning'] = $this->session->has('success') ? $this->session->get('success') : '';
        $this->session->clear('success');
        
        
        // SCRIPTS
        $scripts[] = array('id'=>'categoryList','method'=>'function','script'=>
            "function activate(e) {
            	$.ajax({
            	   'type':'get',
                   'dataType':'json',
                   'url':'". Url::createAdminUrl("content/post_category/activate") ."&id=' + e,
                   'success': function(data) {
                        if (data > 0) {
                            $('#img_' + e).attr('src','image/good.png');
                        } else {
                            $('#img_' + e).attr('src','image/minus.png');
                        }
                   }
            	});
            }
            function borrar() {
                $('#gridWrapper').html('<img src=\"image/nt_loader.gif\" alt=\"Cargando...\" />');
                
                $.post('". Url::createAdminUrl("content/post_category/delete") ."',$('#formGrid').serialize(),function(){
                    $('#gridWrapper').load('". Url::createAdminUrl("content/post_category/grid") ."');
                });
                
            } 
            function eliminar(e) {    
                if (confirm('�Desea eliminar este objeto?')) {
                	$.ajax({
                	   'type':'get',
                       'dataType':'json',
                       'url':'". Url::createAdminUrl("content/post_category/eliminar") ."&id=' + e,
                       'success': function(data) {
                            if (data > 0) {
                                $('li#' + e).remove();
                            } else {
                                alert('No se pudo eliminar el objeto, posiblemente tenga otros objetos relacionados');
                            }
                       }
                	});
                }
             }");
        $scripts[] = array('id'=>'sortable','method'=>'ready','script'=>
            "$('#gridWrapper').load('". Url::createAdminUrl("content/post_category/grid") ."',function(e){
                $('#gridPreloader').hide();
                $('ol.items').nestedSortable({
        			forcePlaceholderSize: true,
        			handle: 'div.item',
        			helper:	'clone',
        			items: 'li',
        			maxLevels: 3,
        			opacity: .6,
        			placeholder: 'placeholder',
        			revert: 250,
        			tabSize: 25,
        			tolerance: 'pointer',
        			toleranceElement: '> div.item',
                    update:  function (event, ui) {
                        var parent = ui.item.parents('li');
                        
                        if (parent.length > 0) {
                            parent_id = parent.attr('id');
                        } else {
                            parent_id = 0;
                        }
                        
                        $.getJSON('". Url::createAdminUrl("content/post_category/updateparent") ."',{'parent_id':parent_id,'category_id':ui.item.attr('id')},function(data){
                            if (data.error) {
                                $('#msg').fadeIn().append('<div class=\"message warning\"'+ data.msg +'</div>').delay(3600).fadeOut();
                            }
                        });
                        
                        var sorts = {}; 
                        var i = 0;
                        $('ol.items li').each(function(){
                            i++;
                            sorts[i] = $(this).attr('id');
                        }); 
                        
                        $.post('". Url::createAdminUrl("content/post_category/sortable") ."',sorts,
                        function(data){
                            if (data.error) {
                                $('#msg').fadeIn().append('<div class=\"message warning\"'+ data.msg +'</div>').delay(3600).fadeOut();
                            }
                        });
                    }
        		});
            });
            $('#formFilter').ntForm({
                lockButton:false,
                ajax:true,
                type:'get',
                dataType:'html',
                url:'". Url::createAdminUrl("content/post_category/grid") ."',
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
        
        
		$this->template = 'content/post_category_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
        
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));  
	}
    
    public function updateparent() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        
        if (empty($_GET['category_id']) && !isset($_GET['parent_id'])) {
            $data['error'] = 1;
            $data['msg'] = "No se encontr&oacute; la categor&iacute;a que se va a actualizar";
        } 
        $result = $this->db->query("UPDATE ". DB_PREFIX ."category SET parent_id = ". (int)$_GET['parent_id'] ." WHERE category_id = ". (int)$_GET['category_id']);
        if ($result) {
            $data['success'] = 1;
        } else {
            $data['error'] = 1;
            $data['msg'] = "No se pudo actualizar la catego&iacute;a, por favor reporte esta falla a trav&eacute;s del formulario de sugerencias";
        }
        $this->load->auto('json');
		$this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));  
    }
    
	/**
	 * ControllerContentPostCategory::grid()
	 * 
     * @see Load
     * @see Model
     * @see Document
     * @see Session
     * @see Language
     * @see Response
	 * @return void
	 */
	public function grid() {
		$url = '';
				
       if (!empty($this->request->get['page'])) {
			$page = $this->request->get['page'];
			$url .= '&page=' . $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (!empty($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
			$url .= '&sort=' . $this->request->get['sort'];
		} else {
			$sort = 'cd.name';
		}
		
		if (!empty($this->request->get['order'])) {
			$order = $this->request->get['order'];
			$url .= '&order=' . $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (!empty($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (!empty($this->request->get['filter_post'])) {
			$filter_post = $this->request->get['filter_post'];
			$url .= '&filter_post=' . $this->request->get['filter_post'];
		} else {
			$filter_post = null;
		}

		if (!empty($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = null;
		}
		
		if (!empty($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = null;
		}
		
		if (!empty($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
			$url .= '&limit=' . $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_admin_limit');
		}
		
        $limit = ($_GET['limit']) ? $_GET['limit'] : $this->config->get('config_admin_limit');
        
		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_post'	  => $filter_post,
			'filter_date_start'   => $filter_date_start,
			'filter_date_end'   => $filter_date_end,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $limit,
			'limit'           => $limit
		);
        
		$this->data['categories'] = array();
        $this->data['categories'] = $this->getCategories(0,$data);
        
		$this->data['text_no_results']    = $this->language->get('text_no_results');
		$this->data['column_name']        = $this->language->get('column_name');
		$this->data['column_sort_order']  = $this->language->get('column_sort_order');
		$this->data['column_action']      = $this->language->get('column_action');
        
        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_warning'] = $this->session->has('success') ? $this->session->get('success') : '';
        $this->session->clear('success');
        $this->data['Url'] = Url;
		$this->template = 'content/post_category_grid.tpl';
        
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));  
	}

     protected function getCategories($parent_id=0,$data=array()) {
	    $output = '';
        $rows = $this->modelPost_category->getAllForList($parent_id,$data);
        
        if ($rows) {
            $output .= ($parent_id==0) ? '<ol class="items">' : '<ol>';
    		foreach ($rows as $result) {
                $output .= '<li id="'. $result['category_id'] .'">';
                $output .= '<div class="item">';
                $output .= '<input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="'. $result['category_id'] .'">';
                $output .= '<b class="name">'. $result['name'] .'</b>';
                
                $_img = ((int)$result['status'] == 1) ? 'good.png' : 'minus.png';
                
                $output .= '<div class="actions">';
                /*
                $output .= '<a title="'. $this->language->get('text_see') .'" href="'. Url::createAdminUrl("content/post_category/see",array('category_id'=>$result['category_id'])) .'">';
                $output .= '<img src="image/report.png" alt="'. $this->language->get('text_see') .'" />';
                $output .= '</a>';
                */
                $output .= '<a title="'. $this->language->get('text_edit') .'" href="'. Url::createAdminUrl("content/post_category/update",array('category_id'=>$result['category_id'])) .'">';
                $output .= '<img src="image/edit.png" alt="'. $this->language->get('text_edit') .'" />';
                $output .= '</a>';
                
                $output .= '<a title="'. $this->language->get('text_activate') .'" onclick="activate('. $result['category_id'] .')">';
                $output .= '<img id="img_'. $result['category_id'] .'" src="image/'. $_img .'" alt="'. $this->language->get('text_activate') .'" />';
                $output .= '</a>';
               
                $output .= '<a title="'. $this->language->get('text_delete') .'" onclick="eliminar('. $result['category_id'] .')">';
                $output .= '<img src="image/delete.png" alt="'. $this->language->get('text_delete') .'" />';
                $output .= '</a>';
               /*
                $output .= '<a title="'. $this->language->get('text_copy') .'" onclick="copy('. $result['category_id'] .')">';
                $output .= '<img src="image/copy.png" alt="'. $this->language->get('text_copy') .'" />';
                $output .= '</a>';
               */
                $output .= '</div>';
                
                $output .= '</div>';
                
                // subcategories
                $childrens = $this->modelPost_category->getAllForList($result['category_id'],$data);
    			if ($childrens) {
                    $output .= $this->getCategories($result['category_id'],$data);
    			}
                
                $output .= '</li>';
            }
            $output .= '</ol>';
        }	
        return $output;
	}
	
	/**
	 * ControllerContentPostCategory::getForm()
	 * 
     * @see Load
     * @see Model
     * @see Document
     * @see Session
     * @see Language
     * @see Response
	 * @return void
	 */
	private function getForm() {
		$this->data['heading_title']      = $this->language->get('heading_title');
		$this->data['text_none']          = $this->language->get('text_none');
		$this->data['text_default']       = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_enabled']       = $this->language->get('text_enabled');
    	$this->data['text_disabled']      = $this->language->get('text_disabled');
		$this->data['entry_name']         = $this->language->get('entry_name');
		$this->data['entry_meta_keywords']= $this->language->get('entry_meta_keywords');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description']  = $this->language->get('entry_description');
		$this->data['entry_keyword']      = $this->language->get('entry_keyword');
		$this->data['entry_category']     = $this->language->get('entry_category');
		$this->data['entry_sort_order']   = $this->language->get('entry_sort_order');
		$this->data['entry_image']        = $this->language->get('entry_image');
		$this->data['entry_status']       = $this->language->get('entry_status');
		$this->data['help_name']          = $this->language->get('help_name');
		$this->data['help_meta_keywords'] = $this->language->get('help_meta_keywords');
		$this->data['help_meta_description'] = $this->language->get('help_meta_description');
		$this->data['help_description']   = $this->language->get('help_description');
		$this->data['help_keyword']       = $this->language->get('help_keyword');
		$this->data['help_category']      = $this->language->get('help_category');
		$this->data['help_sort_order']    = $this->language->get('help_sort_order');
		$this->data['help_image']         = $this->language->get('help_image');
		$this->data['help_status']        = $this->language->get('help_status');
		$this->data['button_save']        = $this->language->get('button_save');
		$this->data['button_save_and_new']= $this->language->get('button_save_and_new');
		$this->data['button_save_and_exit']= $this->language->get('button_save_and_exit');
		$this->data['button_save_and_keep']= $this->language->get('button_save_and_keep');
		$this->data['button_cancel']      = $this->language->get('button_cancel');
    	$this->data['tab_general']        = $this->language->get('tab_general');
    	$this->data['tab_data']           = $this->language->get('tab_data');
		
        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('content/post_category'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['category_id'])) {
			$this->data['action'] = Url::createAdminUrl('content/post_category/insert');
		} else {
			$this->data['action'] = Url::createAdminUrl('content/post_category/update',array('category_id'=>$this->request->get['category_id']));
		}
		
		$this->data['cancel'] = Url::createAdminUrl('content/post_category');

		if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$category_info = $this->modelPost_category->getCategory($this->request->get['category_id']);
    	}
		
		$this->data['languages'] = $this->modelLanguage->getLanguages();
        
		if (isset($this->request->post['category_description'])) {
			$this->data['category_description'] = $this->request->post['category_description'];
		} elseif (isset($category_info)) {
			$this->data['category_description'] = $this->modelPost_category->getCategoryDescriptions($this->request->get['category_id']);
		} else {
			$this->data['category_description'] = array();
		}

        $this->setvar('status',$category_info,1);
        $this->setvar('parent_id',$category_info,0);
        $this->setvar('keyword',$category_info,'');
        $this->setvar('image',$category_info);
        $this->setvar('sort_order',$category_info,0);
        
		$this->data['categories'] = $this->modelPost_category->getCategories(0);

		if (!empty($category_info['image']) && file_exists(DIR_IMAGE . $category_info['image'])) {
			$this->data['preview'] = NTImage::resizeAndSave($category_info['image'], 100, 100);
		} else {
			$this->data['preview'] = NTImage::resizeAndSave('no_image.jpg', 100, 100);
		}
        
        $this->data['Url'] = new Url;
        
        $scripts[] = array('id'=>'categoryForm','method'=>'ready','script'=>
            "$('#category_description_1_name').blur(function(e){
                $.getJSON('". Url::createAdminUrl('common/home/slug') ."',{ slug : $(this).val() },function(data){
                        $('#slug').val(data.slug);
                });
            });
            
            $('#addProductsWrapper').hide();
            
            $('#addProductsPanel').on('click',function(e){
                var products = $('#addProductsWrapper').find('.row');
                
                if (products.length == 0) {
                    $.getJSON('".Url::createAdminUrl("content/post_category/products")."',
                        {
                            'category_id':'".$this->request->getQuery('category_id')."'
                        }, function(data) {
                            
                            $('#addProductsWrapper').html('<div class=\"row\"><label for=\"q\" style=\"float:left\">Filtrar listado de productos:</label><input type=\"text\" value=\"\" name=\"q\" id=\"q\" /></div><div class=\"clear\"></div><br /><ul id=\"addProducts\">');
                            
                            $.each(data, function(i,item){
                                $('#addProducts').append('<li><img src=\"' + item.pimage + '\" alt=\"' + item.pname + '\" /><b class=\"' + item.class + '\">' + item.pname + '</b><input type=\"hidden\" name=\"Products[' + item.product_id + ']\" value=\"' + item.value + '\" /></li>');
                                
                            });
                            
                            $('#q').liveUpdate('#addProducts').focus();
                            
                            $('li').on('click',function() {
                                var b = $(this).find('b');
                                if (b.hasClass('added')) {
                                    b.removeClass('added').addClass('add');
                                    $(this).find('input').val(0);
                                } else {
                                    b.removeClass('add').addClass('added');
                                    $(this).find('input').val(1);
                                }
                            });
                    });
                }
            });
                
            $('#addProductsPanel').on('click',function(){ $('#addProductsWrapper').slideToggle() });
            
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
            
            $('#form').ntForm({lockButton:false});
            $('textarea').ntTextArea();
            
            confirmExitIfModified(document.getElementById('form'), 'You have unsaved changes.');

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
            $scripts[] = array('id'=>'categoryLanguage$language["language_id"]','method'=>'ready','script'=>
                "CKEDITOR.replace('description". $language["language_id"] ."', {
                	filebrowserBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserImageBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserFlashBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserUploadUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserImageUploadUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserFlashUploadUrl: '". Url::createAdminUrl("common/filemanager") ."'
                });");
        }
        
        $scripts[] = array('id'=>'categoryFunctions','method'=>'function','script'=>
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
            
            function image_upload(field, preview) {
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
            		width: 700,
            		height: 400,
            		resizable: false,
            		modal: false
            	});}");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
        // javascript files
        $jspath = defined("CDN_JS") ? CDN_JS : HTTP_JS;
        
        $javascripts[] = "js/vendor/ckeditor/ckeditor.js";
        
        $this->javascripts = array_merge($javascripts,$this->javascripts);
        
        /* feedback form values */
        $this->data['domain'] = HTTP_HOME;
        $this->data['account_id'] = C_CODE;
        $this->data['local_ip'] = $_SERVER['SERVER_ADDR'];
        $this->data['remote_ip'] = $_SERVER['REMOTE_ADDR'];
        $this->data['server'] = serialize($_SERVER); //TODO: encriptar todos estos datos con una llave que solo yo poseo
        
        
		$this->template = 'content/post_category_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	/**
	 * ControllerContentPostCategory::validateForm()
	 * 
     * @see User
     * @see Request
     * @see Language
	 * @return bool
	 */
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'content/post_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
        //TODO: agregar funciones de validaci�n propias

		foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name']))> 32)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
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
	 * ControllerContentPostCategory::validateDelete()
	 * 
     * @see User
     * @see Language
	 * @return bool
	 */
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'content/post_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
        //TODO: agregar funciones de validaci�n propias
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
    
    /**
     * ControllerContentPostCategory::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('content/post_category');
        $status = $this->modelPost_category->getCategory($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelPost_category->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelPost_category->desactivate($_GET['id']);
                echo -1;
            }
            
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerContentPostCategory::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function eliminar() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('content/post_category');
        $result = $this->modelPost_category->getCategory($_GET['id']);
        if ($result) {
            $this->modelPost_category->deleteCategory($_GET['id']);
            echo 1;
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerContentPostCategory::sortable()
     * ordenar el listado actualizando la posici�n de cada objeto
     * @return boolean
     * */
     public function sortable() {
        $this->load->auto('content/post_category');
        $result = $this->modelPost_category->sortCategory($_POST);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
     }
     
     public function products() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        
        if ($this->request->hasQuery('category_id')) {
            $rows = $this->modelProduct->getProductsByCategoryId($this->request->getQuery('category_id'));
            $products_by_category = array();
            foreach ($rows as $row) {
                $products_by_category[] = $row['product_id'];
            }
        }
        $cache = $this->cache->get("products.for.category.form");
        if ($cache) {
            $products = unserialize($cache);
        } else {
            $model = $this->modelProduct->getAll();
            $products = $model->obj;
            $this->cache->set("products.for.category.form",serialize($products));
        }
        
        $this->data['Image'] = new NTImage();
        $this->data['Url'] = new Url;
        
        $output = array();
        
        foreach ($products as $product) {
            if (!empty($products_by_category) && in_array($product->product_id,$products_by_category)) {
                $output[] = array(
                    'product_id'=>$product->product_id,
                    'pimage'    =>NTImage::resizeAndSave($product->pimage,50,50),
                    'pname'     =>$product->pname,
                    'class'     =>'added',
                    'value'     =>1
                );
            } else {
                $output[] = array(
                    'product_id'=>$product->product_id,
                    'pimage'    =>NTImage::resizeAndSave($product->pimage,50,50),
                    'pname'     =>$product->pname,
                    'class'     =>'add',
                    'value'     =>0
                );
            }
        }
        $this->load->auto('json');
        $this->response->setOutput(Json::encode($output), $this->config->get('config_compression'));
            
     }
     
}