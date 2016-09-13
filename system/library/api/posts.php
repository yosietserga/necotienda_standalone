<?php

class PostsApi {
    /**
     * @param $object_type
     * El tipo de objeto o nombre de la tabla a la que siempre va hacer referencia
     * */
	private $object_type = 'post';

    private $db;
    private $cache;
    private $resgistry;
    private $data = array();
    private $result = array();
    
    

    //TODO: construir un mapa de todas las funciones llamables a trav�s de ajax
  	public function __construct($registry) {
        $this->registry = $registry;
        $this->cache = $this->registry->get('cache');
        $this->request = $this->registry->get('request');
        $this->config = $this->registry->get('config');
        $this->db = $this->registry->get('db');
  	}
    
    public function __get($key) {
        return $this->data[$key];
    }
    
    public function __set($key,$value) {
        $this->data[$key] = $value;
    }

    public function categories($data = array()) {
        $cacheId = 'api.posts.categories.all.'.
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->config->get('config_currency') . "." .
            $this->config->get('config_store_id').
            serialize($data);

        $cached = $this->cache->get($cacheId);

        if (!$cached) {

            $sql = "SELECT * ".
                "FROM " . DB_PREFIX . "post_category p ".
                "LEFT JOIN " . DB_PREFIX . "post_category_description pd ON (p.post_category_id = pd.post_category_id) ".
                "LEFT JOIN " . DB_PREFIX . "post_category_to_store p2s ON (p.post_category_id=p2s.post_category_id)";

            $criteria = array();
            $criteria[] = " p.status = '1' ";

            if (!empty($data['id']) && is_numeric($data['id'])) {
                $criteria[] = " p.post_category_id = '" . intval($data['id']) . "' ";
            } elseif (!empty($data['id']) && is_array($data['id'])) {
                $criteria[] = " p.post_category_id IN ('" . implode("','", $data['id']) . "') ";
            }

            if (!empty($data['store_id']) && is_numeric($data['store_id'])) {
                $criteria[] = " p2s.store_id = '". intval($data['store_id']) ."' ";
            } elseif (!empty($data['store_id']) && is_array($data['store_id'])) {
                $criteria[] = " p2s.store_id IN ('" . implode("','", $data['store_id']) . "') ";
            } else {
                $criteria[] = " p2s.store_id = '". (int)STORE_ID ."' ";
            }

            if (!empty($data['language_id']) && is_numeric($data['language_id'])) {
                $criteria[] = " pd.language_id = '". intval($data['language_id']) ."' ";
            } else {
                $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
            }

            if (!empty($data['parent_id'])) {
                $criteria[] = "p.parent_id = '" . (int) $data['parent_id'] . "'";
            } else {
                $criteria[] = "p.parent_id = '0'";
            }

            if (!empty($data['name'])) {
                $criteria[] = " LCASE(pd.name) LIKE '%" . $this->db->escape($data['name']) . "%' ";
            }

            if (!empty($data['name']) && isset($data['search_in_description'])) {
                $criteria[] = " LCASE(pd.description) LIKE '%" . $this->db->escape($data['name']) . "%' ";
            }

            if (!empty($data['date_start']) && !empty($data['date_end'])) {
                $criteria[] = "p.date_added BETWEEN '" . date('Y-m-d h:i:s', strtotime($data['date_start'])) . "' AND '" . date('Y-m-d h:i:s', strtotime($data['date_end'])) . "'";
            } elseif (!empty($data['date_start'])) {
                $criteria[] = "p.date_added BETWEEN '" . date('Y-m-d h:i:s', strtotime($data['date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }

            $sort_data = array(
                'pd.name',
                'date_added'
            );

            if (in_array($data['sort'], $sort_data)) {
                $sql .=  ($data['sort'] == 'pd.name') ? " ORDER BY LCASE(" . $data['sort'] . ")" : " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY pd.name ";
            }

            if ($data['start'] < 0) $data['start'] = 0;
            if ($data['limit'] <= 0) $data['limit'] = 25;

            $sql .= ($data['order'] == 'ASC') ? " ASC" : " DESC";
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];

            $query = $this->db->query($sql);
            $this->cache->set($cacheId, $query->rows);
            return $query->rows;
        } else {
            return $cached;
        }
    }

    public function categoriesTotal($data = array()) {
        $cacheId = 'api.posts.categories.all.'.
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->config->get('config_currency') . "." .
            $this->config->get('config_store_id').
            serialize($data);

        $cached = $this->cache->get($cacheId);

        if (!$cached) {

            $sql = "SELECT COUNT(*) AS total ".
                "FROM " . DB_PREFIX . "post_category p ".
                "LEFT JOIN " . DB_PREFIX . "post_category_description pd ON (p.post_category_id = pd.post_category_id) ".
                "LEFT JOIN " . DB_PREFIX . "post_category_to_store p2s ON (p.post_category_id=p2s.post_category_id)";

            $criteria = array();
            $criteria[] = " p.status = '1' ";

            if (!empty($data['id']) && is_numeric($data['id'])) {
                $criteria[] = " p.post_category_id = '" . intval($data['id']) . "' ";
            } elseif (!empty($data['id']) && is_array($data['id'])) {
                $criteria[] = " p.post_category_id IN ('" . implode("','", $data['id']) . "') ";
            }

            if (!empty($data['store_id']) && is_numeric($data['store_id'])) {
                $criteria[] = " p2s.store_id = '". intval($data['store_id']) ."' ";
            } elseif (!empty($data['store_id']) && is_array($data['store_id'])) {
                $criteria[] = " p2s.store_id IN ('" . implode("','", $data['store_id']) . "') ";
            } else {
                $criteria[] = " p2s.store_id = '". (int)STORE_ID ."' ";
            }

            if (!empty($data['language_id']) && is_numeric($data['language_id'])) {
                $criteria[] = " pd.language_id = '". intval($data['language_id']) ."' ";
            } else {
                $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
            }

            if (!empty($data['parent_id'])) {
                $criteria[] = "p.parent_id = '" . (int) $data['parent_id'] . "'";
            } else {
                $criteria[] = "p.parent_id = '0'";
            }

            if (!empty($data['name'])) {
                $criteria[] = " LCASE(pd.name) LIKE '%" . $this->db->escape($data['name']) . "%' ";
            }

            if (!empty($data['name']) && isset($data['search_in_description'])) {
                $criteria[] = " LCASE(pd.description) LIKE '%" . $this->db->escape($data['name']) . "%' ";
            }

            if (!empty($data['date_start']) && !empty($data['date_end'])) {
                $criteria[] = "p.date_added BETWEEN '" . date('Y-m-d h:i:s', strtotime($data['date_start'])) . "' AND '" . date('Y-m-d h:i:s', strtotime($data['date_end'])) . "'";
            } elseif (!empty($data['date_start'])) {
                $criteria[] = "p.date_added BETWEEN '" . date('Y-m-d h:i:s', strtotime($data['date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }

            $query = $this->db->query($sql);
            $this->cache->set($cacheId, $query->row['total']);
            return $query->row['total'];
        } else {
            return $cached;
        }
    }

    public function posts($data = array()) {
        $cacheId = 'api.posts.all.'.
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->config->get('config_currency') . "." .
            $this->config->get('config_store_id').
            serialize($data);

        $cached = $this->cache->get($cacheId);

        if (!$cached) {

            $sql = "SELECT * ".
                "FROM " . DB_PREFIX . "post p ".
                "LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) ".
                "LEFT JOIN " . DB_PREFIX . "post_to_store p2s ON (p.post_id=p2s.post_id)";

            $criteria = array();
            $criteria[] = " post_type = '{$this->object_type}' ";
            $criteria[] = " p.status = '1' ";

            if (!empty($data['id']) && is_numeric($data['id'])) {
                $criteria[] = " p.post_id = '" . intval($data['id']) . "' ";
            } elseif (!empty($data['id']) && is_array($data['id'])) {
                $criteria[] = " p.post_id IN ('" . implode("','", $data['id']) . "') ";
            }

            if (!empty($data['store_id']) && is_numeric($data['store_id'])) {
                $criteria[] = " p2s.store_id = '". intval($data['store_id']) ."' ";
            } elseif (!empty($data['store_id']) && is_array($data['store_id'])) {
                $criteria[] = " p2s.store_id IN ('" . implode("','", $data['store_id']) . "') ";
            } else {
                $criteria[] = " p2s.store_id = '". (int)STORE_ID ."' ";
            }

            if (!empty($data['language_id']) && is_numeric($data['language_id'])) {
                $criteria[] = " pd.language_id = '". intval($data['language_id']) ."' ";
            } else {
                $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
            }

            if (!empty($data['name'])) {
                $criteria[] = " LCASE(pd.title) LIKE '%" . $this->db->escape($data['name']) . "%' ";
            }

            if (!empty($data['name']) && isset($data['search_in_description'])) {
                $criteria[] = " LCASE(pd.description) LIKE '%" . $this->db->escape($data['name']) . "%' ";
            }

            if (!empty($data['category_id'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p.post_id = p2c.post_id) ";
                $criteria[] = " p2c.post_category_id = '" . (int)$data['category_id'] . "' ";
            }

            if (!empty($data['date_start'])) {
                $criteria[] = " date_publish_start <= '" . date('Y-m-d h:i:s', strtotime($data['date_start'])) . "' ";
            } else {
                $criteria[] = " date_publish_start <= NOW() ";
            }

            if (!empty($data['date_end'])) {
                $criteria[] = " (date_publish_end >= '" . date('Y-m-d h:i:s', strtotime($data['date_end'])) . "' OR date_publish_end = '0000-00-00 00:00:00') ";
            } else {
                $criteria[] = " (date_publish_end >= NOW() OR date_publish_end = '0000-00-00 00:00:00') ";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }

            $sort_data = array(
                'pd.title',
                'p.sort_order',
                'date_publish_start'
            );

            if (in_array($data['sort'], $sort_data)) {
                $sql .=  ($data['sort'] == 'pd.title') ? " ORDER BY LCASE(" . $data['sort'] . ")" : " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY p.date_publish_start ";
            }

            if ($data['start'] < 0) $data['start'] = 0;
            if ($data['limit'] <= 0) $data['limit'] = 25;

            $sql .= ($data['order'] == 'ASC') ? " ASC" : " DESC";
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];

            $query = $this->db->query($sql);
            $this->cache->set($cacheId, $query->rows);
            return $query->rows;
        } else {
            return $cached;
        }
    }

    public function postsTotal($data = array()) {
        $cacheId = 'api.posts.allTotal.'.
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->config->get('config_currency') . "." .
            $this->config->get('config_store_id').
            serialize($data);

        $cached = $this->cache->get($cacheId);

        if (!$cached) {
            $sql = "SELECT COUNT(*) AS total ".
                "FROM " . DB_PREFIX . "post p ".
                "LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) ".
                "LEFT JOIN " . DB_PREFIX . "post_to_store p2s ON (p.post_id=p2s.post_id)";

            $criteria = array();
            $criteria[] = " post_type = '{$this->object_type}' ";
            $criteria[] = " p.status = '1' ";

            if (!empty($data['id']) && is_numeric($data['id'])) {
                $criteria[] = " p.post_id = '" . intval($data['id']) . "' ";
            } elseif (!empty($data['id']) && is_array($data['id'])) {
                $criteria[] = " p.post_id IN ('" . implode("','", $data['id']) . "') ";
            }

            if (!empty($data['store_id']) && is_numeric($data['store_id'])) {
                $criteria[] = " p2s.store_id = '". intval($data['store_id']) ."' ";
            } elseif (!empty($data['store_id']) && is_array($data['store_id'])) {
                $criteria[] = " p2s.store_id IN ('" . implode("','", $data['store_id']) . "') ";
            } else {
                $criteria[] = " p2s.store_id = '". (int)STORE_ID ."' ";
            }

            if (!empty($data['language_id']) && is_numeric($data['language_id'])) {
                $criteria[] = " pd.language_id = '". intval($data['language_id']) ."' ";
            } else {
                $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
            }

            if (!empty($data['name'])) {
                $criteria[] = " LCASE(pd.title) LIKE '%" . $this->db->escape($data['name']) . "%' ";
            }

            if (!empty($data['name']) && isset($data['search_in_description'])) {
                $criteria[] = " LCASE(pd.description) LIKE '%" . $this->db->escape($data['name']) . "%' ";
            }

            if (!empty($data['category_id'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p.post_id = p2c.post_id) ";
                $criteria[] = " p2c.post_category_id = '" . (int)$data['category_id'] . "' ";
            }

            if (!empty($data['date_start'])) {
                $criteria[] = " date_publish_start <= '" . date('Y-m-d h:i:s', strtotime($data['date_start'])) . "' ";
            } else {
                $criteria[] = " date_publish_start <= NOW() ";
            }

            if (!empty($data['date_end'])) {
                $criteria[] = " (date_publish_end >= '" . date('Y-m-d h:i:s', strtotime($data['date_end'])) . "' OR date_publish_end = '0000-00-00 00:00:00') ";
            } else {
                $criteria[] = " (date_publish_end >= NOW() OR date_publish_end = '0000-00-00 00:00:00') ";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }

            $query = $this->db->query($sql);
            $this->cache->set($cacheId, $query->row['total']);
            return $query->row['total'];
        } else {
            return $cached;
        }
    }

    public function recommended($data = array()) {
        $data['id'] = $this->getProperty(0, 'post', 'recommended');
        return $this->posts($data);
    }

    public function featured($data = array()) {
        $data['id'] = $this->getProperty(0, 'post', 'featured');
        return $this->posts($data);
    }

    public function related($data = array()) {
        $data['id'] = $this->getProperty(0, 'post', 'featured');
        return $this->posts($data);
    }

    public function visited($data = array()) {
        $data['id'] = $this->getProperty(0, 'post', 'featured');
        return $this->posts($data);
    }

    public function latest($data = array()) {
        $data['id'] = $this->getProperty(0, 'post', 'featured');
        return $this->posts($data);
    }

    public function smart($data = array()) {
        $data['id'] = $this->getProperty(0, 'post', 'featured');
        return $this->posts($data);
    }

    public function searched($data = array()) {
        $data['id'] = $this->getProperty(0, 'post', 'featured');
        return $this->posts($data);
    }

    public function popular($data = array()) {
        $data['id'] = $this->getProperty(0, 'post', 'featured');
        return $this->posts($data);
    }

    /**
     * PostsApi::getProperty()
     *
     * Obtener una propiedad de la pagina
     *
     * @param int $id object_id
     * @param varchar $group
     * @param varchar $key
     * @return mixed value of property
     * */
    public function getProperty($id, $group, $key) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "property ".
        "WHERE `object_id` = '" . (int) $id . "' ".
        "AND `object_type` = '" . $this->object_type . "' ".
        "AND `group` = '" . $this->db->escape($group) . "' ".
        "AND `key` = '" . $this->db->escape($key) . "'");

        return unserialize(str_replace("\'", "'", $query->row['value']));
    }

    /**
     * PostsApi::getAllProperties()
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
    public function getAllProperties($id, $group = '*') {
        if ($group == '*') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_property
            WHERE `post_id` = '" . (int) $id . "' AND `object_type` = '" . $this->object_type . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_property
            WHERE `post_id` = '" . (int) $id . "'
            AND `group` = '" . $this->db->escape($group) . "' AND `object_type` = '" . $this->object_type . "'");
        }

        return $query->rows;
    }
}
