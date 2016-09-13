<?php
class ModelUserUser extends Model {
	public function add($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "user` SET 
        username = '" . $this->db->escape($data['username']) . "', 
        password = '" . $this->db->escape(md5($data['password'])) . "', 
        firstname = '" . $this->db->escape($data['firstname']) . "', 
        lastname = '" . $this->db->escape($data['lastname']) . "', 
        email = '" . $this->db->escape($data['email']) . "', 
        user_group_id = '" . (int)$data['user_group_id'] . "', 
        status = '" . (int)$data['status'] . "', 
        date_added = NOW()");
        
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
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET 
        username = '" . $this->db->escape($data['username']) . "', 
        firstname = '" . $this->db->escape($data['firstname']) . "', 
        lastname = '" . $this->db->escape($data['lastname']) . "', 
        email = '" . $this->db->escape($data['email']) . "', 
        user_group_id = '" . (int)$data['user_group_id'] . "', 
        status = '" . (int)$data['status'] . "' 
        WHERE user_id = '" . (int)$user_id . "'");

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
		$this->db->query("DELETE FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "user_to_store` WHERE user_id = '" . (int)$user_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "user_property` WHERE user_id = '" . (int)$user_id . "'");
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
	
	public function getById($user_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");
	
		return $query->row;
	}
	
	public function getAll($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "user` u 
        LEFT JOIN `" . DB_PREFIX . "user_group` ug ON (u.user_group_id = ug.user_group_id)";
		
        $criteria = array();
        
		if (!empty($data['filter_name'])) {
            $criteria[] = "LCASE(username) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_email'])) {
            $criteria[] = "LCASE(email) LIKE '%" . $this->db->escape(strtolower($data['filter_email'])) . "%'";
		}

		if (!empty($data['filter_group'])) {
            $criteria[] = "LCASE(ug.name) LIKE '%" . $this->db->escape(strtolower($data['filter_group'])) . "%'";
		}

        if ($criteria) {
            $sql .= " WHERE ". implode(" AND ", $criteria);
        }
    		
		$sort_data = array(
			'username',
			'status',
			'date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY username";	
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

	public function getAllTotal($data) {
      	$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user` u 
          LEFT JOIN `" . DB_PREFIX . "user_group` ug ON (u.user_group_id = ug.user_group_id)";
		
        $criteria = array();
        
		if (!empty($data['filter_name'])) {
            $criteria[] = "LCASE(username) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_email'])) {
            $criteria[] = "LCASE(email) LIKE '%" . $this->db->escape(strtolower($data['filter_email'])) . "%'";
		}

		if (!empty($data['filter_group'])) {
            $criteria[] = "LCASE(ug.name) LIKE '%" . $this->db->escape(strtolower($data['filter_group'])) . "%'";
		}

        if ($criteria) {
            $sql .= " WHERE ". implode(" AND ", $criteria);
        }
    		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getAllTotalByGroupId($user_group_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user` WHERE user_group_id = '" . (int)$user_group_id . "'");
		
		return $query->row['total'];
	}

	/**
	 * ModelUserUser::getProperty()
	 *
	 * Obtener una propiedad de la categoria
	 *
	 * @param int $id user_id
	 * @param varchar $group
	 * @param varchar $key
	 * @return mixed value of property
	 * */
	public function getProperty($id, $group, $key) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user_property 
        WHERE `user_id` = '" . (int) $id . "' 
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");

		return unserialize(str_replace("\'", "'", $query->row['value']));
	}

	/**
	 * ModelUserUser::setProperty()
	 *
	 * Asigna una propiedad de la categoria
	 *
	 * @param int $id user_id
	 * @param varchar $group
	 * @param varchar $key
	 * @param mixed $value
	 * @return void
	 * */
	public function setProperty($id, $group, $key, $value) {
		$this->deleteProperty($id, $group, $key);
		$this->db->query("INSERT INTO " . DB_PREFIX . "user_property SET
        `user_id`   = '" . (int) $id . "',
        `group`     = '" . $this->db->escape($group) . "',
        `key`       = '" . $this->db->escape($key) . "',
        `value`     = '" . $this->db->escape(str_replace("'", "\'", serialize($value))) . "'");
	}

	/**
	 * ModelUserUser::deleteProperty()
	 *
	 * Elimina una propiedad de la categoria
	 *
	 * @param int $id user_id
	 * @param varchar $group
	 * @param varchar $key
	 * @return void
	 * */
	public function deleteProperty($id, $group, $key) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "user_property 
        WHERE `user_id` = '" . (int) $id . "' 
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");
	}

	/**
	 * ModelUserUser::getAllProperties()
	 *
	 * Obtiene todas las propiedades de la categoria
	 *
	 * Si quiere obtener todos los grupos de propiedades
	 * utilice * como nombre del grupo, ejemplo:
	 *
	 * $properties = getAllProperties($user_id, '*');
	 *
	 * Sino coloque el nombre del grupo de las propiedades
	 *
	 * $properties = getAllProperties($user_id, 'NombreDelGrupo');
	 *
	 * @param int $id user_id
	 * @param varchar $group
	 * @return array all properties
	 * */
	public function getAllProperties($id, $group = '*') {
		if ($group == '*') {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user_property 
            WHERE `user_id` = '" . (int) $id . "'");
		} else {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user_property 
            WHERE `user_id` = '" . (int) $id . "' 
            AND `group` = '" . $this->db->escape($group) . "'");
		}

		return $query->rows;
	}

	/**
	 * ModelUserUser::setAllProperties()
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
	 * @param int $id user_id
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
	 * ModelUserUser::deleteAllProperties()
	 *
	 * Elimina todas las propiedades de la categoria
	 *
	 * Si quiere eliminar todos los grupos de propiedades
	 * utilice * como nombre del grupo, ejemplo:
	 *
	 * $properties = deleteAllProperties($user_id, '*');
	 *
	 * Sino coloque el nombre del grupo de las propiedades
	 *
	 * $properties = deleteAllProperties($user_id, 'NombreDelGrupo');
	 *
	 * @param int $id user_id
	 * @param varchar $group
	 * @param varchar $key
	 * @return void
	 * */
	public function deleteAllProperties($id, $group = '*') {
		if ($group == '*') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "user_property 
            WHERE `user_id` = '" . (int) $id . "'");
		} else {
			$this->db->query("DELETE FROM " . DB_PREFIX . "user_property 
            WHERE `user_id` = '" . (int) $id . "' 
            AND `group` = '" . $this->db->escape($group) . "'");
		}
	}

}
