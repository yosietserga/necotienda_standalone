<?php
class ModelMarketingCampaign extends Model {
	public function trackEmail($campaign_id,$contact_id) {
	    $this->load->library('browser');
        $browser = new Browser;
		$this->db->query("INSERT " . DB_PREFIX . "campaign_stat SET 
        `campaign_id`   = '". (int)$campaign_id ."',
        `contact_id`    = '". (int)$contact_id ."',
        `customer_id`   = '". (int)$this->customer->getId() ."',
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
	
	public function trackLink($campaign_id,$contact_id,$link) {
	    $this->load->library('browser');
        $browser = new Browser;
		$this->db->query("INSERT " . DB_PREFIX . "campaign_link_stat SET 
        `campaign_id`   = '". (int)$campaign_id ."',
        `contact_id`    = '". (int)$contact_id ."',
        `customer_id`   = '". (int)$this->customer->getId() ."',
        `link`          = '". $this->db->escape($link) ."',
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
    
	public function getLink($link) {
		$result = $this->db->query("SELECT DISTINCT `redirect` FROM " . DB_PREFIX . "campaign_link WHERE link = '". $this->db->escape($link) ."'");
        return $result->row['redirect'];
	}
}
