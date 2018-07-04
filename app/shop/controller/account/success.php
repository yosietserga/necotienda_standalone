<?php

class ControllerAccountSuccess extends Controller {

    public function index() {
        $this->session->clear('object_type');
        $this->session->clear('object_id');
        $this->session->clear('landing_page');

        $Url = new Url($this->registry);
        $this->language->load('account/success');

        $this->document->title = $this->language->get('heading_title');

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href' => $Url::createUrl("common/home"),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => $Url::createUrl("account/account"),
            'text' => $this->language->get('text_account'),
            'separator' => $this->language->get('text_separator')
        );

        $this->document->breadcrumbs[] = array(
            'href' => $Url::createUrl("account/success"),
            'text' => $this->language->get('text_success'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        if ($this->config->get('marketing_page_new_customer')) {
            $this->load->model("marketing/newsletter");

            if ($this->config->get('config_customer_approval')) {
                $result = $this->modelNewsletter->getById($this->config->get('marketing_page_new_customer'));
            } else {
                $result = $this->modelNewsletter->getById($this->config->get('marketing_page_activate_customer'));
            }
            $this->data['text_message'] = $result['htmlbody'];
        } else {
            if (!$this->config->get('config_customer_approval')) {
                $this->data['text_message'] = sprintf($this->language->get('text_message'), Url::createUrl("page/contact"));
            } else {
                $this->data['text_message'] = sprintf($this->language->get('text_approval'), $this->config->get('config_name'), Url::createUrl("page/contact"));
            }
        }

        $this->data['button_continue'] = $this->language->get('button_continue');

        if ($this->cart->hasProducts()) {
            $this->data['continue'] = Url::createUrl("checkout/cart");
        } else {
            $this->data['continue'] = Url::createUrl("account/account");
        }

        

        $this->session->set('landing_page','account/success');
        $this->loadWidgets('featuredContent');
        $this->loadWidgets('main');
        $this->loadWidgets('featuredFooter');

        $this->addChild('common/column_left');
        $this->addChild('common/column_right');
        $this->addChild('common/footer');
        $this->addChild('common/header');


        $template = ($this->config->get('default_view_account_success')) ? $this->config->get('default_view_account_success') : 'common/success.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
            $this->template = $this->config->get('config_template') . '/' . $template;
        } else {
            $this->template = 'cuyagua/' . $template;
        }

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

}
