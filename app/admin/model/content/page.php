<?php
/**
 * ModelContentPage
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelContentPage extends Model {
	/**
	 * ModelContentPage::addPage()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function addPage($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "post SET 
        parent_id   = '" . (int)$this->request->post['parent_id'] . "', 
        date_publish_start = '" . date('Y-m-d h:i:s',strtotime($this->db->escape($value['date_publish_start']))) . "', 
        date_publish_end = '" . date('Y-m-d h:i:s',strtotime($this->db->escape($value['date_publish_end']))) . "', 
        template    = '" . $this->db->escape($value['template']) . "', 
        post_type   = 'page', 
        status      = 1, 
        sort_order  = 0, 
        date_added  = NOW()");

		$post_id = $this->db->getLastId(); 
			
		foreach ($data['page_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_description SET 
            post_id     = '" . (int)$post_id . "', 
            language_id = '" . (int)$language_id . "', 
            title       = '" . $this->db->escape($value['title']) . "', 
            description = '" . $this->db->escape($value['description']) . "', 
            seo_title  = '" . $this->db->escape($value['seo_title']) . "', 
            meta_description = '" . $this->db->escape($value['meta_description']) . "', 
            meta_keywords    = '" . $this->db->escape($value['meta_keywords']) . "'");
		}
		
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
            query = 'post_id=" . (int)$post_id . "', 
            keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('post');
        return $post_id;
	}
	
	/**
	 * ModelContentPage::editPage()
	 * 
	 * @param int $post_id
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function editPage($post_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "post SET 
        parent_id   = '" . (int)$this->request->post['parent_id'] . "',
        status      = '" . (int)$this->request->post['status'] . "', 
        publish     = '" . (int)$this->request->post['publish'] . "', 
        date_publish_start = '" . $this->db->escape($value['date_publish_start']) . "', 
        date_publish_end = '" . $this->db->escape($value['date_publish_end']) . "', 
        template    = '" . $this->db->escape($value['template']) . "', 
        status      = '" . (int)$this->request->post['status'] . "', 
        sort_order  = '" . (int)$this->request->post['sort_order'] . "', 
        date_modified  = NOW() 
        WHERE post_id = '" . (int)$post_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");
					
		foreach ($data['post_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_description SET 
            post_id     = '" . (int)$post_id . "', 
            language_id = '" . (int)$language_id . "', 
            title       = '" . $this->db->escape($value['title']) . "', 
            description = '" . $this->db->escape($value['description']) . "', 
            seo_title  = '" . $this->db->escape($value['seo_title']) . "', 
            meta_description = '" . $this->db->escape($value['meta_description']) . "', 
            meta_keywords    = '" . $this->db->escape($value['meta_keywords']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'post_id=" . (int)$post_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('post');
        return $post_id;
	}
	
	/**
	 * ModelContentPage::deletePage()
	 * 
	 * @param int $post_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function deletePage($post_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "post WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "'");

		$this->cache->delete('post');
	}	

	/**
	 * ModelContentPage::getPage()
	 * 
	 * @param int $post_id
     * @see DB
	 * @return array sql record
	 */
	public function getPage($post_id) {
	   $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "') AS keyword 
            FROM " . DB_PREFIX . "post  p
            LEFT JOIN ". DB_PREFIX . "post_description pd ON (pd.post_id=p.post_id) 
            WHERE p.post_id = '" . (int)$post_id . "' 
            AND post_type = 'page'");
		  return $query->row;
	}
		
	/**
	 * ModelContentPage::_getPages()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function _getPages($parent_id) {
		$post_data = $this->cache->get('post_admin.' . $this->config->get('config_language_id') . '.' . $parent_id);
	
		if (!$post_data) {
			$post_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post c 
                LEFT JOIN " . DB_PREFIX . "post_description cd ON (c.post_id = cd.post_id) 
            WHERE c.parent_id = '" . (int)$parent_id . "' 
                AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND post_type = 'page' 
            ORDER BY c.sort_order, cd.title ASC");
		
			foreach ($query->rows as $result) {
				$post_data[] = array(
					'post_id' => $result['post_id'],
					'title'        => $this->getPath($result['post_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$post_data = array_merge($post_data, $this->getCategories($result['post_id']));
			}	
	
			$this->cache->set('post_admin.' . $this->config->get('config_language_id') . '.' . $parent_id, $post_data);
		}
		
		return $post_data;
	}
	
	/**
	 * ModelContentPage::getAll()
	 * 
	 * @param int $parent_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAll($parent_id=0, $data=array()) {
		      
			$sql = "SELECT * 
            FROM " . DB_PREFIX . "post c 
                LEFT JOIN " . DB_PREFIX . "post_description cd ON (c.post_id = cd.post_id) 
            WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            AND post_type = 'page' 
            AND parent_id = '". (int)$parent_id ."'
             ORDER BY c.sort_order, cd.title ASC";
			
            $query = $this->db->query($sql);
		return $query->rows;
	}
	
	/**
	 * ModelStoreCategory::getPath()
	 * 
	 * @param int $post_id
	 * @return string 
	 */
	public function getPath($post_id) {
		$query = $this->db->query("SELECT title, parent_id 
        FROM " . DB_PREFIX . "post c 
            LEFT JOIN " . DB_PREFIX . "post_description cd ON (c.post_id = cd.post_id) 
        WHERE c.post_id = '" . (int)$post_id . "' 
            AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            AND post_type = 'page' 
        ORDER BY c.sort_order, cd.title ASC");
		
		$post_info = $query->row;
		
		if ($post_info['parent_id']) {
			return $this->getPath($post_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $post_info['title'];
		} else {
			return $post_info['title'];
		}
	}
	
	/**
	 * ModelContentPage::getPages()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getPages($data = array()) {
			$sql = "SELECT * FROM " . DB_PREFIX . "post pa 
            LEFT JOIN " . DB_PREFIX . "post_description pad ON (pa.post_id = pad.post_id) 
            WHERE pad.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            AND post_type = 'page' ";
            
		if ($data) {
		
    		$implode = array();
    		
    		if (isset($data['filter_title']) && !is_null($data['filter_title'])) {
    			$implode[] = "LCASE(title) LIKE '%" . $this->db->escape($data['filter_title']) . "%'";
    		}
    		
    		if (isset($data['filter_parent']) && !is_null($data['filter_parent'])) {
    			$implode[] = "parent_id = (SELECT post_id FROM " . DB_PREFIX . "post pa 
                LEFT JOIN " . DB_PREFIX . "post_description pad ON (pa.post_id = pad.post_id) 
                WHERE pad.language_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND post_type = 'page' 
                AND LCASE(title) LIKE '%" . $this->db->escape($data['filter_parent']) . "%')";
    		}
    		
    		if ($data['filter_date_start'] && $data['filter_date_end']) {
                $implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s',strtotime($data['filter_date_end'])) . "'";
    		} elseif ($data['filter_date_start']) {
                $implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
    		}
    
    		if ($implode) {
    			$sql .= " AND " . implode(" AND ", $implode);
    		}
    		
			$sort_data = array(
				'title',
				'date_publish_start',
				'date_publish_end',
				'pa.sort_order'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY title";	
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
	}
	
	/**
	 * ModelContentPage::getPageDescriptions()
	 * 
	 * @param int $post_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getPageDescriptions($post_id) {
		$post_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_description pd
        LEFT JOIN " . DB_PREFIX . "post p ON (pd.post_id =p.post_id) 
        WHERE pd.post_id = '" . (int)$post_id . "' AND p.`post_type` = 'page'");
		foreach ($query->rows as $result) {
			$post_description_data[$result['language_id']] = array(
				'title'       => $result['title'],
				'description' => $result['description'],
				'seo_title'   => $result['seo_title'],
				'meta_keywords' => $result['meta_keywords'],
				'meta_description' => $result['meta_description']
			);
		}
		
		return $post_description_data;
	}
	
	/**
	 * ModelContentPage::getTotalPages()
	 * 
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalPages() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post WHERE post_type = 'page'");
		
		return $query->row['total'];
	}	
    
	/**
	 * ModelContentProduct::sortProduct()
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function sortPage($data) {
	   if (!is_array($data)) return false;
       $pos = 1;
       foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "post SET sort_order = '" . (int)$pos . "' WHERE post_id = '" . (int)$id . "' AND post_type = 'page'");
            $pos++;
       }
	   return true;
	}
	
    /**
     * ModelContentProduct::activate()
     * activar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function activate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "post` SET `status` = '1' WHERE `post_id` = '" . (int)$id . "' AND post_type = 'page'");
        return $query;
     }
    
    /**
     * ModelContentProduct::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "post` SET `status` = '0' WHERE `post_id` = '" . (int)$id . "' AND post_type = 'page'");
        return $query;
     }
}
