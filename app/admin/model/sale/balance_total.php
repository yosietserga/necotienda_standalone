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
class ModelSaleBalanceTotal extends Model {

    public function add($data) {

        $this->db->query("INSERT INTO " . DB_PREFIX . "balance_total SET ".
            "`customer_id`        = '" . (int)$data['customer_id'] . "',".
            "`currency_id`        = '" . (int)$data['currency_id'] . "',".
            "`amount_available`   = '" . float($data['amount_available'], 4) . "',".
            "`amount_deferred`    = '" . float($data['amount_deferred'], 4) . "',".
            "`amount_blocked`     = '" . float($data['amount_blocked'], 4) . "',".
            "`amount_total`       = '" . float($data['amount_total'], 4) . "',".
            "`date_modified`      = NOW()");

        $id = $this->db->getLastId();
        
        return $id;
    }
    
    public function update($id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "balance_total SET ".
            "`customer_id`        = '" . (int)$data['customer_id'] . "',".
            "`currency_id`        = '" . (int)$data['currency_id'] . "',".
            "`amount_available`   = '" . float($data['amount_available'], 4) . "',".
            "`amount_deferred`    = '" . float($data['amount_deferred'], 4) . "',".
            "`amount_blocked`     = '" . float($data['amount_blocked'], 4) . "',".
            "`amount_total`       = '" . float($data['amount_total'], 4) . "',".
            "`date_modified`      = NOW()".
        "WHERE balance_total_id     = '". (int)$id ."'");
    }
    
    public function delete($id) {

        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$id ." ".
                "AND object_type = 'balance_total'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "balance_total WHERE `balance_total_id` = '".(int)$id."'");
    }

    public function getById($id) {
        $result = $this->getAll(array(
            'balance_total_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.balance_totals";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "balance_total t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'amount_available',
                    'amount_deferred',
                    'amount_blocked',
                    'amount_total',
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
        $cache_prefix = "admin.balance_totals.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "balance_total t ";
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

        $data['balance_total_id'] = !is_array($data['balance_total_id']) && !empty($data['balance_total_id']) ? array($data['balance_total_id']) : $data['balance_total_id'];
        $data['currency_id'] = !is_array($data['currency_id']) && !empty($data['currency_id']) ? array($data['currency_id']) : $data['currency_id'];
        $data['customer_id'] = !is_array($data['customer_id']) && !empty($data['customer_id']) ? array($data['customer_id']) : $data['customer_id'];

        if (isset($data['customer_name']) || isset($data['customer_email'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "customer c ON (t.customer_id = c.customer_id) ";
        }

        if (isset($data['balance_total_id']) && !empty($data['balance_total_id'])) {
            $criteria[] = " t.balance_total_id IN (" . implode(', ', $data['balance_total_id']) . ") ";
        }

        if (isset($data['currency_id']) && !empty($data['currency_id'])) {
            $criteria[] = " t.currency_id IN (" . implode(', ', $data['currency_id']) . ") ";
        }

        if (isset($data['customer_id']) && !empty($data['customer_id'])) {
            $criteria[] = " t.customer_id IN (" . implode(', ', $data['customer_id']) . ") ";
        }

        if (isset($data['from_amount_total']) || isset($data['to_amount_total'])) {

            if (isset($data['from_amount_total']) && !empty($data['from_amount_total'])) {
                $criteria[] = " t.`amount_total` >= '" . $this->db->escape((float)$data['from_amount_total']) . "' ";
            }

            if (isset($data['to_amount_total']) && !empty($data['to_amount_total'])) {
                $criteria[] = " t.`amount_total` <= '" . $this->db->escape((float)$data['to_amount_total']) . "' ";
            }

        } elseif (isset($data['amount_total']) && !empty($data['amount_total'])) {
            $criteria[] = " t.`amount_total` = '" . $this->db->escape((float)$data['amount_total']) . "' ";
        }

        if (isset($data['from_amount_available']) || isset($data['to_amount_available'])) {

            if (isset($data['from_amount_available']) && !empty($data['from_amount_available'])) {
                $criteria[] = " t.`amount_available` >= '" . $this->db->escape((float)$data['from_amount_available']) . "' ";
            }

            if (isset($data['to_amount_available']) && !empty($data['to_amount_available'])) {
                $criteria[] = " t.`amount_available` <= '" . $this->db->escape((float)$data['to_amount_available']) . "' ";
            }

        } elseif (isset($data['amount_available']) && !empty($data['amount_available'])) {
            $criteria[] = " t.`amount_available` = '" . $this->db->escape((float)$data['amount_available']) . "' ";
        }

        if (isset($data['from_amount_deferred']) || isset($data['to_amount_deferred'])) {

            if (isset($data['from_amount_deferred']) && !empty($data['from_amount_deferred'])) {
                $criteria[] = " t.`amount_deferred` >= '" . $this->db->escape((float)$data['from_amount_deferred']) . "' ";
            }

            if (isset($data['to_amount_deferred']) && !empty($data['to_amount_deferred'])) {
                $criteria[] = " t.`amount_deferred` <= '" . $this->db->escape((float)$data['to_amount_deferred']) . "' ";
            }

        } elseif (isset($data['amount_deferred']) && !empty($data['amount_deferred'])) {
            $criteria[] = " t.`amount_deferred` = '" . $this->db->escape((float)$data['amount_deferred']) . "' ";
        }

        if (isset($data['from_amount_blocked']) || isset($data['to_amount_blocked'])) {

            if (isset($data['from_amount_blocked']) && !empty($data['from_amount_blocked'])) {
                $criteria[] = " t.`amount_blocked` >= '" . $this->db->escape((float)$data['from_amount_blocked']) . "' ";
            }

            if (isset($data['to_amount_blocked']) && !empty($data['to_amount_blocked'])) {
                $criteria[] = " t.`amount_blocked` <= '" . $this->db->escape((float)$data['to_amount_blocked']) . "' ";
            }

        } elseif (isset($data['amount_blocked']) && !empty($data['amount_blocked'])) {
            $criteria[] = " t.`amount_blocked` = '" . $this->db->escape((float)$data['amount_blocked']) . "' ";
        }

        if (isset($data['customer_name']) && !empty($data['customer_name'])) {
            $criteria[] = " LCASE(CONCAT(c.`firstname`, ' ', c.`lastname`)) LIKE '%" . $this->db->escape(strtolower($data['customer_name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['customer_email']) && !empty($data['customer_email'])) {
            $criteria[] = " LCASE(c.`email`) LIKE '%" . $this->db->escape(strtolower($data['customer_email'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " date_modified BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " date_modified BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.balance_total_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'balance_total' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.balance_total_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.date_modified";
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
        return $this->__activate('balance_total', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('balance_total', $id);
      }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('balance_total', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('balance_total', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('balance_total', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('balance_total', $id, $group);
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
