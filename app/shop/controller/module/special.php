<?php  
class ControllerModuleSpecial extends Controller {
	function index() {
		$this->prefetch();
        
		$this->id = 'special';

		if ($this->config->get('special_position') == 'home') {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products.tpl')) {
				$this->template = $this->config->get('config_template') . '/store/products.tpl';
			} else {
				$this->template = 'default/store/products.tpl';
			}
		} else {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products_box.tpl')) {
				$this->template = $this->config->get('config_template') . '/store/products_box.tpl';
			} else {
				$this->template = 'default/store/products_box.tpl';
			}
		}
		
		$this->render();
	}
    
    public function home() {
        $this->prefetch();
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products.tpl')) {
			$this->template = $this->config->get('config_template') . '/store/products.tpl';
		} else {
			$this->template = 'default/store/products.tpl';
		}
        
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }
    
    protected function prefetch() {
		$this->language->load('module/special');

		$this->load->model('catalog/product');
		
		$results = $this->model_catalog_product->getProductSpecials('pd.name', 'ASC', 0, $this->config->get('special_limit'));
        
        require_once(DIR_CONTROLLER . "store/product_array.php");
        
    }
}
