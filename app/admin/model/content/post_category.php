<?php
/**
 * ModelContentPostCategory
 * 
 * @package NecoTienda powered by opencart
 * @author NecoTienda
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 */
class ModelContentPostCategory extends Model {
	/**
	 * ModelContentPostCategory::addCategory()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "post_category SET 
        parent_id = '" . (int)$data['parent_id'] . "', 
        sort_order = '0', 
        status = '1', 
        date_added = NOW()");
	
		$post_category_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post_category SET image = '" . $this->db->escape($data['image']) . "' WHERE post_category_id = '" . (int)$post_category_id . "'");
		}
		
		foreach ($data['post_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_category_description SET 
            post_category_id = '" . (int)$post_category_id . "', 
            language_id = '" . (int)$language_id . "', 
            name = '" . $this->db->escape($value['name']) . "', 
            meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', 
            meta_description = '" . $this->db->escape($value['meta_description']) . "', 
            seo_title = '" . $this->db->escape($value['seo_title']) . "', 
            description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
            query = 'post_category_id=" . (int)$post_category_id . "', 
            keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
        foreach ($data['Post'] as $post_id => $value) {
            if ($value == 0) continue;
    		$this->db->query("REPLACE INTO " . DB_PREFIX . "post_to_category (post_id, post_category_id) VALUES ('" . (int)$post_id . "','" . (int)$post_category_id."')");
        }
        
		$this->cache->delete('post_category_admin');
        
        return $post_category_id;
	}
	
	/**
	 * ModelContentPostCategory::editCategory()
	 * 
	 * @param int $post_category_id
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function editCategory($post_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "post_category SET 
        parent_id = '" . (int)$data['parent_id'] . "',
        status = '" . (int)$data['status'] . "', 
        date_modified = NOW() 
        WHERE post_category_id = '" . (int)$post_category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post_category SET image = '" . $this->db->escape($data['image']) . "' WHERE post_category_id = '" . (int)$post_category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_category_description WHERE post_category_id = '" . (int)$post_category_id . "'");

		foreach ($data['post_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_category_description SET 
            post_category_id = '" . (int)$post_category_id . "', 
            language_id = '" . (int)$language_id . "', 
            name = '" . $this->db->escape($value['name']) . "', 
            meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', 
            meta_description = '" . $this->db->escape($value['meta_description']) . "', 
            seo_title = '" . $this->db->escape($value['seo_title']) . "', 
            meta_description = '" . $this->db->escape($value['meta_description']) . "', 
            description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if ($data['keyword']) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_category_id=" . (int)$post_category_id. "'");
		
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
            query = 'post_category_id=" . (int)$post_category_id . "', 
            keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
        $this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_category_id='" . (int)$post_category_id."'");
        foreach ($data['Post'] as $post_id => $value) {
            if ($value == 0) continue;
    		$this->db->query("REPLACE INTO " . DB_PREFIX . "post_to_category (post_id, post_category_id) VALUES ('" . (int)$post_id . "','" . (int)$post_category_id."')");
        }
        
        
		$this->cache->delete('post_category_admin');
	}
	
	/**
	 * ModelContentPostCategory::sortCategory()
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function sortCategory($data) {
	   if (!is_array($data)) return false;
       $pos = 1;
       foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "post_category SET sort_order = '" . (int)$pos . "' WHERE post_category_id = '" . (int)$id . "'");
            $pos++;
       }
		$this->cache->delete('post_category_admin');
	   return true;
	}
	
	/**
	 * ModelContentPostCategory::deleteCategory()
	 * 
	 * @param int $post_category_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function deleteCategory($post_category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_category WHERE post_category_id = '" . (int)$post_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_category_description WHERE post_category_id = '" . (int)$post_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_category_stats WHERE post_category_id = '" . (int)$post_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_category_id=" . (int)$post_category_id . "'");
		
		$query = $this->db->query("SELECT post_category_id FROM " . DB_PREFIX . "post_category WHERE parent_id = '" . (int)$post_category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['post_category_id']);
		}
		
		$this->cache->delete('post_category_admin');
	} 

	/**
	 * ModelContentPostCategory::getCategory()
	 * 
	 * @param int $post_category_id
     * @see DB
	 * @return array sql record
	 */
	public function getCategory($post_category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'post_category_id=" . (int)$post_category_id . "') AS keyword FROM " . DB_PREFIX . "post_category WHERE post_category_id = '" . (int)$post_category_id . "'");
		
