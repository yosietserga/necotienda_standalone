<?php
/**
 * ModelSaleBalance
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelSaleBalance extends Model {
    
	public function getAll($data=null) {
		if ($data['start'] < 0) $data['start'] = 0;
        
		$sql = "SELECT *, b.date_added aS dateAdded
        FROM `" . DB_PREFIX . "balance` b 
        LEFT JOIN `" . DB_PREFIX . "customer` c ON (c.customer_id=b.customer_id) ";	
	
        $criteria = array();
        
        if ($data['filter_balance_id']) {
            $criteria[] = " b.balance_id = '" . (int)$data['filter_balance_id'] . "' ";
        }
        
        if ($data['filter_type']) {
            $criteria[] = " b.`type` = '" . $this->db->escape($data['filter_type']) . "' ";
        }
        
		if (!empty($data['filter_amount_start']) && !empty($data['filter_amount_end'])) {
            $criteria[] = " amount BETWEEN '" . (float)$data['filter_amount_start'] . "' AND '" . (float)$data['filter_amount_end'] . "'";
		} elseif (!empty($data['filter_amount_start'])) {
            $criteria[] = " amount >= '" . (float)$data['filter_amount_start'] . "' ";
		} elseif (!empty($data['filter_amount_end'])) {
            $criteria[] = " amount <= '" . (float)$data['filter_amount_end'] . "' ";
		}
        
        if ($data['filter_customer']) {
            $criteria[] = " LCASE(CONCAT(c.firstname,' ',c.lastname)) LIKE '%" . $this->db->escape(strtolower($data['filter_customer'])) . "%' ";
        }
        
		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
            $criteria[] = " b.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
		} elseif (!empty($data['filter_date_start'])) {
            $criteria[] = " b.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
		}
        
        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }
            
		$sort_data = array(
			'b.amount',
			'b.amount_available',
			'b.balance_id',
			'customer',
			'b.`type`',
			'b.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'customer') {
                $sql .= " ORDER BY c.firstname, c.lastname ";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
		} else {
			$sql .= " ORDER BY b.date_added";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}
		
	    if ($data['start'] < 0) {
    	   $data['start'] = 0;
        }
	    if (!$data['limit'] || $data['limit'] < 1) {
    	   $data['limit'] = 50;
        }
    			
        $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        
		$query = $this->db->query($sql);	
	
		return $query->rows;
	}
    
	public function getTotalAll($data=null) {
		$sql = "SELECT COUNT(*) AS total
        FROM `" . DB_PREFIX . "balance` b 
        LEFT JOIN `" . DB_PREFIX . "customer` c ON (c.customer_id=b.customer_id) ";	
	
        $criteria = array();
        
        if ($data['filter_balance_id']) {
            $criteria[] = " b.balance_id = '" . (int)$data['balance_id'] . "' ";
        }
        
        if ($data['filter_type']) {
            $criteria[] = " b.`type` = '" . $this->db->escape($data['filter_type']) . "' ";
        }
        
		if (!empty($data['filter_amount_start']) && !empty($data['filter_amount_end'])) {
            $implode[] = " amount BETWEEN '" . (float)$data['filter_amount_start'] . "' AND '" . (float)$data['filter_amount_end'] . "'";
		} elseif (!empty($data['filter_amount_start'])) {
            $implode[] = " amount >= '" . (float)$data['filter_amount_start'] . "' ";
		} elseif (!empty($data['filter_amount_end'])) {
            $implode[] = " amount <= '" . (float)$data['filter_amount_end'] . "' ";
		}
        
        if ($data['filter_customer']) {
            $criteria[] = " LCASE(CONCAT(c.firstname,' ',c.lastname)) LIKE '%" . $this->db->escape(strtolower($data['filter_customer'])) . "%' ";
        }
        
		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
            $implode[] = " b.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
		} elseif (!empty($data['filter_date_start'])) {
            $implode[] = " b.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
		}
        
        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }
            
		$query = $this->db->query($sql);	
	
		return $query->row['total'];
	}
    
    public function getById($id) {
		$sql = "SELECT *
        FROM `" . DB_PREFIX . "balance` b 
        LEFT JOIN `" . DB_PREFIX . "customer` c ON (b.customer_id=c.customer_id)";	
	
        $criteria = array();
        
        $criteria[] = " balance_id = '". (int)$id ."'";
        
        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }
        
        $result = $this->db->query($sql);
        return $result->row;
    }
    
    public function delete($id) {
        $result = $this->db->query("SELECT * FROM ". DB_PREFIX ."balance WHERE balance_id = '". (int)$id ."'");
    }
}
