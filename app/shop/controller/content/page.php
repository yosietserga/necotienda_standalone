<?php

class ControllerContentPage extends Controller {
    
    public function index() {
        $this->language->load('content/page');
        $this->load->model('content/page');

        $Url = new Url($this->registry);

        $cacheId = 'html-page.' .
            $this->request->getQuery('page_id') .
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int) $this->config->get('config_store_id');

        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => $Url::createUrl("common/home"),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        if (isset($this->request->get['page_id'])) {
            $path = '';
            $parts = explode('_', $this->request->get['page_id']);
            foreach ($parts as $id) {
                $page_info = $this->modelPage->getById($id);
                if ($page_info) {
                    if (!$path) {
                        $path = $id;
                    } else {
                        $path .= '_' . $id;
                    }

                    $this->document->breadcrumbs[] = array(
                        'href' => $Url::createUrl('content/page', array('page_id' => $path)),
                        'text' => $page_info['name'],
                        'separator' => $this->language->get('text_separator')
                    );
                }
            }
            $page_id = array_pop($parts);
        } else {
            $page_id = 0;
        }

        $this->request->get['page_id'] = $page_id;

        $this->session->clear('object_type');
        $this->session->clear('object_id');
        $this->session->clear('landing_page');
        $this->session->set('object_type', 'page');
        $this->session->set('object_id', $page_id);

        $this->session->set('redirect', $Url::createUrl('content/page', array('page_id' => $page_id)));

        $page_info = $this->modelPage->getById($page_id);

        if ($page_info) {
            //tracker
            $this->tracker->track($page_info['post_id'], 'page');

            if ($this->session->has('ref_email') && !$this->session->has('ref_cid')) {
                $this->data['show_register_form_invitation'] = true;
            }

            $this->session->set('redirect', $Url::createUrl('content/page', array('page_id' => $page_id)));

            $customerGroups = $this->modelPage->getProperty($page_id, 'customer_groups', 'customer_groups');
            if (($this->customer->isLogged() && in_array($this->customer->getCustomerGroupId(), $customerGroups)) || in_array(0, $customerGroups)) {
                $cached = $this->cache->get($cacheId);
                $this->load->library('user');
                if ($cached && !$this->user->isLogged()) {
                    $this->response->setOutput($cached, $this->config->get('config_compression'));
                } else {
                    $this->document->title = $page_info['title'];

                    $this->document->breadcrumbs[] = array(
                        'href' => $Url::createUrl("content/page") . '&page_id=' . $this->request->get['page_id'],
                        'text' => $page_info['title'],
                        'separator' => $this->language->get('text_separator')
                    );

                    $this->data['breadcrumbs'] = $this->document->breadcrumbs;

                    $this->session->set('landing_page','content/page');
                    $this->loadWidgets('featuredContent');
                    $this->loadWidgets('main');
                    $this->loadWidgets('featuredFooter');

                    $this->addChild('common/column_left');
                    $this->addChild('common/column_right');
                    $this->addChild('common/footer');
                    $this->addChild('common/header');

                    $template = $this->modelPage->getProperty($page_id, 'style', 'view');
                    $default_template = ($this->config->get('default_view_page')) ? $this->config->get('default_view_page') : 'content/page.tpl';
                    $template = empty($template) ? $default_template : $template;
                    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
                        $this->template = $this->config->get('config_template') . '/' . $template;
                    } else {
                        $this->template = 'cuyagua/' . $template;
                    }

                    if (!$this->user->isLogged()) {
                        $this->cacheId = $cacheId;
                    }

                    $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
                }
            } else {
                $this->error404();
            }
        } else {
            $this->error404();
        }
    }

    protected function error404() {
        $Url = new Url($this->registry);

        $this->document->breadcrumbs[] = array(
            'href' => $Url::createUrl("content/page") . '&page_id=' . $this->request->getQuery('page_id'),
            'text' => $this->language->get('text_error'),
            'separator' => $this->language->get('text_separator')
        );
        $this->data['breadcrumbs'] = $this->document->breadcrumbs;
        $this->document->title = $this->language->get('text_error');

        $this->data['heading_title'] = $this->language->get('text_error');

        $this->data['text_error'] = $this->language->get('text_error');

        $this->session->set('landing_page','content/page');
        $this->loadWidgets('featuredContent');
        $this->loadWidgets('main');
        $this->loadWidgets('featuredFooter');

        $this->addChild('common/column_left');
        $this->addChild('common/column_right');
        $this->addChild('common/footer');
        $this->addChild('common/header');

        $template = ($this->config->get('default_view_page_error')) ? $this->config->get('default_view_page_error') : 'error/not_found.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
            $this->template = $this->config->get('config_template') . '/' . $template;
        } else {
            $this->template = 'cuyagua/' . $template;
        }

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }
}
