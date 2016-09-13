<?php  
class ControllerCommonNav extends Controller {
	protected function index() {
	   $this->load->auto('store/category');
	   $this->load->auto('content/menu');
       
       $menu = $this->modelMenu->getMainMenu();
       if ($menu['menu_id']) {
           $this->data['links'] = $this->getLinks($menu['menu_id'],0);
       }

		$this->loadAssets();

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
			$output .= '<ul>';
    		foreach ($results as $result) {
                $output .= '<li'. ((isset($result['class_css']) && !empty($result['class_css'])) ? ' class="'. $result['class_css'] .'"': "") .'>';
				if (isset($result['page_id']) && !empty($result['page_id'])) {
					$page = $this->modelPage->getById($result['page_id']);
					$output .= html_entity_decode($page['description']);
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
