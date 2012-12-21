<?php 
/**
 * ControllerContentMenu
 * 
 * @package  NecoTienda powered by Opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.1.0
 * @access public
 * @see Controller
 */
class ControllerContentMenu extends Controller { 
	private $error = array();
 
	/**
	 * ControllerContentMenu::index()
	 * 
	 * @return void
	 */
	public function index() {
		$this->document->title = $this->language->get('heading_title');
        $this->getList();
	}

	/**
	 * ControllerContentMenu::insert()
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
			$menu_id = $this->modelMenu->add($this->request->post);
			$this->session->set('success',$this->language->get('text_success'));
			
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('content/menu/update',array('menu_id'=>$menu_id))); 
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('content/menu/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('content/menu')); 
            }
		}
		$this->getForm();
	}

	/**
	 * ControllerContentMenu::update()
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
            $this->modelMenu->edit($this->request->get['menu_id'], $this->request->post);
    		$this->session->set('success',$this->language->get('text_success'));
    		if ($this->request->post['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('content/menu/update',array('menu_id'=>$this->request->get['menu_id']))); 
            } elseif ($this->request->post['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('content/menu/insert')); 
            } else {
                $this->redirect(Url::createAdminUrl('content/menu')); 
            }
        }
        $this->getForm();
    }

    /**
     * ControllerContentMenu::delete()
     * elimina un objeto
     * @return boolean
     * */
     public function delete() {
        $this->load->auto('content/menu');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelMenu->delete($id);
            }
		} else {
            $this->modelMenu->delete($_GET['id']);
		}
     }
    
	/**
	 * ControllerContentMenu::getList()
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
       		'href'      => Url::createAdminUrl("content/menu"),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
           //TODO: crear función para generar urls absolutas a partir de un controller						
		$this->data['insert'] = Url::createAdminUrl("content/menu/insert");
		$this->data['delete'] = Url::createAdminUrl("content/menu/delete");
        
		
		$this->data['heading_title']      = $this->language->get('heading_title');
		$this->data['button_insert']      = $this->language->get('button_insert');
		$this->data['button_delete']      = $this->language->get('button_delete');
        
        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['success'] = $this->session->has('success') ? $this->session->get('success') : '';
        $this->session->clear('success');
        
        
        // SCRIPTS
        $scripts[] = array('id'=>'menuList','method'=>'function','script'=>
            "function activate(e) {
            	$.ajax({
            	   'type':'get',
                   'dataType':'json',
                   'url':'". Url::createAdminUrl("content/menu/activate") ."&id=' + e,
                   'success': function(data) {
                        if (data > 0) {
                            $('#img_' + e).attr('src','image/good.png');
                        } else {
                            $('#img_' + e).attr('src','image/minus.png');
                        }
                   }
            	});
            }
            function editAll() {
                return false;
            }
            function deleteAll() {
                if (confirm('¿Desea eliminar todos los objetos seleccionados?')) {
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                    $.post('". Url::createAdminUrl("content/menu/delete") ."',$('#form').serialize(),function(){
                        $('#gridWrapper').load('". Url::createAdminUrl("content/menu/grid") ."',function(){
                            $('#gridWrapper').show();
                            $('#gridPreloader').hide();
                        });
                    });
                }
                return false;
            }
            function eliminar(e) {
                if (confirm('¿Desea eliminar este objeto?')) {
                    $('li#' + e).remove();
                	$.getJSON('". Url::createAdminUrl("content/menu/delete") ."',{
                        id:e
                    });
                }
                return false;
             }");
        $scripts[] = array('id'=>'sortable','method'=>'ready','script'=>
            "$('#gridWrapper').load('". Url::createAdminUrl("content/menu/grid") ."',function(e){
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
                        
                        $.getJSON('". Url::createAdminUrl("content/menu/updateparent") ."',{'parent_id':parent_id,'menu_id':ui.item.attr('id')},function(data){
                            if (data.error) {
                                $('#msg').fadeIn().append('<div class=\"message success\"'+ data.msg +'</div>').delay(3600).fadeOut();
                            }
                        });
                        
                        var sorts = {}; 
                        var i = 0;
                        $('ol.items li').each(function(){
                            i++;
                            sorts[i] = $(this).attr('id');
                        }); 
                        
                        $.post('". Url::createAdminUrl("content/menu/sortable") ."',sorts,
                        function(data){
                            if (data.error) {
                                $('#msg').fadeIn().append('<div class=\"message success\"'+ data.msg +'</div>').delay(3600).fadeOut();
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
                url:'". Url::createAdminUrl("content/menu/grid") ."',
                beforeSend:function(){
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                },
                success:function(data){
                    $('#gridPreloader').hide();
                    $('#gridWrapper').html(data).show();
                    
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
                            
                            $.getJSON('". Url::createAdminUrl("content/menu/updateparent") ."',{'parent_id':parent_id,'menu_id':ui.item.attr('id')},function(data){
                                if (data.error) {
                                    $('#msg').fadeIn().append('<div class=\"message message success\"'+ data.msg +'</div>').delay(3600).fadeOut();
                                }
                            });
                            
                            var sorts = {}; 
                            var i = 0;
                            $('ol.items li').each(function(){
                                i++;
                                sorts[i] = $(this).attr('id');
                            }); 
                            
                            $.post('". Url::createAdminUrl("content/menu/sortable") ."',sorts,
                            function(data){
                                if (data.error) {
                                    $('#msg').fadeIn().append('<div class=\"message message success\"'+ data.msg +'</div>').delay(3600).fadeOut();
                                }
                            });
                        }
            		});
                }
            });");
             
        $this->scripts = array_merge($this->scripts,$scripts);
        
        
		$this->template = 'content/menu_list.tpl';
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
        
        if (empty($_GET['menu_id']) && !isset($_GET['parent_id'])) {
            $data['error'] = 1;
            $data['msg'] = "No se encontr&oacute; la categor&iacute;a que se va a actualizar";
        } 
        $result = $this->db->query("UPDATE ". DB_PREFIX ."menu SET parent_id = ". (int)$_GET['parent_id'] ." WHERE menu_id = ". (int)$_GET['menu_id']);
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
	 * ControllerContentMenu::grid()
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
		$filter_name = !empty($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
		$filter_product = !empty($this->request->get['filter_product']) ? $this->request->get['filter_product'] : null;
		$filter_date_start = !empty($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
		$filter_date_end = !empty($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
		$page = !empty($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = !empty($this->request->get['sort']) ? $this->request->get['sort'] : 'cd.name';
		$order = !empty($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
        
        $start = explode("/",$filter_date_start);
        $end = explode("/",$filter_date_end);
        
		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_product'  => $filter_product,
			'filter_date_start'=> ($filter_date_start) ? date('Y-m-d h:i:s',strtotime($start[2]."-".$start[1]."-".$start[0])) : null,
			'filter_date_end' => ($filter_date_end) ? date('Y-m-d h:i:s',strtotime($end[2]."-".$end[1]."-".$end[0])) : null,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $limit,
			'limit'           => $limit
		);
        
        $results = $this->modelMenu->getAll();
        
        foreach ($results as $key => $result) {
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
                        'href'  =>Url::createAdminUrl('content/menu/update') . '&product_id=' . $result['product_id'] . $url,
                        'img'   => 'edit.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );
            
            $this->data['menus'][] = array(
                'menu_id'=>$result['menu_id'],
                'name'=>$result['name'],
                'route'=>$result['route'],
                'position'=>$result['position'],
                'status'=>($result['status']) ? 'Activado' : 'Desactivado',
                'action'=>$action
            );
        }
        
		$this->data['text_no_results']    = $this->language->get('text_no_results');
		$this->data['column_name']        = $this->language->get('column_name');
		$this->data['column_position']  = $this->language->get('column_position');
		$this->data['column_satus']  = $this->language->get('column_satus');
		$this->data['column_route']  = $this->language->get('column_route');
		$this->data['column_sort_order']  = $this->language->get('column_sort_order');
		$this->data['column_action']      = $this->language->get('column_action');
        
        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_warning'] = $this->session->has('success') ? $this->session->get('success') : '';
        $this->session->clear('success');
        $this->data['Url'] = Url;
		$this->template = 'content/menu_grid.tpl';
        
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));  
	}

     public function getMenus($menus,$parent = false) {
	    $output = '';
        if ($menus) {
            $output .= ($parent) ? '<ol class="items">' : '<ol>';
    		foreach ($menus as $result) {
                $output .= '<li id="'. $result['menu_id'] .'">';
                $output .= '<div class="item">';
                $output .= '<input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="'. $result['menu_id'] .'">';
                $output .= '<b class="name">'. $result['name'] .'</b>';
                
                $_img = ((int)$result['status'] == 1) ? 'good.png' : 'minus.png';
                
                $output .= '<div class="actions">';
                /*
                $output .= '<a title="'. $this->language->get('text_see') .'" href="'. Url::createAdminUrl("content/menu/see",array('menu_id'=>$result['menu_id'])) .'">';
                $output .= '<img src="image/report.png" alt="'. $this->language->get('text_see') .'" />';
                $output .= '</a>';
                */
                $output .= '<a title="'. $this->language->get('text_edit') .'" href="'. Url::createAdminUrl("content/menu/update",array('menu_id'=>$result['menu_id'])) .'">';
                $output .= '<img src="image/edit.png" alt="'. $this->language->get('text_edit') .'" />';
                $output .= '</a>';
                
                $output .= '<a title="'. $this->language->get('text_activate') .'" onclick="activate('. $result['menu_id'] .')">';
                $output .= '<img id="img_'. $result['menu_id'] .'" src="image/'. $_img .'" alt="'. $this->language->get('text_activate') .'" />';
                $output .= '</a>';
               
                $output .= '<a title="'. $this->language->get('text_delete') .'" onclick="eliminar('. $result['menu_id'] .')">';
                $output .= '<img src="image/delete.png" alt="'. $this->language->get('text_delete') .'" />';
                $output .= '</a>';
               /*
                $output .= '<a title="'. $this->language->get('text_copy') .'" onclick="copy('. $result['menu_id'] .')">';
                $output .= '<img src="image/copy.png" alt="'. $this->language->get('text_copy') .'" />';
                $output .= '</a>';
               */
                $output .= '</div>';
                
                $output .= '</div>';
                
                // submenus
    			if ($result['childrens']) {
                    $output .= $this->getMenus($result['childrens']);
    			}
                
                $output .= '</li>';
            }
            $output .= '</ol>';
        }	
        return $output;
	}
	
	/**
	 * ControllerContentMenu::getForm()
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
		$this->data['entry_menu']     = $this->language->get('entry_menu');
		$this->data['entry_sort_order']   = $this->language->get('entry_sort_order');
		$this->data['entry_image']        = $this->language->get('entry_image');
		$this->data['entry_status']       = $this->language->get('entry_status');
		$this->data['help_name']          = $this->language->get('help_name');
		$this->data['help_meta_keywords'] = $this->language->get('help_meta_keywords');
		$this->data['help_meta_description'] = $this->language->get('help_meta_description');
		$this->data['help_description']   = $this->language->get('help_description');
		$this->data['help_keyword']       = $this->language->get('help_keyword');
		$this->data['help_menu']      = $this->language->get('help_menu');
		$this->data['help_sort_order']    = $this->language->get('help_sort_order');
		$this->data['help_image']         = $this->language->get('help_image');
		$this->data['help_status']        = $this->language->get('help_status');
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
       		'href'      => Url::createAdminUrl('content/menu'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['menu_id'])) {
			$this->data['action'] = Url::createAdminUrl('content/menu/insert');
		} else {
			$this->data['action'] = Url::createAdminUrl('content/menu/update',array('menu_id'=>$this->request->get['menu_id']));
		}
		
		$this->data['cancel'] = Url::createAdminUrl('content/menu');

		if (isset($this->request->get['menu_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$menu_info = $this->modelMenu->getMenu($this->request->get['menu_id']);
      		$this->data['links'] = $this->getLinks();
    	}
        
        $this->data['pages'] = $this->getPages();
        $this->data['post_categories'] = $this->getPostCategories();
        $this->data['categories'] = $this->getCategories();
        //$this->data['manufacturers'] = $this->modelManufacturer->getAll();
		
        $this->setvar('status',$menu_info,1);
        $this->setvar('parent_id',$menu_info,0);
        $this->setvar('keyword',$menu_info,'');
        $this->setvar('image',$menu_info);
        $this->setvar('sort_order',$menu_info,0);
        
		//$this->data['menus'] = $this->modelMenu->getMenus(0);

        $this->data['Url'] = new Url;
        
        $scripts[] = array('id'=>'menuForm','method'=>'ready','script'=>
            "$('#menu_description_1_name').blur(function(e){
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
                        var parentIndex = ui.item.parents('li')
                            .map(function () { 
                                      return $(this).index(); 
                                    })
                            .get()
                            .join('_');
                                
                        parent.eq(0).find('> ol > li').each(function() {
                            console.log(this);
                            
                            $(this).find('.menu_link').each(function(){
                                $(this).attr({name:'link['+ parentIndex +'_'+ $(this).index() +'][link]'});
                            });
                            
                            $(this).find('.menu_tag').each(function(){
                                $(this).attr({name:'link['+ parentIndex +'_'+ $(this).index() +'][tag]'});
                            });
                            
                            $(this).find('.menu_keyword').each(function(){
                                $(this).attr({name:'link['+ parentIndex +'_'+ $(this).index() +'][keyword]'});
                            });
                            console.log(parentIndex +'_'+ $(this).index());
                        });
                    } else {
                        parent_id = 0;
                    }
                    
                }
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
            
        $scripts[] = array('id'=>'menuFunctions','method'=>'function','script'=>
            "function saveAndExit() { 
                window.onbeforeunload = null;
                $('#formMenu').append(\"<input type='hidden' name='to' value='saveAndExit'>\").submit(); 
            }
            
            function saveAndKeep() { 
                window.onbeforeunload = null;
                $('#formMenu').append(\"<input type='hidden' name='to' value='saveAndKeep'>\").submit(); 
            }
            
            function saveAndNew() { 
                window.onbeforeunload = null;
                $('#formMenu').append(\"<input type='hidden' name='to' value='saveAndNew'>\").submit(); 
            }");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
        /* feedback form values */
        $this->data['domain'] = HTTP_HOME;
        $this->data['account_id'] = C_CODE;
        $this->data['local_ip'] = $_SERVER['SERVER_ADDR'];
        $this->data['remote_ip'] = $_SERVER['REMOTE_ADDR'];
        $this->data['server'] = serialize($_SERVER); //TODO: encriptar todos estos datos con una llave que solo yo poseo
        
        
		$this->template = 'content/menu_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	/**
	 * ControllerContentMenu::validateForm()
	 * 
     * @see User
     * @see Request
     * @see Language
	 * @return bool
	 */
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'content/menu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
        //TODO: agregar funciones de validación propias

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * ControllerContentMenu::validateDelete()
	 * 
     * @see User
     * @see Language
	 * @return bool
	 */
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'content/menu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
        //TODO: agregar funciones de validación propias
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
    
    /**
     * ControllerContentMenu::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('content/menu');
        $status = $this->modelMenu->getMenu($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelMenu->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelMenu->desactivate($_GET['id']);
                echo -1;
            }
            
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerContentMenu::sortable()
     * ordenar el listado actualizando la posición de cada objeto
     * @return boolean
     * */
     public function sortable() {
        $this->load->auto('content/menu');
        $result = $this->modelMenu->sortMenu($_POST);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
     }
     
     public function getPages($parent_id=0, $marginLeft=5) {
        $pages = $this->modelPage->getAll($parent_id);
        $return = '';
        if ($pages) {
            foreach ($pages as $key => $value) {
                $return .= '<li style="padding-left:'.$marginLeft.'px">';
                $return .= '<input type="checkbox" name="pages[]" value="'. $value['post_id'] .'" />';
                $return .= '<b>'. $value['title'] .'</b>';
                $return .= '</li>';
                
                $childrens = $this->modelPage->getAll($value['post_id']);
                if ($childrens) {
                    $return .= $this->getPages($value['post_id'],$marginLeft + 20);
                }
            }
        }
        return $return;
     }
     
     public function getPostCategories($parent_id=0, $marginLeft=5) {
        $categories = $this->modelPost_category->getAllForMenu($parent_id);
        $return = '';
        if ($categories) {
            foreach ($categories as $key => $value) {
                $return .= '<li style="padding-left:'.$marginLeft.'px">';
                $return .= '<input type="checkbox" name="post_categories[]" value="'. $value['post_category_id'] .'" />';
                $return .= '<b>'. $value['title'] .'</b>';
                $return .= '</li>';
                
                $childrens = $this->modelPost_category->getAllForMenu($value['post_category_id']);
                if ($childrens) {
                    $return .= $this->getPostCategories($value['post_category_id'],$marginLeft + 20);
                }
            }
        }
        return $return;
     }
     
     public function getCategories($parent_id=0, $marginLeft=5) {
        $categories = $this->modelCategory->getAllForMenu($parent_id);
        $return = '';
        if ($categories) {
            foreach ($categories as $key => $value) {
                $return .= '<li style="padding-left:'.$marginLeft.'px">';
                $return .= '<input type="checkbox" name="categories[]" value="'. $value['category_id'] .'" />';
                $return .= '<b>'. $value['name'] .'</b>';
                $return .= '</li>';
                
                $childrens = $this->modelCategory->getAllForMenu($value['category_id']);
                if ($childrens) {
                    $return .= $this->getCategories($value['category_id'],$marginLeft + 20);
                }
            }
        }
        return $return;
     }
     

     public function getLinks($parent_id=0) {
	    $output = '';
        $links = $this->modelMenu->getLinks($this->request->get['menu_id'],$parent_id);
        if ($links) {
    		foreach ($links as $key => $result) {
    		  $index =  ($parent_id) ? $parent_id ."_". $key : $key;
                $output .= '<li id="li_'. $index .'">';
                $output .= '<div class="item">';
                $output .= '<b>'. $result['tag'] .'</b>';
                $output .= '<a class="showOptions" onclick="$(\'#linkOptions'. $index .'\').slideToggle(\'fast\')">&darr;</a>';
                $output .= '</div>';
                $output .= '<div id="linkOptions'. $index .'" class="itemOptions">';
                
                $output .= '<div class="row">';
                $output .= '<label class="neco-label" for="link_'. $index .'_link">Url:</label>';
                $output .= '<input type="url" id="link_'. $index .'_link" name="link['. $index .'][link]" value="'. $result['link'] .'" style="width: 60%;" class="menu_link" />';
                $output .= '</div>';
                
                $output .= '<div class="clear"></div>';
                
                $output .= '<div class="row">';
                $output .= '<label class="neco-label" for="link_'. $index .'_tag">Etiqueta:</label>';
                $output .= '<input type="text" id="link_'. $index .'_tag" name="link['. $index .'][tag]" value="'. $result['tag'] .'" style="width: 60%;" class="menu_link" />';
                $output .= '</div>';
                
                $output .= '<div class="clear"></div>';
                
                $output .= '<div class="row">';
                $output .= '<label class="neco-label" for="link_'. $index .'_keyword">Slug:</label>';
                $output .= '<input type="text" id="link_'. $index .'_keyword" name="link['. $index .'][keyword]" value="'. $result['keyword'] .'" style="width: 60%;" class="menu_link" />';
                $output .= '</div>';
                
                $output .= '<div class="clear"></div>';
                
                $output .= '<a style="float:right;font-size:10px;" onclick="$(\'#li_'. $index .'\').remove()">[ Eliminar ]</a>';
                $output .= '</div>';
                
                // subcategories
                $childrens = $this->modelMenu->getLinks($this->request->get['menu_id'],$result['menu_link_id']);
    			if ($childrens) {
                    $output .= '<ol>';
                    $output .= $this->getLinks($result['menu_link_id']);
                    $output .= '</ol>';
    			}
                
                $output .= '</li>';
            }
            
        }	
        return $output;
	}
	
     public function page() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        
        $data = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['pages'])) {
    		$this->load->model('content/page');
    		$this->load->library('url');
    		$this->load->library('json');
        
            
            foreach ($this->request->post['pages'] as $key => $value) {
                $result = $this->modelPage->getPage($value);
                if (!$result) continue;
                $data[$key]['title'] = $result['title'];
                $data[$key]['keyword'] = $result['keyword'];
                $data[$key]['href'] = HTTP_CATALOG . '/index.php?r=content/page&page_id=' . $result['post_id'];
            }
        } 
        
		$this->response->setOutput(Json::encode($data));       
     }
     
     public function category() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        
        $data = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['categories'])) {
    		$this->load->model('store/category');
    		$this->load->library('url');
    		$this->load->library('json');
            foreach ($this->request->post['categories'] as $key => $value) {
                $result = $this->modelCategory->getCategory($value);
                if (!$result) continue;
                $path = ($result['parent_id']) ? $result['parent_id'] ."_". $result['category_id'] : $result['category_id'];
                
                $data[$value]['title']  = $result['name'];
                $data[$value]['keyword']= $result['keyword'];
                $data[$value]['href']   = HTTP_CATALOG . '/index.php?r=store/category&path=' . $path;
            }
        } 
        
		$this->response->setOutput(Json::encode($data));       
     }
}