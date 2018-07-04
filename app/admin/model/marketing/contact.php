<?php

class ModelMarketingContact extends Model {

	public function add($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "contact SET ".
          "name          = '" . $this->db->escape($data['name']) . "',".
          "email         = '" . $this->db->escape($data['email']) . "', ".
          "customer_id   = '" . (int)$data['customer_id'] . "',".
          "date_added    = NOW()");
          
        $contact_id = $this->db->getLastId();
       
        $this->setList($contact_id, $data['contact_list']);
       
        return $contact_id;
	}
	
	public function update($contact_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "contact SET ".
          "name          = '" . $this->db->escape($data['name']) . "',".
          "email         = '" . $this->db->escape($data['email']) . "', ".
          "customer_id   = '" . (int)$data['customer_id'] . "',".
          "date_modified = NOW() ".
        "WHERE contact_id = '" . (int)$contact_id . "'");
        
        $this->setList($contact_id, $data['contact_list']);
       
	}
	
	public function setList($contact_id, $lists) {
        $this->db->query("DELETE FROM ". DB_PREFIX ."contact_to_list WHERE contact_id = '". (int)$contact_id ."'");
        foreach ($lists as $id) {
            $this->db->query("INSERT INTO ". DB_PREFIX ."contact_to_list SET 
            contact_list_id = '". (int)$id ."',
            contact_id      = '". (int)$contact_id ."',
            date_added      = NOW()");
        }
	}

    public function delete($id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$country_id ." ".
                "AND object_type = 'contact'");
        }

        //TODO: verificar que no tiene tareas programadas como enviar campa�a u otros, alertar si tiene alguna tarea pendiente
        $this->db->query("DELETE FROM ".DB_PREFIX."contact WHERE contact_id = '". (int)$id ."'");
        $this->db->query("DELETE FROM ".DB_PREFIX."contact_to_list WHERE contact_id = '". (int)$id ."'");
    }

    public function getById($id) {
        $result = $this->getAll(array(
            'contact_id'=>$id
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
            $sql = "SELECT *, t.date_Added AS created, t.email AS mail FROM " . DB_PREFIX . "contact t ";

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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "contact t ";
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

        $sql .= "LEFT JOIN " . DB_PREFIX . "customer c ON (c.customer_id = t.customer_id) ";

        $data['contact_id'] = !is_array($data['contact_id']) && !empty($data['contact_id']) ? array($data['contact_id']) : $data['contact_id'];
        $data['contact_list_id'] = !is_array($data['contact_list_id']) && !empty($data['contact_list_id']) ? array($data['contact_list_id']) : $data['contact_list_id'];
        $data['customer_id'] = !is_array($data['customer_id']) && !empty($data['customer_id']) ? array($data['customer_id']) : $data['customer_id'];

        if (isset($data['export'])) {
        	$sql .= "LEFT JOIN " . DB_PREFIX . "address a ON (a.address_id = c.address_id) ";
        }

        if (isset($data['contact_list_id'])) {
        	$sql .= "LEFT JOIN " . DB_PREFIX . "contact_to_list c2l ON (t.contact_id=c2l.contact_id) ";
        }

        if (isset($data['contact_id']) && !empty($data['contact_id'])) {
            $criteria[] = " t.contact_id IN (" . implode(', ', $data['contact_id']) . ") ";
        }

        if (isset($data['contact_list_id']) && !empty($data['contact_list_id'])) {
            $criteria[] = " c2l.contact_list_id IN (" . implode(', ', $data['contact_list_id']) . ") ";
        }

        if (isset($data['customer_id']) && !empty($data['customer_id'])) {
            $criteria[] = " c.customer_id IN (" . implode(', ', $data['customer_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['email']) && !empty($data['email'])) {
            $criteria[] = " LCASE(t.`email`) LIKE '%" . $this->db->escape(strtolower($data['email'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['customer_email']) && !empty($data['customer_email'])) {
            $criteria[] = " LCASE(c.`email`) LIKE '%" . $this->db->escape(strtolower($data['customer_email'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['customer_name']) && !empty($data['customer_name'])) {
            $criteria[] = " LCASE(CONCAT(c.`firstname`, ' ', c.`lastname`)) LIKE '%" . $this->db->escape(strtolower($data['customer_name'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.contact_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'contact' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.contact_id";
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

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('contact', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('contact', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('contact', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('contact', $id, $group);
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
