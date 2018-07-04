<?php

class ModelLocalisationCurrency extends Model {

	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "currency SET ".
	        "`code` = '" . $this->db->escape($data['code']) . "',".
	        "`symbol_left` = '" . $this->db->escape($data['symbol_left']) . "', ".
	        "`symbol_right` = '" . $this->db->escape($data['symbol_right']) . "', ".
	        "`decimal_place` = '" . $this->db->escape($data['decimal_place']) . "', ".
	        "`value` = '" . $this->db->escape($data['value']) . "', ".
	        "`status` = '" . (int)$data['status'] . "', ".
	        "`date_modified` = NOW()");

        $currency_id = $this->db->getLastId();

        $this->setDescriptions($currency_id, $data['description']);

		$this->cache->delete('currency');

        return $currency_id;
	}
	
	public function update($currency_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "currency SET ".
	        "`code` = '" . $this->db->escape($data['code']) . "',".
	        "`symbol_left` = '" . $this->db->escape($data['symbol_left']) . "', ".
	        "`symbol_right` = '" . $this->db->escape($data['symbol_right']) . "', ".
	        "`decimal_place` = '" . $this->db->escape($data['decimal_place']) . "', ".
	        "`value` = '" . $this->db->escape($data['value']) . "', ".
	        "`status` = '" . (int)$data['status'] . "', ".
        	"date_modified = NOW() ".
        "WHERE currency_id = '" . (int)$currency_id . "'");

        $this->setDescriptions($currency_id, $data['description']);

		$this->cache->delete('currency');
	}
	
	public function updateAll() {
		if (extension_loaded('curl')) {
			$data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $this->db->escape($this->config->get('config_currency')) . "' AND date_modified> '" . date(strtotime('-1 day')) . "'");

			foreach ($query->rows as $result) {
				$data[] = $this->config->get('config_currency') . $result['code'] . '=X';
			}	
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://download.finance.yahoo.com/d/quotes.csv?s=' . implode(',', $data) . '&f=sl1&e=.csv');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			$content = curl_exec($ch);
			
			curl_close($ch);
			
			$lines = explode("\n", trim($content));
				
			foreach ($lines as $line) {
				$currency = substr($line, 4, 3);
				$value = substr($line, 11, 6);
				
				if ((float)$value) {
					$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '" . (float)$value . "', date_modified = NOW() WHERE code = '" . $this->db->escape($currency) . "'");
				}
			}
			
			$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '1.00000', date_modified = NOW() WHERE code = '" . $this->db->escape($this->config->get('config_currency')) . "'");
			
			$this->cache->delete('currency');
		}
	}
	
	public function copy($currency_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency t ".
            "LEFT JOIN " . DB_PREFIX . "description td ON (t.currency_id = td.object_id) ".
            "WHERE t.currency_id = '" . (int) $currency_id . "' ".
                "AND td.object_type = 'currency' ".
                "AND td.language_id = '" . (int) $this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = array();
			$data = $query->row;
			$data['code'] = "copia";
            $data = array_merge($data, array('description' => $this->getDescriptions($currency_id)));
			$this->add($data);
		}
	}
	
	public function delete($currency_id) {
        $shared_tables = array(
            'property',
            'description',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$currency_id ." ".
                "AND object_type = 'currency'");
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "currency WHERE currency_id = '" . (int)$currency_id . "'");
		$this->cache->delete('currency');
	}

    public function getById($id) {
        $result = $this->getAll(array(
            'currency_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.currencies";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "currency t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.currency_id = td.object_id) ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'title',
					'code',
					'value',
					'date_modified'
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
        $cache_prefix = "admin.currencies.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "currency t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.currency_id = td.object_id) ";
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

        $criteria[] = " td.object_type = 'currency' ";

        $data['currency_id'] = !is_array($data['currency_id']) && !empty($data['currency_id']) ? array($data['currency_id']) : $data['currency_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];
        if (isset($data['currency_id']) && !empty($data['currency_id'])) {
            $criteria[] = " t.currency_id IN (" . implode(', ', $data['currency_id']) . ") ";
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

        if (isset($data['symbol']) && !empty($data['symbol'])) {
            $criteria[] = 
	            " LCASE(t.`symbol_left`) LIKE '%" . $this->db->escape(strtolower($data['symbol'])) . "%' collate utf8_general_ci ".
	            " OR LCASE(t.`symbol_right`) LIKE '%" . $this->db->escape(strtolower($data['symbol'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['title']) && !empty($data['title'])) {
            $criteria[] = " LCASE(td.`title`) LIKE '%" . $this->db->escape(strtolower($data['title'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['code']) && !empty($data['code'])) {
            $criteria[] = " LCASE(t.`code`) LIKE '%" . $this->db->escape(strtolower($data['code'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.currency_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'currency' ";
            }
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " date_modified BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " date_modified BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.currency_id";
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
        return $this->__getDescriptions('currency', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('currency', $id, $data);
    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('currency', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('currency', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('currency', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('currency', $id, $group);
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