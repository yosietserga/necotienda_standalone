<?php
abstract class Model {
	protected $registry;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
	   if ($this->registry->has($key)) {
	       return $this->registry->get($key);
	   } 
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

    public function __getDescriptions($object_type, $id, $language_id=null) {
        if ($object_type==null || empty($object_type) || !is_numeric($id) || empty($id)) {
            return null;
        }

        //TODO: validate params and expand WHERE query
        //TODO: check and update cache
        $sql = "";
        $criteria = $rows = array();
        $criteria[] = " `object_type` = '" . $this->db->escape($object_type) . "' ";
        $criteria[] = " `object_id` = '" . (int)$id . "' ";

        if (!is_null($language_id) && is_numeric($language_id) && !empty($language_id)) {
            $criteria[] = " `language_id` = '" . intval($language_id) . "' ";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "description ". $sql);

        foreach ($query->rows as $row) {
            $rows[$row['language_id']]['language_id'] = $row['language_id'];
            $rows[$row['language_id']]['title'] = $row['title'];
            $rows[$row['language_id']]['description'] = $row['description'];
            $rows[$row['language_id']]['seo_title'] = $row['seo_title'];
            $rows[$row['language_id']]['meta_keywords'] = $row['meta_keywords'];
            $rows[$row['language_id']]['meta_description'] = $row['meta_description'];
        }

        $keywords = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias ". $sql);

        foreach ($keywords->rows as $row) {
            $rows[$row['language_id']]['keyword'] = $row['keyword'];
        }

        return $rows;
    }

    public function __deleteDescriptions($object_type, $id, $language_id=null) {
        if ($object_type==null || empty($object_type) || !is_numeric($id) || empty($id)) {
            return null;
        }

        //TODO: validate params and expand WHERE query
        //TODO: check cascade delete
        //TODO: check and update cache
        $sql = "DELETE FROM " . DB_PREFIX . "description ";
        $criteria = $rows = array();
        $criteria[] = " `object_type` = '" . $this->db->escape($object_type) . "' ";
        $criteria[] = " `object_id` = '" . (int)$id . "' ";

        if (!is_null($language_id) && is_numeric($language_id) && !empty($language_id)) {
            $criteria[] = " `language_id` = '" . intval($language_id) . "' ";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ", $criteria);
        }
        $this->db->query($sql);
    }

    public function __setDescriptions($object_type, $id, $data) {
        if ($object_type==null || empty($object_type) || !is_numeric($id) || empty($id)) {
            return null;
        }

        //TODO: validate params and expand WHERE query
        //TODO: check and update cache
        foreach ($data as $language_id => $value) {
            $language_id = is_numeric($language_id) && !empty($language_id) ? $language_id : $value['language_id'];
            //$this->__deleteDescriptions($object_type, $id, $language_id);
            $query = $this->db->query("SELECT * FROM `". DB_PREFIX ."description` ".
                "WHERE `object_type` = '". $this->db->escape($object_type) ."' ".
                "AND `object_id`   = '". (int) $id ."' ".
                "AND `language_id` = '". (int) $language_id ."' ");

            if ($query->num_rows) {
                $sql = "UPDATE " . DB_PREFIX . "description SET ";
                $criteria = " WHERE `object_type` = '". $this->db->escape($object_type) ."' ".
                "AND `object_id`   = '". (int) $id ."' ".
                "AND `language_id` = '". (int) $language_id ."' ";
            } else {
                $sql = "INSERT INTO " . DB_PREFIX . "description SET ";
                $criteria = "";
            }

            $sql .= "`object_type` = '" . $this->db->escape($object_type) . "', ";
            $sql .= "`object_id`   = '" . (int) $id . "', ";
            $sql .= "`language_id` = '" . (int) $language_id . "', ";

            if (isset($value['title'])) $sql .= "`title` = '" . $this->db->escape($value['title']) . "', ";
            if (isset($value['description'])) $sql .= "`description` = '" . $this->db->escape($value['description']) . "', ";
            if (isset($value['seo_title'])) $sql .= "`seo_title` = '" . $this->db->escape($value['seo_title']) . "', ";
            if (isset($value['meta_description'])) $sql .= "`meta_description` = '" . $this->db->escape($value['meta_description']) . "', ";
            if (isset($value['meta_keywords'])) $sql .= "`meta_keywords` = '" . $this->db->escape($value['meta_keywords']) . "', ";
            if (isset($value['params'])) $sql .= "``    = '" . $this->db->escape(serialize($value['params'])) . "', ";

            $sql = rtrim(trim($sql), ',');
            $this->db->query($sql . $criteria);
        }
    }

