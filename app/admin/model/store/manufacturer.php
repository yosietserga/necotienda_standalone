<?php

/**
 * ModelStoreManufacturer
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelStoreManufacturer extends Model {

    /**
     * ModelStoreManufacturer::add()
     * 
     * @param mixed $data
     * @see DB
     * @see Cache
     * @return void 
     */
    public function add($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET 
          name = '" . $this->db->escape($data['name']) . "', 
          sort_order = '" . (int) $data['sort_order'] . "', 
          date_added = NOW()");

        $manufacturer_id = $this->db->getLastId();

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");
        }

        foreach ($data['stores'] as $store) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET 
                store_id  = '" . intval($store) . "', 
                manufacturer_id = '" . intval($manufacturer_id) . "'");
        }

        if (!empty($data['keyword'])) {
            $languages = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
            foreach ($languages->rows as $language) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
                language_id = '" . (int) $language['language_id'] . "', 
                object_id   = '" . (int) $manufacturer_id . "', 
                object_type = 'manufacturer', 
                query       = 'manufacturer_id=" . (int) $manufacturer_id . "', 
                keyword     = '" . $this->db->escape($data['keyword']) . "'");
            }
        }

        foreach ($data['Products'] as $product_id => $value) {
            if ($value == 0)
                continue;
            $this->db->query("UPDATE " . DB_PREFIX . "product SET manufacturer_id = '" . (int) $manufacturer_id . "' WHERE product_id = '" . (int) $product_id . "'");
        }

        $this->cache->delete('manufacturer');
        return $manufacturer_id;
    }

    /**
     * ModelStoreManufacturer::editManufacturer()
     * 
     * @param int $manufacturer_id
     * @param mixed $data
     * @see DB
     * @see Cache
     * @return void 
     */
    public function update($manufacturer_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET 
          name = '" . $this->db->escape($data['name']) . "', 
          sort_order = '" . (int) $data['sort_order'] . "' 
          WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");
        //TODO: realizar una sola consulta al actualizar, no hace falta actualizar de nuevo si se cambio la imagen
        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");
        foreach ($data['stores'] as $store) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET 
                store_id  = '" . intval($store) . "', 
                manufacturer_id = '" . intval($manufacturer_id) . "'");
        }


        if (!empty($data['keyword'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias 
                WHERE object_id = '" . (int) $manufacturer_id . "' 
                AND object_type = 'manufacturer'");

            $languages = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
            foreach ($languages->rows as $language) {
                $this->db->query("REPLACE INTO " . DB_PREFIX . "url_alias SET 
                language_id = '" . (int) $language['language_id'] . "', 
                object_id   = '" . (int) $manufacturer_id . "', 
                object_type = 'manufacturer', 
                query       = 'manufacturer_id=" . (int) $manufacturer_id . "', 
                keyword     = '" . $this->db->escape($data['keyword']) . "'");
            }
        }

        if (isset($data['Products'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET manufacturer_id = '0' WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");
            foreach ($data['Products'] as $product_id => $value) {
                $this->db->query("UPDATE " . DB_PREFIX . "product SET manufacturer_id = '" . (int) $manufacturer_id . "' WHERE product_id = '" . (int) $product_id . "'");
            }
        }

        $this->cache->delete('manufacturer');
        return $manufacturer_id;
    }

    /**
     * ModelStoreManufacturer::deleteManufacturer()
     * 
     * @param int $manufacturer_id
     * @see DB
     * @see Cache
     * @return void 
     */
    public function delete($manufacturer_id) {
        $shared_tables = array(
            'property',
            'stat',
            'url_alias',
            'review',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id '". $manufacturer_id ."' ".
                "AND object_type = 'manufacturer'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");

        $this->cache->delete('manufacturer');
    }

    public function getStores($id) {
        $data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int) $id . "'");
        foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
        }
        return $data;
    }

    public function getSeoUrlRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "manufacturer` WHERE manufacturer_id NOT IN (SELECT `object_id` FROM `" . DB_PREFIX . "url_alias` WHERE `object_type` = 'manufacturer')");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "manufacturer`");
        return $query->row['total'] * 100 / $query2->row['total'];
    }

    public function getById($id) {
        $result = $this->getAll(array(
            'manufacturer_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.manufacturers";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "manufacturer t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'name',
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
        $cache_prefix = "admin.manufacturers.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturer t ";
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

        $data['manufacturer_id'] = !is_array($data['manufacturer_id']) && !empty($data['manufacturer_id']) ? array($data['manufacturer_id']) : $data['manufacturer_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];
        $data['product_id'] = !is_array($data['product_id']) && !empty($data['product_id']) ? array($data['product_id']) : $data['product_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "manufacturer_to_store t2s ON (t.manufacturer_id = t2s.manufacturer_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['product_id']) && !empty($data['product_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "manufacturer_to_category p2c ON (t.manufacturer_id = p2c.manufacturer_id) ";
            $criteria[] = " p2c.product_id IN (" . implode(', ', $data['product_id']) . ") ";
        }

        if (isset($data['manufacturer_id']) && !empty($data['manufacturer_id'])) {
            $criteria[] = " t.manufacturer_id IN (" . implode(', ', $data['manufacturer_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(td.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.manufacturer_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'manufacturer' ";
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
                $sql .= " GROUP BY t.manufacturer_id";
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

    public function activate($id) {
        return $this->__activate('manufacturer', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('manufacturer', $id);
    }
    
    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('manufacturer', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('manufacturer', $id, $data);
    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('manufacturer', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('manufacturer', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('manufacturer', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('manufacturer', $id, $group);
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
