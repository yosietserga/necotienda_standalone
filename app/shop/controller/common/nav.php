<?php

class ControllerCommonNav extends Controller {
    
    protected function index($params = null) {
        $this->load->auto('store/category');
        $this->load->auto('content/menu');

        $menu = $this->modelMenu->getMainMenu();
        if ($menu['menu_id']) {
            $this->data['links'] = $this->getLinks($menu['menu_id'],0);
        }

        

        $this->id = 'navigation';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/nav.tpl')) {
            $this->template = $this->config->get('config_template') . '/common/nav.tpl';
        } else {
            $this->template = 'cuyagua/common/nav.tpl';
        }

        $this->render();
    }

    protected function getLinks($menu_id,$parent_id=0) {
        $this->load->auto('content/menu');
        $this->load->auto('content/page');
        $output = '';
        $results = $this->modelMenu->getLinks($menu_id,$parent_id);
        if ($results) {
            $output .= '<ul class="sublevel">';
            foreach ($results as $result) {
                $output .= '<li class="sublink'. ((isset($result['class_css']) && !empty($result['class_css'])) ? ' '. $result['class_css'] : "") .'">';
                if (isset($result['page_id']) && !empty($result['page_id'])) {
                    $page = $this->modelPage->getById($result['page_id']);
                    $output .= '<div class="html_sublevel">'. html_entity_decode($page['description']) .'</div>';
                } else {
                    $output .= '<a href="'. Url::rewrite($result['link']) .'" title="'.$result['tag'].'">' . $result['tag'] . '</a>';
                }
                $output .= $this->getLinks($menu_id,$result['menu_link_id']);
                $output .= '</li>';
            }
            $output .= '</ul>';
        }
        return $output;
    }
}
