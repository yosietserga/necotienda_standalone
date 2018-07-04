<?php 

class ModelLocalisationTaxClass extends Model {

	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "tax_class SET ".
			"title = '" . $this->db->escape($data['title']) . "', ".
			"description = '" . $this->db->escape($data['description']) . "', ".
			"date_added = NOW()");
		
		$tax_class_id = $this->db->getLastId();
		
		if (isset($data['tax_rate'])) {
			foreach ($data['tax_rate'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tax_rate SET ".
					"geo_zone_id = '" . (int)$value['geo_zone_id'] . "', ".
					"tax_class_id = '" . (int)$tax_class_id . "', ".
					"priority = '" . (int)$value['priority'] . "', ".
					"rate = '" . (float)$value['rate'] . "', ".
					"description = '" . $this->db->escape($value['description']) . "', ".
					"date_added = NOW()");
			}
		}
		
		$this->cache->delete('tax_class');
	}
	
	public function update($tax_class_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "tax_class SET ".
			"title = '" . $this->db->escape($data['title']) . "', ".
			"description = '" . $this->db->escape($data['description']) . "', ".
			"date_modified = NOW() ".
			"WHERE tax_class_id = '" . (int)$tax_class_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "tax_rate WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		if (isset($data['tax_rate'])) {
			foreach ($data['tax_rate'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tax_rate SET ".
					"geo_zone_id = '" . (int)$value['geo_zone_id'] . "', ".
					"tax_class_id = '" . (int)$tax_class_id . "', ".
					"priority = '" . (int)$value['priority'] . "',".
					"rate = '" . (float)$value['rate'] . "', ".
					"description = '" . $this->db->escape($value['description']) . "', ".
					"date_added = NOW()");
			}
		}
		
		$this->cache->delete('tax_class');
	}
	
	public function delete($tax_class_id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$tax_class_id ." ".
                "AND object_type = 'taxclass'");
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "tax_class WHERE tax_class_id = '" . (int)$tax_class_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tax_rate WHERE tax_class_id = '" . (int)$tax_class_id . "'");
		
		$this->cache->delete('tax_class');
	}
	
    public function getById($id) {
        $result = $this->getAll(array(
            'tax_class_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.tax_classes";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "tax_class t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'title'
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
        $cache_prefix = "admin.tax_classes.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tax_class t ";
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

        $data['tax_class_id'] = !is_array($data['tax_class_id']) && !empty($data['tax_class_id']) ? array($data['tax_class_id']) : $data['tax_class_id'];
        
        if (isset($data['tax_class_id']) && !empty($data['tax_class_id'])) {
            $criteria[] = " t.tax_class_id IN (" . implode(', ', $data['tax_class_id']) . ") ";
        }

        if (isset($data['title']) && !empty($data['title'])) {
            $criteria[] = " LCASE(t.`title`) LIKE '%" . $this->db->escape(strtolower($data['title'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.tax_class_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'taxclass' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.tax_class_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.title";
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

	public function getTaxRates($tax_class_id) {
      	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tax_rate WHERE tax_class_id = '" . (int)$tax_class_id . "'");
		
		return $query->rows;
	}
			
	public function getAllTotalByGeoZoneId($geo_zone_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tax_rate WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
		
		return $query->row['total'];
	}

    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('taxclass', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('taxclass', $id, $data);
    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('taxclass', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('taxclass', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('taxclass', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('taxclass', $id, $group);
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
