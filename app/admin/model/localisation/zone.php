<?php

class ModelLocalisationZone extends Model {

	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "zone SET ".
			"status = '" . (int)$data['status'] . "', ".
			"code = '" . $this->db->escape($data['code']) . "', ".
			"country_id = '" . (int)$data['country_id'] . "'");
			
        $zone_id = $this->db->getLastId();

        $this->setDescriptions($zone_id, $data['description']);

		$this->cache->delete('zone');
	}
	
	public function update($zone_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "zone SET ".
			"status = '" . (int)$data['status'] . "', ".
			"code = '" . $this->db->escape($data['code']) . "', ".
			"country_id = '" . (int)$data['country_id'] . "' ".
		"WHERE zone_id = '" . (int)$zone_id . "'");

        $this->setDescriptions($zone_id, $data['description']);

		$this->cache->delete('zone');
	}
	
	public function delete($zone_id) {
        $shared_tables = array(
            'property',
            'description',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$zone_id ." ".
                "AND object_type = 'zone'");
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$zone_id . "'");

		$this->cache->delete('zone');	
	}
	

    public function getById($id) {
        $result = $this->getAll(array(
            'zone_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.zones";
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
            $sql = "SELECT *, td.title as zone FROM " . DB_PREFIX . "zone t ";

            if (!isset($sort_data)) {
                $sort_data = array(
					'cd.title',
					'td.title',
					'z.code'
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
        $cache_prefix = "admin.zones.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "zone t ";
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

        $sql .= "LEFT JOIN " . DB_PREFIX . "description td ON (t.zone_id = td.object_id) ";

        $criteria[] = " td.object_type = 'zone' ";

        $data['zone_id'] = !is_array($data['zone_id']) && !empty($data['zone_id']) ? array($data['zone_id']) : $data['zone_id'];
        $data['country_id'] = !is_array($data['country_id']) && !empty($data['country_id']) ? array($data['country_id']) : $data['country_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];

        if (isset($data['country_id']) || isset($data['country'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "country c ON (t.zone_id = c.country_id) ";
            if (isset($data['country'])) $sql .= "LEFT JOIN " . DB_PREFIX . "description cd ON (c.country_id = cd.object_id) ";
        }

        if (isset($data['zone_id']) && !empty($data['zone_id'])) {
            $criteria[] = " t.zone_id IN (" . implode(', ', $data['zone_id']) . ") ";
        }

        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $criteria[] = " t.country_id IN (" . implode(', ', $data['country_id']) . ") ";
        }

        if (isset($data['language_id']) && !empty($data['language_id'])) {
            $criteria[] = " td.language_id IN (" . implode(', ', $data['language_id']) . ") ";

	        if (isset($data['country'])) {
            	$criteria[] = " cd.language_id IN (" . implode(', ', $data['language_id']) . ") ";
	        }

        }

        if ($data['queries']) {
            $search = $search2 = '';
            foreach ($data['queries'] as $key => $value) {
                if (empty($value)) continue;
                if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                    $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                $search .= " LCASE(td.`title`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";

                if (isset($data['search_in_description'])) {
                    $search2 .= " LCASE(td.description) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
            }
            if (!empty($search)) {
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($search2)) {
                $criteria[] = " (". rtrim($search2,'OR') .")";
            }
        }

        if (isset($data['title']) && !empty($data['title'])) {
            $criteria[] = " LCASE(td.`title`) LIKE '%" . $this->db->escape(strtolower($data['title'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['code']) && !empty($data['code'])) {
            $criteria[] = " LCASE(t.`code`) LIKE '%" . $this->db->escape(strtolower($data['country'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['country']) && !empty($data['country'])) {
            $criteria[] = " LCASE(cd.`title`) LIKE '%" . $this->db->escape(strtolower($data['country'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.zone_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'zone' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.zone_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY td.title";
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

    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('zone', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('zone', $id, $data);
    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('zone', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('zone', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('zone', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('zone', $id, $group);
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
