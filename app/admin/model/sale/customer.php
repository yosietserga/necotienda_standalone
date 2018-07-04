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

	public function add($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET ".
          	"firstname = '" . $this->db->escape($data['firstname']) . "', ".
          	"lastname = '" . $this->db->escape($data['lastname']) . "', ".
          	"company = '" . $this->db->escape($data['company']) . "', ".
          	"rif = '" . $this->db->escape($data['rif']) . "', ".
          	"email = '" . $this->db->escape($data['email']) . "', ".
          	"sex = '" . $this->db->escape($data['sexo']) . "', ".
          	"telephone = '" . $this->db->escape($data['telephone']) . "', ".
          	"customer_group_id = '" . (int)$data['customer_group_id'] . "', ".
          	"password = '" . $this->db->escape(md5($data['password'])) . "', ".
          	"approved = '1', ".
          	"status = '1', ".
          	"date_added = NOW()");
      	
      	$customer_id = $this->db->getLastId();
      	
		return $customer_id;
	}
	
	public function update($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET ".
            "firstname = '" . $this->db->escape($data['firstname']) . "', ".
            "lastname = '" . $this->db->escape($data['lastname']) . "', ".
            "company = '" . $this->db->escape($data['company']) . "', ".
            "rif = '" . $this->db->escape($data['rif']) . "', ".
            "email = '" . $this->db->escape($data['email']) . "', ".
            "sex = '" . $this->db->escape($data['sexo']) . "', ".
            "telephone = '" . $this->db->escape($data['telephone']) . "', ".
            "customer_group_id = '" . (int)$data['customer_group_id'] . "' ".
        "WHERE customer_id = '" . (int)$customer_id . "'");
	
      	if ($data['password']) {
        	$this->db->query("UPDATE " . DB_PREFIX . "customer SET ".
            "password = '" . $this->db->escape(md5($data['password'])) . "' ".
            "WHERE customer_id = '" . (int)$customer_id . "'");
      	}
	}

	public function delete($customer_id) {
        $shared_tables = array(
            'property',
            'stat',
            'review',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$customer_id ." ".
                "AND object_type = 'customer'");
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "balance WHERE customer_id = '" . (int)$customer_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_payment WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE owner_id = '" . (int)$customer_id . "'");

        //delete all products and related tables where owner_id = this
	}
	
    public function getById($id) {
        $result = $this->getAll(array(
            'customer_id'=>$id
        ));
        return $result[0];
    }
    
    public function getAll($data=null) {
        $cache_prefix = "admin.customers";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->user->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT *, " .
            "t.customer_id AS cid, " .
            "t.firstname AS firstname, " .
            "t.lastname AS lastname, " .
            "t.company AS company, " .
            "CONCAT(t.firstname, ' ', t.lastname) AS name " .
            "FROM " . DB_PREFIX . "customer t ";

            if (!isset($sort_data)) {
                $sort_data = array(
					't.firstname',
					't.lastname',
					't.email',
					't.customer_group_id',
					't.status',
					't.date_added'
                );
            }
            $sql .= $this->buildSQLQuery($data, $sort_data);
            $query = $this->db->query($sql);

            $this->cache->set($cachedId, $query->rows);
            return $query->rows;
        } else {
            return $cached;
        }
    }

    public function getAllTotal($data=null) {
        $cache_prefix = "admin.customers.total";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->user->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer t ";
            $sql .= $this->buildSQLQuery($data, null, true);
            $query = $this->db->query($sql);

            $this->cache->set($cachedId, $query->row['total']);

            return $query->row['total'];
        } else {
            return $cached;
        }
    }

    private function buildSQLQuery($data, $sort_data = null, $countAsTotal = false) {
        $criteria = array();
        $sql = "";
        
        $sql .= "LEFT JOIN " . DB_PREFIX . "customer_group cg ON (t.customer_group_id = cg.customer_group_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "address a ON (t.address_id = a.address_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "country co ON (co.country_id = a.country_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "zone z ON (z.zone_id = a.zone_id) ";


        $data['customer_id'] = !is_array($data['customer_id']) && !empty($data['customer_id']) ? array($data['customer_id']) : $data['customer_id'];
        $data['customer_group_id'] = !is_array($data['customer_group_id']) && !empty($data['customer_group_id']) ? array($data['customer_group_id']) : $data['customer_group_id'];
        $data['address_id'] = !is_array($data['address_id']) && !empty($data['address_id']) ? array($data['address_id']) : $data['address_id'];
        $data['country_id'] = !is_array($data['country_id']) && !empty($data['country_id']) ? array($data['country_id']) : $data['country_id'];
        $data['zone_id'] = !is_array($data['zone_id']) && !empty($data['zone_id']) ? array($data['zone_id']) : $data['zone_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "customer_to_store t2s ON (t.customer_id = t2s.customer_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['customer_id']) && !empty($data['customer_id'])) {
            $criteria[] = " t.customer_id IN (" . implode(', ', $data['customer_id']) . ") ";
        }

        if (isset($data['customer_group_id']) && !empty($data['customer_group_id'])) {
            $criteria[] = " cg.customer_group_id IN (" . implode(', ', $data['customer_group_id']) . ") ";
        }

        if (isset($data['address_id']) && !empty($data['address_id'])) {
            $criteria[] = " a.address_id IN (" . implode(', ', $data['address_id']) . ") ";
        }

        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $criteria[] = " co.country_id IN (" . implode(', ', $data['country_id']) . ") ";
        }

        if (isset($data['zone_id']) && !empty($data['zone_id'])) {
            $criteria[] = " z.zone_id IN (" . implode(', ', $data['zone_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(CONCAT(t.firstname, ' ', t.lastname)) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['firstname']) && !empty($data['firstname'])) {
            $criteria[] = " LCASE(t.firstname) LIKE '%" . $this->db->escape(strtolower($data['firstname'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['lasttname']) && !empty($data['lasttname'])) {
            $criteria[] = " LCASE(t.lasttname) LIKE '%" . $this->db->escape(strtolower($data['lasttname'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['company']) && !empty($data['company'])) {
            $criteria[] = " LCASE(t.company) LIKE '%" . $this->db->escape(strtolower($data['company'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['rif']) && !empty($data['rif'])) {
            $criteria[] = " LCASE(t.`rif`) LIKE '%" . $this->db->escape(strtolower($data['rif'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['email']) && !empty($data['email'])) {
            $criteria[] = " LCASE(t.`email`) LIKE '%" . $this->db->escape(strtolower($data['email'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['telephone']) && !empty($data['telephone'])) {
            $criteria[] = " LCASE(t.`telephone`) LIKE '%" . $this->db->escape(strtolower($data['telephone'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['approved']) && is_numeric($data['approved'])) {
            $criteria[] = " t.approved = '". intval($data['approved']) ."' ";
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.customer_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'customer' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.customer_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.firstname";
                $sql .= ($data['order'] == 'DESC') ? " DESC" : " ASC";
            }

            if ($data['start'] && $data['limit']) {
                if ($data['start'] < 0) $data['start'] = 0;
                if (!$data['limit']) $data['limit'] = 24;

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            } elseif ($data['limit']) {
                if (!$data['limit']) $data['limit'] = 24;

                $sql .= " LIMIT ". (int)$data['limit'];
            }
        }
        return $sql;
    }

	public function getAllTotalAwaitingApproval() {
		return $this->getAllTotal(array(
			'status' => 0,
			'approved' => 0
		));
	}
	
	public function getAllTotalByCustomerGroupId($customer_group_id) {
		return $this->getAllTotal(array(
			'customer_group_id' => $customer_group_id
		));
	}
    
	public function approve($customer_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET approved = '1' WHERE customer_id = '" . (int)$customer_id . "'");
	}
	
    public function desapprove($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `approved` = '0' WHERE `customer_id` = '" . (int)$id . "'");
        return $query;
    }

    public function activate($id) {
        return $this->__activate('customer', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('customer', $id);
	}
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('customer', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('customer', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('customer', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('customer', $id, $group);
    }

    public function setAllProperties($id, $group, $data) {
        if (is_array($data) && !empty($data)) {
            $this->deleteProperty($id, $group);
            foreach ($data as $key => $value) {
                $this->setProperty($id, $group, $key, $value);
            }
        }
    }
}
