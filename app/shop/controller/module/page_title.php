<?php

class ControllerModulePageTitle extends Module {

    protected function index($widget = null) {
        $this->language->load('module/page_title');
        $this->load->auto('content/page');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'page_title';

        if ($this->request->hasQuery('page_id') || $this->request->hasPost('page_id')) {
            $data['page_id'] = $this->request->hasPost('page_id') ? $this->request->getPost('page_id') : $this->request->getQuery('page_id');
        }

        $results = $this->modelPage->getAll($data);

        if ($page_info = $results[0]) {
            $this->data['title'] = $page_info['title'];
            $this->data['heading_title'] = isset($page_info['title']) ? $page_info['title'] :
                isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');
        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/page_title.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/page_title.tpl';
        } else {
            $this->template = 'cuyagua/module/page_title.tpl';
        }

        $this->id = 'page_title';
        $this->render();
    }
}
