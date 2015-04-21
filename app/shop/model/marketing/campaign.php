<?php
class ModelMarketingCampaign extends Model {
    
	/**
	 * ModelMarketingCampaign::add()
     * 
	 * Registra la información de la campaña en la base de datos y coloca todos los
     * enlaces a la url completa
     * 
     * @see DB::escape()
     * @see DB::query()
     * @see DB::getLastId()
	 * @return int $newsletter_id
	 */
	public function add($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "campaign SET 
          `newsletter_id`        = '" . (int)$data['newsletter_id'] . "',
          `name`            = '" . $this->db->escape($data['name']) . "',
          `subject`         = '" . $this->db->escape($data['subject']) . "',
          `from_name`       = '" . $this->db->escape($data['from_name']) . "',
          `from_email`      = '" . $this->db->escape($data['from_email']) . "',
          `replyto_email`   = '" . $this->db->escape($data['replyto_email']) . "',
          `trace_email`     = '" . (int)$data['trace_email'] . "',
          `trace_click`     = '" . (int)$data['trace_click'] . "',
          `embed_image`     = '" . (int)$data['embed_image'] . "',
          `repeat`          = '" . $this->db->escape($data['repeat']) . "',
          `date_start`      = '" . $this->db->escape($data['date_start']) . "',
          `date_end`        = '" . $this->db->escape($data['date_end']) . "',
          `date_added`      = NOW()");
        $id = $this->db->getLastId();
        
        if ($data['contacts']) {
            foreach ($data['contacts'] as $contact) {
              	$this->db->query("INSERT INTO " . DB_PREFIX . "campaign_contact SET 
                  `campaign_id`= '" . (int)$id . "',
                  `contact_id` = '" . (int)$contact['contact_id'] . "',
                  `name`       = '" . $this->db->escape($contact['name']) . "',
                  `email`      = '" . $this->db->escape($contact['email']) . "',
                  `status`     = 1");
            }
        }
        if ($data['links']) {
            foreach ($data['links'] as $link) {
              	$this->addLink($link,$id);
            }
        }
        return $id;
	}
	
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
    /**
     * ModelMarketingCampaign::getProperty()
     * 
     * Obtener una propiedad de la categoria
     * 
     * @param int $id campaign_id
     * @param varchar $group
     * @param varchar $key
     * @return mixed value of property
     * */
    public function getProperty($id, $group, $key) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "campaign_property 
        WHERE `campaign_id` = '" . (int) $id . "' 
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");

        return unserialize(str_replace("\'", "'", $query->row['value']));
    }

    /**
     * ModelMarketingCampaign::setProperty()
     * 
     * Asigna una propiedad de la categoria
     * 
     * @param int $id campaign_id
     * @param varchar $group
     * @param varchar $key
     * @param mixed $value
     * @return void
     * */
    public function setProperty($id, $group, $key, $value) {
        $this->deleteProperty($id, $group, $key);
        $this->db->query("INSERT INTO " . DB_PREFIX . "campaign_property SET
        `campaign_id`   = '" . (int) $id . "',
        `group`     = '" . $this->db->escape($group) . "',
        `key`       = '" . $this->db->escape($key) . "',
        `value`     = '" . $this->db->escape(str_replace("'", "\'", serialize($value))) . "'");
    }

    /**
     * ModelMarketingCampaign::deleteProperty()
     * 
     * Elimina una propiedad de la categoria
     * 
     * @param int $id campaign_id
     * @param varchar $group
     * @param varchar $key
     * @return void
     * */
    public function deleteProperty($id, $group, $key) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "campaign_property 
        WHERE `campaign_id` = '" . (int) $id . "' 
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");
    }

    /**
     * ModelMarketingCampaign::getAllProperties()
     * 
     * Obtiene todas las propiedades de la categoria
     * 
     * Si quiere obtener todos los grupos de propiedades
     * utilice * como nombre del grupo, ejemplo:
     * 
     * $properties = getAllProperties($campaign_id, '*');
     * 
     * Sino coloque el nombre del grupo de las propiedades
     * 
     * $properties = getAllProperties($campaign_id, 'NombreDelGrupo');
     * 
     * @param int $id campaign_id
     * @param varchar $group
     * @return array all properties
     * */
    public function getAllProperties($id, $group = '*') {
        if ($group == '*') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "campaign_property 
            WHERE `campaign_id` = '" . (int) $id . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "campaign_property 
            WHERE `campaign_id` = '" . (int) $id . "' 
            AND `group` = '" . $this->db->escape($group) . "'");
        }

        return $query->rows;
    }

    /**
     * ModelMarketingCampaign::setAllProperties()
     * 
     * Asigna todas las propiedades de la categoria
     * 
     * Pase un array con todas las propiedades y sus valores
     * eneplo:
     * 
     * $data = array(
     *    'key1'=>'abc',
     *    'key2'=>123,
     *    'key3'=>array(
     *       'subkey1'=>'value1'
     *    ),
     *    'key4'=>$object,
     * );
     * 
     * @param int $id campaign_id
     * @param varchar $group
     * @param array $data
     * @return void
     * */
    public function setAllProperties($id, $group, $data) {
        if (is_array($data) && !empty($data)) {
            $this->deleteAllProperties($id, $group);
            foreach ($data as $key => $value) {
                $this->setProperty($id, $group, $key, $value);
            }
        }
    }

    /**
     * ModelMarketingCampaign::deleteAllProperties()
     * 
     * Elimina todas las propiedades de la categoria
     * 
     * Si quiere eliminar todos los grupos de propiedades
     * utilice * como nombre del grupo, ejemplo:
     * 
     * $properties = deleteAllProperties($campaign_id, '*');
     * 
     * Sino coloque el nombre del grupo de las propiedades
     * 
     * $properties = deleteAllProperties($campaign_id, 'NombreDelGrupo');
     * 
     * @param int $id campaign_id
     * @param varchar $group
     * @param varchar $key
     * @return void
     * */
    public function deleteAllProperties($id, $group = '*') {
        if ($group == '*') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "campaign_property 
            WHERE `campaign_id` = '" . (int) $id . "'");
        } else {
            $this->db->query("DELETE FROM " . DB_PREFIX . "campaign_property 
            WHERE `campaign_id` = '" . (int) $id . "' 
            AND `group` = '" . $this->db->escape($group) . "'");
        }
    }
}
