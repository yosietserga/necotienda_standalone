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
	 * @return void
	 */
	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "menu SET 
        store_id    = '" . (int)$data['store_id'] . "', 
        name        = '" . $this->db->escape($data['name']) . "', 
        position    = '" . $this->db->escape($data['position']) . "', 
        route       = '" . $this->db->escape($data['route']) . "', 
        sort_order  = '" . (int)$data['sort_order'] . "', 
        `default`      = '" . (int)$data['default'] . "', 
        status      = '1', 
        date_added  = NOW()");

		$menu_id = $this->db->getLastId();
        
        if ($data['default']) {
            $this->db->query("UPDATE " . DB_PREFIX . "menu SET `default` = 0");
            $this->db->query("UPDATE " . DB_PREFIX . "menu SET `default` = 1 WHERE menu_id = '". (int)$menu_id ."'");
        }
        
        foreach ($data['stores'] as $store) {
    		$this->db->query("INSERT INTO " . DB_PREFIX . "menu_to_store SET 
            store_id       = '" . intval($store) . "', 
            menu_id        = '" . intval($menu_id) . "'");
        }
        
		$parent = array();
		foreach ($data['link'] as $key => $link) {
            if (empty($link['link']) || empty($link['tag'])) continue;
            $index = explode("_",$key);
            if (count($index) == 2) {
                $parent_id = $parent[$index[0]];
                $sort_order = $index[1];
            } elseif (count($index) == 3) {
                $parent_id = $parent[$index[0] ."_". $index[1]];
                $sort_order = $index[2];
            } else {
                $sort_order = $index[0];
                $parent_id = 0;
            }

			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_link SET 
            menu_id     = '" . (int)$menu_id . "',
            parent_id   = '" . (int)$parent_id . "',
            link        = '" . $this->db->escape($link['link']) . "', 
            sort_order  = '" . (int)$sort_order . "', 
            tag         = '" . $this->db->escape($link['tag']) . "'");

			$parent[$key] = $this->db->getLastId();

			if (isset($link['page_id'])) {
				$this->setProperty($parent[$key], 'menu_link', 'page_id', $link['page_id']);
			}
			if (isset($link['class_css'])) {
				$this->setProperty($parent[$key], 'menu_link', 'class_css', $link['class_css']);
			}
		}
        return $menu_id;
	}
	
	/**
	 * ModelContentMenu::editMenu()
	 * 
	 * @param int $menu_id
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function update($menu_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "menu SET 
        store_id = '" . (int)$data['store_id'] . "', 
        name = '" . $this->db->escape($data['name']) . "', 
        position = '" . $this->db->escape($data['position']) . "', 
        route = '" . $this->db->escape($data['route']) . "', 
        sort_order = '" . (int)$data['sort_order'] . "', 
        `default`      = '" . (int)$data['default'] . "', 
        status = '1', 
        date_modified = NOW() 
        WHERE menu_id = '" . (int)$menu_id . "'");

        if ($data['default']) {
            $this->db->query("UPDATE " . DB_PREFIX . "menu SET `default` = 0");
            $this->db->query("UPDATE " . DB_PREFIX . "menu SET `default` = 1 WHERE menu_id = '". (int)$menu_id ."'");
        }
        
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_to_store WHERE menu_id = '". (int)$menu_id ."'");
		foreach ($data['stores'] as $store) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_to_store SET
			store_id  = '". intval($store) ."',
			menu_id = '". intval($menu_id) ."'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_property ".
		"WHERE `group` = 'menu_link' ".
		"AND menu_id IN ".
		"(SELECT menu_link_id FROM " . DB_PREFIX . "menu_link WHERE menu_id = '" . (int)$menu_id . "')");

        $parent = array();
		foreach ($data['link'] as $key => $link) {
			if (empty($link['link']) || empty($link['tag'])) continue;
            $index = explode("_",$key);
            if (count($index) == 2) {
                $parent_id = $parent[$index[0]];
                $sort_order = $index[1];
            } elseif (count($index) >= 3) {
                $parent_id = $parent[$index[0] ."_". $index[1]];
                $sort_order = $index[2];
            } else {
                $sort_order = $index[0];
                $parent_id = 0;
            }

			if (isset($link['menu_link_id'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "menu_link SET
				menu_id     = '" . (int)$menu_id . "',
				parent_id   = '" . (int)$parent_id . "',
				link        = '" . $this->db->escape($link['link']) . "',
				sort_order  = '" . (int)$sort_order . "',
				tag         = '" . $this->db->escape($link['tag']) . "'
				WHERE menu_link_id = '" . (int)$link['menu_link_id'] . "'");

				$parent[$key] = $link['menu_link_id'];
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "menu_link SET
				menu_id     = '" . (int)$menu_id . "',
				parent_id   = '" . (int)$parent_id . "',
				link        = '" . $this->db->escape($link['link']) . "',
				sort_order  = '" . (int)$sort_order . "',
				tag         = '" . $this->db->escape($link['tag']) . "'");

				$parent[$key] = $this->db->getLastId();
			}
			if (isset($link['page_id'])) {
				$this->setProperty($parent[$key], 'menu_link', 'page_id', $link['page_id']);
			}
			if (isset($link['class_css'])) {
				$this->setProperty($parent[$key], 'menu_link', 'class_css', $link['class_css']);
			}
		}
var_dump($parent);
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_link WHERE `menu_link_id` NOT IN (". implode(',', $parent) .")");
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
	   return true;
	}
	
	/**
	 * ModelContentMenu::deleteMenu()
	 * 
	 * @param int $menu_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function delete($menu_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu WHERE menu_id = '" . (int)$menu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query IN (SELECT link FROM " . DB_PREFIX . "menu_link WHERE menu_id = '" . (int)$menu_id . "')");
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_link WHERE menu_id = '" . (int)$menu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_property WHERE menu_id = '" . (int)$menu_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_link 
        WHERE menu_id IN 
            (SELECT menu_id 
            FROM " . DB_PREFIX . "menu 
            WHERE parent_id = '" . (int)$menu_id . "')");
            
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias 
        WHERE object_type = 'menu' 
        AND object_id IN 
            (SELECT menu_id 
            FROM " . DB_PREFIX . "menu_link 
            WHERE parent_id = '" . (int)$menu_id . "')");
            
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_to_store WHERE menu_id = '" . (int)$menu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_to_store WHERE menu_id IN 
        (SELECT menu_id 
            FROM " . DB_PREFIX . "menu_link 
            WHERE parent_id = '" . (int)$menu_id . "')");
            
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_link WHERE parent_id = '" . (int)$menu_id . "'");
	} 

	/**
	 * ModelContentMenu::getLinks()
	 * 
	 * @param int $menu_id
     * @see DB
	 * @return array sql record
	 */
	public function getLinks($menu_id,$parent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_link ml WHERE 
        menu_id = '" . (int)$menu_id . "' AND parent_id = '" . (int)$parent_id . "'");
        
        foreach ($query->rows as $k => $value) {
            $keyword = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($value['link']) . "'");
            $links[$k] = array(
                'menu_link_id'   =>$value['menu_link_id'],
                'menu_id'   =>$value['menu_id'],
                'parent_id' =>$value['parent_id'],
                'link'      =>$value['link'],
                'tag'      =>$value['tag'],
                'sort_order'=>$value['sort_order'],
                'keyword'   => $keyword->row['keyword']
            );
			$links[$k]['class_css'] = $this->getProperty($value['menu_link_id'], 'menu_link', 'class_css');
			$links[$k]['page_id'] = $this->getProperty($value['menu_link_id'], 'menu_link', 'page_id');
        }
        
		return $links;
	} 
	
	/**
	 * ModelContentMenu::getMenu()
	 * 
	 * @param int $menu_id
     * @see DB
	 * @return array sql record
	 */
	public function getMenu($menu_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_link ml WHERE menu_id = '" . (int)$menu_id . "'");
        
        foreach ($query->rows as $value) {
            $keyword = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($value['link']) . "'");
            $links[] = array(
                'menu_id'   =>$value['menu_id'],
                'parent_id' =>$value['parent_id'],
                'link'      =>$value['link'],
                'sort_order'=>$value['sort_order'],
                'keyword'   => $keyword->row['keyword']
            );
        }
        
		$query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu m WHERE menu_id = '" . (int)$menu_id . "'");
        
        $return = array(
            'menu_id'   =>$query2->row['menu_id'],
            'default'   =>$query2->row['default'],
            'position'  =>$query2->row['position'],
            'route'     =>$query2->row['route'],
            'name'      =>$query2->row['name'],
            'sort_order'=>$query2->row['sort_order'],
            'links'     =>$links
        );
        
		return $return;
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
	
	/**
	 * ModelContentMenu::getMenus()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getMenus() {
			$sql = "SELECT * FROM ". DB_PREFIX ."menu m ";
            $implode = array();
			$implode[] = " `status` = '1'";
            if ($implode) {
                $sql .= "WHERE " . implode(" AND ",$implode);
            }
			$sql .= " ORDER BY m.name ASC";
            $query = $this->db->query($sql);
            
		return $query->rows;
	}
	/**
	 * ModelContentMenu::getAll()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAll($data=array()) {
			$menu_data = array();
		      
			$sql = "SELECT * FROM ". DB_PREFIX ."menu m ";
            
            $implode = array();
            
			if (isset($data['filter_name'])) {
				$implode[] = " LCASE(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
			}

			if (isset($data['filter_position'])) {
				$implode[] = " LCASE(position) LIKE '%" . $this->db->escape(strtolower($data['filter_position'])) . "%'";
			}

			if (isset($data['filter_route'])) {
				$implode[] = " LCASE(route) LIKE '%" . $this->db->escape(strtolower($data['filter_route'])) . "%'";
			}

			if (isset($data['status'])) {
				$implode[] = " `status` = '" . (int)$data['status'] . "'";
			}

			if (isset($data['filter_date_start'],$data['filter_date_end'])) {
				$implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
			} elseif (isset($data['filter_date_start'])) {
				$implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
			}
            
            if ($implode) {
                $sql .= "WHERE " . implode(" AND ",$implode);
            }

			$sort_data = array(
				'name',
				'position',
				'date_added',
				'sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY m.sort_order, m.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
            $query = $this->db->query($sql);
            
		return $query->rows;
	}
	
	/**
	 * ModelContentMenu::getAllTotal()
	 * 
     * @see DB
	 * @return int Count sql records
	 */
	public function getAllTotal($data) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu ";
		
            $implode = array();
            
			if (isset($data['filter_name'])) {
				$implode[] = " LCASE(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
			}

			if (isset($data['filter_position'])) {
				$implode[] = " LCASE(position) LIKE '%" . $this->db->escape(strtolower($data['filter_position'])) . "%'";
			}

			if (isset($data['filter_route'])) {
				$implode[] = " LCASE(route) LIKE '%" . $this->db->escape(strtolower($data['filter_route'])) . "%'";
			}

			if (isset($data['filter_date_start'],$data['filter_date_end'])) {
				$implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
			} elseif (isset($data['filter_date_start'])) {
				$implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
			}
            
            if ($implode) {
                $sql .= "WHERE " . implode(" AND ",$implode);
            }

			$sort_data = array(
				'name',
				'position',
				'date_added',
				'sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY m.sort_order, m.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
      	$query = $this->db->query($sql);
        
		return $query->row['total'];
	}
		
	/**
	 * ModelContentMenu::getAllTotalByImageId()
	 * 
	 * @param int $image_id
	 * @return int Count sql records
	 */
	public function getAllTotalByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}
    
    /**
     * ModelContentMenu::activate()
     * activar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function activate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "menu` SET `status` = '1' WHERE `menu_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelContentMenu::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "menu` SET `status` = '0' WHERE `menu_id` = '" . (int)$id . "'");
        return $query;
     }


	/**
	 * ModelContentMenu::getProperty()
	 *
	 * Obtener una propiedad de la pagina
	 *
	 * @param int $id post_id
	 * @param varchar $group
	 * @param varchar $key
	 * @return mixed value of property
	 * */
	public function getProperty($id, $group, $key) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_property
        WHERE `menu_id` = '" . (int) $id . "'
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");

		return unserialize(str_replace("\'", "'", $query->row['value']));
	}

	/**
	 * ModelContentMenu::setProperty()
	 *
	 * Asigna una propiedad de la pagina
	 *
	 * @param int $id post_id
	 * @param varchar $group
	 * @param varchar $key
	 * @param mixed $value
	 * @return void
	 * */
	public function setProperty($id, $group, $key, $value) {
		$this->deleteProperty($id, $group, $key);
		$this->db->query("INSERT INTO " . DB_PREFIX . "menu_property SET
        `menu_id`   = '" . (int) $id . "',
        `group`     = '" . $this->db->escape($group) . "',
        `key`       = '" . $this->db->escape($key) . "',
        `value`     = '" . $this->db->escape(str_replace("'", "\'", serialize($value))) . "'");
	}

	/**
	 * ModelContentMenu::deleteProperty()
	 *
	 * Elimina una propiedad de la pagina
	 *
	 * @param int $id post_id
	 * @param varchar $group
	 * @param varchar $key
	 * @return void
	 * */
	public function deleteProperty($id, $group, $key) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_property
        WHERE `menu_id` = '" . (int) $id . "'
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");
	}

	/**
	 * ModelContentMenu::getAllProperties()
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
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_property
            WHERE `menu_id` = '" . (int) $id . "'");
		} else {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_property
            WHERE `menu_id` = '" . (int) $id . "'
            AND `group` = '" . $this->db->escape($group) . "'");
		}

		return $query->rows;
	}

	/**
	 * ModelContentMenu::setAllProperties()
	 *
	 * Asigna todas las propiedades de la pagina
	 *
	 * Pase un array con todas las propiedades y sus valores
	 * eneplo:
	 *
	 * $data = array(
	 *    'key1'=>'abc',
	 *    'key2'=>123,
	 *    'key3'=>array(
	 *       'subkey1'=>'value1'
	 *    ),
	 *    'key4'=>$object,
	 * );
	 *
	 * @param int $id post_id
	 * @param varchar $group
	 * @param array $data
	 * @return void
	 * */
	public function setAllProperties($id, $group, $data) {
		if (is_array($data) && !empty($data)) {
			$this->deleteAllProperties($id, $group);
			foreach ($data as $key => $value) {
				$this->setProperty($id, $group, $key, $value);
			}
		}
	}

	/**
	 * ModelContentMenu::deleteAllProperties()
	 *
	 * Elimina todas las propiedades de la pagina
	 *
	 * Si quiere eliminar todos los grupos de propiedades
	 * utilice * como nombre del grupo, ejemplo:
	 *
	 * $properties = deleteAllProperties($post_id, '*');
	 *
	 * Sino coloque el nombre del grupo de las propiedades
	 *
	 * $properties = deleteAllProperties($post_id, 'NombreDelGrupo');
	 *
	 * @param int $id post_id
	 * @param varchar $group
	 * @param varchar $key
	 * @return void
	 * */
	public function deleteAllProperties($id, $group = '*') {
		if ($group == '*') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "menu_property
            WHERE `menu_id` = '" . (int) $id . "'");
		} else {
			$this->db->query("DELETE FROM " . DB_PREFIX . "menu_property
            WHERE `menu_id` = '" . (int) $id . "'
            AND `group` = '" . $this->db->escape($group) . "'");
		}
	}
}
