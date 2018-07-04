<?php

/**
 * ControllerContentMenu
 * 
 * @package  NecoTienda
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
     * ControllerContentMenu::getById()
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
            'href' => Url::createAdminUrl("common/home"),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl("content/menu"),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );
        //TODO: crear funci�n para generar urls absolutas a partir de un controller						
        $this->data['insert'] = Url::createAdminUrl("content/menu/insert");
        $this->data['delete'] = Url::createAdminUrl("content/menu/delete");

        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['success'] = $this->session->has('success') ? $this->session->get('success') : '';
        $this->session->clear('success');

        // SCRIPTS
        $scripts[] = array('id' => 'menuList', 'method' => 'function', 'script' =>
            "function activate(e) {    
            	$.ajax({
            	   'type':'get',
                   'dataType':'json',
                   'url':'" . Url::createAdminUrl("content/menu/activate") . "&id=' + e,
                   'success': function(data) {
                        if (data > 0) {
                            $(\"#img_\" + e).attr('src','image/good.png');
                        } else {
                            $(\"#img_\" + e).attr('src','image/minus.png');
                        }
                   }
            	});
             }
            function eliminar(e) {
                if (confirm('\\xbfDesea eliminar este objeto?')) {
                    $('#tr_' + e).remove();
                	$.getJSON('" . Url::createAdminUrl("content/menu/delete") . "',{
                        id:e
                    });
                }
                return false;
             }
            function editAll() {
                return false;
            } 
            function addToList() {
                return false;
            } 
            function deleteAll() {
                if (confirm('\\xbfDesea eliminar todos los objetos seleccionados?')) {
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                    $.post('" . Url::createAdminUrl("content/menu/delete") . "',$('#form').serialize(),function(){
                        $('#gridWrapper').load('" . Url::createAdminUrl("content/menu/grid") . "',function(){
                            $('#gridWrapper').show();
                            $('#gridPreloader').hide();
                        });
                    });
                }
                return false;
            }");
        $scripts[] = array('id' => 'sortable', 'method' => 'ready', 'script' =>
            "$('#gridWrapper').load('" . Url::createAdminUrl("content/menu/grid") . "',function(e){
                $('#gridPreloader').hide();
            });
            
            $('#formFilter').ntForm({
                lockButton:false,
                ajax:true,
                type:'get',
                dataType:'html',
                url:'" . Url::createAdminUrl("content/menu/grid") . "',
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
                            
                            $.getJSON('" . Url::createAdminUrl("content/menu/updateparent") . "',{'parent_id':parent_id,'menu_id':ui.item.attr('id')},function(data){
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
                            
                            $.post('" . Url::createAdminUrl("content/menu/sortable") . "',sorts,
                            function(data){
                                if (data.error) {
                                    $('#msg').fadeIn().append('<div class=\"message message success\"'+ data.msg +'</div>').delay(3600).fadeOut();
                                }
                            });
                        }
            		});
                }
            });
            $('#formFilter').on('keyup', function(e){
                var code = e.keyCode || e.which;
                if (code == 13){
                    $('#formFilter').ntForm('submit');
                }
            });");

        $this->scripts = array_merge($this->scripts, $scripts);


        $template = ($this->config->get('default_admin_view_menu_list')) ? $this->config->get('default_admin_view_menu_list') : 'content/menu_list.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_admin_template') . '/'. $template)) {
            $this->template = $this->config->get('config_admin_template') . '/' . $template;
        } else {
            $this->template = 'default/' . $template;
        }

        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
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

        $start = explode("/", $filter_date_start);
        $end = explode("/", $filter_date_end);

        $data = array(
            'filter_name' => $filter_name,
            'filter_product' => $filter_product,
            'filter_date_start' => ($filter_date_start) ? date('Y-m-d h:i:s', strtotime($start[2] . "-" . $start[1] . "-" . $start[0])) : null,
            'filter_date_end' => ($filter_date_end) ? date('Y-m-d h:i:s', strtotime($end[2] . "-" . $end[1] . "-" . $end[0])) : null,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        $results = $this->modelMenu->getAll();
        $i = str_replace('%theme%',$this->config->get('config_admin_template'),HTTP_ADMIN_THEME_IMAGE);
        foreach ($results as $key => $result) {
            $action = array(
                'activate' => array(
                    'action' => 'activate',
                    'text' => $this->language->get('text_activate'),
                    'href' => '',
                    'img' => $i .'good.png'
                ),
                'edit' => array(
                    'action' => 'edit',
                    'text' => $this->language->get('text_edit'),
                    'href' => Url::createAdminUrl('content/menu/update') . '&menu_id=' . $result['menu_id'] . $url,
                    'img' =>  $i .'edit.png'
                ),
                'delete' => array(
                    'action' => 'delete',
                    'text' => $this->language->get('text_delete'),
                    'href' => '',
                    'img' => $i .'delete.png'
                )
            );

            $this->data['menus'][] = array(
                'menu_id' => $result['menu_id'],
                'name' => $result['name'],
                'route' => $result['route'],
                'position' => $result['position'],
                'status' => ($result['status']) ? 'Activado' : 'Desactivado',
                'action' => $action
            );
        }

        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_warning'] = $this->session->has('success') ? $this->session->get('success') : '';
        $this->session->clear('success');

        $template = ($this->config->get('default_admin_view_menu_grid')) ? $this->config->get('default_admin_view_menu_grid') : 'content/menu_grid.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_admin_template') . '/'. $template)) {
            $this->template = $this->config->get('config_admin_template') . '/' . $template;
        } else {
            $this->template = 'default/' . $template;
        }


        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function getMenus($menus, $parent = false) {
        $output = '';
        if ($menus) {
            $output .= ($parent) ? '<ol class="items">' : '<ol>';
            foreach ($menus as $result) {
                $output .= '<li id="' . $result['menu_id'] . '">';
                $output .= '<div class="item">';
                $output .= '<input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="' . $result['menu_id'] . '">';
                $output .= '<b class="name">' . $result['name'] . '</b>';

                $_img = ((int) $result['status'] == 1) ? 'good.png' : 'minus.png';

                $output .= '<div class="actions">';
                /*
                  $output .= '<a title="'. $this->language->get('text_see') .'" href="'. Url::createAdminUrl("content/menu/see",array('menu_id'=>$result['menu_id'])) .'">';
                  $output .= '<img src="image/report.png" alt="'. $this->language->get('text_see') .'" />';
                  $output .= '</a>';
                 */
                $output .= '<a title="' . $this->language->get('text_edit') . '" href="' . Url::createAdminUrl("content/menu/update", array('menu_id' => $result['menu_id'])) . '">';
                $output .= '<img src="image/edit.png" alt="' . $this->language->get('text_edit') . '" />';
                $output .= '</a>';

                $output .= '<a title="' . $this->language->get('text_activate') . '" onclick="activate(' . $result['menu_id'] . ')">';
                $output .= '<img id="img_' . $result['menu_id'] . '" src="image/' . $_img . '" alt="' . $this->language->get('text_activate') . '" />';
                $output .= '</a>';

                $output .= '<a title="' . $this->language->get('text_delete') . '" onclick="eliminar(' . $result['menu_id'] . ')">';
                $output .= '<img src="image/delete.png" alt="' . $this->language->get('text_delete') . '" />';
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
        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('content/menu'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        if (!isset($this->request->get['menu_id'])) {
            $this->data['action'] = Url::createAdminUrl('content/menu/save');
        } else {
            $this->data['action'] = Url::createAdminUrl('content/menu/save', array('menu_id' => $this->request->get['menu_id']));
        }

        $this->data['cancel'] = Url::createAdminUrl('content/menu');

        if (isset($this->request->get['menu_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $menu_info = $this->modelMenu->getById($this->request->getQuery('menu_id'));
            $this->data['links'] = $this->getLinks();
        }

        $this->data['languages'] = $this->modelLanguage->getAll();
        $this->data['stores'] = $this->modelStore->getAll();
        $this->data['_stores'] = $this->modelMenu->getStores($this->request->get['menu_id']);
        $this->data['pages'] = $this->getAll();
        $this->data['post_categories'] = $this->getPostCategories();
        $this->data['categories'] = $this->getCategories();
        $this->data['manufacturers'] = $this->modelManufacturer->getAll();

        $this->setvar('name', $menu_info, '');
        $this->setvar('default', $menu_info, 0);
        $this->setvar('status', $menu_info, 1);
        $this->setvar('parent_id', $menu_info, 0);
        $this->setvar('sort_order', $menu_info, 0);
        
        $scripts[] = array('id' => 'menuFunctions', 'method' => 'function', 'script' =>
            "function saveAndKeep() {
                $('#temp').remove();
                $('#menuMsg').append('<div class=\"message success\" id=\"temp\">" . $this->language->get('text_success') . "</div>');
                window.onbeforeunload = null;
                
                data = $.extend(true, $('#formMenu').serializeFormJSON(), $('#menuItems').serializeFormJSON(), {items:$('#menuItems').serialize()}); 
                
                $.post('" . Url::createAdminUrl("content/menu/save") . "', data,
                function(response){
                    
                });
            }
            (function($) {
                $.fn.serializeFormJSON = function() {
                
                   var o = {};
                   var a = this.serializeArray();
                   $.each(a, function() {
                       if (o[this.name]) {
                           if (!o[this.name].push) {
                               o[this.name] = [o[this.name]];
                           }
                           o[this.name].push(this.value || '');
                       } else {
                           o[this.name] = this.value || '';
                       }
                   });
                   return o;
                };
                })(jQuery);");

        $this->scripts = array_merge($this->scripts, $scripts);

        /* feedback form values */
        $this->data['domain'] = HTTP_HOME;
        $this->data['account_id'] = C_CODE;
        $this->data['local_ip'] = $_SERVER['SERVER_ADDR'];
        $this->data['remote_ip'] = $_SERVER['REMOTE_ADDR'];
        $this->data['server'] = serialize($_SERVER); //TODO: encriptar todos estos datos con una llave que solo yo poseo

        $template = ($this->config->get('default_admin_view_menu_form')) ? $this->config->get('default_admin_view_menu_form') : 'content/menu_form.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_admin_template') . '/'. $template)) {
            $this->template = $this->config->get('config_admin_template') . '/' . $template;
        } else {
            $this->template = 'default/' . $template;
        }

        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }


    public function save() {
        $this->load->model('content/menu');
        $this->load->library('json');
        $json = $data = array();
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $json = $data = $_POST;
            if ($this->request->hasQuery('menu_id')) {
                $this->modelMenu->update($this->request->get['menu_id'], $data);
                $this->session->set('success', $this->language->get('text_success'));
                $this->redirect(Url::createAdminUrl("content/menu/update", array('menu_id' => $this->request->get['menu_id'])));
            } else {
                $menu_id = $this->modelMenu->add($data);
                $this->session->set('success', $this->language->get('text_success'));
                $this->redirect(Url::createAdminUrl("content/menu/update", array('menu_id' => $menu_id)));
            }
        } else {
            $json['error'] = 1;
            $json['message'] = $this->error;
        }
        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
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
        //TODO: agregar funciones de validaci�n propias

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
        //TODO: agregar funciones de validaci�n propias

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
        if (!isset($_GET['id']))
            return false;
        $this->load->auto('content/menu');
        $menus = $this->modelMenu->getAll(array(
            'menu_id'=>$_GET['id']
        ));

        if ($menus[0]) {
            if ($menus[0]['status'] == 0) {
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
     * ordenar el listado actualizando la posici�n de cada objeto
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

    public function getAll($parent_id = 0, $marginLeft = 5) {

        $pages = $this->modelPage->getAll(array(
            'parent_id'=>$parent_id
        ));
        $return = '';
        if ($pages) {
            foreach ($pages as $key => $value) {
                $return .= '<li style="padding-left:' . $marginLeft . 'px">';
                $return .= '<input id="scrollboxPages'. $value['post_id'] .'" type="checkbox" name="pages[]" value="' . $value['post_id'] . '" />';
                $return .= '<label for="scrollboxPages'. $value['post_id'] .'">' . $value['title'] . '</label>';
                $return .= '</li>';

                $childrens = $this->modelPage->getAll(array(
                    'parent_id'=>$value['post_id']
                ));
                if ($childrens) {
                    $return .= $this->getAll($value['post_id'], $marginLeft + 20);
                }
            }
        }

        return $return;
    }

    public function getPostCategories($parent_id = 0, $marginLeft = 5) {
        $data['parent_id'] = $parent_id;
        $categories = $this->modelPost_category->getAll($data);
        $return = '';
        if ($categories) {
            foreach ($categories as $key => $value) {
                $return .= '<li style="padding-left:' . $marginLeft . 'px">';
                $return .= '<input id="scrollboxPostCategories'. $value['post_category_id'] .'" type="checkbox" name="post_categories[]" value="' . $value['post_category_id'] . '" />';
                $return .= '<label for="scrollboxPostCategories'. $value['post_category_id'] .'">' . $value['title'] . '</label>';
                $return .= '</li>';

                $data['parent_id'] = $value['post_category_id'];
                $children = $this->modelPost_category->getAll($data);
                if ($children) {
                    $return .= $this->getPostCategories($value['post_category_id'], $marginLeft + 20);
                }
            }
        }
        return $return;
    }

    public function getCategories($parent_id = 0, $marginLeft = 5) {
        $categories = $this->modelCategory->getAll(array(
          'parent_id'=>$parent_id
        ));
        $return = '';
        if ($categories) {
            foreach ($categories as $key => $value) {
                $return .= '<li style="padding-left:' . $marginLeft . 'px">';
                $return .= '<input id="scrollboxCategories'. $value['category_id'] .'" type="checkbox" name="categories[]" value="' . $value['category_id'] . '" />';
                $return .= '<label for="scrollboxCategories'. $value['category_id'] .'">' . $value['title'] . '</label>';
                $return .= '</li>';

                $childrens = $this->modelCategory->getAll(array(
                  'parent_id'=>$value['category_id']
                ));
                if ($childrens) {
                    $return .= $this->getCategories($value['category_id'], $marginLeft + 20);
                }
            }
        }
        return $return;
    }

    public function getParentsTree($id) {
        $this->load->auto('content/menu');

        $links = $this->modelMenu->getAllItems(array(
            'menu_link_id'=>$id
        ));

        if ($links[0]['parent_id']) {
            return $links[0]['parent_id'];
        }
    }

    public function getLinks($parent_id = 0) {
        $output = '';
        $scripts = array();
        $this->load->model('content/page');
        $this->load->model('localisation/language');
        $links = $this->modelMenu->getAllItems(array(
            'menu_id' => $this->request->getQuery('menu_id'),
            'parent_id' => $parent_id
        ));
        $languages = $this->modelLanguage->getAll();
        foreach ($links as $key => $result) {
            if ($result['parent_id']) {
                $index = trim($this->getParentsTree($result['parent_id']) ."_". $result['parent_id'] ."_". $result['menu_link_id'], '_');
            } else {
                $index = $result['menu_link_id'];
            }

            $output .= '<li id="li_' . $index . '">';
            $output .= '<div class="item">';
            $output .= '<b>' . $result['tag'] . '</b>';
            $output .= '<a class="showOptions" onclick="$(\'#linkOptions' . $index . '\').slideToggle(\'fast\')">&darr;</a>';
            $output .= '</div>';
            $output .= '<input type="hidden" id="link_' . $index . '_menu_link_id" name="link[' . $index . '][menu_link_id]" value="' . $result['menu_link_id'] . '" />';
            $output .= '<div id="linkOptions' . $index . '" class="itemOptions">';

            $output .= '<a style="float:right;font-size:10px;" onclick="$(\'#li_' . $index . '\').remove()">[ Eliminar ]</a>';

            $output .= '<div class="row">';
            $output .= '<label class="neco-label" for="link_' . $index . '_link">Url:</label>';
            $output .= '<input type="url" id="link_' . $index . '_link" name="link[' . $index . '][link]" value="' . $result['link'] . '" style="width: 60%;" class="menu_link" />';
            $output .= '</div>';

            $output .= '<div class="clear"></div>';

            $output .= '<div class="row">';
            $output .= '<label class="neco-label" for="link_' . $index . '_tag">Etiqueta:</label>';
            $output .= '<input type="text" id="link_' . $index . '_tag" name="link[' . $index . '][tag]" value="' . $result['tag'] . '" style="width: 60%;" class="menu_tag" />';
            $output .= '</div>';

            $output .= '<div class="clear"></div>';

            $output .= '<div class="row">';
            $output .= '<label class="neco-label" for="link_' . $index . '_class_css">Clases CSS:</label>';
            $output .= '<input type="text" id="link_' . $index . '_class_css" name="link[' . $index . '][class_css]" value="' . $result['class_css'] . '" style="width: 60%;" class="menu_class_css" />';
            $output .= '</div>';

            $output .= '<div class="clear"></div>';

            $output .= '<label class="neco-label" for="link_' . $index . '_html">Contenido HTML:</label>';

            $output .= '<div class="clear"></div>';
            $output .= '<div id="languages" class="htabs2">';
                foreach ($languages as $language) {
                    $output .= '<a tab="#language'.  $language['language_id'] . $index .'" class="htab2">';

                    $output .= '<img src="images/flags/'. $language['image'] .'" title="'. $language['name'] .'" /> '. $language['name'];
                    $output .= '</a>';
                }
            $output .= '</div>';

            foreach ($languages as $language) {
                $i = $language["language_id"] . $index;
                $output .= '<div id="language'. $i . '">';

                    $output .= '<textarea name="link[' . $index . '][descriptions]['. $language['language_id'] .'][description]" id="description'. $i .'">'. $result['descriptions'][$language['language_id']]['description'] .'</textarea>';

                $output .= '</div>';

                $code = "var editor". $i ." = CKEDITOR.replace('description" . $i . "', {"
                    . "filebrowserBrowseUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserImageBrowseUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserFlashBrowseUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserUploadUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserImageUploadUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserFlashUploadUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "height:100"
                    . "});"
                    . "editor". $i .".config.allowedContent = true;";
                $cssrules = "assets/theme/". ($this->config->get('config_template') ? $this->config->get('config_template') : 'choroni') ."/css/theme.css";
                if (file_exists(DIR_ROOT . $cssrules)) {
                    $code .= "editor". $i .".config.contentsCss = '". HTTP_CATALOG . $cssrules ."';";
                }

                $scripts[] = array('id' => 'menuLanguage' . $i, 'method' => 'ready', 'script' => $code );

            }

            $output .= '<div class="clear"></div>';
            $output .= '<hr />';

            $output .= '</div>';

            // subcategories
            $childrens = $this->modelMenu->getAllItems(array(
                'menu_id'=>$this->request->getQuery('menu_id'),
                'parent_id'=>$result['menu_link_id']
            ));

            if ($childrens) {
                $output .= '<ol>';
                $output .= $this->getLinks($result['menu_link_id']);
                $output .= '</ol>';
            }

            $output .= '</li>';
        }
        $this->scripts = array_merge($this->scripts, $scripts);

        return $output;
    }

    public function page() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/json");

        $data = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['pages'])) {
            $this->load->model('content/page');
            $this->load->library('url');
            $this->load->library('json');


            foreach ($this->request->post['pages'] as $key => $value) {
                $result = $this->modelPage->getById($value);
                if (!$result)
                    continue;
                $data[$key]['title'] = $result['title'];
                $data[$key]['href'] = Url::createUrl('content/page', array('page_id' => $result['post_id']), 'NONSSL', HTTP_CATALOG);
            }
        }

        $this->response->setOutput(Json::encode($data));
    }

    public function category() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/json");

        $data = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['categories'])) {
            $this->load->model('store/category');
            $this->load->library('url');
            $this->load->library('json');
            foreach ($this->request->post['categories'] as $key => $value) {
                $result = $this->modelCategory->getById($value);
                if (!$result)
                    continue;
                $path = ($result['parent_id']) ? $result['parent_id'] . "_" . $result['category_id'] : $result['category_id'];

                $data[$value]['title'] = $result['title'];
                $data[$value]['href'] = Url::createUrl('store/category', array('path' => $path), 'NONSSL', HTTP_CATALOG);
            }
        }

        $this->response->setOutput(Json::encode($data));
    }

    public function postcategory() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/json");

        $data = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['post_categories'])) {
            $this->load->model('content/post_category');
            $this->load->library('url');
            $this->load->library('json');
            foreach ($this->request->post['post_categories'] as $key => $value) {
                $result = $this->modelPost_category->getById($value);
                if (!$result)
                    continue;
                $path = ($result['parent_id']) ? $result['parent_id'] . "_" . $result['post_category_id'] : $result['post_category_id'];

                $data[$value]['title'] = $result['title'];
                $data[$value]['href'] = Url::createUrl('content/category', array('path' => $path), 'NONSSL', HTTP_CATALOG);
            }
        }

        $this->response->setOutput(Json::encode($data));
    }

}
