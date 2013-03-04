<?php
/**
 * ModelSaleCustomerGroup
 * 
 * @package   NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelSaleCustomerGroup extends Model {
	/**
	 * ModelSaleCustomerGroup::addCustomerGroup()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return void
	 */
	public function addCustomerGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group SET 
        name = '" . $this->db->escape($data['name']) . "',
        cant_orders = '" . (int)$data['cant_orders'] . "',
        cant_invoices = '" . (int)$data['cant_invoices'] . "',
        cant_reviews = '" . (int)$data['cant_reviews'] . "',
        cant_references = '" . (int)$data['cant_references'] . "',
        total_orders = '" . (int)$data['total_orders'] . "',
        total_invoices = '" . (int)$data['total_invoices'] . "',
        total_reviews = '" . (int)$data['total_reviews'] . "',
        total_references = '" . (int)$data['total_references'] . "'");
	}
	
	/**
	 * ModelSaleCustomerGroup::editCustomerGroup()
	 * 
	 * @param int $customer_group_id
	 * @param mixed $data
     * @see DB
	 * @return void
	 */
	public function editCustomerGroup($customer_group_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_group SET 
        name = '" . $this->db->escape($data['name']) . "',
        cant_orders = '" . (int)$data['cant_orders'] . "',
        cant_invoices = '" . (int)$data['cant_invoices'] . "',
        cant_reviews = '" . (int)$data['cant_reviews'] . "',
        cant_references = '" . (int)$data['cant_references'] . "',
        total_orders = '" . (int)$data['total_orders'] . "',
        total_invoices = '" . (int)$data['total_invoices'] . "',
        total_reviews = '" . (int)$data['total_reviews'] . "',
        total_references = '" . (int)$data['total_references'] . "'
        WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	}
	
	/**
	 * ModelSaleCustomerGroup::deleteCustomerGroup()
	 * 
	 * @param int $customer_group_id
     * @see DB
	 * @return void
	 */
	public function deleteCustomerGroup($customer_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	}
	
	/**
	 * ModelSaleCustomerGroup::getCustomerGroup()
	 * 
	 * @param int $customer_group_id
     * @see DB
	 * @return array sql record
	 */
	public function getCustomerGroup($customer_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		
		return $query->row;
	}
	
	/**
	 * ModelSaleCustomerGroup::getCustomerGroups()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return array sql records
	 */
	public function getCustomerGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_group";
		
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
	}
	
	/**
	 * ModelSaleCustomerGroup::getTotalCustomerGroups()
	 * 
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalCustomerGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_group");
		
		return $query->row['total'];
	}
	
	/**
	 * ModelSaleCustomerGroup::getTotalCustomerGroups()
	 * 
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalCustomersByGroup($id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE customer_group_id = '" .(int)$id. "'");
		
		return $query->row['total'];
	}
    
    /**
     * ModelCatalogProduct::activate()
     * activar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function activate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "customer_group` SET `status` = '1' WHERE `customer_group_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelCatalogProduct::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "customer_group` SET `status` = '0' WHERE `customer_group_id` = '" . (int)$id . "'");
        return $query;
     }
}
