<?php

class ControllerModuleCategoryList extends Module {

    protected function index($widget = null) {
        $this->language->load('module/category_list');
        $this->load->auto('image');
        $this->load->auto('image');

        $Url = new Url($this->registry);
        $this->data['Image'] = new NTImage;

        if (isset($widget)) {
            $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$settings['module']) $settings['module'] = 'category_list';

        $this->data['thumb_width'] = isset($settings['width']) ? $settings['width'] : $this->config->get('config_image_category_width');
        $this->data['thumb_height'] = isset($settings['height']) ? $settings['height'] : $this->config->get('config_image_category_height');

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        if ($this->request->hasQuery('category_id') || $this->request->hasPost('category_id')) {
            $data['category_id'] = $this->request->hasPost('category_id') ? $this->request->getPost('category_id') : $this->request->getQuery('category_id');
        } else {
            $data['category_id'] = (!empty($settings['categories'])) ? $settings['categories'] : null;
        }

        $this->data['categories'] = $this->getCategories($data);
        
        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/category_list.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/category_list.tpl';
        } else {
            $this->template = 'cuyagua/module/category_list.tpl';
        }

        $this->id = 'category_list';
        $this->render();
    }

    protected function getCategories($data) {
        $data['parent_id'] = ($data['parent_id']) ? $data['parent_id'] : 0;

        static $ready = array();
        if (in_array($data['parent_id'], $ready)) return false;
        $ready[] = $data['parent_id'];

        $this->load->auto('store/category');
        $results = $this->modelCategory->getAll($data);
        if (count($results)==0) return false;

        $c_data = $data;
        unset($c_data['parent_id']);
        foreach ($results as $k=>$result) {
            $c_data['parent_id'] = $result['category_id'];
            $results[$k]['children'] = $this->getCategories($c_data);
        }
        return $results;
    }
}
