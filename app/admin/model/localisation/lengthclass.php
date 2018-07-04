<?php

class ModelLocalisationLengthClass extends Model {

	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "length_class SET value = '" . (float)$data['value'] . "'");

		$length_class_id = $this->db->getLastId();
		
        $this->setDescriptions($length_class_id, $data['length_class_description']);

		$this->cache->delete('length_class');
	}
	
	public function update($length_class_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "length_class SET 
			value = '" . (float)$data['value'] . "' WHERE length_class_id = '" . (int)$length_class_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "length_class_description WHERE length_class_id = '" . (int)$length_class_id . "'");

        $this->setDescriptions($length_class_id, $data['length_class_description']);

		$this->cache->delete('length_class');	
	}
	
	public function delete($length_class_id) {
        $shared_tables = array(
            'property',
            'description',
            'stat',
            'url_alias',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$id ." ".
                "AND object_type = 'lengthclass'");
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "length_class WHERE length_class_id = '" . (int)$length_class_id . "'");
		
		$this->cache->delete('length_class');
	}
	
    public function getByID($id) {
        $result = $this->getAll(array(
            'length_class_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.length_classes";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "length_class t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.length_class_id = td.object_id) ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'title',
					'description',
					'value'
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
        $cache_prefix = "admin.length_classes.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "length_class t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.length_class_id = td.object_id) ";
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

        $criteria[] = " td.object_type = 'lengthclass' ";

        $data['length_class_id'] = !is_array($data['length_class_id']) && !empty($data['length_class_id']) ? array($data['length_class_id']) : $data['length_class_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];

        if (isset($data['length_class_id']) && !empty($data['length_class_id'])) {
            $criteria[] = " t.length_class_id IN (" . implode(', ', $data['length_class_id']) . ") ";
        }

        if (isset($data['language_id']) && !empty($data['language_id'])) {
            $criteria[] = " td.language_id IN (" . implode(', ', $data['language_id']) . ") ";
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

        if (isset($data['description']) && !empty($data['description'])) {
            $criteria[] = " LCASE(td.`description`) LIKE '%" . $this->db->escape(strtolower($data['description'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.length_class_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'lengthclass' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.length_class_id";
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

	public function getDescriptionByUnit($unit) {
        $result = $this->getAll(array(
            'description'=>$unit,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
	}
	
    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('lengthclass', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('lengthclass', $id, $data);
    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('lengthclass', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('lengthclass', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('lengthclass', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('lengthclass', $id, $group);
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
