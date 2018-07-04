<?php

class ModelUserUser extends Model {

	public function add($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "user` SET ".
        "username = '" . $this->db->escape($data['username']) . "', ".
        "password = '" . $this->db->escape(md5($data['password'])) . "', ".
        "firstname = '" . $this->db->escape($data['firstname']) . "', ".
        "lastname = '" . $this->db->escape($data['lastname']) . "', ".
        "email = '" . $this->db->escape($data['email']) . "', ".
        "user_group_id = '" . (int)$data['user_group_id'] . "', ".
        "status = '" . (int)$data['status'] . "', ".
        "date_added = NOW()");
        
        $user_id =  $this->db->getLastId();

		if (isset($data['image'])) {
			$this->setProperty($user_id, 'user', 'image', $data['image']);
		}

		if (!empty($data['stores'])) {
            foreach ($data['stores'] as $store) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "user_to_store SET 
                store_id  = '". intval($store['store_id']) ."', 
                user_id = '". intval($user_id) ."'");
            }
        }
        
        return $user_id;
	}
	
	public function update($user_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET ".
        "username = '" . $this->db->escape($data['username']) . "', ".
        "firstname = '" . $this->db->escape($data['firstname']) . "', ".
        "lastname = '" . $this->db->escape($data['lastname']) . "', ".
        "email = '" . $this->db->escape($data['email']) . "', ".
        "user_group_id = '" . (int)$data['user_group_id'] . "', ".
        "status = '" . (int)$data['status'] . "' ".
        "WHERE user_id = '" . (int)$user_id . "'");

		if (isset($data['image'])) {
			$this->setProperty($user_id, 'user', 'image', $data['image']);
		}

		if (!empty($data['stores'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "user_to_store WHERE user_id = '". (int)$user_id ."'");
            foreach ($data['stores'] as $store) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "user_to_store SET 
                store_id  = '". intval($store['store_id']) ."', 
                user_id = '". intval($user_id) ."'");
            }
        }
        
		if (!empty($data['password'])) {
			$this->db->query("UPDATE `" . DB_PREFIX . "user` SET password = '" . $this->db->escape(md5($data['password'])) . "' WHERE user_id = '" . (int)$user_id . "'");
		}
	}
	
	public function delete($user_id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$user_id ." ".
                "AND object_type = 'user'");
        }

		$this->db->query("DELETE FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "user_to_store` WHERE user_id = '" . (int)$user_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "user_activity` WHERE user_id = '" . (int)$user_id . "'");
	}
	
	public function getStores($id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user_to_store WHERE user_id = '" . (int)$id . "'");
		foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
		}
		return $data;
	}	
	
    public function getById($id) {
        $result = $this->getAll(array(
            'user_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.users";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "user t ";

            if (!isset($sort_data)) {
                $sort_data = array(
					'username',
					'email',
					'firstname',
					'lastname',
                    't.status',
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
        $cache_prefix = "admin.users.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user t ";
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

        $sql .= " LEFT JOIN `" . DB_PREFIX . "user_group` ug ON (t.user_group_id = ug.user_group_id) ";

        $data['user_id'] = !is_array($data['user_id']) && !empty($data['user_id']) ? array($data['user_id']) : $data['user_id'];
        $data['user_group_id'] = !is_array($data['user_group_id']) && !empty($data['user_group_id']) ? array($data['user_group_id']) : $data['user_group_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "user_to_store t2s ON (t.user_id = t2s.user_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['user_id']) && !empty($data['user_id'])) {
            $criteria[] = " t.user_id IN (" . implode(', ', $data['user_id']) . ") ";
        }

        if (isset($data['user_group_id']) && !empty($data['user_group_id'])) {
            $criteria[] = " t.user_group_id IN (" . implode(', ', $data['user_group_id']) . ") ";
        }

        if (isset($data['username']) && !empty($data['username'])) {
            $criteria[] = " LCASE(t.`username`) LIKE '%" . $this->db->escape(strtolower($data['username'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['email']) && !empty($data['email'])) {
            $criteria[] = " LCASE(t.`email`) LIKE '%" . $this->db->escape(strtolower($data['email'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(CONCAT(t.firstname, ' ', t.lastname)) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['user_group']) && !empty($data['user_group'])) {
            $criteria[] = " LCASE(ug.`name`) LIKE '%" . $this->db->escape(strtolower($data['user_group'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.user_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'user' ";
            }
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.user_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.username";
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
        return $this->__activate('user', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('user', $id);
    }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('user', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('user', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('user', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('user', $id, $group);
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
