<?php
/**
 * ModelStyleTheme
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelStyleTheme extends Model {
	/**
	 * ModelStyleTheme::add()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void 
	 */
	public function add($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "theme SET ".
          "template_id   = '" . intval($data['template_id']) . "', ".
          "user_id       = '" . intval($data['user_id']) . "', ".
          "store_id      = '" . intval($data['store_id']) . "',".
          "name          = '" . $this->db->escape($data['name']) . "', ".
          "template      = '" . $this->db->escape($data['template']) . "', ".
          "date_publish_start = '" . $this->db->escape($data['date_publish_start']) . "', ".
          "date_publish_end = '" . $this->db->escape($data['date_publish_end']) . "', ".
          "`default`      = '" . intval($data['default']) . "',".
          "status        = '1', ".
          "sort_order    = '0', ".
          "date_added    = NOW()");
          
		$theme_id = $this->db->getLastId();

		if (!empty($data['stores'])) {
            foreach ($data['stores'] as $store) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "theme_to_store SET 
                store_id  = '". intval($store['store_id']) ."', 
                theme_id = '". intval($theme_id) ."'");
            }
        }
        
        foreach ($data['style'] as $k => $value) {
            if ($value == 0) continue;
            $value['theme_id'] = $theme_id;
            $this->setStyle($value);
        }

		$this->cache->delete('theme');
        
        return $theme_id;
	}
	
	public function update($theme_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "theme SET ".
          "template_id   = '" . intval($data['template_id']) . "', ".
          "user_id       = '" . intval($data['user_id']) . "', ".
          "store_id      = '" . intval($data['store_id']) . "',".
          "name          = '" . $this->db->escape($data['name']) . "', ".
          "template      = '" . $this->db->escape($data['template']) . "', ".
          "date_publish_start = '" . $this->db->escape($data['date_publish_start']) . "', ".
          "date_publish_end = '" . $this->db->escape($data['date_publish_end']) . "', ".
          "`default`      = '" . intval($data['default']) . "',".
          "status        = '1', ".
          "sort_order    = '0', ".
          "date_modified    = NOW() ".
          "WHERE theme_id = '" . intval($theme_id) . "' ");
          
		if (!empty($data['stores'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "theme_to_store WHERE theme_id = '". (int)$theme_id ."'");
            foreach ($data['stores'] as $store) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "theme_to_store SET 
                store_id  = '". intval($store['store_id']) ."', 
                theme_id = '". intval($theme_id) ."'");
            }
        }
        
        $this->deleteStyle($theme_id);
        foreach ($data['style'] as $k => $value) {
            if ($value == 0) continue;
            $value['theme_id'] = $theme_id;
            $this->setStyle($value);
        }
        
		$this->cache->delete('theme');
        return $theme_id;
	}
	
	public function setStyle($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "theme_style SET ".
	        "`theme_id`    = '" . intval($data['theme_id']) . "',".
	        "`selector`    = '" . $this->db->escape($data['selector']) . "', ".
	        "`property`    = '" . $this->db->escape($data['property']) . "', ".
	        "`value`       = '" . $this->db->escape($data['value']) . "'");

		return $this->db->getLastId();
	}

	public function deleteStyle($theme_id) {
        $this->db->query("DELETE " . DB_PREFIX . "theme_style WHERE theme_id = '" . intval($theme_id) . "'");
	}

	public function saveStyle($theme_id, $data) {
	   if (!$theme_id && empty($data)) return false;

        $this->deleteStyle($theme_id);

       $sql = "INSERT INTO " . DB_PREFIX . "theme_style (theme_id, selector, `property`, `value`) VALUES ";
        foreach ($data as $selector => $properties) {
            foreach ($properties as $property => $value) {
                if (empty($value)) continue;
                $sql .= "(". (int)$theme_id .",'". $this->db->escape($selector) ."','". $this->db->escape($property) ."','". $this->db->escape($value) ."'),";
            }
        }
        $sql = substr($sql,0,strlen($sql) - 1);
        $this->db->query($sql);
	}
	
	public function copy($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "theme WHERE theme_id = '" . (int)$id . "'");
		
		if ($query->num_rows) {
			$data = array();
			$data = $query->row;
			$data['name'] = $data['name'] ." - copia";
			$data = array_merge($data, array('style' => $this->getStyles($id)));
			$this->add($data);
		}
	}
	
	public function delete($theme_id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$theme_id ." ".
                "AND object_type = 'theme'");
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "theme WHERE theme_id = '" . (int)$theme_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "theme_to_store WHERE theme_id = '" . (int)$theme_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "theme_style WHERE theme_id = '" . (int)$theme_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `key` = 'theme_default_id'");
		$this->cache->delete('theme');
	}	
	
	public function getStores($id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "theme_to_store WHERE theme_id = '" . (int)$id . "'");
		foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
		}
		return $data;
	}	
	
	public function ntSort($data) {
	   if (!is_array($data)) return false;
       $pos = 1;
       foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "theme SET sort_order = '" . (int)$pos . "' WHERE theme_id = '" . (int)$id . "'");
            $pos++;
       }
	   return true;
	}
	
    public function getById($id) {
        $result = $this->getAll(array(
            'theme_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.themes";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "theme t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.name',
                    't.date_added'
                );
            }
            $sql .= $this->buildSQLQuery($data, $sort_data);
            $query = $this->db->query($sql);
            $return = array();
            foreach ($query->rows as $row) {
            	$row['styles'] = $this->getAllStyles($data, $sort_data);
            	$return[] = $row;
            }
            $this->cache->set($cachedId, $return);
            return $return;
        } else {
            return $cached;
        }
    }

    public function getAllTotal($data=null) {
        $cache_prefix = "admin.themes.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "theme t ";
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

        $data['theme_id'] = !is_array($data['theme_id']) && !empty($data['theme_id']) ? array($data['theme_id']) : $data['theme_id'];
        $data['template_id'] = !is_array($data['template_id']) && !empty($data['template_id']) ? array($data['template_id']) : $data['template_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];
        $data['user_id'] = !is_array($data['user_id']) && !empty($data['user_id']) ? array($data['user_id']) : $data['user_id'];

        if (isset($data['user_name']) || isset($data['user_email'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "user c ON (t.user_id = u.user_id) ";
        }

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $criteria[] = " t.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['theme_id']) && !empty($data['theme_id'])) {
            $criteria[] = " t.theme_id IN (" . implode(', ', $data['theme_id']) . ") ";
        }

        if (isset($data['template_id']) && !empty($data['template_id'])) {
            $criteria[] = " t.template_id IN (" . implode(', ', $data['template_id']) . ") ";
        }

        if (isset($data['user_id']) && !empty($data['user_id'])) {
            $criteria[] = " t.user_id IN (" . implode(', ', $data['user_id']) . ") ";
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
                $search .= " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
            }
            if (!empty($search)) {
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['template']) && !empty($data['template'])) {
            $criteria[] = " LCASE(t.`template`) LIKE '%" . $this->db->escape(strtolower($data['template'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['user_name']) && !empty($data['user_name'])) {
            $criteria[] = " LCASE(CONCAT(u.firstname, ' ', u.lastname)) LIKE '%" . $this->db->escape(strtolower($data['user_name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['user_email']) && !empty($data['user_email'])) {
            $criteria[] = " LCASE(u.`email`) LIKE '%" . $this->db->escape(strtolower($data['user_email'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.theme_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'theme' ";
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
                $sql .= " GROUP BY t.theme_id";
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

    public function getAllStyles($data=null) {
        $cache_prefix = "admin.theme_styles";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "theme_style t ";

            $sql .= $this->buildStyleSQLQuery($data);
            $query = $this->db->query($sql);
            $this->cache->set($cachedId, $query->rows);
            return $query->rows;
        } else {
            return $cached;
        }
    }

    private function buildStyleSQLQuery($data) {
        $criteria = array();
        $sql = "";

        $data['theme_id'] = !is_array($data['theme_id']) && !empty($data['theme_id']) ? array($data['theme_id']) : $data['theme_id'];
        $data['theme_style_id'] = !is_array($data['theme_style_id']) && !empty($data['theme_style_id']) ? array($data['theme_style_id']) : $data['theme_style_id'];

        if (isset($data['theme_id']) && !empty($data['theme_id'])) {
            $criteria[] = " t.theme_id IN (" . implode(', ', $data['theme_id']) . ") ";
        }

        if (isset($data['theme_style_id']) && !empty($data['theme_style_id'])) {
            $criteria[] = " t.theme_style_id IN (" . implode(', ', $data['theme_style_id']) . ") ";
        }

        if (isset($data['selector']) && !empty($data['selector'])) {
            $criteria[] = " LCASE(t.`selector`) LIKE '%" . $this->db->escape(strtolower($data['selector'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['property']) && !empty($data['property'])) {
            $criteria[] = " LCASE(t.`property`) LIKE '%" . $this->db->escape(strtolower($data['property'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['value']) && !empty($data['value'])) {
            $criteria[] = " LCASE(t.`value`) LIKE '%" . $this->db->escape(strtolower($data['value'])) . "%' collate utf8_general_ci ";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        $sql .= " GROUP BY t.theme_style_id ";
        $sql .= " ORDER BY t.selector ";
        $sql .= ($data['order'] == 'DESC') ? " DESC" : " ASC";
        

        if ($data['start'] && $data['limit']) {
            if ($data['start'] < 0) $data['start'] = 0;
            if (!$data['limit']) $data['limit'] = 24;

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        } elseif ($data['limit']) {
            if (!$data['limit']) $data['limit'] = 24;

            $sql .= " LIMIT ". (int)$data['limit'];
        }
        
        return $sql;
    }

    public function activate($id) {
        return $this->__activate('theme', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('theme', $id);
    }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('theme', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('theme', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('theme', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('theme', $id, $group);
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