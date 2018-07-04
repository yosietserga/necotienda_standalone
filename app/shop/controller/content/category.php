<?php

class ControllerContentCategory extends Controller {

    public function index() {
        $this->language->load('content/category');
        $this->load->model('content/category');
        $this->load->model('content/post');

        $Url = new Url($this->registry);

        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => $Url::createUrl("common/home"),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );
        $this->document->breadcrumbs[] = array(
            'href' => $Url::createUrl("content/category"),
            'text' => $this->language->get('text_posts'),
            'separator' => false
        );

        $this->document->title = $this->language->get('heading_title') . " - " . $this->config->get('config_title');
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->setvar('post_category_id', null, 0);
        if ($this->data['post_category_id']) {
            $category_info = $this->modelCategory->getById($this->data['post_category_id']);
        }

        $this->session->clear('object_type');
        $this->session->clear('object_id');
        $this->session->set('object_type', 'post_category');
        $this->session->set('object_id', $this->data['post_category_id']);
        $this->session->clear('landing_page');

        if ($category_info) {
            //tracker
            $this->tracker->track($category_info['post_category_id'], 'post_category');

            if ($this->session->has('ref_email') && !$this->session->has('ref_cid')) {
                $this->data['show_register_form_invitation'] = true;
            }

            $this->request->get['post_category_id'] = $this->data['post_category_id'];

            $this->document->title = $category_info['seo_title'];
            $this->document->description = $category_info['meta_description'];
            $this->document->keywords = $category_info['meta_keywords'];

            $this->document->breadcrumbs[] = array(
                'href' => $Url::createUrl("content/category") . '&post_category_id=' . $this->request->get['post_category_id'],
                'text' => $category_info['title'],
                'separator' => $this->language->get('text_separator')
            );

            $this->data['breadcrumbs'] = $this->document->breadcrumbs;
            $this->data['heading_title'] = $category_info['title'];
            $this->data['description'] = html_entity_decode($category_info['description']);
            $this->data['keywords'] = explode(";", $category_info['meta_keywords']);
        }

        $this->session->set('landing_page','content/category');
        $this->loadWidgets('featuredContent');
        $this->loadWidgets('main');
        $this->loadWidgets('featuredFooter');

        $this->addChild('common/column_left');
        $this->addChild('common/column_right');
        $this->addChild('common/footer');
        $this->addChild('common/header');

        $template = $this->modelCategory->getProperty($this->data['post_category_id'], 'style', 'view');
        $default_template = ($this->config->get('default_view_post_category')) ? $this->config->get('default_view_post_category') : 'content/category.tpl';
        $template = empty($template) ? $default_template : $template;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
            $this->template = $this->config->get('config_template') . '/' . $template;
        } else {
            $this->template = 'cuyagua/' . $template;
        }

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }
}
