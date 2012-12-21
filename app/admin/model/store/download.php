<?php
/**
 * ModelStoreDownload
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 */
class ModelStoreDownload extends Model {
	/**
	 * ModelStoreDownload::addDownload()
	 * 
	 * @param mixed $data
	 * @return void
	 */
	public function addDownload($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "download SET remaining = '" . (int)$data['remaining'] . "', date_added = NOW()");

      	$download_id = $this->db->getLastId(); 

      	if (isset($data['download'])) {
        	$this->db->query("UPDATE " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['download']) . "', mask = '" . $this->db->escape($data['mask']) . "' WHERE download_id = '" . (int)$download_id . "'");
      	}

      	foreach ($data['download_description'] as $language_id => $value) {
        	$this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      	}	
	}
	
	/**
	 * ModelStoreDownload::editDownload()
	 * 
	 * @param int $download_id
	 * @param mixed $data
	 * @return void
	 */
	public function editDownload($download_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "download SET remaining = '" . (int)$data['remaining'] . "' WHERE download_id = '" . (int)$download_id . "'");
      	
		if (isset($data['download'])) {
        	$this->db->query("UPDATE " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['download']) . "', mask = '" . $this->db->escape($data['mask']) . "' WHERE download_id = '" . (int)$download_id . "'");
      	}
		
		if (isset($data['update'])) {
        	$query = $this->db->query("SELECT filename from " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");
     		$filename = $query->row['filename'];
      		$this->db->query("UPDATE " . DB_PREFIX . "order_download SET `filename` = '" . $this->db->escape($data['download']) . "', mask = '" . $this->db->escape(basename($data['mask'])) . "' WHERE `filename` = '" . $this->db->escape($filename) . "'");
      	}
		
      	$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");

      	foreach ($data['download_description'] as $language_id => $value) {
        	$this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      	}	
	}
	
	/**
	 * ModelStoreDownload::deleteDownload()
	 * 
	 * @param int $download_id
	 * @return void
	 */
	public function deleteDownload($download_id) {
      	$this->db->query("DELETE FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");
	  	$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");	
	}	

	/**
	 * ModelStoreDownload::getDownload()
	 * 
	 * @param int $download_id
	 * @return array sql record
	 */
	public function getDownload($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");
		
		return $query->row;
	}

	/**
	 * ModelStoreDownload::getDownloads()
	 * 
	 * @param mixed $data
	 * @return array sql records
	 */
	public function getDownloads($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
	
		$sort_data = array(
			'dd.name',
			'd.remaining'
		);
	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY dd.name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	/**
	 * ModelStoreDownload::getDownloadDescriptions()
	 * 
	 * @param int $download_id
	 * @return array sql records
	 */
	public function getDownloadDescriptions($download_id) {
		$download_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");
		
		foreach ($query->rows as $result) {
			$download_description_data[$result['language_id']] = array('name' => $result['name']);
		}
		
		return $download_description_data;
	}
	
	/**
	 * ModelStoreDownload::getTotalDownloads()
	 * 
	 * @return int Count sql records
	 */
	public function getTotalDownloads() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "download");
		
		return $query->row['total'];
	}	
}