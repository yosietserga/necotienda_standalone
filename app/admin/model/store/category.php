<?php
/**
 * ModelStoreCategory
 * 
 * @package NecoTienda powered by opencart
 * @author NecoTienda
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 */
class ModelStoreCategory extends Model {
	/**
	 * ModelStoreCategory::addCategory()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET 
        parent_id = '" . (int)$data['parent_id'] . "', 
        sort_order = '0', 
        status = '1', 
        date_modified = NOW(), 
        date_added = NOW()");
	
		$category_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}
		
		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET 
            category_id = '" . (int)$category_id . "', 
            language_id = '" . (int)$language_id . "', 
            name = '" . $this->db->escape($value['name']) . "', 
            meta_description = '" . $this->db->escape($value['meta_description']) . "', 
            description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
            query = 'category_id=" . (int)$category_id . "', 
            keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id='" . (int)$category_id."'");
        foreach ($data['Products'] as $product_id => $value) {
            if ($value == 0) continue;
    		$this->db->query("REPLACE INTO " . DB_PREFIX . "product_to_category (product_id, category_id) VALUES ('" . (int)$product_id . "','" . (int)$category_id."')");
        }
        
		$this->cache->delete('category_admin');
        
        return $category_id;
	}
	
	/**
	 * ModelStoreCategory::editCategory()
	 * 
	 * @param int $category_id
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function editCategory($category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "category SET 
        parent_id = '" . (int)$data['parent_id'] . "',
        date_modified = NOW() 
        WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET 
            category_id = '" . (int)$category_id . "', 
            language_id = '" . (int)$language_id . "', 
            name = '" . $this->db->escape($value['name']) . "', 
            meta_description = '" . $this->db->escape($value['meta_description']) . "', 
            description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if ($data['keyword']) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id. "'");
		
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
            query = 'category_id=" . (int)$category_id . "', 
            keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id='" . (int)$category_id."'");
        foreach ($data['Products'] as $product_id => $value) {
            if ($value == 0) continue;
    		$this->db->query("REPLACE INTO " . DB_PREFIX . "product_to_category (product_id, category_id) VALUES ('" . (int)$product_id . "','" . (int)$category_id."')");
        }
        
		$this->cache->delete('category_admin');
	}
	
	/**
	 * ModelStoreCategory::sortCategory()
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function sortCategory($data) {
	   if (!is_array($data)) return false;
       $pos = 1;
       foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "category SET sort_order = '" . (int)$pos . "' WHERE category_id = '" . (int)$id . "'");
            $pos++;
       }
		$this->cache->delete('category_admin');
	   return true;
	}
	
	/**
	 * ModelStoreCategory::deleteCategory()
	 * 
	 * @param int $category_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function delete($category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_stats WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");
		
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}
		
		$this->cache->delete('category_admin');
	} 

	/**
	 * ModelStoreCategory::getCategory()
	 * 
	 * @param int $category_id
     * @see DB
	 * @return array sql record
	 */
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "') AS keyword 
        FROM " . DB_PREFIX . "category c
            LEFT JOIN ". DB_PREFIX . "category_description cd ON (cd.category_id=c.category_id) 
        WHERE c.category_id = '" . (int)$category_id . "'");
		
