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
      	$this->db->query("INSERT INTO " . DB_PREFIX . "campaign SET ".
          "`newsletter_id`        = '" . (int)$data['newsletter_id'] . "',".
          "`name`            = '" . $this->db->escape($data['name']) . "',".
          "`subject`         = '" . $this->db->escape($data['subject']) . "',".
          "`from_name`       = '" . $this->db->escape($data['from_name']) . "',".
          "`from_email`      = '" . $this->db->escape($data['from_email']) . "',".
          "`replyto_email`   = '" . $this->db->escape($data['replyto_email']) . "',".
          "`trace_email`     = '" . (int)$data['trace_email'] . "',".
          "`trace_click`     = '" . (int)$data['trace_click'] . "',".
          "`embed_image`     = '" . (int)$data['embed_image'] . "',".
          "`repeat`          = '" . $this->db->escape($data['repeat']) . "',".
          "`date_start`      = '" . $this->db->escape($data['date_start']) . "',".
          "`date_end`        = '" . $this->db->escape($data['date_end']) . "',".
          "`date_added`      = NOW()");

        $id = $this->db->getLastId();
        
        if ($data['contacts']) {
            $this->setContacts($id, $data['contacts']);
        }

        if ($data['links']) {
            foreach ($data['links'] as $link) {
              	$this->addLink($link,$id);
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
	public function update($id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "campaign SET ".
          "`newsletter_id`        = '" . (int)$data['newsletter_id'] . "',".
          "`name`            = '" . $this->db->escape($data['name']) . "',".
          "`subject`         = '" . $this->db->escape($data['subject']) . "',".
          "`from_name`       = '" . $this->db->escape($data['from_name']) . "',".
          "`from_email`      = '" . $this->db->escape($data['from_email']) . "',".
          "`replyto_email`   = '" . $this->db->escape($data['replyto_email']) . "',".
          "`trace_email`     = '" . (int)$data['trace_email'] . "',".
          "`trace_click`     = '" . (int)$data['trace_click'] . "',".
          "`embed_image`     = '" . (int)$data['embed_image'] . "',".
          "`repeat`          = '" . $this->db->escape($data['repeat']) . "',".
          "`date_start`      = '" . $this->db->escape($data['date_start']) . "',".
          "`date_end`        = '" . $this->db->escape($data['date_end']) . "',".
        "WHERE campaign_id = '". (int)$id ."'");
        
        if ($data['contacts']) {
            $this->setContacts($id, $data['contacts']);
        }
	}

    public function setContacts($id, $contacts) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "campaign_contact WHERE campaign_id = '". (int)$id ."'");
            foreach ($contacts as $contact) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "campaign_contact SET 
                  `campaign_id`= '" . (int)$id . "',
                  `contact_id` = '" . (int)$contact['contact_id'] . "',
                  `name`       = '" . $this->db->escape($contact['name']) . "',
                  `email`      = '" . $this->db->escape($contact['email']) . "',
                  `status`     = 1");
            }
    }
    
	/**
	 * ModelStoreProduct::copy()
	 * 
	 * @param int $product_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function copy($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "campaign WHERE campaign_id = '" . (int)$id . "'");
		
		if ($query->num_rows) {
			$data = array();
			$data = $query->row;
			$data['name'] = $data['name'] ." - copia";
			$data = array_merge($data, array('contacts' => $this->getContacts($id)));
			$data = array_merge($data, array('links' => $this->getLinks($id)));
			$this->add($data);
		}
	}
	
    /**
     * ModelMarketingCampaign::delete()
     * 
     * @return
     */
    public function delete($campaign_id) {

		//TODO: validar que no tenga trabajos de envío pendientes, si es así mostrar una confirmación
        $query = $this->db->query(
            "SELECT * FROM " . DB_PREFIX . "task_exec te ".
                "LEFT JOIN " . DB_PREFIX . "task t ON (te.task_id=t.task_id) ".
            "WHERE object_id = '".(int)$campaign_id."' ".
                "AND object_type = 'campaign'"
        );

        if (!$query->num_rows) {
            $shared_tables = array(
                'property',
                'stat',
                'task',
            );

            foreach ($shared_tables as $table) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                    "WHERE object_id  = ". (int)$campaign_id ." ".
                    "AND object_type = 'campaign'");
            }

            $this->db->query("DELETE FROM " . DB_PREFIX . "campaign WHERE `campaign_id` = '".(int)$campaign_id."'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "campaign_contact WHERE `campaign_id` = '".(int)$campaign_id."'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "task_queue WHERE `task_id` IN ( ".
                "SELECT task_id FROM ". DB_PREFIX ."task ".
                "WHERE object_id = '".(int)$campaign_id."' ".
                "AND object_type = 'campaign'".
            ")");

            $shared_tables = array(
                'property',
                'stat',
                'task',
            );

            foreach ($shared_tables as $table) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                    "WHERE object_id  = ". (int)$campaign_id ." ".
                    "AND object_type = 'campaign'");
            }

        } else {
          return false;
        }
	}
    
    public function getContacts($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "campaign_contact WHERE campaign_id = '" . (int)$id . "'");
        return $query->rows;
    }
    
    public function getLinks($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "campaign_link WHERE campaign_id = '" . (int)$id . "'");
        return $query->rows;
    }
    
    public function getTasks($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "task WHERE object_id = '" . (int)$id . "' AND object_type = 'campaign'");
        return $query->rows;
    }
    
    public function getNewsletter($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "newsletter WHERE newsletter_id = '" . (int)$id . "'");
        return $query->row;
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
	

    public function getById($id) {
        $result = $this->getAll(array(
            'campaign_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.campaigns";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->user->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT * FROM " . DB_PREFIX . "campaign t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.name',
                    'subject',
                    'active',
                    'archive',
                    't.date_added'
                );
            }
            $sql .= $this->buildSQLQuery($data, $sort_data);
            $query = $this->db->query($sql);

            $return = array();
            foreach ($query->rows as $result) {
                $return[] = array(
                    'campaign_id'   =>$result['campaign_id'],
                    'name'          =>$result['name'],
                    'subject'       =>$result['subject'],
                    'status'        =>$result['status'],
                    'date_added'    =>$result['date_added'],
                    'date_start'    =>$result['date_start'],
                    'date_end'      =>$result['date_end'],
                    'repeat'        =>$result['repeat'],
                    'newsletter'    =>$this->getNewsletter($result['newsletter_id']),
                    'contacts'      =>$this->getContacts($result['campaign_id']),
                    'links'         =>$this->getLinks($result['campaign_id']),
                    'tasks'         =>$this->getTasks($result['campaign_id'])
                );
            }
        

            $this->cache->set($cachedId, $return);
            return $return;
        } else {
            return $cached;
        }
    }

    public function getAllTotal($data=null) {
        $cache_prefix = "admin.campaigns.total";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->user->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "campaign t ";
            $sql .= $this->buildSQLQuery($data, null, true);
            $query = $this->db->query($sql);

            $this->cache->set($cachedId, $query->row['total']);

            return $query->row['total'];
        } else {
            return $cached;
        }
    }

    private function buildSQLQuery($data, $sort_data = null, $countAsTotal = false) {
        $criteria = array();
        $sql = "";

        $data['campaign_id'] = !is_array($data['campaign_id']) && !empty($data['campaign_id']) ? array($data['campaign_id']) : $data['campaign_id'];
        $data['newsletter_id'] = !is_array($data['newsletter_id']) && !empty($data['newsletter_id']) ? array($data['newsletter_id']) : $data['newsletter_id'];
        $data['newsletter_id'] = !is_array($data['newsletter_id']) && !empty($data['newsletter_id']) ? array($data['newsletter_id']) : $data['newsletter_id'];
        $data['contact_id'] = !is_array($data['contact_id']) && !empty($data['contact_id']) ? array($data['contact_id']) : $data['contact_id'];

        if (isset($data['contact_id']) || isset($data['contact_name']) || isset($data['contact_email'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "campaign_contact cc ON (t.campaign_id = cc.campaign_id) ";
        }

        if (isset($data['campaign_id']) && !empty($data['campaign_id'])) {
            $criteria[] = " t.campaign_id IN (" . implode(', ', $data['campaign_id']) . ") ";
        }

        if (isset($data['newsletter_id']) && !empty($data['newsletter_id'])) {
            $criteria[] = " t.newsletter_id IN (" . implode(', ', $data['newsletter_id']) . ") ";
        }

        if (isset($data['contact_id']) && !empty($data['contact_id'])) {
            $criteria[] = " cc.contact_id IN (" . implode(', ', $data['contact_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['subject']) && !empty($data['subject'])) {
            $criteria[] = " LCASE(t.`subject`) LIKE '%" . $this->db->escape(strtolower($data['subject'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['from_name']) && !empty($data['from_name'])) {
            $criteria[] = " LCASE(t.`from_name`) LIKE '%" . $this->db->escape(strtolower($data['from_name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['from_email']) && !empty($data['from_email'])) {
            $criteria[] = " LCASE(t.`from_email`) LIKE '%" . $this->db->escape(strtolower($data['from_email'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['replyto_email']) && !empty($data['replyto_email'])) {
            $criteria[] = " LCASE(t.`replyto_email`) LIKE '%" . $this->db->escape(strtolower($data['replyto_email'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (isset($data['contact_name']) && !empty($data['contact_name'])) {
            $criteria[] = " LCASE(cc.`name`) LIKE '%" . $this->db->escape(strtolower($data['contact_name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['contact_email']) && !empty($data['contact_email'])) {
            $criteria[] = " LCASE(cc.`email`) LIKE '%" . $this->db->escape(strtolower($data['contact_email'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.campaign_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'campaign' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.campaign_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.name";
                $sql .= ($data['order'] == 'DESC') ? " DESC" : " ASC";
            }

            if ($data['start'] && $data['limit']) {
                if ($data['start'] < 0) $data['start'] = 0;
                if (!$data['limit']) $data['limit'] = 24;

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            } elseif ($data['limit']) {
                if (!$data['limit']) $data['limit'] = 24;

                $sql .= " LIMIT ". (int)$data['limit'];
            }
        }
        return $sql;
    }

    public function activate($id) {
        return $this->__activate('campaign', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('campaign', $id);
	  }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('campaign', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('campaign', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('campaign', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('campaign', $id, $group);
    }

    public function setAllProperties($id, $group, $data) {
        if (is_array($data) && !empty($data)) {
            $this->deleteProperty($id, $group);
            foreach ($data as $key => $value) {
                $this->setProperty($id, $group, $key, $value);
            }
        }
    }
}
