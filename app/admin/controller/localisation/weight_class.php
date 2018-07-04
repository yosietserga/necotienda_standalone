<?php

class ControllerLocalisationWeightClass extends Controller {

    private $error = array();

    public function index() {
        $this->document->title = $this->language->get('heading_title');
        $this->getList();
    }

    public function insert() {
        $this->document->title = $this->language->get('heading_title');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $weight_class_id = $this->modelWeightclass->add($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page']))
                $url .= '&page=' . $this->request->get['page'];
            if (isset($this->request->get['sort']))
                $url .= '&sort=' . $this->request->get['sort'];
            if (isset($this->request->get['order']))
                $url .= '&order=' . $this->request->get['order'];

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('localisation/weight_class/update', array('weight_class_id' => $weight_class_id)));
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('localisation/weight_class/insert'));
            } else {
                $this->redirect(Url::createAdminUrl('localisation/weight_class'));
            }
        }

        $this->getForm();
    }

    public function update() {
        $this->document->title = $this->language->get('heading_title');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->modelWeightclass->update($this->request->get['weight_class_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page']))
                $url .= '&page=' . $this->request->get['page'];
            if (isset($this->request->get['sort']))
                $url .= '&sort=' . $this->request->get['sort'];
            if (isset($this->request->get['order']))
                $url .= '&order=' . $this->request->get['order'];

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('localisation/weight_class/update', array('weight_class_id' => $this->request->get['weight_class_id'])));
            } elseif ($_POST['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('localisation/weight_class/insert'));
            } else {
                $this->redirect(Url::createAdminUrl('localisation/weight_class'));
            }
        }

        $this->getForm();
    }

    public function delete() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelWeightclass->delete($id);
            }
        } else {
            $this->modelWeightclass->delete($_GET['id']);
        }
    }

    private function getList() {
        $filter_title = isset($this->request->get['filter_title']) ? $this->request->get['filter_title'] : null;
        $page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
        $sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'title';
        $order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
        $limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
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

        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => FALSE
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('localisation/weight_class'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->data['insert'] = Url::createAdminUrl('localisation/weight_class/insert') . $url;
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        // SCRIPTS        
        $scripts[] = array('id' => 'weight_classList', 'method' => 'function', 'script' =>
            "function activate(e) {    
            	$.ajax({
            	   'type':'get',
                   'dataType':'json',
                   'url':'" . Url::createAdminUrl("localisation/weight_class/activate") . "&id=' + e,
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
                	$.getJSON('" . Url::createAdminUrl("localisation/weight_class/delete") . "',{
                        id:e
                    });
                }
                return false;
             }
            function deleteAll() {
                if (confirm('\\xbfDesea eliminar todos los objetos seleccionados?')) {
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                    $.post('" . Url::createAdminUrl("localisation/weight_class/delete") . "',$('#form').serialize(),function(){
                        $('#gridWrapper').load('" . Url::createAdminUrl("localisation/weight_class/grid") . "',function(){
                            $('#gridWrapper').show();
                            $('#gridPreloader').hide();
                        });
                    });
                }
                return false;
            }");
        $scripts[] = array('id' => 'sortable', 'method' => 'ready', 'script' =>
            "$('#gridWrapper').load('" . Url::createAdminUrl("localisation/weight_class/grid") . "',function(e){
                $('#gridPreloader').hide();
            });
                
            $('#formFilter').ntForm({
                lockButton:false,
                ajax:true,
                type:'get',
                dataType:'html',
                url:'" . Url::createAdminUrl("localisation/weight_class/grid") . "',
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

        $template = ($this->config->get('default_admin_view_weight_class_list')) ? $this->config->get('default_admin_view_weight_class_list') : 'localisation/weight_class_list.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_admin_template') . '/'. $template)) {
            $this->template = $this->config->get('config_admin_template') . '/' . $template;
        } else {
            $this->template = 'default/' . $template;
        }

        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    public function grid() {
        $filter_title = isset($this->request->get['filter_title']) ? $this->request->get['filter_title'] : null;
        $page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
        $sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'name';
        $order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
        $limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');

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
        if (!empty($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

        $data = array(
            'filter_title' => $filter_title,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        $this->data['weight_classes'] = array();

        $weight_class_total = $this->modelWeightclass->getAllTotal();
        if ($weight_class_total) {
            $results = $this->modelWeightclass->getAll($data);

            $i = str_replace('%theme%',$this->config->get('config_admin_template'),HTTP_ADMIN_THEME_IMAGE);
            foreach ($results as $result) {
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
                        'href' => Url::createAdminUrl('localisation/weight_class/update') . '&weight_class_id=' . $result['weight_class_id'] . $url,
                        'img' =>  $i .'edit.png'
                    ),
                    'delete' => array(
                        'action' => 'delete',
                        'text' => $this->language->get('text_delete'),
                        'href' => '',
                        'img' => $i .'delete.png'
                    )
                );

                $this->data['weight_classes'][] = array(
                    'weight_class_id' => $result['weight_class_id'],
                    'title' => $result['title'] . (($result['description'] == $this->config->get('config_weight_class')) ? $this->language->get('text_default') : ''),
                    'description' => $result['description'],
                    'value' => $result['value'],
                    'selected' => isset($this->request->post['selected']) && in_array($result['weight_class_id'], $this->request->post['selected']),
                    'action' => $action
                );
            }
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $url = '';

        $url .= ($order == 'ASC') ? '&order=DESC' : '&order=ASC';
        if (isset($this->request->get['page']))
            $url .= '&page=' . $this->request->get['page'];

        $this->data['sort_title'] = Url::createAdminUrl('localisation/weight_class/grid') . '&sort=title' . $url;
        $this->data['sort_description'] = Url::createAdminUrl('localisation/weight_class/grid') . '&sort=description' . $url;
        $this->data['sort_value'] = Url::createAdminUrl('localisation/weight_class/grid') . '&sort=value' . $url;

        $url = '';

        if (isset($this->request->get['sort']))
            $url .= '&sort=' . $this->request->get['sort'];
        if (isset($this->request->get['order']))
            $url .= '&order=' . $this->request->get['order'];

        $pagination = new Pagination();
        $pagination->total = $weight_class_total;
        $pagination->page = $page;
        $pagination->ajax = 'true';
        $pagination->ajaxTarget = 'gridWrapper';
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createAdminUrl('localisation/weight_class/grid') . $url . '&page={page}';

        $this->data['pagination'] = $pagination->render();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $template = ($this->config->get('default_admin_view_weight_class_grid')) ? $this->config->get('default_admin_view_weight_class_grid') : 'localisation/weight_class_grid.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_admin_template') . '/'. $template)) {
            $this->template = $this->config->get('config_admin_template') . '/' . $template;
        } else {
            $this->template = 'default/' . $template;
        }

        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    private function getForm() {
        $this->data['heading_title'] = $this->language->get('heading_title');

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
            'href' => Url::createAdminUrl('localisation/weight_class') . $url,
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        if (!isset($this->request->get['currency_id'])) {
            $this->data['action'] = Url::createAdminUrl('localisation/weight_class/insert') . $url;
        } else {
            $this->data['action'] = Url::createAdminUrl('localisation/weight_class/update') . '&weight_class_id=' . $this->request->get['weight_class_id'] . $url;
        }

        $this->data['cancel'] = Url::createAdminUrl('localisation/weight_class') . $url;

        if (isset($this->request->get['weight_class_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $weight_class_info = $this->modelWeightclass->getById($this->request->get['weight_class_id']);
        }

        $this->data['languages'] = $this->modelLanguage->getAll();

        if (isset($this->request->post['weight_class_description'])) {
            $this->data['weight_class_description'] = $this->request->post['weight_class'];
        } elseif (isset($this->request->get['weight_class_id'])) {
            $this->data['weight_class_description'] = $this->modelWeightclass->getDescriptions($this->request->get['weight_class_id']);
        } else {
            $this->data['weight_class_description'] = array();
        }

        $this->setvar('value', $weight_class_info, '');

        $template = ($this->config->get('default_admin_view_weight_class_form')) ? $this->config->get('default_admin_view_weight_class_form') : 'localisation/weight_class_form.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_admin_template') . '/'. $template)) {
            $this->template = $this->config->get('config_admin_template') . '/' . $template;
        } else {
            $this->template = 'default/' . $template;
        }

        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'localisation/weight_class')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['weight_class_description'] as $language_id => $value) {
            if ((strlen(utf8_decode($value['title'])) < 3) || (strlen(utf8_decode($value['title'])) > 32)) {
                $this->error['title'][$language_id] = $this->language->get('error_title');
            }

            if ((!$value['description']) || (strlen(utf8_decode($value['description'])) > 4)) {
                $this->error['description'][$language_id] = $this->language->get('error_description');
            }
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'localisation/weight_class')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $this->load->model('catalog/product');

        foreach ($this->request->post['selected'] as $weight_class_id) {
            $weight_class_info = $this->modelWeightclass->getById($weight_class_id);

            if ($weight_class_info && ($this->config->get('config_weight_class') == $weight_class_info['description'])) {
                $this->error['warning'] = $this->language->get('error_default');
            }

            $product_total = $this->model_catalog_product->getAllTotalByWeightClassId($weight_class_id);

            if ($product_total) {
                $this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
            }
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>