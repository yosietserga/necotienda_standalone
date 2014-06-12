<?php
/**
 * ModelSalePayment
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelSalePayment extends Model {
    
	public function getAll($data=null) {
		if ($data['start'] < 0) $data['start'] = 0;
        
		$sql = "SELECT *, ops.name AS status, op.date_added AS dateAdded, bk.name AS bank
        FROM `" . DB_PREFIX . "order_payment` op 
        LEFT JOIN `" . DB_PREFIX . "customer` c ON (c.customer_id=op.customer_id)
        LEFT JOIN `" . DB_PREFIX . "order_payment_status` ops ON (ops.order_payment_status_id=op.order_payment_status_id)
        LEFT JOIN `" . DB_PREFIX . "bank_account` ba ON (ba.bank_account_id=op.bank_account_id)
        LEFT JOIN `" . DB_PREFIX . "bank` bk ON (ba.bank_id=bk.bank_id)
        LEFT JOIN `" . DB_PREFIX . "order` o ON (o.order_id=op.order_id)";	
	
        $criteria = array();
        
        $criteria[] = " ops.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
        
        if ($data['filter_bank']) {
            $criteria[] = " bk.bank_id = '" . (int)$data['filter_bank'] . "' ";
        }
        
        if ($data['filter_transac_number']) {
            $criteria[] = " LCASE(op.transac_number) LIKE '%" . $this->db->escape(strtolower($data['filter_transac_number'])) . "%' ";
        }
        
        if ($data['filter_customer']) {
            $criteria[] = " LCASE(CONCAT(c.firstname,' ',c.lastname)) LIKE '%" . $this->db->escape(strtolower($data['filter_customer'])) . "%' ";
        }
        
        if ($data['filter_status']) {
            $criteria[] = " op.order_payment_status_id = '" . (int)$data['filter_status'] . "' ";
        }
        
        if ($data['filter_payment_id']) {
            $criteria[] = " op.order_payment_id = '" . (int)$data['filter_payment_id'] . "' ";
        }
        
        if ($data['filter_order_id']) {
            $criteria[] = " op.order_id = '" . (int)$data['filter_order_id'] . "' ";
        }
        
		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
            $implode[] = " op.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
		} elseif (!empty($data['filter_date_start'])) {
            $implode[] = " op.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
		}
    
        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }
            
		$sort_data = array(
			'op.amount',
			'op.order_id',
			'op.order_payment_status_id',
			'op.order_payment_id',
			'op.payment_method',
			'op.transac_date',
			'op.transac_number',
			'bk.name',
			'customer',
			'op.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'customer') {
                $sql .= " ORDER BY c.firstname, c.lastname ";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
		} else {
			$sql .= " ORDER BY op.date_added";	
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
        FROM `" . DB_PREFIX . "order_payment` op 
        LEFT JOIN `" . DB_PREFIX . "customer` c ON (c.customer_id=op.customer_id)
        LEFT JOIN `" . DB_PREFIX . "order_payment_status` ops ON (ops.order_payment_status_id=op.order_payment_status_id)
        LEFT JOIN `" . DB_PREFIX . "bank_account` ba ON (ba.bank_account_id=op.bank_account_id)
        LEFT JOIN `" . DB_PREFIX . "bank` bk ON (ba.bank_id=bk.bank_id)
        LEFT JOIN `" . DB_PREFIX . "order` o ON (o.order_id=op.order_id)";	
	
        $criteria = array();
        
        if ($data['filter_bank']) {
            $criteria[] = " bk.bank_id = '" . (int)$data['filter_bank'] . "' ";
        }
        
        if ($data['filter_transac_number']) {
            $criteria[] = " LCASE(op.transac_number) LIKE '%" . $this->db->escape(strtolower($data['filter_transac_number'])) . "%' ";
        }
        
        if ($data['filter_customer']) {
            $criteria[] = " LCASE(CONCAT(c.firstname,' ',c.lastname)) LIKE '%" . $this->db->escape(strtolower($data['filter_customer'])) . "%' ";
        }
        
        if ($data['filter_status']) {
            $criteria[] = " op.order_payment_status_id = '" . (int)$data['filter_status'] . "' ";
        }
        
        if ($data['filter_payment_id']) {
            $criteria[] = " op.order_payment_id = '" . (int)$data['filter_payment_id'] . "' ";
        }
        
        if ($data['filter_order_id']) {
            $criteria[] = " op.order_id = '" . (int)$data['filter_order_id'] . "' ";
        }
        
		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
            $implode[] = " op.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
		} elseif (!empty($data['filter_date_start'])) {
            $implode[] = " op.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
		}
    
        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }
            
		$query = $this->db->query($sql);	
	
		return $query->row['total'];
	}
    
    public function getById($id) {
		$sql = "SELECT *, ops.name AS status, op.date_added AS dateAdded
        FROM `" . DB_PREFIX . "order_payment` op 
        LEFT JOIN `" . DB_PREFIX . "order_payment_status` ops ON (ops.order_payment_status_id=op.order_payment_status_id)
        LEFT JOIN `" . DB_PREFIX . "bank_account` ba ON (ba.bank_account_id=op.bank_account_id)
        LEFT JOIN `" . DB_PREFIX . "order` o ON (o.order_id=op.order_id)";	
	
        $criteria = array();
        
        $criteria[] = " order_payment_id = '". (int)$id ."'";
        
        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }
        
        $result = $this->db->query($sql);
        return $result->row;
    }
    
    public function delete($id) {
        $result = $this->db->query("SELECT * FROM ". DB_PREFIX ."order_payment WHERE order_payment = '". (int)$id ."'");
    }
}
