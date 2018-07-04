<?php
/**
 * ControllerModuleShoppingCartBoxWidget
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerModuleShoppingCartBoxWidget extends Controller {
	private $error = array();
    private $module = 'shopping_cart_box';
	
	/**
	 * ControllerModuleShoppingCartBoxWidget::index()
	 * 
	 * @return
	 */
	public function index() {
        if (!$this->request->hasQuery('name')) return false;
        
		$this->load->language('module/'. $this->module);
        
		$this->load->helper('widgets');
        $widget = new NecoWidget($this->registry);
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $widget_name = $this->request->getQuery('name');
            $widget_position = $this->request->getQuery('position');
            $data = $this->request->post['Widgets'][$widget_name];
            $data['name'] = $widget_name;
            $data['position'] = $widget_position;
            
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
            $data['name']           = ($this->request->hasQuery('name')) ? $this->request->getQuery('name') : null;
            $data['row_id'] = ($this->request->hasQuery('row_id')) ? $this->request->getQuery('row_id') : null;
            $data['col_id'] = ($this->request->hasQuery('col_id')) ? $this->request->getQuery('col_id') : null;
            $data['landing_page']   = 'all';
            $data['position']       = ($this->request->hasQuery('position')) ? $this->request->getQuery('position') : null;
            $data['extension']       = ($this->request->hasQuery('extension')) ? $this->request->getQuery('extension') : null;
            $data['app']            = ($this->request->hasQuery('app')) ? $this->request->getQuery('app') : 'shop';
            $data['order']          = ($this->request->hasQuery('order')) ? $this->request->getQuery('order') : 0;
            $data['store_id']       = ($this->request->hasQuery('store_id')) ? $this->request->getQuery('store_id') : 0;

            $views = glob(DIR_CATALOG . 'view/theme/'. $this->config->get('config_template') .'/module/'. $this->module .'_*.tpl', GLOB_NOSORT);
            $this->data['views'] = array();
            foreach ($views as $view) {
                $this->data['views'][] = str_replace(array($this->module .'_','.tpl'), '', basename($view));
            }

            $views = glob(DIR_CATALOG . 'view/theme/'. $this->config->get('config_template') .'/module/'. $this->module .'_*.tpl', GLOB_NOSORT);
            $this->data['views'] = $this->data['view_files'] = array();
            foreach ($views as $view) {
                $this->data['views'][] = str_replace(array($this->module .'_','.tpl'), '', basename($view));
                $this->data['view_files'][] = realpath($view);
            }

            $m = str_replace(array('-','_',' ','.'), '', 'module'. $this->module);
            $files = glob(DIR_THEME_ASSETS . $this->config->get('config_template') . "/css/$m*.css");
            $this->data['css_files'] = array();
            foreach ($files as $key => $file) {
                $this->data['css_files'][] = basename($file);
            }

            $files = glob(DIR_THEME_ASSETS . $this->config->get('config_template') . "/js/$m*.js");
            $this->data['js_files'] = array();
            foreach ($files as $key => $file) {
                $this->data['js_files'][] = basename($file);
            }

            $this->data['module_view_file_prefix'] = $this->module .'_';
            $this->data['module_view_folder'] = DIR_CATALOG . 'view'. DIRECTORY_SEPARATOR .'theme'. DIRECTORY_SEPARATOR . $this->config->get('config_template') . DIRECTORY_SEPARATOR .'module'. DIRECTORY_SEPARATOR;
            $this->data['module_css_file_prefix'] = $m;
            $this->data['module_css_folder'] = DIR_THEME_ASSETS . $this->config->get('config_template') . DIRECTORY_SEPARATOR ."css" . DIRECTORY_SEPARATOR;
            $this->data['module_js_file_prefix'] = $m;
            $this->data['module_js_folder'] = DIR_THEME_ASSETS . $this->config->get('config_template') . DIRECTORY_SEPARATOR ."js" . DIRECTORY_SEPARATOR;

            if ($this->request->hasQuery('w')) {
                $this->load->model('style/widget');
                $widget_info = $this->modelWidget->getByName($data['name']);
                $this->setvar('widget_id',$widget_info);
                $this->setvar('code',$widget_info);
                $this->setvar('name',$widget_info);
                $this->setvar('position',$widget_info);
                $this->setvar('extension',$widget_info);
                $this->setvar('status',$widget_info);
                $this->setvar('app',$widget_info);
                $this->setvar('order',$widget_info);
                $this->setvar('store_id',$widget_info);
                
                $landing_pages = array();
                foreach ($widget_info['landing_pages'] as $lp) {
                    $landing_pages[] = $lp['landing_page'];
                }
                $this->data['landing_pages'] = $landing_pages;
                
                $this->data['settings'] = (array)unserialize($widget_info['settings']);
            } else {
                $settings           = new stdClass;
                $settings->route    = 'module/'. $this->module;
                $settings->autoload = 1;
                $settings->showonmobile = 1;
                $settings->showondesktop = 1;
                $settings->view = 'default';

                $settings->landing_page = 'landing_page=all';
                if ($this->request->hasQuery('landing_page')) {
                    $settings->landing_page = 'landing_page='.$this->request->getQuery('landing_page');
                }
                if ($this->request->hasQuery('ot')) {
                    $settings->object_type = 'object_type='.$this->request->getQuery('ot');
                }
                if ($this->request->hasQuery('oid')) {
                    $settings->object_id = 'object_id='.$this->request->getQuery('oid');
                }
                if ($this->request->hasQuery('row_id')) {
                    $settings->row_id = 'row_id='.$this->request->getQuery('row_id');
                }
                if ($this->request->hasQuery('col_id')) {
                    $settings->col_id = 'col_id='.$this->request->getQuery('col_id');
                }
                $this->data['settings'] = (array)$settings;
                
                $data['settings']   = $settings;
                $widget->save($data);
                $this->setvar('name');
            }
            
            $this->data['routes'] = $widget->getRoutes();
            foreach ($this->data['routes'] as $text_var => $landing_page) {
                $json['routes'][] = array(
        			'landing_page' => $landing_page,
        			'title'    => $this->language->get($text_var),
        		);
            }

            $template = ($this->config->get('default_admin_view_module_'. $this->module .'_widget')) ? $this->config->get('default_admin_view_module_'. $this->module .'_widget') : 'module/'. $this->module .'/widget.tpl';
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_admin_template') . '/'. $template)) {
                $this->template = $this->config->get('config_admin_template') . '/' . $template;
            } else {
                $this->template = 'default/' . $template;
            }

            $json['html'] = $this->render(true);
        }
        
        $this->load->library('json');
		$this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
	}
}
