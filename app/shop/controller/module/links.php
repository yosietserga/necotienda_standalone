<?php

class ControllerModuleLinks extends Controller {

    protected $links_id = 0;
    protected $path = array();

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }
        $this->language->load('module/links');

        if (isset($settings['title'])) {
            $this->data['heading_title'] = $settings['title'];
        } else {
            $this->data['heading_title'] = $this->language->get('heading_title');
        }

        $this->data['links'] = $this->getLinks($settings['menu_id']);

        $this->loadAssets();

        if ($scripts)
            $this->scripts = array_merge($this->scripts, $scripts);

        $this->id = 'links';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/links.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/links.tpl';
        } else {
            $this->template = 'cuyagua/module/links.tpl';
        }
        $this->render();
    }

    protected function getLinks($menu_id = 0, $parent_id = 0) {
        $this->load->model('content/menu');
        $this->load->model('content/page');

        $output = '';
        $results = $this->modelMenu->getLinks($menu_id, $parent_id);
        if ($results) {
            $output .= '<ul>';
            foreach ($results as $result) {
                $childrens = $this->modelMenu->getLinks($menu_id, $result['menu_link_id']);
                $output .= '<li'. ((isset($result['class_css']) && !empty($result['class_css'])) ? ' class="'. $result['class_css'] .'"': "") .'>';
                if (isset($result['page_id']) && !empty($result['page_id'])) {
                    $page = $this->modelPage->getById($result['page_id']);
                    $output .= $page['description'];
                } else {
                    $output .= '<a href="'. Url::rewrite($result['link']) .'" title="'.$result['tag'].'">' . $result['tag'] . '</a>';
                }
                $output .= '</li>';

                if ($childrens) {
                    foreach ($childrens as $child) {
                        $output .= '<li>&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $child['link'] . '" title="' . $child['tag'] . '">' . $child['tag'] . '</a></li>';
                        $childs = $this->modelMenu->getLinks($menu_id, $child['menu_link_id']);
                        if ($childs) {
                            foreach ($childs as $ch) {
                                $output .= '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $ch['link'] . '" title="' . $ch['tag'] . '">' . $ch['tag'] . '</a></li>';
                            }
                        }
                    }
                }
            }
            $output .= '</ul>';
        }
        return $output;
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

        if (file_exists($cssFolder . strtolower(__CLASS__) . '.css')) {
            if ($this->config->get('config_render_css_in_file')) {
                $this->data['css'] .= file_get_contents($cssFolder . strtolower(__CLASS__) .'.css');
            } else {
                $styles[strtolower(__CLASS__) .'.css'] = array('media' => 'all', 'href' => $csspath . strtolower(__CLASS__) .'.css');
            }
        }

        if (file_exists($jsFolder . str_replace('controller', '', strtolower(__CLASS__) . '.js'))) {
            if ($this->config->get('config_render_js_in_file')) {
                $javascripts[] = $jsFolder . str_replace('controller', '', strtolower(__CLASS__) . '.js');
            } else {
                $javascripts[] = $jspath . str_replace('controller', '', strtolower(__CLASS__) . '.js');
            }
        }

        if (count($styles)) {
            $this->data['styles'] = $this->styles = array_merge($this->styles, $styles);
        }

        if (count($javascripts)) {
            $this->javascripts = array_merge($this->javascripts, $javascripts);
        }
    }
}
