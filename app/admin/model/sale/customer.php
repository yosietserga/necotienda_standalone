<?php
/**
 * ModelSaleCustomer
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelSaleCustomer extends Model {
	/**
	 * ModelSaleCustomer::add()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return void
	 */
	public function add($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET 
          firstname = '" . $this->db->escape($data['firstname']) . "', 
          lastname = '" . $this->db->escape($data['lastname']) . "', 
          company = '" . $this->db->escape($data['company']) . "', 
          rif = '" . $this->db->escape($data['rif']) . "', 
          email = '" . $this->db->escape($data['email']) . "', 
          sexo = '" . $this->db->escape($data['sexo']) . "', 
          telephone = '" . $this->db->escape($data['telephone']) . "', 
          fax = '" . $this->db->escape($data['fax']) . "', 
          newsletter = '" . (int)$data['newsletter'] . "', 
          customer_group_id = '" . (int)$data['customer_group_id'] . "', 
          password = '" . $this->db->escape(md5($data['password'])) . "', 
          approved = '1', 
          status = '1', 
          date_added = NOW()");
      	
      	$customer_id = $this->db->getLastId();
      	
      	if (isset($data['addresses'])) {		
      		foreach ($data['addresses'] as $address) {	
      			$this->db->query("INSERT INTO " . DB_PREFIX . "address SET 
                  customer_id = '" . (int)$customer_id . "', 
                  firstname = '" . $this->db->escape($address['firstname']) . "', 
                  lastname = '" . $this->db->escape($address['lastname']) . "', 
                  company = '" . $this->db->escape($address['company']) . "', 
                  address_1 = '" . $this->db->escape($address['address_1']) . "', 
                  address_2 = '" . $this->db->escape($address['address_2']) . "', 
                  city = '" . $this->db->escape($address['city']) . "', 
                  postcode = '" . $this->db->escape($address['postcode']) . "', 
                  country_id = '" . (int)$address['country_id'] . "', 
                  zone_id = '" . (int)$address['zone_id'] . "'");
			}
		}
	}
	
	/**
	 * ModelSaleCustomer::editCustomer()
	 * 
	 * @param int $customer_id
	 * @param mixed $data
     * @see DB
	 * @return void
	 */
	public function update($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET 
            firstname = '" . $this->db->escape($data['firstname']) . "', 
            lastname = '" . $this->db->escape($data['lastname']) . "', 
            company = '" . $this->db->escape($data['company']) . "', 
            rif = '" . $this->db->escape($data['rif']) . "', 
            email = '" . $this->db->escape($data['email']) . "', 
            sexo = '" . $this->db->escape($data['sexo']) . "', 
            telephone = '" . $this->db->escape($data['telephone']) . "', 
            fax = '" . $this->db->escape($data['fax']) . "', 
            newsletter = '" . (int)$data['newsletter'] . "', 
            customer_group_id = '" . (int)$data['customer_group_id'] . "'
        WHERE customer_id = '" . (int)$customer_id . "'");
	
      	if ($data['password']) {
        	$this->db->query("UPDATE " . DB_PREFIX . "customer SET 
            password = '" . $this->db->escape(md5($data['password'])) . "' 
            WHERE customer_id = '" . (int)$customer_id . "'");
      	}
      	
      	$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
      	
      	if (isset($data['addresses'])) {
      		foreach ($data['addresses'] as $address) {	
				$this->db->query("INSERT INTO " . DB_PREFIX . "address SET 
                customer_id = '" . (int)$customer_id . "', 
                firstname = '" . $this->db->escape($address['firstname']) . "', 
                lastname = '" . $this->db->escape($address['lastname']) . "', 
                company = '" . $this->db->escape($address['company']) . "', 
                address_1 = '" . $this->db->escape($address['address_1']) . "', 
                address_2 = '" . $this->db->escape($address['address_2']) . "', 
                city = '" . $this->db->escape($address['city']) . "', 
                postcode = '" . $this->db->escape($address['postcode']) . "', 
                country_id = '" . (int)$address['country_id'] . "', 
                zone_id = '" . (int)$address['zone_id'] . "'");
			}
		}
	}
	
	/**
	 * ModelSaleCustomer::getAddresses()
	 * 
	 * @param int $customer_id
     * @see DB
	 * @return array sql records
	 */
	public function getAddresses($customer_id) {
		$address_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
	
		foreach ($query->rows as $result) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$result['country_id'] . "'");
			
			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';	
				$address_format = '';
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$result['zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$code = $zone_query->row['code'];
			} else {
				$zone = '';
				$code = '';
			}		
		
			$address_data[] = array(
				'address_id'     => $result['address_id'],
				'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				'company'        => $result['company'],
				'address_1'      => $result['address_1'],
				'address_2'      => $result['address_2'],
				'postcode'       => $result['postcode'],
				'city'           => $result['city'],
				'zone_id'        => $result['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $code,
				'country_id'     => $result['country_id'],
				'country'        => $country,	
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format
			);
		}		
		
		return $address_data;
	}	
	
	/**
	 * ModelSaleCustomer::delete()
	 * 
	 * @param int $customer_id
     * @see DB
	 * @return void
	 */
	public function delete($customer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
	}
	
	/**
	 * ModelSaleCustomer::getCustomer()
	 * 
	 * @param int $customer_id
     * @see DB
	 * @return array sql record
	 */
	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
	
		return $query->row;
	}
	
	/**
	 * ModelSaleCustomer::getAll()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return array sql records
	 */
	public function getAll($data = array()) {
		$sql = "SELECT c.*,a.*, c.customer_id as cid, co.name as country, z.name as zone, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group 
        FROM " . DB_PREFIX . "customer c 
        LEFT JOIN " . DB_PREFIX . "customer_group cg 
            ON (c.customer_group_id = cg.customer_group_id) 
        LEFT JOIN " . DB_PREFIX . "address a 
            ON (c.address_id = a.address_id)
        LEFT JOIN " . DB_PREFIX . "country co 
            ON (co.country_id = a.country_id)
        LEFT JOIN " . DB_PREFIX . "zone z 
            ON (z.zone_id = a.zone_id) ";

		$implode = array();
		
		if (!empty($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . strtolower($this->db->escape($data['filter_name'])) . "%'";
		}
		
		if (!empty($data['filter_email'])) {
			$implode[] = "LCASE(c.email) LIKE '%" . $this->db->escape(strtolower($data['filter_email'])) . "%'";
		}
		
		if (!empty($data['customer_group_id'])) {
			$implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}	
		/*
        //TODO: pensar mejor como condicionar el status del cliente
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		*/
		if (!empty($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}		
		
		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
            $implode[] = " c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
		} elseif (!empty($data['filter_date_start'])) {
            $implode[] = " c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
		}
    
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
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
	 * ModelSaleCustomer::approve()
	 * 
	 * @param int $customer_id
     * @see DB
	 * @return void
	 */
	public function approve($customer_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET approved = '1' WHERE customer_id = '" . (int)$customer_id . "'");
	}
	
	/**
	 * ModelSaleCustomer::getAllTotal()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return int Count sql records
	 */
	public function getAllTotal($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer c";
		
		$implode = array();
		
		if (!empty($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(strtolower(trim($data['filter_name']))) . "%'";
		}
		
		if (!empty($data['filter_email'])) {
			$implode[] = "LCASE(c.email) LIKE '%" . $this->db->escape(strtolower(trim($data['filter_email']))) . "%'";
		}
		
		if (!empty($data['customer_group_id'])) {
			$implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}	
		/*
        //TODO: pensar mejor como condicionar el status del cliente
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		*/
		if (!empty($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}		
		
		if (!empty($data['filter_date_start']) && !empty($data['filter_date_end'])) {
            $implode[] = " c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
		} elseif (!empty($data['filter_date_start'])) {
            $implode[] = " c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
		}
    
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
				
		$query = $this->db->query($sql);
				
		return $query->row['total'];
	}
		
	/**
	 * ModelSaleCustomer::getAllTotalAwaitingApproval()
	 * 
     * @see DB
	 * @return int Count sql records
	 */
	public function getAllTotalAwaitingApproval() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE status = '0' OR approved = '0'");

		return $query->row['total'];
	}
	
	/**
	 * ModelSaleCustomer::getTotalAddressesByCustomerId()
	 * 
	 * @param int $customer_id
     * @see DB
	 * @return int Count sql recors
	 */
	public function getTotalAddressesByCustomerId($customer_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
		
		return $query->row['total'];
	}
	
	/**
	 * ModelSaleCustomer::getTotalAddressesByCountryId()
	 * 
	 * @param int $country_id
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalAddressesByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE country_id = '" . (int)$country_id . "'");
		
		return $query->row['total'];
	}	
	
	/**
	 * ModelSaleCustomer::getTotalAddressesByZoneId()
	 * 
	 * @param int $zone_id
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalAddressesByZoneId($zone_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE zone_id = '" . (int)$zone_id . "'");
		
		return $query->row['total'];
	}
	
	/**
	 * ModelSaleCustomer::getAllTotalByCustomerGroupId()
	 * 
	 * @param int $customer_group_id
     * @see DB
	 * @return Count sql records
	 */
	public function getAllTotalByCustomerGroupId($customer_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		
		return $query->row['total'];
	}
    	
    /**
     * ModelCatalogProduct::activate()
     * activar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function activate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `status` = '1' WHERE `customer_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelCatalogProduct::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `status` = '0' WHERE `customer_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelCatalogProduct::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desapprove($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `approved` = '0' WHERE `customer_id` = '" . (int)$id . "'");
        return $query;
     }
}
