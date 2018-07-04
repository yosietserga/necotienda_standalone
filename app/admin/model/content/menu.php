<?php
/**
 * ModelContentMenu
 * 
 * @package NecoTienda
 * @author NecoTienda
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 */
class ModelContentMenu extends Model {
	/**
	 * ModelContentMenu::add()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return integer $id
	 */
	public function add($data) {
        $sql = "INSERT INTO " . DB_PREFIX . "menu SET ".
            "`store_id`    = '" . (int)$data['store_id'] . "', ".
            "`name`        = '" . $this->db->escape($data['name']) . "', ".
            "`default`      = '" . ($data['default'] ? 1 : 0) . "', ".
            "`status`      = '1', ".
            "`date_added`  = NOW()";
        $this->db->query($sql);
		$id = $this->db->getLastId();

        foreach ($data['stores'] as $store) {
    		$this->db->query("INSERT INTO " . DB_PREFIX . "menu_to_store SET ".
            "store_id       = '" . intval($store) . "', ".
            "menu_id        = '" . intval($id) . "'");
        }

        $this->setItems($id, $data['link']);

        return $id;
	}
	
	/**
	 * ModelContentMenu::editMenu()
	 * 
	 * @param int $id
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function update($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "menu SET ".
            "`store_id` = '" . (int)$data['store_id'] . "', ".
            "`name`        = '" . $this->db->escape($data['name']) . "', ".
            "`default`      = '" . ($data['default'] ? 1 : 0) . "', ".
            "`status` = '1', ".
            "date_modified = NOW()".
        "WHERE menu_id = '" . (int)$id . "'");
        
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_to_store ".
            "WHERE menu_id = '". (int)$id ."'");
        
		foreach ($data['stores'] as $store) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_to_store SET ".
            "store_id  = '". intval($store) ."',".
			"menu_id = '". intval($id) ."'");
		}
        
		$this->deleteItems($id);
        $this->setItems($id, $data['link']);
	}
	
	/**
	 * ModelContentMenu::sortMenu()
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function sortMenu($data) {
	   if (!is_array($data)) return false;
       $pos = 1;
       foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "menu SET sort_order = '" . (int)$pos . "' WHERE menu_id = '" . (int)$id . "'");
            $pos++;
       }
	}
	
	/**
	 * ModelContentMenu::delete()
	 * 
	 * @param int $menu_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function delete($id) {
	    $this->deleteItems($id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "menu ".
            "WHERE menu_id = '" . (int)$id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "property ".
            "WHERE object_id = '" . (int)$id . "' ".
            "AND object_type = 'menu'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_to_store ".
            "WHERE menu_id = '" . (int)$id . "'");
	}

    public function getAllItems($data=null) {
        $cache_prefix = "admin.menu_links";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "menu_link ml ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'tag',
                    'sort_order'
                );
            }

            $sql .= $this->buildSQLQueryItems($data, $sort_data);
            $query = $this->db->query($sql);
            $links = array();

            foreach ($query->rows as $k => $v) {
                $keyword = $this->db->query("SELECT `keyword` FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($v['link']) . "'");

                $links[$k] = array(
                    'menu_link_id'  => $v['menu_link_id'],
                    'menu_id'       => $v['menu_id'],
                    'parent_id'     => $v['parent_id'],
                    'link'          => $v['link'],
                    'tag'           => $v['tag'],
                    'sort_order'    => $v['sort_order'],
                    'keyword'       => $keyword->row['keyword']
                );
                $links[$k]['class_css'] = $this->getProperty($v['menu_link_id'], 'menu_link', 'class_css');
                $links[$k]['page_id'] = $this->getProperty($v['menu_link_id'], 'menu_link', 'page_id');
                $links[$k]['descriptions'] = $this->getDescriptions($v['menu_link_id']);
            }
            $this->cache->set($cachedId, $links);
            return $links;
        } else {
            return $cached;
        }
    }

    public function getAllItemsTotal($data=null) {
        $cache_prefix = "admin.menu_links.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu_link ml ";
            $sql .= $this->buildSQLQueryItems($data, null, true);
            $query = $this->db->query($sql);

            $this->cache->set($cachedId, $query->row['total']);

            return $query->row['total'];
        } else {
            return $cached;
        }
    }

    private function buildSQLQueryItems($data, $sort_data = null, $countAsTotal = false) {
        $criteria = array();
        $sql = "";

        $data['menu_id'] = !is_array($data['menu_id']) && !empty($data['menu_id']) ? array($data['menu_id']) : $data['menu_id'];
        $data['parent_id'] = !is_array($data['parent_id']) && (!empty($data['parent_id']) || $data['parent_id'] === 0) ? array($data['parent_id']) : $data['parent_id'];
        $data['menu_link_id'] = !is_array($data['menu_link_id']) && !empty($data['menu_link_id']) ? array($data['menu_link_id']) : $data['menu_link_id'];

        if (isset($data['menu_id']) && !empty($data['menu_id'])) {
            $criteria[] = " ml.menu_id IN (" . implode(', ', $data['menu_id']) . ") ";
        }

        if (isset($data['parent_id']) && (!empty($data['parent_id']) || $data['parent_id'] === 0)) {
            $criteria[] = " ml.parent_id IN (" . implode(', ', $data['parent_id']) . ") ";
        }

        if (isset($data['menu_link_id']) && !empty($data['menu_link_id'])) {
            $criteria[] = " ml.menu_link_id IN (" . implode(', ', $data['menu_link_id']) . ") ";
        }

        if (!empty($data['link'])) {
            $criteria[] = " LCASE(ml.`link`) LIKE '%" . $this->db->escape(strtolower($data['link'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['tag'])) {
            $criteria[] = " LCASE(ml.`tag`) LIKE '%" . $this->db->escape(strtolower($data['tag'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['keyword'])) {
            $criteria[] = " LCASE(ml.`keyword`) LIKE '%" . $this->db->escape(strtolower($data['keyword'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property lp ON (ml.menu_link_id = lp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(lp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(lp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " lp.object_type = 'menu_link' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY ml.menu_link_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY ml.sort_order";
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

	public function setItems($menu_id, $links) {
        if ($menu_id==0) return false;
        $parent = array();
        $sort_order = 0;
        foreach ($links as $key => $link) {
            if (empty($link['link']) || empty($link['tag'])) continue;
            
            $index = explode("_",$key);
            $parent_id = 0;
            if (count($index) == 2) {
                $parent_id = $parent[$index[0]];
             } elseif (count($index) == 3) {
                $parent_id = $parent[$index[0] . "_" . $index[1]];
            }

            $this->log->trace('$parent: '. print_r($parent, true));
            $this->log->trace('$parent_id: '. print_r($parent_id, true));
            $this->log->trace('$index: '. print_r($index, true));

            $this->db->query("INSERT INTO " . DB_PREFIX . "menu_link SET ".
                "menu_id     = '" . (int)$menu_id . "',".
                "parent_id   = '" . (int)$parent_id . "',".
                "link        = '" . $this->db->escape($link['link']) . "',".
                "sort_order  = '" . (int)$sort_order . "', ".
                "tag         = '" . $this->db->escape($link['tag']) . "'");
            
            $parent[$key] = $this->db->getLastId();
            
            $sort_order++;
            
            if (isset($link['class_css']) && !empty($link['class_css'])) {
                $this->setProperty($parent[$key], 'menu_link', 'class_css', $link['class_css']);
            }

            if (isset($link['page_id']) && !empty($link['page_id'])) {
                $this->setProperty($parent[$key], 'menu_link', 'page_id', $link['page_id']);
            }

            if (isset($link['descriptions']) && !empty($link['descriptions'])) {
                $this->setDescriptions($parent[$key], $link['descriptions']);
            }
        }
    }

    public function deleteItems($id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "property ".
            "WHERE object_id IN (".
            "SELECT menu_link_id FROM " . DB_PREFIX . "menu_link ".
            "WHERE menu_id = ". (int)$id
            .") ".
            "AND object_type = 'menu_link'");
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "description ".
            "WHERE object_id IN (".
            "SELECT menu_link_id FROM " . DB_PREFIX . "menu_link ".
            "WHERE menu_id = ". (int)$id
            .") ".
            "AND object_type = 'menu_link'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "menu_link ".
            "WHERE menu_id = '" . (int)$id . "'");

        $this->deleteProperties($id, 'menu_link');
    }

	/**
	 * ModelContentCategory::getStores()
	 * 
	 * @param int $banner_id
     * @see DB
	 * @return array sql records
	 */
	public function getStores($menu_id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_to_store WHERE menu_id = '" . (int)$menu_id . "'");
		foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
		}
		return $data;
	}	

    public function getById($id) {
        $result = $this->getAll(array(
            'menu_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.menus";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "menu m ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'name',
                    'date_added'
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
        $cache_prefix = "admin.menus.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu m ";
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

        $data['menu_id'] = !is_array($data['menu_id']) && !empty($data['menu_id']) ? array($data['menu_id']) : $data['menu_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "menu_to_store t2s ON (m.menu_id = t2s.menu_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['menu_id']) && !empty($data['menu_id'])) {
            $criteria[] = " m.menu_id IN (" . implode(', ', $data['menu_id']) . ") ";
        }

        if (!empty($data['name'])) {
            $criteria[] = " LCASE(m.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " m.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['default']) && is_numeric($data['default'])) {
            $criteria[] = " m.default = '". intval($data['default']) ."' ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property mp ON (m.menu_id = mp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(mp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(mp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " mp.object_type = 'menu' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY m.menu_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY m.name";
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
        return $this->__activate('menu', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('menu', $id);
    }
    
    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('menu_link', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        $descriptions = array();
        foreach ($data as $language_id => $v) {
            if (empty($v['description'])) continue;
            $descriptions[$language_id] = array(
                'description'=>$v['description']
            );
        }
        return $this->__setDescriptions('menu_link', $id, $descriptions);
    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('menu', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('menu', $id, $group, $key, $value);
    }

    public function deleteProperties($id, $group='*', $key='*') {
        return $this->__deleteProperties('menu', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('menu', $id, $group);
    }

    public function setAllProperties($id, $group, $data) {
        if (is_array($data) && !empty($data)) {
            $this->deleteProperties($id, $group);
            foreach ($data as $key => $value) {
                $this->setProperty($id, $group, $key, $value);
            }
        }
    }
}
