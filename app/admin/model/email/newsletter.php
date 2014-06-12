<?php
/**
 * ModelEmailNewsletter
 * 
 * @package NecoTienda
 * @author Inversiones Necoyoad, C.A.
 * @copyright 2010
 * @version $Id$
 * @access public
 */
class ModelEmailNewsletter extends Model {
	/**
	 * ModelEmailNewsletter::create()
     * 
	 * Registra la información de la campaña en la base de datos y coloca todos los
     * enlaces a la url completa
     * 
     * @see DB::escape()
     * @see DB::query()
     * @see DB::getLastId()
	 * @return int $newsletter_id
	 */
	public function create($data) {
	   $data['htmlbody'] = html_entity_decode($data['htmlbody']);
      	$this->db->query("INSERT INTO " . DB_PREFIX . "email_newsletters SET 
          `name`        = '" . $this->db->escape($data['name']) . "', 
          `description` = '" . $this->db->escape($data['description']) . "', 
          `format`      = '" . $this->db->escape($data['format']) . "', 
          `subject`     = '" . $this->db->escape($data['subject']) . "', 
          `textbody`    = '" . $this->db->escape($data['textbody']) . "', 
          `htmlbody`    = '" . $this->db->escape($data['htmlbody']) . "', 
          `from_name`     = '" . ucwords($this->db->escape($data['from_name'])) . "',
          `from_email`    = '" . strtolower($this->db->escape($data['from_email'])) . "',
          `bounce_email`    = '" . strtolower($this->db->escape($data['bounce_email'])) . "',
          `replyto_email`    = '" . strtolower($this->db->escape($data['replyto_email'])) . "',
          `active`      = '" . (int)$data['active'] . "', 
          `archive`     = '" . (int)$data['archive'] . "', 
          `date_added`  = NOW()");
      	$newsletters_id = $this->db->getLastId();
        return $newsletters_id;
	}
	
	/**
	 * ModelEmailNewsletter::update()
     * 
	 * Actualiza la información de la campaña en la base de datos y coloca todos los
     * enlaces a la url completa
     * 
     * @see DB::escape()
     * @see DB::query()
     * @see DB::getLastId()
	 * @return void
	 */
	public function update($newsletter_id, $data) {
	   $data['htmlbody'] = html_entity_decode($data['htmlbody']);
		if (!empty($data['htmlbody']) && preg_match_all('/<a([^>]+)href\s*=\s*(\'|")(.*?)\2/is', $data['htmlbody'], $matches)) {
		  $link_data = "&fecha=".date('d-m-Y');
        $link_data .= "&ipnt=".$_SERVER['SERVER_ADDR'];
        $link_data .= "&hostnt=".$_SERVER['SERVER_NAME'];
        $link_data .= "&newsletter_id=".$newsletter_id;
        $link_data = base64_encode($link_data);
				foreach ($matches[0] as $index => $match) {
					$link = str_replace(' ', '%20', $matches[3][$index]);
                    if (preg_match('/twitter/', $link)) {
                        continue;
                    }
                    if (preg_match('/facebook/', $link)) {
                        continue;
                    }
                    if (preg_match('/mailto/', $link)) {
                        continue;
                    }
					$data['htmlbody'] = str_replace($match, ('<a' . $matches[1][$index] . 'href=' . $matches[2][$index] . $link . '&to=1&tl=1&td=' . $link_data . $matches[2][$index]), $data['htmlbody']);
				}
	   }
      	$result = $this->db->query("UPDATE " . DB_PREFIX . "email_newsletters SET 
          `name`        = '" . ucwords($this->db->escape($data['name'])) . "',
          `description` = '" . ucfirst($this->db->escape($data['description'])) . "',
          `format`      = '" . $this->db->escape($data['format']) . "',
          `subject`     = '" . $this->db->escape($data['subject']) . "',
          `textbody`    = '" . $this->db->escape($data['textbody']) . "',
          `htmlbody`    = '" . $this->db->escape($data['htmlbody']) . "',
          `from_name`     = '" . ucwords($this->db->escape($data['from_name'])) . "',
          `from_email`    = '" . strtolower($this->db->escape($data['from_email'])) . "',
          `bounce_email`    = '" . strtolower($this->db->escape($data['bounce_email'])) . "',
          `replyto_email`    = '" . strtolower($this->db->escape($data['replyto_email'])) . "',
          `date_modified`  = NOW() 
          WHERE `newsletter_id` = '".(int)$newsletter_id."'");
        return $result;
	}
    
    public function copy($newsletter_id) {
      	$result = $this->db->query("INSERT INTO " . DB_PREFIX . "email_newsletters 
          (`name`,`description`,`format`,`subject`,`textbody`,`htmlbody`,`from_name`,`from_email`,`bounce_email`,`replyto_email`,`active`,`archive`,`date_added`)
          SELECT CONCAT(`name`,'_".rand()."'),`description`,`format`,`subject`,`textbody`,`htmlbody`,`from_name`,`from_email`,`bounce_email`,`replyto_email`,`active`,`archive`,`date_added` FROM " . DB_PREFIX . "email_newsletters WHERE `newsletter_id` = '".(int)$newsletter_id."'");
        $newsletters_id = $this->db->getLastId();
        $result = $this->db->query("UPDATE " . DB_PREFIX . "email_newsletters SET `date_added`  = NOW() WHERE `newsletter_id` = '".(int)$newsletter_id."'");
        return $result;
	}
    
    /**
     * ModelEmailNewsletter::delete()
     * 
     * @return
     */
    public function delete($newsletter_id) {
		//TODO: validar que no tenga trabajos de envío pendientes, si es así mostrar una confirmación
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_newsletters WHERE `newsletter_id` = '".(int)$newsletter_id."'");                
        if ($query) {
            $result = $this->db->query("DELETE FROM " . DB_PREFIX . "email_newsletters WHERE `newsletter_id` = '".(int)$newsletter_id."'");
        }
        return $result;
	}
    
    /**
     * ModelEmailNewsletter::updateMembersNewsletter()
     * 
     * @return
     */
    public function updateMembersNewsletter($newsletter_id,$data) {
        if (!empty($data) && is_array($data)) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_newsletter_member WHERE `newsletter_id` = '".(int)$newsletter_id."'");                
            if ($query) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "email_newsletter_member WHERE `newsletter_id` = '".(int)$newsletter_id."'");
                foreach ($data as $member_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "email_newsletter_member SET 
                  `member_id`        = '" . intval($member_id) . "', 
                  `newsletter_id` = '" . (int)$newsletter_id . "',
                  `date_added`  = NOW()");
            }
        } else {
            foreach ($data as $member_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "email_newsletter_member SET 
                  `member_id`        = '" . intval($member_id) . "', 
                  `newsletter_id` = '" . (int)$newsletter_id . "',
                  `date_added`  = NOW()");
            }
        }
        }
    }
    
