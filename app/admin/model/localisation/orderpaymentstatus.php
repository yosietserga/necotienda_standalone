<?php 
class ModelLocalisationOrderPaymentStatus extends Model {
	public function add($data) {
		foreach ($data['order_payment_status'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_payment_status SET 
            language_id = '" . (int)$language_id . "', 
            name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->cache->delete('order_payment_status');
	}

	public function update($id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_payment_status WHERE order_payment_status_id = '" . (int)$id . "'");

		foreach ($data['order_payment_status'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_payment_status SET 
            order_payment_status_id = '" . (int)$id . "', 
            language_id = '" . (int)$language_id . "', 
            name = '" . $this->db->escape($value['name']) . "'");
		}
				
		$this->cache->delete('order_payment_status');
	}
	
	public function delete($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_payment_status WHERE order_payment_status_id = '" . (int)$id . "'");
	
		$this->cache->delete('order_payment_status');
	}
		
	public function getById($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_payment_status 
        WHERE order_payment_status_id = '" . (int)$id . "' 
        AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
		
	public function getAll($data = array()) {
      	if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "order_payment_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			$sql .= " ORDER BY name";	
			
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
		} else {
			$order_payment_status_data = $this->cache->get('order_payment_status.' . $this->config->get('config_language_id'));
		
			if (!$order_payment_status_data) {
				$query = $this->db->query("SELECT order_payment_status_id, name 
                FROM " . DB_PREFIX . "order_payment_status 
                WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' 
                ORDER BY name");
	
				$order_payment_status_data = $query->rows;
			
				$this->cache->set('order_payment_status.' . $this->config->get('config_language_id'), $order_payment_status_data);
			}	
	
			return $order_payment_status_data;				
		}
	}
	
	public function getDescriptions($id) {
		$order_payment_status_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_payment_status WHERE order_payment_status_id = '" . (int)$id . "'");
		
		foreach ($query->rows as $result) {
			$order_payment_status_data[$result['language_id']] = array('name' => $result['name']);
		}
		
		return $order_payment_status_data;
	}
	
	public function getAllTotal() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_payment_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}	
}
