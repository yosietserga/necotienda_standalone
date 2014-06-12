<?php

class ControllerModuleLightBox extends Controller {

    protected function index($widget = null) {
        if (!$this->session->has($widget['name'])) {
            if (isset($widget)) {
                $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
                $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
            }

            if (isset($settings['title'])) {
                $this->data['heading_title'] = $settings['title'];
            } else {
                $this->data['heading_title'] = $this->language->get('heading_title');
            }

            if ((int) $settings['page_id']) {
                $this->load->model('content/page');
                $this->data['page'] = $this->modelPage->getById($settings['page_id']);
            }

            $this->request->setCookie($widget['name'], true);
            $this->session->set($widget['name'], true);

            $this->load->helper('widgets');
            $widgets = new NecoWidget($this->registry, $this->Route);
            foreach ($widgets->getWidgets('main') as $w) {
                $settings = (array) unserialize($w['settings']);

                if (isset($settings['route']) && strpos(html_entity_decode($this->data['page']['description']), $w['code']) > 0) {
                    $this->children[$w['name']] = $settings['route'];
                    $this->widget[$w['name']] = $w;
                }
            }

            $this->loadAssets();

            if ($scripts)
                $this->scripts = array_merge($this->scripts, $scripts);

            $this->id = 'lightbox';

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/lightbox.tpl')) {
                $this->template = $this->config->get('config_template') . '/module/lightbox.tpl';
            } else {
                $this->template = 'choroni/module/lightbox.tpl';
            }
            $this->render();
        }
    }

    protected function loadAssets() {
        $csspath = defined("CDN") ? CDN_CSS : HTTP_THEME_CSS;
        $jspath = defined("CDN") ? CDN_JS : HTTP_THEME_JS;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
            $csspath = str_replace("%theme%", $this->config->get('config_template'), $csspath);
            $cssFolder = str_replace("%theme%", $this->config->get('config_template'), DIR_THEME_CSS);

            $jspath = str_replace("%theme%", $this->config->get('config_template'), $jspath);
            $jsFolder = str_replace("%theme%", $this->config->get('config_template'), DIR_THEME_JS);
        } else {
            $csspath = str_replace("%theme%", "default", $csspath);
            $cssFolder = str_replace("%theme%", "default", DIR_THEME_CSS);

            $jspath = str_replace("%theme%", "default", $jspath);
            $jsFolder = str_replace("%theme%", "default", DIR_THEME_JS);
        }

        if (file_exists($cssFolder . str_replace('controller', '', strtolower(__CLASS__) . '.css'))) {
            $styles[] = array('media' => 'all', 'href' => $csspath . str_replace('controller', '', strtolower(__CLASS__) . '.css'));
        }

        if (count($styles)) {
            $this->data['styles'] = $this->styles = array_merge($this->styles, $styles);
        }

        if (file_exists($jsFolder . str_replace('controller', '', strtolower(__CLASS__) . '.js'))) {
            $javascripts[] = $jspath . str_replace('controller', '', strtolower(__CLASS__) . '.js');
        }

        if (count($javascripts)) {
            $this->javascripts = array_merge($this->javascripts, $javascripts);
        }
    }

}
