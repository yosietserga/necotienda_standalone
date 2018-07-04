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
class ModelSaleAddress extends Model {

    public function add($data) {
      $this->db->query("INSERT INTO " . DB_PREFIX . "address SET ".
          "customer_id = '" . (int)$data['customer_id'] . "', ".
          "firstname = '" . $this->db->escape($data['firstname']) . "', ".
          "lastname = '" . $this->db->escape($data['lastname']) . "', ".
          "company = '" . $this->db->escape($data['company']) . "', ".
          "address_1 = '" . $this->db->escape($data['address_1']) . "', ".
          "address_2 = '" . $this->db->escape($data['address_2']) . "', ".
          "city = '" . $this->db->escape($data['city']) . "', ".
          "postcode = '" . $this->db->escape($data['postcode']) . "', ".
          "country_id = '" . (int)$data['country_id'] . "', ".
          "zone_id = '" . (int)$data['zone_id'] . "'");

        $id = $this->db->getLastId();
        return $id;
  	}
  	
  	public function update($id, $data) {
      $this->db->query("UPDATE " . DB_PREFIX . "address SET ".
          "customer_id = '" . (int)$data['customer_id'] . "', ".
          "firstname = '" . $this->db->escape($data['firstname']) . "', ".
          "lastname = '" . $this->db->escape($data['lastname']) . "', ".
          "company = '" . $this->db->escape($data['company']) . "', ".
          "address_1 = '" . $this->db->escape($data['address_1']) . "', ".
          "address_2 = '" . $this->db->escape($data['address_2']) . "', ".
          "city = '" . $this->db->escape($data['city']) . "', ".
          "postcode = '" . $this->db->escape($data['postcode']) . "', ".
          "country_id = '" . (int)$data['country_id'] . "', ".
          "zone_id = '" . (int)$data['zone_id'] . "' ".
      "WHERE address_id = '". (int)$id ."");
    }

    public function delete($id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$id ." ".
                "AND object_type = 'address'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$id . "'");
    }
  
    public function deleteByCustomerId($id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  IN ( ".
                  "SELECT address_id FROM " . DB_PREFIX . "address WHERE customer_id = '". (int)$id ."' ".
                ") AND object_type = 'address'");
        }

		    $this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$id . "'");
    }
	
    public function getById($id) {
        $result = $this->getAll(array(
            'address_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.addresses";
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
            $sql = "SELECT *, zd.title AS zone, cod.title AS country, z.code AS zone_code FROM " . DB_PREFIX . "address t ";

            if (!isset($sort_data)) {
                $sort_data = array(
        					'address_id',
        					'city',
        					'address_1',
        					'street'
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
        $cache_prefix = "admin.addresses.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address t ";
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
        
        $sql .= "LEFT JOIN " . DB_PREFIX . "country co ON (co.country_id = t.country_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "description cod ON (co.country_id = cod.object_id) ";

        $sql .= "LEFT JOIN " . DB_PREFIX . "zone z ON (z.zone_id = t.zone_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "description zd ON (z.zone_id = zd.object_id) ";

        $data['customer_id'] = !is_array($data['customer_id']) && !empty($data['customer_id']) ? array($data['customer_id']) : $data['customer_id'];
        $data['address_id'] = !is_array($data['address_id']) && !empty($data['address_id']) ? array($data['address_id']) : $data['address_id'];
        $data['country_id'] = !is_array($data['country_id']) && !empty($data['country_id']) ? array($data['country_id']) : $data['country_id'];
        $data['zone_id'] = !is_array($data['zone_id']) && !empty($data['zone_id']) ? array($data['zone_id']) : $data['zone_id'];

        if (isset($data['customer_id']) && !empty($data['customer_id'])) {
            $criteria[] = " t.customer_id IN (" . implode(', ', $data['customer_id']) . ") ";
        }

        if (isset($data['address_id']) && !empty($data['address_id'])) {
            $criteria[] = " t.address_id IN (" . implode(', ', $data['address_id']) . ") ";
        }

        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $criteria[] = " co.country_id IN (" . implode(', ', $data['country_id']) . ") ";
        }

        if (isset($data['zone_id']) && !empty($data['zone_id'])) {
            $criteria[] = " z.zone_id IN (" . implode(', ', $data['zone_id']) . ") ";
        }

        if (isset($data['address']) && !empty($data['address'])) {
            $criteria[] = " LCASE(CONCAT(t.address_1, ' ', t.address_2)) LIKE '%" . $this->db->escape(strtolower($data['address'])) . "%' collate utf8_general_ci ";
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

        if (isset($data['city']) && !empty($data['city'])) {
            $criteria[] = " LCASE(t.`city`) LIKE '%" . $this->db->escape(strtolower($data['city'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['street']) && !empty($data['street'])) {
            $criteria[] = " LCASE(t.`street`) LIKE '%" . $this->db->escape(strtolower($data['street'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['zone']) && !empty($data['zone'])) {
            $criteria[] = " LCASE(zd.`title`) LIKE '%" . $this->db->escape(strtolower($data['zone'])) . "%' collate utf8_general_ci ";
            $criteria[] = " LCASE(zd.`object_type`) = 'zone' ";
        }

        if (isset($data['country']) && !empty($data['country'])) {
            $criteria[] = " LCASE(cod.`title`) LIKE '%" . $this->db->escape(strtolower($data['country'])) . "%' collate utf8_general_ci ";
            $criteria[] = " LCASE(cod.`object_type`) = 'country' ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.address_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'address' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.address_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.address_id";
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

  	public function getTotalAddressesByCustomerId($customer_id) {
        return $this->getAllTotal(array(
            'customer_id' => $customer_id
        ));
  	}
  	
  	public function getTotalAddressesByCountryId($country_id) {
        return $this->getAllTotal(array(
            'country_id' => $country_id
        ));
  	}	
  	
  	public function getTotalAddressesByZoneId($zone_id) {
        return $this->getAllTotal(array(
            'zone_id' => $zone_id
        ));
  	}
  	
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('address', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('address', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('address', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('address', $id, $group);
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
