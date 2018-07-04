<?php

class ModelStoreManufacturer extends Model
{
    public function getManufacturer($manufacturer_id)
    {
        $results = $this->getAll(array('manufacturer_id' => $manufacturer_id));
        return $results[0];
    }

    public function getManufacturers($data = array())
    {
        return $this->getAll($data);
    }

    public function getAll($data) {
            $cache_prefix = "shop.manufacturers";
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
            $sql = "SELECT DISTINCT *, m.name AS mname, m.image AS mimage FROM " . DB_PREFIX . "manufacturer m ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'm.sort_order',
                    'm.name',
                    'm.viewed'
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
            $cache_prefix = "shop.manufacturers.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturer m ";

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

        $sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) ";

        $data['manufacturer_id'] = !is_array($data['manufacturer_id']) && !empty($data['manufacturer_id']) ? array($data['manufacturer_id']) : $data['manufacturer_id'];
        $data['product_id'] = !is_array($data['product_id']) && !empty($data['product_id']) ? array($data['product_id']) : $data['product_id'];
        $data['category_id'] = !is_array($data['category_id']) && !empty($data['category_id']) ? array($data['category_id']) : $data['category_id'];

        if (isset($data['manufacturer_id']) && !empty($data['manufacturer_id'])) {
            $criteria[] = " m.manufacturer_id IN (" . implode(', ', $data['manufacturer_id']) . ") ";
        }

        if (!empty($data['category_id']) || !empty($data['product_id'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p.manufacturer_id = m.manufacturer_id) ";
        }

        if (!empty($data['category_id'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id = p.product_id) ";
            $sql .= " LEFT JOIN " . DB_PREFIX . "category c ON (p2c.category_id = c.category_id) ";
            $criteria[] = " c.category_id IN (" . implode(', ', $data['category_id']) . ") ";
        }

        if (!empty($data['product_id'])) {
            $criteria[] = " p.product_id IN (" . implode(', ', $data['product_id']) . ") ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer_property mp ON (m.manufacturer_id = mp.manufacturer_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(cp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(cp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
            }
        }

        if (!empty($data['store_id']) && is_numeric($data['store_id'])) {
            $criteria[] = " m2s.store_id = '". intval($data['store_id']) ."' ";
        } elseif (!empty($data['store_id']) && is_array($data['store_id'])) {
            $criteria[] = " m2s.store_id IN ('" . implode("','", $data['store_id']) . "') ";
        } else {
            $criteria[] = " m2s.store_id = '". (int)STORE_ID ."' ";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY m.manufacturer_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY m.sort_order";
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

    public function updateStats($manufacturer_id, $customer_id)
    {
        $this->load->library('browser');
        $browser = new Browser;
        $this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET viewed = viewed + 1 WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
        $this->db->query("INSERT " . DB_PREFIX . "stat SET 
        `object_id`     = '" . (int)$manufacturer_id . "',
        `store_id`      = '" . (int)STORE_ID . "',
        `customer_id`   = '" . (int)$customer_id . "',
        `object_type`   = 'manufacturer',
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
     * ModelStoreManufacturer::getProperty()
     *
     * Obtener una propiedad de la pagina
     *
     * @param int $id manufacturer_id
     * @param varchar $group
     * @param varchar $key
     * @return mixed value of property
     * */
    public function getProperty($id, $group, $key)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_property 
        WHERE `manufacturer_id` = '" . (int)$id . "' 
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");

        return unserialize(str_replace("\'", "'", $query->row['value']));
    }

    /**
     * ModelStoreManufacturer::getAllProperties()
     *
     * Obtiene todas las propiedades de la pagina
     *
     * Si quiere obtener todos los grupos de propiedades
     * utilice * como nombre del grupo, ejemplo:
     *
     * $properties = getAllProperties($manufacturer_id, '*');
     *
     * Sino coloque el nombre del grupo de las propiedades
     *
     * $properties = getAllProperties($manufacturer_id, 'NombreDelGrupo');
     *
     * @param int $id manufacturer_id
     * @param varchar $group
     * @return array all properties
     * */
    public function getAllProperties($id, $group = '*')
    {
        if ($group == '*') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_property 
            WHERE `manufacturer_id` = '" . (int)$id . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_property 
            WHERE `manufacturer_id` = '" . (int)$id . "' 
            AND `group` = '" . $this->db->escape($group) . "'");
        }

        return $query->rows;
    }
}
