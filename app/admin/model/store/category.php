<?php

/**
 * ModelStoreCategory
 * 
 * @package NecoTienda
 * @author NecoTienda
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 */
class ModelStoreCategory extends Model {

    /**
     * ModelStoreCategory::add()
     * 
     * @param mixed $data
     * @see DB
     * @see Cache
     * @return void
     */
    public function add($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "category SET 
        parent_id = '" . (int) $data['parent_id'] . "', 
        sort_order = '0', 
        status = '1', 
        date_modified = NOW(), 
        date_added = NOW()");

        $category_id = $this->db->getLastId();

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int) $category_id . "'");
        }

        $this->setDescriptions($category_id, $data['category_description']);

        foreach ($data['stores'] as $store) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET 
                store_id  = '" . intval($store) . "', 
                category_id = '" . intval($category_id) . "'");
        }


        foreach ($data['Products'] as $product_id => $value) {
            if ($value == 0) continue;
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category (product_id, category_id) VALUES ('" . (int) $product_id . "','" . (int) $category_id . "')");
        }

        $this->cache->delete('category_admin');

        return $category_id;
    }

    /**
     * ModelStoreCategory::editCategory()
     * 
     * @param int $category_id
     * @param array $data
     * @see DB
     * @see Cache
     * @return void
     */
    public function update($category_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "category SET 
        parent_id = '" . (int) $data['parent_id'] . "',
        date_modified = NOW() 
        WHERE category_id = '" . (int) $category_id . "'");

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int) $category_id . "'");
        }

        $this->setDescriptions($category_id, $data['category_description']);

        $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int) $category_id . "'");
        foreach ($data['stores'] as $store) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET 
                store_id  = '" . intval($store) . "', 
                category_id = '" . intval($category_id) . "'");
        }


        if (!empty($data['Products'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id='" . (int) $category_id . "'");
            foreach ($data['Products'] as $product_id => $value) {
                if ($value == 0) continue;
                $this->db->query("REPLACE INTO " . DB_PREFIX . "product_to_category (product_id, category_id) VALUES ('" . (int) $product_id . "','" . (int) $category_id . "')");
            }
        }

        $this->cache->delete('category_admin');
    }

    /**
     * ModelStoreCategory::sortCategory()
     * @param array $data
     * @see DB
     * @see Cache
     * @return void
     */
    public function sortCategory($data) {
        if (!is_array($data))
            return false;
        $pos = 1;
        foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "category SET sort_order = '" . (int) $pos . "' WHERE category_id = '" . (int) $id . "'");
            $pos++;
        }
        $this->cache->delete('category_admin');
        return true;
    }

    /**
     * ModelStoreCategory::delete()
     * 
     * @param int $category_id
     * @see DB
     * @see Cache
     * @return void
     */
    public function delete($category_id) {
        $shared_tables = array(
            'property',
            'description',
            'stat',
            'url_alias',
            'review',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id IN ( ".
                    "SELECT category_id ".
                    "FROM " . DB_PREFIX . "category ".
                    "WHERE category_id = '" . (int) $category_id . "' ".
                    "OR parent_id = '" . (int) $category_id . "' ".
                ") ".
                "AND object_type = 'category'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int) $category_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int) $category_id . "' OR parent_id = '" . (int) $category_id . "'");

        $this->cache->delete('category_admin');
    }

    public function getStores($id) {
        $data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int) $id . "'");
        foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
        }
        return $data;
    }

    /**
     * ModelStoreCategory::getPath()
     * 
     * @param int $category_id
     * @return string 
     */
    public function getPath($category_id) {
        $query = $this->db->query("SELECT title, parent_id 
        FROM " . DB_PREFIX . "category c 
            LEFT JOIN " . DB_PREFIX . "description cd ON (c.category_id = cd.object_id) 
        WHERE c.category_id = '" . (int) $category_id . "' 
            AND cd.object_type = 'category' 
            AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "' 
        ORDER BY c.sort_order, cd.title ASC");

        $category_info = $query->row;

        if ($category_info['parent_id']) {
            return $this->getPath($category_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $category_info['title'];
        } else {
            return $category_info['title'];
        }
    }

    public function getSeoTitleRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE CHAR_LENGTH(`title`) NOT BETWEEN 8 AND 55 AND object_type = 'category' ");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE object_type = 'category'");
        return $query->row['total'] * 100 / $query2->row['total'];
    }

    public function getSeoMetaDescripionRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE CHAR_LENGTH(`meta_description`) NOT BETWEEN 8 AND 155 AND object_type = 'category'");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE object_type = 'category'");
        return $query->row['total'] * 100 / $query2->row['total'];
    }

    public function getSeoDescriptionRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE CHAR_LENGTH(`description`) < 150 AND object_type = 'category'");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE object_type = 'category'");
        return $query->row['total'] * 100 / $query2->row['total'];
    }

    public function getSeoUrlRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "category` WHERE category_id NOT IN (SELECT `object_id` FROM `" . DB_PREFIX . "url_alias` WHERE `object_type` = 'category')");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "category`");
        return $query->row['total'] * 100 / $query2->row['total'];
    }

    public function getById($id) {
        $result = $this->getAll(array(
            'category_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.categories";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "category t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.category_id = td.object_id) ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'publish_date_start',
                    'publish_date_end',
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
        $cache_prefix = "admin.categories.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.category_id = td.object_id) ";
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

        $criteria[] = " td.object_type = 'category' ";

        $data['category_id'] = !is_array($data['category_id']) && !empty($data['category_id']) ? array($data['category_id']) : $data['category_id'];
        $data['parent_id'] = !is_array($data['parent_id']) && (!empty($data['parent_id']) || $data['parent_id'] === 0) ? array($data['parent_id']) : $data['parent_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];
        $data['product_id'] = !is_array($data['product_id']) && !empty($data['product_id']) ? array($data['product_id']) : $data['product_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "category_to_store t2s ON (t.category_id = t2s.category_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['product_id']) && !empty($data['product_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (t.category_id = p2c.category_id) ";
            $criteria[] = " p2c.product_id IN (" . implode(', ', $data['product_id']) . ") ";
        }

        if (isset($data['category_id']) && !empty($data['category_id'])) {
            $criteria[] = " t.category_id IN (" . implode(', ', $data['category_id']) . ") ";
        }

        if (isset($data['parent_id'])) {
            $criteria[] = " t.parent_id IN (" . implode(', ', $data['parent_id']) . ") ";
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

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.category_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'category' ";
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
                $sql .= " GROUP BY t.category_id";
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

    public function activate($id) {
        return $this->__activate('category', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('category', $id);
    }
    
    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('category', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('category', $id, $data);
    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('category', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('category', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('category', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('category', $id, $group);
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
