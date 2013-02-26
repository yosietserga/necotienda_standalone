<?php
/**
 * ModelContentPost
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelContentPost extends Model {
	/**
	 * ModelContentPost::addPost()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function addPost($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "post SET 
        parent_id   = '0', 
        post_type   = 'post', 
        publish     = '" . (int)$this->request->post['publish'] . "', 
        date_publish_start = '" . $this->db->escape($value['date_publish_start']) . "', 
        date_publish_end = '" . $this->db->escape($value['date_publish_end']) . "', 
        template    = '" . $this->db->escape($value['template']) . "', 
        status      = '1', 
        date_added  = NOW()");

		$post_id = $this->db->getLastId(); 
			
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
		
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
            query = 'post_id=" . (int)$post_id . "', 
            keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('post');
        return $post_id;
	}
	
	/**
	 * ModelContentPost::editPost()
	 * 
	 * @param int $post_id
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function editPost($post_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "post SET 
        parent_id   = '0',
        publish     = '" . (int)$this->request->post['publish'] . "', 
        date_publish_start = '" . $this->db->escape($value['date_publish_start']) . "', 
        date_publish_end = '" . $this->db->escape($value['date_publish_end']) . "', 
        template    = '" . $this->db->escape($value['template']) . "', 
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
	}
	
	/**
	 * ModelContentPost::deletePost()
	 * 
	 * @param int $post_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function deletePost($post_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "post WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "'");

		$this->cache->delete('post');
	}	

	/**
	 * ModelContentPost::getPost()
	 * 
	 * @param int $post_id
     * @see DB
	 * @return array sql record
	 */
	public function getPost($post_id) {
	   $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "') AS keyword 
            FROM " . DB_PREFIX . "post p
            LEFT JOIN ". DB_PREFIX . "post_description pd ON (pd.post_id=p.post_id) 
            WHERE p.post_id = '" . (int)$post_id . "' 
            AND p.`post_type` = 'post'");
		  return $query->row;
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
            AND post_type = 'post' 
            AND parent_id = '". (int)$parent_id ."'
             ORDER BY c.sort_order, cd.title ASC";
			
            $query = $this->db->query($sql);
		return $query->rows;
	}
	
	/**
	 * ModelContentPost::getPosts()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getPosts($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "post pa 
            LEFT JOIN " . DB_PREFIX . "post_description pad ON (pa.post_id = pad.post_id) 
            WHERE pad.language_id = '" . (int)$this->config->get('config_language_id') . "'
            AND post_type = 'post'";
		
			$sort_data = array(
				'title',
				'publish',
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
		} else {
			$post_data = $this->cache->get('post.' . $this->config->get('config_language_id'));
		
			if (!$post_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post pa 
                LEFT JOIN " . DB_PREFIX . "post_description pad ON (pa.post_id = pad.post_id) 
                WHERE pad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pad.title");
	
				$post_data = $query->rows;
			
				$this->cache->set('post.' . $this->config->get('config_language_id'), $post_data);
			}	
	
			return $post_data;			
		}
	}
	
	/**
	 * ModelContentPost::getPostsByCategoryId()
	 * 
	 * @param int $id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getPostsByCategoryId($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post p 
        LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) 
        LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p.post_id = p2c.post_id) 
        WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND p2c.category_id = '" . (int)$id . "' 
        AND post_type = 'post'
        ORDER BY pd.name ASC");
								  
		return $query->rows;
	} 
	
	/**
	 * ModelContentPost::getPostDescriptions()
	 * 
	 * @param int $post_id
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getPostDescriptions($post_id) {
		$post_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_description pd
        LEFT JOIN " . DB_PREFIX . "post p ON (pd.post_id =p.post_id) 
        WHERE pd.post_id = '" . (int)$post_id . "' AND p.`post_type` = 'post'");

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
	 * ModelContentPost::getTotalPosts()
	 * 
     * @see DB
	 * @return int Count sql records
	 */
	public function getTotalPosts() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post");
		
		return $query->row['total'];
	}	
    
	/**
	 * ModelContentProduct::sortProduct()
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function sortPost($data) {
	   if (!is_array($data)) return false;
       $pos = 1;
       foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "post SET sort_order = '" . (int)$pos . "' WHERE post_id = '" . (int)$id . "'");
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
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "post` SET `status` = '1' WHERE `post_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelContentProduct::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "post` SET `status` = '0' WHERE `post_id` = '" . (int)$id . "'");
        return $query;
     }
}
