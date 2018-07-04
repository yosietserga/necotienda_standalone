<?php 

class ModelLocalisationOrderPaymentStatus extends Model {

	public function add($data) {
		foreach ($data['order_payment_status'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_payment_status SET ".
            "language_id = '" . (int)$language_id . "', ".
            "name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->cache->delete('order_payment_status');
	}

	public function update($id, $data) {
		foreach ($data['order_payment_status'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "order_payment_status SET ".
            	"name = '" . $this->db->escape($value['name']) . "' ".
            "WHERE order_payment_status_id = '" . (int)$id . "' ".
            	"AND language_id = '" . (int)$language_id . "' ");
		}
				
		$this->cache->delete('order_payment_status');
	}
	
	public function delete($id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$country_id ." ".
                "AND object_type = 'order_payment_status'");
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "order_payment_status WHERE order_payment_status_id = '" . (int)$id . "'");
	
		$this->cache->delete('order_payment_status');
	}
		
	public function getDescriptions($id) {
		$order_payment_status_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_payment_status WHERE order_payment_status_id = '" . (int)$id . "'");
		
		foreach ($query->rows as $result) {
			$order_payment_status_data[$result['language_id']] = array('name' => $result['name']);
		}
		
		return $order_payment_status_data;
	}
	
    public function getById($id) {
        $result = $this->getAll(array(
            'order_payment_status_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.order_payment_statuses";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "order_payment_status t ";

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
        $cache_prefix = "admin.order_payment_statuses.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_payment_status t ";
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

        $data['order_payment_status_id'] = !is_array($data['order_payment_status_id']) && !empty($data['order_payment_status_id']) ? array($data['order_payment_status_id']) : $data['order_payment_status_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];

        if (isset($data['order_payment_status_id']) && !empty($data['order_payment_status_id'])) {
            $criteria[] = " t.order_payment_status_id IN (" . implode(', ', $data['order_payment_status_id']) . ") ";
        }

        if (isset($data['language_id']) && !empty($data['language_id'])) {
            $criteria[] = " t.language_id IN (" . implode(', ', $data['language_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.order_payment_status_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'order_payment_status' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.order_payment_status_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY name";
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
        return $this->__getProperty('order_payment_status', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('order_payment_status', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('order_payment_status', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('order_payment_status', $id, $group);
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
