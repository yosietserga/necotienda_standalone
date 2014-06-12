<?php
/**
 * ModelModuleLayerSlider
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelModuleLayerSlider extends Model {
	/**
	 * ModelModuleLayerSlider::add()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "layer_slider SET 
        `name`              = '" . $this->db->escape($data['name']) . "', 
        `jquery_plugin`     = '" . $this->db->escape($data['jquery_plugin']) . "', 
        `params`            = '" . $this->db->escape($data['params']) . "', 
        `publish_date_start`= '" . $this->db->escape($data['publish_date_start']) . "', 
        `publish_date_end`  = '" . $this->db->escape($data['publish_date_end']) . "', 
        `status`            = '1', 
        `date_added`        = NOW()");
        
		$layer_slider_id = $this->db->getLastId();
		
        foreach ($data['stores'] as $store) {
    		$this->db->query("INSERT INTO " . DB_PREFIX . "layer_slider_to_store SET 
            store_id       = '" . intval($store) . "', 
            layer_slider_id        = '" . intval($layer_slider_id) . "'");
        }
        
        foreach ($data['items'] as $key => $item) {
    		$this->db->query("INSERT INTO " . DB_PREFIX . "layer_slider_item SET 
            `layer_slider_id`  = '" . intval($layer_slider_id) . "', 
            `sort_order` = '" . intval($item['sort_order']) . "', 
            `status`     = '1', 
            `image`      = '" . $this->db->escape($item['image']) . "',
            `link`       = '" . $this->db->escape($item['link']) . "'");
            
            $layer_slider_item_id = $this->db->getLastId();
            
            foreach ($item['descriptions'] as $language_id => $description) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "layer_slider_item_description SET 
                `layer_slider_item_id`= '" . intval($layer_slider_item_id) . "', 
                `language_id`   = '" . intval($language_id) . "',
                `title`         = '" . $this->db->escape($description['title']) . "',
                `description`   = '" . $this->db->escape($description['description']) . "'");
            }
            
        }
        
		$this->cache->delete('layer_slider');
        return $layer_slider_id;
	}
	
	/**
	 * ModelModuleLayerSlider::update()
	 * 
	 * @param int $id
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function update($layer_slider_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "layer_slider SET 
        `name`              = '" . $this->db->escape($data['name']) . "', 
        `jquery_plugin`     = '" . $this->db->escape($data['jquery_plugin']) . "', 
        `params`            = '" . $this->db->escape($data['params']) . "', 
        `publish_date_start`= '" . $this->db->escape($data['publish_date_start']) . "', 
        `publish_date_end`  = '" . $this->db->escape($data['publish_date_end']) . "', 
        `date_modified`        = NOW()
        WHERE layer_slider_id = '". (int)$layer_slider_id ."'");
        
            $this->db->query("DELETE FROM " . DB_PREFIX . "layer_slider_to_store WHERE layer_slider_id = '". (int)$layer_slider_id ."'");
            foreach ($data['stores'] as $store) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "layer_slider_to_store SET 
                store_id  = '". intval($store) ."', 
                layer_slider_id = '". intval($layer_slider_id) ."'");
            }
        
        $this->db->query("DELETE FROM ". DB_PREFIX ."layer_slider_item_description WHERE layer_slider_item_id IN (SELECT layer_slider_item_id FROM ". DB_PREFIX ."layer_slider_item WHERE layer_slider_id = '". (int)$layer_slider_id ."')");
        $this->db->query("DELETE FROM ". DB_PREFIX ."layer_slider_item WHERE layer_slider_id = '". (int)$layer_slider_id ."'");
        foreach ($data['items'] as $key => $item) {
    		$this->db->query("INSERT INTO " . DB_PREFIX . "layer_slider_item SET 
            `layer_slider_id`  = '" . intval($layer_slider_id) . "', 
            `sort_order` = '" . intval($item['sort_order']) . "', 
            `image`      = '" . $this->db->escape($item['image']) . "',
            `link`       = '" . $this->db->escape($item['link']) . "'");
            
            $layer_slider_item_id = $this->db->getLastId();
            
            foreach ($item['descriptions'] as $language_id => $description) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "layer_slider_item_description SET 
                `layer_slider_item_id`= '" . intval($layer_slider_item_id) . "', 
                `language_id`   = '" . intval($language_id) . "',
                `title`         = '" . $this->db->escape($description['title']) . "',
                `description`   = '" . $this->db->escape($description['description']) . "'");
            }
            
        }
        
		$this->cache->delete('layer_slider');
	}
	
	/**
	 * ModelModuleLayerSlider::delete()
	 * 
	 * @param int $id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function delete($id) {
		$this->db->query("DELETE FROM ". DB_PREFIX ."layer_slider WHERE layer_slider_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM ". DB_PREFIX ."layer_slider_to_store WHERE layer_slider_id = '". (int)$layer_slider_id ."'");
        $this->db->query("DELETE FROM ". DB_PREFIX ."layer_slider_item_description WHERE layer_slider_item_id IN (SELECT layer_slider_item_id FROM ". DB_PREFIX ."layer_slider_item WHERE layer_slider_id = '". (int)$layer_slider_id ."')");
        $this->db->query("DELETE FROM ". DB_PREFIX ."layer_slider_item WHERE layer_slider_id = '". (int)$layer_slider_id ."'");
	}
	
	/**
	 * ModelModuleLayerSlider::getById()
	 * 
	 * @param int $layer_slider_id
     * @see DB
     * @see Cache
	 * @return array sql record
	 */
	public function getById($layer_slider_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "layer_slider WHERE layer_slider_id = '" . (int)$layer_slider_id . "'");
        $return = $query->row;
        $return['layer_slider_items']  = $this->getItems($layer_slider_id);
        $return['layer_slider_stores'] = $this->getStores($layer_slider_id);
		return $return;
	}
	
	/**
	 * ModelModuleCategory::getItems()
	 * 
	 * @param int $layer_slider_id
     * @see DB
	 * @return array sql records
	 */
	public function getItems($layer_slider_id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layer_slider_item WHERE layer_slider_id = '" . (int)$layer_slider_id . "'");
		foreach ($query->rows as $key => $result) {
            $data[$key] = $result;
            $data[$key]['descriptions'] = $this->getDescriptions($result['layer_slider_item_id']);
		}
		return $data;
	}	
	
	/**
	 * ModelModuleCategory::getDescriptions()
	 * 
	 * @param int $slider_id
     * @see DB
	 * @return array sql records
	 */
	public function getDescriptions($layer_slider_item_id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layer_slider_item_description WHERE layer_slider_item_id = '" . (int)$layer_slider_item_id . "'");
		foreach ($query->rows as $result) {
			$data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description']
			);
		}
		return $data;
	}	
	
	public function getStores($id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layer_slider_to_store WHERE layer_slider_id = '" . (int)$id . "'");
		foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
		}
		return $data;
	}	
	
	/**
	 * ModelModuleLayerSlider::getAll()
	 * 
	 * @param mixed $data
     * @see DB
     * @see Cache
	 * @return array sql records
	 */
	public function getAll($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "layer_slider ";
        
        $criteria = array();
        
        if (!empty($data['filter_name'])) {
            $criteria[] = "LCASE(name) LIKE '%". $this->db->escape(strtolower($data['filter_name'])) ."%'";
        }
        
        if (!empty($data['filter_plugin'])) {
            $criteria[] = "LCASE(jquery_plugin) LIKE '%". $this->db->escape(strtolower($data['filter_plugin'])) ."%'";
        }
        
		if (!empty($data['filter_date_start'])) {
            $criteria[] = "publish_date_start >= '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "'";
		}
        
		if (!empty($data['filter_date_end'])) {
            $criteria[] = "publish_date_end <= '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "'";
		}
        
        if ($criteria) {
            $sql .= " WHERE ". implode(" AND ",$criteria);
        }

        $sort_data = array(
            'name',
			'publish_date_start',
			'publish_date_end'
        );	
			
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
            $sql .= " ORDER BY name";	
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
	 * ModelModuleLayerSlider::getTotal()
	 * 
	 * @param int $id
     * @see DB
     * @see Cache
	 * @return array sql record
	 */
	public function getTotal($product_id) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "layer_slider ";
        
        $criteria = array();
        
        if (!empty($data['filter_name'])) {
            $criteria[] = "LCASE(name) LIKE '%". $this->db->escape(strtolower($data['filter_name'])) ."%'";
        }
        
        if (!empty($data['filter_plugin'])) {
            $criteria[] = "LCASE(jquery_plugin) LIKE '%". $this->db->escape(strtolower($data['filter_plugin'])) ."%'";
        }
        
		if (!empty($data['filter_date_start'])) {
            $criteria[] = "publish_date_start >= '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "'";
		}
        
		if (!empty($data['filter_date_end'])) {
            $criteria[] = "publish_date_end <= '" . date('Y-m-d h:i:s',strtotime($data['filter_date_start'])) . "'";
		}
        
        if ($criteria) {
            $sql .= " WHERE ". implode(" AND ",$criteria);
        }

		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	
	/**
	 * ModelModuleLayerSlider::sortLayerSlider()
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function sortLayerSlider($data) {
	   if (!is_array($data)) return false;
       $pos = 1;
       foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "layer_slider SET sort_order = '" . (int)$pos . "' WHERE layer_slider_id = '" . (int)$id . "'");
            $pos++;
       }
	   return true;
	}

    /**
     * ModelModuleLayerSlider::activate()
     * activar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function activate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "layer_slider` SET `status` = '1' WHERE `layer_slider_id` = '" . (int)$id . "'");
        return $query;
     }
    
    /**
     * ModelModuleLayerSlider::desactivate()
     * desactivar un objeto
     * @param integer $id del objeto
     * @return boolean
     * */
     public function desactivate($id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "layer_slider` SET `status` = '0' WHERE `layer_slider_id` = '" . (int)$id . "'");
        return $query;
     }
     
	/**
	 * ModelModuleLayerSlider::install()
	 * 
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "layer_slider` (
          `layer_slider_id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(250) NOT NULL,
          `params` text NOT NULL,
          `publish_date_start` date NOT NULL,
          `publish_date_end` date NOT NULL,
          `status` int(1) NOT NULL,
          `date_added` datetime NOT NULL,
          `date_modified` datetime NOT NULL,
          PRIMARY KEY (`layer_slider_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "layer_slider_item` (
          `layer_slider_item_id` int(11) NOT NULL AUTO_INCREMENT,
          `layer_slider_id` int(11) NOT NULL,
          `content_type` varchar(250) NOT NULL,
          `content` varchar(250) NOT NULL,
          `params` text NOT NULL,
          `sort_order` int(11) NOT NULL,
          PRIMARY KEY (`layer_slider_item_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
	}
    
	/**
	 * ModelModuleLayerSlider::uninstall()
	 * 
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function uninstall() {
		$this->db->query("DROP TABLE `" . DB_PREFIX . "layer_slider`;");
		$this->db->query("DROP TABLE `" . DB_PREFIX . "layer_slider_item`;");
	}
	
}