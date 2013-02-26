<?php  
class ControllerModuleLatest extends Controller {
	 protected function index() {
		$this->prefetch();
        
		$this->id = 'latest';
		
		if ($this->config->get('latest_position') == 'home') {
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
        $this->language->load('module/latest');
        $this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('catalog/product');
		
        $results = $this->model_catalog_product->getLatestProducts($this->config->get('latest_limit'));
        
        require_once(DIR_CONTROLLER . "store/product_array.php");
        
    }
    
    public function carousel() {
        $json = array();
        $this->load->auto("store/product");
        $this->load->auto('image');
        $this->load->auto('json');
        
        $json['results'] = $this->modelProduct->getRandomProducts(40);
        $width  = isset($_GET['width']) ? $_GET['width'] : 80;
        $height = isset($_GET['height']) ? $_GET['height'] : 80;
        foreach ($json['results'] as $k => $v) {
            if (!file_exists(DIR_IMAGE . $v['image'])) $json['results'][$k]['image'] = HTTP_IMAGE ."no_image.jpg";
            $json['results'][$k]['thumb'] = NTImage::resizeAndSave($v['image'], $width, $height);
            $json['results'][$k]['price'] = $this->currency->format($this->tax->calculate($v['price'], $v['tax_class_id'], $this->config->get('config_tax')));
        }
        
        if (!count($json['results'])) $json['error'] = 1;
        
        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
    }
    
}
