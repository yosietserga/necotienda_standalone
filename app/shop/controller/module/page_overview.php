<?php

class ControllerModulePageOverview extends Module {

    protected function index($widget = null) {
        $this->language->load('module/page_overview');
        $this->load->auto('content/page');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'page_overview';

        if ($this->request->hasQuery('page_id') || $this->request->hasPost('page_id')) {
            $data['page_id'] = $this->request->hasPost('page_id') ? $this->request->getPost('page_id') : $this->request->getQuery('page_id');
        }

        $results = $this->modelPage->getAll($data);

        if ($page_info = $results[0]) {
            $this->data['overview'] = $page_info['meta_description'];
        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/page_overview.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/page_overview.tpl';
        } else {
            $this->template = 'cuyagua/module/page_overview.tpl';
        }

        $this->id = 'page_overview';
        $this->render();
    }
}
