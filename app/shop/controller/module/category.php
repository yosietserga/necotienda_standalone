<?php  
class ControllerModuleCategory extends Controller {
	protected $category_id = 0;
	protected $path = array();
	
	protected function index() {
		$this->language->load('module/category');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('catalog/category');
		$this->load->model('tool/seo_url');
		
		if (isset($this->request->get['path'])) {
			$this->path = explode('_', $this->request->get['path']);
			
			$this->category_id = end($this->path);
		}
		
		$this->data['category'] = $this->getCategories();
		
		$this->id = 'category';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/category.tpl')) {
			$this->template = $this->config->get('config_template') . '/module/category.tpl';
		} else {
			$this->template = 'default/module/category.tpl';
		}
		
		$this->render();
  	}
	
	protected function getCategories($parent_id=0) {
		$output = '';
		$results = $this->model_catalog_category->getCategories($parent_id);
		
		if ($results) { 
			$output .= '<ul>';
    		foreach ($results as $result) {	    			
    			$childrens = $this->model_catalog_category->getCategories($result['category_id']);
                if ($childrens) {
                    $output .= '<li class="hasCategories">';
                } else {
                    $output .= '<li>';
                }
    			
    			if ($this->category_id == $result['category_id']) {
    				$output .= '<a href="' . $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/category&amp;path=' . $result['category_id'])  . '"><b>' . $result['name'] . '</b></a>';
    			} else {
    				$output .= '<a href="' . $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/category&amp;path=' . $result['category_id'])  . '">' . $result['name'] . '</a>';
    			}
    			
                // subcategories
    			if ($childrens) {
                    $output .= '<ul>';
    			     foreach ($childrens as $child) {
    			         $output .= '<li><a href="' . $this->model_tool_seo_url->rewrite(HTTP_HOME . 'index.php?r=store/category&amp;path=' . $result['category_id'].'_'.$child['category_id'])  . '" title="'.$child['name'].'">'.$child['name'].'</a></li>';
    			     }
			         $output .= '</ul>';
    			}
    			$output .= '</li>'; 
    		}
 
			$output .= '</ul>';
		}
		
		return $output;
	}		
}
