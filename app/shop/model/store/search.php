<?php
class ModelStoreSearch extends Model {
	public function add() {
        $this->load->library('browser');
        $browser = new Browser;
        $sql = "INSERT INTO " . DB_PREFIX . "search SET 
            `customer_id`   = '". (int)$this->customer->getId() ."',
            store_id   = '" . (int)STORE_ID . "', 
            `request`       = '". $this->db->escape(serialize($_REQUEST)) ."',
            `urlQuery`      = '". $this->db->escape($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) ."',
            `browser`       = '". $this->db->escape($browser->getBrowser()) ."',
            `browser_version`= '". $this->db->escape($browser->getVersion()) ."',
            `os`            = '". $this->db->escape($browser->getPlatform()) ."',
            `ip`            = '". $this->db->escape($_SERVER['REMOTE_ADDR']) ."',
            `date_added`    = NOW()";
            
        $sql = str_replace("%sql",$this->db->escape($sql),$sql);
        
		$this->db->query($sql);
        
        $search_id = $this->db->getLastId();
        
        return $search_id;
	}
}