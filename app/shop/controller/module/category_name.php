<?php

class ControllerModuleCategoryName extends Module {

    protected function index($widget = null) {
        $this->language->load('module/category_name');
        $this->load->auto('store/category');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'category_name';

        if ($this->request->hasQuery('category_id') || $this->request->hasPost('category_id')) {
            $data['category_id'] = $this->request->hasPost('category_id') ? $this->request->getPost('category_id') : $this->request->getQuery('category_id');
        }

        $results = $this->modelCategory->getAll($data);

        if ($category_info = $results[0]) {
            $this->data['name'] = $category_info['cname'];
            $this->data['heading_title'] = isset($category_info['cname']) ? $category_info['cname'] :
                isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');
        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/category_name.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/category_name.tpl';
        } else {
            $this->template = 'cuyagua/module/category_name.tpl';
        }

        $this->id = 'category_name';
        $this->render();
    }
}
