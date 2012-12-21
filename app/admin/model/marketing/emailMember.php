<?php
class ModelMarketingMember extends Model {
	public function addMember($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', password = '" . $this->db->escape(md5($data['password'])) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
      	
      	$customer_id = $this->db->getLastId();
      	
      	if (isset($data['addresses'])) {		
      		foreach ($data['addresses'] as $address) {	
      			$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($address['firstname']) . "', lastname = '" . $this->db->escape($address['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");
			}
		}
	}
	
	public function editMember($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
	
    
    public function setMemberDown($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
    public function setMemberUp($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
    public function setMemberBlock($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
    public function setMemberBanned($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
    public function setMembersDown($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
    public function setMembersUp($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
    public function setMembersBlock($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
    public function setMembersBanned($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
	public function getMember($member_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "email_list_members lm ON (c.customer_id = lm.customer_id) WHERE lm.customer_id = '" . (int)$member_id . "'");
		return $query->row;
	}
    
	public function getMemberExport($member_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "email_list_members lm ON (c.customer_id = lm.customer_id) LEFT JOIN " . DB_PREFIX . "address a ON (a.address_id = c.address_id) WHERE lm.customer_id = '" . (int)$member_id . "'");
		return $query->row;
	}
	
    public function getMemberBySubscribe() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE newsletter = 1");
        return $query->rows;
    }	
    
    public function getMemberDown($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
    public function getMemberUp($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
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
    
	public function getMembers($data = array()) {
		$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "address a ON (c.address_id=a.address_id)";

		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "c.email = '" . $this->db->escape($data['filter_email']) . "'";
		}
        
		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}			
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'name',
			'email',
			'newsletter',
			'date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY c.name";	
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
    
	public function getTotalMembersByList($member_id) {
		$query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "email_list_members WHERE customer_id = ".(int)$member_id);
	
		return $query->row;
	}
    
	public function getMembersByList($list_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_list_members lm LEFT JOIN " . DB_PREFIX . "customer c ON (lm.customer_id = c.customer_id) WHERE lm.list_id = ".(int)$list_id);
	
		return $query->rows;
	}
	
	public function getTotalMembers($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";
		
		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
		}	
		
		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "newsletter = '" . (int)$data['filter_newsletter'] . "'";
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
}
