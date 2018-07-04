<?php

class ModelStoreStore extends Model {

    public function add($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "store SET 
          name = '" . $this->db->escape($data['config_name']) . "', 
          folder = '" . $this->db->escape($data['config_folder']) . "', 
          status = '1', 
          date_added = NOW()");

        $store_id = $this->db->getLastId();

        foreach ($data as $key => $value) {
            $this->setSettings($store_id, 'config', $key, $value);
        }

        $this->cache->delete('store');
        return $store_id;
    }

    public function update($store_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "store SET 
          name = '" . $this->db->escape($data['config_name']) . "', 
          status = '1', 
          date_modified = NOW()
          WHERE store_id = '" . (int) $store_id . "'");

        $this->deleteSettings($store_id, 'config');
        foreach ($data as $key => $value) {
            $this->setSettings($store_id, 'config', $key, $value);
        }

        $this->cache->delete('store');
    }

    public function saveContent($store_id, $data) {
        if (!empty($data['Products'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Products'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                product_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['Categories'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Categories'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                category_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['Manufacturers'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Manufacturers'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                manufacturer_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['Downloads'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "download_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Downloads'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "download_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                download_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['Pages'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "post_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Pages'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "post_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                post_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['Posts'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "post_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Posts'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "post_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                post_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['PostCategories'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "post_category_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['PostCategories'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "post_category_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                post_category_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['Banners'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "banner_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Banners'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "banner_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                banner_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['Menus'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "menu_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Menus'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "menu_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                menu_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['Coupons'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "coupon_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Coupons'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "coupon_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                coupon_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['BankAccounts'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "bank_account_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['BankAccounts'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "bank_account_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                bank_account_id = '" . (int) $result . "'");
            }
        }

        if (!empty($data['Customers'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "customer_to_store WHERE store_id = '" . (int) $store_id . "'");
            foreach ($data['Customers'] as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_store SET 
                store_id    = '" . (int) $store_id . "', 
                customer_id = '" . (int) $result . "'");
            }
        }

        $this->cache->delete('store');
    }

    public function delete($store_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int) $store_id . "' AND `key` = 'config_folder'");

        if (!empty($query->row['config_folder'])) {
            $this->deleteFiles(DIR_ROOT . "app/{$query->row['config_folder']}/*");
            $this->deleteFiles(DIR_ROOT . "web/{$query->row['config_folder']}/*");
        }

        $shared_tables = array(
            'property',
            'description',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$store_id ." ".
                "AND object_type = 'store'");
        }

        $related_tables = array(
            'bank_account',
            'banner',
            'coupon',
            'customer',
            'download',
            'menu',
            'object',
            'post_category',
            'post',
            'template',
            'theme',
            'category',
            'product',
            'manufacturer',
        );

        foreach ($related_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "{$table}_to_store WHERE store_id = '". (int)$store_id ."' ");
        }

        $drop_tables = array(
            'setting',
            'search',
            'store',
            'stat',
        );

        foreach ($drop_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "{$table} WHERE store_id = '". (int)$store_id ."' ");
        }

        $this->cache->delete('store');
    }

    public function deleteFiles($folder) {
        if (empty($folder))
            return false;
        $files = glob($folder);
        if ($files) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    if (is_dir($file)) {
                        $this->deleteFiles($file . "/*");
                    } else {
                        unlink($file);
                    }
                }
            }
        }
    }

    public function getSettings($id = 0, $group = '*', $key = '*') {

        $sql = "SELECT * FROM " . DB_PREFIX . "setting ";
        $criteria = $rows = array();
        $criteria[] = " `store_id` = '" . (int)$id . "' ";

        if (!is_null($group) && !empty($group) && $group != '*') {
            $criteria[] = " `group` = '" . $this->db->escape($group) . "' ";
        }

        if (!is_null($key) && !empty($key) && $key != '*') {
            $criteria[] = " `key` = '" . $this->db->escape($key) . "' ";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        $query = $this->db->query($sql);

        foreach ($query->rows as $row) {
            $rows[] = unserialize(str_replace("\'", "'", $row['value']));
        }

        return $rows;
    }

    public function setSetting($id, $group, $key, $value) {
        if (empty($group) || empty($key)) {
            return null;
        }

        $this->deleteSettings($id, $group, $key);
        $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET ".
            "`store_id`    = '" . (int) $id . "',".
            "`group`        = '" . $this->db->escape($group) . "',".
            "`key`          = '" . $this->db->escape($key) . "',".
            "`value`        = '" . $this->db->escape(str_replace("'", "\'", serialize($value))) . "'");
    }

    public function deleteSettings($id, $group, $key) {
        $sql = "DELETE FROM " . DB_PREFIX . "setting ";
        $criteria = $rows = array();
        $criteria[] = " `store_id` = '" . (int)$id . "' ";
        
        if (!is_null($group) && !empty($group) && $group != '*') {
            $criteria[] = " `group` = '" . $this->db->escape($group) . "' ";
        }
        
        if (!is_null($key) && !empty($key) && $key != '*') {
            $criteria[] = " `key` = '" . $this->db->escape($key) . "' ";
        }
        
        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }
        $this->db->query($sql);
    }

    public function editMaintenance($data, $group = 'config') {
        $this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($data) . "' WHERE `key` = 'config_maintenance'");
    }

    public function getByID($id) {
        $result = $this->getAll(array(
            'store_id'=>$id,
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.stores";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "store t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.name',
                    't.date_added'
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
        $cache_prefix = "admin.stores.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "store t ";
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

        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $criteria[] = " t.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['settings'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "setting ss ON (t.store_id = ss.store_id) ";
            foreach ($data['settings'] as $key => $value) {
                $criteria[] = " LCASE(ss.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(ss.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
            }
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.store_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'store' ";
            }
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.store_id";
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

    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('store', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('store', $id, $data);
    }

    public function activate($id) {
        return $this->__activate('store', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('store', $id);
    }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('store', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('store', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('store', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('store', $id, $group);
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
