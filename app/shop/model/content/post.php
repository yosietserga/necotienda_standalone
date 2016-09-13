<?php
class ModelContentPost extends Model {
    /**
     * @param $object_type
     * El tipo de objeto o nombre de la tabla a la que siempre va hacer referencia
     * */
    private $object_type = 'post';

    public function getById($id) {
        $query = $this->db->query("SELECT DISTINCT *
        FROM " . DB_PREFIX . "post p 
        LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) 
        LEFT JOIN " . DB_PREFIX . "post_to_store p2s ON (p.post_id=p2s.post_id)
        WHERE p.post_id = '" . (int)$id . "' 
        AND post_type = 'post'
        AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND date_publish_start <= NOW()
        AND (date_publish_end >= NOW() OR date_publish_end = '0000-00-00 00:00:00')
        AND p.status = '1'
        AND p2s.store_id = '". (int)STORE_ID ."'");

        return $query->row;
    }

    public function getAll($data, $sort_data= null) {
        $cachedId = "all_posts_".
            (int)STORE_ID ."_".
            implode('_',$data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        if($cachedId !== mb_convert_encoding( mb_convert_encoding($cachedId, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
            $cachedId = mb_convert_encoding($cachedId, 'UTF-8', mb_detect_encoding($cachedId));
        $cachedId = htmlentities($cachedId, ENT_NOQUOTES, 'UTF-8');
        $cachedId = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $cachedId);
        $cachedId = html_entity_decode($cachedId, ENT_NOQUOTES, 'UTF-8');
        $cachedId = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $cachedId);
        $cachedId = strtolower( trim($cachedId, '-') );

        $cached = $this->cache->get($cachedId);
        if (!$cached) {
            $sql = "SELECT *, p.date_added AS created, p.image AS pimage ".
                "FROM " . DB_PREFIX . "post p ".
                "LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) ";


            if (!isset($sort_data)) {
                $sort_data = array(
                    'pd.title',
                    'p.sort_order',
                    'RAND()',
                    'date_publish_start',
                    'p.date_added'
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
        $cachedId = "all_posts_total".
            (int)STORE_ID ."_".
            implode('_',$data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        if($cachedId !== mb_convert_encoding( mb_convert_encoding($cachedId, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
            $cachedId = mb_convert_encoding($cachedId, 'UTF-8', mb_detect_encoding($cachedId));
        $cachedId = htmlentities($cachedId, ENT_NOQUOTES, 'UTF-8');
        $cachedId = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $cachedId);
        $cachedId = html_entity_decode($cachedId, ENT_NOQUOTES, 'UTF-8');
        $cachedId = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $cachedId);
        $cachedId = strtolower( trim($cachedId, '-') );

        $cached = $this->cache->get($cachedId);
        if (!$cached) {
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post p
            LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) ";

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

        $sql .= " LEFT JOIN " . DB_PREFIX . "post_to_store p2s ON (p.post_id = p2s.post_id) ";
        $sql .= " LEFT JOIN " . DB_PREFIX . "store s ON (s.store_id = p2s.store_id) ";

        $data['post_id'] = !is_array($data['post_id']) && !empty($data['post_id']) ? array($data['post_id']) : $data['post_id'];
        $data['category_id'] = !is_array($data['category_id']) && !empty($data['category_id']) ? array($data['category_id']) : $data['category_id'];

        if (!empty($data['language_id']) && is_numeric($data['language_id'])) {
            $criteria[] = " pd.language_id = '". intval($data['language_id']) ."' ";
        } else {
            $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
        }

        if (!empty($data['publish']) && is_numeric($data['publish'])) {
            $criteria[] = " p.publish = '". intval($data['publish']) ."' ";
        } else {
            $criteria[] = " p.publish = '1' ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " p.status = '". intval($data['status']) ."' ";
        } else {
            $criteria[] = " p.status = '1' ";
        }

        if (!empty($data['post_id'])) {
            $criteria[] = " p.post_id IN (" . implode(', ', $data['post_id']) . ") ";
        }

        if (!empty($data['post_type'])) {
            $criteria[] = " p.post_type = '" . $this->db->escape($data['post_type']) . "' ";
        } else {
            $criteria[] = " post_type = '{$this->object_type}' ";
        }

        if ($data['queries']) {
            $search =  $search2 = '';
            foreach ($data['queries'] as $key => $value) {
                if (empty($value)) continue;
                if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                    $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');

                $search .= " LCASE(pd.title) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";

                if (isset($data['search_in_description'])) {
                    $search2 .= " LCASE(pd.description) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
            }
            if (!empty($search)) {
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($search2)) {
                $criteria[] = " (". rtrim($search2,'OR') .")";
            }
        }

        if (!empty($data['category']) || !empty($data['category_id'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p.post_id = p2c.post_id) ";
        }

        if (!empty($data['category'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "post_category_description cd ON (cd.category_id = p2c.category_id) ";
            $criteria[] = " LCASE(cd.name) LIKE '%" . $this->db->escape(strtolower($data['category'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['category_id'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "post_category_to_store c2s ON (p2c.post_category_id = c2s.post_category_id) ";
            $criteria[] = " c2s.store_id = '" . (int) STORE_ID . "' ";
            $criteria[] = " p2c.post_category_id IN (" . implode(', ', $data['category_id']) . ") ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "post_property pp ON (p.post_id = pp.post_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
            }
        }

        if (!empty($data['zone'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "post_to_zone p2z ON (p.post_id = p2z.post_id) ";
            $sql .= " LEFT JOIN " . DB_PREFIX . "zone z ON (z.zone_id = p2z.zone_id) ";
            $criteria[] = " LCASE(z.name) LIKE '%" . $this->db->escape(strtolower($data['zone'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['author'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "customer cu ON (p.author_id = cu.customer_id) ";
            $search = '';
            $search .= " CONVERT(LCASE(CONCAT(cu.`firstname`,' ', cu.`lastname`,' ', cu.`company`)) USING utf8) LIKE '%" . $this->db->escape(strtolower($data['seller'])) . "%' OR";
            //$search .= " CONVERT(LCASE(cu.`lastname`) USING utf8) LIKE '%" . $this->db->escape(strtolower($data['seller'])) . "%' OR";
            //$search .= " CONVERT(LCASE(cu.`company`) USING utf8) LIKE '%" . $this->db->escape(strtolower($data['seller'])) . "%' OR";
            $criteria[] = " cu.status = '1' ";
            if (!empty($search)) {
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
        }

        if (!empty($data['store'])) {
            $criteria[] = " LCASE(s.name) = '" . $this->db->escape(strtolower($data['store'])) . "' collate utf8_general_ci ";
        }

        if (!empty($data['store_id']) && is_numeric($data['store_id'])) {
            $criteria[] = " p2s.store_id = '". intval($data['store_id']) ."' ";
        } elseif (!empty($data['store_id']) && is_array($data['store_id'])) {
            $criteria[] = " p2s.store_id IN ('" . implode("','", $data['store_id']) . "') ";
        } else {
            $criteria[] = " p2s.store_id = '". (int)STORE_ID ."' ";
        }

        if (!empty($data['related']) && !empty($data['post_id'])) {
            $search = '';

            $search .= " p.post_id IN ( " .
                "SELECT post_id FROM `" . DB_PREFIX . "post_to_category` WHERE post_category_id IN ( " .
                "SELECT post_category_id FROM `" . DB_PREFIX . "post_to_category` WHERE post_id IN (". implode(', ', $data['post_id']) .") "
                ." )) OR";

            foreach ($data['queries'] as $key => $value) {
                if (empty($value)) continue;
                if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                    $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                $search .= "  p.post_id IN ( ".
                    " SELECT post_id FROM `" . DB_PREFIX . "post_description` WHERE `post_id` IN (" .
                    " SELECT `post_id` FROM `" . DB_PREFIX . "post_description` WHERE LCASE(meta_keywords) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci".
                    " )) OR";
            }

            if (!empty($search)) {
                $criteria[] = " " . rtrim($search, 'OR') . " ";
                $criteria[] = " p.post_id NOT IN (". implode(', ', $data['post_id']) .") ";
                if ($data['limit'] > 12 || (int)$data['limit'] == 0) $data['limit'] = 12;
            }
        }

        if (!empty($data['date_publish_start']) || !empty($data['date_start'])) {
            $criteria[] = " p.date_publish_start <= '". $this->db->escape($data['date_publish_start']) ."' ";
        } else {
            $criteria[] = " p.date_publish_start <= NOW()";
        }

        if (!empty($data['date_publish_end']) || !empty($data['date_end'])) {
            $criteria[] = " p.date_publish_end >= '". $this->db->escape($data['date_publish_end']) ."' ";
        } else {
            $criteria[] = " p.date_publish_end = '0000-00-00 00:00:00' OR p.date_publish_end >= NOW()";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY p.post_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY p.date_publish_start";
                $sql .= ($data['order'] == 'ASC') ? " ASC" : " DESC";
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

    public function posts($data = array()) {
        return $this->getAll($data);

    }

    public function postsTotal($data = array()) {
        return $this->getAllTotal($data);
    }

    public function getRandomPost($data = array()) {
        $data['rand'] = mt_rand();
        $data['sort'] = 'RAND()';
        return $this->getAll($data);
    }

    public function getLatestPost($data = array()) {
        $data['sort'] = 'DESC';
        $data['sort'] = 'p.date_added';
        return $this->getAll($data);
    }

    public function getPostRelated($id, $data) {
        $data['post_id'] = $id;
        $data['related'] = true;
        return $this->getAll($data);
    }

    public function getAllByCategoryId($data) {
        return $this->getAll($data);
    }

    public function getTotalByCategoryId($data) {
        return $this->getAllTotal($data);
    }

    public function updateStats($id) {
        $this->load->library('browser');
        $browser = new Browser;
        $this->db->query("UPDATE " . DB_PREFIX . "post SET viewed = viewed + 1 WHERE post_id = '" . (int)$id . "'");
        $this->db->query("INSERT " . DB_PREFIX . "stat SET
        `object_id`     = '". (int)$id ."',
        `store_id`      = '". (int)STORE_ID ."',
        `customer_id`   = '". (int)$this->reseller->getId() ."',
        `object_type`   = 'post',
        `server`        = '". $this->db->escape(serialize($_SERVER)) ."',
        `session`       = '". $this->db->escape(serialize($_SESSION)) ."',
        `request`       = '". $this->db->escape(serialize($_REQUEST)) ."',
        `store_url`     = '". $this->db->escape($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) ."',
        `ref`           = '". $this->db->escape($_SERVER['HTTP_REFERER']) ."',
        `browser`       = '". $this->db->escape($browser->getBrowser()) ."',
        `browser_version`= '". $this->db->escape($browser->getVersion()) ."',
        `os`            = '". $this->db->escape($browser->getPlatform()) ."',
        `ip`            = '". $this->db->escape($_SERVER['REMOTE_ADDR']) ."',
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
    public function getProperty($id, $group, $key) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_property
        WHERE `post_id` = '" . (int)$id . "' 
        AND `group` = '". $this->db->escape($group) ."'
        AND `key` = '". $this->db->escape($key) ."'");

        return unserialize(str_replace("\'","'",$query->row['value']));
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
    public function getAllProperties($id, $group='*') {
        if ($group=='*') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_property
            WHERE `post_id` = '" . (int)$id . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_property
            WHERE `post_id` = '" . (int)$id . "' 
            AND `group` = '". $this->db->escape($group) ."'");
        }

        return $query->rows;
    }
}
