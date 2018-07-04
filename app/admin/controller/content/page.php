<?php

/**
 * ControllerContentPage
 * 
 * @package NecoTienda
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

                    if (preg_match('/data:([^;]*);base64,(.*)/', $src)) {
                        list($type, $img) = explode(",", $src);
                        $type = trim(substr($type, strpos($type, "/") + 1, 3));

                        //TODO: validar imagenes

                        $str = $this->config->get('config_name');
                        if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
                            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
                        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
                        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
                        $str = strtolower(trim($str, '-'));

                        $filename = uniqid($str . "-") . "_" . time() . "." . $type;
                        $fp = fopen(DIR_IMAGE . "data/" . $filename, 'wb');
                        fwrite($fp, base64_decode($img));
                        fclose($fp);
                        $image->setAttribute('src', HTTP_IMAGE . "data/" . $filename);
                    }
                }
                $this->request->post['page_description'][$language_id]['description'] = htmlentities($dom->saveHTML());
            }

            if (empty($this->request->post['date_publish_end'])) {
                $this->request->post['date_publish_end'] = '0000-00-00 00:00:00';
            } else {
                $dpe = explode("/", $this->request->post['date_publish_end']);
                $this->request->post['date_publish_end'] = $dpe[2] . "-" . $dpe[1] . "-" . $dpe[0] . ' 00:00:00';
            }

            $dps = explode("/", $this->request->post['date_publish_start']);
            $this->request->post['date_publish_start'] = $dps[2] . "-" . $dps[1] . "-" . $dps[0] . ' 00:00:00';

            $post_id = $this->modelPage->add($this->request->post);
            $this->modelPage->setProperty($post_id, 'customer_groups', 'customer_groups', $this->request->getPost('customer_groups'));
            $this->modelPage->setProperty($post_id, 'style', 'view', $this->request->getPost('view'));

            $this->session->set('success', $this->language->get('text_success'));

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('content/page/update', array('page_id' => $post_id)));
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
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            foreach ($this->request->post['page_description'] as $language_id => $description) {
                $dom = new DOMDocument;
                $dom->preserveWhiteSpace = false;
                $dom->loadHTML(html_entity_decode($description['description']));
                $images = $dom->getElementsByTagName('img');
                foreach ($images as $image) {
                    $src = $image->getAttribute('src');

                    if (preg_match('/data:([^;]*);base64,(.*)/', $src)) {
                        list($type, $img) = explode(",", $src);
                        $type = trim(substr($type, strpos($type, "/") + 1, 3));

                        //TODO: validar imagenes

                        $str = $this->config->get('config_name');
                        if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
                            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
                        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
                        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
                        $str = strtolower(trim($str, '-'));

                        $filename = uniqid($str . "-") . "_" . time() . "." . $type;
                        $fp = fopen(DIR_IMAGE . "data/" . $filename, 'wb');
                        fwrite($fp, base64_decode($img));
                        fclose($fp);
                        $image->setAttribute('src', HTTP_IMAGE . "data/" . $filename);
                    }
                }
                $this->request->post['page_description'][$language_id]['description'] = htmlentities($dom->saveHTML());
            }

            if (empty($this->request->post['date_publish_end'])) {
                $this->request->post['date_publish_end'] = '0000-00-00 00:00:00';
            } else {
                $dpe = explode("/", $this->request->post['date_publish_end']);
                $this->request->post['date_publish_end'] = $dpe[2] . "-" . $dpe[1] . "-" . $dpe[0] . ' 00:00:00';
            }

            $dps = explode("/", $this->request->post['date_publish_start']);
            $this->request->post['date_publish_start'] = $dps[2] . "-" . $dps[1] . "-" . $dps[0] . ' 00:00:00';

            $this->modelPage->update($this->request->getQuery('page_id'), $this->request->post);
            $this->modelPage->setProperty($this->request->getQuery('page_id'), 'customer_groups', 'customer_groups', $this->request->getPost('customer_groups'));
            $this->modelPage->setProperty($this->request->getQuery('page_id'), 'style', 'view', $this->request->getPost('view'));

            $this->session->set('success', $this->language->get('text_success'));

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('content/page/update', array('page_id' => $this->request->getQuery('page_id'))));
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('content/page/insert'));
            } else {
                $this->redirect(Url::createAdminUrl('content/page'));
            }
        }

        $this->getForm();
    }

    /**
     * ControllerMarketingNewsletter::delete()
     * elimina un objeto
     * @return boolean
     * */
    public function delete() {
        $this->load->auto('content/page');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelPage->delete($id);
            }
        } else {
            $this->modelPage->delete($_GET['id']);
        }
    }

    /**
     * ControllerMarketingNewsletter::copy()
     * duplicar un objeto
     * @return boolean
     */
    public function copy() {
        $this->load->auto('content/page');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelPage->copy($id);
            }
        } else {
            $this->modelPage->copy($_GET['id']);
        }
        echo 1;
    }

    /**
     * ControllerContentPage::getById()
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
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('content/page') . $url,
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->data['insert'] = Url::createAdminUrl('content/page/insert') . $url;
        $this->data['delete'] = Url::createAdminUrl('content/page/delete') . $url;

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

        $scripts[] = array('id' => 'pageList', 'method' => 'function', 'script' =>
            "function activate(e) {    
            	$.ajax({
            	   'type':'get',
                   'dataType':'json',
                   'url':'" . Url::createAdminUrl("content/page/activate") . "&id=' + e,
                   'success': function(data) {
                        if (data > 0) {
                            $(\"#img_\" + e).attr('src','image/good.png');
                        } else {
                            $(\"#img_\" + e).attr('src','image/minus.png');
                        }
                   }
            	});
             }
            function copy(e) {
                $('#gridWrapper').hide();
                $('#gridPreloader').show();
                $.getJSON('" . Url::createAdminUrl("content/page/copy") . "&id=' + e, function(data) {
                    $('#gridWrapper').load('" . Url::createAdminUrl("content/page/grid") . "',function(response){
                        $('#gridPreloader').hide();
                        $('#gridWrapper').show();
                    });
                });
            }
            function eliminar(e) {
                if (confirm('\\xbfDesea eliminar este objeto?')) {
                    $('#tr_' + e).remove();
                	$.getJSON('" . Url::createAdminUrl("content/page/delete") . "',{
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
            function copyAll() {
                $('#gridWrapper').hide();
                $('#gridPreloader').show();
                $.post('" . Url::createAdminUrl("content/page/copy") . "',$('#form').serialize(),function(){
                    $('#gridWrapper').load('" . Url::createAdminUrl("content/page/grid") . "',function(){
                        $('#gridWrapper').show();
                        $('#gridPreloader').hide();
                    });
                });
                return false;
            } 
            function deleteAll() {
                if (confirm('\\xbfDesea eliminar todos los objetos seleccionados?')) {
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                    $.post('" . Url::createAdminUrl("content/page/delete") . "',$('#form').serialize(),function(){
                        $('#gridWrapper').load('" . Url::createAdminUrl("content/page/grid") . "',function(){
                            $('#gridWrapper').show();
                            $('#gridPreloader').hide();
                        });
                    });
                }
                return false;
            }");
        $scripts[] = array('id' => 'sortable', 'method' => 'ready', 'script' =>
            "$('#gridWrapper').load('" . Url::createAdminUrl("content/page/grid") . "',function(e){
                $('#gridPreloader').hide();
                $('#list tbody').sortable({
                    opacity: 0.6, 
                    cursor: 'move',
                    handle: '.move',
                    update: function() {
                        $.ajax({
                            'type':'post',
                            'dateType':'json',
                            'url':'" . Url::createAdminUrl("content/page/sortable") . "',
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
                url:'" . Url::createAdminUrl("content/page/grid") . "',
                beforeSend:function(){
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                },
                success:function(data){
                    $('#gridPreloader').hide();
                    $('#gridWrapper').html(data).show();
                }
            });
            $('#formFilter').on('keyup', function(e){
                var code = e.keyCode || e.which;
                if (code == 13){
                    $('#formFilter').ntForm('submit');
                }
            });");

        $this->scripts = array_merge($this->scripts, $scripts);

        $template = ($this->config->get('default_admin_view_page_list')) ? $this->config->get('default_admin_view_page_list') : 'content/page_list.tpl';
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

    public function getPages() {
        $this->load->auto('content/page');
        $this->load->auto('json');
        $this->response->setOutput(Json::encode($this->modelPage->getAll()), $this->config->get('config_compression'));
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

        $search_in_description = $this->request->hasQuery('search_in_description') ? $this->request->getQuery('search_in_description') : null;
        $title = $this->request->hasQuery('title') ? $this->request->getQuery('title') : null;
        $parent = $this->request->hasQuery('parent') ? $this->request->getQuery('parent') : null;
        $status = $this->request->hasQuery('status') ? $this->request->getQuery('status') : null;
        $date_start = $this->request->hasQuery('date_start') ? $this->request->getQuery('date_start') : null;
        $date_end = $this->request->hasQuery('date_end') ? $this->request->getQuery('date_end') : null;
        $publish_date_start = $this->request->hasQuery('publish_date_start') ? $this->request->getQuery('publish_date_start') : null;
        $publish_date_end = $this->request->hasQuery('publish_date_end') ? $this->request->getQuery('publish_date_end') : null;
        $page = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
        $sort = $this->request->hasQuery('sort') ? $this->request->getQuery('sort') : 'title';
        $order = $this->request->hasQuery('order') ? $this->request->getQuery('order') : 'ASC';
        $limit = !empty($this->request->get['limit']) ? $this->request->getQuery('limit') : $this->config->get('config_admin_limit');

        $queries = explode(' ', strtolower($title));

        $url = '';

        if (isset($this->request->get['title'])) {
            $url .= '&title=' . $this->request->get['title'];
        }
        if (isset($this->request->get['parent'])) {
            $url .= '&parent=' . $this->request->get['parent'];
        }
        if (isset($this->request->get['status'])) {
            $url .= '&status=' . $this->request->get['status'];
        }
        if (isset($this->request->get['date_start'])) {
            $url .= '&date_start=' . $this->request->get['date_start'];
        }
        if (isset($this->request->get['date_end'])) {
            $url .= '&date_end=' . $this->request->get['date_end'];
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
        if (!empty($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

        $this->data['pages'] = array();

        $filters = array(
            'language_id'=>$this->config->get('config_language_id'),
            'queries' => $queries,
            'search_in_description' => $search_in_description,
            'title' => $title,
            'parent' => $parent,
            'status' => $status,
            'publish_date_start' => $publish_date_start,
            'publish_date_end' => $publish_date_end,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        $page_total = $this->modelPage->getAllTotal($filters);

        $results = $this->modelPage->getAll($filters);

        $i = str_replace('%theme%',$this->config->get('config_admin_template'),HTTP_ADMIN_THEME_IMAGE);
        foreach ($results as $result) {

            $action = array(
                'activate' => array(
                    'action' => 'activate',
                    'text' => $this->language->get('text_activate'),
                    'href' => '',
                    'img' => $i.'good.png'
                ),
                'edit' => array(
                    'action' => 'edit',
                    'text' => $this->language->get('text_edit'),
                    'href' => Url::createAdminUrl('content/page/update') . '&page_id=' . $result['post_id'] . $url,
                    'img' =>  $i.'edit.png'
                ),
                'delete' => array(
                    'action' => 'delete',
                    'text' => $this->language->get('text_delete'),
                    'href' => '',
                    'img' => $i.'delete.png'
                )
            );

            $this->data['pages'][] = array(
                'page_id' => $result['post_id'],
                'title' => $result['title'],
                'status' => $result['status'],
                'publish' => ($result['publish']) ? $this->language->get('text_yes') : $this->language->get('text_no'),
                'date_publish_start' => date('d-m-Y h:i', strtotime($result['date_publish_start'])),
                'date_publish_end' => date('d-m-Y h:i', strtotime($result['date_publish_end'])),
                'sort_order' => $result['sort_order'],
                'selected' => isset($this->request->post['selected']) && in_array($result['page_id'], $this->request->post['selected']),
                'action' => $action
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

        $template = ($this->config->get('default_admin_view_page_grid')) ? $this->config->get('default_admin_view_page_grid') : 'content/page_grid.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_admin_template') . '/'. $template)) {
            $this->template = $this->config->get('config_admin_template') . '/' . $template;
        } else {
            $this->template = 'default/' . $template;
        }

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
        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_title'] = isset($this->error['title']) ? $this->error['title'] : '';
        $this->data['error_description'] = isset($this->error['description']) ? $this->error['description'] : '';

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
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('content/page') . $url,
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        if (!$this->request->hasQuery('page_id')) {
            $this->data['action'] = Url::createAdminUrl('content/page/insert') . $url;
        } else {
            $this->data['action'] = Url::createAdminUrl('content/page/update') . '&page_id=' . $this->request->getQuery('page_id') . $url;
        }

        $this->data['cancel'] = Url::createAdminUrl('content/page') . $url;

        if ($this->request->hasQuery('page_id') && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $page_info = $this->modelPage->getById($this->request->getQuery('page_id'));
        }

        $this->setvar('post_id', $page_info, '');
        $this->setvar('parent_id', $page_info, '');
        $this->setvar('allow_reviews', $page_info, 1);
        $this->setvar('publish', $page_info, 1);
        $this->setvar('image', $page_info, '');

        $this->data['languages'] = $this->modelLanguage->getAll();
        $this->data['pages'] = $this->modelPage->getAll();
        $this->data['stores'] = $this->modelStore->getAll();
        $this->data['_stores'] = $this->modelPage->getStores($this->request->getQuery('page_id'));
        $this->data['customerGroups'] = $this->modelCustomergroup->getAll();
        $this->data['customer_groups'] = $this->modelPage->getProperty($this->request->getQuery('page_id'), 'customer_groups', 'customer_groups');
        $this->data['layout'] = $this->modelPage->getProperty($this->request->getQuery('page_id'), 'style', 'view');

        if (!empty($page_info['image']) && file_exists(DIR_IMAGE . $page_info['image'])) {
            $this->data['preview'] = NTImage::resizeAndSave($page_info['image'], 100, 100);
        } else {
            $this->data['preview'] = NTImage::resizeAndSave('no_image.jpg', 100, 100);
        }

        if (file_exists(DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/common/home.tpl')) {
            $folderTPL = DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/';
        } else {
            $folderTPL = DIR_CATALOG . 'view/theme/default/';
        }

        $directories = glob($folderTPL . "*", GLOB_ONLYDIR);
        $this->data['templates'] = array();
        foreach ($directories as $key => $directory) {
            $this->data['views'][$key]['folder'] = basename($directory);
            $files = glob($directory . "/*.tpl", GLOB_NOSORT);
            foreach ($files as $k => $file) {
                $this->data['views'][$key]['files'][$k] = str_replace("\\", "/", $file);
            }
        }

        if (isset($this->request->post['page_description'])) {
            $this->data['page_description'] = $this->request->post['page_description'];
        } elseif ($this->request->hasQuery('page_id')) {
            $this->data['page_description'] = $this->modelPage->getDescriptions($this->request->getQuery('page_id'));
        } else {
            $this->data['page_description'] = array();
        }

        if (isset($this->request->post['date_publish_start'])) {
            $this->data['date_publish_start'] = date('d-m-Y', strtotime($this->request->post['date_publish_start']));
        } elseif (isset($page_info['date_publish_start']) && $page_info['date_publish_start'] != '0000-00-00 00:00:00') {
            $this->data['date_publish_start'] = date('d-m-Y', strtotime($page_info['date_publish_start']));
        } else {
            $this->data['date_publish_start'] = date('d-m-Y');
        }

        if (isset($this->request->post['date_publish_end'])) {
            $this->data['date_publish_end'] = date('d-m-Y', strtotime($this->request->post['date_publish_end']));
        } elseif (isset($page_info['date_publish_end']) && $page_info['date_publish_end'] != '0000-00-00 00:00:00') {
            $this->data['date_publish_end'] = date('d-m-Y', strtotime($page_info['date_publish_end']));
        } else {
            $this->data['date_publish_end'] = '';
        }

        $scripts[] = array('id' => 'pageForm', 'method' => 'ready', 'script' =>
            "$('#q').on('change',function(e){
                var that = this;
                var valor = $(that).val().toLowerCase();
                if (valor.length <= 0) {
                    $('#customerGroupsWrapper li').show();
                } else {
                    $('#customerGroupsWrapper li b').each(function(){
                        if ($(this).text().toLowerCase().indexOf( valor ) != -1) {
                            $(this).closest('li').show();
                        } else {
                            $(this).closest('li').hide();
                        }
                    });
                }
            });");

        foreach ($this->data['languages'] as $language) {
            $code = "var editor" . $language["language_id"] . " = CKEDITOR.replace('description" . $language["language_id"] . "', {"
                    . "filebrowserBrowseUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserImageBrowseUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserFlashBrowseUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserUploadUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserImageUploadUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "filebrowserFlashUploadUrl: '" . Url::createAdminUrl("common/filemanager") . "',"
                    . "height:600"
                . "});"
                . "editor". $language["language_id"] .".products = '". $json['products'] ."';"
                . "editor". $language["language_id"] .".config.allowedContent = true;";
            $cssrules = "assets/theme/". ($this->config->get('config_template') ? $this->config->get('config_template') : 'choroni') ."/css/theme.css";
            if (file_exists(DIR_ROOT . $cssrules)) {
                $code .= "editor". $language["language_id"] .".config.contentsCss = '". HTTP_CATALOG . $cssrules ."';";
            }
            $code .= "$('#description_" . $language["language_id"] . "_title').change(function(e){"
                    . "$.getJSON('" . Url::createAdminUrl('common/home/slug') . "',"
                    . "{"
                        . "slug : $(this).val(),"
                        . "query : 'page_id=" . $this->request->getQuery('page_id') . "',"
                    . "},"
                    . "function(data){"
                        . "$('#description_" . $language["language_id"] . "_keyword').val(data.slug);"
                    . "});"
                . "});";
            $scripts[] = array('id' => 'pageLanguage' . $language["language_id"], 'method' => 'ready', 'script' => $code );
                
        }

        $this->scripts = array_merge($this->scripts, $scripts);

        $template = ($this->config->get('default_admin_view_page_form')) ? $this->config->get('default_admin_view_page_form') : 'content/page_form.tpl';
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
        if (!isset($_GET['id']))
            return false;
        $this->load->auto('content/page');
        $status = $this->modelPage->getById($_GET['id']);
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
        if (!isset($_GET['id']))
            return false;
        $this->load->auto('content/page');
        $result = $this->modelPage->getById($_GET['id']);
        if ($result) {
            $this->modelPage->deletePage($_GET['id']);
            echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * ControllerContentPage::sortable()
     * ordenar el listado actualizando la posici�n de cada objeto
     * @return boolean
     * */
    public function sortable() {
        if (!isset($_POST['tr']))
            return false;
        $this->load->auto('content/page');
        $result = $this->modelPage->sortPage($_POST['tr']);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
