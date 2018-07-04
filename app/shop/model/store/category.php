<?php

class ModelStoreCategory extends Model {

    public function getCategory($category_id) {
        $results = $this->getAll(array('category_id'=>$category_id));
        return $results[0];
    }

    public function getCategories($parent_id = 0) {
        return $this->getAll(array('parent_id'=>$parent_id));
    }

    public function getTotalCategoriesByCategoryId($parent_id = 0) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c 
        LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
        WHERE c.parent_id = '" . (int) $parent_id . "' 
        AND c2s.store_id = '" . (int) STORE_ID . "' 
        AND c.status = '1'");
        return $query->row['total'];
    }

    public function getAll($data) {
            $cache_prefix = "shop.categories";
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
            $sql = "SELECT DISTINCT *, cd.name AS cname, cd.description AS cdescription, c.image AS cimage FROM " . DB_PREFIX . "category c ".
                "LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'c.sort_order',
                    'cd.name',
                    'c.viewed'
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

    public function getAllTotal($data) {
            $cache_prefix = "shop.categories.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c ".
                "LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) ";

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

        $sql .= " LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) ";

        $data['product_id'] = !is_array($data['product_id']) && !empty($data['product_id']) ? array($data['product_id']) : $data['product_id'];
        $data['category_id'] = !is_array($data['category_id']) && !empty($data['category_id']) ? array($data['category_id']) : $data['category_id'];
        $data['manufacturer_id'] = !is_array($data['manufacturer_id']) && !empty($data['manufacturer_id']) ? array($data['manufacturer_id']) : $data['manufacturer_id'];
        $data['parent_id'] = !is_array($data['parent_id']) && (!empty($data['parent_id']) || $data['parent_id'] === 0) ? array($data['parent_id']) : $data['parent_id'];

        if (isset($data['category_id']) && !empty($data['category_id'])) {
            $criteria[] = " c.category_id IN (" . implode(', ', $data['category_id']) . ") ";
        }

        if (isset($data['parent_id'])) {
            $criteria[] = " c.parent_id IN (" . implode(', ', $data['parent_id']) . ") ";
        }

        if (!empty($data['language_id']) && is_numeric($data['language_id'])) {
            $criteria[] = " cd.language_id = '". intval($data['language_id']) ."' ";
        } else {
            $criteria[] = " cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " c.status = '". intval($data['status']) ."' ";
        } else {
            $criteria[] = " c.status = '1' ";
        }

        if (!empty($data['manufacturer_id']) || !empty($data['product_id'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.category_id = c.category_id) ";
            $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = p2c.product_id) ";
            //$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) ";
        }

        if (!empty($data['product_id'])) {
            $criteria[] = " p2c.product_id IN (" . implode(', ', $data['product_id']) . ") ";
        }

        if (!empty($data['manufacturer_id'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) ";
            $criteria[] = " m.manufacturer_id IN (" . implode(', ', $data['manufacturer_id']) . ") ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "category_property cp ON (c.category_id = cp.category_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(cp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(cp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
            }
        }

        if (!empty($data['store_id']) && is_numeric($data['store_id'])) {
            $criteria[] = " c2s.store_id = '". intval($data['store_id']) ."' ";
        } elseif (!empty($data['store_id']) && is_array($data['store_id'])) {
            $criteria[] = " c2s.store_id IN ('" . implode("','", $data['store_id']) . "') ";
        } else {
            $criteria[] = " c2s.store_id = '". (int)STORE_ID ."' ";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY c.category_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY c.sort_order";
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

    public function updateStats($category_id, $customer_id) {
        $this->load->library('browser');
        $browser = new Browser;
        $this->db->query("UPDATE " . DB_PREFIX . "category SET viewed = viewed + 1 WHERE category_id = '" . (int) $category_id . "'");
        $this->db->query("INSERT " . DB_PREFIX . "stat SET 
        `object_id`     = '" . (int) $category_id . "',
        `store_id`      = '" . (int) STORE_ID . "',
        `customer_id`   = '" . (int) $customer_id . "',
        `object_type`   = 'category',
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
     * ModelStoreCategory::getProperty()
     *
     * Obtener una propiedad de la categoria
     *
     * @param int $id category_id
     * @param varchar $group
     * @param varchar $key
     * @return mixed value of property
     * */
    public function getProperty($id, $group, $key) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_property 
        WHERE `category_id` = '" . (int) $id . "' 
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");

        return unserialize(str_replace("\'", "'", $query->row['value']));
    }

    /**
     * ModelStoreCategory::getAllProperties()
     *
     * Obtiene todas las propiedades de la categoria
     *
     * Si quiere obtener todos los grupos de propiedades
     * utilice * como nombre del grupo, ejemplo:
     *
     * $properties = getAllProperties($category_id, '*');
     *
     * Sino coloque el nombre del grupo de las propiedades
     *
     * $properties = getAllProperties($category_id, 'NombreDelGrupo');
     *
     * @param int $id category_id
     * @param varchar $group
     * @return array all properties
     * */
    public function getAllProperties($id, $group = '*') {
        if ($group == '*') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_property 
            WHERE `category_id` = '" . (int) $id . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_property 
            WHERE `category_id` = '" . (int) $id . "' 
            AND `group` = '" . $this->db->escape($group) . "'");
        }

        return $query->rows;
    }

}
