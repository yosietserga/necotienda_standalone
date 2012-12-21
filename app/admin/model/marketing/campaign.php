<?php
/**
 * ModelMarketingCampaign
 * 
 * @package NecoTienda
 * @author Inversiones Necoyoad, C.A.
 * @copyright 2010
 * @version $Id$
 * @access public
 */
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
        return $id;
	}
	
	/**
	 * ModelMarketingCampaign::update()
     * 
	 * Actualiza la información de la campaña en la base de datos y coloca todos los
     * enlaces a la url completa
     * 
     * @see DB::escape()
     * @see DB::query()
     * @see DB::getLastId()
	 * @return void
	 */
	public function update($newsletter_id, $data) {
      	return $this->db->query("UPDATE " . DB_PREFIX . "newsletter SET 
          `name`        = '" . $this->db->escape($data['name']) . "',
          `textbody`    = '" . $this->db->escape($data['textbody']) . "',
          `htmlbody`    = '" . $this->db->escape($data['htmlbody']) . "',
          `date_modified`  = NOW() 
          WHERE `newsletter_id` = '".(int)$newsletter_id."'");
	}
    
    public function copy($newsletter_id) {
      $result = $this->db->query("INSERT INTO " . DB_PREFIX . "newsletter (
              `name`,
              `textbody`,
              `htmlbody`,
              `status`
          )
       SELECT 
          CONCAT(`name`,' (copia)'),
          `textbody`,
          `htmlbody`,
          `status`
       FROM " . DB_PREFIX . "newsletter 
       WHERE `newsletter_id` = '".(int)$newsletter_id."'");
        $newsletters_id = $this->db->getLastId();
        return $this->db->query("UPDATE " . DB_PREFIX . "newsletter SET `date_added` = NOW() WHERE `newsletter_id` = '".(int)$newsletter_id."'");
	}
    
    /**
     * ModelMarketingCampaign::delete()
     * 
     * @return
     */
    public function delete($newsletter_id) {
		//TODO: validar que no tenga trabajos de envío pendientes, si es así mostrar una confirmación            
        $this->db->query("DELETE FROM " . DB_PREFIX . "newsletter WHERE `newsletter_id` = '".(int)$newsletter_id."'");
	}
    
	/**
	 * ModelMarketingCampaign::addLink()
     * Registra un enlace a la campaña para rastrearlo
     * 
     * @see DB::escape()
     * @see DB::query()
     * @see DB::getLastId()
	 * @return int $newsletter_id
	 */
	public function addLink($data,$id) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "campaign_link SET 
          `campaign_id` = '" . (int)$id . "',
          `url`         = '" . $this->db->escape($data['url']) . "',
          `redirect`    = '" . $this->db->escape($data['redirect']) . "',
          `link`        = '" . $this->db->escape($data['link_index']) . "',
          `date_added`  = NOW()");
	}
	
    /**
     * ModelMarketingCampaign::getCampaign()
     * 
     * @return
     */
    public function getById($newsletter_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "newsletter WHERE newsletter_id = '" . (int)$newsletter_id . "'");
		return $query->row;
    }
	
    /**
     * ModelMarketingCampaign::getCampaigns()
     * 
     * @return
     */
    public function getAll($data = array()) {	
	    $sql = "SELECT * FROM " . DB_PREFIX . "newsletter ";

		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'name',
			'subject',
			'active',
			'archive',
			'date_added'
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
	 * ModelMarketingCampaign::getTotalCampaigns()
	 * 
	 * @return
	 */
	public function getTotalCampaigns($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "newsletter";
		
		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_subject']) && !is_null($data['filter_subject'])) {
			$implode[] = "subject = '" . $this->db->escape($data['filter_subject']) . "'";
		}	
		
		if (isset($data['filter_active']) && !is_null($data['filter_active'])) {
			$implode[] = "active = '" . $this->db->escape($data['filter_active']) . "'";
		}	
		
		if (isset($data['filter_archive']) && !is_null($data['filter_archive'])) {
			$implode[] = "archive = '" . $this->db->escape($data['filter_archive']) . "'";
		}				
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
				
		$query = $this->db->query($sql);
				
		return $query->row['total'];
	}

    /**
     * ModelMarketingCampaign::setMembersBanned()
     * 
     * @return
     */
    public function activate($newsletter_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "newsletter SET status = '1' WHERE newsletter_id = '" . (int)$newsletter_id . "'");
	}

    /**
     * ModelMarketingCampaign::getActive()
     * 
     * @return
     */
    public function desactivate($newsletter_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "newsletter SET status = '0' WHERE newsletter_id = '" . (int)$newsletter_id . "'");
	}
}
