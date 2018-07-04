<?php

class ControllerModuleLinks extends Module {

    protected $links_id = 0;
    protected $path = array();

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }
        $this->language->load('module/links');

        $this->data['heading_title'] = $settings['title'];

        if ($settings['is_main_menu']) {
            $this->data['links'] = $this->drawMainMenu($this->getLinks($settings['menu_id']), $this->data['rows']);
        } else {
            $this->data['links'] = $this->drawLinksGroup($this->getLinks($settings['menu_id']));
        }

        $this->id = 'links';

        $settings['view'] = isset($settings['view']) ? $settings['view'] : 'default';
        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
        $this->loadWidgetAssets($filename);

        $this->data['settings'] = $settings;

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

        $return = array();
        $results = $this->modelMenu->getAllItems(array(
            'menu_id'=>$menu_id,
            'parent_id'=>$parent_id
        ));

        if ($results) {
            foreach ($results as $k => $result) {
                $return[$k] = $result;

                if (isset($result['page_id']) && !empty($result['page_id'])) {
                    $page = $this->modelPage->getById($result['page_id']);
                    if ($page) {
                        $return[$k]['page'] = $page;

                        $this->session->clear('object_type');
                        $this->session->clear('object_id');
                        $this->session->clear('landing_page');

                        $this->session->set('object_type', 'page');
                        $this->session->set('object_id', $page['post_id']);
                        $this->session->set('landing_page', 'content/page');

                        $this->loadWidgets('featuredContent');
                        $this->loadWidgets('main');
                        $this->loadWidgets('featuredFooter');
                    }
                }

                $return[$k]['children'] = $this->getLinks($menu_id, $result['menu_link_id']);
            }
        }

        return $return;
    }

    protected function drawLinksGroup($links, $submenu = false) {
        $output = "<ul". ($submenu ? ' class="submenu"' : "") .">";
        foreach ($links as $k => $result) {
            $output .= '<li'. ((isset($result['class_css']) && !empty($result['class_css'])) ? ' class="'. $result['class_css'] .'"': "") .'>';
            $output .= '<a href="'. Url::rewrite($result['link']) .'" title="'.$result['tag'].'">' . $result['tag'] . '</a>';

            if ($result['children']) {
                $output .= $this->drawLinksGroup($result['children'], true);
            }

            $output .= '</li>';

        }
        $output .= '</ul>';

        return $output;
    }

    protected function drawMainMenu($links, $rows, $submenu = false) {
        $tpl = "<ul". ($submenu ? ' class="submenu"' : "") .">";
        foreach ($links as $result) {
            $tpl .= '<li'. ((isset($result['class_css']) && !empty($result['class_css'])) ? ' class="'. $result['class_css'] .'"': "") .'>';

            $tpl .= '<a href="'. Url::rewrite($result['link']) .'" title="'. $result['tag'] .'">'. $result['tag'] .'</a>';

            if ($result['page']) {

                $tpl .= '<div class="submenu">';

                $tpl .= '<div class="large-12">';
                $tpl .=  $this->drawWidgets('featuredContent', $rows);
                $tpl .= '</div>';

                $tpl .= '<div class="row">';

                $tpl .= '<div class="large-12">';
                $tpl .= html_entity_decode($result['page']['pdescription']);
                $tpl .=  $this->drawWidgets('main', $rows);
                $tpl .= '</div>';

                $tpl .= '</div>';

                $tpl .= '<div class="large-12">';
                $tpl .=  $this->drawWidgets('featuredFooter', $rows);
                $tpl .= '</div>';

                $tpl .= '</div>';
            } elseif ($result['children']) {
                $tpl .= $this->drawMainMenu($result['children'], $rows, true);
            }

            $tpl .= "</li>";
        }
        $tpl .= "</ul>";

        return $tpl;
    }

    protected function drawWidgets($position, $rows) {
        $tpl = '';

        foreach($rows[$position] as $j => $row) {
            if (!$row['key']) continue;
            $row_id = $row['key'];
            $row_settings = unserialize($row['value']);

            $tpl .= '<div class="row" id="'. $position .'_'. $row_id .'" nt-editable>';

            foreach($row['columns'] as $k => $column) {
                if (!$column['key']) continue;
                $column_id = $column['key'];
                $column_settings = unserialize($column['value']);

                $tpl .= '<div class="large-'. $column_settings['grid_large'] .' medium-'. $column_settings['grid_medium'] .' small-'. $column_settings['grid_small'] .'" id="'. $position .'_'. $column_id .'" nt-editable>';

                $tpl .= '<ul class="widgets">';

                foreach($column['widgets'] as $l => $widget) {
                    $tpl .= '{%'. $widget['name'] .'%}';
                }

                $tpl .= '</ul>';

                $tpl .= '</div>';
            }
            $tpl .= '</div>';
        }

        return $tpl;
    }
}
