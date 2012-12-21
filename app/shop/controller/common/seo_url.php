<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);
			
			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
				
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					
					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					
					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}	
					
					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}	
				} else {
					$this->request->get['r'] = 'error/not_found';	
				}
			}
			
			if (isset($this->request->get['product_id'])) {
				$this->request->get['r'] = 'store/product';
			} elseif (isset($this->request->get['path'])) {
				$this->request->get['r'] = 'store/category';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['r'] = 'store/manufacturer';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['r'] = 'information/information';
			}
			
			if (isset($this->request->get['r'])) {
				return $this->forward($this->request->get['r']);
			}
		}
	}
}
