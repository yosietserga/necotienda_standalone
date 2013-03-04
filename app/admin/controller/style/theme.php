<?php
/**
 * ControllerStyleTheme
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerStyleTheme extends Controller { 
	private $error = array();
  
  	/**
  	 * ControllerStyleTheme::index()
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
  	 * ControllerStyleTheme::index()
     * 
  	 * @see Load
  	 * @see Document
  	 * @see Language
  	 * @see getList
  	 * @return void
  	 */
  	public function save() {
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $css = "";
            $data = array();
            foreach ($this->request->post['selectors'] as $selector => $properties) {
                $cssOutput = "";
                if (isset($properties['background']['background'])) {
                    $cssOutput .= $properties['background']['background'];
                    $data[$selector]['background'] = $properties['background']['background'];
                    $cssOutput .= $properties['background']['background'];
                } else {
                    foreach ($properties['background'] as $property => $value) {
                        if (empty($value)) continue;
                        if ($property=="image") $value = "url(" . $value .")";
                        if ($property=="attachment") $value = "fixed";
                        $cssOutput .= "background-". $property .":". $value .";";
                        $data[$selector]["background-". $property] = $value;
                    }
                }
                
                if ($cssOutput) {
                    $css .= "#". $selector ."{". $cssOutput ."}";
                }
                
            }
            
            file_put_contents(DIR_CSS."custom-". $this->request->getQuery('theme_id') ."-". $this->request->getQuery('template') .".css",$css);
            
            $this->modelTheme->saveStyle($this->request->getQuery('theme_id'),$data);
		}
  	}
  
  	/**
  	 * ControllerStyleTheme::insert()
  	 * 
  	 * @see Load
  	 * @see Document
  	 * @see Request
  	 * @see Session
  	 * @see Redirect
  	 * @see Language
  	 * @see getForm
  	 * @return void
  	 */
  	public function insert() {
    	$this->document->title = $this->language->get('heading_title');	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		  
            if (empty($this->request->post['date_publish_end'])) {
                $this->request->post['date_publish_end'] = '0000-00-00 00:00:00';
            } else {
                $dpe = explode("/",$this->request->post['date_publish_end']);
                $this->request->post['date_publish_end'] = date('Y-m-d h:i:s',strtotime($dpe[2] ."-". $dpe[1] ."-". $dpe[0]));
            }
            
            $dps = explode("/",$this->request->post['date_publish_start']);
            $this->request->post['date_publish_start'] = date('Y-m-d h:i:s',strtotime($dps[2] ."-". $dps[1] ."-". $dps[0]));
            
			$theme_id = $this->modelTheme->add($this->request->post);

			$this->session->set('success',$this->language->get('text_success'));
			
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('style/theme/update',array('theme_id'=>$theme_id))); 
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('style/theme/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('style/theme')); 
            }
		}
    
    	$this->getForm();
  	} 
   
  	/**
  	 * ControllerStyleTheme::update()
  	 * 
  	 * @see Load
  	 * @see Document
  	 * @see Request
  	 * @see Session
  	 * @see Redirect
  	 * @see Language
  	 * @see getForm
  	 * @return void
  	 */
  	public function update() {
    	$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
            if (empty($this->request->post['date_publish_end'])) {
                $this->request->post['date_publish_end'] = '0000-00-00 00:00:00';
            } else {
                $dpe = explode("/",$this->request->post['date_publish_end']);
                $this->request->post['date_publish_end'] = date('Y-m-d h:i:s',strtotime($dpe[2] ."-". $dpe[1] ."-". $dpe[0]));
            }
            
            $dps = explode("/",$this->request->post['date_publish_start']);
            $this->request->post['date_publish_start'] = date('Y-m-d h:i:s',strtotime($dps[2] ."-". $dps[1] ."-". $dps[0]));
            
            $theme_id = $this->modelTheme->update($this->request->get['theme_id'], $this->request->post);

			$this->session->set('success',$this->language->get('text_success'));
			
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('style/theme/update',array('theme_id'=>$theme_id))); 
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('style/theme/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('style/theme')); 
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
        $this->load->auto('style/theme');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelTheme->delete($id);
            }
		} else {
            $this->modelTheme->delete($_GET['id']);
		}
     }
    
  	/**
  	 * ControllerStyleTheme::getList()
  	 * 
  	 * @see Load
  	 * @see Document
  	 * @see Request
  	 * @see Session
  	 * @see Response
  	 * @see Pagination
  	 * @see Language
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
       		'href'      => Url::createAdminUrl('style/theme') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = Url::createAdminUrl('style/theme/insert') . $url;
		$this->data['delete'] = Url::createAdminUrl('style/theme/delete') . $url;	

		$this->data['heading_title']  = $this->language->get('heading_title');
		$this->data['button_insert']  = $this->language->get('button_insert');
		$this->data['button_import']  = $this->language->get('button_import');
		$this->data['button_delete']  = $this->language->get('button_delete');
 
 		$this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

		if ($this->session->has('success')) {
			$this->data['success'] = $this->session->get('success');
			$this->session->clear('success');
		} else {
			$this->data['success'] = '';
		}

        // SCRIPTS
        $scripts[] = array('id'=>'themeList','method'=>'function','script'=>
            "function activate(e) {
                $.getJSON('". Url::createAdminUrl("style/theme/activate") ."',{
                    id:e
                },function(data){
                    if (data > 0) {
                        $('#img_' + e).attr('src','image/good.png');
                    } else {
                        $('#img_' + e).attr('src','image/minus.png');
                    }
                });
            }
            function editAll() {
                return false;
            } 
            function addToList() {
                return false;
            } 
            function deleteAll() {
                if (confirm('Desea eliminar todos los objetos seleccionados?')) {
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                    $.post('". Url::createAdminUrl("style/theme/delete") ."',$('#form').serialize(),function(){
                        $('#gridWrapper').load('". Url::createAdminUrl("style/theme/grid") ."',function(){
                            $('#gridWrapper').show();
                            $('#gridPreloader').hide();
                        });
                    });
                }
                return false;
            }
            function eliminar(e) {
                if (confirm('¿Desea eliminar este objeto?')) {
                    $('#tr_' + e).remove();
                	$.getJSON('". Url::createAdminUrl("style/theme/delete") ."',{
                        id:e
                    });
                }
                return false;
             }");
        $scripts[] = array('id'=>'sortable','method'=>'ready','script'=>
            "$('#gridWrapper').load('". Url::createAdminUrl("style/theme/grid") ."',function(e){
                $('#gridPreloader').hide();
                $('#list tbody').sortable({
                    opacity: 0.6, 
                    cursor: 'move',
                    handle: '.move',
                    update: function() {
                        $.ajax({
                            'type':'post',
                            'dateType':'json',
                            'url':'". Url::createAdminUrl("style/theme/sortable") ."',
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
                url:'". Url::createAdminUrl("style/theme/grid") ."',
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
        
		$this->template = 'style/theme_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
    
    public function grid() {
        $this->load->auto('image');
        
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
		$filter_template = isset($this->request->get['filter_template']) ? $this->request->get['filter_template'] : null;
		$filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
		$filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'name';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
		
		$url = '';
			
		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; } 
		if (isset($this->request->get['filter_template'])) { $url .= '&filter_template=' . $this->request->get['filter_template']; } 
		if (isset($this->request->get['filter_date_start'])) { $url .= '&filter_date_start=' . $this->request->get['filter_date_start']; }
		if (isset($this->request->get['filter_date_end'])) { $url .= '&filter_date_end=' . $this->request->get['filter_date_end']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; }
		
		$this->data['themes'] = array();

		$data = array(
			'filter_name' => $filter_name, 
			'filter_template' => $filter_template, 
			'filter_date_start' => $filter_date_start, 
			'filter_date_end' => $filter_date_end, 
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);
		
		$theme_total = $this->modelTheme->getTotalThemes();
	
		$results = $this->modelTheme->getAll($data);
 
    	foreach ($results as $result) {
				$action = array(
                'style'    => array(
                        'action'  => 'style',
                        'text'  => $this->language->get('text_style'),
                        'target'=> '_blank',
                        'href'  => HTTP_CATALOG ."/index.php?theme_editor=1&theme_id=". $result['theme_id'] ."&template=". $result['template'],
                        'img'   => 'palette.png'
                ),
                'edit'      => array(
                        'action'  => 'edit',
                        'text'  => $this->language->get('text_edit'),
                        'href'  =>Url::createAdminUrl('style/theme/update') . '&theme_id=' . $result['theme_id'] . $url,
                        'img'   => 'edit.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );
            
			$this->data['themes'][] = array(
				'theme_id'      => $result['theme_id'],
				'name'          => $result['name'],
				'template'      => $result['template'],
				'date_publish_start' => date('d-m-y h:i:s',strtotime($result['date_publish_start'])),
				'default'       => $result['default'],
				'sort_order'    => $result['sort_order'],
				'template_id'   => $result['template_id'],
				'selected'      => isset($this->request->post['selected']) && in_array($result['theme_id'], $this->request->post['selected']),
				'action'        => $action
			);
		}	       
        
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = Url::createAdminUrl('style/theme/grid') . '&sort=name' . $url;
		$this->data['sort_sort_order'] = Url::createAdminUrl('style/theme/grid') . '&sort=sort_order' . $url;
		
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
		$pagination->total = $theme_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('style/theme/grid') . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->data['text_no_results']= $this->language->get('text_no_results');
		$this->data['column_template']    = $this->language->get('column_template');
		$this->data['column_name']    = $this->language->get('column_name');
		$this->data['column_date_start']    = $this->language->get('column_date_start');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action']  = $this->language->get('column_action');	
        
		$this->template = 'style/theme_grid.tpl';
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }
    
  	/**
  	 * ControllerStyleTheme::getForm()
  	 * 
  	 * @see Load
  	 * @see Document
  	 * @see Request
  	 * @see Session
  	 * @see Response
  	 * @see Pagination
  	 * @see Language
  	 * @return void
  	 */
  	private function getForm() {
  	 //TODO: condicionar el gestor de archivos para que solo permita seleccionar un (1) archivo de imagen
     //TODO: crear funciones para seleccionar varias imagenes a la vez y asociarlas con objeto, asi no se tiene que seleccionar de una en una
     //TODO: detectar los slugs que coincidan y agregarle un contador al final en caso de que hayan palabras claves ya creadas
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_default'] = $this->language->get('text_default');
    	$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
    	$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_default'] = $this->language->get('entry_default');
		$this->data['entry_template'] = $this->language->get('entry_template');
		$this->data['entry_theme_editor'] = $this->language->get('entry_theme_editor');
		$this->data['text_open_theme_editor'] = $this->language->get('text_open_theme_editor');
		
		$this->data['help_name'] = $this->language->get('help_name');
		$this->data['help_date_start'] = $this->language->get('help_date_start');
    	$this->data['help_date_end'] = $this->language->get('help_date_end');
    	$this->data['help_default'] = $this->language->get('help_default');
    	$this->data['help_template'] = $this->language->get('help_template');
  
		$this->data['button_save_and_new']= $this->language->get('button_save_and_new');
		$this->data['button_save_and_exit']= $this->language->get('button_save_and_exit');
		$this->data['button_save_and_keep']= $this->language->get('button_save_and_keep');
		$this->data['button_cancel']      = $this->language->get('button_cancel');
	  
 		$this->data['error_warning'] = ($this->error['warning']) ? $this->error['warning'] : '';
 		$this->data['error_name'] = ($this->error['name']) ? $this->error['name'] : '';
		    
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
       		'href'      => Url::createAdminUrl('style/theme') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
						
        $directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
		$this->data['templates'] = array();
		foreach ($directories as $directory) {
			$this->data['templates'][] = basename($directory);
		}	
        	
		if (!isset($this->request->get['theme_id'])) {
			$this->data['action'] = Url::createAdminUrl('style/theme/insert') . $url;
		} else {
			$this->data['action'] = Url::createAdminUrl('style/theme/update') . '&theme_id=' . $this->request->get['theme_id'] . $url;
		}
		
		$this->data['cancel'] = Url::createAdminUrl('style/theme') . $url;
        
    	if (isset($this->request->get['theme_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$theme_info = $this->modelTheme->getTheme($this->request->get['theme_id']);
            $this->data['isSaved'] = true;
    	}
        
        $this->setvar('name',$theme_info,'');
        $this->setvar('template',$theme_info,'');
        $this->setvar('default',$theme_info,'');
        
		if (isset($this->request->post['date_publish_start'])) {
			$this->data['date_publish_start'] = date('d-m-Y',strtotime($this->request->post['date_publish_start']));
		} elseif ($page_info) {
			$this->data['date_publish_start'] = date('d-m-Y',strtotime($theme_info['date_publish_start']));
		} else {
			$this->data['date_publish_start'] = date('d-m-Y');
		}

		if (isset($this->request->post['date_publish_end'])) {
			$this->data['date_publish_end'] = date('d-m-Y',strtotime($this->request->post['date_publish_end']));
		} elseif ($page_info) {
			$this->data['date_publish_end'] = date('d-m-Y',strtotime($theme_info['date_publish_end']));
		} else {
			$this->data['date_publish_end'] = '';
		}

        $this->data['Url'] = new Url;
        //TODO: mostrar los productos al scrolldown para no colapsar el navegador cuando se listan todos los productos
        $scripts[] = array('id'=>'form','method'=>'ready','script'=>
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
            }");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'style/theme_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}  
	 
  	/**
  	 * ControllerStyleTheme::validateForm()
  	 * 
  	 * @see Request
  	 * @see Language
  	 * @return bool
  	 */
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'style/theme')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
        //TODO: colocar validaciones propias

    	if (empty($this->request->post['name'])) {
      		$this->error['name'] = $this->language->get('error_name');
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    

  	/**
  	 * ControllerStyleTheme::validateForm()
  	 * 
  	 * @see Request
  	 * @see Language
  	 * @return bool
  	 */
  	private function validateSave() {
    	if (!$this->user->hasPermission('modify', 'style/theme')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
        
    	if (!$this->request->hasQuery('theme_id')) {
      		$this->error['theme_id'] = true;
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    

  	/**
  	 * ControllerStyleTheme::validateDelete()
  	 * 
  	 * @see Request
  	 * @see Language
  	 * @return bool
  	 */
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'style/theme')) {
			$this->error['warning'] = $this->language->get('error_permission');
    	}	
        //TODO: colocar validaciones propias
		
		$this->load->auto('store/product');

		foreach ($this->request->post['selected'] as $theme_id) {
  			$product_total = $this->modelProduct->getTotalProductsByThemeId($theme_id);
    
			if ($product_total) {
	  			$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);	
			}	
	  	} 
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  
  	}
    
    /**
     * ControllerStoreCategory::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('style/theme');
        $status = $this->modelTheme->getTheme($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelTheme->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelTheme->desactivate($_GET['id']);
                echo -1;
            }
            
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerStoreCategory::sortable()
     * ordenar el listado actualizando la posición de cada objeto
     * @return boolean
     * */
     public function sortable() {
        if (!isset($_POST['tr'])) return false;
        $this->load->auto('style/theme');
        $result = $this->modelTheme->sortProduct($_POST['tr']);
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
        $this->load->auto("store/product");
        $this->load->auto("image");
        $this->load->auto("url");
        if ($this->request->hasQuery('theme_id')) {
            $rows = $this->modelProduct->getProductsByThemeId($this->request->getQuery('theme_id'));
            $products_by_theme = array();
            foreach ($rows as $row) {
                $products_by_theme[] = $row['product_id'];
            }
        }
        $cache = $this->cache->get("products.for.theme.form");
        if ($cache) {
            $products = unserialize($cache);
        } else {
            $model = $this->modelProduct->getAll();
            $products = $model->obj;
            $this->cache->set("products.for.theme.form",serialize($products));
        }
        
        $this->data['Image'] = new NTImage();
        $this->data['Url'] = new Url;
        
        $output = array();
        
        foreach ($products as $product) {
            if (!empty($products_by_theme) && in_array($product->product_id,$products_by_theme)) {
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