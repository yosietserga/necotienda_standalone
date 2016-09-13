<?php

/**
 * ControllerModuleMercadoLibreSeller
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleMercadoLibreSeller extends Controller {

    private $error = array();

    /**
     * ControllerModuleMercadoLibreSeller::index()
     * 
     * @return
     */
    public function index() {
        $this->load->language('module/mercadolibre');
        $this->document->title = $this->data['heading_title'] = $this->language->get('heading_title');

        $this->templatePath = dirname(__FILE__);
        $this->template = '/view/status/index.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function api() {
        $this->load->moduleModel('status', dirname(__FILE__));
        if ($this->request->server['REQUEST_METHOD'] === 'POST') {
            //create or update process
            if ($this->request->hasQuery('id')) {
                //update
                $this->updateProcess();
            } else {
                //create
                $this->createProcess();
            }
        } else if ($this->request->server['REQUEST_METHOD'] === 'DELETE' ) {
            // delete
            if ($this->request->hasQuery('id')) {
                $this->deleteProcess();
            } else {
                echo 0;
            }
        } else {
            
            $filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
            $filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
            $filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
            $page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
            $sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'name';
            $order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
            $limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }
            if (isset($this->request->get['filter_date_start'])) {
                $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
            }
            if (isset($this->request->get['filter_date_end'])) {
                $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
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
                'filter_name' => $filter_name,
                'filter_date_start' => $filter_date_start,
                'filter_date_end' => $filter_date_end,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );

            $total = $this->modelStatus->getAllTotal($data);
            $results = $this->modelStatus->getAll($data);
            
            foreach ($results as $result) {
                $action = array(
                    'edit' => array(
                        'action' => 'edit',
                        'text' => $this->language->get('text_edit'),
                        'href' => Url::createAdminUrl('module/mercadolibre/status/update') . '&sale_status_id=' . $result['sale_status_id'] . $url,
                        'img' => 'edit.png'
                    ),
                    'delete' => array(
                        'action' => 'delete',
                        'text' => $this->language->get('text_delete'),
                        'href' => '',
                        'img' => 'delete.png'
                    )
                );

                $json['items'][] = array(
                    'sale_status_id' => $result['sale_status_id'],
                    'name' => $result['name'],
                    'sort_order' => $result['sort_order'],
                    'selected' => isset($this->request->post['selected']) && in_array($result['sale_status_id'], $this->request->post['selected']),
                    'action' => $action
                );
            }
            
            $this->load->library('pagination');
            $pagination = new Pagination();
            $pagination->ajax = true;
            $pagination->ajaxTarget = "gridWrapper";
            $pagination->total = $total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = Url::createAdminUrl('store/manufacturer/grid') . $url . '&page={page}';
            $json['pagination'] = $pagination->render();
            
            // get data
        }
        
        $this->load->library('json');
        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
    }

    public function create() {
        $this->load->moduleModel('status', dirname(__FILE__));
        $this->load->moduleLanguage('status', dirname(__FILE__));
        if ($this->request->server['REQUEST_METHOD'] === 'POST') {
            $id = $this->modelStatus->add($this->request->post);
            
            $this->session->set('success', $this->language->get('text_success'));

            if ($this->request->getPost('to') === "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('module/mercadolibre/status/update', array('sale_status_id' => $id)));
            } elseif ($this->request->getPost('to') === "saveAndNew") {
                $this->redirect(Url::createAdminUrl('module/mercadolibre/status/create'));
            } else {
                $this->redirect(Url::createAdminUrl('module/mercadolibre/status'));
            }
        }
        
        $this->getForm();
    }
    
    public function update() {
        $this->load->moduleModel('status', dirname(__FILE__));
        $this->load->moduleLanguage('status', dirname(__FILE__));
        if ($this->request->server['REQUEST_METHOD'] === 'POST') {
            $this->modelStatus->update($this->request->getQuery('sale_status_id'), $this->request->post);
            
            $this->session->set('success', $this->language->get('text_success'));

            if ($this->request->getPost('to') === "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('module/mercadolibre/status/update', array('sale_status_id' => $this->request->getQuery('sale_status_id'))));
            } elseif ($this->request->getPost('to') === "saveAndNew") {
                $this->redirect(Url::createAdminUrl('module/mercadolibre/status/create'));
            } else {
                $this->redirect(Url::createAdminUrl('module/mercadolibre/status'));
            }
        }
        
        $this->getForm();
    }
    
    /**
     * ControllerStoreCategory::sortable()
     * ordenar el listado actualizando la posici�n de cada objeto
     * @return boolean
     * */
    public function sortable() {
        $this->load->moduleModel('status', dirname(__FILE__));
        $result = $this->modelStatus->sort($_POST);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function read() {}
    public function delete() {}

    protected function createProcess() {}
    protected function updateProcess() {}
    protected function getData() {}
    protected function deleteProcess() {}
    
    /**
     * ControllerContentBanner::getById()
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
    public function admin() {
        $this->load->language('module/mercadolibre');

        $this->load->moduleModel('status', dirname(__FILE__));
        $this->load->moduleLanguage('status', dirname(__FILE__));

        $this->document->title = $this->data['heading_title'] = $this->language->get('heading_title');

        $this->load->auto('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->modelSetting->update('mercadolibre', $this->request->post);

            $this->session->set('success', $this->language->get('text_success'));

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('module/mercadolibre/plugin'));
            } else {
                $this->redirect(Url::createAdminUrl('extension/module'));
            }
        }

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('extension/module'),
            'text' => $this->language->get('text_module'),
            'separator' => ' :: '
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('module/mercadolibre'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );
        
        $this->templatePath = dirname(__FILE__);
        $this->template = '/view/status/list.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function grid() {
        $this->load->language('module/mercadolibre');
        $this->load->moduleModel('status', dirname(__FILE__));
        $this->load->moduleLanguage('status', dirname(__FILE__));
        $this->load->auto('setting/setting');

        $filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
        $filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
        $filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
        $page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
        $sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'name';
        $order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
        $limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }
        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }
        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
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
            'filter_name' => $filter_name,
            'filter_date_start' => $filter_date_start,
            'filter_date_end' => $filter_date_end,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        $total = $this->modelStatus->getAllTotal($data);
        if ($total) {
            $results = $this->modelStatus->getAll($data);

            foreach ($results as $result) {
                $action = array(
                    'edit' => array(
                        'action' => 'edit',
                        'text' => $this->language->get('text_edit'),
                        'href' => Url::createAdminUrl('module/mercadolibre/status/update') . '&sale_status_id=' . $result['sale_status_id'] . $url,
                        'img' => 'edit.png'
                    ),
                    'delete' => array(
                        'action' => 'delete',
                        'text' => $this->language->get('text_delete'),
                        'href' => '',
                        'img' => 'delete.png'
                    )
                );

                $this->data['statuss'][] = array(
                    'sale_status_id' => $result['sale_status_id'],
                    'name' => $result['name'],
                    'sort_order' => $result['sort_order'],
                    'selected' => isset($this->request->post['selected']) && in_array($result['sale_status_id'], $this->request->post['selected']),
                    'action' => $action
                );
            }
        }

        $this->load->library('pagination');
        $pagination = new Pagination();
        $pagination->ajax = true;
        $pagination->ajaxTarget = "gridWrapper";
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createAdminUrl('module/mercadolibre/status/grid') . $url . '&page={page}';
        $this->data['pagination'] = $pagination->render();

        $this->templatePath = dirname(__FILE__);
        $this->template = '/view/status/grid.tpl';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    protected function getForm() {
        $this->data['error_warning'] = ($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_name'] = ($this->error['name']) ? $this->error['name'] : '';

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
            'href' => Url::createAdminUrl('module/mercadolibre/status') . $url,
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        if (!$this->request->hasQuery('sale_status_id')) {
            $this->data['action'] = Url::createAdminUrl('module/mercadolibre/status/create') . $url;
        } else {
            $this->data['action'] = Url::createAdminUrl('module/mercadolibre/status/update') . '&sale_status_id=' . $this->request->getQuery('sale_status_id') . $url;
        }

        $this->data['cancel'] = Url::createAdminUrl('module/mercadolibre/status') . $url;

        if ($this->request->hasQuery('sale_status_id')) {
            $info = $this->modelStatus->getById($this->request->getQuery('sale_status_id'));
        }
        
        $this->setvar('sale_status_id', $info, '');
        $this->setvar('name', $info, '');
        
        $this->templatePath = dirname(__FILE__);
        $this->template = '/view/status/form.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }
    
    /**
     * ControllerModuleMercadoLibreSeller::validate()
     * 
     * @return
     */
    private function validate() {
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
    protected function validateCreate() {}
    protected function validateUpdate() {}
    protected function validateDelete() {}

}