		return $query->row;
	} 
	
	/**
	 * ModelStoreCategory::getCategories()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getCategories($parent_id) {
		$category_data = $this->cache->get('category_admin.' . $this->config->get('config_language_id') . '.' . $parent_id);
	
		if (!$category_data) {
			$category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c 
                LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
            WHERE c.parent_id = '" . (int)$parent_id . "' 
                AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$category_data = array_merge($category_data, $this->getCategories($result['category_id']));
			}	
	
			$this->cache->set('category_admin.' . $this->config->get('config_language_id') . '.' . $parent_id, $category_data);
		}
		
		return $category_data;
	}
	
	/**
	 * ModelStoreCategory::getCategories()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAll($data=array()) {
			$category_data = array();
		      
			$sql = "SELECT * 
            FROM " . DB_PREFIX . "category c 
                LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
            WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            
			if (isset($data['filter_name'])) {
				$sql .= " AND LCASE(cd.name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
			}

			if (isset($data['filter_date_start'],$data['filter_date_end'])) {
				$sql .= " AND c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
			} elseif (isset($data['filter_date_start'])) {
				$sql .= " AND c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
			}

			$sort_data = array(
				'cd.name',
				'c.date_added',
				'c.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY c.sort_order, cd.name";	
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
			foreach ($query->rows as $result) {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$category_data = array_merge($category_data, $this->getCategories($result['category_id']));
			}	
	
		return $category_data;
	}
	
	/**
	 * ModelStoreCategory::getAllForList()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAllForList($parent_id=0,$data=array()) {
		$sql = "SELECT * 
        FROM " . DB_PREFIX . "category c 
            LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
        WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
            
		if (empty($data['filter_name']) && empty($data['filter_date_start']) && empty($data['filter_product'])) {
            $sql .= " AND parent_id = " . (int)$parent_id;
            $with_child = true;
		}
  
		if (isset($data['filter_name'])) {
            $sql .= " AND LCASE(cd.name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}

		if (isset($data['filter_date_start'],$data['filter_date_end'])) {
            $sql .= " AND c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
		} elseif (isset($data['filter_date_start'])) {
            $sql .= " AND c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
		}

		if (isset($data['filter_product'])) {
            $sql .= " AND c.category_id IN (SELECT category_id 
                FROM " . DB_PREFIX . "product_to_category p2c
                    LEFT JOIN " . DB_PREFIX . "product_description pd ON (p2c.product_id=pd.product_id) 
                WHERE LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($data['filter_product'])) . "%'
                AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
		}

		$sort_data = array(
		  'cd.name',
		  'c.date_added',
		  'c.sort_order'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];	
		} else {
            $sql .= " ORDER BY c.sort_order ASC, cd.name ";	
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
        $return = array();
        if ($query->rows) {
            foreach ($query->rows as $key => $value) {
                if (isset($with_child)) $childrens = $this->getAllForList($value['category_id'],$data);
                $return[] = array(
                    'category_id'=>$value['category_id'],
                    'name'=>$value['name'],
                    'status'=>$value['status'],
                    'childrens'=> ($childrens) ? $childrens : null
                );
            }
            return $return;
        } else {
            return false;
        }
	}
	
	/**
	 * ModelStoreCategory::getAllForList()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAllForMenu($parent_id=0) {
		$sql = "SELECT * 
        FROM " . DB_PREFIX . "category c 
            LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
        WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            AND parent_id = " . (int)$parent_id ." ORDER BY c.sort_order ASC, cd.name ASC";
		
        $query = $this->db->query($sql);
        return $query->rows;
	}
	
	/**
	 * ModelStoreCategory::getPath()
	 * 
	 * @param int $category_id
	 * @return string 
	 */
	public function getPath($category_id) {
		$query = $this->db->query("SELECT name, parent_id 
        FROM " . DB_PREFIX . "category c 
            LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
        WHERE c.category_id = '" . (int)$category_id . "' 
            AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        ORDER BY c.sort_order, cd.name ASC");
		
		$category_info = $query->row;
		
		if ($category_info['parent_id']) {
			return $this->getPath($category_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $category_info['name'];
		} else {
			return $category_info['name'];
		}
	}
	
	/**
	 * ModelStoreCategory::getCategoryDescriptions()
	 * 
	 * @param int $category_id
     * @see DB
	 * @return array sql records
	 */
	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_keywords'    => $result['meta_keywords'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $category_description_data;
	}	
	
	/**
	 * ModelStoreCategory::getTotalCategories()
	 * 
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");
		
		return $query->row['total'];
	}	
		
		
	/**
	 * ModelStoreCategory::getTotalCategoriesByImageId()
	 * 
	 * @param int $image_id
	 * @return int Count sql records
	 */
	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}
    
    /**
     * ModelStoreCategory::activate()
     * activar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function activate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "category` SET `status` = '1' WHERE `category_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelStoreCategory::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "category` SET `status` = '0' WHERE `category_id` = '" . (int)$id . "'");
        return $query;
     }
}
