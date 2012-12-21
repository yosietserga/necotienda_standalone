<?php
/**
 * ModelContentSlider
 * 
 * @package NecoTienda powered opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelContentSlider extends Model {
	/**
	 * ModelContentSlider::add()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "slider SET 
        image       = '" . $this->db->escape($data['image']) . "', 
        link        = '" . $this->db->escape($data['link']) . "', 
        date_publish_start= '" . $this->db->escape($data['date_publish_start']) . "',
        date_publish_end= '" . $this->db->escape($data['date_publish_end']) . "',
        status      = '1',
        sort_order  = '1', 
        date_added  = NOW()");
        
		$slider_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "slider SET image = '" . $this->db->escape($data['image']) . "' WHERE slider_id = '" . (int)$slider_id . "'");
		}
		
		foreach ($data['slider_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "slider_description SET slider_id = '" . (int)$slider_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
        
		if (isset($data['slider_store'])) {
			foreach ($data['slider_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "slider_to_store SET slider_id = '" . (int)$slider_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		$this->cache->delete('slider');
        return $slider_id;
	}
	
	/**
	 * ModelContentSlider::edit()
	 * 
	 * @param int $id
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function edit($id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "slider SET 
        image       = '" . $this->db->escape($data['image']) . "', 
        link        = '" . $this->db->escape($data['link']) . "', 
        date_publish_start= '" . $this->db->escape($data['date_publish_start']) . "',
        date_publish_end= '" . $this->db->escape($data['date_publish_end']) . "',
        date_modified  = NOW()
        WHERE slider_id = '" . (int)$id . "'");
        
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "slider SET image = '" . $this->db->escape($data['image']) . "' WHERE slider_id = '" . (int)$id . "'");
		}
		
		foreach ($data['slider_description'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "slider_description SET slider_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "' WHERE slider_id = '" . (int)$id . "'");
		}
        
		$this->db->query("DELETE FROM " . DB_PREFIX . "slider_to_store WHERE slider_id = '" . (int)$id . "'");
		
		if (isset($data['slider_store'])) {
			foreach ($data['slider_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "slider_to_store SET slider_id = '" . (int)$id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		$this->cache->delete('slider');
	}
	
	/**
	 * ModelContentSlider::delete()
	 * 
	 * @param int $id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function delete($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "slider WHERE slider_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "slider_description WHERE slider_id = '" . (int)$id . "'");
	}
	
	/**
	 * ModelContentSlider::getById()
	 * 
	 * @param int $slider_id
     * @see DB
     * @see Cache
	 * @return array sql record
	 */
	public function getById($slider_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "slider WHERE slider_id = '" . (int)$slider_id . "'");
		return $query->row;
	}
	
	/**
	 * ModelContentCategory::getCategoryDescriptions()
	 * 
	 * @param int $slider_id
     * @see DB
	 * @return array sql records
	 */
	public function getDescriptions($slider_id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "slider_description WHERE slider_id = '" . (int)$slider_id . "'");
		foreach ($query->rows as $result) {
			$data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description']
			);
		}
		return $data;
	}	
	
	/**
	 * ModelContentSlider::getAll()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAll($data = array()) {
	   $sql = "SELECT * FROM " . DB_PREFIX . "slider_description sd 
       LEFT JOIN " . DB_PREFIX . "slider s ON (s.slider_id=sd.slider_id) 
       WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "' "; 
       
		if ($data) {
			if (isset($data['filter_title']) && !is_null($data['filter_title'])) {
				$sql .= " AND LCASE(title) LIKE '%" . $this->db->escape(strtolower($data['filter_title'])) . "%'";
			}

			$sort_data = array(
				'title',
				'status',
				'sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY title";	
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
			
		}
        
		$query = $this->db->query($sql);
		return $query->rows;
	}
    
	/**
	 * ModelContentSlider::getTotal()
	 * 
	 * @param int $id
     * @see DB
     * @see Cache
	 * @return array sql record
	 */
	public function getTotal($product_id) {
	   $sql = "SELECT * FROM " . DB_PREFIX . "slider_description sd 
       LEFT JOIN " . DB_PREFIX . "slider s ON (s.slider_id=sd.slider_id) 
       WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "' "; 
       
		if ($data) {
			if (isset($data['filter_title']) && !is_null($data['filter_title'])) {
				$sql .= " AND LCASE(title) LIKE '%" . $this->db->escape(strtolower($data['filter_title'])) . "%'";
			}

			$sort_data = array(
				'title',
				'status',
				'sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY title";	
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
			
		}
        
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	
	/**
	 * ModelContentSlider::getSliderStores()
	 * 
	 * @param int $slider_id
     * @see DB
     * @see Cache
	 * @return array sql records 
	 */
	public function getStores($slider_id) {
		$slider_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "slider_to_store WHERE slider_id = '" . (int)$slider_id . "'");

		foreach ($query->rows as $result) {
			$slider_store_data[] = $result['store_id'];
		}
		
		return $slider_store_data;
	}
	
	/**
	 * ModelContentSlider::sortSlider()
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function sortSlider($data) {
	   if (!is_array($data)) return false;
       $pos = 1;
       foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "slider SET sort_order = '" . (int)$pos . "' WHERE slider_id = '" . (int)$id . "'");
            $pos++;
       }
	   return true;
	}
	
    /**
     * ModelContentSlider::activate()
     * activar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function activate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "slider` SET `status` = '1' WHERE `slider_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelContentSlider::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "slider` SET `status` = '0' WHERE `slider_id` = '" . (int)$id . "'");
        return $query;
     }
}
?>