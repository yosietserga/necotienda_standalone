<?php
/**
 * ModelSaleBank
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelSaleBankAccount extends Model {

    public function add($data) {
        $sql = "INSERT INTO `". DB_PREFIX ."bank_account` SET ".
        "`bank_id` = '". intval($data['bank_id']) ."',".
        "`number` = '". $this->db->escape($data['number']) ."',".
        "`accountholder` = '". $this->db->escape($data['accountholder']) ."',".
        "`type` = '". $this->db->escape($data['type']) ."',".
        "`rif` = '". $this->db->escape($data['rif']) ."',".
        "`email` = '". $this->db->escape($data['email']) ."',".
        "`status` = '1',".
        "`date_added` = NOW()";
        
        $this->db->query($sql);
        
        $id = $this->db->getLastId();
        
        foreach ($data['stores'] as $store) {
    		$this->db->query("INSERT INTO " . DB_PREFIX . "bank_account_to_store SET ".
            "store_id  = '". intval($store) ."', ".
            "bank_account_id = '". intval($id) ."'");
        }
                
        return $id;
    }
    
    public function update($id,$data) {
        $sql = "UPDATE `". DB_PREFIX ."bank_account` SET ".
        "`bank_id` = '". intval($data['bank_id']) ."',".
        "`number` = '". $this->db->escape($data['number']) ."',".
        "`accountholder` = '". $this->db->escape($data['accountholder']) ."',".
        "`type` = '". $this->db->escape($data['type']) ."',".
        "`rif` = '". $this->db->escape($data['rif']) ."',".
        "`email` = '". $this->db->escape($data['email']) ."' ".
        "WHERE bank_account_id = '". (int)$id ."'";
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "bank_account_to_store WHERE bank_account_id = '". (int)$id ."'");
        foreach ($data['stores'] as $store) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "bank_account_to_store SET ".
            "store_id  = '". intval($store) ."', ".
            "bank_account_id = '". intval($id) ."'");
        }
                
        $this->db->query($sql);
    }
    
	public function copy($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "bank_account WHERE bank_account_id = '" . (int)$id . "'");
		
		if ($query->num_rows) {
			$data = array();
			$data = $query->row;
			$this->add($data);
		}
	}
    
    public function delete($id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$id ." ".
                "AND object_type = 'bank_account'");
        }

        $this->db->query("DELETE FROM ". DB_PREFIX ."bank_account WHERE bank_account_id = '". (int)$id ."'");
        $this->db->query("DELETE FROM ". DB_PREFIX ."bank_account_to_store WHERE bank_account_id = '". (int)$id ."'");
    }
    
	public function getStores($id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bank_account_to_store WHERE bank_account_id = '" . (int)$id . "'");
		foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
		}
		return $data;
	}	
	
    public function getById($id) {
        $result = $this->getAll(array(
            'bank_account_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.bank_accounts";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "bank_account t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.name',
                    'accountholder',
                    'number',
                    't.email'
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
        $cache_prefix = "admin.bank_accounts.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "bank_account t ";
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
        
        $sql .= "LEFT JOIN `". DB_PREFIX ."bank` b ON (b.bank_id=t.bank_id) ";

        $data['bank_account_id'] = !is_array($data['bank_account_id']) && !empty($data['bank_account_id']) ? array($data['bank_account_id']) : $data['bank_account_id'];
        $data['bank_id'] = !is_array($data['bank_id']) && !empty($data['bank_id']) ? array($data['bank_id']) : $data['bank_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['bank_account_id']) && !empty($data['bank_account_id'])) {
            $criteria[] = " t.bank_account_id IN (" . implode(', ', $data['bank_account_id']) . ") ";
        }

        if (isset($data['bank_id']) && !empty($data['bank_id'])) {
            $criteria[] = " t.bank_id IN (" . implode(', ', $data['bank_id']) . ") ";
        }

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN `". DB_PREFIX ."bank_account_to_store` ba2s ON (ba2s.bank_account_id=t.bank_account_id) ";
            $criteria[] = " ba2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['accountholder']) && !empty($data['accountholder'])) {
            $criteria[] = " LCASE(t.`accountholder`) LIKE '%" . $this->db->escape(strtolower($data['accountholder'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['email']) && !empty($data['email'])) {
            $criteria[] = " LCASE(t.`email`) LIKE '%" . $this->db->escape(strtolower($data['email'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['number']) && !empty($data['number'])) {
            $criteria[] = " LCASE(t.`number`) LIKE '%" . $this->db->escape(strtolower($data['number'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(b.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.bank_account_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'bank_account' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.bank_account_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.accountholder";
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
        return $this->__activate('bank_account', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('bank_account', $id);
      }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('bank_account', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('bank_account', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('bank_account', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('bank_account', $id, $group);
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
