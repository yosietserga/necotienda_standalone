<?php
class ModelContentPage extends Model {
	public function getById($id) {
		$query = $this->db->query("SELECT DISTINCT * 
        FROM " . DB_PREFIX . "post i 
        LEFT JOIN " . DB_PREFIX . "post_description id ON (i.post_id = id.post_id) 
        WHERE i.post_id = '" . (int)$id . "' 
        AND post_type = 'page'
        AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND date_publish_start <= NOW()
        AND (date_publish_end >= NOW() OR date_publish_end = '0000-00-00 00:00:00')
        AND i.status = '1'");
	
		return $query->row;
	}
	
	public function getAll() {
		$query = $this->db->query("SELECT * 
        FROM " . DB_PREFIX . "post i 
        LEFT JOIN " . DB_PREFIX . "post_description id ON (i.post_id = id.post_id) 
        WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND post_type = 'page'
        AND date_publish_start <= NOW()
        AND (date_publish_end >= NOW() OR date_publish_end = '0000-00-00 00:00:00')
        AND i.status = '1' 
        ORDER BY i.sort_order, LCASE(id.title) ASC");
		
		return $query->rows;
	}
    
	public function updateViewed($id,$customer_id) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "post_stats SET 
        `post_id` = '" . (int)$id . "',
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
