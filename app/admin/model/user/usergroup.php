<?php

class ModelUserUserGroup extends Model {

    public function add($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "user_group SET 
        name = '" . $this->db->escape($data['name']) . "', 
        permission = '" . (isset($data['permission']) ? serialize($data['permission']) : '') . "'");
        return $this->db->getLastId();
    }

    public function update($user_group_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "user_group SET 
        name = '" . $this->db->escape($data['name']) . "', 
        permission = '" . (isset($data['permission']) ? serialize($data['permission']) : '') . "' 
        WHERE user_group_id = '" . (int) $user_group_id . "'");
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
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int) $id . "'");

        if ($query->num_rows) {
            $data = array();
            $data = $query->row;
            $data['name'] = $data['name'] . " - copia";
            $this->add($data);
        }
    }

    public function delete($user_group_id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$user_group_id ." ".
                "AND object_type = 'user_group'");
        }

        $this->db->query("UPDATE " . DB_PREFIX . "user SET user_group_id = 0 WHERE user_group_id = '" . (int) $user_group_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int) $user_group_id . "'");
    }

    public function addPermission($user_id, $type, $page) {
        $user_query = $this->db->query("SELECT DISTINCT user_group_id FROM " . DB_PREFIX . "user WHERE user_id = '" . (int) $user_id . "'");

        if ($user_query->num_rows) {
            $user_group_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int) $user_query->row['user_group_id'] . "'");

            if ($user_group_query->num_rows) {
                $data = unserialize($user_group_query->row['permission']);

                $data[$type][] = $page;

                $this->db->query("UPDATE " . DB_PREFIX . "user_group SET permission = '" . serialize($data) . "' WHERE user_group_id = '" . (int) $user_query->row['user_group_id'] . "'");
            }
        }
    }

    public function getById($id) {
        $result = $this->getAll(array(
            'user_group_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.user_groups";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "user_group t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'name',
                    't.status',
                    't.date_added'
                );
            }
            $sql .= $this->buildSQLQuery($data, $sort_data);
            $query = $this->db->query($sql);
            $return = array();
            foreach ($query->rows as $row) {
                $row['permission'] = unserialize($row['permission']);
                $return[] = $row;
            }
            $this->cache->set($cachedId, $return);
            return $return;
        } else {
            return $cached;
        }
    }

    public function getAllTotal($data=null) {
        $cache_prefix = "admin.user_groups.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user_group t ";
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

        $data['user_group_id'] = !is_array($data['user_group_id']) && !empty($data['user_group_id']) ? array($data['user_group_id']) : $data['user_group_id'];

        if (isset($data['user_group_id']) && !empty($data['user_group_id'])) {
            $criteria[] = " t.user_group_id IN (" . implode(', ', $data['user_group_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.user_group_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'user_group' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.user_group_id";
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
        return $this->__activate('user_group', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('user_group', $id);
    }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('user_group', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('user_group', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('user_group', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('user_group', $id, $group);
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
