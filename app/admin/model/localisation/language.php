<?php

class ModelLocalisationLanguage extends Model {

	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "language SET ".
            "name = '" . $this->db->escape($data['name']) . "', ".
            "code = '" . $this->db->escape($data['code']) . "', ".
            "locale = '" . $this->db->escape($data['locale']) . "', ".
            "directory = '" . $this->db->escape($data['directory']) . "', ".
            "filename = '" . $this->db->escape($data['filename']) . "', ".
            "image = '" . $this->db->escape($data['image']) . "', ".
            "sort_order = '" . $this->db->escape($data['sort_order']) . "', ".
            "status = '" . (int)$data['status'] . "'");
		
		$this->cache->delete('language');
		
		$id = $this->db->getLastId();

		//description's tables
        $tables = array(
            'order_status',
            'order_payment_status',
            'stock_status',
            'description',
        );

        foreach ($tables as $table_name) {

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . $table_name . " WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

            foreach ($query->rows as $key =>$value) {
                $keys = array_keys($value);
                $values = array_values($value);
                if (strpos($keys[0], 'description_id') > -1) {
                    array_shift($keys);
                    array_shift($values);
                }

                $s = '';
                foreach ($keys as $k => $v) {
                    if ($keys[$k] == 'language_id')
                        $s .= " `$keys[$k]` = '$id', ";
                    elseif ($keys[$k] == 'date_added')
                        $s .= " `$keys[$k]` = NOW(), ";
                    else
                        $s .= " `$keys[$k]` = '{$this->db->escape($values[$k])}', ";
                }
                $s = rtrim($s, ', ');
                $q = "INSERT INTO " . DB_PREFIX . $table_name ." SET ". $s;
                $this->db->query($q);
            }
            $this->cache->delete(str_replace('_description', '', $table_name));
        }
        return $id;
	}
	
	public function update($language_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "language SET ".
            "name = '" . $this->db->escape($data['name']) . "', ".
            "code = '" . $this->db->escape($data['code']) . "', ".
            "locale = '" . $this->db->escape($data['locale']) . "', ".
            "directory = '" . $this->db->escape($data['directory']) . "', ".
            "filename = '" . $this->db->escape($data['filename']) . "', ".
            "image = '" . $this->db->escape($data['image']) . "', ".
            "sort_order = '" . $this->db->escape($data['sort_order']) . "', ".
            "status = '" . (int)$data['status'] . "' ".
        "WHERE language_id = '" . (int)$language_id . "'");
		$this->cache->delete('language');
	}
	
	public function copy($language_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "language WHERE language_id = '" . (int)$language_id . "'");
		
		if ($query->num_rows) {
			$data = array();
			$data = $query->row;
			$data['name'] = $data['name'] ." - copia";
			$data['code'] = "copia";
			$this->add($data);
		}
	}
	
	public function delete($language_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "language WHERE language_id = '" . (int)$language_id . "'");
		$this->cache->delete('language');

        //description's tables
        $tables = array(
            'order_status',
            'order_payment_status',
            'stock_status',
            'description',
        );

        foreach ($tables as $table_name) {
            $q = "DELETE FROM " . DB_PREFIX . $table_name ." WHERE language_id = '" . (int)$language_id . "'";
            $this->db->query($q);
            $this->cache->delete(str_replace('_description', '', $table_name));
        }
	}

    public function getById($id) {
        $results = $this->getAll(array('language_id'=>$id));
        return $results[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.languages";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "language t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.name',
                    't.code'
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
        $cache_prefix = "admin.languages.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "language t ";
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

        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];

        if (isset($data['language_id']) && !empty($data['language_id'])) {
            $criteria[] = " language_id IN (" . implode(', ', $data['language_id']) . ") ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['name'])) {
            $criteria[] = " LCASE(t.name) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['code'])) {
            $criteria[] = " LCASE(t.code) LIKE '%" . $this->db->escape(strtolower($data['code'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['locale'])) {
            $criteria[] = " LCASE(t.locale) LIKE '%" . $this->db->escape(strtolower($data['locale'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['directory'])) {
            $criteria[] = " LCASE(t.directory) LIKE '%" . $this->db->escape(strtolower($data['directory'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['filename'])) {
            $criteria[] = " LCASE(t.filename) LIKE '%" . $this->db->escape(strtolower($data['filename'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property lp ON (t.language_id = lp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(lp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(lp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " lp.object_type = 'language' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.language_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.sort_order";
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

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('language', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('language', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('language', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('language', $id, $group);
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
