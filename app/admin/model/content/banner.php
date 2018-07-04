<?php

/**
 * ModelContentBanner
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelContentBanner extends Model {

    /**
     * ModelContentBanner::add()
     * 
     * @param mixed $data
     * @see DB
     * @see Cache
     * @return void
     */
    public function add($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "banner SET ".
            "`name`              = '" . $this->db->escape($data['name']) . "', ".
            "`jquery_plugin`     = '" . $this->db->escape($data['jquery_plugin']) . "', ".
            "`params`            = '" . $this->db->escape($data['params']) . "', ".
            "`publish_date_start`= '" . $this->db->escape($data['publish_date_start']) . "', ".
            "`publish_date_end`  = '" . $this->db->escape($data['publish_date_end']) . "', ".
            "`status`            = '1', ".
            "`date_added`        = NOW()");

        $id = $this->db->getLastId();

        foreach ($data['stores'] as $store) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "banner_to_store SET ".
            "store_id       = '" . intval($store) . "', ".
            "banner_id        = '" . intval($id) . "'");
        }

        $this->deleteItems($id);
        foreach ($data['items'] as $key => $item) {
            $item['banner_id'] = $id;
            $item['sort_order'] = $key;
            $banner_item_id = $this->setItem($item);
            $this->setDescriptions($banner_item_id, $item['descriptions']);
        }

        $this->cache->delete('banner');
        return $id;
    }

    /**
     * ModelContentBanner::update()
     * 
     * @param int $id
     * @param mixed $data
     * @see DB
     * @see Cache
     * @return void
     */
    public function update($id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "banner SET 
        `name`              = '" . $this->db->escape($data['name']) . "', 
        `jquery_plugin`     = '" . $this->db->escape($data['jquery_plugin']) . "', 
        `params`            = '" . $this->db->escape($data['params']) . "', 
        `publish_date_start`= '" . $this->db->escape($data['publish_date_start']) . "', 
        `publish_date_end`  = '" . $this->db->escape($data['publish_date_end']) . "', 
        `date_modified`     = NOW()
        WHERE banner_id = '" . (int) $id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "banner_to_store WHERE banner_id = '" . (int) $id . "'");
        foreach ($data['stores'] as $store) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "banner_to_store SET 
                store_id  = '" . intval($store) . "', 
                banner_id = '" . intval($id) . "'");
        }

        $this->deleteItems($id);
        foreach ($data['items'] as $key => $item) {
            $item['banner_id'] = $id;
            $item['sort_order'] = $key;
            $banner_item_id = $this->setItem($item);
            $this->setDescriptions($banner_item_id, $item['descriptions']);
        }

        $this->cache->delete('banner');
    }

    /**
     * ModelContentBanner::delete()
     * 
     * @param int $id
     * @see DB
     * @see Cache
     * @return void
     */
    public function delete($id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "banner_to_store WHERE banner_id = '" . (int) $id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "description WHERE object_id IN (SELECT banner_item_id FROM " . DB_PREFIX . "banner_item WHERE banner_id = '" . (int) $id . "') AND object_type = 'banner_item' ");
        $this->db->query("DELETE FROM " . DB_PREFIX . "property WHERE object_id = '" . (int) $id . "' AND object_type = 'banner'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "property WHERE object_id IN (SELECT banner_item_id FROM " . DB_PREFIX . "banner_item WHERE banner_id = '" . (int) $id . "') AND object_type = 'banner_item'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "banner_item WHERE banner_id = '" . (int) $id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "banner WHERE banner_id = '" . (int) $id . "'");
    }

    /**
     * ModelContentBanner::getById()
     * 
     * @param int $id
     * @see DB
     * @see Cache
     * @return array sql record
     */
    public function getById($id) {
        $results = $this->getAll(array('banner_id'=>$id));
        $results[0]['banner_items'] = $this->getItems($id);
        $results[0]['banner_stores'] = $this->getStores($id);
        return $results[0];
    }

    /**
     * ModelContentCategory::getItems()
     * 
     * @param int $id
     * @see DB
     * @return array sql records
     */
    public function getItems($id) {
        $data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_item WHERE banner_id = '" . (int) $id . "' ORDER BY sort_order");
        foreach ($query->rows as $key => $result) {
            $data[$key] = $result;
            $data[$key]['descriptions'] = $this->getDescriptions($result['banner_item_id']);
        }
        return $data;
    }

    public function setItem($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "banner_item SET ".
            "`banner_id`  = '" . intval($data['banner_id']) . "', ".
            "`sort_order` = '" . intval($data['sort_order']) . "', ".
            "`status`     = '1', ".
            "`image`      = '" . $this->db->escape($data['image']) . "',".
            "`link`       = '" . $this->db->escape($data['link']) . "'");

        return $this->db->getLastId();
    }

    public function deleteItems($banner_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "description WHERE object_id IN (SELECT banner_item_id FROM " . DB_PREFIX . "banner_item WHERE banner_id = '" . (int) $banner_id . "') AND object_type = 'banner_item'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "banner_item WHERE banner_id = '" . $banner_id . "'");
    }

    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('banner_item', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('banner_item', $id, $data);
    }

    public function getStores($id) {
        $data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_to_store WHERE banner_id = '" . (int) $id . "'");
        foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
        }
        return $data;
    }

    /**
     * ModelContentBanner::getAll()
     * 
     * @param mixed $data
     * @see DB
     * @see Cache
     * @return array sql records
     */
    public function getAll($data = array()) {

        $cache_prefix = "admin.banners";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "banner t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'name',
                    'publish_date_start',
                    'publish_date_end'
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
        $cache_prefix = "admin.banners.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "banner t ";
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
        $data['banner_id'] = !is_array($data['banner_id']) && !empty($data['banner_id']) ? array($data['banner_id']) : $data['banner_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "banner_to_store t2s ON (t.banner_id = t2s.banner_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['banner_id']) && !empty($data['banner_id'])) {
            $criteria[] = " banner_id IN (" . implode(', ', $data['banner_id']) . ") ";
        }

        if (!empty($data['name'])) {
            $criteria[] = " LCASE(t.name) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['plugin'])) {
            $criteria[] = "LCASE(t.jquery_plugin) LIKE '%" . $this->db->escape(strtolower($data['plugin'])) . "%'";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if ($data['queries']) {
            $search = '';
            foreach ($data['queries'] as $key => $value) {
                if (empty($value)) continue;
                if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                    $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                $search .= " LCASE(t.name) LIKE '%" . $this->db->escape(strtolower(trim($value))) . "%' collate utf8_general_ci OR";
            }
            if (!empty($search)) {
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.banner_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'banner' ";
            }
        }

        if (!empty($data['publish_date_start'])) {
            $criteria[] = "publish_date_start <= '" . date('Y-m-d h:i:s', strtotime($data['publish_date_start'])) . "'";
        }

        if (!empty($data['publish_date_end'])) {
            $criteria[] = "publish_date_end >= '" . date('Y-m-d h:i:s', strtotime($data['publish_date_end'])) . "'";
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
                $sql .= " GROUP BY t.banner_id";
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

    /**
     * ModelContentBanner::sortBanner()
     * @param array $data
     * @see DB
     * @see Cache
     * @return void
     */
    public function sortBanner($data) {
        if (!is_array($data))
            return false;
        $pos = 1;
        foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "banner SET sort_order = '" . (int) $pos . "' WHERE banner_id = '" . (int) $id . "'");
            $pos++;
        }
        return true;
    }

    public function activate($id) {
        return $this->__activate('banner', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('banner', $id);
    }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('banner', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('banner', $id, $group, $key, $value);
    }

    public function deleteProperties($id, $group='*', $key='*') {
        return $this->__deleteProperties('banner', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('banner', $id, $group);
    }

    public function setAllProperties($id, $group, $data) {
        if (is_array($data) && !empty($data)) {
            $this->deleteProperties($id, $group);
            foreach ($data as $key => $value) {
                $this->setProperty($id, $group, $key, $value);
            }
        }
    }

    public function getItemProperty($id, $group, $key) {
        return $this->__getProperty('banner_item', $id, $group, $key);
    }

    public function setItemProperty($id, $group, $key, $value) {
        return $this->__setProperty('banner_item', $id, $group, $key, $value);
    }

    public function deleteItemProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('banner_item', $id, $group, $key);
    }

    public function getAllItemProperties($id, $group = '*') {
        return $this->__getProperties('banner_item', $id, $group);
    }

    public function setAllItemProperties($id, $group, $data) {
        if (is_array($data) && !empty($data)) {
            $this->deleteProperty($id, $group);
            foreach ($data as $key => $value) {
                $this->setProperty($id, $group, $key, $value);
            }
        }
    }
}
