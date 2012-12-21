<?php
class ModelCatalogInformation extends Model {
	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i.status = '1'");
	
		return $query->row;
	}
	
	public function getInformations() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");
		
		return $query->rows;
	}
    
	public function updateViewed($information_id,$customer_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "information SET viewed = viewed + 1 WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "information_stats SET 
        `information_id` = '" . (int)$information_id . "',
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
