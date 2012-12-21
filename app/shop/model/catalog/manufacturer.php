<?php
class ModelCatalogManufacturer extends Model {
	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m WHERE m.manufacturer_id = '" . (int)$manufacturer_id . "'");
	
		return $query->row;	
	}
	
	public function getManufacturers() {
		$manufacturer = $this->cache->get('manufacturer.' . (int)C_CODE);
		
		if (!$manufacturer) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m ORDER BY sort_order, LCASE(m.name) ASC");
	
			$manufacturer = $query->rows;
			
			$this->cache->set('manufacturer.' . (int)C_CODE, $manufacturer);
		}
		
		return $manufacturer;
	} 	
    
	public function updateViewed($manufacturer_id,$customer_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET viewed = viewed + 1 WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("INSERT " . DB_PREFIX . "manufacturer_stats SET 
        `manufacturer_id` = '" . (int)$manufacturer_id . "',
        `customer_id` = '" . (int)$customer_id . "',
        `server` = '".$this->db->escape(serialize($_SERVER))."',
        `session` = '".$this->db->escape(serialize($_SESSION))."',
        `request` = '".$this->db->escape(serialize($_REQUEST))."',
        `store_url` = '".$this->db->escape($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'])."',
        `store_id` = '".$this->db->escape($this->config->get('config_store_id'))."',
        `ip` = '".$_SERVER['REMOTE_ADDR']."',
        `date_added` = NOW()");
	}
}
