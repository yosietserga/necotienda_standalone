<?php

class ControllerModuleLightBox extends Module {

    protected function index($widget = null) {
        if (!$this->session->has($widget['name'])) {
            $this->load->helper('tools');
            $this->data['necoTool'] = new NecoTool();

            if (isset($widget)) {
                $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
                $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
            }

            $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

            if (!$this->data['settings']['module']) $this->data['settings']['module'] = 'lightbox';
            
            if ((int)$settings['page_id'] && (!isset($settings['show_once']) && !$this->request->getCookie($widget['name']))) {
                $this->load->model('content/page');
                $this->data['page'] = $this->modelPage->getById($settings['page_id']);
                
                $this->request->setCookie($widget['name'], true);
                $this->session->set($widget['name'], true);

                //TODO: pass widget params through direct vars
                $this->session->clear('object_type');
                $this->session->clear('object_id');
                $this->session->clear('landing_page');

                $this->session->set('object_type', 'page');
                $this->session->set('object_id', $settings['page_id']);
                $this->session->set('landing_page', 'content/page');
                $this->loadWidgets('featuredContent');
                $this->loadWidgets('main');
                $this->loadWidgets('featuredFooter');
            }

            $this->id = 'lightbox';

            $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
            $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
            $this->loadWidgetAssets($filename);

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/lightbox.tpl')) {
                $this->template = $this->config->get('config_template') . '/module/lightbox.tpl';
            } else {
                $this->template = 'cuyagua/module/lightbox.tpl';
            }
            $this->render();
        }
    }
}
