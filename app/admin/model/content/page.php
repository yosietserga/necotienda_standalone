<?php

/**
 * ModelContentPage
 *
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelContentPage extends Model {

    public function add($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "post SET ".
            "parent_id   = '" . (int) $this->request->post['parent_id'] . "',".
            "image = '" . $this->db->escape($data['image']) . "',".
            "publish     = '" . (int) $this->request->post['publish'] . "',".
            "allow_reviews     = '" . (int) $this->request->post['allow_reviews'] . "',".
            "date_publish_start = '" . $this->db->escape($data['date_publish_start']) . "',".
            "date_publish_end = '" . $this->db->escape($data['date_publish_end']) . "',".
            "template    = '" . $this->db->escape($data['template']) . "', ".
            "post_type   = 'page', ".
            "status      = 1, ".
            "sort_order  = 0, ".
            "date_added  = NOW()");

        $post_id = $this->db->getLastId();

        $this->setDescriptions($post_id, $data['page_description']);

        foreach ($data['stores'] as $store) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "post_to_store SET ".
                "store_id   = '" . intval($store) . "', ".
                "post_id    = '" . intval($post_id) . "'");
        }

        $this->cache->delete("page");
        return $post_id;
    }

    public function update($post_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "post SET ".
            "parent_id   = '" . (int) $this->request->post['parent_id'] . "',".
            "image = '" . $this->db->escape($data['image']) . "',".
            "publish     = '" . (int) $this->request->post['publish'] . "',".
            "allow_reviews     = '" . (int) $this->request->post['allow_reviews'] . "',".
            "date_publish_start = '" . $this->db->escape($data['date_publish_start']) . "',".
            "date_publish_end = '" . $this->db->escape($data['date_publish_end']) . "',".
            "template    = '" . $this->db->escape($data['template']) . "', ".
            "sort_order  = '" . (int) $this->request->post['sort_order'] . "', ".
            "date_modified  = NOW() ".
        "WHERE post_id = '" . (int) $post_id . "'");

        $this->setDescriptions($post_id, $data['page_description']);

        $this->db->query("DELETE FROM " . DB_PREFIX . "post_to_store WHERE post_id = '" . (int) $post_id . "'");
        foreach ($data['stores'] as $store) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "post_to_store SET ".
                "store_id   = '" . intval($store) . "', ".
                "post_id    = '" . intval($post_id) . "'");
        }

        $this->cache->delete("page");
    }

    public function copy($post_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "post p ".
            "LEFT JOIN " . DB_PREFIX . "description pd ON (p.post_id = pd.object_id) ".
            "WHERE p.post_id = '" . (int) $post_id . "' ".
                "AND pd.object_type = '". $this->post_type  ."' ".
                "AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

        if ($query->num_rows) {
            $data = $query->row;
            $data = array_merge($data, array('page_description' => $this->getDescriptions($post_id)));
            $data['keyword'] = $data['keyword'] . uniqid("-");
            $this->add($data);
        }
    }

    public function delete($id) {
        $shared_tables = array(
            'property',
            'description',
            'stat',
            'url_alias',
            'review',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$id ." ".
                "AND object_type = 'page'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "post_to_store WHERE post_id = '" . (int) $id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "post WHERE post_id = '" . (int) $id . "'");

        //TODO: check if delete children too is checked, and then delete children too xD
        $children = $this->db->query("SELECT * FROM " . DB_PREFIX . "post WHERE parent_id = '" . (int) $id . "'");
        if ($children->rows) {
            $this->db->query("UPDATE FROM " . DB_PREFIX . "post SET ".
                "parent_id = 0 ".
            "WHERE parent_id = ". (int)$id);
        }

        $this->cache->delete("page");
    }

    public function getStores($id) {
        $data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_store WHERE post_id = '" . (int) $id . "'");
        foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
        }
        return $data;
    }

    public function getCategories($parent_id = 0, $data = array()) {

        $sql = "SELECT *
            FROM " . DB_PREFIX . "post c
                LEFT JOIN " . DB_PREFIX . "post_description cd ON (c.post_id = cd.post_id)
            WHERE cd.language_id = '" . (int) $this->config->get('config_language_id') . "'
            AND post_type = 'page'
            AND parent_id = '" . (int) $parent_id . "'
             ORDER BY c.sort_order, cd.title ASC";

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getPath($post_id) {
        $query = $this->db->query("SELECT title, parent_id
        FROM " . DB_PREFIX . "post c
            LEFT JOIN " . DB_PREFIX . "post_description cd ON (c.post_id = cd.post_id)
        WHERE c.post_id = '" . (int) $post_id . "'
            AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "'
            AND post_type = 'page'
        ORDER BY c.sort_order, cd.title ASC");

        $post_info = $query->row;

        if ($post_info['parent_id']) {
            return $this->getPath($post_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $post_info['title'];
        } else {
            return $post_info['title'];
        }
    }

    public function getByID($id) {
        $result = $this->getAll(array(
            'post_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.pages";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "post t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.post_id = td.object_id) ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'td.title',
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
        $cache_prefix = "admin.pages.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.post_id = td.object_id) ";
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

        $criteria[] = " t.post_type = 'page' ";
        $criteria[] = " td.object_type = 'page' ";

        $data['post_id'] = !is_array($data['post_id']) && !empty($data['post_id']) ? array($data['post_id']) : $data['post_id'];
        $data['parent_id'] = !is_array($data['parent_id']) && (!empty($data['parent_id']) || $data['parent_id'] === 0) ? array($data['parent_id']) : $data['parent_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "post_to_store t2s ON (t.post_id = t2s.post_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['post_id']) && !empty($data['post_id'])) {
            $criteria[] = " t.post_id IN (" . implode(', ', $data['post_id']) . ") ";
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
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.post_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'page' ";
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
                $sql .= " GROUP BY t.post_id";
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
        return $this->__getDescriptions('page', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('page', $id, $data);
    }

    public function sortPage($data) {
        if (!is_array($data))
            return false;
        $pos = 1;
        foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "post SET sort_order = '" . (int) $pos . "' WHERE post_id = '" . (int) $id . "' AND post_type = 'page'");
            $pos++;
        }
        return true;
    }

    public function activate($id) {
        return $this->__activate('post', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('post', $id);
    }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('page', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('page', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('page', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('page', $id, $group);
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
