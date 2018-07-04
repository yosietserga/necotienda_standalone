<?php

class ControllerModuleCategoryDescription extends Module {

    protected function index($widget = null) {
        $this->language->load('module/category_description');
        $this->load->auto('store/category');

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'category_description';

        if ($this->request->hasQuery('category_id') || $this->request->hasPost('category_id')) {
            $data['category_id'] = $this->request->hasPost('category_id') ? $this->request->getPost('category_id') : $this->request->getQuery('category_id');
        }

        $results = $this->modelCategory->getAll($data);

        if ($category_info = $results[0]) {
                $this->data['description'] = html_entity_decode($category_info['cdescription'], ENT_QUOTES, 'UTF-8');
        }

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/category_description.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/category_description.tpl';
        } else {
            $this->template = 'cuyagua/module/category_description.tpl';
        }

        $this->id = 'category_description';
        $this->render();
    }
}
