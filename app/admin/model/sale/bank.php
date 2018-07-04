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
class ModelSaleBank extends Model {

    public function add($data) {
        $sql = "INSERT INTO `". DB_PREFIX ."bank` SET ".
        "`name` = '". $this->db->escape($data['name']) ."', ".
        "`image` = '". $this->db->escape($data['image']) ."', ".
        "`date_added` = NOW()";
        
        $this->db->query($sql);
        
        return $this->db->getLastId();
    }
    
    public function update($id,$data) {
        $sql = "UPDATE `". DB_PREFIX ."bank` SET  ".
        "`name` = '". $this->db->escape($data['name']) ."', ".
        "`image` = '". $this->db->escape($data['image']) ."', ".
        "`date_modified` = NOW() ".
        "WHERE bank_id = '". (int)$id ."'";
        
        $this->db->query($sql);
    }

	/**
	 * ModelStoreProduct::copy()
	 * 
	 * @param int $product_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function copy($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "bank WHERE bank_id = '" . (int)$id . "'");
		
		if ($query->num_rows) {
			$data = array();
			$data = $query->row;
			$data['name'] = $data['name'] ." - copia";
			$this->add($data);
		}
	}
    
    public function delete($id) {
        $result = $this->db->query("SELECT * FROM ". DB_PREFIX ."bank_account WHERE bank_id = '". (int)$id ."'");
        if (!$result->num_rows) {
            $shared_tables = array(
                'property',
                'stat',
            );

            foreach ($shared_tables as $table) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                    "WHERE object_id  = ". (int)$id ." ".
                    "AND object_type = 'bank'");
            }

            $this->db->query("DELETE FROM ". DB_PREFIX ."bank WHERE bank_id = '". (int)$id ."'");
        } else {
            return false;
        }
    }

    public function getById($id) {
        $result = $this->getAll(array(
            'bank_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.banks";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "bank t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.name'
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
        $cache_prefix = "admin.banks.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "bank t ";
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

        $data['bank_id'] = !is_array($data['bank_id']) && !empty($data['bank_id']) ? array($data['bank_id']) : $data['bank_id'];

        if (isset($data['bank_id']) && !empty($data['bank_id'])) {
            $criteria[] = " t.bank_id IN (" . implode(', ', $data['bank_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.bank_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'bank' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.bank_id";
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

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('bank', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('bank', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('bank', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('bank', $id, $group);
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
