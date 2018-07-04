<?php

/**
 * ModelContentPost
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelContentPost extends Model {

    public $post_type = 'post';
    
    public function add($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "post SET ".
            "parent_id   = '0', ".
            "post_type   = '". $this->post_type  ."', ".
            "publish     = '" . (int) $this->request->post['publish'] . "', ".
            "allow_reviews     = '" . (int) $this->request->post['allow_reviews'] . "',".
            "image = '" . $this->db->escape($data['image']) . "',".
            "date_publish_start = '" . $this->db->escape($data['date_publish_start']) . "',".
            "date_publish_end = '" . $this->db->escape($data['date_publish_end']) . "',".
            "template    = '" . $this->db->escape($data['template']) . "', ".
            "status      = '1', ".
            "date_added  = NOW()");

        $post_id = $this->db->getLastId();

        $this->setDescriptions($post_id, $data['post_description']);

        if (isset($data['post_category'])) {
            foreach ($data['post_category'] as $category_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET ".
                "post_id = '" . (int) $post_id . "', ".
                "post_category_id = '" . (int) $category_id . "'");
            }
        }

        if (!empty($data['stores'])) {
            foreach ($data['stores'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "post_to_store SET ".
                    "store_id  = '" . (int) $store_id . "', ".
                    "post_id = '" . (int) $post_id . "'");
            }
        }

        $this->cache->delete("post");
        return $post_id;
    }

    public function update($post_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "post SET ".
            "parent_id   = '0', ".
            "publish     = '" . (int) $this->request->post['publish'] . "',".
            "allow_reviews     = '" . (int) $this->request->post['allow_reviews'] . "',".
            "image = '" . $this->db->escape($data['image']) . "',".
            "date_publish_start = '" . $this->db->escape($data['date_publish_start']) . "', ".
            "date_publish_end = '" . $this->db->escape($data['date_publish_end']) . "', ".
            "template    = '" . $this->db->escape($data['template']) . "', ".
            "date_modified  = NOW() ".
            "WHERE post_id = '" . (int) $post_id . "'");

        $this->setDescriptions($post_id, $data['post_description']);

        $this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int) $post_id . "'");
        if (isset($data['post_category'])) {
            foreach ($data['post_category'] as $category_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET ".
                    "post_id = '" . (int) $post_id . "', ".
                    "post_category_id = '" . (int) $category_id . "'");
            }
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "post_to_store WHERE post_id = '" . (int) $post_id . "'");
        foreach ($data['stores'] as $store_id) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "post_to_store SET ". 
                    "store_id  = '" . (int) $store_id . "', ".
                    "post_id = '" . (int) $post_id . "'");
        }

        $this->cache->delete("post");
    }

    public function copy($post_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "post p ".
            "LEFT JOIN " . DB_PREFIX . "description pd ON (p.post_id = pd.object_id) ".
            "WHERE p.post_id = '" . (int) $post_id . "' ".
                "AND pd.object_type = '". $this->post_type  ."' ".
                "AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

        if ($query->num_rows) {
            $data = array();
            $data = $query->row;
            $data = array_merge($data, array('post_description' => $this->getDescriptions($post_id)));
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
                "AND object_type = '". $this->post_type  ."'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "post_to_store WHERE post_id = '" . (int) $id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int) $id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "post WHERE post_id = '" . (int) $id . "'");


        $this->cache->delete("post");
    }

    public function getStores($id) {
        $data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_store WHERE post_id = '" . (int) $id . "'");
        foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
        }
        return $data;
    }

    public function getSeoUrlRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "post` WHERE post_type = '". $this->post_type  ."' AND post_id NOT IN (SELECT `object_id` FROM `" . DB_PREFIX . "url_alias` WHERE `object_type` = '". $this->post_type  ."')");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "post`");
        return $query->row['total'] * 100 / $query2->row['total'];
    }
    
    public function getById($id) {
        $result = $this->getAll(array(
            'post_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.{$this->post_type}s";
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
        $cache_prefix = "admin.{$this->post_type}s.total";
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

        $criteria[] = " t.post_type = '". $this->post_type  ."' ";
        $criteria[] = " td.object_type = '". $this->post_type  ."' ";

        $data['post_id'] = !is_array($data['post_id']) && !empty($data['post_id']) ? array($data['post_id']) : $data['post_id'];
        $data['parent_id'] = !is_array($data['parent_id']) && (!empty($data['parent_id']) || $data['parent_id'] === 0) ? array($data['parent_id']) : $data['parent_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];
        $data['category_id'] = !is_array($data['category_id']) && !empty($data['category_id']) ? array($data['category_id']) : $data['category_id'];
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

        if (isset($data['category_id']) && !empty($data['category_id'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (t.post_id = p2c.post_id) ";
            //$sql .= " LEFT JOIN " . DB_PREFIX . "post_category pc ON (pc.category_id = p2c.category_id) ";
            $criteria[] = " p2c.category_id IN (" . implode(', ', $data['category_id']) . ") ";
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
                $criteria[] = " pp.object_type = '". $this->post_type  ."' ";
            }
        }

        if (!empty($data['publish_date_start'])) {
            $criteria[] = "date_publish_start <= '" . date('Y-m-d h:i:s', strtotime($data['publish_date_start'])) . "'";
        }

        if (!empty($data['publish_date_end'])) {
            $criteria[] = "date_publish_end >= '" . date('Y-m-d h:i:s', strtotime($data['publish_date_end'])) . "'";
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

    public function getCategories($post_id) {
        $category_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int) $post_id . "'");

        foreach ($query->rows as $result) {
            $category_data[] = $result['post_category_id'];
        }

        return $category_data;
    }

    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions($this->post_type, $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions($this->post_type, $id, $data);
    }

    public function sortPost($data) {
        if (!is_array($data))
            return false;
        $pos = 1;
        foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "post SET sort_order = '" . (int) $pos . "' WHERE post_id = '" . (int) $id . "'");
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
        return $this->__getProperty($this->post_type, $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty($this->post_type, $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties($this->post_type, $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties($this->post_type, $id, $group);
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