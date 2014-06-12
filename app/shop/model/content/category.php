<?php
class ModelContentCategory extends Model {
	public function getById($id) {
		$query = $this->db->query("SELECT DISTINCT * 
        FROM " . DB_PREFIX . "post_category pc 
        LEFT JOIN " . DB_PREFIX . "post_category_description pcd ON (pc.post_category_id = pcd.post_category_id) 
        LEFT JOIN " . DB_PREFIX . "post_category_to_store pc2s ON (pc.post_category_id = pc2s.post_category_id) 
        WHERE pc.post_category_id = '" . (int)$id . "' 
        AND pc2s.store_id = '". (int)STORE_ID ."' 
        AND pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND pc.status = '1'");
		return $query->row;
	}
    
	public function getTotalById($id) {
		$query = $this->db->query("SELECT COUNT(*) AS total
        FROM " . DB_PREFIX . "post_category pc 
        LEFT JOIN " . DB_PREFIX . "post_category_description pcd ON (pc.post_category_id = pcd.post_category_id) 
        LEFT JOIN " . DB_PREFIX . "post_category_to_store pc2s ON (pc.post_category_id = pc2s.post_category_id) 
        WHERE pc.parent_id = '" . (int)$id . "' 
        AND pc2s.store_id = '". (int)STORE_ID ."' 
        AND pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND pc.status = '1'");
		return $query->row['total'];
	}
	
	public function getAllById($id) {
		$query = $this->db->query("SELECT * 
        FROM " . DB_PREFIX . "post_category pc 
        LEFT JOIN " . DB_PREFIX . "post_category_description pcd ON (pc.post_category_id = pcd.post_category_id) 
        LEFT JOIN " . DB_PREFIX . "post_category_to_store pc2s ON (pc.post_category_id = pc2s.post_category_id) 
        WHERE pc.parent_id = '" . (int)$id . "' 
        AND pc2s.store_id = '". (int)STORE_ID ."' 
        AND pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND pc.status = '1'");
		return $query->rows;
	}
	
	public function updateStats($id) {
	   $this->load->library('browser');
       $browser = new Browser;
		$this->db->query("UPDATE " . DB_PREFIX . "post SET viewed = viewed + 1 WHERE post_id = '" . (int)$id . "'");
		$this->db->query("INSERT " . DB_PREFIX . "stat SET 
        `object_id`     = '". (int)$id ."',
        `store_id`      = '". (int)STORE_ID ."',
        `customer_id`   = '". (int)$this->customer->getId() ."',
        `object_type`   = 'post_category',
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
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_category_property 
        WHERE `post_category_id` = '" . (int)$id . "' 
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
    		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_category_property 
            WHERE `post_category_id` = '" . (int)$id . "'");
        } else {
    		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_category_property 
            WHERE `post_category_id` = '" . (int)$id . "' 
            AND `group` = '". $this->db->escape($group) ."'");
        }
        
		return $query->rows;
	}
}
