<?php
/**
 * ModelMarketingNewsletter
 * 
 * @package NecoTienda
 * @author Inversiones Necoyoad, C.A.
 * @copyright 2010
 * @version $Id$
 * @access public
 */
class ModelMarketingNewsletter extends Model {
	/**
	 * ModelMarketingNewsletter::add()
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
      	$this->db->query("INSERT INTO " . DB_PREFIX . "newsletter SET ".
          "`name`        = '" . $this->db->escape($data['name']) . "',".
          "`textbody`    = '" . $this->db->escape($data['textbody']) . "',".
          "`htmlbody`    = '" . $this->db->escape($data['htmlbody']) . "',".
          "`date_added`  = NOW()");
        return $this->db->getLastId();
	}
	
	/**
	 * ModelMarketingNewsletter::update()
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
      	return $this->db->query("UPDATE " . DB_PREFIX . "newsletter SET ".
          "`name`        = '" . $this->db->escape($data['name']) . "',".
          "`textbody`    = '" . $this->db->escape($data['textbody']) . "',".
          "`htmlbody`    = '" . $this->db->escape($data['htmlbody']) . "',".
          "`date_modified`  = NOW() ".
          "WHERE `newsletter_id` = '".(int)$newsletter_id."'");
	}
    
    public function copy($newsletter_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "newsletter WHERE newsletter_id = '" . (int)$newsletter_id . "'");
		
		if ($query->num_rows) {
			$data = array();
			$data = $query->row;
			$data['name'] = $data['name'] ." - copia";
			$this->add($data);
		}
	}
    
    /**
     * ModelMarketingNewsletter::delete()
     * 
     * @return
     */
    public function delete($newsletter_id) {
        $shared_tables = array(
            'property',
            'description',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$country_id ." ".
                "AND object_type = 'newsletter'");
        }

		//TODO: validar que no tenga trabajos de envío pendientes, si es así mostrar una confirmación            
        $this->db->query("DELETE FROM " . DB_PREFIX . "newsletter WHERE `newsletter_id` = '".(int)$newsletter_id."'");
	}
    
    public function getById($id) {
        $result = $this->getAll(array(
            'newsletter_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.newsletters";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "newsletter t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.name',
                    't.date_added'
                );
            }
            $sql .= $this->buildSQLQuery($data, $sort_data);
            $query = $this->db->query($sql);
            $this->cache->set($cachedId, $query->rows);
            return $query->rows;
        } else {
            return $cached;
        }
    }

    public function getAllTotal($data=null) {
        $cache_prefix = "admin.newsletters.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "newsletter t ";
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

        $data['newsletter_id'] = !is_array($data['newsletter_id']) && !empty($data['newsletter_id']) ? array($data['newsletter_id']) : $data['newsletter_id'];
        $data['campaign_id'] = !is_array($data['campaign_id']) && !empty($data['campaign_id']) ? array($data['campaign_id']) : $data['campaign_id'];

        if (isset($data['newsletter_id']) && !empty($data['newsletter_id'])) {
            $criteria[] = " t.newsletter_id IN (" . implode(', ', $data['newsletter_id']) . ") ";
        }

        if (isset($data['campaign_id']) && !empty($data['campaign_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "campaign c ON (c.newsletter_id = t.newsletter_id) ";
            $criteria[] = " c.campaign_id IN (" . implode(', ', $data['campaign_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.newsletter_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'newsletter' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.newsletter_id";
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

    /**
     * ModelMarketingNewsletter::toggleStatus()
     * Alterna el status
     * @return integer status
     */
    public function toggleStatus($newsletter_id) {
        $result = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."newsletter WHERE newsletter_id = '" . (int)$newsletter_id . "'");
        $status = ($result->row['status']) ? 0 : 1;
		$this->db->query("UPDATE " . DB_PREFIX . "newsletter SET status = '". (int)$status ."' WHERE newsletter_id = '" . (int)$newsletter_id . "'");
        return $status;
	}
    
    /**
     * ModelMarketingNewsletter::activate()
     * activa el objeto
     * @return void
     */
    public function activate($newsletter_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "newsletter SET status = '1' WHERE newsletter_id = '" . (int)$newsletter_id . "'");
	}
    
    /**
     * ModelMarketingNewsletter::desactivate()
     * desactva el objeto
     * @return void
     */
    public function desactivate($newsletter_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "newsletter SET status = '0' WHERE newsletter_id = '" . (int)$newsletter_id . "'");
	}
        
    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('newsletter', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('newsletter', $id, $data);
    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('newsletter', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('newsletter', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('newsletter', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('newsletter', $id, $group);
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