    public function __getProperty($object_type, $id, $group=null, $key=null) {
        $rows = $this->__getProperties($object_type, $id, $group, $key);
        return $rows[0];
    }

    public function __getProperties($object_type, $id, $group=null, $key=null) {
        if ($object_type==null || empty($object_type) || !is_numeric($id) || empty($id)) {
            return null;
        }

        $sql = "SELECT * FROM " . DB_PREFIX . "property ";
        $criteria = $rows = array();
        $criteria[] = " `object_type` = '" . $this->db->escape($object_type) . "' ";
        $criteria[] = " `object_id` = '" . (int)$id . "' ";

        if (!is_null($group) && !empty($group) && $group != '*') {
            $criteria[] = " `group` = '" . $this->db->escape($group) . "' ";
        }

        if (!is_null($key) && !empty($key) && $key != '*') {
            $criteria[] = " `key` = '" . $this->db->escape($key) . "' ";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        $query = $this->db->query($sql);

        foreach ($query->rows as $row) {
            $rows[] = unserialize(str_replace("\'", "'", $row['value']));
        }

        return $rows;
    }

    public function __setProperty($object_type, $id, $group, $key, $value) {
        if (is_numeric($object_type)
            || empty($object_type)
            || empty($group)
            || empty($key)
            || !is_numeric($id)
            || empty($id))
        {
            return null;
        }

        $this->__deleteProperties($object_type, $id, $group, $key);
        $this->db->query("INSERT INTO " . DB_PREFIX . "property SET ".
            "`object_id`    = '" . (int) $id . "',".
            "`object_type`  = '" . $this->db->escape($object_type) . "',".
            "`group`        = '" . $this->db->escape($group) . "',".
            "`key`          = '" . $this->db->escape($key) . "',".
            "`value`        = '" . $this->db->escape(str_replace("'", "\'", serialize($value))) . "'");
    }

    public function __deleteProperties($object_type, $id, $group, $key) {
        if ($object_type==null || empty($object_type) || !is_numeric($id) || empty($id)) {
            return null;
        }
        
        $sql = "DELETE FROM " . DB_PREFIX . "property ";
        $criteria = $rows = array();
        $criteria[] = " `object_type` = '" . $this->db->escape($object_type) . "' ";
        $criteria[] = " `object_id` = '" . (int)$id . "' ";
        
        if (!is_null($group) && !empty($group) && $group != '*') {
            $criteria[] = " `group` = '" . $this->db->escape($group) . "' ";
        }
        
        if (!is_null($key) && !empty($key) && $key != '*') {
            $criteria[] = " `key` = '" . $this->db->escape($key) . "' ";
        }
        
        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }
        $this->db->query($sql);
    }

    public function __setAllProperties($id, $group, $data) {
        if (is_array($data) && !empty($data)) {
            $this->__deleteAllProperties($id, $group);
            foreach ($data as $key => $value) {
                $this->__setProperty($id, $group, $key, $value);
            }
        }
    }

    public function __activate($object_type, $id) {
        $this->db->query("UPDATE `".DB_PREFIX."$object_type` SET status = '1' WHERE `{$object_type}_id` = '" . (int)$id . "'");
    }

    public function __desactivate($object_type, $id) {
        $this->db->query("UPDATE `".DB_PREFIX."$object_type` SET status = '0' WHERE `{$object_type}_id` = '" . (int)$id . "'");
    }

    public function __toggleStatus($id, $object_type) {
        $result = $this->db->query("SELECT status FROM `".DB_PREFIX."$object_type` WHERE `{$object_type}_id` = '" . (int)$id . "'");
        $status = ($result->row['status']) ? 0 : 1;
        $this->db->query("UPDATE `" . DB_PREFIX . "$object_type` SET status = '". (int)$status ."' WHERE `{$object_type}_id` = '" . (int)$id . "'");
        return $status;
    }
}
