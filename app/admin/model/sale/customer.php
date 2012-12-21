<?php
/**
 * ModelSaleCustomer
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelSaleCustomer extends Model {
	/**
	 * ModelSaleCustomer::addCustomer()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return void
	 */
	public function addCustomer($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', sexo = '" . $this->db->escape($data['sexo']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', password = '" . $this->db->escape(md5($data['password'])) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
      	
      	$customer_id = $this->db->getLastId();
      	
      	if (isset($data['addresses'])) {		
      		foreach ($data['addresses'] as $address) {	
      			$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($address['firstname']) . "', lastname = '" . $this->db->escape($address['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");
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
	public function editCustomer($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', sexo = '" . $this->db->escape($data['sexo']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
      	if ($data['password']) {
        	$this->db->query("UPDATE " . DB_PREFIX . "customer SET password = '" . $this->db->escape(md5($data['password'])) . "' WHERE customer_id = '" . (int)$customer_id . "'");
      	}
      	
      	$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
      	
      	if (isset($data['addresses'])) {
      		foreach ($data['addresses'] as $address) {	
				$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($address['firstname']) . "', lastname = '" . $this->db->escape($address['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");
			}
		}
	}
	
	/**
	 * ModelSaleCustomer::getAddressesByCustomerId()
	 * 
	 * @param int $customer_id
     * @see DB
	 * @return array sql records
	 */
	public function getAddressesByCustomerId($customer_id) {
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
	 * ModelSaleCustomer::deleteCustomer()
	 * 
	 * @param int $customer_id
     * @see DB
	 * @return void
	 */
	public function deleteCustomer($customer_id) {
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
     * ModelSaleCustomer::getCustomerBySubscribe()
     * 
     * @see DB
	 * @return array sql records
     */
    public function getCustomerBySubscribe() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE newsletter = 1");
        return $query->rows;
    }	
    
	/**
	 * ModelSaleCustomer::getCustomers()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return array sql records
	 */
	public function getCustomers($data = array()) {
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
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "c.email = '" . $this->db->escape($data['filter_email']) . "'";
		}
		
		if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
			$implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}	
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}		
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
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
     * ModelSaleCustomer::getCumpleaneros()
     * 
     * @param mixed $data
     * @see DB
	 * @return array sql records
     */
    public function getCumpleaneros($data) {
        $hoy = getdate();
        $datMes  = $hoy['mon'];
        $datDia  = $hoy['mday'];
        $cumpleaneros = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "customer ";		
		$sort_data = array(
			'firstname',
			'email',
			'facebook',
			'twitter',
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY firstname";	
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
        if ($query->num_rows) {
            foreach ($query->rows as $value) {
                $datDay = substr($value['nacimiento'],0,2);
                $datMonth = substr($value['nacimiento'],4,2);
                if (($datMes == $datMonth) && ($datDay == $datDia)){
                    $cumpleaneros[] = array (
                    'customer_id' => $value['customer_id'],
                    'name' => $value['firstname'].' '.$value['lastname'],
                    'email' => $value['email'],
                    'facebook' => $value['facebook'],
                    'twitter' => $value['twitter'],
                    'telephone' => $value['telephone']
                    );
                }
            }
        }		
		return $cumpleaneros;	
	}
	
    /**
     * ModelSaleCustomer::getTotalCumpleaneros()
     * 
     * @see DB
	 * @return int Count sql records
     */
    public function getTotalCumpleaneros() {
        $hoy = getdate();
        $datMes  = $hoy['mon'];
        $datDia  = $hoy['mday'];
        $total = 0;
        $sql = "SELECT COUNT(*) AS total, nacimiento FROM " . DB_PREFIX . "customer GROUP BY nacimiento";		
		$query = $this->db->query($sql);
        if ($query->num_rows) {
            foreach ($query->rows as $value) {
                $datDay = substr($value['nacimiento'],0,2);
                $datMonth = substr($value['nacimiento'],4,2);
                if (($datMes == $datMonth) && ($datDay == $datDia)){
                    $total ++;
                }
            }
        }
		return $total;	
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
	 * ModelSaleCustomer::getCustomersByNewsletter()
	 * 
     * @see DB
	 * @return array sql records
	 */
	public function getCustomersByNewsletter() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE newsletter = '1' ORDER BY firstname, lastname, email");
	
		return $query->rows;
	}
	
	/**
	 * ModelSaleCustomer::getCustomersByKeyword()
	 * 
	 * @param string $keyword
     * @see DB
	 * @return array sql records
	 */
	public function getCustomersByKeyword($keyword) {
		if ($keyword) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LCASE(CONCAT(firstname, ' ', lastname)) LIKE '%" . $this->db->escape(strtolower($keyword)) . "%' ORDER BY firstname, lastname, email");
	
			return $query->rows;
		} else {
			return array();	
		}
	}
	
	/**
	 * ModelSaleCustomer::getCustomersByProduct()
	 * 
	 * @param int $product_id
     * @see DB
	 * @return array sql records
	 */
	public function getCustomersByProduct($product_id) {
		if ($product_id) {
			$query = $this->db->query("SELECT DISTINCT `email` FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE op.product_id = '" . (int)$product_id . "' AND o.order_status_id <> '0'");
	
			return $query->rows;
		} else {
			return array();	
		}
	}
	
	/**
	 * ModelSaleCustomer::getAddresses()
	 * 
	 * @param string $keyword
     * @see DB
	 * @return array sql records
	 */
	public function getAddresses($keyword) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
	
		return $query->rows;
	}
	
	/**
	 * ModelSaleCustomer::getTotalCustomers()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalCustomers($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";
		
		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
		}	
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}			
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
				
		$query = $this->db->query($sql);
				
		return $query->row['total'];
	}
		
	/**
	 * ModelSaleCustomer::getTotalCustomersAwaitingApproval()
	 * 
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalCustomersAwaitingApproval() {
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
	 * ModelSaleCustomer::getTotalCustomersByCustomerGroupId()
	 * 
	 * @param int $customer_group_id
     * @see DB
	 * @return Count sql records
	 */
	public function getTotalCustomersByCustomerGroupId($customer_group_id) {
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
