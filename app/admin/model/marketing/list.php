<?php 

class ModelMarketingList extends Model {

	public function add($data) {
	    $total_contacts = sizeof($data['contact_list']);
        $this->db->query("INSERT INTO " . DB_PREFIX . "contact_list SET ".
        "`name` = '" . $this->db->escape($data['name']) . "',".
        "`description` = '" . $this->db->escape($data['description']) . "',".
        "`total_contacts` = '" . (int)$total_contacts . "',".
        "`date_added` = NOW()");
        
        $id = $this->db->getLastId();
        
        foreach ($data['contact_list'] as $contact_id) {
            $this->addContact($id, $contact_id);
        }
        return $id;
	}
	
	public function update($contact_list_id,$data) {
	    $total_contacts = sizeof($data['contact_list']);
        $this->db->query("UPDATE " . DB_PREFIX . "contact_list SET 
        `name` = '" . $this->db->escape($data['name']) . "',
        `description` = '" . $this->db->escape($data['description']) . "',
        `total_contacts` = '" . (int)$total_contacts . "',
        `date_modified` = NOW()
        WHERE `contact_list_id` = ". (int)$contact_list_id);
        
        foreach ($data['contact_list'] as $contact_id) {
            $this->addContact($id, $contact_id);
        }
	}
    
    public function addContact($id,$contact_id) {
        $this->db->query("REPLACE INTO " . DB_PREFIX . "contact_to_list SET 
            `contact_id` = '" . (int)$contact_id . "',
            `contact_list_id` = '" . (int)$id . "',
            `date_added` = NOW()");
    }
    
    /**
     * ModelMarketingList::copy()
     * 
     * @param int $id
     * @see DB
     * @see Cache
     * @return void
     */
    public function copy($id) {     
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "contact_list WHERE contact_list_id = '" . (int)$id . "'");
        
        if ($query->num_rows) {
            $data = array();
            $data = $query->row;
            $data['contact_list'] = $this->getContacts(array($id));
            $data['name'] = $data['name'] ." - copia";
            $this->add($data);
        }
    }
    
    /**
     * ModelMarketingList::delete()
     * 
     * @param int $id
     * @see DB
     * @see Cache
     * @return void
     */
    public function delete($id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$country_id ." ".
                "AND object_type = 'contact_list'");
        }

       //TODO: verificar que no tenga ninguna cola de trabajo pendiente
        $this->db->query("DELETE FROM " . DB_PREFIX . "contact_list WHERE contact_list_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "contact_to_list WHERE contact_list_id = '" . (int)$id . "'");
    }
    
    public function getById($id){
        $result = $this->getAll(array(
            'contact_list_id'=>$id
        ));
        return $result[0];
    }
    
    public function getAll($data=null) {
        $cache_prefix = "admin.contacts";
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
            $sql = "SELECT *, (SELECT COUNT(*) FROM " . DB_PREFIX . "contact_to_list c2ll WHERE c2ll.contact_list_id = t.contact_list_id) AS total_contacts FROM " . DB_PREFIX . "contact_list t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.name',
                    't.email',
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
        $cache_prefix = "admin.contacts.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "contact_list t ";
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

        $data['contact_id'] = !is_array($data['contact_id']) && !empty($data['contact_id']) ? array($data['contact_id']) : $data['contact_id'];
        $data['contact_list_id'] = !is_array($data['contact_list_id']) && !empty($data['contact_list_id']) ? array($data['contact_list_id']) : $data['contact_list_id'];

        if (isset($data['contact_id']) || isset($data['contact_name']) || isset($data['contact_email'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "contact_to_list c2l ON (c2l.contact_list_id = t.contact_list_id) ";
        }

        if (isset($data['contact_name']) || isset($data['contact_email'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "contact co ON (c2l.contact_id = co.contact_id) ";
        }

        if (isset($data['contact_list_id']) && !empty($data['contact_list_id'])) {
            $criteria[] = " t.contact_list_id IN (" . implode(', ', $data['contact_list_id']) . ") ";
        }

        if (isset($data['contact_id']) && !empty($data['contact_id'])) {
            $criteria[] = " c2l.contact_id IN (" . implode(', ', $data['contact_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['contact_name']) && !empty($data['contact_name'])) {
            $criteria[] = " LCASE(co.`name`) LIKE '%" . $this->db->escape(strtolower($data['contact_name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['contact_email']) && !empty($data['contact_email'])) {
            $criteria[] = " LCASE(co.`email`) LIKE '%" . $this->db->escape(strtolower($data['contact_email'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.contact_list_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'contact_list' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.contact_list_id";
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

    public function getContacts($data) {
        if ($data) {
    		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "contact_to_list c2l ".
            "LEFT JOIN " . DB_PREFIX . "contact co ON (c2l.contact_id=co.contact_id) ".
            "WHERE c2l.contact_list_id IN (". implode(",",$data) .")";
    		$query = $this->db->query($sql);
    		
            foreach ($query->rows as $row) {
                $return[] = array(
                    "contact_id"=>$row['contact_id'],
                    "email"=>$row['email'],
                    "name"=>$row['name']
                );
            }
        }
		return $return;
	}	
   
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('contact_list', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('contact_list', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('contact_list', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('contact_list', $id, $group);
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