    /**
     * ModelEmailNewsletter::updateListsNewsletter()
     * 
     * @return
     */
    public function updateListsNewsletter($newsletter_id,$data) {
        if (!empty($data) && is_array($data)) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_newsletter_list WHERE `newsletter_id` = '".(int)$newsletter_id."'");                
            if ($query) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "email_newsletter_list WHERE `newsletter_id` = '".(int)$newsletter_id."'");
            foreach ($data as $list_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "email_newsletter_list SET 
                  `list_id`        = '" . (int)$list_id . "', 
                  `newsletter_id` = '" . (int)$newsletter_id . "',
                  `date_added`  = NOW()");
            }
            } else {
                foreach ($data as $list_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "email_newsletter_list SET 
                  `list_id`        = '" . (int)$list_id . "', 
                  `newsletter_id` = '" . (int)$newsletter_id . "',
                  `date_added`  = NOW()");
                }
            }
        }
    }
	
    /**
     * ModelEmailNewsletter::getNewsletter()
     * 
     * @return
     */
    public function getNewsletter($newsletter_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_newsletters WHERE newsletter_id = '" . (int)$newsletter_id . "'");
		return $query->row;
    }
	
    /**
     * ModelEmailNewsletter::getListByNewsletter()
     * 
     * @return
     */
    public function getListByNewsletter($newsletter_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_newsletter_list WHERE newsletter_id = '" . (int)$newsletter_id . "'");
		$arrList = array();
        if ($query->rows) {
		  foreach ($query->rows as $row) {
		      $arrList[] = $row['list_id'];
		  }
		}
        return $arrList;
    }
	
    /**
     * ModelEmailNewsletter::getMemberByNewsletter()
     * 
     * @param int $newsletter_id
     * @return array All members from a newsletter
     * 
     */
    public function getMemberByNewsletter($newsletter_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_newsletter_member WHERE newsletter_id = '" . (int)$newsletter_id . "'");
		$arrMember = array();
        if ($query->rows) {
		  foreach ($query->rows as $row) {
		      $arrMember[] = $row['member_id'];
		  }
		}
        return $arrMember;
    }
    
	/**
	 * ModelEmailNewsletter::getAllNewsletters()
	 * 
	 * @return
	 */
	public function getAllNewsletters() {	
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "email_newsletters");
		return $query->rows;
    }
    
    /**
     * ModelEmailNewsletter::getNewsletters()
     * 
     * @return
     */
    public function getNewsletters($data = array()) {	
	    $sql = "SELECT * FROM " . DB_PREFIX . "email_newsletters ";

		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_subject']) && !is_null($data['filter_subject'])) {
			$implode[] = "subject = '" . $this->db->escape($data['filter_subject']) . "'";
		}	
		
		if (isset($data['filter_active']) && !is_null($data['filter_active'])) {
			$implode[] = "active = '" . (int)$data['filter_active'] . "'";
		}	
		
		if (isset($data['filter_archive']) && !is_null($data['filter_archive'])) {
			$implode[] = "archive = '" . (int)$data['filter_archive'] . "'";
		}		
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'name',
			'subject',
			'active',
			'archive',
			'date_added'
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
	 * ModelEmailNewsletter::getTotalNewsletters()
	 * 
	 * @return
	 */
	public function getTotalNewsletters($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "email_newsletters";
		
		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_subject']) && !is_null($data['filter_subject'])) {
			$implode[] = "subject = '" . $this->db->escape($data['filter_subject']) . "'";
		}	
		
		if (isset($data['filter_active']) && !is_null($data['filter_active'])) {
			$implode[] = "active = '" . $this->db->escape($data['filter_active']) . "'";
		}	
		
		if (isset($data['filter_archive']) && !is_null($data['filter_archive'])) {
			$implode[] = "archive = '" . $this->db->escape($data['filter_archive']) . "'";
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
     * ModelEmailNewsletter::setMemberDown()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::setMemberUp()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::setMemberBlock()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::setMemberBanned()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::setMembersDown()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::setMembersUp()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::setMembersBlock()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::setMembersBanned()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::setMembersBanned()
     * 
     * @return
     */
    public function setActive($newsletter_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "email_newsletters SET active = '" . (int)$data . "' WHERE newsletter_id = '" . (int)$newsletter_id . "'");
	}
    
	/**
	 * ModelEmailNewsletter::getMember()
	 * 
     * @param int $member_id
	 * @return array All the info of one member
	 */
	public function getMember($member_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "email_list_members lm ON (c.customer_id = lm.customer_id) WHERE c.customer_id = '" . (int)$member_id . "'");
		return $query->row;
	}
	
    /**
     * ModelEmailNewsletter::getMemberBySubscribe()
     * 
     * @return
     */
    public function getMemberBySubscribe() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE newsletter = 1");
        return $query->rows;
    }	
    
    /**
     * ModelEmailNewsletter::getMemberDown()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::getMemberUp()
     * 
     * @return
     */
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
    
    /**
     * ModelEmailNewsletter::getActive()
     * 
     * @return
     */
    public function getActive($newsletter_id) {
		$query = $this->db->query("SELECT active FROM " . DB_PREFIX . "email_newsletters WHERE newsletter_id = '" . (int)$newsletter_id . "'");
        return $query->row['active'];	
	}
    
	/**
	 * ModelEmailNewsletter::getMembers()
	 * 
	 * @return
	 */
	public function getMembers($data = array()) {
		$sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS name FROM " . DB_PREFIX . "customer ";

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
		
		$sort_data = array(
			'name',
			'email',
			'newsletter',
			'date_added'
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
	 * ModelEmailNewsletter::getTotalMembersByList()
	 * 
	 * @return
	 */
	public function getTotalMembersByList($member_id) {
		$query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "email_list_members WHERE customer_id = ".(int)$member_id);
	
		return $query->row;
	}
	
}
?>