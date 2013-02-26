<?php
class ModelStoreReview extends Model {
	public function addReview($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "review SET 
        author = '" . $this->db->escape($data['author']) . "', 
        product_id = '" . (int)$data['product_id'] . "', 
        text = '" . $this->db->escape(strip_tags($data['text'])) . "', 
        rating = '" . (int)$data['rating'] . "', 
        status = '1', 
        date_added = NOW()");
        return $this->db->getLastId();
	}
	
	public function editReview($review_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['author']) . "', product_id = '" . $this->db->escape($data['product_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW() WHERE review_id = '" . (int)$review_id . "'");
	}
	
	public function delete($review_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE review_id = '" . (int)$review_id . "'");
	}
	
	public function getReview($review_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "review WHERE review_id = '" . (int)$review_id . "'");
		
		return $query->row;
	}

	public function getReviews($data = array()) {
		$sql = "SELECT *, r.status AS rstatus, r.date_added AS created FROM " . DB_PREFIX . "review r 
            LEFT JOIN " . DB_PREFIX . "product_description pd ON (r.product_id = pd.product_id) 
            LEFT JOIN " . DB_PREFIX . "customer c ON (c.customer_id = r.customer_id)";																					
			if (isset($data['filter_author'])) {
				$sql .= " WHERE LCASE(name) LIKE '%" . $this->db->escape(strtolower($data['filter_author'])) . "%'";
			}

			if (isset($data['filter_date_start'],$data['filter_date_end'],$data['filter_author'])) {
				$sql .= " AND r.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
			} elseif (isset($data['filter_date_start'],$data['filter_author'])) {
				$sql .= " AND r.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
			} elseif (isset($data['filter_date_start'],$data['filter_date_end']) && !isset($data['filter_author'])) {
				$sql .= " WHERE r.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
			} elseif (isset($data['filter_date_start']) && !isset($data['filter_author'])) {
				$sql .= " WHERE r.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
			}

            if (isset($data['filter_product'],$data['filter_author']) || isset($data['filter_product'],$data['filter_date_start'])) {
                $sql .= " AND r.review_id IN (SELECT review_id 
                    FROM " . DB_PREFIX . "review p2
                        LEFT JOIN " . DB_PREFIX . "product_description pd ON (p2.product_id=pd.product_id) 
                    WHERE LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($data['filter_product'])) . "%'
                        AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
            } elseif (isset($data['filter_product']) && !isset($data['filter_author'],$data['filter_date_start'])) {
                $sql .= " WHERE r.review_id IN (SELECT review_id 
                    FROM " . DB_PREFIX . "review p2
                        LEFT JOIN " . DB_PREFIX . "product_description pd ON (p2.product_id=pd.product_id) 
                    WHERE LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($data['filter_product'])) . "%'
                        AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
            }
											  
		
		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY r.date_added";	
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
	
	public function getTotalReviews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review");
		
		return $query->row['total'];
	}
	
	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review WHERE status = '0'");
		
		return $query->row['total'];
	}	
	/**
	 * ModelStoreProduct::sortProduct()
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function sortProduct($data) {
	   if (!is_array($data)) return false;
       $pos = 1;
       foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "review SET sort_order = '" . (int)$pos . "' WHERE review_id = '" . (int)$id . "'");
            $pos++;
       }
	   return true;
	}
	
    /**
     * ModelStoreProduct::activate()
     * activar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function activate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "review` SET `status` = '1' WHERE `review_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelStoreProduct::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "review` SET `status` = '0' WHERE `review_id` = '" . (int)$id . "'");
        return $query;
     }
}
