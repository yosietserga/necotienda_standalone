<?php
class ModelCatalogSlider extends Model {
	public function getById($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "slider s 
        LEFT JOIN " . DB_PREFIX . "slider_description sd ON (s.slider_id = sd.slider_id) 
        WHERE s.slider_id = '" . (int)$category_id . "' 
            AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            AND s.status = '1'");
		
		return $query->object;
	}
	
	public function getAll() {
		return $this->db->query("SELECT * FROM " . DB_PREFIX . "slider c 
        LEFT JOIN " . DB_PREFIX . "slider_description cd ON (c.slider_id = cd.slider_id) 
        WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            AND c.status = '1' ORDER BY c.sort_order");
	}
}
