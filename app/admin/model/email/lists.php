<?php 
class ModelEmailLists extends Model {
	public function addList($data) {		
       $subscribe_count = sizeof($data['customer_id']);
       $sql = "INSERT INTO " . DB_PREFIX . "email_lists SET 
        `name` = '" . $this->db->escape($data['name']) . "',
        `bounce_email` = '" . $this->db->escape($data['bounce_email']) . "',
        `replyto_email` = '" . $this->db->escape($data['replyto_email']) . "',
        `format` = '" . $this->db->escape($data['format']) . "',
        `notify` = '" . $this->db->escape($data['notify']) . "'";
        foreach ($data['extra_mail_settings'] as $extra_setting) {
            $strSettings .= '/'.$extra_setting;
        }
        
		$query = $this->db->query($sql);
        
        $list_id = $this->db->getLastId();
        
        if (isset($data['customer_id'])) {
			foreach ($data['customer_id'] as $key => $customer_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "email_list_members SET 
                list_id = '" . (int)$list_id . "', 
                customer_id = '" . (int)$customer_id . "',
                email = '" . $this->db->escape($data['email'][$key]) . "',
                subscribed = 1,
                date_added = now()");
			}
		}
        if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "email_list_interes SET 
                list_id = '" . (int)$list_id . "', 
                category_id = '" . (int)$category_id . "',
                date_added = now()");
			}
		}
	}
	
	public function editList($list_id,$data) {
	    $subscribe_count = sizeof($data['customer_id']);
        $sql = "UPDATE " . DB_PREFIX . "email_lists SET 
        `name` = '" . $this->db->escape($data['name']) . "',
        `format` = '" . $this->db->escape($data['format']) . "',
        `notify` = '" . $this->db->escape($data['notify']) . "'";
        $sql .= "`extra_mail_settings` = '" . $this->db->escape($strSettings) . "',
        `imap_account` = '" . $this->db->escape($data['imap_account']) . "',
        `process_bounce` = '" . $this->db->escape($data['process_bounce']) . "',
        `agree_delete` = '" . $this->db->escape($data['agree_delete']) . "',
        `date_modified` = now(),
        `subscribe_count` = '" . (int)$subscribe_count . "'
        WHERE `list_id` = ". (int)$list_id;
        
		$query = $this->db->query($sql);

        $this->db->query("DELETE FROM `" . DB_PREFIX . "email_list_members` WHERE `list_id` = '" . (int)$list_id . "'");
        foreach ($data['customer_id'] as $key => $customer_id) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "email_list_members SET 
            list_id = '" . (int)$list_id . "', 
            customer_id = '" . (int)$customer_id . "',
            email = '" . $this->db->escape($data['email'][$key]) . "',
            subscribed = 1,
            date_added = now(),
            date_modified = now()");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "email_list_interes WHERE `list_id` = " . (int)$list_id);
		foreach ($data['product_category'] as $category_id) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "email_list_interes SET 
            list_id = '" . (int)$list_id . "', 
            category_id = '" . (int)$category_id . "',
            date_added = now(),
            date_modified = now()");
   		}
	}
    
    public function getAllLists() {
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_lists");
        return $result->rows;   
    }
    
    public function getNewsletterLists($list_id) {
		$result = $this->db->query("SELECT *, COUNT(member_id) as total FROM " . DB_PREFIX . "email_lists l LEFT JOIN " . DB_PREFIX . "email_list_members lm ON (l.list_id = lm.list_id) WHERE l.list_id = ".(int)$list_id." ORDER BY l.name");
        return $result->row;   
    }
    
    public function getLists($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "email_lists ";

		
		if (isset($data['filter_list_id']) && !is_null($data['filter_list_id'])) {
			$sql .= " AND list_id = '" . (int)$data['filter_list_id'] . "'";
		}

		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$sql .= " AND name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if (isset($data['filter_subscribe_count']) && !is_null($data['filter_subscribe_count'])) {
			$sql .= " AND subscribe_count = '" . (float)$data['filter_subscribe_count'] . "'";
		}

		$sort_data = array(
			'list_id',
			'name',
			'date_added',
			'subscribe_count',
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY list_id";	
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
    
    public function getList($list_id){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_lists WHERE `list_id` = ".(int)$list_id);
        return $query->row;
    }
    
    public function getListByMember($member_id) {
		$list_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_list_members WHERE `customer_id` = '" . (int)$member_id . "'");
		
		foreach ($query->rows as $result) {
			$list_data[] = $result['list_id'];
		}

		return $list_data;
	}
     
    public function getMembers($list_id) {
		$customers_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_list_members WHERE `list_id` = '" . (int)$list_id . "'");
		
		foreach ($query->rows as $result) {
			$customers_data[] = $result['customer_id'];
		}

		return $customers_data;
	}
    
    public function getFullLists($list_id,$language_id) {
        $a = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_lists WHERE `list_id` = ".(int)$list_id);
        
            $a['list_id'] = $query->row['list_id'];
            $a['list_name'] = $query->row['name'];             

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_list_interes li LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = li.category_id) WHERE li.list_id = '".(int)$list_id."' AND cd.language_id = '".(int)$language_id."' ORDER BY cd.name");
        foreach ($query->rows as $result) {
            $a[] = array (
                'category_id' => $result['category_id'],
                'category_name' => $result['name'],
                'listID' => $result['list_id']             
            );
        }
		return $a;    
    }
    
    public function deleteMemberFromList($data) {
        $query = $this->db->query("DELETE FROM " . DB_PREFIX . "email_list_members WHERE list_id ='".(int)$data['list_id']."' AND customer_id = '".(int)$data['member_id']."'");
    }
    
    public function deleteMemberFromAllLists($data) {
        $query = $this->db->query("DELETE FROM " . DB_PREFIX . "email_list_members WHERE customer_id = '".(int)$data['member_id']."'");
    }
    
    public function addMemberToList($data) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_list_members WHERE list_id ='".(int)$data['list_id']."' AND customer_id = '".(int)$data['member_id']."'");
        if ($query->row) {
            return false;
        } else {
            $query = $this->db->query("INSERT INTO " . DB_PREFIX . "email_list_members SET 
                list_id = '" . (int)$data['list_id'] . "', 
                customer_id = '" . (int)$data['member_id'] . "',
                email = '" . $this->db->escape($data['email']) . "',
                subscribed = 1,
                date_added = now()");
        }
    }
    
    public function addMemberToAllLists($data) {
        $lists = $this->getAllLists();
        foreach($lists as $list) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_list_members WHERE list_id ='".(int)$data['list_id']."' AND customer_id = '".(int)$data['member_id']."'");
            if ($query->row) {
                return false;
            } else {
                $query = $this->db->query("INSERT INTO " . DB_PREFIX . "email_list_members SET 
                    list_id = '" . (int)$list['list_id'] . "', 
                    customer_id = '" . (int)$data['member_id'] . "',
                    email = '" . $this->db->escape($data['email']) . "',
                    subscribed = 1,
                    date_added = now()");
            }
        }
    }
    
    public function getIntereses($list_id) {
		$category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_list_interes WHERE `list_id` = '" . (int)$list_id . "'");
		
		foreach ($query->rows as $result) {
			$category_data[] = $result['category_id'];
		}

		return $category_data;
	}
    
    public function getTotalLists($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "email_lists`";
		
		if (isset($data['filter_list_id']) && !is_null($data['filter_list_id'])) {
			$sql .= " AND list_id = '" . (int)$data['filter_list_id'] . "'";
		}

		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$sql .= " AND name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if (isset($data['subscribe_count']) && !is_null($data['subscribe_count'])) {
			$sql .= " AND subscribe_count = '" . (float)$data['subscribe_count'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	} 

}
?>