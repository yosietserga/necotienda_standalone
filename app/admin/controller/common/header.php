<?php

class ControllerCommonHeader extends Controller {

    /**
     * ControllerCommonHeader::index()
     * 
     * @return
     */
    protected function index() {
        if ($this->request->hasQuery('hl')) {
            $this->session->set('language', $this->request->getQuery('hl'));
            if ($this->session->has('redirect')) {
                $this->redirect($this->session->get('redirect'));
            } else {
                $this->redirect(Url::createAdminUrl('common/home'));
            }
        }
        
        $this->load->language('common/header');
        $this->data['title'] = $this->document->title . " | NecoTienda";
        $this->data['breadcrumbs'] = $this->document->breadcrumbs;
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->load->library('browser');
        $browser = new Browser;
        if ($browser->getBrowser() == 'Internet Explorer' && $browser->getVersion() <= 8) {
            $this->redirect(Url::createUrl("page/deprecated", null, 'NONSSL', HTTP_CATALOG));
        }

        if (!$this->user->validSession()) {
            $this->data['logged'] = '';
            $this->data['home'] = Url::createAdminUrl('common/login');
        } else {
            $this->data['logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());

            if ($this->session->has('success')) {
                $this->data['success'] = $this->session->get('success');
                $this->session->clear('success');
            }

            if ($this->session->has('error')) {
                $this->data['error'] = $this->session->get('error');
                $this->session->clear('error');
            }

            $this->load->auto("setting/store");
            $this->data['stores'] = $this->modelStore->getAll();
        }
        
        $this->loadCss();
        
        $this->id = 'header';
        $this->template = 'common/header.tpl';

        $this->render();
    }

    protected function loadCss() {
        $csspath = defined("CDN_CSS") ? CDN_CSS : HTTP_ADMIN_CSS;
        
        $styles[] = array('media' => 'all', 'href' => $csspath . 'jquery-ui.min.css');
        $styles[] = array('media' => 'all', 'href' => $csspath . 'vendor/jquery.chosen/chosen.min.css');
        $styles[] = array('media' => 'all', 'href' => $csspath . 'vendor/jquery.sidr.dark.css');
        $styles[] = array('media' => 'all', 'href' => $csspath . 'vendor/font-awesome.min.css');
        $styles[] = array('media' => 'all', 'href' => $csspath . 'neco.form.css');
        $styles[] = array('media' => 'all', 'href' => $csspath . 'main.css');
        
        $this->data['css'] = "";
        if (file_exists(DIR_ADMIN_CSS . 'vendor.css')) {
            $this->data['css'] .= file_get_contents($csspath . 'vendor.css');
        }
        if (file_exists(DIR_ADMIN_CSS . 'theme.css')) {
            $this->data['css'] .= file_get_contents($csspath . 'theme.css');
        }
        foreach ($this->styles as $css) {
            $this->data['css'] .= file_get_contents($css['href']);
        }

        if (file_exists(DIR_ADMIN_CSS . str_replace('controller', '', strtolower($this->ClassName) . '.css'))) {
            $styles[] = array('media' => 'all', 'href' => HTTP_ADMIN_CSS . str_replace('controller', '', strtolower($this->ClassName) . '.css'));
        }

        $this->load->auto('style/theme');
        foreach ($this->modelTheme->getAll() as $theme) {
            if ($this->config->get('theme_default_id') == $theme['theme_id'] && file_exists(DIR_CSS . "custom-" . $theme['theme_id'] . "-" . $this->config->get('config_template') . ".css")) {
                $this->data['css'] .= file_get_contents($csspath . "custom-" . $theme['theme_id'] . "-" . $this->config->get('config_template') . ".css");
                break;
            } elseif (file_exists(DIR_CSS . "custom-" . $theme['theme_id'] . "-" . $this->config->get('config_template') . ".css")) {
                $this->data['css'] .= file_get_contents($csspath . "custom-" . $theme['theme_id'] . "-" . $this->config->get('config_template') . ".css");
                break;
            }
        }

        if ($this->data['css']) {
            $this->data['css'] = str_replace("../../../images/", HTTP_IMAGE, $this->data['css']);
            $this->data['css'] = str_replace("../images/", '../admin/images/', $this->data['css']);
            $this->data['css'] = str_replace("../fonts/", '../admin/fonts/', $this->data['css']);
        }

        $this->data['styles'] = $this->styles = array_merge($this->styles, $styles);
    }

}
