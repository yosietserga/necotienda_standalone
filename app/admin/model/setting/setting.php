<?php 
/**
 * ModelSettingSetting
 * 
 * @package   
 * @author NecoTienda
 * @copyright Inversiones Necoyoad, C.A.
 * @version 2010
 * @access public
 */
class ModelSettingSetting extends Model {
	public function getSetting($group, $store_id=0) {
		$data = array();
		$query = $this->db->query("SELECT * 
        FROM " . DB_PREFIX . "setting 
        WHERE `group` = '" . $this->db->escape($group) . "' 
        AND store_id = '". (int)$store_id ."'");
		foreach ($query->rows as $result) {
			$data[$result['key']] = $result['value'];
		}
		return $data;
	}
	
	public function update($group, $data, $store_id=0) {
		$this->db->query("DELETE 
        FROM " . DB_PREFIX . "setting 
        WHERE `group` = '" . $this->db->escape($group) . "' 
        AND store_id = '". (int)$store_id ."'");
        
		foreach ($data as $key => $value) {		  
		if ($key == 'config_bounce_password' && !empty($value)) $value = base64_encode($value); 
		if ($key == 'config_smtp_password' && !empty($value)) $value = base64_encode($value); 
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
		}
	}
    
	public function updateProperty($group, $key, $data, $store_id=0) {
		$this->db->query("REPLACE INTO " . DB_PREFIX . "setting SET 
        `group` = '" . $this->db->escape($group) . "',
        `key`   = '". $this->db->escape($key) ."',
        `value` = '" . $this->db->escape($data) . "',
        `store_id` = '". (int)$store_id ."'");
	}
    
    public function editMaintenance($data,$group = 'config', $store_id=0) {		
    	$this->db->query("UPDATE " . DB_PREFIX . "setting SET 
        `value` = '" . $this->db->escape($data) . "' 
        WHERE `key` = 'config_maintenance' 
        AND store_id = '". (int)$store_id ."'");
	}
	
	public function delete($group, $store_id=0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting 
        WHERE `group` = '" . $this->db->escape($group) . "' 
        AND store_id = '". (int)$store_id ."'");
	}
    
	/**
	 * ModelCatalogProduct::sortProduct()
	 * @param array $data
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function sortExtensions($data, $store_id=0) {
	   //TODO: acomodar para que ordene por módulo y por posición del módulo
	   /*
	   if (!is_array($data)) return false;
       $left = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `value` = 'left'");
       $right = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `value` = 'left'");
       $center = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `value` = 'left'");
       
       if ($left->num_rows) {
            foreach ($data as $k => $v) {
                if ($v['position'] != 'left') continue;
                if ($v['position'] != 'left') continue;
                
            }
       }
       **/
       $pos = 1;
       foreach ($data as $v) {
            $this->db->query("UPDATE " . DB_PREFIX . "setting SET 
            `value` = '" . (int)$pos . "' 
            WHERE `key` = '" . $this->db->escape($v['group']) . "_sort_order' 
            AND store_id = '". (int)$store_id ."'");
            $pos++;
       }
	   return true;
	}
}