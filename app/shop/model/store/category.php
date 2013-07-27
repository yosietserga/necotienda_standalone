<?php
class ModelStoreCategory extends Model {
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c 
        LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
        LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
        WHERE c.category_id = '" . (int)$category_id . "' 
        AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND c2s.store_id = '". (int)STORE_ID ."' 
        AND c.status = '1'");
		
		return $query->row;
	}
	
	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * 
        FROM " . DB_PREFIX . "category c 
        LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
        LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
        WHERE c.parent_id = '" . (int)$parent_id . "' 
        AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND c2s.store_id = '". (int)STORE_ID ."' 
        AND c.status = '1' 
        ORDER BY c.sort_order ASC");
		return $query->rows;
	}
    
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c 
        LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
        WHERE c.parent_id = '" . (int)$parent_id . "' 
        AND c2s.store_id = '". (int)STORE_ID ."' 
        AND c.status = '1'");
		return $query->row['total'];
	}	
    
	public function updateStats($category_id,$customer_id) {
	   $this->load->library('browser');
       $browser = new Browser;
		$this->db->query("UPDATE " . DB_PREFIX . "category SET viewed = viewed + 1 WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("INSERT " . DB_PREFIX . "stat SET 
        `object_id`     = '". (int)$category_id ."',
        `store_id`      = '". (int)STORE_ID ."',
        `customer_id`   = '". (int)$customer_id ."',
        `object_type`   = 'category',
        `server`        = '". $this->db->escape(serialize($_SERVER)) ."',
        `session`       = '". $this->db->escape(serialize($_SESSION)) ."',
        `request`       = '". $this->db->escape(serialize($_REQUEST)) ."',
        `store_url`     = '". $this->db->escape($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) ."',
        `ref`           = '". $this->db->escape($_SERVER['HTTP_REFERER']) ."',
        `browser`       = '". $this->db->escape($browser->getBrowser()) ."',
        `browser_version`= '". $this->db->escape($browser->getVersion()) ."',
        `os`            = '". $this->db->escape($browser->getPlatform()) ."',
        `ip`            = '". $this->db->escape($_SERVER['REMOTE_ADDR']) ."',
        `date_added`    = NOW()");
	}
}
