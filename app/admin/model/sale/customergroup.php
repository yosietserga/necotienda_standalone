<?php
/**
 * ModelSaleCustomerGroup
 * 
 * @package   NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelSaleCustomerGroup extends Model {
	/**
	 * ModelSaleCustomerGroup::add()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return void
	 */
	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group SET ".
        "`name` = '" . $this->db->escape($data['name']) . "', ".
        "`params` = '" . $this->db->escape($data['params']) . "', ".
        "`status` = '1', ".
        "`date_added` = NOW()");
        return $this->db->getLastId();
	}
	
	/**
	 * ModelSaleCustomerGroup::update()
	 * 
	 * @param int $customer_group_id
	 * @param mixed $data
     * @see DB
	 * @return void
	 */
	public function update($customer_group_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_group SET ".
        "`name` = '" . $this->db->escape($data['name']) . "', ".
        "`params` = '" . $this->db->escape($data['params']) . "',".
        "`date_modified` = NOW()".
        "WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	}
	
	/**
	 * ModelStoreProduct::copy()
	 * 
	 * @param int $product_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function copy($customer_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group ".
        "WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		
		if ($query->num_rows) {
			$data = array();
			$data = $query->row;
			$data['name'] = $data['name'] . " - copia";
			$this->add($data);
		}
	}
	
	/**
	 * ModelSaleCustomerGroup::deleteCustomerGroup()
	 * 
	 * @param int $customer_group_id
     * @see DB
	 * @return void
	 */
	public function delete($customer_group_id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$customer_group_id ." ".
                "AND object_type = 'customer_group'");
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET customer_group_id = 0 WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	}
	
    public function getById($id) {
        $result = $this->getAll(array(
            'customer_group_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.customer_groups";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "customer_group t ";

            if (!isset($sort_data)) {
                $sort_data = array(
					'name'
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
        $cache_prefix = "admin.customer_groups.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_group t ";
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
        


        $data['customer_id'] = !is_array($data['customer_id']) && !empty($data['customer_id']) ? array($data['customer_id']) : $data['customer_id'];
        $data['customer_group_id'] = !is_array($data['customer_group_id']) && !empty($data['customer_group_id']) ? array($data['customer_group_id']) : $data['customer_group_id'];

        if (isset($data['customer_id']) || isset($data['customer_name'])  || isset($data['customer_email'])) {
        	$sql .= "LEFT JOIN " . DB_PREFIX . "customer c ON (t.customer_group_id = c.customer_group_id) ";
        }

        if (isset($data['customer_group_id']) && !empty($data['customer_group_id'])) {
            $criteria[] = " t.customer_group_id IN (" . implode(', ', $data['customer_group_id']) . ") ";
        }

        if (isset($data['customer_id']) && !empty($data['customer_id'])) {
            $criteria[] = " c.customer_id IN (" . implode(', ', $data['customer_id']) . ") ";
        }

        if (isset($data['customer_name']) && !empty($data['customer_name'])) {
            $criteria[] = " LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(strtolower($data['customer_name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['customer_email']) && !empty($data['customer_email'])) {
            $criteria[] = " LCASE(c.email) LIKE '%" . $this->db->escape(strtolower($data['customer_email'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.name) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.customer_group_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'customer_group' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.customer_group_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.name";
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

    public function activate($id) {
        return $this->__activate('customer_group', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('customer_group', $id);
    }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('customer_group', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('customer_group', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('customer_group', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('customer_group', $id, $group);
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
