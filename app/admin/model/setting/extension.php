<?php
/**
 * ModelSettingExtension
 * 
 * @package   
 * @author NecoTienda
 * @copyright Inversiones Necoyoad, C.A.
 * @version 2010
 * @access public
 */
class ModelSettingExtension extends Model {
	/**
	 * ModelSettingExtension::getInstalled()
	 * 
	 * @param string $type
     * @see DB
	 * @return array sql records
	 */
	public function getInstalled($type) {
		$extension_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "'");
		
		foreach ($query->rows as $result) {
			$extension_data[] = $result['key'];
		}
		
		return $extension_data;
	}

	/**
	 * ModelSettingExtension::isInstalled()
	 *
	 * @param string $ext
	 * @param string $type
     * @see DB
	 * @return array sql record
	 */
	public function isInstalled($ext, $type='module') {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `key` = '" . $this->db->escape($ext) . "' AND `type` = '" . $this->db->escape($type) . "'");

		return $query->row;
	}

	/**
	 * ModelSettingExtension::install()
	 * 
	 * @param string $type
	 * @param string $key
     * @see DB
	 * @return void
	 */
	public function install($type, $key) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "extension SET `type` = '" . $this->db->escape($type) . "', `key` = '" . $this->db->escape($key) . "'");
	}
	
	/**
	 * ModelSettingExtension::uninstall()
	 * 
	 * @param string $type
	 * @param string $key
     * @see DB
	 * @return void
	 */
	public function uninstall($type, $key) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "' AND `key` = '" . $this->db->escape($key) . "'");
	}
}