		return $query->row;
	} 
	
	/**
	 * ModelContentPostCategory::getCategories()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getCategories($parent_id) {
		$post_category_data = $this->cache->get('post_category_admin.' . $this->config->get('config_language_id') . '.' . $parent_id);
	
		if (!$post_category_data) {
			$post_category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_category c 
                LEFT JOIN " . DB_PREFIX . "post_category_description cd ON (c.post_category_id = cd.post_category_id) 
            WHERE c.parent_id = '" . (int)$parent_id . "' 
                AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$post_category_data[] = array(
					'post_category_id' => $result['post_category_id'],
					'name'        => $this->getPath($result['post_category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$post_category_data = array_merge($post_category_data, $this->getCategories($result['post_category_id']));
			}	
	
			$this->cache->set('post_category_admin.' . $this->config->get('config_language_id') . '.' . $parent_id, $post_category_data);
		}
		
		return $post_category_data;
	}
	
	/**
	 * ModelContentPostCategory::getCategories()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAll($data=array()) {
			$post_category_data = array();
		      
			$sql = "SELECT * 
            FROM " . DB_PREFIX . "post_category c 
                LEFT JOIN " . DB_PREFIX . "post_category_description cd ON (c.post_category_id = cd.post_category_id) 
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
				$post_category_data[] = array(
					'post_category_id' => $result['post_category_id'],
					'name'        => $this->getPath($result['post_category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$post_category_data = array_merge($post_category_data, $this->getCategories($result['post_category_id']));
			}	
	
		return $post_category_data;
	}
	
	/**
	 * ModelContentPostCategory::getAllForList()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAllForList($parent_id=0,$data=array()) {
		$sql = "SELECT * 
        FROM " . DB_PREFIX . "post_category c 
            LEFT JOIN " . DB_PREFIX . "post_category_description cd ON (c.post_category_id = cd.post_category_id) 
        WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
            AND parent_id = " . (int)$parent_id;
            
		if (isset($data['filter_name'])) {
            $sql .= " AND LCASE(cd.name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}

		if (isset($data['filter_date_start'],$data['filter_date_end'])) {
            $sql .= " AND c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
		} elseif (isset($data['filter_date_start'])) {
            $sql .= " AND c.date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
		}

		if (isset($data['filter_post'])) {
            $sql .= " AND c.post_category_id IN (SELECT post_category_id 
                                        FROM " . DB_PREFIX . "product_to_post_category p2c
                                            LEFT JOIN " . DB_PREFIX . "product_description pd ON (p2c.product_id=pd.product_id) 
                                        WHERE LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($data['filter_post'])) . "%'
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
		return $query->rows;
	}
	
	/**
	 * ModelContentPostCategory::getAllForMenu()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAllForMenu($parent_id=0) {
		$sql = "SELECT * 
        FROM " . DB_PREFIX . "post_category c 
            LEFT JOIN " . DB_PREFIX . "post_category_description cd ON (c.post_category_id = cd.post_category_id) 
        WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
            AND parent_id = " . (int)$parent_id ." ORDER BY c.sort_order, cd.name ASC";
		
        $query = $this->db->query($sql);
		return $query->rows;
	}
	
	/**
	 * ModelContentPostCategory::getPath()
	 * 
	 * @param int $post_category_id
	 * @return string 
	 */
	public function getPath($post_category_id) {
		$query = $this->db->query("SELECT name, parent_id 
        FROM " . DB_PREFIX . "post_category c 
            LEFT JOIN " . DB_PREFIX . "post_category_description cd ON (c.post_category_id = cd.post_category_id) 
        WHERE c.post_category_id = '" . (int)$post_category_id . "' 
            AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        ORDER BY c.sort_order, cd.name ASC");
		
		$post_category_info = $query->row;
		
		if ($post_category_info['parent_id']) {
			return $this->getPath($post_category_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $post_category_info['name'];
		} else {
			return $post_category_info['name'];
		}
	}
	
	/**
	 * ModelContentPostCategory::getCategoryDescriptions()
	 * 
	 * @param int $post_category_id
     * @see DB
	 * @return array sql records
	 */
	public function getCategoryDescriptions($post_category_id) {
		$post_category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_category_description WHERE post_category_id = '" . (int)$post_category_id . "'");
		
		foreach ($query->rows as $result) {
			$post_category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_keywords'    => $result['meta_keywords'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $post_category_description_data;
	}	
	
	/**
	 * ModelContentPostCategory::getTotalCategories()
	 * 
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_category");
		
		return $query->row['total'];
	}	
		
		
	/**
	 * ModelContentPostCategory::getTotalCategoriesByImageId()
	 * 
	 * @param int $image_id
	 * @return int Count sql records
	 */
	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_category WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}
    
    /**
     * ModelContentPostCategory::activate()
     * activar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function activate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "post_category` SET `status` = '1' WHERE `post_category_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelContentPostCategory::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "post_category` SET `status` = '0' WHERE `post_category_id` = '" . (int)$id . "'");
        return $query;
     }
}
