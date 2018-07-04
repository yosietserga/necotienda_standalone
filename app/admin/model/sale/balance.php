<?php
/**
 * ModelSaleBalance
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelSaleBalance extends Model {

    public function add($data) {

        $this->db->query("INSERT INTO " . DB_PREFIX . "balance SET ".
            "`customer_id`        = '" . (int)$data['customer_id'] . "',".
            "`currency_id`        = '" . (int)$data['currency_id'] . "',".
            "`type`               = '" . $this->db->escape($data['type']) . "',".
            "`amount`             = '" . float($data['amount'], 4) . "',".
            "`amount_available`   = '" . float($data['amount_available'], 4) . "',".
            "`amount_deferred`    = '" . float($data['amount_deferred'], 4) . "',".
            "`amount_blocked`     = '" . float($data['amount_blocked'], 4) . "',".
            "`amount_total`       = '" . float($data['amount_total'], 4) . "',".
            "`description`        = '" . $this->db->escape($data['description']) . "',".
            "`currency_code`      = '" . $this->db->escape($data['currency_code']) . "',".
            "`currency_value`     = '" . $this->db->escape($data['currency_value']) . "',".
            "`currency_title`     = '" . $this->db->escape($data['currency_title']) . "', ".
            "`date_added`      = NOW()");

        $id = $this->db->getLastId();
        
        return $id;
    }
    
    public function update($id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "balance SET ".
            "`customer_id`        = '" . (int)$data['customer_id'] . "',".
            "`currency_id`        = '" . (int)$data['currency_id'] . "',".
            "`type`               = '" . $this->db->escape($data['type']) . "',".
            "`amount`             = '" . float($data['amount'], 4) . "',".
            "`amount_available`   = '" . float($data['amount_available'], 4) . "',".
            "`amount_deferred`    = '" . float($data['amount_deferred'], 4) . "',".
            "`amount_blocked`     = '" . float($data['amount_blocked'], 4) . "',".
            "`amount_total`       = '" . float($data['amount_total'], 4) . "',".
            "`description`        = '" . $this->db->escape($data['description']) . "',".
            "`currency_code`      = '" . $this->db->escape($data['currency_code']) . "',".
            "`currency_value`     = '" . $this->db->escape($data['currency_value']) . "',".
            "`currency_title`     = '" . $this->db->escape($data['currency_title']) . "' ".
        "WHERE balance_id     = '". (int)$id ."'");
    }
    
    public function delete($id) {

        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$id ." ".
                "AND object_type = 'balance'");
        }


        $this->db->query("DELETE FROM " . DB_PREFIX . "balance WHERE `balance_id` = '".(int)$id."'");
    }
    

    public function getById($id) {
        $result = $this->getAll(array(
            'balance_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.balances";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "balance t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.type',
                    'amount',
                    't.description'
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
        $cache_prefix = "admin.balances.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "balance t ";
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

        $data['balance_id'] = !is_array($data['balance_id']) && !empty($data['balance_id']) ? array($data['balance_id']) : $data['balance_id'];
        $data['currency_id'] = !is_array($data['currency_id']) && !empty($data['currency_id']) ? array($data['currency_id']) : $data['currency_id'];
        $data['customer_id'] = !is_array($data['customer_id']) && !empty($data['customer_id']) ? array($data['customer_id']) : $data['customer_id'];

        if (isset($data['customer_name']) || isset($data['customer_email'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "customer c ON (t.customer_id = c.customer_id) ";
        }

        if (isset($data['balance_id']) && !empty($data['balance_id'])) {
            $criteria[] = " t.balance_id IN (" . implode(', ', $data['balance_id']) . ") ";
        }

        if (isset($data['currency_id']) && !empty($data['currency_id'])) {
            $criteria[] = " t.currency_id IN (" . implode(', ', $data['currency_id']) . ") ";
        }

        if (isset($data['customer_id']) && !empty($data['customer_id'])) {
            $criteria[] = " t.customer_id IN (" . implode(', ', $data['customer_id']) . ") ";
        }

        if (isset($data['from_amount']) || isset($data['to_amount'])) {

            if (isset($data['from_amount']) && !empty($data['from_amount'])) {
                $criteria[] = " t.`amount` >= '" . $this->db->escape((float)$data['from_amount']) . "' ";
            }

            if (isset($data['to_amount']) && !empty($data['to_amount'])) {
                $criteria[] = " t.`amount` <= '" . $this->db->escape((float)$data['to_amount']) . "' ";
            }

        } elseif (isset($data['amount']) && !empty($data['amount'])) {
            $criteria[] = " t.`amount` = '" . $this->db->escape((float)$data['amount']) . "' ";
        } 

        if (isset($data['type']) && !empty($data['type'])) {
            $criteria[] = " LCASE(t.`type`) = '" . $this->db->escape(strtolower($data['type'])) . "' collate utf8_general_ci ";
        }

        if (isset($data['currency_code']) && !empty($data['currency_code'])) {
            $criteria[] = " LCASE(t.`currency_code`) LIKE '%" . $this->db->escape(strtolower($data['currency_code'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['currency_title']) && !empty($data['currency_title'])) {
            $criteria[] = " LCASE(t.`currency_title`) LIKE '%" . $this->db->escape(strtolower($data['currency_title'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['description']) && !empty($data['description'])) {
            $criteria[] = " LCASE(t.`description`) LIKE '%" . $this->db->escape(strtolower($data['description'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['customer_name']) && !empty($data['customer_name'])) {
            $criteria[] = " LCASE(CONCAT(c.`firstname`, ' ', c.`lastname`)) LIKE '%" . $this->db->escape(strtolower($data['customer_name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['customer_email']) && !empty($data['customer_email'])) {
            $criteria[] = " LCASE(c.`email`) LIKE '%" . $this->db->escape(strtolower($data['customer_email'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.balance_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'balance' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.balance_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.date_added";
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
        return $this->__activate('balance', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('balance', $id);
      }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('balance', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('balance', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('balance', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('balance', $id, $group);
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
