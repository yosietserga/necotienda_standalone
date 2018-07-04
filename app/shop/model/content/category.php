<?php

class ModelContentCategory extends Model
{
    public function getById($id)
    {
        $results = $this->getAll(array('post_category_id'=>$id));
        return $results[0];
    }

    public function getAll($data) {
        $cache_prefix = "shop.post_categories";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT DISTINCT *, pcd.name AS cname, pcd.description AS cdescription FROM " . DB_PREFIX . "post_category pc ".
                "LEFT JOIN " . DB_PREFIX . "post_category_description pcd ON (pc.post_category_id = pcd.post_category_id) ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'pc.sort_order',
                    'pcd.name',
                    'pc.viewed'
                );
            }

            $sql .= $this->buildSQLQuery($data, $sort_data);
            $query = $this->db->query($sql);
            $this->cache->set($cachedId, $query->rows, $cache_prefix);
            return $query->rows;
        } else {
            return $cached;
        }
    }

    public function getAllTotal($data) {
        $cache_prefix = "shop.post_categories.total";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_category pc ".
                "LEFT JOIN " . DB_PREFIX . "post_category_description pcd ON (pc.post_category_id = pcd.post_category_id) ";

            $sql .= $this->buildSQLQuery($data, null, true);

            $query = $this->db->query($sql);

            $this->cache->set($cachedId, $query->row['total'], $cache_prefix);

            return $query->row['total'];
        } else {
            return $cached;
        }
    }

    private function buildSQLQuery($data, $sort_data = null, $countAsTotal = false) {
        $criteria = array();
        $sql = "";

        $sql .= " LEFT JOIN " . DB_PREFIX . "post_category_to_store pc2s ON (pc.post_category_id = pc2s.post_category_id) ";

        $data['post_id'] = !is_array($data['post_id']) && !empty($data['post_id']) ? array($data['post_id']) : $data['post_id'];
        $data['post_category_id'] = !is_array($data['post_category_id']) && !empty($data['post_category_id']) ? array($data['post_category_id']) : $data['post_category_id'];
        $data['parent_id'] = !is_array($data['parent_id']) && (!empty($data['parent_id']) || $data['parent_id'] === 0) ? array($data['parent_id']) : $data['parent_id'];

        if (isset($data['post_category_id']) && !empty($data['post_category_id'])) {
            $criteria[] = " pc.post_category_id IN (" . implode(', ', $data['post_category_id']) . ") ";
        }

        if (isset($data['parent_id'])) {
            $criteria[] = " pc.parent_id IN (" . implode(', ', $data['parent_id']) . ") ";
        }

        if (!empty($data['language_id']) && is_numeric($data['language_id'])) {
            $criteria[] = " pcd.language_id = '". intval($data['language_id']) ."' ";
        } else {
            $criteria[] = " pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " pc.status = '". intval($data['status']) ."' ";
        } else {
            $criteria[] = " pc.status = '1' ";
        }

        if (isset($data['post_id']) && !empty($data['post_id'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p2c.post_category_id = pc.post_category_id) ";
            $sql .= " LEFT JOIN " . DB_PREFIX . "post p ON (p.post_id = p2c.post_id) ";
            //$sql .= " LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) ";
            $criteria[] = " p2c.post_id IN (" . implode(', ', $data['post_id']) . ") ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "post_category_property pcp ON (c.post_category_id = pcp.post_category_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(cp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(cp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
            }
        }

        if (!empty($data['store_id']) && is_numeric($data['store_id'])) {
            $criteria[] = " pc2s.store_id = '". intval($data['store_id']) ."' ";
        } elseif (!empty($data['store_id']) && is_array($data['store_id'])) {
            $criteria[] = " pc2s.store_id IN ('" . implode("','", $data['store_id']) . "') ";
        } else {
            $criteria[] = " pc2s.store_id = '". (int)STORE_ID ."' ";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY pc.post_category_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY pc.sort_order";
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

    public function updateStats($id)
    {
        $this->load->library('browser');
        $browser = new Browser;
        $this->db->query("UPDATE " . DB_PREFIX . "post SET viewed = viewed + 1 WHERE post_id = '" . (int)$id . "'");
        $this->db->query("INSERT " . DB_PREFIX . "stat SET 
        `object_id`     = '" . (int)$id . "',
        `store_id`      = '" . (int)STORE_ID . "',
        `customer_id`   = '" . (int)$this->customer->getId() . "',
        `object_type`   = 'post_category',
        `server`        = '" . $this->db->escape(serialize($_SERVER)) . "',
        `session`       = '" . $this->db->escape(serialize($_SESSION)) . "',
        `request`       = '" . $this->db->escape(serialize($_REQUEST)) . "',
        `store_url`     = '" . $this->db->escape($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']) . "',
        `ref`           = '" . $this->db->escape($_SERVER['HTTP_REFERER']) . "',
        `browser`       = '" . $this->db->escape($browser->getBrowser()) . "',
        `browser_version`= '" . $this->db->escape($browser->getVersion()) . "',
        `os`            = '" . $this->db->escape($browser->getPlatform()) . "',
        `ip`            = '" . $this->db->escape($_SERVER['REMOTE_ADDR']) . "',
        `date_added`    = NOW()");
    }

    /**
     * ModelContentPage::getProperty()
     *
     * Obtener una propiedad de la pagina
     *
     * @param int $id post_id
     * @param varchar $group
     * @param varchar $key
     * @return mixed value of property
     * */
    public function getProperty($id, $group, $key)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_category_property 
        WHERE `post_category_id` = '" . (int)$id . "' 
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");

        return unserialize(str_replace("\'", "'", $query->row['value']));
    }

    /**
     * ModelContentPage::getAllProperties()
     *
     * Obtiene todas las propiedades de la pagina
     *
     * Si quiere obtener todos los grupos de propiedades
     * utilice * como nombre del grupo, ejemplo:
     *
     * $properties = getAllProperties($post_id, '*');
     *
     * Sino coloque el nombre del grupo de las propiedades
     *
     * $properties = getAllProperties($post_id, 'NombreDelGrupo');
     *
     * @param int $id post_id
     * @param varchar $group
     * @return array all properties
     * */
    public function getAllProperties($id, $group = '*')
    {
        if ($group == '*') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_category_property 
            WHERE `post_category_id` = '" . (int)$id . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_category_property 
            WHERE `post_category_id` = '" . (int)$id . "' 
            AND `group` = '" . $this->db->escape($group) . "'");
        }

        return $query->rows;
    }
}
