<?php

class ControllerModulePostOverview extends Module {

    protected function index($widget = null) {
        $this->language->load('module/post_overview');
        $this->load->auto('content/post');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'post_overview';

        if ($this->request->hasQuery('post_id') || $this->request->hasPost('post_id')) {
            $data['post_id'] = $this->request->hasPost('post_id') ? $this->request->getPost('post_id') : $this->request->getQuery('post_id');
        }

        $results = $this->modelPost->getAll($data);

        if ($post_info = $results[0]) {
            $this->data['overview'] = $post_info['meta_description'];
        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/post_overview.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/post_overview.tpl';
        } else {
            $this->template = 'cuyagua/module/post_overview.tpl';
        }

        $this->id = 'post_overview';
        $this->render();
    }
}
