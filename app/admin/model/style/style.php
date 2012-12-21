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
class ModelStyleStyle extends Model {
    
	public function getStyles($group) {
		$data = array(); 
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'style_" . $this->db->escape($group) . "'");
		
		foreach ($query->rows as $result) {
			$data[$result['key']] = $result['value'];
		}
				
		return $data;
	}
	
	public function edit($group,$data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = 'style_" . $this->db->escape($group) . "'");
		foreach ($data as $key => $value) {		  
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `group` = 'style_" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
		}
        return $this->db->countAffected();
	}
    
	public function delete($group) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = 'style_" . $this->db->escape($group) . "'");
	}
	
}
