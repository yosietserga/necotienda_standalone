<?php

/**
 * ControllerModuleProductListWidget
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleProductListWidget extends Controller {

    private $error = array();

    /**
     * ControllerModuleProductListWidget::index()
     * 
     * @return
     */
    public function index() {
        if (!$this->request->hasQuery('name'))
            return false;

        $this->load->language('module/product_list');
        $this->load->helper('widgets');
        $widget = new NecoWidget($this->registry);

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $widget_name = $this->request->getQuery('name');
            $data = $this->request->post['Widgets'][$widget_name];

            $settings = new stdClass;
            foreach ($data['settings'] as $key => $value) {
                $settings->$key = $value;
            }
            $data['settings'] = $settings;

            if ($widget->save($data)) {
                $json['success'] = 1;
            } else {
                $json['error'] = 1;
                $json['msg'] = $this->language->get('error_saving_widget');
            }
        } else {
            $data['name'] = ($this->request->hasQuery('name')) ? $this->request->getQuery('name') : null;
            $data['landing_page'] = 'all';
            $data['position'] = ($this->request->hasQuery('position')) ? $this->request->getQuery('position') : null;
            $data['extension'] = ($this->request->hasQuery('extension')) ? $this->request->getQuery('extension') : null;
            $data['app'] = ($this->request->hasQuery('app')) ? $this->request->getQuery('app') : 'shop';
            $data['order'] = ($this->request->hasQuery('order')) ? $this->request->getQuery('order') : 0;
            $data['store_id'] = ($this->request->hasQuery('store_id')) ? $this->request->getQuery('store_id') : 0;

            $this->load->model('store/category');
            $c = $this->modelCategory->getAllForList(0, null);
            if ($this->request->hasQuery('w')) {
                $this->load->model('style/widget');
                $widget_info = $this->modelWidget->getByName($data['name']);
                $this->setvar('widget_id', $widget_info);
                $this->setvar('code', $widget_info);
                $this->setvar('name', $widget_info);
                $this->setvar('position', $widget_info);
                $this->setvar('extension', $widget_info);
                $this->setvar('status', $widget_info);
                $this->setvar('app', $widget_info);
                $this->setvar('order', $widget_info);
                $this->setvar('store_id', $widget_info);

                $landing_pages = array();
                foreach ($widget_info['landing_pages'] as $lp) {
                    $landing_pages[] = $lp['landing_page'];
                }
                $this->data['landing_pages'] = $landing_pages;
                $this->data['settings'] = (array) unserialize($widget_info['settings']);
                $this->data['categories'] = $this->getCategories($c, true, $widget_info['name'], $this->data['settings']['categories']);
            } else {
                $settings = new stdClass;
                $settings->route = 'module/product_list';
                $settings->autoload = 1;
                $settings->limit = 24;
                $settings->module = 'random';
                $data['settings'] = $settings;
                $widget->save($data);
                $this->setvar('name');
                $this->data['categories'] = $this->getCategories($c, true, $data['name'], null);
            }

            $this->data['routes'] = $widget->getRoutes();
            foreach ($this->data['routes'] as $text_var => $landing_page) {
                $json['routes'][] = array(
                    'landing_page' => $landing_page,
                    'title' => $this->language->get($text_var),
                );
            }

            $this->template = 'module/product_list/widget.tpl';
            $json['html'] = $this->render(true);
        }

        $this->load->library('json');
        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
    }

    private function getCategories($categories, $parent = false, $name, $settingsCategories) {
        $output = '';
        if ($categories) {
            foreach ($categories as $result) {
                if ($parent === true)
                    $output .= '<li>';
                else
                    $output .= '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $output .= '<input id="'. $name .'Settingscategories' . $result['category_id'] . '" type="checkbox" name="Widgets['. $name .'][settings][categories][]" value="' . $result['category_id'] .'"';
                $output .= (in_array($result['category_id'], $settingsCategories) || empty($settingsCategories)) ? ' checked="checked"' : '';
                $output .= '">';
                $output .= '<label for="'. $name .'Settingscategories' . $result['category_id'] . '">' . $result['name'] . '</label>';
                
                // subcategories
                if ($result['childrens']) {
                    $output .= $this->getCategories($result['childrens'], 2);
                }
                $output .= '</li>';
            }
        }
        return $output;
    }

}
