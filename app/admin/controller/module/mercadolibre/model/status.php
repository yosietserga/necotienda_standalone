<?php

/**
 * ModelStatus
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelStatus extends Model {

    /**
     * ModelStatus::add()
     * 
     * @param mixed $data
     * @see DB
     * @see Cache
     * @return void 
     */
    public function add($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "crm_sale_opportunity_status SET 
        language_id = '". (int)$this->config->get('config_language_id') ."',
        name = '" . $this->db->escape($data['name']) . "', 
        properties = '" . serialize($data['properties']) . "', 
        date_added = NOW()");

        $id = $this->db->getLastId();

        $this->cache->delete('crm_sale_opportunity_status');
        return $id;
    }

    /**
     * ModelStatus::update()
     * 
     * @param int $id
     * @param mixed $data
     * @see DB
     * @see Cache
     * @return void 
     */
    public function update($id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "crm_sale_opportunity_status SET 
        language_id = '". (int)$this->config->get('config_language_id') ."',
        name = '" . $this->db->escape($data['name']) . "', 
        properties = '" . serialize($data['properties']) . "', 
        date_modified = NOW() 
        WHERE sale_status_id = '" . (int) $id . "'");
        $this->cache->delete('crm_sale_opportunity_status');
    }

    /**
     * ModelStatus::delete()
     * 
     * @param int $id
     * @see DB
     * @see Cache
     * @return void 
     */
    public function delete($id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "crm_sale_opportunity_status WHERE sale_status_id = '" . (int) $id . "'");
        $this->db->query("UPDATE " . DB_PREFIX . "crm_sale_opportunity SET sale_status_id = '0' WHERE sale_status_id = '" . (int) $id . "'");
        $this->cache->delete('crm_sale_opportunity_status');
    }
    
    /**
     * ModelStatus::getById()
     * 
     * @param int $id
     * @see DB
     * @see Cache
     * @return array sql record 
     */
    public function getById($id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "crm_sale_opportunity_status WHERE sale_status_id = '" . (int) $id . "'");

        return $query->row;
    }

    /**
     * ModelStatus::getAll()
     * 
     * @param mixed $data
     * @see DB
     * @see Cache
     * @return array sql records 
     */
    public function getAll($data = array()) {
        if ($data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "crm_sale_opportunity_status s";

            $implode = array();

            if ($data['filter_name']) {
                $implode[] = "LCASE(name) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
            }

            if ($data['filter_date_start'] && $data['filter_date_end']) {
                $implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s', strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s', strtotime($data['filter_date_end'])) . "'";
            } elseif ($data['filter_date_start']) {
                $implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s', strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
            }

            if ($implode) {
                $sql .= " WHERE " . implode(" AND ", $implode);
            }

            $sort_data = array(
                'name',
                'date_added',
                'sort_order'
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

                $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
            }

            $query = $this->db->query($sql);

            return $query->rows;
        } else {
            $cache_data = $this->cache->get('admin.crm_sale_opportunity_status.all');

            if (!$cache_data) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "crm_sale_opportunity_status ORDER BY sort_order");

                $cache_data = $query->rows;

                $this->cache->set('admin.crm_sale_opportunity_status.all', $cache_data);
            }

            return $cache_data;
        }
    }

    /**
     * ModelStatus::getAll()
     * 
     * @see DB
     * @return int Count sql records 
     */
    public function getAllTotal($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "crm_sale_opportunity_status s";

        $implode = array();

        if ($data['filter_name']) {
            $implode[] = "LCASE(name) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if ($data['filter_date_start'] && $data['filter_date_end']) {
            $implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s', strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s', strtotime($data['filter_date_end'])) . "'";
        } elseif ($data['filter_date_start']) {
            $implode[] = " date_added BETWEEN '" . date('Y-m-d h:i:s', strtotime($data['filter_date_start'])) . "' AND '" . date('Y-m-d h:i:s') . "'";
        }

        if ($implode) {
            $sql .= " WHERE " . implode(" AND ", $implode);
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    /**
     * ModelStatus::sort()
     * @param array $data
     * @see DB
     * @see Cache
     * @return void
     */
    public function sort($data) {
        if (!is_array($data))
            return false;
        $pos = 1;
        foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "crm_sale_opportunity_status SET sort_order = '" . (int) $pos . "' WHERE sale_status_id = '" . (int) $id . "'");
            $pos++;
        }
        return true;
    }

    /**
     * ModelStatus::getProperty()
     * 
     * Obtener una propiedad de la categoria
     * 
     * @param int $id sale_status_id
     * @param varchar $group
     * @param varchar $key
     * @return mixed value of property
     * */
    public function getProperty($id, $group, $key) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "crm_sale_opportunity_status_property 
        WHERE `sale_status_id` = '" . (int) $id . "' 
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");

        return unserialize(str_replace("\'", "'", $query->row['value']));
    }

    /**
     * ModelStatus::setProperty()
     * 
     * Asigna una propiedad de la categoria
     * 
     * @param int $id sale_status_id
     * @param varchar $group
     * @param varchar $key
     * @param mixed $value
     * @return void
     * */
    public function setProperty($id, $group, $key, $value) {
        $this->deleteProperty($id, $group, $key);
        $this->db->query("INSERT INTO " . DB_PREFIX . "crm_sale_opportunity_status_property SET
        `sale_status_id`   = '" . (int) $id . "',
        `group`     = '" . $this->db->escape($group) . "',
        `key`       = '" . $this->db->escape($key) . "',
        `value`     = '" . $this->db->escape(str_replace("'", "\'", serialize($value))) . "'");
    }

    /**
     * ModelStatus::deleteProperty()
     * 
     * Elimina una propiedad de la categoria
     * 
     * @param int $id sale_status_id
     * @param varchar $group
     * @param varchar $key
     * @return void
     * */
    public function deleteProperty($id, $group, $key) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "crm_sale_opportunity_status_property 
        WHERE `sale_status_id` = '" . (int) $id . "' 
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");
    }

    /**
     * ModelStatus::getAllProperties()
     * 
     * Obtiene todas las propiedades de la categoria
     * 
     * Si quiere obtener todos los grupos de propiedades
     * utilice * como nombre del grupo, ejemplo:
     * 
     * $properties = getAllProperties($id, '*');
     * 
     * Sino coloque el nombre del grupo de las propiedades
     * 
     * $properties = getAllProperties($id, 'NombreDelGrupo');
     * 
     * @param int $id sale_status_id
     * @param varchar $group
     * @return array all properties
     * */
    public function getAllProperties($id, $group = '*') {
        if ($group == '*') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "crm_sale_opportunity_status_property 
            WHERE `sale_status_id` = '" . (int) $id . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "crm_sale_opportunity_status_property 
            WHERE `sale_status_id` = '" . (int) $id . "' 
            AND `group` = '" . $this->db->escape($group) . "'");
        }

        return $query->rows;
    }

    /**
     * ModelStatus::setAllProperties()
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
     * @param int $id sale_status_id
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
     * ModelStatus::deleteAllProperties()
     * 
     * Elimina todas las propiedades de la categoria
     * 
     * Si quiere eliminar todos los grupos de propiedades
     * utilice * como nombre del grupo, ejemplo:
     * 
     * $properties = deleteAllProperties($id, '*');
     * 
     * Sino coloque el nombre del grupo de las propiedades
     * 
     * $properties = deleteAllProperties($id, 'NombreDelGrupo');
     * 
     * @param int $id sale_status_id
     * @param varchar $group
     * @param varchar $key
     * @return void
     * */
    public function deleteAllProperties($id, $group = '*') {
        if ($group == '*') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "crm_sale_opportunity_status_property 
            WHERE `sale_status_id` = '" . (int) $id . "'");
        } else {
            $this->db->query("DELETE FROM " . DB_PREFIX . "crm_sale_opportunity_status_property 
            WHERE `sale_status_id` = '" . (int) $id . "' 
            AND `group` = '" . $this->db->escape($group) . "'");
        }
    }
}
